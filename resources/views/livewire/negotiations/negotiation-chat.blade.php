<?php

	use App\Events\ConversationInvitation;
	use App\Events\InvitationSent;
	use App\Events\NewMessageEvent;
	use App\Events\ParticipantLeavesChatEvent;
	use App\Models\Conversation;
	use App\Models\ConversationParticipant;
	use App\Models\Invitation;
	use App\Models\Message;
	use App\Models\Room;
	use App\Models\TextMessage;
	use App\Models\User;
	use App\Services\ConversationService;
	use App\Services\VonageSmsService;
	use Illuminate\Support\Collection;
	use Livewire\Attributes\Validate;
	use Livewire\Volt\Component;
	use App\Services\MessageService;
	use Livewire\Attributes\On;
	use App\Services\InvitationService;
	use Symfony\Component\Mailer\Event\MessageEvent;


	new class extends Component {

		public Collection $conversations;
		public Conversation $defaultConversation;
		public array $activeUsers = [];

		#[Validate('string|required|min:3|max:255')]
		public string $newMessage = '';

		public Room $room;
		public string $sortBy = '';
		public User $user;
		public Collection $smsMessages;

		public function mount(Room $room):void
		{
			$this->room = $room;
			$this->user = auth()->user();
			$this->createGroupChats();
			$this->fetchConversations();
		}

		#[On('smsConversationCreated')]
		public function fetchConversations():void
		{
			$conversationService = new ConversationService;
			$this->conversations = $conversationService->fetchConversations($this->room->id, $this->room->tenant_id,
				$this->user->id)->load('participants.user');
			$this->resetToPublicConversation();
		}

		public function sendMessage($currentConversationId):void
		{
			$this->validate();
			$messageService = new MessageService;
			$message = $this->createMessage($currentConversationId);
			$messageService->broadcastMessage($message);
			$this->newMessage = '';

		}

		public function sendSMSMessage($conversationId):void
		{
			$messageService = new MessageService();
			$message = $this->createMessage($conversationId);

			$smsService = new VonageSmsService();
			$smsService->sendMessage($message, $this->room->subject);
			event(new NewMessageEvent($message));
			$this->newMessage = '';
		}

		private function createMessage($currentConversationId):Message
		{
			$messageService = new MessageService;
			return $messageService->createMessage($this->room, $this->user, $this->newMessage,
				$currentConversationId);
		}

		public function refreshChat():void
		{
			$this->room->load('messages');
			$this->dispatch('new-message');
		}

		public function getListeners():array
		{
			return [
				"echo-presence:chat.{$this->room->id},NewMessageEvent" => 'refreshChat',
				"echo-presence:chat-sms.{$this->room->id},NewTextEvent" => 'refreshChat',
				"echo-presence:chat.{$this->room->id},leaving" => 'handleUserLeaving',
				"echo-presence:chat.{$this->room->id},ParticipantLeavesChatEvent" => 'handleParticipantLeft',
				'echo-private:user.'.auth()->id().',InvitationAcceptedEvent' => 'fetchConversations',
			];
		}

		public function handleParticipantLeft($data):void
		{
			$this->fetchConversations();
		}

		public function showResponses($messageId):void
		{
			$this->dispatch('modal.open', component: 'modals.message-responses',
				arguments: ['messageId' => $messageId]);
		}

		public function resetToPublicConversation():void
		{
			// Find the "public" conversation in the $conversations collection
			$publicConversation = $this->conversations->firstWhere('name', 'public');

			if ($publicConversation) {
				// Set the explicitly found public conversation as default
				$this->defaultConversation = $publicConversation;
			} else {
				// Fallback to the first conversation in the collection if none is marked public
				$this->defaultConversation = $this->conversations->first();
			}
		}

		public function createGroupChats():void
		{
			$conversationService = new ConversationService;
			$defaultPublicConversation = [
				'type' => 'public',
				'name' => 'public',
				'room_id' => $this->room->id,
				'tenant_id' => $this->room->tenant_id,
				'initiator_id' => $this->user->id,
			];
			$this->defaultConversation = $conversationService->createGroupChat($defaultPublicConversation);
			$conversationService->addParticipantsToConversation($this->defaultConversation, User::all());
		}

		public function trackIdleUsers():void
		{
			$idleThreshold = now()->subMinutes(5);
			$this->activeUsers = collect($this->activeUsers)->map(function ($user) use ($idleThreshold) {
				return [
					...$user,
					'is_idle' => $user['last_active'] < $idleThreshold,
				];
			})->toArray();
		}

		public function leaveConversation(int $conversationId):void
		{
			$conversation = Conversation::findOrFail($conversationId);
			$conversation->update(['is_active' => false]);
			$this->fetchConversations();
			event(new ParticipantLeavesChatEvent($this->room->id));
		}

		public function sendUsersInvite(array $userIds):void
		{
			$invitationService = new InvitationService();
			foreach ($userIds as $userId) {
				$existingInvite = $invitationService->findExistingInvitation(auth()->id(), $userId);
				if ($existingInvite) {
					continue;
				}
				$conversationService = new ConversationService();
				$conversationService->sendInvitations(null, [$userId], $this->user->id);

				session()->flash('user_message_'.$userId, "Invitation sent to User ID: $userId");
			}
		}
	}
?>

<div
		x-data="{ conversation: '{{ $defaultConversation->name ?? '' }}' }"
		class="bg-white dark:bg-gray-800 dark-light-text shadow-lg rounded-b-lg rounded-t-lg">

	{{--	Conversation Tabs as Buttons--}}
	<div class="flex items-center justify-between space-x-4 p-4 border-b dark:border-gray-700">
		<div>
			@foreach ($conversations as $conversation)
				@if($conversation->type === 'public')
					<button
							@click="conversation = '{{ $conversation->name }}'"
							class="rounded-md px-3 py-2 text-sm font-medium text-indigo-700"
							:class="{ 'bg-indigo-100': conversation === '{{ $conversation->name }}' }">
						{{ ucfirst($conversation->name) }}
					</button>
				@elseif($conversation->type === 'private')
					<button
							@click="conversation = '{{ $conversation->name }}'"
							class="rounded-md px-3 py-2 text-sm font-medium text-indigo-700"
							:class="{ 'bg-indigo-100': conversation === '{{ $conversation->name }}' }">
						{{ ucfirst($conversation->getOtherParticipantName()) }}
					</button>
				@elseif($conversation->type === 'sms')
					<button
							@click="conversation = '{{ $conversation->name }}'"
							class="rounded-md px-3 py-2 text-sm font-medium text-indigo-700"
							:class="{ 'bg-indigo-100': conversation === '{{ $conversation->name }}' }">
						{{ $conversation->name }}
					</button>
				@else
					<button
							@click="conversation = '{{ $conversation->name }}'"
							class="rounded-md px-3 py-2 text-sm font-medium text-indigo-700"
							:class="{ 'bg-indigo-100': conversation === '{{ $conversation->name }}' }">
						{{ ucfirst($conversation->getOtherParticipantName()) }}
						<span class="text-gray-500 text-xs">
                        (+ {{ $conversation->getOtherParticipantCount() }})
                    </span>
					</button>
				@endif
			@endforeach
		</div>
		<div
				x-data="{ open: false, submenu: false }"
				class="relative space-x-2">
			<!-- Main Dropdown Trigger -->
			<livewire:notifications.chat-notifications :roomId="$this->room->id" />
			<button
					@click="open = !open">
				<x-heroicons::micro.solid.plus class="w-5 h-5 text-gray-400 dark:text-gray-300" />
			</button>
			<!-- Main Dropdown Content -->

			<div
					x-show="open"
					@click.away="open = false"
					class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ltr:origin-top-right rtl:origin-top-left end-0 ring-1 ring-black ring-opacity-5">
				<livewire:dropdowns.sub-menu
						:active-users="$activeUsers"
						:room="$room"
						button-label="New Conversation" />

				<livewire:dropdowns.sub-menu
						:active-users="$activeUsers"
						:room="$room"
						button-label="New Group Chat" />
			</div>
		</div>

	</div>

	{{--	Conversation Content Section--}}
	<div class="p-4">
		@foreach ($conversations as $conversation)
			<div
					x-show="conversation === '{{ $conversation->name }}'"
					wire:key="conversation-{{ $conversation->id }}">

				{{-- Message List --}}
				@if($conversation->type === 'public')
					<h3 class="font-bold text-lg mb-3">
						Conversation: {{ ucfirst($conversation->name) }}</h3>
				@elseif($conversation->type === 'group')
					<div class="flex items-center justify-between space-x-4">
						<div>
							<h3 class="font-bold text-lg mb-3">
								Conversation: {{ ucfirst($conversation->name) }}</h3>
						</div>
						<div class="mb-3">
							<button
									wire:click="leaveConversation({{ $conversation->id }})"
									type="button"
									class="text-xs text-gray-500 hover:text-gray-600 flex items-center gap-1 font-semibold">
								<span>Leave</span>
								<x-heroicons::micro.solid.arrow-right class="w-3 h-3" />
							</button>
						</div>
					</div>
				@elseif($conversation->type === 'sms')
					<div class="flex items-center justify-between space-x-4">
						<div>
							<h3 class="font-bold text-lg mb-3">
								Conversation: {{ $this->room->subject->name }}</h3>
						</div>
						<div class="mb-3">
							<button
									wire:click="leaveConversation({{ $conversation->id }})"
									type="button"
									class="text-xs text-gray-500 hover:text-gray-600 flex items-center gap-1 font-semibold">
								<span>Leave</span>
								<x-heroicons::micro.solid.arrow-right class="w-3 h-3" />
							</button>
						</div>
					</div>
				@else
					<div class="flex items-center justify-between space-x-4">
						<div>
							<h3 class="font-bold text-lg mb-3">
								Conversation To: {{ ucfirst($conversation->getOtherParticipantName()) }}</h3>
						</div>
						<div class="mb-3">
							<button
									wire:click="leaveConversation({{ $conversation->id }})"
									type="button"
									class="text-xs text-gray-500 hover:text-gray-600 flex items-center gap-1 font-semibold">
								<span>Leave</span>
								<x-heroicons::micro.solid.arrow-right class="w-3 h-3" />
							</button>
						</div>
					</div>
				@endif
				<div
						id="messages-container"
						class="flex flex-col overflow-y-auto {{ auth()->user()->cannot('createMessage', $conversation) ? 'h-[46rem]' : 'h-[35rem]' }} bg-gray-100 dark:bg-gray-600 rounded-lg p-4">
					<div class="space-y-4">
						@can('view', $conversation)
							@foreach ($conversation->messages as $message)
								@php
									$isOwnMessage = auth()->id() === $message->user_id;
								@endphp
								<div class="flex items-start {{ $isOwnMessage ? '' : 'ml-8' }} gap-2.5">
									@if($message->senderable_type === 'App\Models\User')
										<img
												class="w-8 h-8 rounded-full"
												src="{{ $message->senderable->avatarUrl() }}"
												alt="User Avatar">
									@else
										<x-avatar />
										@php
											$image = $message->senderable->images()->first()->image;
										@endphp
										<img
												src="{{ $message->senderable->imageUrl($image) }}"
												class="w-24 h-24 rounded"
												alt="Subject Image">
									@endif

									<div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 {{ $isOwnMessage ? 'bg-slate-200' : 'bg-white' }} rounded-e-xl rounded-es-xl dark:bg-gray-700">
										<div class="flex items-center space-x-2 rtl:space-x-reverse">
											<span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $message->senderable->name }}</span>
											<span class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
										</div>
										<p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">{{ $message->message }}</p>
										<span class="text-xs font-normal text-gray-500 dark:text-gray-400">Delivered</span>
									</div>
									<div>
										<x-dropdown.dropdown>
											<x-slot:trigger>
												<button
														type="button"
														class="bg-white rounded p-0.5">
													<x-heroicons::solid.ellipsis-vertical class="w-5 h-5 text-gray-400 dark:text-gray-300" />
												</button>
											</x-slot:trigger>
											<x-slot:content>
												<x-dropdown.dropdown-button value="Reply" />
												<x-dropdown.dropdown-button value="Like" />
											</x-slot:content>
										</x-dropdown.dropdown>
									</div>
								</div>
							@endforeach
						@endcan
					</div>
				</div>

				{{-- Message Input (if allowed to send messages) --}}
				@can('createMessage', $conversation)
					<div class="bg-gray-100 dark:bg-gray-600 rounded-lg p-4 mt-4">
						@if($conversation->type === 'sms')
							<form wire:submit.prevent="sendSMSMessage({{ $conversation->id }})">
                            <textarea
		                            wire:model.defer="newMessage"
		                            class="w-full p-2 rounded-lg border-gray-300"
		                            rows="3"
		                            placeholder="Type your message here..."></textarea>
								<button
										type="submit"
										class="px-4 py-2 mt-2 text-white bg-blue-500 rounded-lg">
									Send Message
								</button>
							</form>
						@else
							<form wire:submit.prevent="sendMessage({{ $conversation->id }})">
                            <textarea
		                            wire:model.defer="newMessage"
		                            class="w-full p-2 rounded-lg border-gray-300"
		                            rows="3"
		                            placeholder="Type your message here..."></textarea>
								<button
										type="submit"
										class="px-4 py-2 mt-2 text-white bg-blue-500 rounded-lg">
									Send Message
								</button>
							</form>
						@endif
					</div>
				@endcan
			</div>
		@endforeach
	</div>
</div>

@script
<script>
	$wire.on('new-message', () => {
		let chatWindow = document.getElementById('messages-container')
		chatWindow.scrollTop = chatWindow.scrollHeight - 5
	})
</script>
@endscript