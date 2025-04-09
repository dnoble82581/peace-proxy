@props(['message', 'heading' => 'Needs Attention'])
<div class="rounded-md bg-blue-50 p-1">
	<div class="flex">
		<div class="shrink-0">
			<svg
					class="size-5 text-blue-400"
					viewBox="0 0 20 20"
					fill="currentColor"
					aria-hidden="true"
					data-slot="icon">
				<path
						fill-rule="evenodd"
						d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
						clip-rule="evenodd" />
			</svg>
		</div>
		<div class="ml-3">
			<h3 class="text-xs font-medium text-blue-800">{{ $heading }}</h3>
			<div class="text-xs text-blue-700">
				<p>{{ $message }}</p>
			</div>
		</div>
	</div>
</div>