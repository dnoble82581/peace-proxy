@props(['room', 'roles', 'chosenRole'])
<li
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="opacity-0 scale-95"
		x-transition:enter-end="opacity-100 scale-100"
		x-transition:leave="transition ease-in duration-75"
		x-transition:leave-start="opacity-100 scale-100"
		x-transition:leave-end="opacity-0 scale-95"
		x-show="open"
		class="relative flex justify-between gap-x-6 px-4 py-5 sm:px-6 lg:px-8 bg-gray-100 dark:bg-gray-600 rounded shadow">
	<div class="flex min-w-0 gap-x-4">
		<div class="min-w-0 flex-auto">
			<p class="text-sm/6 font-semibold text-gray-900 dark:text-slate-300">
				<span>
					Room {{ $room->id }}
				</span>
			</p>
			<p class="mt-1 flex text-xs/5 text-gray-500">
				<a
						href="mailto:leslie.alexander@example.com"
						class="relative truncate hover:underline dark:text-slate-300">leslie.alexander@example.com</a>
			</p>
		</div>
	</div>
	<livewire:forms.enter-room-form :room="$room" />
</li>