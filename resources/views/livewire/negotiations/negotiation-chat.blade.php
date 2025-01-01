<?php

use App\Events\NewMessageEvent;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
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
    public string $newMessage = '';

    /**
     * Instance of the chat room.
     *
     * @var Room
     */
    public Room $room;

    public bool $alert = false;

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
        $this->validate([
            'newMessage' => 'required|string|max:255',
        ]);

        $message = $this->createMessage();
        $this->broadcastMessage($message);

        $this->reset('newMessage');
        $this->reset('alert');
    }

    /**
     * Creates a new message in the database.
     *
     * @return Message The newly created message instance.
     */
    private function createMessage():Message
    {
        if ($this->user->cannot('create', Message::class)) {
            abort(403, 'Unauthorized to send messages in this room');
        }
        return Message::create([
            'user_id' => $this->user->id,
            'tenant_id' => $this->user->tenant_id,
            'type' => $this->alert? 'emergency' : 'normal',
            'room_id' => $this->room->id,
            'message' => $this->newMessage,
        ]);
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
            "echo-presence:chat.{$this->room->id},NewMessageEvent" => 'refresh',
            "echo-presence:chat.{$this->room->id},here" => 'handleUserHere',
        ];
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

};
?>

<div class="bg-white dark:bg-gray-800 shadow-lg">
	<div class="h-[500px] flex flex-col overflow-y-auto">
		<div class="flex flex-col justify-end flex-1 p-4">
			<div class="space-y-1">
				@foreach($this->room->messages as $message)
					@php
						$isOwnMessage = auth()->id() === $message->user_id;
						$isEmergent = $message->type === 'emergency';
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
				for="chat"
				class="sr-only">Your message</label>
		<div
				x-data="{alert: @entangle('alert')}"
				class="bg-gray-50 dark:bg-gray-700 pl-2">
			<button

					x-on:click="alert = !alert"
					type="button"
					class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">

				<svg
						xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="size-5"
						:class="alert ? 'text-red-400' : ''">
					<path
							stroke-linecap="round"
							stroke-linejoin="round"
							d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
				</svg>

				<span class="sr-only">Upload image</span>
			</button>

		</div>
		@can('chat')
			<div class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-700">
						<textarea
								wire:model="newMessage"
								id="chat"
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
		@endcan
	</form>
</div>
