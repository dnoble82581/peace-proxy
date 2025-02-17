<?php

	use App\Models\Subject;
	use Livewire\Volt\Component;
	use function Livewire\Volt\{state};

	new class extends Component {
		public Subject $subject;

		public function mount($subject)
		{
			$this->subject = $subject;
		}
	}

?>


<div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-4 p-3">
	@foreach ($subject->socialMediaProviders as $social)
		<p>{{ $social->platform_name }}</p>
	@endforeach
</div>

