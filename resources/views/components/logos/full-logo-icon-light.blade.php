@props(['primarySize' => 'text-xl', 'secondarySize' => 'text-xs'])
<flux:button-or-link href="/">
	<h2 class="font-semibold uppercase {{ $primarySize }} text-accent-500">
		Peace<span class="font-normal text-primary-500">Proxy</span>
	</h2>
	<p class="text-primary-500 {{ $secondarySize }} text-center uppercase">
		Communications
	</p>
</flux:button-or-link>