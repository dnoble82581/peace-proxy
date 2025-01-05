<?php

	use App\Models\Room;
	use Livewire\Volt\Component;

	new class extends Component {
		public Room $room;

		public function mount($roomId)
		{
			$this->room = $this->getRoom($roomId);
		}

		private function getRoom($roomId)
		{
			return Room::findOrFail($roomId);
		}
	}

?>

<div>
	Edit Hostage
</div>
