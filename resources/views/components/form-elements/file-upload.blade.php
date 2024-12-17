@props(["label" => '', "type" => '', "model" => '', 'wireModel' => '', "acceptType" => '', "message" => ''])
<div>
	<x-form-elements.input-label :for="$label">{{ $label }}</x-form-elements.input-label>
	<div class="flex items-center">
		@if($type === 'photo' && $model)
			<img
					class="h-10 w-10 rounded-full"
					src="{{ $model->temporaryUrl() }}"
					alt="Uploaded {{ $label }}"
			/>
		@elseif($type === 'application' && $model)
			<x-svg-images.document-icon />
		@else
			<x-svg-images.image-placeholder />
		@endif
		<div class="ml-4">
			<input
					wire:model="{{ $wireModel }}"
					type="file"
					accept="{{ $acceptType }}"
					class="mt-1"
			/>
			@error('{{ $wireModel }}')
			<span class="text-sm text-red-500 mt-2">{{ $message }}</span>
			@enderror
		</div>
	</div>
</div>