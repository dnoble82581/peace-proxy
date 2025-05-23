<?php

	use App\Models\Negotiation;
	use App\Models\Room;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;

	new class extends Component {
		public Negotiation $negotiation;
		public Collection $hostages;
		public int $roomId;

		public function mount($negotiationId, $roomId):void
		{
			$this->negotiation = $this->getNegotiation($negotiationId);
			$this->hostages = $this->getHostages();
			$this->roomId = $roomId;
		}

		private function getNegotiation($negotiationId):Negotiation
		{
			return Negotiation::query()
				->with('associates')
				->findOrFail($negotiationId);
		}

		private function getHostages():Collection
		{
			return $this->negotiation->associates->where('relationship_to_subject', 'Hostage');
		}

		public function getListeners():array
		{
			return [
				"echo-presence:associate.$this->roomId,AssociateEditedEvent" => 'refresh',
			];
		}
	}

?>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 px-2 pb-4">
	@if($this->hostages->count())
		@foreach($hostages as $hostage)
			<x-cards.hostage-tiny-card :hostage="$hostage" />
		@endforeach
	@else
		<div class="h-full col-span-2">
			<h3 class="text-7xl text-gray-200 uppercase text-center mt-12">No Hostages</h3>
		</div>
	@endif
</div>
