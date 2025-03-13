<?php

	use App\Livewire\Actions\Logout;
	use App\Models\Negotiation;
	use App\Models\Tenant;
	use App\Models\User;
	use App\Services\RecordRetrievalService;
	use App\Services\StripeService;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Collection;
	use LaravelIdea\Helper\App\Models\_IH_Negotiation_C;
	use LaravelIdea\Helper\App\Models\_IH_User_C;
	use Livewire\Attributes\Layout;
	use Livewire\Volt\Component;

	new #[Layout('layouts.admin')] class extends Component {
		public Collection $members;
		public User $user;
		public Tenant $tenant;

		public function mount()
		{
			$this->members = $this->fetchMembers();
			$this->user = $this->fetchUser();
			$this->tenant = $this->fetchTenant();
		}

		private function fetchMembers():Collection
		{
			return User::all();
		}

		public function retrieveRecords(Model $model, int $duration)
		{
			$recordRetrievalService = new RecordRetrievalService();
			return $recordRetrievalService->getRecordsWithinTimeFrame($model->query(), $duration)->get();
		}

		private function fetchTenant()
		{
			return auth()->user()->tenant;
		}

		private function fetchUser():User
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
						<x-admin.registered-users />
						<x-admin.new-negotiations />
						<x-admin.new-resolutions />
					</dl>
				</div>
				<div class="grid grid-cols-1 gap-5 mt-10 sm:grid-cols-2 lg:grid-cols-3">
				</div>
			</div>
		</main>
	</div>
</div>

