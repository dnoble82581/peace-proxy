<div class="p-8 space-y-3">
	<div class="space-y-3">
		<span class="text-sm text-gray-500">
			Responding to: {{ $message->user->name }}
		</span>
		<div class="px-4">
			<p class="text-sm p-4 bg-blue-100 rounded">"{{ $message->message }}"</p>
		</div>
	</div>
	<form wire:submit.prevent="reply">
		<div>
			<x-textarea
					label="Alert Response"
					wire:model="form.response"
					placeholder="Enter your response here..." />
		</div>
		<div class="flex justify-end items-center space-x-2 mt-4">
			<x-buttons.primary-button
					type="submit"
					:value="__('Reply')" />
			<x-buttons.secondary-button
					type="button"
					wire:click="$dispatch('modal.close')"
					:value="__('Cancel')" />
		</div>
	</form>

</div>
