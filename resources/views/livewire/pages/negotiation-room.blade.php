<?php

	use App\Models\Room;
	use Illuminate\Support\Facades\Redis;
	use Livewire\Attributes\Computed;
	use Livewire\Attributes\Layout;
	use Livewire\Volt\Component;

	new #[layout('layouts.negotiation')] class extends Component {
		public Room $room;

		#[Computed]
		public function objectivesCount()
		{
			return $this->room->negotiation->objectives->count();
		}

		public function updateObjectivesCount():void
		{
			$this->room->load('negotiation.objectives'); // Reload the objectives relationship
		}


		public function mount($room):void
		{
			$this->room = Room::with([
				'messages:id,message,created_at,room_id,user_id,updated_at,to_primary,to_tactical,emergency,important',
				// Fetch necessary columns
				'messages.user:id,name', // Fetch user data for each message
				'subject:id,name,address,city,state,zip,phone,tenant_id,room_id,facebook_url,x_url,instagram_url,snapchat_url,youtube_url,weapons,weapons_details',
				'subject.demands:id,subject_id,tenant_id,type,deadline,description,title,status,notes',
				'subject.moodLogs:id,subject_id,tenant_id,mood,name,created_at',
				'subject.callLogs',
				'subject.warnings:id,subject_id,user_id,tenant_id,room_id,warning_type,warning',
				'subject.documents:id,subject_id,filename,size,updated_at,extension',
			])->findOrFail($room->id);

			if (auth()->user()->cannot('view', $room)) {
				abort(403, 'Sorry, You are not authorized to view this room.');
			}

			Redis::set('room_id', $room->id);
		}

	}

?>

<div class="pt-4 overflow-hidden pb-8 px-4">
	<div class="flex items-center gap-3">
		<div class="flex-1">
			<livewire:negotiations.negotiation-subject
					:room="$room" />
		</div>

		<div class="flex-1">
			<livewire:negotiations.negotiation-information
					:room="$room" />
		</div>
	</div>
	<!-- Chat Menu -->
	<div class="grid grid-cols-12 gap-4 mt-4">
		<x-navigation.tab-navigation
				container-class="sm:col-span-3 bg-white"
				:tabs="[
                    ['key' => 'public', 'label' => 'Public'],
                    ['key' => 'private', 'label' => 'Private'],
                    ['key' => 'tactical', 'label' => 'Tactical'],
                ]"
				:default-tab="'public'">

			<div x-show="tab === 'public'">
				<livewire:negotiations.negotiation-chat :room="$room" />
			</div>
			<div x-show="tab === 'private'">
				Private Content
			</div>
			<div x-show="tab === 'tactical'">
				Tactical Content
			</div>
		</x-navigation.tab-navigation>

		<x-navigation.tab-navigation
				container-class="sm:col-span-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg"
				:tabs="[
                    ['key' => 'board', 'label' => 'Board'],
                    ['key' => 'objectives', 'label' => 'Objectives('.$this->objectivesCount().')'],
                ]"
				:default-tab="'board'">

			<div x-show="tab === 'board'">
				<div class="space-y-4 max-h-[610px] overflow-y-auto sticky top-0 overflow-x-hidden">
					<livewire:negotiations.negotiation-hooks :room="$room" />
					<livewire:negotiations.negotiation-triggers :room="$room" />
					<livewire:negotiations.negotiation-demands :room="$room" />
					<livewire:negotiations.negotiation-associate :room="$room" />
				</div>
			</div>
			<div x-show="tab === 'objectives'">
				<livewire:cards.objectives-card
						:negotiationId="$this->room->negotiation_id"
						:roomId="$this->room->id" />
			</div>
		</x-navigation.tab-navigation>

		<x-navigation.tab-navigation
				container-class="col-span-3 max-h-[690px] overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow-lg"
				:tabs="[
                    ['key' => 'charts', 'label' => 'Charts'],
                    ['key' => 'lies', 'label' => 'Lies'],
                ]"
				:default-tab="'charts'">

			<div x-show="tab === 'charts'">
				<div class="mt-4">
					<div>
						<livewire:charts.mood-log-chart :room="$room" />
					</div>
					<div>
						<livewire:charts.call-log-chart :room="$room" />
					</div>
				</div>
			</div>
			<div x-show="tab === 'lies'">
				Lies information here
			</div>
		</x-navigation.tab-navigation>
	</div>
</div>
