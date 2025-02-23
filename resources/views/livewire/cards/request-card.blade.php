<?php

	use App\Events\RequestEditedEvent;
	use App\Events\SubjectRequestEvent;
	use App\Events\SubjectUpdatedEvent;
	use App\Livewire\Forms\SubjectRequestForm;
	use App\Models\Room;
	use App\Models\SubjectRequest;
	use App\Policies\ResponsePolicy;
	use Carbon\Carbon;
	use Livewire\Volt\Component;
	use App\Models\Response;


	new class extends Component {
		public SubjectRequestForm $form;
		public Room $room;

		public function mount($room):void
		{
			$this->room = $room;
		}

		public function showRequest($requestId):void
		{
			$this->dispatch('modal.open', component: 'modals.show-subject-request',
				arguments: ['requestId' => $requestId]);
		}

		public function editRequest($requestId):void
		{
			$this->dispatch('modal.open', component: 'modals.edit-request-form',
				arguments: ['requestId' => $requestId]);
		}

		public function addRequest():void
		{
			$this->dispatch('modal.open', component: 'modals.create-request-modal',
				arguments: ['roomId' => $this->room->id]);
		}

		public function getListeners():array
		{
			return [
				"echo-presence:subject-request.{$this->room->id},SubjectRequestEvent" => 'refresh',
//				"echo-presence:response.{$this->room->id},ResponseCreatedEvent" => 'refresh',
//				"echo-presence:response.{$this->room->id},ResponseUpdatedEvent" => 'refresh',
			];
		}

		public function respond($requestId):void
		{
			$this->dispatch('modal.open', component: 'modals.create-response-form', arguments: [
				'roomId' => $this->room->id, 'requestId' => $requestId
			]);
		}

		public function showResponses($requestId):void
		{
			$this->dispatch('modal.open', component: 'modals.show-response-modal',
				arguments: ['requestId' => $requestId]);
		}

		public function deleteRequest($requestId):void
		{
			$requestToDelete = SubjectRequest::findOrFail($requestId);
			$requestToDelete->delete();
			event(new SubjectRequestEvent($this->room->id, null, 'deleted'));
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
					<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">
						@if($request->responses()->where('dismissed', false)->count())
							<button
									wire:click="showResponses({{ $request->id }})"
									type="button"
									class="hover:text-indigo-600 text-indigo-500 cursor-pointer">
								View({{$request->responses()->where('dismissed', false)->count()}})
							</button>
						@else
							<button
									wire:click="showResponses({{ $request->id }})"
									type="button"
									disabled
									class="hover:text-indigo-600 text-indigo-500 cursor-not-allowed">
								View({{$request->responses()->where('dismissed', false)->count()}})
							</button>
						@endif

					</td>
					<td class="relative py-2 space-x-2 pr-4 pl-3 text-left text-xs font-medium whitespace-nowrap sm:pr-3">
						<button
								type="button"
								wire:click="showRequest({{ $request->id }})">
							<x-heroicons::outline.envelope-open class="w-4 h-4 hover:text-indigo-500 text-indigo-400 cursor-pointer" />
						</button>
						@can('update', $request)
							<button
									type="button"
									wire:click="editRequest({{ $request->id }})">
								<x-heroicons::mini.solid.pencil-square class="w-4 h-4 hover:text-blue-500 text-blue-400 cursor-pointer" />
							</button>
						@endcan
						@can('delete', $request)
							<button
									type="button"
									wire:click="deleteRequest({{ $request->id }})">
								<x-heroicons::outline.trash class="w-5 h-5 hover:text-red-500 text-red-400 cursor-pointer" />
							</button>
						@endcan
						@can('create', App\Models\Response::class)
							<button
									type="button"
									wire:click="respond({{ $request->id }})">
								<x-heroicons::outline.arrows-right-left class="w-4 h-4 hover:indigo-sky-500 text-sky-400 cursor-pointer" />
							</button>
						@endcan
					</td>
				</tr>
			@endforeach
		</x-slot:content>
	</x-table-elements.subject-card-table-layout>
</div>

