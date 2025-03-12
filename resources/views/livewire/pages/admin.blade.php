<?php

	use App\Livewire\Actions\Logout;
	use App\Models\Negotiation;
	use App\Models\Tenant;
	use App\Models\User;
	use App\Services\StripeService;
	use Illuminate\Support\Collection;
	use LaravelIdea\Helper\App\Models\_IH_Negotiation_C;
	use LaravelIdea\Helper\App\Models\_IH_User_C;
	use Livewire\Attributes\Layout;
	use Livewire\Volt\Component;

	new #[Layout('layouts.admin')] class extends Component {
		public Collection $members;
		public User $user;

		public function mount()
		{
			$this->members = $this->fetchMembers();
			$this->user = $this->fetchUser();
		}

		private function fetchMembers():Collection
		{
			return User::all();
		}

		private function fetchUser()
		{
			return auth()->user();
		}

		public function logout(Logout $logout):void
		{
			$logout();
			$this->redirect('/', navigate: true);
		}
	};
?>


<div>
	@include('pages.partials.admin._responsive-sidebar')
	@include('pages.partials.admin._static-sidebar')

	<div class="lg:pl-72">
		@include('pages.partials.admin._admin-top-nav')


		<main class="py-10">
			<div class="px-4 sm:px-6 lg:px-8">
				<div>
					<h3 class="text-base font-semibold text-gray-900">Last 30 days</h3>

					<dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
						<div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow-sm sm:px-6 sm:pt-6">
							<dt>
								<div class="absolute rounded-md bg-indigo-500 p-3">
									<x-heroicons::outline.users class="size-6 text-white" />
								</div>
								<p class="ml-16 truncate text-sm font-medium text-gray-500">Total Subscribers</p>
							</dt>
							<dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
								<p class="text-2xl font-semibold text-gray-900">{{ $this->members->count() }}</p>
								<p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
									<x-heroicons::micro.solid.arrow-long-up class="size-5 shrink-0 self-center text-green-500" />
									<span class="sr-only"> Increased by </span>
									122
								</p>
								<div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
									<div class="text-sm">
										<a
												href="#"
												class="font-medium text-indigo-600 hover:text-indigo-500">View
										                                                                  all<span class="sr-only"> Total Subscribers stats</span></a>
									</div>
								</div>
							</dd>
						</div>
						<div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow-sm sm:px-6 sm:pt-6">
							<dt>
								<div class="absolute rounded-md bg-indigo-500 p-3">
									<svg
											class="size-6 text-white"
											fill="none"
											viewBox="0 0 24 24"
											stroke-width="1.5"
											stroke="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												stroke-linecap="round"
												stroke-linejoin="round"
												d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
									</svg>
								</div>
								<p class="ml-16 truncate text-sm font-medium text-gray-500">Avg. Open Rate</p>
							</dt>
							<dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
								<p class="text-2xl font-semibold text-gray-900">58.16%</p>
								<p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
									<svg
											class="size-5 shrink-0 self-center text-green-500"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.29 9.77a.75.75 0 0 1-1.08-1.04l5.25-5.5a.75.75 0 0 1 1.08 0l5.25 5.5a.75.75 0 1 1-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0 1 10 17Z"
												clip-rule="evenodd" />
									</svg>
									<span class="sr-only"> Increased by </span>
									5.4%
								</p>
								<div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
									<div class="text-sm">
										<a
												href="#"
												class="font-medium text-indigo-600 hover:text-indigo-500">View
										                                                                  all<span class="sr-only"> Avg. Open Rate stats</span></a>
									</div>
								</div>
							</dd>
						</div>
						<div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow-sm sm:px-6 sm:pt-6">
							<dt>
								<div class="absolute rounded-md bg-indigo-500 p-3">
									<svg
											class="size-6 text-white"
											fill="none"
											viewBox="0 0 24 24"
											stroke-width="1.5"
											stroke="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												stroke-linecap="round"
												stroke-linejoin="round"
												d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
									</svg>
								</div>
								<p class="ml-16 truncate text-sm font-medium text-gray-500">Avg. Click Rate</p>
							</dt>
							<dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
								<p class="text-2xl font-semibold text-gray-900">24.57%</p>
								<p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">
									<svg
											class="size-5 shrink-0 self-center text-red-500"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M10 3a.75.75 0 0 1 .75.75v10.638l3.96-4.158a.75.75 0 1 1 1.08 1.04l-5.25 5.5a.75.75 0 0 1-1.08 0l-5.25-5.5a.75.75 0 1 1 1.08-1.04l3.96 4.158V3.75A.75.75 0 0 1 10 3Z"
												clip-rule="evenodd" />
									</svg>
									<span class="sr-only"> Decreased by </span>
									3.2%
								</p>
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
					</dl>
				</div>
			</div>
		</main>
	</div>
</div>

