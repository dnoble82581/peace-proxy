<?php

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
	use App\Notifications\FlashMessageNotification;
	use App\Services\Conversations\ConversationCreationService;
	use App\Services\Conversations\ConversationFetchingService;
	use App\Services\Conversations\ParticipantService;
	use App\Services\VonageSmsService;
	use Carbon\Carbon;
	use Illuminate\Support\Collection;
	use Livewire\Attributes\Validate;
	use Livewire\Volt\Component;
	use App\Services\MessageService;
	use Livewire\Attributes\On;
	use Symfony\Component\Mailer\Event\MessageEvent;


	new class extends Component {

		public Collection $conversations;

		#[Validate('string|required|min:3|max:255')]
		public string $newMessage = '';

		public Room $room;
		public Collection $smsMessages;
		public array $activeUsers = [];
		public array $participants = [];
		public User $user;
		public Conversation $defaultConversation;
		public bool $flashMessage = false;

		public function getListeners():array
		{
			return [
				"echo-presence:chat.{$this->room->id},NewMessageEvent" => 'refreshMessages',
				"echo-private:user.{$this->user->id},ConversationEvent" => 'refreshConversations',
			];
		}

		public function mount(Room $room):void
		{
			$this->user = auth()->user();
			$this->room = $room;
			$this->checkForPublicConversation();
			$this->ensureUserInPublicConversation($this->user);
			$this->conversations = $this->fetchUserRoomConversations();
		}

		public function refreshMessages():void
		{
			$this->fetchUserRoomConversations();
		}

		public function sendMessage($conversation):void
		{
			$this->validate([
				'newMessage' => 'required | min:1 | max:255',
			]);
			$data = $this->fetchMessageData($conversation);
			$messageService = new MessageService();
			$newMessage = $messageService->createMessage($data);
			$this->newMessage = '';
			event(new NewMessageEvent($newMessage));
		}

		public function refreshConversations():void
		{
			$this->conversations = $this->fetchUserRoomConversations();
		}

		public function fetchOtherParticipantName(Conversation $conversation)
		{
			$participantService = new ParticipantService();
			return $participantService->fetchOtherParticipantName($conversation, $this->user);
		}

		public function getUserAvatar($id):string
		{
			return User::findOrFail($id)->avatarUrl();
		}


		private function fetchDefaultConversation():Conversation
		{
//			$conversationFetchingService = new ConversationFetchingService();
//			$defaultConversation = $conversationFetchingService->fetchDefaultConversation($this->room);

			$this->checkForPublicConversation();

		}

		private function checkForPublicConversation():void
		{
			$publicConversation = Conversation::where('type', 'public')
				->where('tenant_id', $this->user->tenant_id)
				->exists();

			if (!$publicConversation)
				$this->defaultConversation = $this->createDefaultConversation();

			$this->defaultConversation = $this->fetchDefaultConversation();
		}

		private function ensureUserInPublicConversation(User $user):void
		{
			// Step 1: Fetch the public conversation
			$publicConversation = $this->fetchDefaultConversation();

			// Step 2: Check if the user is already a participant
			$isParticipant = ConversationParticipant::where('conversation_id', $publicConversation->id)
				->where('user_id', $user->id)
				->exists();

			// Step 3: Add the user if not found in the participants
			if (!$isParticipant) {
				ConversationParticipant::create([
					'conversation_id' => $publicConversation->id,
					'user_id' => $user->id,
					'tenant_id' => $user->tenant_id,
					'joined_at' => now(),
					'status' => 'accepted'
				]);
			}
		}


		private function createDefaultConversation():Conversation
		{

			$data = [
				'type' => 'public',
				'name' => 'Public',
				'token' => (string) Str::uuid(),
				'room_id' => $this->room->id,
				'tenant_id' => $this->user->tenant_id
			];

			$conversationCreationService = app(ConversationCreationService::class);
			return $conversationCreationService->createPublicChat(
				$data,
				User::all()->pluck('id')->toArray());
		}

		private function fetchMessageData($conversation):array
		{
			return [
				'tenant_id' => $this->room->tenant_id,
				'negotiation_id' => $this->room->negotiation_id,
				'room_id' => $this->room->id,
				'conversation_id' => $conversation,
				'message_status' => 'sent',
				'message_type' => 'chat',
				'senderable_type' => 'App / Models / User',
				'senderable_id' => $this->user->id,
				'message' => $this->newMessage,
				'sent_at' => now(),
				'created_at' => now(),
				'updated_at' => now()
			];
		}

		private function fetchUserRoomConversations()
		{
			$fetchingService = new ConversationFetchingService();
			return
				$fetchingService->fetchUserRoomConversations($this->user, $this->room);
		}

	}
?>
<div
		class="flex-1 p:2 sm:p-2 justify-between flex flex-col bg-white dark:bg-gray-800 shadow-lg rounded-lg">
	<div class="flex sm:items-center justify-between py-2">
		<div>
			<img
					src="{{ auth()->user()->avatarUrl() }}"
					class="w-10 h-10 rounded-full object-cover"
					alt="User Avatar">
		</div>

		<livewire:notifications.flash-notification :user="$user" />
		{{--		Put Notification here--}}
		<div class="flex items-center space-x-2">
			<button
					type="button"
					class="inline-flex items-center justify-center rounded-lg transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
				<x-heroicons::micro.solid.magnifying-glass class="h-5 w-5 mb-1" />
			</button>
			<div class="relative">
				<livewire:notifications.chat-notifications :roomId="$room->id" />
			</div>

			<div
					class="relative"
					x-data="{open: false, submenu: false}">
				<button
						type="button"
						@click="open = !open"
						class="inline-flex items-center justify-center rounded-lg transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
					<x-heroicons::outline.plus class="h-5 w-5" />
				</button>
				<div
						x-show="open"
						@click.away="open = false"
						class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-700 ltr:origin-top-right rtl:origin-top-left end-0">

					<livewire:dropdowns.sub-menu
							:room="$room"
							button-label="New Private Chat" />

					<livewire:dropdowns.sub-menu
							:room="$room"
							button-label="New Group Chat" />
				</div>
			</div>
		</div>
	</div>
	<div class="flex sm:items-center justify-between py-2 border-b-2 border-gray-200">
		<div class="grid grid-cols-1 sm:hidden">
			<!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
			<select
					aria-label="Select a tab"
					class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
				<option>My Account</option>
				<option>Company</option>
				<option selected>Team Members</option>
				<option>Billing</option>
			</select>
			<svg
					class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end fill-gray-500"
					viewBox="0 0 16 16"
					fill="currentColor"
					aria-hidden="true"
					data-slot="icon">
				<path
						fill-rule="evenodd"
						d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
						clip-rule="evenodd" />
			</svg>
		</div>
	</div>
	<div x-data="{ conversation: {{ $defaultConversation->id }}}">
		<!-- Tabs Section -->
		<div class="hidden sm:block">
			<div class="border-b border-gray-200">
				<nav
						class="-mb-px flex space-x-1"
						aria-label="Tabs">
					@foreach($this->conversations as $conversation)
						@if($conversation->type === 'public')
							<!-- Public Tab -->
							<button
									type="button"
									@click="conversation = {{ $conversation->id}}"
									class="group inline-flex items-center border-b-2 border-transparent px-4 py-4 text-xs font-medium dark-light-text hover:border-gray-300 hover:text-gray-700"
									:class="{ 'border-b-indigo-600 dark:broder-b-gray-700 text-indigo-500 hover:border-indigo-500 hover:text-indigo-600 bg-indigo-50 dark:bg-gray-700': conversation === {{ $conversation->id}} }">
								<x-heroicons::outline.chat-bubble-left-right class="w-4 h-4 mr-2" />
								<span>{{ $conversation->name }}</span>
							</button>
						@elseif($conversation->type === 'private')
							<!-- Private Tab -->
							<button
									type="button"
									@click="conversation = {{ $conversation->id}}"
									class="group inline-flex items-center border-b-2 border-transparent px-4 py-4 text-xs font-medium dark-light-text hover:border-gray-300 hover:text-gray-700"
									:class="{ 'border-b-indigo-600 dark:broder-gray-700 text-indigo-500 hover:border-indigo-500 hover:text-indigo-600 bg-indigo-50 dark:bg-gray-700': conversation === {{ $conversation->id }} }">
								<x-heroicons::outline.chat-bubble-bottom-center-text class="w-4 h-4 mr-2" />
								<span>{{ $this->fetchOtherParticipantName($conversation) }}</span>
							</button>
						@elseif($conversation->type === 'group')
							<!-- Private Tab -->
							<button
									type="button"
									@click="conversation = {{ $conversation->id}}"
									class="group inline-flex items-center border-b-2 border-transparent px-4 py-4 text-xs font-medium dark-light-text hover:border-gray-300 hover:text-gray-700"
									:class="{ 'border-b-indigo-600 dark:broder-b-gray-700 text-indigo-500 hover:border-indigo-500 hover:text-indigo-600 bg-indigo-50 dark:bg-gray-700': conversation === {{ $conversation->id }} }">
								<x-heroicons::outline.chat-bubble-left-right class="w-4 h-4 mr-2" />
								<span>Group</span>
							</button>
						@endif
					@endforeach
				</nav>
			</div>
		</div>
		<div
				id="messages"
				class="space-y-4 bg-gray-100 dark:bg-gray-700 p-3 min-h-[45rem] overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch soft-scrollbar">
			@foreach($this->conversations as $conversation)
				@if($conversation->type === 'public')
					<!-- Public Messages -->
					<div
							x-show="conversation === {{ $conversation->id}}"
							wire:key="conversation-{{ $conversation->id }}">
						@foreach($conversation->messages as $message)
							<div class="chat-message mt-1">
								@if($message->senderable_type === 'App / Models / User' && $message->senderable_id === $this->user->id)
									<x-chat-elements.sent-message
											:message="$message->message"
											:user-avatar-url="$this->user->avatarUrl()" />
								@else
									<x-chat-elements.recieved-message
											:message="$message->message"
											:user-avatar-url="$this->getUserAvatar($message->senderable_id)" />
								@endif
							</div>
						@endforeach
					</div>
				@elseif($conversation->type === 'private')
					<!-- Private Messages -->
					<div
							x-show="conversation === {{ $conversation->id}}"
							wire:key="conversation-{{ $conversation->id }}">
						@foreach($conversation->messages as $message)
							<div class="chat-message mt-1">
								@if($message->senderable_type === 'App / Models / User' && $message->senderable_id === $this->user->id)
									<x-chat-elements.sent-message
											:message="$message->message"
											:user-avatar-url="$this->user->avatarUrl()" />
								@else
									<x-chat-elements.recieved-message
											:message="$message->message"
											:user-avatar-url="$this->getUserAvatar($message->senderable_id)" />
								@endif
							</div>
						@endforeach
					</div>
				@elseif($conversation->type === 'group')
					<!-- Private Messages -->
					<div
							x-show="conversation === {{ $conversation->id}}"
							wire:key="conversation-{{ $conversation->id }}">
						@foreach($conversation->messages as $message)
							<div class="chat-message mt-1">
								@if($message->senderable_type === 'App / Models / User' && $message->senderable_id === $this->user->id)
									<x-chat-elements.sent-message
											:message="$message->message"
											:user-avatar-url="$this->user->avatarUrl()" />
								@else
									<x-chat-elements.recieved-message
											:message="$message->message"
											:user-avatar-url="$this->getUserAvatar($message->senderable_id)" />
								@endif
							</div>
						@endforeach
					</div>
				@endif
			@endforeach
		</div>
		<div class="border-t-2 border-gray-200 dark:bg-gray-600 px-4 pt-4 mb-2 sm:mb-0">
			<div class="flex w-full gap-2">
				<x-textarea
						wire:model="newMessage"
						placeholder="Write your message"
						rows="1" />

				<button
						@click="$wire.sendMessage(conversation)"
						type="button"
						class="rounded-lg px-4 py-2 transition duration-500 ease-in-out text-indigo-500 hover:text-indigo-600m bg-gray-100 focus:outline-none">
					<x-heroicons::outline.paper-airplane class="h-6 w-6" />
				</button>
			</div>
		</div>
	</div>
</div>
<script>
	const el = document.getElementById('messages')
	el.scrollTop = el.scrollHeight
</script>