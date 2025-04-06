<?php

	use App\Models\User;
	use Livewire\Volt\Component;
	use App\Notifications\FlashMessageNotification;

	new class extends Component {
		public User $user;
		public bool $flashMessage = false;
		public string $message = '';

		public function mount($user):void
		{
			$this->user = $user;
		}

		public function getListeners():array
		{
			return [
				"echo-private:user.{$this->user->id},InvitationAcceptedEvent" => 'handleFlashMessage',
			];
		}

		public function handleFlashMessage($event):void
		{
			$invitee = User::findOrFail($event['invitee_id']);

			if ($event['inviter_id'] === $this->user->id) {
				$this->message = $invitee->name.'Accepted your invitation!';
				$this->flashMessage = true;

				$this->dispatch('clearFlashMessageAfterDelay');
			}
		}

		public function clearFlashMessageAfterDelay():void
		{
			// Wait for 5 seconds before hiding the flash message
			usleep(5000000); // 5 seconds in microseconds
			$this->flashMessage = false;
		}


	}


?>

<div>
	<div
			x-cloak
			x-data="{ show: @entangle('flashMessage'), timeout: null }"
			x-init="$watch('show', value => {
            if (value) {
                clearTimeout(timeout); // Clear any previous timers
                timeout = setTimeout(() => show = false, 5000);
            }
        })"
			x-show="show"
			x-transition:enter="transition ease-out duration-300"
			x-transition:enter-start="opacity-0"
			x-transition:enter-end="opacity-100"
			x-transition:leave="transition ease-in duration-500"
			x-transition:leave-start="opacity-100"
			x-transition:leave-end="opacity-0"
			class="rounded-md bg-green-50 p-2">
		<div class="flex">
			<div class="shrink-0">
				<svg
						class="size-5 text-green-400"
						viewBox="0 0 20 20"
						fill="currentColor"
						aria-hidden="true"
						data-slot="icon">
					<path
							fill-rule="evenodd"
							d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
							clip-rule="evenodd" />
				</svg>
			</div>
			<div class="ml-3">
				<p class="text-sm font-medium text-green-800">{{ $message }}</p>
			</div>
		</div>
	</div>


</div>
