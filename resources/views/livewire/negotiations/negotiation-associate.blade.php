<?php

	use App\Events\AssociateDeletedEvent;
	use App\Events\AssociateEvent;
	use App\Models\Associate;
	use App\Models\Room;
	use App\Traits\Searchable;
	use Illuminate\Support\Collection;
	use Livewire\Features\SupportRedirects\Redirector;
	use Livewire\Volt\Component;
	use function Livewire\Volt\{state};
	use Illuminate\Support\Facades\Storage;

	new class extends Component {
		use Searchable;

		public Room $room;
		public Collection $associates;
		public Associate $associate;

		public function mount($room):void
		{
			$this->room = $room;
			$this->refreshAssociates();
		}

		private function getAssociate($associateId):Associate
		{
			return Associate::findOrFail($associateId);
		}

		public function updatedSearch():void
		{
			// Refresh associates dynamically based on the current search query
			$this->refreshAssociates();
		}

		public function refreshAssociates():void
		{
			$this->associates = $this->applySearch($this->room->associates(), ['name', 'email']);
		}

		public function editAssociate($associate):Redirector
		{
			return redirect(route('edit.associate', [
				'room' => $this->room,
				'associate' => $associate,
			]));
		}

		public function showAssociate(Associate $associate):Redirector
		{
			return redirect(route('show.associate', [
				'associate' => $associate,
				'room' => $associate->room,
			]));
		}

		public function deleteAssociate($associateId):void
		{
			$this->associate = $this->getAssociate($associateId);

			// Delete associated images, if any
			if ($this->associate->images()->count()) {
				foreach ($this->associate->images as $image) {
					if (Storage::disk('s3-public')->exists($image->image)) {
						Storage::disk('s3-public')->delete($image->image);
					}
				}
			}
			$this->associate->delete();

			event(new AssociateEvent($this->room->id, null, 'deleted'));
			$this->refreshAssociates(); // Refresh the list immediately after deletion
		}

		public function addAssociate():Redirector
		{
			return redirect(route('create.associate', ['room' => $this->room]));
		}

		public function getListeners():array
		{
			return [
				"echo-presence:associate.{$this->room->id},AssociateEvent" => 'refreshAssociates',
			];
		}
	};

?>

<div x-data="{showList:true}">
	<div class="px-3">
		<x-board-elements.category-header
				click-action="addAssociate"
				class="bg-violet-400 dark:bg-violet-600 border-gray-300"
				label="Associates">

			<x-slot:leftActions>
				<button @click="showList = !showList">
					<x-heroicons::mini.solid.chevron-up-down class="w-5 h-5 text-slate-700 dark:text-slate-300" />
				</button>
				<span
						x-show="!showList"
						class="text-sm text-slate-700 dark:text-slate-300 reusable-transition">
                    {{ $this->room->associates->count() }} items hidden
                </span>
			</x-slot:leftActions>

			<x-slot:rightActions>
				<x-form-elements.comoponent-search field="search" />
				<button
						wire:click="addAssociate"
						class="flex items-center">
					<x-heroicons::mini.solid.plus class="w-5 h-5 text-slate-700 dark:text-slate-300" />
				</button>
			</x-slot:rightActions>


		</x-board-elements.category-header>
	</div>

	<!-- List of associates -->
	<div
			x-show="showList"
			class="px-4 reusable-transition">
		<ul
				role="list"
				class="divide-y divide-gray-100 space-y-4 my-4">
			@foreach($associates as $associate)
				<x-cards.associate-card :associate="$this->getAssociate($associate['id'])" />
			@endforeach
		</ul>
	</div>
</div>
