<?php

	use App\Models\Negotiation;
	use App\Models\User;
	use Illuminate\Database\Eloquent\Collection;
	use Livewire\Attributes\Computed;
	use Livewire\Attributes\Validate;
	use Livewire\Volt\Component;
	use Livewire\WithPagination;

	new class extends Component {
		use WithPagination;

		public \Illuminate\Support\Collection $negotiations;
		public User $user;

		public function mount():void
		{
			$this->negotiations = $this->getNegotiations();
			$this->user = auth()->user();
			$this->roles = ['Primary Negotiator', 'Secondary Negotiator', 'Recorder'];
		}

		private function getNegotiations():Collection
		{
			return Negotiation::query()->with('rooms')->get();
		}

	}

?>

<div>
	<ul
			role="list"
			class="divide-y divide-gray-200">
		@foreach($negotiations as $negotiation)
			<div x-data="{ open: false }">
				<x-cards.negotiation-list-card :negotiation="$negotiation" />
				<div class="px-12">
					<ul class="my-2 space-y-2">
						@foreach($negotiation->rooms as $room)
							<x-cards.room-list-card
									wirekey="room-list-card-{{ $room->id }}"
									:room="$room"
									:roles="$this->roles" />
						@endforeach
					</ul>
				</div>
			</div>
		@endforeach
	</ul>
</div>
