<?php

	use App\Events\UserLoggedInEvent;
	use App\Models\Role;
	use App\Models\Room;
	use App\Models\RoomUser;
	use App\Models\User;
	use Illuminate\Database\Eloquent\Collection;
	use Livewire\Attributes\Validate;
	use Livewire\Volt\Component;

	new class extends Component {
		public Collection $roles;

		#[Validate(['required', 'string'])]
		public string $chosenRole;

		public Room $room;

		public User $user;

		public function mount($room):void
		{
			$this->room = $room;
			$this->roles = $this->getRoles();
			$this->user = auth()->user();
			$this->user->update(['role' => '']);
		}

		private function getRoles()
		{
			return Role::all();
		}

		public function enterRoom():void
		{
			$this->validate();
			$this->loginUser();
		}

		private function loginUser():void
		{
			$this->updateUserRole();
			$this->user = auth()->user();
			
			$roleRedirections = $this->getRoleRedirectionRoutes();

			// Get the route based on the user's role, or fall back to a default redirection
			$redirectRoute = $roleRedirections[$this->user->role] ?? route('negotiation.room',
				['room' => $this->room->id]);

			// Dispatch event if required (e.g., only for negotiation room roles)
			if ($this->user->role !== 'Tactical Lead') {
				event(new UserLoggedInEvent(auth()->user()->tenant_id));
			}

			redirect($redirectRoute);
		}

		private function getRoleRedirectionRoutes():array
		{
			return [
				'Tactical Lead' => route('tactical.room', $this->room->id),
				'Primary Negotiator' => route('negotiation.room', ['room' => $this->room->id]),
				'Secondary Negotiator' => route('negotiation.room', ['room' => $this->room->id]),
				'Recorder' => route('negotiation.room', ['room' => $this->room->id]),
				// Add other roles and their routes as needed
			];
		}

		private function updateUserRole():void
		{
			auth()->user()->update(['role' => $this->chosenRole]);
		}

	}

?>
<form
		wire:submit.prevent="enterRoom()"
		class="flex shrink-0 items-center gap-x-4">
	<x-form-elements.input-error :messages="$errors->get('chosenRole')" />
	<div class="relative w-64 mr-4">
		<label
				for="underline_select"
				class="sr-only">Choose Your Role</label>
		<select
				wire:model="chosenRole"
				id="underline_select"
				class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
			<option selected>Choose your role</option>
			@foreach($roles as $role)
				<option value='{{ $role->name }}'>{{ $role->name }}</option>
			@endforeach
		</select>
	</div>
	<button
			type="submit"
			class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
		Enter Room
	</button>
</form>
