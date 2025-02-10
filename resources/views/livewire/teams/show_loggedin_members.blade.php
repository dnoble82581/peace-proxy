<?php

	use App\Models\User;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;

	new class extends Component {
		public Collection $loggedInUsers;
		public User $user;

		public function mount()
		{
			$this->loggedInUsers = $this->getLoggedInUsers();
			$this->user = auth()->user();
		}

		private function getLoggedInUsers()
		{
			$userIds = DB::table(config('session.table'))
				->whereNotNull('user_id') // Ensure only authenticated users
				->distinct()
				->pluck('user_id'); // Get the list of unique user IDs

			// Use Eloquent to fetch user instances
			return User::whereIn('id', $userIds)->get();
		}

		public function refresh()
		{
			$this->loggedInUsers = $this->getLoggedInUsers();
		}

		public function getListeners()
		{
			return [
				"echo-presence:user.{$this->user->tenant_id},UserLoggedInEvent" => 'refresh',
				"echo-presence:user.{$this->user->tenant_id},UserLoggedOutEvent" => 'refresh',
			];
		}
	}

?>

<div>
	<ul
			role="list"
			class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 p-4">
		@forelse($loggedInUsers as $user)
			<li class="col-span-3 divide-y divide-gray-200 rounded-lg bg-white shadow-md">
				<div class="flex w-full items-center justify-between space-x-6 p-6">
					<div class="flex-1 truncate">
						<div class="flex items-center space-x-3">
							<h3 class="truncate text-sm font-medium text-gray-900">{{ $user->name }}</h3>
							<span class="inline-flex shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset">Admin</span>
						</div>
						<p class="mt-1 truncate text-sm text-gray-500">{{ $user->role }}</p>
					</div>
					<img
							class="size-10 shrink-0 rounded-full bg-gray-300"
							src="{{ $user->avatarUrl() }}"
							alt="">
				</div>
				<div>
					<div class="-mt-px flex divide-x divide-gray-200">
						<div class="flex w-0 flex-1 hover:bg-gray-50">
							<a
									href="mailto:janecooper@example.com"
									class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
								<x-heroicons::micro.solid.envelope class="size-5 text-gray-400" />
								Email
							</a>
						</div>
						<div class="flex w-0 flex-1 hover:bg-gray-50">
							<a
									href="mailto:janecooper@example.com"
									class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
								<x-heroicons::micro.solid.chat-bubble-bottom-center-text class="size-5 text-gray-400" />
								Message
							</a>
						</div>
						<div class="-ml-px flex w-0 flex-1 hover:bg-gray-50">
							<a
									href="tel:+1-202-555-0170"
									class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
								<x-heroicons::micro.solid.phone class="size-5 text-gray-400" />
								Call
							</a>
						</div>
					</div>
				</div>
			</li>
		@empty
			<li>No users are currently logged in.</li>
			<!-- More people... -->
		@endforelse
	</ul>
</div>
