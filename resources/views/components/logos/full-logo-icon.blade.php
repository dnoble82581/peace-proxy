@props(['primarySize' => 'text-xl', 'secondarySize' => 'text-xs'])
<flux:button-or-link
		href="/"
		class="text-center">
	<h2 class="font-semibold uppercase {{ $primarySize }} text-accent-500">
		Peace<span class="font-normal dark:text-white text-primary-500">Proxy</span>
	</h2>
	<p class="dark:text-white text-primary-500 {{ $secondarySize }} uppercase">
		Communications
	</p>
</flux:button-or-link>