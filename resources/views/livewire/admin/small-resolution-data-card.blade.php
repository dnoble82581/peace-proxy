<?php

	use App\Models\ResolutionResponse;
	use App\Models\Tenant;
	use Livewire\Volt\Component;

	new class extends Component {
		public Tenant $tenant;

		public function mount(Tenant $tenant):void
		{
			$this->tenant = $tenant;
		}
	}

?>

<div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow-sm sm:px-6 sm:pt-6">
	<dt>
		<div class="absolute rounded-md bg-indigo-500 p-3">
			<x-heroicons::outline.users class="text-white size-6" />
		</div>
		<p class="ml-16 truncate text-sm font-medium text-gray-500">Resolutions</p>
	</dt>
	<dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
		<p class="text-2xl font-semibold text-gray-900">{{ $tenant->resolutions()->count() }}</p>
		<div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
			<div class="text-sm">
				<a
						href="#"
						class="font-medium text-indigo-600 hover:text-indigo-500">View
				                                                                  all<span class="sr-only"> Avg. Click Rate stats</span></a>
			</div>
		</div>
	</dd>
</div>
