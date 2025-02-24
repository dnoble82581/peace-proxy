<?php

	use App\Events\DeliveryPlanEvent;
	use App\Events\DemandEvent;
	use App\Events\DocumentDeletedEvent;
	use App\Models\DeliveryPlan;
	use App\Models\Room;
	use App\Services\DocumentProcessor;
	use Livewire\Volt\Component;

	new class extends Component {

		public Room $room;

		public function mount($roomId)
		{
			$this->room = Room::findOrFail($roomId);
		}

		public function createDeliveryPlan()
		{
			$this->dispatch('modal.open', component: 'modals.create-delivery-plan',
				arguments: ['roomId' => $this->room->id]);
		}

		public function editDeliveryPlan($deliveryPlanId)
		{
			$this->dispatch('modal.open', component: 'modals.create-delivery-plan',
				arguments: ['roomId' => $this->room->id, 'deliveryPlanId' => $deliveryPlanId]);
		}

		public function deleteDeliveryPlan($deliveryPlanId):void
		{
			$deliveryPlanToDelete = $this->fetchDeliveryPlan($deliveryPlanId);

			if ($deliveryPlanToDelete->documents()->count()) {
				foreach ($deliveryPlanToDelete->documents as $document) {
					try {
						$documentProcessor = new DocumentProcessor();
						$documentProcessor->deleteDocument($deliveryPlanToDelete, $document->filename);
						$isDeleted = $documentProcessor->deleteDocument($deliveryPlanToDelete,
							$document->filename);
						if ($isDeleted) {
							$this->flashMessage = 'Document successfully deleted.';
						} else {
							$this->flashMessage = 'Failed to delete the document.';
						}
					} catch (Exception $e) {
						echo 'Error: '.$e->getMessage();
					}
				}
			}
			$deliveryPlanToDelete->delete();
			event(new DeliveryPlanEvent($this->room->id, null, 'deleted'));
			event(new DemandEvent($this->room->id, null, 'edited'));

		}

		private function fetchDeliveryPlan($deliveryPlanId):DeliveryPlan
		{
			return DeliveryPlan::findOrFail($deliveryPlanId);
		}

		public function getListeners()
		{
			return [
				"echo-presence:deliveryPlan.{$this->room->id},DeliveryPlanEvent" => 'refresh'
			];
		}

		public function createResolutionPlan()
		{
			dd('Resolution Plan');
		}
	}

?>

<div>
	<x-dropdown.dropdown>
		<x-slot:trigger>
			<div class="flex justify-end px-4">
				<button>
					<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
				</button>
			</div>
		</x-slot:trigger>
		<x-slot:content>
			<x-dropdown.dropdown-button
					value="Create Delivery Plan"
					wire:click="createDeliveryPlan" />
			<x-dropdown.dropdown-button value="Create Resolution Plan" />
		</x-slot:content>
	</x-dropdown.dropdown>
	<x-table-elements.subject-card-table-layout :labels="['Title', 'Location','Documents', 'Created By', 'Actions']">
		<x-slot:content>
			@foreach($this->room->deliveryPlans as $deliveryPlan)
				<tr class="even:bg-gray-50 dark:even:bg-slate-900">
					<td class="py-2 pr-3 pl-4 text-xs font-medium whitespace-nowrap dark-light-text sm:pl-3">
						{{ $deliveryPlan->title }}
					</td>
					<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $deliveryPlan->delivery_location }}</td>
					<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $deliveryPlan->documents()->count() }}</td>
					<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $deliveryPlan->user->name }}
					</td>
					<td class="relative py-2 gap-3 pr-4 pl-3 text-left text-xs font-medium whitespace-nowrap sm:pr-3 flex">
						<button
								type="button">
							<x-heroicons::outline.envelope-open class="w-4 h-4 hover:text-indigo-500 text-indigo-400 cursor-pointer" />
						</button>
						<button
								wire:click="editDeliveryPlan({{ $deliveryPlan->id }})"
								type="button">
							<x-heroicons::outline.pencil-square class="w-4 h-4 hover:text-blue-500 text-blue-400 cursor-pointer" />
						</button>
						<button
								wire:click="deleteDeliveryPlan({{ $deliveryPlan->id }})"
								type="button">
							<x-heroicons::outline.trash class="w-4 h-4 hover:text-red-500 text-red-400 cursor-pointer" />
						</button>
					</td>
				</tr>
			@endforeach
		</x-slot:content>
	</x-table-elements.subject-card-table-layout>

</div>
