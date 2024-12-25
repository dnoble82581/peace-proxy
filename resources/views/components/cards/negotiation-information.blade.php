@props(['negotiation'])
<div class="overflow-hidden rounded-lg bg-white shadow col-span-6 dark:bg-gray-700">
	<div class="px-4 py-5 sm:p-6">
		<div class="flex gap-5 justify-between">
			<div class="max-w-md flex-1">
				<strong class="text-sm text-gray-600 dark:text-slate-300">Initial Complaint</strong>
				<p class="max-w-prose text-sm text-gray-600 dark:text-slate-300">{{ $negotiation->initial_complaint }}</p>
			</div>
			<div class="text-sm text-gray-600 flex-1 dark:text-slate-300">
				<strong class="block">Subject Motivation</strong>
				<p class="max-w-prose">{{ $negotiation->subject_motivation }}</p>
			</div>

		</div>
	</div>
</div>