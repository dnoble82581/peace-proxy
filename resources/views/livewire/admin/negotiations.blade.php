<?php

	use App\Models\Negotiation;
	use App\Models\Tenant;
	use App\Models\User;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;

	new class extends Component {
		public Tenant $tenant;

		public function mount($tenantId):void
		{
			$this->tenant = $this->fetchTenant($tenantId);
		}

		private function fetchTenant($tenantId):Tenant
		{
			return Tenant::findOrFail($tenantId);
		}
	}
?>

<div>
	<ul
			role="list"
			class="divide-y divide-gray-200 px-8">
		@foreach ($tenant->negotiations as $negotiation)
			<x-cards.admin.negotiations-list-card :negotiation="$negotiation" />
		@endforeach
	</ul>
</div>
