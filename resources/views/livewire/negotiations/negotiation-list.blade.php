<?php

use App\Models\Negotiation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $negotiations;
    public User $user;

    public function mount():void
    {
        $this->negotiations = $this->getNegotiations();
        $this->user = auth()->user();
    }

    private function getNegotiations():Collection
    {

        return Negotiation::query()
            ->select('id', 'title', 'status', 'created_at', 'initial_complainant', 'initial_complaint', 'user_id',
                'city',
                'subject_name',
                'address')
            ->with([
                'rooms' => function ($query) {
                    $query->select('id', 'negotiation_id', 'tenant_id', 'subject_id')
                        ->with('subject');
                },
                'user:id,name', 'subjects'
            ])
            ->get();
    }

    public function beginAndEnterNegotiation($negotiationId):void
    {
        $toUpdate = Negotiation::findOrFail($negotiationId);
        $toUpdate->update(['status' => 'started']);
        $this->redirect(route('negotiation.room', $negotiationId));
    }
}

?>

<div>
	<ul
			role="list"
			class="divide-y divide-gray-100">
		@if($this->negotiations)
			@foreach($this->negotiations as $negotiation)
				<li class="flex items-center justify-between gap-x-6 py-5">
					<div class="min-w-0">
						<div class="flex items-start gap-x-3">
							<p class="text-sm/6 font-semibold text-gray-900">{{ $negotiation->title }}</p>
							<p class="mt-0.5 whitespace-nowrap rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
								{{ $negotiation->status }}</p>
						</div>
						<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
							<p class="whitespace-nowrap">Created:
								<time datetime="2023-03-17T00:00Z">{{ $negotiation->created_at->diffForHumans() }}</time>
							</p>
							<svg
									viewBox="0 0 2 2"
									class="size-0.5 fill-current">
								<circle
										cx="1"
										cy="1"
										r="1" />
							</svg>
							<p class="truncate">{{ $negotiation->user->name }}</p>
						</div>
					</div>
					<div class="min-w-0 max-w-xl">
						<div class="flex items-start gap-x-3">
							<p class="text-sm/6 font-semibold text-gray-900">Initial Complaint</p>
						</div>
						<div class="mt-1 text-xs/5 text-gray-500">
							<p class="truncate">
								{{ $negotiation->initial_complaint }}
							</p>
						</div>
					</div>
					<div class="min-w-0">
						<div class="flex items-start gap-x-3">
							<p class="text-sm/6 font-semibold text-gray-900">Initial Complainant</p>
						</div>
						<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
							<p class="whitespace-nowrap">
								{{ $negotiation->initial_complainant }}
							</p>
						</div>
					</div>

					<div class="flex flex-none items-center gap-x-4">

						<div class="relative flex-none">
							<x-dropdown.dropdown
									align="right"
									width="48">
								<x-slot:trigger>
									<button
											type="button"
											class="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900"
											id="options-menu-0-button"
											aria-expanded="false"
											aria-haspopup="true">
										<span class="sr-only">Open options</span>
										<svg
												class="size-5"
												viewBox="0 0 20 20"
												fill="currentColor"
												aria-hidden="true"
												data-slot="icon">
											<path d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
										</svg>
									</button>
								</x-slot:trigger>
								<x-slot:content>
									<x-dropdown.dropdown-link>Test</x-dropdown.dropdown-link>
								</x-slot:content>
							</x-dropdown.dropdown>
						</div>
					</div>
				</li>
				@foreach($negotiation->rooms as $room)
					<div class="px-8 pt-2">
						<div class="bg-gray-100 px-4 rounded-lg">
							<ul
									role="list"
									class="divide-y divide-gray-100">
								<li class="flex items-center justify-between gap-x-6 py-5">
									<div class="min-w-0">
										<div class="flex items-start gap-x-3">
											<p class="text-sm/6 font-semibold text-gray-900">Room {{ $room->id }}</p>
										</div>
									</div>
									<div class="min-w-0">
										<div class="flex items-start gap-x-3">
											<p class="text-sm/6 font-semibold text-gray-900">{{ $negotiation->subject_name }}</p>
											<p class="mt-0.5 whitespace-nowrap rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
												{{ $room->subject->phone()  }}</p>
										</div>
										<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
											<p class="whitespace-nowrap">
												{{ $negotiation->address }}
											</p>
											<svg
													viewBox="0 0 2 2"
													class="size-0.5 fill-current">
												<circle
														cx="1"
														cy="1"
														r="1" />
											</svg>
											<p class="truncate">{{ $negotiation->city }}</p>
										</div>
									</div>
									<div class="flex flex-none items-center gap-x-4">
										@if($negotiation->status === 'pending' & $this->user->id === $negotiation->user->id)
											<button
													wire:click="beginAndEnterNegotiation({{ $negotiation->id }})"
													class="hidden rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block">
												Begin This
												Negotiation<span class="sr-only">, Enter Negotiation</span></button>
											<span class="sr-only">, Enter Negotiation</span>
										@elseif($negotiation->status === 'started')
											<button
													wire:click="beginAndEnterNegotiation({{ $negotiation->id }})"
													class="hidden rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block">
												Enter This
												Negotiation<span class="sr-only">, Enter Negotiation</span></button>
											<span class="sr-only">, Enter Negotiation</span>
										@else
											<p>This Negotiation will begin soon...</p>
										@endif
									</div>
								</li>
							</ul>
						</div>
					</div>
				@endforeach
			@endforeach
		@endif
	</ul>
</div>
