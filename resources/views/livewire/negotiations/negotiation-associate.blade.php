<?php


	use App\Events\AssociateDeletedEvent;
	use App\Models\Associate;
	use App\Models\Room;
	use Illuminate\Support\Collection;
	use Livewire\Features\SupportRedirects\Redirector;
	use Livewire\Volt\Component;
	use function Livewire\Volt\{state};

	new class extends Component {
		public Room $room;
		public Collection $associates;
		public Associate $associate;

		public function mount($room):void
		{
			$this->room = $room;
			$this->associates = $this->getAssociates();
		}

		private function getAssociates():Collection
		{
			return $this->room->associates;
		}

		private function getAssociate($associateId):Associate
		{
			return Associate::findOrFail($associateId);
		}

		public function editAssociate($associate):Redirector
		{
			return redirect(route('edit.associate',
				[
					'room' => $this->room,
					'associate' => $associate
				]
			));
		}

		public function showAssociate(Associate $associate):Redirector
		{
			return redirect(route('show.associate', ['associate' => $associate, 'room' => $associate->room]));
		}

		public function deleteAssociate($associateId):void
		{
			$this->associate = $this->getassociate($associateId);
			if ($this->associate->images()->count()) {
				foreach ($this->associate->images as $image) {
					if (Storage::disk('s3-public')->exists($image->image)) {
						Storage::disk('s3-public')->delete($image->image);
					}
				}
			}
			$this->associate->delete();
			event(new AssociateDeletedEvent($this->room->id));
		}

		public function addAssociate():Redirector
		{
			return redirect(route('create.associate', ['room' => $this->room]));
		}

		public function getListeners():array
		{
			return [
				"echo-presence:associate.{$this->room->id},AssociateEditedEvent" => 'refresh',
				"echo-presence:associate.{$this->room->id},AssociateCreatedEvent" => 'refresh',
				"echo-presence:associate.{$this->room->id},AssociateDeletedEvent" => 'refresh',
			];
		}
	}

?>

<div x-data="{showList:true}">
	<div class="px-3">
		<x-board-elements.category-header
				click-action="addAssociate"
				class="bg-violet-400 dark:bg-violet-600 border-gray-300"
				value="Associates">
			<x-slot:actions>
				<button @click="showList = !showList">
					<x-heroicons::mini.solid.chevron-up-down class="w-5 h-5 text-slate-700 dark:text-slate-300" />
				</button>
				<span
						x-transition:enter="transition ease-out duration-200"
						x-transition:enter-start="opacity-0 scale-95"
						x-transition:enter-end="opacity-100 scale-100"
						x-transition:leave="transition ease-in duration-75"
						x-transition:leave-start="opacity-100 scale-100"
						x-transition:leave-end="opacity-0 scale-95"
						x-show="!showList"
						class="text-sm text-slate-700 dark:text-slate-300">{{ $associates->count() }}items hidden</span>
			</x-slot:actions>
		</x-board-elements.category-header>
	</div>
	<div
			x-transition:enter="transition ease-out duration-200"
			x-transition:enter-start="opacity-0 scale-95"
			x-transition:enter-end="opacity-100 scale-100"
			x-transition:leave="transition ease-in duration-75"
			x-transition:leave-start="opacity-100 scale-100"
			x-transition:leave-end="opacity-0 scale-95"
			class="px-4"
			x-show="showList">
		<ul
				role="list"
				class="divide-y divide-gray-100 space-y-4 my-4">
			@foreach($room->associates as $associate)
				<x-cards.associate-card :associate="$associate" />
			@endforeach
		</ul>
	</div>
</div>
