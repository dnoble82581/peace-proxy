<?php

	use App\Events\RequestForInformationEvent;
	use App\Models\RequestForInformation;
	use App\Models\Room;
	use App\Models\Subject;
	use Livewire\Volt\Component;

	new class extends Component {

		public Room $room;
		public Subject $subject;

		public function mount($room)
		{
			$this->room = $room;
			$this->subject = $this->room->subject;
		}

		public function addRfi()
		{
			$this->dispatch('modal.open', component: 'modals.create-rfi', arguments: [
				'userId' => auth()->user()->id, 'roomId' => $this->room->id
			]);
		}

		public function showRfi($rfiId)
		{
			$this->dispatch('modal.open', component: 'modals.show-rfi-modal', arguments: ['rfiId' => $rfiId]);
		}

		public function editRfi($rfiId)
		{
			$this->dispatch('modal.open', component: 'modals.edit-rfi-modal', arguments: ['rfiId' => $rfiId]);
		}

		public function deleteRfi($rfiId)
		{
			$rfiToDelete = RequestForInformation::findOrFail($rfiId);
			$rfiToDelete->delete();
			event(new RequestForInformationEvent($this->room->id, null, 'deleted'));
		}

		public function getListeners()
		{
			return [
				"echo-presence:rfi.{$this->room->id},RequestForInformationEvent" => 'refresh',
			];
		}

//		public function refresh()
//		{
//			dd('here');
//		}
	}
?>

<div>
	<div>
		<x-buttons.add-button onClick="addRfi" />
	</div>
	<div>
		<x-table-elements.subject-card-table-layout :labels="['Request', 'Created At', 'Updated At', 'Responses',  'Actions']">
			<x-slot:content>
				@foreach ($room->subject->rfis as $rfi)
					<tr class="even:bg-gray-50 dark:even:bg-slate-900">
						<td class="py-2 pr-3 pl-4 text-xs font-medium whitespace-nowrap dark-light-text sm:pl-3">
							{{ $rfi->request }}
						</td>
						<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $rfi->created_at }}</td>
						<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $rfi->updated_at }}</td>
						<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">Responses</td>
						<td class="relative py-2 space-x-2 pr-4 pl-3 text-left text-xs font-medium whitespace-nowrap sm:pr-3">
							<button
									wire:click="showRfi({{ $rfi->id }})"
									type="button">
								<x-heroicons::outline.envelope-open class="w-4 h-4 hover:text-indigo-500 text-indigo-400 cursor-pointer" />
							</button>
							<button
									wire:click="editRfi({{ $rfi->id }})"
									type="button">
								<x-heroicons::mini.solid.pencil-square class="w-4 h-4 hover:text-blue-500 text-blue-400 cursor-pointer" />
							</button>
							<button
									wire:click="deleteRfi({{ $rfi->id }})"
									type="button">
								<x-heroicons::outline.trash class="w-4 h-4 hover:text-red-500 text-red-400 cursor-pointer" />
							</button>
						</td>
					</tr>
				@endforeach
			</x-slot:content>
		</x-table-elements.subject-card-table-layout>
	</div>
</div>
