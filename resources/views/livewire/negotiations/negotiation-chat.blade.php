<?php

	use App\Events\NewMessageEvent;
	use App\Models\Conversation;
	use App\Models\ConversationParticipant;
	use App\Models\Message;
	use App\Models\Room;
	use App\Models\User;
	use Illuminate\Support\Collection;
	use Livewire\Attributes\Validate;
	use Livewire\Volt\Component;

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

			$message = $this->createMessage($currentConversationId);
			$this->broadcastMessage($message);
			$this->newMessage = '';

		}

		/**
		 * Creates a new message in the database.
		 *
		 * @return Message The newly created message instance.
		 */
		private function createMessage($currentconversationId):Message
		{
			return $this->room->messages()->create([
				'user_id' => $this->user->id,
				'tenant_id' => $this->user->tenant_id,
				'room_id' => $this->room->id,
				'conversation_id' => $currentconversationId,
				'message' => $this->newMessage,
			]);

		}

		public function refreshChat():void
		{
			$this->room->load('messages');
			$this->dispatch('new-message');
		}

		/**
		 * Broadcasts the new message to all listeners.
		 *
		 * @param  Message  $message  The message to be broadcasted.
		 *
		 * @return void
		 */
		private function broadcastMessage(Message $message):void
		{
			broadcast(new NewMessageEvent($message));
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
			// Ensure Public Chat exists
			$publicConversation = Conversation::firstOrCreate(
				[
					'type' => 'public', // Unique type
					'room_id' => $this->room->id,
					'tenant_id' => $this->room->tenant_id,
				],
				[
					'initiator_id' => auth()->user()->id,
					'created_at' => now(),
					'updated_at' => now(),
				]);

			$privateConversation = Conversation::firstOrCreate(
				[
					'type' => 'negotiator', // Unique type
					'room_id' => $this->room->id,
					'tenant_id' => $this->room->tenant_id,
				],
				[
					'initiator_id' => auth()->user()->id,
					'created_at' => now(),
					'updated_at' => now(),
				]);

			// Add participants to Public Chat
			$this->addParticipantsToConversation($publicConversation, 'public');

			// Add participants to Private Chat
			$this->addParticipantsToConversation($privateConversation, 'private');

		}

		private function addParticipantsToConversation(Conversation $conversation, string $type):void
		{
			if ($type === 'public') {
				$participants = User::all(); // Modify this if participant selection needs customization

				$bulkInsert = $participants->map(function ($participant) use ($conversation) {
					return [
						'conversation_id' => $conversation->id,
						'user_id' => $participant->id,
						'tenant_id' => $this->room->tenant_id,
						'created_at' => now(),
						'updated_at' => now(),
					];
				})->toArray();

				DB::table('conversation_participants')->insertOrIgnore($bulkInsert); // Avoid duplicates
			} else {
				$participants = User::where('role', 'Primary Negotiator')->orWhere('role',
					'Secondary Negotiator')->get();
				$bulkInsert = $participants->map(function ($participant) use ($conversation) {
					return [
						'conversation_id' => $conversation->id,
						'user_id' => $participant->id,
						'tenant_id' => $this->room->tenant_id,
						'created_at' => now(),
						'updated_at' => now(),
					];
				})->toArray();

				DB::table('conversation_participants')->insertOrIgnore($bulkInsert); // Avoid duplicates
			}
		}

		/**
		 * Handles the presence of a user in the chat room.
		 *
		 * Implementation should be defined for displaying or reacting
		 * to users who are currently in the chat room.
		 *
		 * @param  mixed  $user  The user present in the chat room.
		 *
		 * @return void
		 */
		public function handleUserHere($user):void {}

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
		public function handleUserJoining($user):void {}

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
		public function handleUserLeaving($user):void {}

	}
?>

<div
		x-data="{ conversation: '{{ $conversations->isNotEmpty() ? $conversations->first()->type : '' }}' }"
		class="bg-white dark:bg-gray-800 shadow-lg rounded-b-lg rounded-t-lg">

	{{--	Conversation Tabs as Buttons--}}
	<div class="flex space-x-4 p-4 border-b dark:border-gray-700">
		@foreach ($conversations as $conversation)
			<button
					@click="conversation = '{{ $conversation->type }}'"
					class="rounded-md px-3 py-2 text-sm font-medium text-indigo-700"
					:class="{ 'bg-indigo-100': conversation === '{{ $conversation->type }}' }">
				{{ ucfirst($conversation->type) }}
			</button>
		@endforeach
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
						class="flex flex-col overflow-y-auto {{ auth()->user()->cannot('create', App\Models\Message::class) ? 'h-[40rem]' : 'h-[35rem]' }} bg-gray-100 rounded-lg p-4">
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

