@props(['message', 'isOwnMessage', 'isEmergent', 'hasResponse', 'id' => ''])

<!--
Render an individual chat message.
- Props:
    - $message: The message instance to display.
    - $isOwnMessage: A boolean indicating if this message belongs to the logged-in user.
-->

<div
		id="{{ $id }}"
		class="flex items-start {{ $isOwnMessage ? 'justify-start' : 'justify-end' }} gap-2.5">
	<!--
	Wrapper div to position the message content.
	- Flexbox is used to align the message and add spacing.
	- $isOwnMessage determines the alignment direction:
		- 'justify-start' if the current user sent the message.
		- 'justify-end' otherwise, for messages from others.
	-->

	<div class="flex flex-col gap-1 w-full max-w-[340px]">
		<!--
		Container for the message block.
		- Uses 'flexbox' for column-based layout and applies spacing between elements.
		- Limits the width of the message block (max-width: 340px).
		-->

		<div class="flex items-center space-x-2 rtl:space-x-reverse">
			<!--
			Header of the message block with sender info and timestamp.
			- Displays the sender's name and when the message was sent (e.g., "2 minutes ago").
			- Applies spacing between the name and timestamp using 'space-x-2'.
			-->

			<span class="text-xs font-semibold text-gray-900 dark:text-slate-400">
                {{ $message->user->name }}
				<!-- The name of the user who sent the message. -->
            </span>

			<span
					class="text-xs font-normal text-gray-500 dark:text-gray-400">
                {{ $message->created_at->diffForHumans() }}
				<!-- Human-readable timestamp, e.g., "2 minutes ago". -->
            </span>
		</div>

		<div
				@php

					if ($isEmergent){
						$messageClasses = 'bg-rose-200 border border-rose-500';
					}elseif($isOwnMessage){
						$messageClasses = 'bg-slate-100 dark:bg-slate-200';
					}else{
						$messageClasses = 'bg-sky-100 dark:bg-blue-200';
					}
				@endphp
				class="flex flex-col leading-1.5 p-4 border-gray-200
            rounded-e-xl rounded-es-xl {{ $messageClasses }}">

			<p class="text-sm font-normal text-gray-900">
				{{ $message->message }}
				<!-- The content of the message being displayed. -->
			</p>
		</div>

		<div class="flex items-center justify-between">
			<span class="text-xs font-normal text-gray-500 dark:text-gray-400">Delivered</span>
			@if($message->responses()->count())
				<button
						wire:click="showResponses({{ $message->id }})"
						type="button"
						class="text-xs font-normal text-indigo-700 dark:text-gray-400"> {{ $message->responses()->count() }}
					responses
				</button>
			@endif
		</div>
	</div>
</div>