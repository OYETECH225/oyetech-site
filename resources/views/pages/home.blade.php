@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'OYETECH — Agence digitale et cabinet stratégique à Abidjan',
        'Agence digitale et cabinet stratégique à Abidjan : conseil, communication, marketing digital et solutions numériques pour faire grandir les entreprises africaines.'
    );
@endphp

@php
    $heroTitle = \App\Models\Setting::get('hero_title', 'Stratégie, communication et solutions digitales pour faire grandir les entreprises africaines');
    $heroBadge = \App\Models\Setting::get('hero_badge', 'Agence Digitale · Abidjan · Côte d\'Ivoire');
    $heroSubtitle = \App\Models\Setting::get('hero_subtitle', 'Cabinet stratégique et agence digitale 360°, OYETECH accompagne les entreprises et institutions de référence dans leur transformation et leur croissance.');
    // Uniquement des faits vérifiables (pas de nombre de projets ni de taux de satisfaction)
    $heroStats = array_values(array_filter([
        ['5', 'Pôles d\'expertise'],
        $entreprise->afficheAnciennete() ? [$entreprise->anciennete(), 'Années d\'expertise'] : null,
        ['Abidjan', 'Siège en Côte d\'Ivoire'],
    ]));
    $ctaTitle    = \App\Models\Setting::get('cta_title', 'Prêt à transformer votre ambition en résultats ?');
    $ctaSubtitle = \App\Models\Setting::get('cta_subtitle', 'Parlons de votre projet et construisons ensemble la prochaine étape de votre croissance.');
    $ctaButton   = \App\Models\Setting::get('cta_button', 'Démarrer un projet');
@endphp

@section('content')

{{-- ============================================================
     HERO — fond noir + grille de points
     ============================================================ --}}
<section class="relative flex min-h-screen items-center overflow-hidden bg-navy text-white" data-reveal-group>

    {{-- Blobs morphants CSS --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="blob absolute -left-48 -top-48 h-[700px] w-[700px] bg-white/5"
             style="--blob-morph:20s; --blob-float:26s;"></div>
        <div class="blob absolute -right-32 bottom-0 h-[550px] w-[550px] bg-white/4"
             style="--blob-morph:15s; --blob-float:19s; animation-delay:-8s,-12s;"></div>
        <div class="blob absolute left-1/2 top-1/3 h-[400px] w-[400px] -translate-x-1/2 bg-white/3"
             style="--blob-morph:24s; --blob-float:30s; animation-delay:-5s,-18s;"></div>
    </div>

    {{-- Grille géométrique animée --}}
    <div class="grid-dark absolute inset-0" style="--grid-size:96px; --grid-speed:40s" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-7xl px-6 pb-20 pt-36">
        <div class="grid items-center gap-14 lg:grid-cols-2 lg:gap-20">

            {{-- Contenu gauche --}}
            <div data-reveal-group>
                <span class="section-badge-light mb-6 inline-flex" data-reveal>
                    <span class="mr-2 h-1.5 w-1.5 rounded-full bg-white/60"></span>
                    {{ $heroBadge }}
                </span>

                <h1 class="font-display text-4xl font-extrabold leading-[1.08] tracking-tight sm:text-5xl xl:text-[3.5rem]" data-reveal>
                    {{ $heroTitle }}
                </h1>

                <p class="mt-6 max-w-xl text-base leading-relaxed text-white/60 sm:text-lg" data-reveal>
                    {{ $heroSubtitle }}
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4" data-reveal>
                    <a href="{{ route('contact') }}" class="btn-invert">Démarrer un projet</a>
                </div>

                <div class="mt-10 flex flex-wrap gap-8 border-t border-white/10 pt-8" data-reveal>
                    @foreach($heroStats as [$val, $label])
                        <div>
                            <p class="font-display text-3xl font-extrabold text-white">{{ $val }}</p>
                            <p class="mt-0.5 text-xs text-white/60">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Panneau des pôles (droite) : uniquement du contenu réel, chaque ligne mène à la page du pôle --}}
            @if($services->isNotEmpty())
            <nav class="relative hidden lg:block" aria-label="Nos pôles d'expertise" data-reveal>
                <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-navy-light/80 p-6 shadow-2xl shadow-black/30 backdrop-blur-sm">
                    <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-white/60">Nos {{ $services->count() }} pôles d'expertise</p>
                    <ul class="space-y-2">
                        @foreach($services as $service)
                            <li>
                                <a href="{{ $service->url }}" class="group flex items-center gap-4 rounded-xl border border-white/5 bg-white/4 px-4 py-3 transition hover:border-white/20 hover:bg-white/10">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white/10 text-white">
                                        <x-dynamic-component :component="$service->icon ?? 'heroicon-o-sparkles'" class="h-5 w-5" />
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-semibold text-white">{{ $service->name }}</span>
                                        <span class="block truncate text-xs text-white/60">{{ $service->summary }}</span>
                                    </span>
                                    <svg class="h-4 w-4 shrink-0 text-white/60 transition group-hover:translate-x-1 group-hover:text-white" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
            @endif

        </div>
    </div>

    <button onclick="window.scrollTo({top: window.innerHeight, behavior: 'smooth'})"
        aria-label="Défiler vers le contenu"
        class="absolute bottom-8 left-1/2 flex h-10 w-10 -translate-x-1/2 items-center justify-center rounded-full border border-white/20 text-white/50 transition hover:border-white hover:text-white motion-reduce:hidden">
        <svg class="h-5 w-5 animate-bounce motion-reduce:animate-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
</section>

{{-- ============================================================
     CLIENTS — logos en marquee sur fond sombre
     ============================================================ --}}
{{-- Seulement des logos réels ; section masquée sous 2 logos (voir HomeController) --}}
@if($clients->count() >= 2)
<div class="relative border-y border-white/5 bg-navy-light py-10">
    <p class="mb-5 text-center text-xs font-semibold uppercase tracking-widest text-white/60">Ils nous font confiance</p>
    <x-marquee>
        @foreach($clients as $client)
            <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" width="160" height="40" loading="lazy"
                class="mx-10 inline-flex h-10 w-auto object-contain opacity-40 grayscale transition hover:opacity-80 hover:grayscale-0">
        @endforeach
    </x-marquee>
    <x-wave-divider fill="#ffffff" :height="56" />
</div>
@endif

{{-- ============================================================
     SERVICES PHARES — 3 cartes avec icônes noires
     ============================================================ --}}
<section class="relative overflow-hidden bg-white py-24">
    <div class="grid-light absolute inset-0" aria-hidden="true"></div>
    <div class="mx-auto max-w-7xl px-6">
        <div class="mb-14 text-center" data-reveal>
            <span class="section-badge mb-5 inline-flex">Ce que nous faisons</span>
            <h2 class="section-title">Des solutions adaptées à <span class="gradient-text">chaque défi</span></h2>
            <p class="mx-auto mt-4 max-w-xl text-ink/60">Une expertise pluridisciplinaire pour propulser votre entreprise à l'ère digitale.</p>
        </div>

        <div class="grid gap-8 sm:grid-cols-3" data-reveal-group>
            @foreach([
                ['icon' => 'heroicon-o-bolt', 'num' => '01', 'title' => 'Exécution rapide', 'text' => 'Des équipes dédiées qui passent à l\'action dès le cadrage validé.', 'link' => route('services.index')],
                ['icon' => 'heroicon-o-chart-bar', 'num' => '02', 'title' => 'Pilotage par la donnée', 'text' => 'Chaque recommandation s\'appuie sur des indicateurs mesurables.', 'link' => route('portfolio.index')],
                ['icon' => 'heroicon-o-shield-check', 'num' => '03', 'title' => 'Engagement de résultats', 'text' => 'Nous nous engageons sur des objectifs, pas seulement des livrables.', 'link' => route('contact')],
            ] as $feature)
                <a href="{{ $feature['link'] }}" data-reveal
                    class="group relative overflow-hidden rounded-2xl border border-ink/8 bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-2 hover:border-ink/20 hover:shadow-xl hover:shadow-black/5">
                    {{-- Numéro décoratif --}}
                    <span class="absolute right-6 top-6 font-display text-5xl font-extrabold text-ink/4 transition group-hover:text-ink/6">{{ $feature['num'] }}</span>
                    {{-- Icône --}}
                    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-ink text-white shadow-lg shadow-black/20 transition-all duration-300 group-hover:scale-110 group-hover:shadow-black/30">
                        <x-dynamic-component :component="$feature['icon']" class="h-7 w-7" />
                    </div>
                    <h3 class="font-display text-xl font-bold text-ink">{{ $feature['title'] }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-ink/60">{{ $feature['text'] }}</p>
                    <span class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-ink transition-all group-hover:gap-2">
                        Découvrir
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     POURQUOI OYETECH — split : stats noir + texte
     ============================================================ --}}
<section class="relative bg-slate-50 py-28">
    <div class="mx-auto grid max-w-7xl gap-16 px-6 lg:grid-cols-2 lg:items-center">

        {{-- Gauche : grille de stats sur fond noir --}}
        <div class="relative" data-reveal>
            <div class="relative overflow-hidden rounded-3xl bg-navy p-8">
                {{-- Blob décoratif subtil --}}
                <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-white/4 blur-[60px]" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -bottom-8 -left-8 h-40 w-40 rounded-full bg-white/3 blur-[50px]" aria-hidden="true"></div>

                <div class="relative grid grid-cols-2 gap-4">
                    @foreach(array_filter([
                        ['value' => 5,   'suffix' => '',  'label' => 'Pôles d\'expertise'],
                        $entreprise->afficheAnciennete() ? ['value' => $entreprise->anciennete(), 'suffix' => '', 'label' => 'Années d\'expertise'] : null,
                    ]) as $stat)
                        <div x-data="countUp({{ $stat['value'] }})" class="rounded-2xl border border-white/10 bg-white/6 p-6 text-center {{ $loop->last && $loop->count % 2 ? 'col-span-2' : '' }}">
                            <p class="font-display text-4xl font-extrabold sm:text-5xl">
                                <span class="text-white" x-text="count">{{ $stat['value'] }}</span><span class="text-white">{{ $stat['suffix'] }}</span>
                            </p>
                            <p class="mt-2 text-xs text-white/60">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="relative mt-5 flex items-center gap-4 rounded-2xl border border-white/10 bg-white/6 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/15">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </span>
                    <p class="text-sm font-medium text-white/70">
                        {{ $entreprise->afficheAnciennete() ? 'Partenaire de confiance depuis '.$entreprise->anneeCreation() : 'Cabinet basé à Abidjan, au service des entreprises africaines' }}
                    </p>
                </div>
            </div>
            @if($entreprise->afficheAnciennete())
            <div class="absolute -bottom-5 -right-5 flex items-center gap-3 rounded-2xl border border-ink/10 bg-white px-5 py-4 shadow-xl">
                <span class="font-display text-2xl font-extrabold text-ink">{{ $entreprise->anciennete() }}</span>
                <span class="max-w-[7rem] text-xs font-medium leading-tight text-ink/60">années d'expertise au service de nos clients</span>
            </div>
            @endif
        </div>

        {{-- Droite : texte --}}
        <div data-reveal-group>
            <span class="section-badge mb-5 inline-flex" data-reveal>Pourquoi OYETECH</span>
            <h2 class="section-title" data-reveal>
                Un partenaire stratégique autant qu'un <span class="gradient-text">acteur technologique</span>
            </h2>
            <p class="mt-5 leading-relaxed text-ink/60" data-reveal>
                Nous combinons la rigueur d'un cabinet de conseil et l'agilité d'une agence digitale pour livrer des résultats mesurables, pas seulement des recommandations.
            </p>

            <ul class="mt-8 space-y-4" data-reveal>
                @foreach([
                    'Une équipe pluridisciplinaire : stratégie, créa, tech et data sous un même toit',
                    'Une connaissance fine du marché et des usages ivoiriens',
                    'Des engagements de résultats, pas de simples livrables',
                ] as $point)
                    <li class="flex items-start gap-4">
                        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-ink">
                            <svg class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </span>
                        <span class="text-ink/70">{{ $point }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="mt-10 flex flex-wrap gap-4" data-reveal>
                <a href="{{ route('about') }}" class="btn-primary">En savoir plus</a>
                <a href="{{ route('contact') }}" class="btn-outline-dark">Parlons de votre projet</a>
            </div>
        </div>
    </div>
    <x-wave-divider fill="#080808" :height="64" />
</section>

{{-- ============================================================
     MARQUEE — pôles sur fond noir
     ============================================================ --}}
<div class="relative overflow-hidden bg-navy-dark py-4 border-y border-white/5">
    <x-marquee :reverse="true">
        @foreach(['Conseil & Stratégie', 'Communication & Publicité', 'Marketing Digital', 'Solutions Numériques', 'Ilepay'] as $pole)
            <span class="font-display mx-6 inline-flex items-center gap-5 text-xl font-extrabold uppercase tracking-tight text-white/25">
                {{ $pole }}
                <span class="text-white/20" aria-hidden="true">✦</span>
            </span>
        @endforeach
    </x-marquee>
    <x-wave-divider fill="#ffffff" :height="56" />
</div>

{{-- ============================================================
     5 PÔLES — carte featured noire + grille
     ============================================================ --}}
<section class="relative overflow-hidden bg-white py-24">
    <div class="grid-light absolute inset-0" style="--grid-size:84px; --grid-speed:36s" aria-hidden="true"></div>
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto mb-14 max-w-2xl text-center" data-reveal>
            <span class="section-badge mb-5 inline-flex">Nos pôles</span>
            <h2 class="section-title">Cinq pôles, <span class="gradient-text">une seule ambition</span></h2>
            <p class="mt-4 text-ink/60">Une expertise complète pour accompagner chaque étape de votre transformation.</p>
        </div>

        @php $first = $services->first(); $rest = $services->slice(1); @endphp

        @if($first)
            <a href="{{ $first->url }}" data-reveal
                class="group relative mb-8 flex flex-col items-start gap-8 overflow-hidden rounded-3xl bg-ink p-10 text-white transition duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-black/30 sm:flex-row sm:items-center sm:p-12">
                {{-- Blob déco intérieur --}}
                <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/5 blur-[60px]" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -bottom-10 left-1/3 h-40 w-40 rounded-full bg-black/20 blur-[40px]" aria-hidden="true"></div>

                <span class="relative flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl border border-white/20 bg-white/10 text-white backdrop-blur-sm">
                    <x-dynamic-component :component="$first->icon ?? 'heroicon-o-sparkles'" class="h-10 w-10" />
                </span>
                <div class="relative flex-1">
                    <span class="mb-3 inline-block rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-white/70">Pôle phare</span>
                    <h3 class="font-display text-2xl font-extrabold sm:text-3xl">{{ $first->name }}</h3>
                    <p class="mt-3 max-w-xl text-white/70">{{ $first->summary }}</p>
                </div>
                <span class="relative shrink-0 rounded-full border border-white/30 bg-white/10 px-7 py-3 font-semibold text-white backdrop-blur-sm transition group-hover:bg-white/20">Découvrir</span>
            </a>
        @endif

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
            @foreach($rest as $service)
                <x-service-card :service="$service" />
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     PORTFOLIO — grille filtrée
     ============================================================ --}}
<section class="bg-slate-50 py-24" x-data="{
    filter: new URLSearchParams(window.location.search).get('pole') || 'all',
    setFilter(key) {
        this.filter = key;
        const url = new URL(window.location);
        key === 'all' ? url.searchParams.delete('pole') : url.searchParams.set('pole', key);
        window.history.replaceState({}, '', url);
    },
}">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mb-10 flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end" data-reveal>
            <div>
                <span class="section-badge mb-3 inline-flex">Portfolio</span>
                <h2 class="section-title">Nos <span class="gradient-text">réalisations</span></h2>
            </div>
            {{-- Filtres seulement pour les pôles qui ont des réalisations, et s'il y en a au moins deux --}}
            @php $poleFilters = collect(['conseil' => 'Conseil', 'communication' => 'Communication', 'marketing' => 'Marketing', 'solutions' => 'Solutions', 'ilepay' => 'Ilepay'])->only($projects->pluck('pole')->unique()); @endphp
            @if($poleFilters->count() > 1)
            <div class="flex flex-wrap gap-2" role="group" aria-label="Filtrer les réalisations par pôle">
                @foreach(['all' => 'Tous'] + $poleFilters->all() as $key => $label)
                    <button @click="setFilter('{{ $key }}')"
                        :class="filter === '{{ $key }}' ? 'bg-ink text-white shadow-md shadow-black/20' : 'bg-white text-ink/60 hover:text-ink border border-ink/10'"
                        class="min-h-10 rounded-full px-4 py-2 text-sm font-medium transition duration-200">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <div class="mt-4 flex gap-6 overflow-x-auto px-6 pb-4 [scroll-padding-left:1.5rem] snap-x snap-mandatory sm:px-[max(1.5rem,calc((100vw-80rem)/2))]" data-reveal-group>
        @foreach($projects as $project)
            <div x-show="filter === 'all' || filter === '{{ $project->pole }}'" x-transition class="w-[85%] shrink-0 snap-start sm:w-[380px]">
                <x-project-card :project="$project" />
            </div>
        @endforeach
    </div>

    <div class="mt-10 text-center" data-reveal>
        <a href="{{ route('portfolio.index') }}" class="btn-primary inline-flex">Voir tous les projets</a>
    </div>
</section>

{{-- ============================================================
     TÉMOIGNAGES — fond blanc
     ============================================================ --}}
<x-testimonials :testimonials="$testimonials" />

{{-- ============================================================
     ÉQUIPE
     ============================================================ --}}
@if($team->isNotEmpty())
<section class="bg-slate-50 py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto mb-14 max-w-2xl text-center" data-reveal>
            <span class="section-badge mb-4 inline-flex">L'équipe</span>
            <h2 class="section-title">Une équipe <span class="gradient-text">pluridisciplinaire</span></h2>
            <p class="mt-4 text-ink/60">Stratégie, créativité, technologie et data réunies pour porter vos projets.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
            @foreach($team as $member)
                <x-team-card :member="$member" data-reveal />
            @endforeach
        </div>

        <div class="mt-10 text-center" data-reveal>
            <a href="{{ route('about') }}" class="btn-outline-dark inline-flex items-center gap-2">
                Voir toute l'équipe
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     FAQ
     ============================================================ --}}
<section class="bg-white py-24">
    <div class="mx-auto max-w-3xl px-6">
        <div class="mb-12 text-center" data-reveal>
            <span class="section-badge mb-4 inline-flex">FAQ</span>
            <h2 class="section-title">Questions <span class="gradient-text">fréquentes</span></h2>
        </div>
        <x-faq :items="app(\App\Services\Faq::class)->accueil()" />
    </div>
</section>

{{-- ============================================================
     BLOG
     ============================================================ --}}
@if($articles->isNotEmpty())
<section class="bg-slate-50 py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto mb-14 max-w-2xl text-center" data-reveal>
            <span class="section-badge mb-4 inline-flex">Blog & Insights</span>
            <h2 class="section-title">Derniers <span class="gradient-text">insights</span></h2>
        </div>
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
            @foreach($articles as $article)
                <x-article-card :article="$article" />
            @endforeach
        </div>
    </div>
</section>
@endif

<x-cta-band
    :title="$ctaTitle"
    :subtitle="$ctaSubtitle"
    :buttonLabel="$ctaButton"
/>

@endsection
