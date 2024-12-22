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
					@endphp
					<x-chat-elements.chat-message
							:message="$message"
							:isOwnMessage="$isOwnMessage" />
				@endforeach
			</div>
		</div>
	</div>
	<hr>
	<form wire:submit.prevent="sendMessage">
		<label
				for="chat"
				class="sr-only">Your message</label>
		<div class="bg-gray-50 dark:bg-gray-700">
			<button
					type="button"
					class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
				<svg
						class="w-5 h-5"
						aria-hidden="true"
						xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 20 18">
					<path
							fill="currentColor"
							d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z" />
					<path
							stroke="currentColor"
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							d="M18 1H2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
					<path
							stroke="currentColor"
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z" />
				</svg>
				<span class="sr-only">Upload image</span>
			</button>
			<button
					type="button"
					class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
				<svg
						class="w-5 h-5"
						aria-hidden="true"
						xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 20 20">
					<path
							stroke="currentColor"
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							d="M13.408 7.5h.01m-6.876 0h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM4.6 11a5.5 5.5 0 0 0 10.81 0H4.6Z" />
				</svg>
				<span class="sr-only">Add emoji</span>
			</button>
		</div>
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
	</form>
</div>
