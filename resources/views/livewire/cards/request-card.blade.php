<?php

	use App\Events\RequestEditedEvent;
	use App\Events\SubjectUpdatedEvent;
	use App\Livewire\Forms\SubjectRequestForm;
	use App\Models\Room;
	use App\Models\SubjectRequest;
	use Carbon\Carbon;
	use Livewire\Volt\Component;

	new class extends Component {
		public SubjectRequestForm $form;
		public Room $room;

		public function mount($room)
		{
			$this->room = $room;
		}

		public function showRequest($requestId)
		{
			$this->dispatch('modal.open', component: 'modals.show-subject-request', arguments: [$requestId]);
		}

		public function editRequest($requestId)
		{
			$this->dispatch('modal.open', component: 'modals.edit-request-form', arguments: [$requestId]);
		}

		public function addRequest()
		{
			$this->dispatch('modal.open', component: 'modals.create-request-modal', arguments: [$this->room->id]);
		}

		public function getListeners():array
		{
			return [
				"echo-presence:request.{$this->room->id},RequestEditedEvent" => 'refresh',
			];
		}

		public function deleteRequest($requestId)
		{
			$requestToDelete = SubjectRequest::findOrFail($requestId);
			$requestToDelete->delete();
			event(new RequestEditedEvent($this->room->id));
		}
	}

?>
<div>
	<div class="flex justify-end px-4 mt-2">
		<button wire:click="addRequest">
			<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
		</button>
	</div>
	<x-table-elements.subject-card-table-layout :labels="['Request', 'Status','Type', 'Priority', 'Responses']">
		<x-slot:content>
			@foreach ($room->requests->sortByDesc('priority_level') as $request)
				<tr class="even:bg-gray-50 dark:even:bg-slate-900">
					<td class="py-2 pr-3 pl-4 text-xs font-medium whitespace-nowrap dark-light-text sm:pl-3">
						{{ $request->subject_request }}
					</td>
					<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">
						<x-badges.badge
								:color="$request->badgeColor()"
								:value="$request->status" />
					</td>
					<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $request->type }}
					<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $request->getPriorityString($request->priority_level) }}
					{{--					<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $request->created_at }}--}}
					<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text"><a
								href="#"
								class="hover:text-indigo-600 text-indigo-500 cursor-pointer">View(2)</a></td>
					<td class="relative py-2 space-x-2 pr-4 pl-3 text-left text-xs font-medium whitespace-nowrap sm:pr-3">
						<button
								type="button"
								wire:click="showRequest({{ $request->id }})">
							<x-heroicons::outline.envelope-open class="w-4 h-4 hover:text-indigo-500 text-indigo-400 cursor-pointer" />
						</button>
						<button
								type="button"
								wire:click="editRequest({{ $request->id }})">
							<x-heroicons::mini.solid.pencil-square class="w-4 h-4 hover:text-blue-500 text-blue-400 cursor-pointer" />
						</button>
						<button
								type="button"
								wire:click="deleteRequest({{ $request->id }})">
							<x-heroicons::outline.trash class="w-4 h-4 hover:text-red-500 text-red-400 cursor-pointer" />
						</button>
					</td>
				</tr>
			@endforeach
		</x-slot:content>
	</x-table-elements.subject-card-table-layout>
</div>

