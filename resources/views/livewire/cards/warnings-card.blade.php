<?php

	use App\Models\Subject;
	use Livewire\Volt\Component;

	new class extends Component {
		public Subject $subject;

		public function mount($subject):void
		{
			$this->subject = $subject->load('warnings');
		}

		public function addWarning():void
		{
			$this->dispatch('modal.open', component: 'modals.create-warning-form',
				arguments: ['roomId' => $this->subject->room_id]);
		}
	}
?>

<div>
	<div class="flex justify-end px-4 mt-2">
		<button wire:click="addWarning">
			<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
		</button>
	</div>
	<div class="px-4 sm:px-6 lg:px-8">
		<div class="mt-3 flow-root">
			<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
				<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
					@if($subject->warnings->count())
						<ul
								role="list"
								class="divide-y divide-gray-200 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
							@foreach($subject->warnings as $warning)
								<li class="col-span-1 sm:col-span-2 flex rounded-md shadow-sm">
									<div class="flex w-16 shrink-0 items-center justify-center rounded-l-md bg-pink-600 text-sm font-medium text-white">
										MH
									</div>
									<div class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
										<div class="flex-1 truncate px-4 py-2 text-sm">
											<a
													href="#"
													class="font-medium text-gray-900 hover:text-gray-600">Mental
											                                                              Health</a>
											<p class="text-gray-500">Subject Is Bi-Polar</p>
										</div>
										<div class="shrink-0 pr-2">
											<button
													type="button"
													class="inline-flex size-8 items-center justify-center rounded-full bg-transparent bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
												<span class="sr-only">Open options</span>
												<svg
														class="size-5"
														viewBox="0 0 20 20"
														fill="currentColor"
														aria-hidden="true"
														data-slot="icon">
													<path d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
												</svg>
											</button>
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					@else
						<div class="">
							<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Warnings</h3>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
