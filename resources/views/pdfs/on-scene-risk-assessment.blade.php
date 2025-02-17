<x-document-layout>
	<h1>On Scene Risk Assessment</h1>

	<!-- Display assessment questions and responses -->
	<div class="questions-section">
		@foreach ($questions as $question)
			<div class="question">
				<p class="question-title"><strong>{{ $question->question_text }}</strong></p>
				<p class="response">
					@if(is_array($responses[$question->id]))
						{{ implode(', ', $responses[$question->id]) }}
					@else
						{{ $responses[$question->id] }}
					@endif
				</p>
			</div>
		@endforeach
	</div>
</x-document-layout>
