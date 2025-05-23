<?php

	use App\Events\HookEvent;
	use App\Models\Hook;
	use App\Models\Room;
	use App\Models\User;
	use App\Traits\Searchable;
	use Illuminate\Auth\Access\AuthorizationException;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;
	use App\Policies\HookPolicy;

	/**
	 * Livewire component for managing negotiation hooks.
	 * Handles actions such as creating, editing, and deleting hooks tied to a specific room,
	 * and listens for related events via broadcasting.
	 */
	new class extends Component {
		use Searchable;

		/**
		 * The current room associated with the hooks.
		 *
		 * @var Room
		 */
		public Room $room;

		/**
		 * The authenticated user.
		 *
		 * @var User
		 */
		public User $user;

		public Collection $hooks;

		/**
		 * Initialize the component with the provided room and authenticated user data.
		 *
		 * @param  Room  $room  Represents the room the user is managing hooks for.
		 */
		public function mount(Room $room):void
		{
			$this->room = $room;
			$this->user = auth()->user();
			$this->refreshHooks();
		}

		/**
		 * Define the event listeners for the Livewire component.
		 * These handle real-time events for hook creation, editing, and deletion.
		 *
		 * @return array An array of event-key-to-method mappings.
		 */
		public function getListeners():array
		{
			return [
				"echo-presence:hook.{$this->room->id},HookEvent" => 'refreshHooks',
			];
		}

		public function updatedSearch():void
		{
			// Refresh associates dynamically based on the current search query
			$this->refreshHooks();
		}

		public function refreshHooks():void
		{
			$this->hooks = $this->applySearch($this->room->subject->hooks(), ['title']);
		}

		/**
		 * Opens a modal for creating a new hook tied to the current room.
		 *
		 * This will trigger a frontend event (`modal.open`) to display the hook creation form.
		 */
		public function addHook():void
		{
			$this->dispatch('modal.open', component: 'modals.create-hook-form',
				arguments: ['roomId' => $this->room->id]);
		}

		/**
		 * Handles deletion of a specific hook by ID.
		 * Ensures only authorized users can delete hooks, and dispatches an event on deletion.
		 *
		 * @param  int  $hookId  The ID of the hook to delete.
		 *
		 * @return void
		 */
		public function deleteHook(int $hookId):void
		{
			// Find the hook by ID within the current room
			$hook = $this->findHookOrFail($hookId);

			try {
				// Check if the authenticated user is authorized to delete the hook
//            $this->authorize('delete', $hook);

				// Perform deletion and broadcast the HookDeletedEvent
				$hook->delete();
				event(new HookEvent($this->room->id, null, 'deleted'));
			} catch (AuthorizationException $exception) {
				// Handle the case where the user is not authorized to delete the hook
				session()->flash('error', 'You are not authorized to delete this hook.');
			}
		}

		/**
		 * Finds a hook by its ID within the current room, or throws an exception if not found.
		 *
		 * @param  int  $hookId  The ID of the hook.
		 *
		 * @return Hook The found hook.
		 * @throws ModelNotFoundException
		 */
		private function findHookOrFail(int $hookId):Hook
		{
			return Hook::findOrFail($hookId);
		}

		/**
		 * Opens a modal for editing an existing hook by ID.
		 *
		 * This will trigger a frontend event (`modal.open`) to display the hook editing form.
		 *
		 * @param  int  $hookId  The ID of the hook to edit.
		 */
		public function editHook(int $hookId):void
		{
			$this->dispatch('modal.open', component: 'modals.edit-hook-form', arguments: [
				'hookId' => $hookId, 'roomId' => $this->room->id
			]);
		}
	}

?>

<div
		class="mt-3 over"
		x-data="{showList:true}">

	<!-- Section header for hooks with a button for adding a new hook -->
	<div class="px-3">
		<x-board-elements.category-header
				id="HookHeader"
				class="border-gray-300 dark:bg-blue-500 bg-blue-400"
				@click="open = !open"
				click-action="addHook"
				label="Hooks">
			<x-slot:leftActions>
				<button @click="showList = !showList">
					<x-heroicons::mini.solid.chevron-up-down class="w-5 h-5 text-slate-700 dark:text-slate-300" />
				</button>
				<span
						x-show="!showList"
						class="text-sm text-slate-700 reusable-transition dark:text-slate-300">{{ $room->subject->hooks->count() }} items hidden</span>
			</x-slot:leftActions>

			<x-slot:rightActions>
				<x-form-elements.comoponent-search field="search" />
				@can('create', App\Models\Hook::class)
					<button
							wire:click="addHook"
							class="flex items-center">
						<x-heroicons::mini.solid.plus class="w-5 h-5 text-slate-700 dark:text-slate-300" />
					</button>
				@endcan
			</x-slot:rightActions>
		</x-board-elements.category-header>
	</div>


	<!-- Render all hooks in the current room -->
	<div

			x-show="showList"
			class="mt-3 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6 reusable-transition">
		@foreach($hooks as $hook)
			<div
					x-data="{open:true}"
					class="col-span-3">
				<x-cards.expandable-mid-card class="bg-gray-200">
					<!-- Hook Title -->
					<x-slot:title>
						{{ $hook->title }}
					</x-slot:title>

					<!-- Hook Description -->
					<x-slot:content>
						{{ $hook->description }}
					</x-slot:content>

					<!-- Action buttons for editing or deleting the hook -->
					<x-slot:actions>
						<!-- Button to delete the hook -->
						<x-mini-button
								class="mr-2"
								wire:click="deleteHook({{ $hook->id }})"
								rounded
								icon="trash"
								flat
								gray
								interaction="negative"
						/>

						<!-- Button to edit the hook -->
						<x-mini-button
								wire:click="editHook({{ $hook->id }})"
								rounded
								icon="pencil-square"
								flat
								gray
								interaction="neutral"
						/>
					</x-slot:actions>
				</x-cards.expandable-mid-card>
			</div>
		@endforeach
	</div>
</div>
