<x-document-layout>
	<div style="display: flex; justify-content: space-between; align-items: center;">
		<div>
			<h1>On Scene Risk Assessment</h1>
		</div>
		<div>
			<strong>{{ $subject->name }}</strong>
			<p>{{ $subject->room->negotiation->title }}</p>
			<p>{{ $subject->room->negotiation->address }}</p>
		</div>
	</div>

	<!-- Display assessment questions and responses -->
	<div
			style="background-color: #DCE4F2; padding: 1rem;"
			class="questions-section">
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
