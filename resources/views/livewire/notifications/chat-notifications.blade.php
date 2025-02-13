<?php

	use App\Events\InvitationDeclinedEvent;
	use App\Events\InvitationSent;
	use App\Models\Invitation;
	use App\Models\Room;
	use App\Models\User;
	use App\Services\ConversationService;
	use App\Services\InvitationService;
	use Illuminate\Database\Eloquent\Collection;
	use Livewire\Volt\Component;

	new class extends Component {
		public Collection $pendingInvitations;
		public Room $room;

		public function mount($roomId):void
		{
			$this->room = $this->getRoom($roomId);
			$this->pendingInvitations = $this->fetchPendingInvitations();
		}

		private function getRoom($roomId)
		{
			return Room::findOrFail($roomId);
		}

		public function getListeners():array
		{
			return [
				'echo-private:user.'.auth()->id().',InvitationSent' => 'refreshInvitations',
				'echo-private:user.'.auth()->id().',InvitationDeclinedEvent' => 'refreshInvitations',
				'echo-private:user.'.auth()->id().',InvitationAcceptedEvent' => 'refreshInvitations',
			];
		}

		public function refreshInvitations():void
		{
			// Refresh the pending invitations
			$this->pendingInvitations = $this->fetchPendingInvitations();
		}

		public function fetchPendingInvitations():Collection
		{
			$invitationService = new InvitationService();
			return $invitationService->fetchPendingInvitations();
		}

		public function acceptInvitation($invitationId):void
		{
			$invitation = Invitation::findOrFail($invitationId);
			$invitationService = new InvitationService();
			$invitationService->acceptInvitation($invitation, $this->room->id);
		}

		public function declineInvitation($invitationId):void
		{
			$invitation = Invitation::findOrFail($invitationId);
			$invitationService = new InvitationService();
			$invitationService->declineInvitation($invitation);
		}

	}
?>
<div class="inline-flex relative">
	@if ($pendingInvitations->count())
		<div class="bg-rose-400 bg-opacity-80 rounded-full font-semibold text-[10px] h-[10px] w-[10px] absolute flex items-center justify-center -top-2 -left-4 p-2 text-white">
			{{ $pendingInvitations->count() }}
		</div>
	@endif
	<x-dropdown.dropdown width="52">
		<x-slot:trigger>
			<button>
				<x-heroicons::outline.chat-bubble-left-right class="w-5 h-5 text-gray-500" />
			</button>
		</x-slot:trigger>
		<x-slot:content>
			@if(!$pendingInvitations->count())
				<div class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
					No Pending Invitations
				</div>
			@else
				@foreach ($pendingInvitations as $invitation)
					<div class="p-2">
						<span class="text-sm block">Invitation to: {{ $invitation->conversation ? $invitation->conversation->type : 'private' }} By </span>
						<span class="block text-xs">{{ $invitation->inviter->name }}</span>
						<hr class="my-2">
						<div class="flex justify-between text-sm mt-3">
							<x-buttons.small-primary
									class="bg-indigo-400 hover:bg-indigo-500"
									wire:click="acceptInvitation({{ $invitation->id }})">Accept
							</x-buttons.small-primary>
							<x-buttons.small-primary
									wire:click="declineInvitation({{ $invitation->id }})"
									class="bg-gray-400 hover:bg-gray-500">Decline
							</x-buttons.small-primary>
						</div>
					</div>
				@endforeach
			@endif
		</x-slot:content>
	</x-dropdown.dropdown>

</div>


