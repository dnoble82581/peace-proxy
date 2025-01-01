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

	<script>(g => {
        var h, a, k, p = 'The Google Maps JavaScript API', c = 'google', l = 'importLibrary', q = '__ib__',
          m = document, b = window
        b = b[c] || (b[c] = {})
        var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams,
          u = () => h || (h = new Promise(async (f, n) => {
            await (a = m.createElement('script'))
            e.set('libraries', [...r] + '')
            for (k in g) e.set(k.replace(/[A-Z]/g, t => '_' + t[0].toLowerCase()), g[k])
            e.set('callback', c + '.maps.' + q)
            a.src = `https://maps.${c}apis.com/maps/api/js?` + e
            d[q] = f
            a.onerror = () => h = n(Error(p + ' could not load.'))
            a.nonce = m.querySelector('script[nonce]')?.nonce || ''
            m.head.append(a)
          }))
        d[l] ? console.warn(p + ' only loads once. Ignoring:', g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
      })
      ({ key: 'AIzaSyCjE4zIlaH_y0omX1UbSv0-ZgPC__Besbw', v: 'weekly' })</script>


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
	<livewire:layout.navigation />

	<!-- Page Heading -->
	@if (isset($header))
		<header class="bg-white dark:bg-gray-800 shadow">
			<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
				{{ $header }}
			</div>
		</header>
	@endif

	<!-- Page Content -->
	<main>
		{{ $slot }}
	</main>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@livewireScripts
</body>
</html>
