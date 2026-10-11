<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Active les animations d'apparition seulement si JS tourne (voir app.css) --}}
    <script>document.documentElement.classList.add('js');</script>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-mark.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-mark.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {!! \Artesaos\SEOTools\Facades\SEOTools::generate() !!}

    @php
        $trackers = (object) array_filter([
            'gtm' => config('services.gtm.id'),
            'ga4' => config('services.ga4.id'),
            'metaPixel' => config('services.meta_pixel.id'),
            'linkedin' => config('services.linkedin.partner_id'),
        ]);
    @endphp
    {{-- Google Consent Mode v2 : tout refusé par défaut. Aucun traceur tiers n'est chargé
         avant l'acceptation dans le bandeau cookies (resources/js/consent.js). --}}
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('consent', 'default', {
            ad_storage: 'denied',
            ad_user_data: 'denied',
            ad_personalization: 'denied',
            analytics_storage: 'denied',
        });
        window.oyetechTrackers = {!! json_encode($trackers, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES) !!};
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-ink antialiased">
    <a href="#contenu" class="sr-only z-[70] rounded-full bg-white px-5 py-3 font-semibold text-ink shadow-lg focus:not-sr-only focus:fixed focus:left-4 focus:top-4">Aller au contenu</a>

    <x-cookie-banner />

    <div class="cursor-ring" aria-hidden="true" data-cursor></div>

    <x-navbar />

    <main id="contenu" tabindex="-1" class="focus:outline-none">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <x-footer />

    <x-whatsapp-float />

    @stack('scripts')
</body>
</html>
