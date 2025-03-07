<div>
	@if($is_active)
		<p>Your subscription is active.</p>
	@else
		<p>Your subscription has expired.</p>
	@endif

	@if($on_trial)
		<p>You are on a free trial. Ends on {{ $trial_ends_at->toFormattedDateString() }}</p>
	@endif
</div>