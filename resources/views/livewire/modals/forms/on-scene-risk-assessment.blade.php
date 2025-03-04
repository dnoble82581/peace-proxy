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
					wire:key="question-{{ $question->id }}"
					role="group"
					aria-labelledby="question-label-{{ $question->id }}"
			>
				<p id="question-label-{{ $question->id }}">{{ $question->id }}. {{ $question->question_text }}</p>

				@if($question->type === 'single-choice')
					<div class="flex items-center space-x-4">
						<!-- Radio option for 'Yes' -->
						<div>
							<label for="q{{ $question->id }}_yes">Yes</label>
							<input
									type="radio"
									id="q{{ $question->id }}_yes"
									name="question-{{ $question->id }}"
									wire:model.live="responses.{{ $question->id }}"
									value="Yes"
							/>
						</div>

						<!-- Radio option for 'No' -->
						<div>
							<label for="q{{ $question->id }}_no">No</label>
							<input
									type="radio"
									id="q{{ $question->id }}_no"
									name="question-{{ $question->id }}"
									wire:model.live="responses.{{ $question->id }}"
									value="No"
							/>
						</div>
					</div>
				@else
					<label
							for="response-{{ $question->id }}"
							class="sr-only">Provide an answer</label>
					<input
							type="text"
							id="response-{{ $question->id }}"
							wire:model="responses.{{ $question->id }}"
							placeholder="Your answer"
					/>
				@endif
			</div>
		@endforeach
		<div class="mt-4 px-4 py-2 bg-gray-100 border border-gray-300 rounded">
			<p class="font-bold">Total "Yes" Responses: {{ $this->yesCount }}</p>
		</div>

	</x-form-layouts.form-layout>
</div>
