@props(['negotiation'])
<li class="relative flex justify-between gap-x-6 px-4 py-5 sm:px-6 lg:px-8">
	<div class="flex-1 min-w-0 gap-x-4">
		<div class="min-w-0 flex-auto">
			<p class="text-sm/6 font-semibold text-gray-900 dark:text-slate-300">
				<a
						class="capitalize"
						href="#">
					{{ $negotiation->title }}
					<span class="text-xs text-gray-500">({{ $negotiation->rooms()->count() }})</span>
				</a>
			</p>
			<p class="mt-1 flex text-xs/5 text-gray-500">
								<span
										class="relative truncate hover:underline">{{ $negotiation->address }}</span>
			</p>
		</div>
	</div>
	<div class="flex-1">
		<p class="text-sm/6 font-semibold text-gray-900 dark:text-slate-300">Initial
		                                                                     complaint</p>
		<p class="mt-1 flex text-xs/5 text-gray-500">{{ $negotiation->initial_complaint }}</p>
	</div>
	<div class="flex shrink-0 items-center gap-x-4">
		<div class="hidden sm:flex sm:flex-col sm:items-end">
			<p class="text-sm/6 text-gray-900 dark:text-slate-300 block">{{ $negotiation->subject_name }}</p>
			<p class="mt-1 text-xs/5 text-gray-500 block">Last seen
				<time datetime="2023-01-23T13:23Z">3h ago</time>
			</p>
		</div>
		<button @click="open = !open">
			<svg
					class="size-5 flex-none text-gray-400"
					:class="open ? 'rotate-90 transition-transform duration-300' : 'transition-transform duration-300'"
					viewBox="0 0 20 20"
					fill="currentColor"
					aria-hidden="true"
					data-slot="icon">
				<path
						fill-rule="evenodd"
						d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
						clip-rule="evenodd" />
			</svg>
		</button>
	</div>
</li>