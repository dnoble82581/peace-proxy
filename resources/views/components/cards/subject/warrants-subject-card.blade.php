@props(['subject'])
<div class="px-4 sm:px-6 lg:px-8">
	<div class="mt-3 flow-root">
		<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
			<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
				@if($subject->warrants->count())
					<x-table-elements.subject-card-table-layout
							:labels="['Offense', 'Originating County', 'Originating State', 'Extraditable', 'Action']">
						@foreach($subject->warrants as $warrant)
							<a href="#">
								<x-table-elements.subject-warrants-row :warrant="$warrant" />
							</a>
						@endforeach
					</x-table-elements.subject-card-table-layout>
				@else
					<div class="h-full">
						<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Warrants</h3>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>