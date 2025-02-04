<?php

	use App\Events\NewMessageEvent;
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

		public bool $isPrivate = false;

		public bool $emergency = false;
		public bool $important = false;
		public bool $toPrimary = false;
		public bool $toTactical = false;
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
		 * @param $isPrivate
		 * @param $toTactical
		 *
		 * @return void
		 */
		public function mount(Room $room, $isPrivate, $toTactical):void
		{
			$this->room = $room;
			$this->user = auth()->user();
			$isPrivate? $this->toPrimary = true : $this->toPrimary = false;
		}

		/**
		 * Sends a new message to the chat room.
		 *
		 * Validates the input message, creates the new message,
		 * broadcasts it, and resets the message input field.
		 *
		 * @return void
		 */
		public function sendMessage():void
		{
			$this->validate();

			$message = $this->createMessage();
			$this->broadcastMessage($message);

			$this->reset('newMessage');
			$this->reset('emergency');
			if (!$this->isPrivate) {
				$this->reset('toPrimary');
			}
		}

		public function getFilteredMessages()
		{
			return $this->room->messages->filter(function ($message) {
				if ($this->toTactical) {
					return $message->to_tactical;
				}

				if ($this->toPrimary) {
					return $message->to_primary;
				}
				return !($message->to_primary || $message->to_tactical);
			});
		}


		/**
		 * Creates a new message in the database.
		 *
		 * @return Message The newly created message instance.
		 */
		private function createMessage():Message
		{
			return $this->room->messages()->create([
				'user_id' => $this->user->id,
				'tenant_id' => $this->user->tenant_id,
				'emergency' => $this->emergency,
				'to_primary' => $this->toPrimary,
				'to_tactical' => $this->toTactical,
				'important' => $this->important,
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
		class="bg-white dark:bg-gray-800 shadow-lg rounded-b-lg">
	<div
			x-data
			x-init="$nextTick(() => $el.scrollTop = $el.scrollHeight)"
			@new-message.window="setTimeout(() => $el.scrollTop = $el.scrollHeight, 100)"
			id="conversation"
			class="h-[32rem] flex flex-col overflow-y-auto">
		<div class="flex flex-col justify-end flex-1 p-4">
			<div
					class="space-y-1">
				@foreach($this->room->messages as $message)
					@php
						$isOwnMessage = auth()->id() === $message->user_id;
						$isEmergent = $message->emergency;
					@endphp
					<x-chat-elements.chat-message
							:message="$message"
							:isOwnMessage="$isOwnMessage" />
				@endforeach
			</div>
		</div>
	</div>
	<hr>
	<div class="">
		<form
				wire:submit.prevent="sendMessage">
			<label
					for="chat-input"
					class="sr-only">Your message</label>

			<div class="bg-gray-100 dark:bg-gray-700 rounded-b-lg">
				<div class="py-2 px-8 border-t bg-gray-100 flex items-center space-x-4 dark:bg-gray-700">
					<button class="bg-gray-200 p-1 rounded-lg">⚠️</button>
					<button class="bg-gray-200 p-1 rounded-lg">🆘</button>
					<button class="bg-gray-200 p-1 rounded-lg">👏</button>
				</div>
				<div class="flex items-center px-3 pt-2 pb-3">
				<textarea
						wire:model="newMessage"
						id="chat-input"
						rows="1"
						class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
						placeholder="Your message..."></textarea>
					<button
							type="submit"
							class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
						<svg
								class="w-5 h-5 rotate-90 rtl:-rotate-90"
								aria-hidden="true"
								xmlns="http://www.w3.org/2000/svg"
								fill="currentColor"
								viewBox="0 0 18 20">
							<path d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
						</svg>
						<span class="sr-only">Send message</span>
					</button>
				</div>
			</div>
		</form>
	</div>
</div>