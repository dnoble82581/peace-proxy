<?php

	use App\Models\Room;
	use App\Models\Subject;
	use Illuminate\Foundation\Application;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Routing\Redirector;
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
			$this->dispatch('modal.open', component: 'modals.show-warrants',
				arguments: ['subjectId' => $this->subject->id]);
		}

		private function getSubject():Subject
		{
			return $this->room->subject;
		}

		public function editSubject():Redirector
		{
			return redirect(route('edit.subject',
				['room' => $this->room, 'subject' => $this->subject]
			));
		}

		public function addWarrant():void
		{
			$this->dispatch('modal.open', component: 'modals.add-warrant-form',
				arguments: ['subjectId' => $this->subject->id]);
		}

		public function getListeners():array
		{
			return [
				"echo-presence:chart.{$this->room->id},ChartUpdatedEvent" => 'refresh',
			];
		}
	}

?>

<div class="rounded-lg bg-white dark:bg-gray-800 col-span-6 relative">
	@if($subject->weapons === 'Yes')
		<div class="flex items-center gap-4">
		<span class="relative flex h-3 w-3 mt-2 ml-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
		</span>
			<button
					type="button"
					class="text-sm flex items-center mt-2 text-red-400 hover:cursor-pointer">Weapons Alert
				<x-heroicons::micro.solid.arrow-right class="ml-2" />
			</button>
		</div>
	@endif
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
								<x-dropdown.dropdown-button wire:click="addWarrant">Add Warrant
								</x-dropdown.dropdown-button>
								<x-dropdown.dropdown-button wire:click="editSubject">
									Edit
								</x-dropdown.dropdown-button>
								<x-dropdown.dropdown-link href="{{ route('show.subject', ['room' => $this->room, 'subject' => $this->subject]) }}">
									View
								</x-dropdown.dropdown-link>
							</div>
						</x-slot:content>
					</x-dropdown.dropdown>
				</div>
				<div class="">
					@if($subject->images()->count())
						@php
							$image = $subject->images()->first()->image;
						@endphp
						<img
								src="{{ $subject->imageUrl($image) }}"
								class="w-24 h-24 rounded"
								alt="">
					@else
						<x-svg-images.image-placeholder
								class="w-24 h-24 rounded shadow" />
					@endif

				</div>
				<div class="text-sm dark-light-text">
					<strong class="block">{{ $subject->name }}</strong>
					<span class="block">{{ $subject->address ?? 'No Address' }}</span>
					<span class="block">{{ $subject->phone() }}</span>
				</div>
				<div class="text-sm dark-light-text max-w-36">
					<strong class="block">Deadline</strong>
					<span class="block truncate">{{ $subject->demands->count() ? $subject->demands()->latest('created_at')->first()->title : 'none' }}</span>
					<span class="block">{{ $subject->demands->count() ? $subject->demands()->latest('created_at')->first()->deadline->diffForHumans() : 'none' }}</span>
				</div>

				<div
						wire:poll
						class="text-sm dark-light-text">
					<strong class="block">Mood</strong>
					<span class="block">{{ $subject->moodLogs()->count() ? $subject->moodLogs()->latest('created_at')->first()->name : 'No recent log' }}</span>
					<span class="block">{{ $subject->moodLogs()->count() ? $subject->moodlogs()->latest('created_at')->first()->created_at->diffForHumans() : '' }}</span>
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
				<div
						x-cloak
						class="col-span-5 relative"
						x-data="{warnings: false}">
					<div class="flex items-center gap-2">
						@if($subject->warrants()->count())
							<button
									wire:click="showWarrants"
									type="button"
									class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
								Warrants({{ $subject->warrants->count() }})
							</button>
						@endif
						@if($subject->warnings()->count())
							<div
									x-transition:enter="transition ease-out duration-200"
									x-transition:enter-start="opacity-0 scale-95"
									x-transition:enter-end="opacity-100 scale-100"
									x-transition:leave="transition ease-in duration-75"
									x-transition:leave-start="opacity-100 scale-100"
									x-transition:leave-end="opacity-0 scale-95"
									x-show="warnings"
									class="absolute top-8 right-52">
								<ul class="list-disc list-inside bg-red-50 text-sm text-red-500 p-3 rounded">
									@foreach($subject->warnings as $warning)
										<li>{{ $warning->warning }}</li>
									@endforeach
								</ul>
							</div>
							<button
									@click="warnings = !warnings"
									@click.away="warnings = false"
									type="button"
									class="rounded bg-rose-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-rose-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-600">
								Alerts ({{ $subject->warnings()->count() }})
							</button>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
