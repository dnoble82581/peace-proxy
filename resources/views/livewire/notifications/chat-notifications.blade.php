<?php

	use App\Events\InvitationAcceptedEvent;
	use App\Events\InvitationDeclinedEvent;
	use App\Events\InvitationSent;
	use App\Models\Invitation;
	use App\Models\Room;
	use App\Models\User;
	use App\Services\ConversationService;
	use App\Services\InvitationService;
	use Illuminate\Database\Eloquent\Collection;
	use LaravelIdea\Helper\App\Models\_IH_User_C;
	use Livewire\Volt\Component;

	new class extends Component {
		public Collection $pendingInvitations;
		public User $user;

		public function mount():void
		{
			$this->user = auth()->user();
			$this->pendingInvitations = $this->fetchPendingInvitations();
		}

		private function getRoom($roomId):Room
		{
			return Room::findOrFail($roomId);
		}

		public function getListeners():array
		{
			return [
				'echo-private:user.'.auth()->id().',InvitationSent' => 'refreshInvitations',
				'echo-private:user.'.auth()->id().',InvitationDeclinedEvent' => 'refreshInvitations',
				'echo-private:user.'.auth()->id().',InvitationAcceptedEvent' => 'handleInvitationAccepted',
			];
		}

		public function refreshInvitations():void
		{
			// Refresh the pending invitations
			$this->pendingInvitations = $this->fetchPendingInvitations();
		}

		public function handleInvitationAccepted($data):void
		{
			$this->dispatch('invitationAccepted', $data);
			$this->refreshInvitations();
		}

		private function createConversation(Invitation $invitation):void
		{
			$conversationService = new ConversationService();
			$conversationService->createConversation($invitation, 'private');
		}

		public function fetchPendingInvitations():Collection
		{
			$invitationService = new InvitationService();
			return $invitationService->fetchPendingInvitations($this->user);
		}

		public function acceptInvitation($invitationId):void
		{
			$invitation = Invitation::findOrFail($invitationId);
			$invitationService = new InvitationService();
			$invitationService->acceptInvitation($invitation->token);
			event(new InvitationAcceptedEvent($invitation));
		}

		public function declineInvitation($invitationId):void
		{
			$invitation = Invitation::findOrFail($invitationId);
			$invitationService = new InvitationService();
			$invitationService->declineInvitation($invitation);
		}

	}
?>
<div>
	<x-dropdown.dropdown>
		<x-slot:trigger>
			<button
					type="button"
					class="inline-flex items-center justify-center rounded-lg transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
				<x-heroicons::outline.chat-bubble-left class="h-5 w-5" />
			</button>
		</x-slot:trigger>
		<x-slot:content>
			@if($this->pendingInvitations->count())
				@foreach($this->pendingInvitations as $invitation)
					<div class="p-2">
						<span class="text-sm block">Invitation to: {{ $invitation->invitation_type ?: 'private' }} by </span>
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
			@else
				<span class="px-2 text-sm text-gray-500">No Pending Invitations</span>
			@endif
		</x-slot:content>
	</x-dropdown.dropdown>

	@if ($pendingInvitations->count())
		<div class="bg-rose-400 bg-opacity-80 rounded-full font-semibold text-[10px] h-[10px] w-[10px] absolute flex items-center justify-center -top-2 -left-1 p-2 text-white">
			{{ $pendingInvitations->count() }}
		</div>
	@endif
</div>


