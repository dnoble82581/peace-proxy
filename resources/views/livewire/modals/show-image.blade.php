<div class="relative">
	<img
			src="{{ $this->image }}"
			alt="Image"
			class="object-fill w-full h-full">
	<button
			onclick="Livewire.dispatch('modal.close')"
			class="absolute top-3 right-3 text-gray-400">
		<x-heroicons::mini.solid.x-mark class="w-6 h-6" />
	</button>
</div>
