<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta
			name="viewport"
			content="width=device-width, initial-scale=1">
	<meta
			name="csrf-token"
			content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	<wireui:scripts />
	@livewireStyles
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
		class="font-sans antialiased"
		x-data="{darkMode: false}"
		:class="{'dark': darkMode === true }">

<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
	<livewire:layout.room-navigation />
	<main>
		{{ $slot }}
	</main>
</div>
@livewire('modal-pro')
@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</body>
</html>
