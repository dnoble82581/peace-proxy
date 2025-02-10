<div>
	<x-form-layouts.form-layout submit="submit">
		<x-slot:header>Risk Assessment</x-slot:header>
		<x-slot:description>
			Suicide risk assessment is not an exact science. This suicide risk assessment is intended to be an indicator
			of relative3 suicide risk during an incident. The scorer should indicate each statement to be True, False,
			or Unknown.
		</x-slot:description>
		<x-slot:actions>
			<x-buttons.primary-button type="submit">Create Form</x-buttons.primary-button>
			<x-buttons.secondary-button
					type="button"
					wire:modal="close">Cancel
			</x-buttons.secondary-button>
		</x-slot:actions>
		@foreach ($questions as $question)
			<div
					class="flex items-center justify-between px-4 pb-2 border-b border-gray-200"
					wire:key="question-{{ $question->id }}">
				<p>{{ $question->id }}. {{ $question->question_text }}</p>
				@if($question->type === 'single-choice')
					<div class="flex items-center space-x-4">
						<!-- Radio option for 'Yes' -->
						<x-radio
								label="Yes"
								wire:model="responses.{{ $question->id }}"
								value="Yes"
								id="q{{ $question->id }}_yes"
								wire:key="option-{{ $question->id }}-yes"
						/>

						<!-- Radio option for 'No' -->
						<x-radio
								label="No"
								wire:model="responses.{{ $question->id }}"
								value="No"
								id="q{{ $question->id }}_no"
								wire:key="option-{{ $question->id }}-no"
						/>
					</div>
				@else
					<input
							type="text"
							wire:model="responses.{{ $question->id }}"
							placeholder="Your answer"
							wire:key="response-{{ $question->id }}"
					/>
				@endif
			</div>
		@endforeach

	</x-form-layouts.form-layout>
</div>
