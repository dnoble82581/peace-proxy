<?php

	use App\Events\NewMessageEvent;
	use App\Models\Conversation;
	use App\Models\ConversationParticipant;
	use App\Models\Message;
	use App\Models\Room;
	use App\Models\User;
	use App\Services\ConversationService;
	use Illuminate\Support\Collection;
	use Livewire\Attributes\Validate;
	use Livewire\Volt\Component;
	use App\Services\MessageService;


	/**
	 * ChatRoom Component
	 *
	 * This Livewire component manages a chat room. It handles:
	 * - Sending messages
	 * - Broadcasting messages
	 * - Listening to events (e.g., user presence)
	 * - Displaying a chat interface
	 */
	new class extends Component {

		public Collection $conversations;
		public Conversation $defaultConversation;
		public array $activeUsers = [];
//		public MessageService $messageService;


		/**
		 * Stores the message being written by the user
		 *
		 * @var string
		 */
		#[Validate('string|required|min:3|max:255')]
		public string $newMessage = '';


		/**
		 * Instance of the chat room.
		 *
		 * @var Room
		 */
		public Room $room;
		public string $sortBy = '';

		/**
		 * The authenticated user.
		 *
		 * @var User
		 */
		public User $user;

		/**
		 * Mount the component.
		 *
		 * Called when the component is initialized.
		 * Sets the current room and user.
		 *
		 * @param  Room  $room  The chat room instance.
		 *
		 * @return void
		 */
		public function mount(Room $room):void
		{
			$this->room = $room;
			$this->user = auth()->user();
			$this->createGroupChats();

			$this->fetchConversations();
		}

		public function fetchConversations():void
		{
			$this->conversations = Conversation::where('room_id', $this->room->id)
				->where('tenant_id', $this->room->tenant_id)
				->get();
			$this->defaultConversation = $this->conversations->first();
		}


		/**
		 * Sends a new message to the chat room.
		 *
		 * Validates the input message, creates the new message,
		 * broadcasts it, and resets the message input field.
		 *
		 * @param $currentConversationId
		 *
		 * @return void
		 */
		public function sendMessage($currentConversationId):void
		{
			$this->validate();
			$messageService = new MessageService;
			$message = $this->createMessage($currentConversationId);
			$messageService->broadcastMessage($message);
			$this->newMessage = '';

		}

		/**
		 * Creates a new message in the database.
		 *
		 * @return Message The newly created message instance.
		 */
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

		/**
		 * Define the event listeners for the chat room.
		 *
		 * Listeners include:
		 * - "NewMessageEvent" for updating the chat UI with new messages.
		 * - "here" for handling user presence.
		 *
		 * @return array An array of event listeners.
		 */
		public function getListeners():array
		{
			return [
				"echo-presence:chat.{$this->room->id},NewMessageEvent" => 'refreshChat',
				"echo-presence:chat.{$this->room->id},here" => 'handleUserHere',
			];
		}

		public function showResponses($messageId):void
		{
			$this->dispatch('modal.open', component: 'modals.message-responses',
				arguments: ['messageId' => $messageId]);
		}

		public function createGroupChats():void
		{
			$conversationService = new ConversationService;
			$defaultPublicConversation = [
				'type' => 'public', // Unique type
				'room_id' => $this->room->id,
				'tenant_id' => $this->room->tenant_id,
				'initiator_id' => $this->user->id,
			];
			$publicConversation = $conversationService->createGroupChat($defaultPublicConversation);
			$conversationService->addParticipantsToConversation($publicConversation, User::all());

		}


		/**
		 * Handles the presence of a user in the chat room.
		 *
		 * Implementation should be defined for displaying or reacting
		 * to users who are currently in the chat room.
		 *
		 * @param $users
		 *
		 * @return void
		 */
		public function handleUserHere($users):void
		{
			$this->activeUsers = collect($users)->map(function ($user) {
				return [
					'id' => $user['id'],
					'name' => $user['name'],
					'avatar' => $user['avatar'],
					'last_active' => now(), // Initialize the user's activity timestamp
				];
			})->toArray();

		}

		/**
		 * Handles when a user joins the chat room.
		 *
		 * Implementation should be defined for actions to take when
		 * a user joins the chat room.
		 *
		 * @param  mixed  $user  The user who joined the chat room.
		 *
		 * @return void
		 */
		public function handleUserJoining($user):void
		{
			$newUser = [
				'id' => $user['id'],
				'name' => $user['name'],
				'avatar' => $user['avatar'],
				'last_active' => now() // Record the current timestamp
			];

			// Avoid duplicating users in the array
			$this->activeUsers[] = $newUser;
		}


		/**
		 * Handles when a user leaves the chat room.
		 *
		 * Implementation should be defined for actions to take when
		 * a user leaves the chat room.
		 *
		 * @param  mixed  $user  The user who left the chat room.
		 *
		 * @return void
		 */
		public function handleUserLeaving($user):void
		{
			$this->activeUsers = collect($this->activeUsers)
				->where('id', '!=', $user['id']) // Remove the user who left
				->toArray();
		}

		public function trackIdleUsers():void
		{
			$idleThreshold = now()->subMinutes(5); // Define idle time (e.g., 5 minutes)

			$this->activeUsers = collect($this->activeUsers)->map(function ($user) use ($idleThreshold) {
				return [
					...$user,
					'is_idle' => $user['last_active'] < $idleThreshold, // Mark the user as idle if past the threshold
				];
			})->toArray();
		}

		public function createConversation($userId)
		{
			$user = User::findOrFail($userId);

			$privateConversation = Conversation::firstOrCreate(
				[
					'type' => $user->name, // Unique type
					'room_id' => $this->room->id,
					'tenant_id' => $this->room->tenant_id,
				],
				[
					'initiator_id' => auth()->user()->id,
					'created_at' => now(),
					'updated_at' => now(),
				]);
		}


	}
?>

<div
		x-data="{ conversation: '{{ $conversations->isNotEmpty() ? $conversations->first()->type : '' }}' }"
		class="bg-white dark:bg-gray-800 shadow-lg rounded-b-lg rounded-t-lg">

	{{--	Conversation Tabs as Buttons--}}
	<div class="flex items-center justify-between space-x-4 p-4 border-b dark:border-gray-700">
		<div>
			@foreach ($conversations as $conversation)
				<button
						@click="conversation = '{{ $conversation->type }}'"
						class="rounded-md px-3 py-2 text-sm font-medium text-indigo-700"
						:class="{ 'bg-indigo-100': conversation === '{{ $conversation->type }}' }">
					{{ ucfirst($conversation->type) }}
				</button>
			@endforeach
		</div>
		<div
				x-data="{ open: false, submenu: false }"
				class="relative">
			<!-- Main Dropdown Trigger -->
			<button
					@click="open = !open">
				<x-heroicons::micro.solid.plus class="w-5 h-5 text-gray-400 dark:text-gray-300" />
			</button>

			<!-- Main Dropdown Content -->
			<div
					x-show="open"
					@click.away="open = false"
					class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ltr:origin-top-right rtl:origin-top-left end-0 ring-1 ring-black ring-opacity-5"
			>
				<!-- Dropdown Option 2 with Submenu -->
				<div
						class="relative"
						x-data="{ submenu: false }">
					<x-dropdown.dropdown-button
							@click="submenu = !submenu"
							class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
						New Conversation
					</x-dropdown.dropdown-button>

					<!-- Submenu Dropdown -->
					<div
							x-show="submenu"
							class="absolute left-full ml-3 top-0 w-56 bg-white rounded shadow-lg ring-1 ring-black ring-opacity-5"
							@click.away="submenu = false"
					>
						@foreach($activeUsers as $user)
							<x-dropdown.dropdown-button
									wire:click="createConversation({{ $user['id'] }})"
									class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
								<div class="flex items-center space-x-2 rtl:space-x-reverse">
									<img
											class="w-8 h-8 rounded-full"
											src="{{ $user['avatar'] }}"
											alt="User Avatar">
									<span>{{ $user['name'] }}</span>
								</div>

							</x-dropdown.dropdown-button>
						@endforeach
					</div>
				</div>

				<!-- Dropdown Option 3 -->
				<x-dropdown.dropdown-button
						class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
					Group Conversation
				</x-dropdown.dropdown-button>
			</div>
		</div>

	</div>

	{{--	Conversation Content Section--}}
	<div class="p-4">
		@foreach ($conversations as $conversation)
			<div
					x-show="conversation === '{{ $conversation->type }}'"
					wire:key="conversation-{{ $conversation->id }}">
				{{-- Message List --}}
				<h3 class="font-bold text-lg mb-3">Conversation: {{ ucfirst($conversation->type) }}</h3>
				<div
						id="messages-container"
						class="flex flex-col overflow-y-auto {{ auth()->user()->cannot('create', App\Models\Message::class) ? 'h-[46rem]' : 'h-[35rem]' }} bg-gray-100 rounded-lg p-4">
					<div class="space-y-4">
						@foreach ($conversation->messages as $message)
							@php
								$isOwnMessage = auth()->id() === $message->user_id;
							@endphp
							<div class="flex items-start {{ $isOwnMessage ? '' : 'ml-8' }} gap-2.5">
								<img
										class="w-8 h-8 rounded-full"
										src="{{ $message->user->avatarUrl() }}"
										alt="User Avatar">
								<div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 {{ $isOwnMessage ? 'bg-slate-200' : 'bg-white' }} rounded-e-xl rounded-es-xl dark:bg-gray-700">
									<div class="flex items-center space-x-2 rtl:space-x-reverse">
										<span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $message->user->name }}</span>
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
					</div>
				</div>

				{{-- Message Input (if allowed to send messages) --}}
				@can('create', App\Models\Message::class)
					<div class="bg-gray-100 rounded-lg p-4 mt-4">
						<form wire:submit.prevent="sendMessage({{ $conversation->id }})">
                            <textarea
		                            wire:model.defer="newMessage"
		                            class="w-full p-2 rounded-lg border-gray-300"
		                            rows="3"
		                            placeholder="Type your message here..."></textarea>
							<button
									type="submit"
									class="px-4 py-2 mt-2 text-white bg-blue-500 rounded-lg"
							>
								Send Message
							</button>
						</form>
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

