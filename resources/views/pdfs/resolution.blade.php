<x-document-layout>
	<!-- Header Section -->
	<div
			style="background-color: #F5F8FA; margin-bottom: 5px; padding:6px; font-family: sans-serif">
		<div>
			<h1>Negotiation Resolution</h1>
		</div>
		<div>
			<strong style="font-size: 14px">{{ $subject->name }}</strong>
			<p style="font-size: 12px; color: #718096; margin-top: 2px; margin-bottom: 0;">{{ $subject->room->negotiation->title }}</p>
			<p style="font-size: 12px; color: #718096; margin-top: 2px; margin-bottom: 0;">{{ $subject->room->negotiation->address }}</p>
		</div>
	</div>

	<!-- Questions and Responses Section -->
	<div
			style="background-color: #f3f4f6; padding: 6px">
		@foreach ($questions as $question)
			<!-- Find the response for the current question -->
			<div style="background-color: #DFE8EA; padding: .5rem; margin-bottom: 10px">
				<strong style="font-size: 14px; font-family: sans-serif;">
					{{ $question->question_text }}
				</strong>
			</div>
			<div>
				@foreach ($question->responses as $response)
					<p style="margin-top: .5rem; font-size: 12px; font-family: sans-serif;">
						{{ $response->response }}
					</p>
				@endforeach
			</div>
		@endforeach
	</div>
</x-document-layout>