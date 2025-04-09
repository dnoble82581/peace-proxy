@props(['message', 'heading' => 'Needs Attention'])
<div class="rounded-md bg-green-50 p-1">
	<div class="flex">
		<div class="shrink-0">
			<x-heroicons::micro.solid.check class="h-5 w-5 text-green-400" />
		</div>
		<div class="ml-3">
			<h3 class="text-xs font-medium text-green-800">{{ $heading }}</h3>
			<div class="text-xs text-green-700">
				<p>{{ $message }}</p>
			</div>
		</div>
	</div>
</div>