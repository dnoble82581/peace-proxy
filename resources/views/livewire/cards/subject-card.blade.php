<?php

	use App\Models\Room;
	use App\Models\Subject;
	use App\Notifications\SendSMSNotification;
	use Livewire\Features\SupportRedirects\Redirector;
	use Livewire\Volt\Component;
	use function Livewire\Volt\{state};
	use Twilio\Rest\Client;


	new class extends Component {
		public Subject $subject;
		public Room $room;

		public function mount($subject):void
		{
			$this->subject = $subject;
			$this->room = $this->subject->room;
		}

		public function editSubject():Redirector
		{
			return redirect(route('edit.subject',
				['room' => $this->room, 'subject' => $this->subject]
			));
		}

		public function getListeners():array
		{
			return [
				"echo-presence:subject.{$this->room->id},SubjectUpdatedEvent" => 'refresh',
			];
		}

		public function callSubject()
		{
			new SendSMSNotification('13195947290');
		}

		public function textSubject() {}
	}
?>

<div class="pt-3">
	<div class="flex gap-5 justify-between items-center px-8">
		<div class="absolute top-12 right-4">
			<x-dropdown.dropdown>
				<x-slot:trigger>
					<button class="">
						<x-heroicons::mini.solid.ellipsis-vertical class="w-6 h-6 text-gray-400" />
					</button>
				</x-slot:trigger>
				<x-slot:content>
					<div>
						<x-dropdown.dropdown-button wire:click="editSubject">
							Edit
						</x-dropdown.dropdown-button>
						<x-dropdown.dropdown-link href="{{ route('show.subject', ['room' => $this->subject->room_id, 'subject' => $this->subject]) }}">
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
						alt="Subject Image">
			@else
				<img
						src="{{ $subject->temporaryImageUrl() }}"
						class="w-24 h-24 rounded"
						alt="Temporary Subject Image">
			@endif
			<div class="mt-3 flex justify-between gap-2 px-1">
				<form
						action="{{ route('send.sms') }}"
						method="POST"
						class="text-center">
					@csrf
					<button
							type="submit"
							class="bg-blue-600 text-white p-1 rounded-lg hover:bg-blue-700">
						<x-heroicons::micro.solid.chat-bubble-bottom-center class="w-6 h-6" />
					</button>
					@if (session('message'))
						<p class="text-green-600 mt-2">{{ session('message') }}</p>
					@endif
				</form>
			</div>
		</div>
		<div class="text-sm dark-light-text">
			<strong class="block">{{ $subject->name }}</strong>
			<span class="block">{{ $subject->address ?? 'No Address' }}</span>
			<span class="block">{{ $subject->phone }}</span>
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
</div>

