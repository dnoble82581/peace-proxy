<?php

	use App\Models\Tenant;
	use Carbon\Carbon;
	use Livewire\Volt\Component;

	new class extends Component {
		public Tenant $tenant;
		public ?string $currentPlan = null;
		public ?string $nextBillingDate = null;
		public ?float $nextBillingAmount = null;


		public function mount($tenant)
		{
			$this->tenant = $tenant;

			$subscription = $tenant->subscription(); // Replace 'default' with the subscription name you use

			if ($subscription) {
				// Get the current plan
				$this->currentPlan = $subscription->stripe_price;

				// Fetch the Stripe subscription to retrieve additional details
				$stripeSubscription = $subscription->asStripeSubscription();

				// Next billing date
				$this->nextBillingDate = Carbon::createFromTimestamp($stripeSubscription->current_period_end)->toDateString();

				// Next billing amount
				$this->nextBillingAmount = $this->getUpcomingInvoiceTotal($tenant);
			} else {
				$this->currentPlan = 'No active subscription';
				$this->nextBillingDate = null;
				$this->nextBillingAmount = null;
			}


		}

		private function getUpcomingInvoiceTotal(Tenant $tenant):?float
		{
			try {
				// Get the upcoming invoice from Stripe
				$stripeInvoice = $tenant->upcomingInvoice();
				return optional($stripeInvoice)->total / 100; // Convert cents to dollars
			} catch (Exception $e) {
				// Handle any errors (e.g., no upcoming invoice exists or Stripe error)
				return null;
			}
		}
	}

?>

<div class="p-4">
	<div class="grid grid-cols-1 sm:grid-cols-6 lg:grid-cols-12 gap-4">
		<div class="col-span-4 bg-[#1a1a1b] p-4 text-[#dddddd] rounded-lg">
			<p class=" font-semibold text-sm pb-4">Subscription Information</p>
			<div class="flex items-center justify-between text-sm border-b border-b-gray-300 py-2 px-2">
				<p>Current Plan</p>
				<p>{{ $currentPlan }}</p>
			</div>
			<div class="flex items-center justify-between text-sm border-b border-b-gray-300 py-2 px-2">
				<p>Next Billing Date</p>
				<p>{{ $nextBillingDate ?? 'N/A' }}</p>
			</div>
			<div class="flex items-center justify-between text-sm border-b border-b-gray-300 py-2 px-2">
				<p>Next Billing Amount</p>
				<p>{{ $nextBillingAmount ? '$' . number_format($nextBillingAmount, 2) : 'N/A' }}</p>
			</div>
			<div class="flex items-center justify-between mb-8 text-sm border-b border-b-gray-300 py-2 px-2">
				<p>Payment Method</p>
				<p>{{ $tenant->pm_type ?: 'N/A' }}</p>
			</div>
			<div class="text-sm py-2 px-2 mt-auto flex justify-end">
				<a
						href="https://billing.stripe.com/p/login/test_4gwbKXeE14AR9Ow6oo"
						target="_blank"
						class="bg-indigo-500 font-semibold px-2 py-1 rounded-md">Edit Subscription</a>
			</div>
		</div>
		<div class="col-span-4 flex flex-col bg-[#1a1a1b] p-4 text-[#dddddd] rounded-lg">
			<p class=" font-semibold text-sm pb-4">Billing Information</p>
			<div class="flex items-center justify-between text-sm border-b border-b-gray-300 py-2 px-2">
				<p>Tenant</p>
				<p>{{ $tenant->tenant_name }}</p>
			</div>
			<div class="flex items-center justify-between text-sm border-b border-b-gray-300 py-2 px-2">
				<p>Address</p>
				<div class="">
					<p class="text-right">{{ $tenant->address_line1 }}</p>
					<p>{{ $tenant->address_line2 }}</p>
					<p>{{ $tenant->address_city }} , {{ $tenant->address_state }}
						{{ $tenant->address_postal_code }} {{ $tenant->address_country }}</p>
				</div>
			</div>
			<div class="flex items-center justify-between text-sm border-b border-b-gray-300 py-2 px-2">
				<p>Phone</p>
				<p>{{ $tenant->primary_phone }}</p>
			</div>
			<div class="flex items-center justify-between mb-4 text-sm border-b border-b-gray-300 py-2 px-2">
				<p>Email</p>
				<p>{{ $tenant->tenant_email }}</p>
			</div>
			<div class="text-sm py-2 px-2 flex mt-auto justify-end">
				<a
						href="#"
						target="_blank"
						class="bg-indigo-500 font-semibold px-2 py-1 rounded-md">Edit Tenant</a>
			</div>
		</div>
	</div>
</div>
