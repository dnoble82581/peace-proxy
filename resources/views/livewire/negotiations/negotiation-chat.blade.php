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

		public bool $emergency = false;
		public bool $important = false;
		public bool $toPrimary = false;
		public bool $toTactical = false;

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
		class="bg-white dark:bg-gray-800 shadow-lg">
	<div
			x-data
			x-init="$nextTick(() => $el.scrollTop = $el.scrollHeight)"
			@new-message.window="setTimeout(() => $el.scrollTop = $el.scrollHeight, 100)"
			id="conversation"
			class="h-[500px] flex flex-col overflow-y-auto">
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
							:isOwnMessage="$isOwnMessage"
							:isEmergent="$isEmergent" />
				@endforeach
			</div>
		</div>
	</div>
	<hr>
	<form
			wire:submit.prevent="sendMessage">
		<label
				for="chat-input"
				class="sr-only">Your message</label>
		<div
				x-data="{emergency: @entangle('emergency'), important: @entangle('important'), toPrimary: @entangle('toPrimary'), toTactical: @entangle('toTactical')}"
				class="bg-gray-50 dark:bg-gray-700 pl-6 flex items-center gap-4 pt-2">
			<button

					x-on:click="emergency = !emergency"
					type="button"
					class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
				<svg
						xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="size-5"
						:class="emergency ? 'text-red-400' : ''">
					<path
							stroke-linecap="round"
							stroke-linejoin="round"
							d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
				</svg>

				<span class="sr-only">Mark Message Urgent</span>
			</button>
			<button
					type="button"
					@click="important = !important"
					class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
				<svg
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="size-6"
						:class="important ? 'text-yellow-600' : ''">
					<path
							stroke-linecap="round"
							stroke-linejoin="round"
							d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
				</svg>

				<span class="sr-only">Mark Message Important</span>

			</button>
			<button
					type="button"
					@click="toPrimary = !toPrimary"
					class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
				<svg
						xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="size-6"
						:class="toPrimary ? 'text-blue-400' : ''">
					<path
							stroke-linecap="round"
							stroke-linejoin="round"
							d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
				</svg>

				<span class="sr-only">Mark Message for primary negotiator</span>

			</button>
			<button
					type="button"
					@click="toTactical = !toTactical"
					class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
				<svg
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="size-6"
						:class="toTactical ? 'text-green-400' : ''">
					<path
							stroke-linecap="round"
							stroke-linejoin="round"
							d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
				</svg>

				<span class="sr-only">Mark Message for tactical team</span>

			</button>

		</div>
		<div class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-700">
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
	</form>
</div>
