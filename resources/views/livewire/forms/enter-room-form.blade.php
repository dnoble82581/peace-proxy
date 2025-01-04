<?php

	use App\Models\Room;
	use App\Models\RoomUser;
	use App\Models\User;
	use Illuminate\Database\Eloquent\Collection;
	use Livewire\Attributes\Validate;
	use Livewire\Volt\Component;
	use Spatie\Permission\Models\Role;

	new class extends Component {
		public Collection $roles;

		#[Validate('required')]
		public int $chosenRole;

		public Room $room;

		public User $user;

		public function mount($room):void
		{
			$this->room = $room;
			$this->user = auth()->user();
			$this->roles = $this->getRoles();
		}

		public function enterRoom():void
		{
			$this->validate();
			$this->loginUser();
		}

		private function loginUser():void
		{
			$this->user->syncRoles($this->chosenRole);

			if ($this->user->hasRole('tactical-lead')) {
				redirect(route('tactical.room', $this->room->id));
			} else {
				redirect(route('negotiation.room', $this->room->id));
			}
		}

		private function getRole($roleId) {}

		private function getRoles():Collection
		{
			return Role::all();
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
				<option value={{ $role->id }}>{{ $role->name }}</option>
			@endforeach
		</select>
	</div>
	<button
			type="submit"
			class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
		Enter Room
	</button>
</form>
