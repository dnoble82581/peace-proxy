<!DOCTYPE html>
<html lang="en">
<head>
	@include('partials.head')
	@fluxAppearance
</head>
<body>
{{--@include('partials.header')--}}

<main>
	{{ $slot }}
</main>

{{--@include('partials.footer')--}}
<script src="https://cdn.jsdelivr.net/npm/animejs@3.0.1/lib/anime.min.js"></script>
@stack('scripts')
</body>
</html>
