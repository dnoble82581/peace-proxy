<?php

use App\Models\Room;
use App\Models\Subject;
use Livewire\Volt\Component;

new class extends Component {
    public Room $room;
    public Subject $subject;

    public function mount(Room $room):void
    {
        $this->room = $room;
        $this->subject = $this->getSubject();
    }

    public function showWarrants():void
    {
        $this->dispatch('modal.open', component: 'modals.show-warrant', arguments: ['subjectId' => $this->subject->id]);
    }

    private function getSubject():Subject
    {
        return $this->room->subject;
    }

    public function editSubject()
    {
        return redirect(route('edit.subject',
            ['room' => $this->room, 'subject' => $this->subject]
        ));
    }

    public function getListeners():array
    {
        return [
            "echo-presence:chart.{$this->room->id},ChartUpdatedEvent" => 'refresh',
        ];
    }
}

?>

<div class="rounded-lg bg-white dark:bg-gray-800 col-span-6">
	<div class="rounded-lg shadow dark:bg-gray-700">
		<div class="px-4 py-5 sm:p-6 relative">
			<div class="flex gap-5 justify-evenly">
				<div class="absolute top-2 right-2">
					<x-dropdown.dropdown>
						<x-slot:trigger>
							<button>
								<x-heroicons::mini.solid.ellipsis-vertical class="w-6 h-6 text-gray-400" />
							</button>
						</x-slot:trigger>
						<x-slot:content>
							<div>
								<x-dropdown.dropdown-button>Add Warrant</x-dropdown.dropdown-button>
								<x-dropdown.dropdown-button wire:click="editSubject">
									Edit
								</x-dropdown.dropdown-button>
								<x-dropdown.dropdown-button>View</x-dropdown.dropdown-button>
							</div>
						</x-slot:content>
					</x-dropdown.dropdown>
				</div>
				<div>
					<x-svg-images.image-placeholder
							class="w-20 h-20 rounded shadow" />
				</div>
				<div class="text-sm dark-light-text">
					<strong class="block">{{ $subject->name }}</strong>
					<span class="block">{{ $subject->address ?? 'No Address' }}</span>
					<span class="block">{{ $subject->phone() }}</span>
				</div>
				<div class="text-sm dark-light-text">
					<strong class="block">Deadlines</strong>
					<span class="block">{{ $subject->demands->first()->title ?? 'none' }}</span>
					<span class="block">{{ $subject->demands->first()->deadline->diffForHumans() ?? 'none' }}</span>
				</div>

				<div
						wire:poll
						class="text-sm dark-light-text">
					<strong class="block">Mood</strong>
					<span class="block">{{ $subject->moodLogs()->latest('created_at')->first()->name ?? 'No recent log' }}</span>
					<span class="block">{{ $subject->moodLogs()->latest('created_at')->first()->created_at->diffForHumans() }}</span>
				</div>
			</div>
			<div class="grid grid-cols-8 gap-5 items-center">
				<div class="p-4 flex gap-5 col-span-3">
					@if(isset($subject->facebook_url))
						<a href="{{ $subject->facebook_url }}">
							<x-svg-images.social.facebook-icon class="w-6 h-6" />
						</a>
					@endif
					@if(isset($subject->instagram_url))
						<a href="{{ $subject->instagram_url }}">
							<x-svg-images.social.instagram-icon class="w-6 h-6" />
						</a>
					@endif
					@if(isset($subject->snapchat_url))
						<a href="{{ $subject->snapchat_url }}">
							<x-svg-images.social.snapchat-icon class="w-6 h-6" />
						</a>
					@endif
					@if(isset($subject->x_url))
						<a href="{{ $subject->x_url }}">
							<x-svg-images.social.x-icon class="w-6 h-6" />
						</a>
					@endif
					@if(isset($subject->youtube_url))
						<a href="{{ $subject->youtube_url }}">
							<x-svg-images.social.youtube-icon class="w-6 h-6" />
						</a>
					@endif
				</div>
				<div class="col-span-5">
					<div class="flex items-center gap-2">
						<button
								wire:click="showWarrants"
								type="button"
								class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
							Warrants({{ $subject->warrants->count() }})
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
