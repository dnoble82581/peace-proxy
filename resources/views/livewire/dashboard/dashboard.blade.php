<?php

	use App\Models\User;
	use Illuminate\Support\Collection;

	new class extends \Livewire\Volt\Component {
		public Collection $users;

		public function mount()
		{
			$this->users = User::all();
		}
	}
?>

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
	<div class="grid auto-rows-min gap-4 md:grid-cols-3">
		<div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
			<div class="p-4 text-sm space-y-2">
				<div class="flex items-center justify-between">
					<span>Logged In As:</span>
					<span>{{ auth()->user()->name }}</span>
				</div>
				<div class="flex items-center justify-between">
					<span>Tenant:</span>
					<span>{{ auth()->user()->tenant->tenant_name }}</span>
				</div>
				<div class="flex items-center justify-between">
					<span>Team:</span>
					<span>{{ User::count() }}</span>
				</div>
			</div>
		</div>
		<div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
			<x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
		</div>
		<div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
			<x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
		</div>
	</div>
	<div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">


	</div>
</div>
