<?php

	use App\Models\User;
	use Livewire\Volt\Component;
	use App\Notifications\FlashMessageNotification;

	new class extends Component {
		public User $user;
		public bool $flashMessage = false;
		public string $type = '';
		public string $message = '';
		public string $heading = '';

		public function mount($user):void
		{
			$this->user = $user;
		}

		public function getListeners():array
		{
			return [
				"echo-private:user.{$this->user->id},InvitationAcceptedEvent" => 'handleFlashMessage',
				"echo-private:user.{$this->user->id},InvitationDeclinedToInviterEvent" => 'handleFlashMessage',
				"echo-private:user.{$this->user->id},InvitationDeclinedToInviteeEvent" => 'handleFlashMessage',
				"echo-private:user.{$this->user->id},InvitationSentToInviteeEvent" => 'handleFlashMessage',
				"echo-private:user.{$this->user->id},InvitationSentToInviterEvent" => 'handleFlashMessage',
				"echo-private:user.{$this->user->id},UserLeavesPrivateChatEvent" => 'handleFlashMessage',
			];
		}

		public function handleFlashMessage($event):void
		{
			if ($event['status'] === 'accepted') {
				$this->acceptedInvitation($event);
			} elseif ($event['status'] === 'declined') {
				$this->declinedInvitation($event);
			} elseif ($event['type'] === 'Invitation Sent') {
				$this->invitationSentToInviter($event);
			} elseif ($event['type'] === 'Invitation Received') {
				$this->invitationSentToInvitee($event);
			} elseif ($event['type'] === 'User Left Chat') {
				$this->userLeftChat($event);
			}
		}

		public function declinedInvitation($event):void
		{
			$this->message = $event['message'];
			$this->flashMessage = true;
			$this->type = 'info';
			$this->heading = 'Invitation Declined';

			$this->dispatch('clearFlashMessageAfterDelay');
		}

		public function acceptedInvitation($event):void
		{
			$invitee = User::findOrFail($event['invitee_id']);

			if ($event['inviter_id'] === $this->user->id) {
				$this->message = $invitee->name.' Accepted your invitation!';
				$this->flashMessage = true;
				$this->type = 'success';
				$this->heading = 'Invitation Accepted';

				$this->dispatch('clearFlashMessageAfterDelay');
			}
		}

		public function invitationSentToInvitee($event):void
		{
			$inviter = User::find($event['invitee_id']);

			$this->message = $event['message'];
			$this->flashMessage = true;
			$this->type = 'info';
			$this->heading = 'Invitation Received';

			$this->dispatch('clearFlashMessageAfterDelay');
		}

		public function invitationSentToInviter($event):void
		{
			$invitee = User::findOrFail($event['inviter_id']);

			$this->message = $event['message'];
			$this->flashMessage = true;
			$this->type = 'info';
			$this->heading = 'Invitation Sent';

			$this->dispatch('clearFlashMessageAfterDelay');
		}

		public function userLeftChat($event)
		{
			$this->message = $event['message'];
			$this->flashMessage = true;
			$this->type = 'info';
			$this->heading = 'User Left Chat';
		}

		function clearFlashMessageAfterDelay():void
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
			class="rounded-md">
		@if ($type === 'info')
			<x-alerts.information-alert
					:message="$message"
					:heading="$heading" />
		@elseif($type === 'success')
			<x-alerts.success-alert
					:message="$message"
					:heading="$heading" />
		@endif
	</div>


</div>
