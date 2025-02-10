<?php

	use Livewire\Volt\Component;

	new class extends Component {

		public function addRfi()
		{
			dd('here');
		}
	}

?>

<div>
	<x-buttons.add-button onClick="addRfi" />
</div>
