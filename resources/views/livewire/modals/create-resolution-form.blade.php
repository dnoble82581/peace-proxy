<div>
	<x-form-layouts.form-layout
			class="p-4"
			submit="saveResolutionPlan">
		<x-slot:header>Create Resolution Plan</x-slot:header>
		<x-slot:description>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto consectetur dolores
		                    doloribus eius est fugiat inventore, ipsa maxime minima minus modi non nostrum quo similique
		                    voluptate. Eos impedit quibusdam soluta.
		</x-slot:description>
		<x-slot:actions>
			<x-buttons.primary-button>Create</x-buttons.primary-button>
			<x-buttons.secondary-button wire:click="cancel">Cancel</x-buttons.secondary-button>
		</x-slot:actions>
		<div
				x-data="{ showText: false }"
				class="grid grid-cols-2 gap-4">
			@foreach ($this->questions as $question)
				<div class="mb-4">
					<p class="text-lg mb-2 font-semibold">{{ $question->question_text }}</p>

					@switch($question->type)
						@case('single-choice')
							@if (!empty($question->options))
								@if($question['text'] === 'Was an Interpreter Used?')
									@foreach ($question->options as $option)
										<div>
											<x-radio
													name="responses[{{ $question->id }}]"
													wire:model="responses.{{ $question->id }}"
													value="{{ $option['text'] }}"
													:label="$option['text']" />
										</div>
									@endforeach
								@endif
								@foreach ($question->options as $option)
									<div>
										<x-radio
												name="responses[{{ $question->id }}]"
												wire:model="responses.{{ $question->id }}"
												value="{{ $option['text'] }}"
												:label="$option['text']" />
									</div>
								@endforeach
							@else
								<p class="text-sm text-gray-500">No options available for this question.</p>
							@endif
							@break
						@case('multiple-choice')
							@if (!empty($question->options))
								@foreach ($question->options as $option)
									<div>
										<x-radio
												wire:model="responses.{{ $question->id }}.{{ $loop->index }}"
												value="{{ $option['text'] }}"
												:label="$option['text']" />
									</div>
								@endforeach
							@else
								<p class="text-sm text-gray-500">No options available for this question.</p>
							@endif
							@break

						@case('text')
							<x-input
									x-show="showText"
									name="responses[{{ $question->id }}]"
									class="w-full"
									wire:model="responses.{{ $question->id }}"
									placeholder="Your response" />
							@break
						@default
							<p class="text-sm text-red-500">Unsupported question type.</p>
					@endswitch
				</div>
			@endforeach
		</div>
	</x-form-layouts.form-layout>
</div>
