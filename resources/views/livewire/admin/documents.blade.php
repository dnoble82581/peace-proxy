<?php

	use App\Models\Tenant;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;

	new class extends Component {
		public $documents;
		public Tenant $tenant;

		public function mount()
		{
			$this->tenant = auth()->user()->tenant;
		}

		private function fetchDocuments()
		{
			return $this->tenant->documents();
		}
	}

?>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

	<ul
			role="list"
			class="divide-y divide-gray-200 bg-white p-4 rounded-md shadow-lg">
		@foreach($this->tenant->negotiations as $negotiation)
			<li class="flex justify-between gap-x-6 py-5">
				<div class="flex min-w-0 gap-x-4">
					<img
							class="size-12 flex-none rounded-full bg-gray-50"
							src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
							alt="">
					<div class="min-w-0 flex-auto">
						<p class="text-sm/6 font-semibold text-gray-900">{{ $negotiation->title }}</p>
						<p class="mt-1 truncate text-xs/5 text-gray-500">{{ $negotiation->address }}</p>
					</div>
				</div>
				<div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
					<p class="text-sm/6 text-gray-900">{{ $negotiation->resolution }}</p>
					<p class="mt-1 text-xs/5 text-gray-500">Duration
						<time datetime="2023-01-23T13:23Z">3 days</time>
					</p>
				</div>
			</li>
		@endforeach

	</ul>
</div>

