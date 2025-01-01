<?php

use App\Events\NewMessageEvent;
use App\Models\Message;
use App\Models\MessageResponse;
use App\Models\Room;
use Livewire\Volt\Component;
use Symfony\Component\Mailer\Event\MessageEvent;

new class extends Component {
    public Room $room;
    public $messages;
    public Message $EmergencyMessage;

    public function mount($room)
    {
        $this->room = $room;
        $this->messages = $this->getMessages();
    }

    protected function getMessages()
    {
        return $this->room->messages->where('type', 'emergency');
    }

    public function dismiss(int $messageId):void
    {
        $this->EmergencyMessage = $this->getMessage($messageId);
        $this->updateMessage();
        broadcast(new NewMessageEvent($this->EmergencyMessage));
    }

    private function getMessage($messageId):Message
    {
        return Message::findOrFail($messageId);
    }

    public function respond($messageId)
    {
        $this->message = $this->getMessage($messageId);

        MessageResponse::create([
            'user_id' => auth()->user()->id,
            'message_id' => $messageId,
            'response' => 'This is a test',
            'acknowledged' => false,
            'status' => null,
            'tenant_id' => $this->room->tenant_id
        ]);
        broadcast(new NewMessageEvent($this->message));
    }

    private function updateMessage()
    {
        $this->message->update([
            'type' => 'normal',
            'updated_at' => now(),
        ]);
    }

    public function getListeners():array
    {
        return [
            "echo-presence:chat.{$this->room->id},NewMessageEvent" => 'refresh'
        ];
    }

    public function refresh()
    {
        $this->messages = $this->getMessages();
    }
}

?>
<div>
	@if($this->messages->count())
		<div class="rounded-md bg-red-50 p-4">
			<div class="flex">
				<div class="shrink-0">
					<svg
							class="size-5 text-red-400"
							viewBox="0 0 20 20"
							fill="currentColor"
							aria-hidden="true"
							data-slot="icon">
						<path
								fill-rule="evenodd"
								d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
								clip-rule="evenodd" />
					</svg>
				</div>
				<div
						class="ml-3"
						x-data="{ open: true }"
						x-cloak>
					<div class="flex items-center">
						<h3 class="text-sm font-medium text-red-800">High Priority Message from Negotiators
						                                             ({{ $this->messages->count() }})
						</h3>
						<button
								type="button"
								@click="open = !open">
							<x-heroicons::mini.solid.chevron-up-down class="text-red-800 ml-4" />
						</button>
					</div>

					<div class="mt-2 text-sm text-red-700">
						<ul
								x-show="open"
								role="list"
								class="list-disc space-y-3 pl-5">
							@foreach($this->messages as $message)
								<li>{{ $message->message }}
									<span
											wire:poll
											class="text-xs ml-10">Submitted {{ $message->updated_at->diffForHumans() }} By: {{ $message->user->name }} </span>
									<div class="mt-1 space-x-2">
										<x-buttons.small-primary
												class="bg-rose-400 hover:bg-rose-500"
												wire:click="respond({{ $message->id }})">Reply
										</x-buttons.small-primary>
										<x-buttons.small-primary
												wire:click="dismiss({{ $message->id }})"
												class="bg-gray-400 hover:bg-gray-500">Dismiss
										</x-buttons.small-primary>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	@endif
</div>

