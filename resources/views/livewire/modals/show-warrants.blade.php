<div class="p-4 dark:bg-gray-800">
	<div class="border-b border-gray-200 bg-white dark:bg-gray-800 px-4 py-5 sm:px-6">
		<h3 class="text-base font-semibold text-gray-900 dark:text-slate-300">Warrants</h3>
		<p class="mt-1 text-sm text-gray-500 dark:text-slate-300">Lorem ipsum dolor sit amet consectetur adipisicing
		                                                          elit quam corrupti
		                                                          consectetur.</p>
	</div>
	<ul
			role="list"
			class="divide-y divide-gray-100 px-4">

		@foreach($subject->warrants as $warrant)
			<x-cards.warrant-card :warrant="$warrant" />
		@endforeach
	</ul>
</div>


