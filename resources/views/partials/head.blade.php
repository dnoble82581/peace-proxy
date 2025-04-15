<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Basic SEO -->
<title>@yield('title', 'Peace Proxy')</title>
<meta name="description" content="@yield('meta_description', 'A web application for crisis negotiators.')">
<meta name="keywords" content="@yield('meta_keywords', 'default, keywords, here')">
<meta name="author" content="Your Name or Company">

<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('og_title', 'Default OG Title')">
<meta property="og:description" content="@yield('og_description', 'Default OG description')">
<meta property="og:image" content="@yield('og_image', asset('images/default-og-image.jpg'))">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="@yield('twitter_title', 'Default Twitter Title')">
<meta name="twitter:description" content="@yield('twitter_description', 'Default Twitter Description')">
<meta name="twitter:image" content="@yield('twitter_image', asset('images/default-twitter-image.jpg'))">

<!-- Favicon -->
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

<!-- Structured Data JSON-LD (Example for an Organization) -->
<script type="application/ld+json">
	{
	  "@context": "https://schema.org",
	  "@type": "Organization",
	  "name": "Peace Proxy",
	  "description": "A web application for crisis negotiators.",
	  "url": "{{ url('/') }}",
      "logo": "{{ asset('images/logo.png') }}",
      "sameAs": [
        "https://www.facebook.com/yourpage",
        "https://www.twitter.com/yourhandle"
      ]
    }
</script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
@stack('head')