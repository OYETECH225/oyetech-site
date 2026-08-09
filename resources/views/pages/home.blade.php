@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'OYETECH — Agence digitale & cabinet stratégique à Abidjan',
        'OYETECH accompagne entreprises et institutions de Côte d\'Ivoire avec des solutions de conseil, communication, marketing digital et technologie.'
    );
@endphp

@php
    $heroWords = json_decode(\App\Models\Setting::get('hero_rotating_words', '["solutions digitales","stratégies gagnantes","produits innovants"]'), true);
    $heroBadge = \App\Models\Setting::get('hero_badge', 'Agence Digitale · Abidjan · Côte d\'Ivoire');
    $heroSubtitle = \App\Models\Setting::get('hero_subtitle', 'Cabinet stratégique et agence digitale 360°, OYETECH accompagne les entreprises et institutions de référence dans leur transformation et leur croissance.');
    $heroStats = [
        [\App\Models\Setting::get('stat_projects', '120+'), \App\Models\Setting::get('stat_projects_label', 'Projets livrés')],
        [\App\Models\Setting::get('stat_countries', '1'), \App\Models\Setting::get('stat_countries_label', 'Pays couvert')],
        [\App\Models\Setting::get('stat_satisfaction', '98%'), \App\Models\Setting::get('stat_satisfaction_label', 'Satisfaction client')],
    ];
    $ctaTitle    = \App\Models\Setting::get('cta_title', 'Prêt à transformer votre ambition en résultats ?');
    $ctaSubtitle = \App\Models\Setting::get('cta_subtitle', 'Parlons de votre projet et construisons ensemble la prochaine étape de votre croissance.');
    $ctaButton   = \App\Models\Setting::get('cta_button', 'Démarrer un projet');
@endphp

@section('content')

{{-- ============================================================
     HERO — fond noir + grille de points
     ============================================================ --}}
<section class="relative flex min-h-screen items-center overflow-hidden bg-navy text-white" data-reveal-group
    x-data x-init="
        const words = document.querySelectorAll('[id^=hero-word-]');
        const tl = gsap.timeline({ repeat: -1, delay: 1 });
        words.forEach((el) => {
            tl.to(el, { opacity: 1, y: 0, duration: 0.6 })
              .to(el, { opacity: 0, y: -20, duration: 0.6, delay: 1.6 });
        });
    ">

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
                    Nous créons des<br>
                    <span class="relative inline-block h-[1.2em] min-w-[8rem] align-bottom">
                        @foreach($heroWords as $i => $word)
                            <span id="hero-word-{{ $i + 1 }}" class="-translate-y-5 absolute left-0 top-0 whitespace-nowrap opacity-0 text-white">{{ $word }}</span>
                        @endforeach
                    </span>
                    <br>pour la Côte d'Ivoire
                </h1>

                <p class="mt-6 max-w-xl text-base leading-relaxed text-white/60 sm:text-lg" data-reveal>
                    {{ $heroSubtitle }}
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4" data-reveal>
                    <a href="{{ route('contact') }}" class="btn-invert magnetic">Démarrer un projet</a>
                </div>

                <div class="mt-10 flex flex-wrap gap-8 border-t border-white/10 pt-8" data-reveal>
                    @foreach($heroStats as [$val, $label])
                        <div>
                            <p class="font-display text-3xl font-extrabold text-white">{{ $val }}</p>
                            <p class="mt-0.5 text-xs text-white/45">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tableau de bord flottant (droite) --}}
            <div class="relative hidden lg:block" data-reveal>
                {{-- Carte principale --}}
                <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-navy-light/80 p-6 shadow-2xl shadow-black/30 backdrop-blur-sm">
                    {{-- Barre de titre --}}
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full bg-white/40"></span>
                            <span class="h-3 w-3 rounded-full bg-white/25"></span>
                            <span class="h-3 w-3 rounded-full bg-white/15"></span>
                        </div>
                        <span class="text-xs font-medium text-white/30">dashboard.oyetech.ci</span>
                    </div>

                    {{-- Graphique en barres --}}
                    <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-white/30">Performance mensuelle</p>
                    <div class="mb-5 flex h-20 items-end gap-1.5">
                        @foreach([35, 55, 42, 68, 58, 82, 65, 90, 72, 85, 62, 95] as $i => $h)
                            <div class="flex-1 rounded-t-sm {{ $h >= 70 ? 'bg-white/70' : 'bg-white/25' }}"
                                style="height: {{ $h }}%"></div>
                        @endforeach
                    </div>

                    {{-- Statistiques --}}
                    <div class="mb-4 grid grid-cols-3 gap-3">
                        @foreach([['120+', 'Projets'], ['98%', 'Satisfaits'], ['12+', 'Années']] as [$v, $l])
                            <div class="rounded-xl border border-white/10 bg-white/6 p-3 text-center">
                                <p class="font-display text-xl font-extrabold text-white">{{ $v }}</p>
                                <p class="mt-0.5 text-[10px] text-white/35">{{ $l }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Activité récente --}}
                    <div class="space-y-2">
                        @foreach([
                            ['Projet Fintech CI', 'Livré', 'bg-white/70'],
                            ['Campagne Digital Mali', 'En cours', 'bg-white/40'],
                            ['Stratégie BtoB Sénégal', 'Planifié', 'bg-white/25'],
                        ] as [$name, $status, $dot])
                            <div class="flex items-center justify-between rounded-lg border border-white/5 bg-white/4 px-3 py-2.5">
                                <span class="text-xs text-white/60">{{ $name }}</span>
                                <span class="flex items-center gap-1.5 text-xs text-white/40">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $dot }}"></span>
                                    {{ $status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Carte flottante : satisfaction --}}
                <div class="absolute -left-10 top-1/4 z-10 flex items-center gap-3 rounded-2xl border border-white/10 bg-navy-light px-4 py-3 shadow-2xl shadow-black/30">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/15">
                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.299.921-.755 1.688-1.539 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.063 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-[10px] font-medium text-white/45">Satisfaction client</p>
                        <p class="text-sm font-bold text-white">98% — Excellent</p>
                    </div>
                </div>

                {{-- Carte flottante : livraison --}}
                <div class="absolute -right-8 bottom-1/4 z-10 flex items-center gap-3 rounded-2xl border border-white/10 bg-navy-light px-4 py-3 shadow-2xl shadow-black/30">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/15">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-[10px] font-medium text-white/45">Livraison dans les délais</p>
                        <p class="text-sm font-bold text-white">95% des projets</p>
                    </div>
                </div>
            </div>

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
@php $clients = \App\Models\Client::active()->get(); @endphp
@if($clients->isNotEmpty())
<div class="relative border-y border-white/5 bg-navy-light py-10">
    <p class="mb-5 text-center text-xs font-semibold uppercase tracking-widest text-white/25">Ils nous font confiance</p>
    <x-marquee>
        @foreach($clients as $client)
            @if($client->logo_url)
                <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="mx-10 inline-flex h-10 w-auto object-contain opacity-40 grayscale transition hover:opacity-80 hover:grayscale-0">
            @else
                <span class="mx-10 inline-flex h-10 items-center font-bold text-white/20 transition-colors hover:text-white/50">{{ $client->name }}</span>
            @endif
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
                    class="magnetic group relative overflow-hidden rounded-2xl border border-ink/8 bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-2 hover:border-ink/20 hover:shadow-xl hover:shadow-black/5">
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
                    @foreach([
                        ['value' => 120, 'suffix' => '+', 'label' => 'Projets livrés'],
                        ['value' => 1,   'suffix' => '',  'label' => 'Pays couvert'],
                        ['value' => 98,  'suffix' => '%', 'label' => 'Clients satisfaits'],
                        ['value' => 12,  'suffix' => '+', 'label' => 'Années d\'expertise'],
                    ] as $stat)
                        <div x-data="{ count: 0, target: {{ $stat['value'] }} }" x-init="
                            let started = false;
                            const step = (ts, start) => {
                                const progress = Math.min((ts - start) / 1200, 1);
                                count = Math.floor(progress * target);
                                if (progress < 1) requestAnimationFrame((t) => step(t, start));
                            };
                            ScrollTrigger.create({ trigger: $el, start: 'top 90%', once: true, onEnter: () => { if (!started) { started = true; requestAnimationFrame((t) => step(t, t)); } } });
                        " class="rounded-2xl border border-white/10 bg-white/6 p-6 text-center">
                            <p class="font-display text-4xl font-extrabold sm:text-5xl">
                                <span class="text-white" x-text="count"></span><span class="text-white">{{ $stat['suffix'] }}</span>
                            </p>
                            <p class="mt-2 text-xs text-white/50">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="relative mt-5 flex items-center gap-4 rounded-2xl border border-white/10 bg-white/6 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/15">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </span>
                    <p class="text-sm font-medium text-white/70">Partenaire de confiance depuis 2012</p>
                </div>
            </div>
            <div class="absolute -bottom-5 -right-5 flex items-center gap-3 rounded-2xl border border-ink/10 bg-white px-5 py-4 shadow-xl">
                <span class="font-display text-2xl font-extrabold text-ink">12+</span>
                <span class="max-w-[7rem] text-xs font-medium leading-tight text-ink/60">années d'expertise au service de nos clients</span>
            </div>
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
                <a href="{{ route('about') }}" class="btn-primary magnetic">En savoir plus</a>
                <a href="{{ route('contact') }}" class="btn-outline-dark magnetic">Parlons de votre projet</a>
            </div>
        </div>
    </div>
    <x-wave-divider fill="#111111" :height="64" />
</section>

{{-- ============================================================
     ENGAGEMENTS — barres grises sur fond noir
     ============================================================ --}}
<section class="relative overflow-hidden bg-navy py-20 text-white">
    <div class="grid-dark absolute inset-0" style="--grid-size:60px; --grid-speed:24s" aria-hidden="true"></div>
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="blob absolute -right-24 -top-24 h-64 w-64 bg-white/5"
             style="--blob-morph:16s; --blob-float:21s;"></div>
        <div class="blob absolute -bottom-16 left-1/4 h-56 w-56 bg-white/4"
             style="--blob-morph:20s; --blob-float:26s; animation-delay:-6s,-10s;"></div>
    </div>

    <div class="relative mx-auto max-w-4xl px-6">
        <div class="mb-12 text-center" data-reveal>
            <span class="section-badge-light mb-4 inline-flex">Nos engagements</span>
            <h2 class="section-title-light">Une exigence mesurée à <span class="text-white">chaque mission</span></h2>
        </div>
        <div class="space-y-8" data-reveal-group>
            @foreach([
                ['label' => 'Clients satisfaits', 'value' => 98],
                ['label' => 'Projets livrés dans les délais', 'value' => 95],
                ['label' => 'Taux de renouvellement des contrats', 'value' => 90],
            ] as $bar)
                <div data-reveal x-data="{ count: 0, target: {{ $bar['value'] }} }" x-init="
                    let started = false;
                    const step = (ts, start) => {
                        const progress = Math.min((ts - start) / 1200, 1);
                        count = Math.floor(progress * target);
                        if (progress < 1) requestAnimationFrame((t) => step(t, start));
                    };
                    ScrollTrigger.create({ trigger: $el, start: 'top 90%', once: true, onEnter: () => { if (!started) { started = true; requestAnimationFrame((t) => step(t, t)); } } });
                ">
                    <div class="mb-3 flex items-baseline justify-between">
                        <p class="text-sm font-medium text-white/70">{{ $bar['label'] }}</p>
                        <p class="font-display text-lg font-bold"><span class="text-white" x-text="count"></span><span class="text-white">%</span></p>
                    </div>
                    <div class="h-2.5 overflow-hidden rounded-full bg-white/10">
                        <div class="h-full rounded-full bg-white transition-all duration-1000" :style="`width: ${count}%`"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <x-wave-divider fill="#080808" :height="56" />
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
                <span class="relative shrink-0 rounded-full border border-white/30 bg-white/10 px-7 py-3 font-semibold text-white backdrop-blur-sm transition group-hover:bg-white/20 magnetic">Découvrir</span>
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
            <div class="flex flex-wrap gap-2" role="group" aria-label="Filtrer les réalisations par pôle">
                @foreach(['all' => 'Tous', 'conseil' => 'Conseil', 'communication' => 'Communication', 'marketing' => 'Marketing', 'solutions' => 'Solutions', 'ilepay' => 'Ilepay'] as $key => $label)
                    <button @click="setFilter('{{ $key }}')"
                        :class="filter === '{{ $key }}' ? 'bg-ink text-white shadow-md shadow-black/20' : 'bg-white text-ink/60 hover:text-ink border border-ink/10'"
                        class="min-h-10 rounded-full px-4 py-2 text-sm font-medium transition duration-200">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
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
        <a href="{{ route('portfolio.index') }}" class="btn-primary magnetic inline-flex">Voir tous les projets</a>
    </div>
</section>

{{-- ============================================================
     TÉMOIGNAGES — fond blanc
     ============================================================ --}}
@if($testimonials->isNotEmpty())
<section class="relative overflow-hidden bg-white py-28" x-data="{ active: 0, total: {{ $testimonials->count() }} }">
    <div class="relative mx-auto max-w-3xl px-6 text-center">
        <span class="section-badge mb-6 inline-flex" data-reveal>Témoignages clients</span>
        <h2 class="section-title mb-8" data-reveal>Ce que disent <span class="gradient-text">nos clients</span></h2>

        <span class="font-display select-none text-8xl leading-none text-ink/15" aria-hidden="true">&ldquo;</span>

        <div class="relative min-h-[240px]" aria-live="polite" data-reveal>
            @foreach($testimonials as $i => $testimonial)
                <div x-show="active === {{ $i }}" x-transition>
                    <div class="mb-5 flex justify-center gap-1" aria-label="{{ $testimonial->rating }} étoiles sur 5">
                        @for($s = 1; $s <= 5; $s++)
                            <svg class="h-5 w-5 {{ $s <= $testimonial->rating ? 'text-ink' : 'text-ink/15' }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.299.921-.755 1.688-1.539 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.063 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="font-display text-xl font-medium leading-relaxed text-ink/80 sm:text-2xl">
                        &ldquo;{{ $testimonial->content }}&rdquo;
                    </p>
                    <div class="mt-8 flex items-center justify-center gap-4">
                        @if($testimonial->photo_url)
                            <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->author_name }}" width="52" height="52" loading="lazy"
                                class="h-12 w-12 rounded-full object-cover ring-2 ring-ink/15">
                        @else
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-ink ring-2 ring-ink/10 font-display text-lg font-bold text-white">
                                {{ mb_substr($testimonial->author_name, 0, 1) }}
                            </span>
                        @endif
                        <div class="text-left">
                            <p class="font-display font-bold text-ink">{{ $testimonial->author_name }}</p>
                            <p class="text-sm text-ink/45">{{ $testimonial->author_role }}, {{ $testimonial->company }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10 flex justify-center gap-2">
            @foreach($testimonials as $i => $testimonial)
                <button @click="active = {{ $i }}"
                    :aria-current="active === {{ $i }}"
                    aria-label="Témoignage {{ $i + 1 }} sur {{ $testimonials->count() }}"
                    :class="active === {{ $i }} ? 'bg-ink w-8' : 'bg-ink/15 w-2.5 hover:bg-ink/25'"
                    class="h-2.5 rounded-full transition-all duration-300">
                </button>
            @endforeach
        </div>
    </div>
</section>
@endif

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
                <div data-reveal class="group rounded-2xl border border-ink/8 bg-white p-6 text-center shadow-sm transition duration-300 hover:-translate-y-2 hover:border-ink/20 hover:shadow-xl hover:shadow-black/5">
                    @if($member->photo_url)
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" width="96" height="96" loading="lazy"
                            class="mx-auto h-24 w-24 rounded-full object-cover ring-4 ring-ink/5 transition group-hover:ring-ink/15">
                    @else
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-ink">
                            <span class="font-display text-2xl font-extrabold text-white/80">{{ mb_substr($member->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <h3 class="mt-4 font-display font-bold text-ink">{{ $member->name }}</h3>
                    <p class="text-sm font-medium text-ink/50">{{ $member->role }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-10 text-center" data-reveal>
            <a href="{{ route('about') }}" class="btn-outline-dark magnetic inline-flex items-center gap-2">
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
        <x-faq :items="[
            ['q' => 'Quels types d\'entreprises accompagnez-vous ?', 'a' => 'Nous travaillons avec des PME, grandes entreprises, institutions publiques et startups basées en Côte d\'Ivoire.'],
            ['q' => 'Combien de temps dure une mission type ?', 'a' => 'Cela dépend du pôle et du périmètre : de quelques semaines pour une campagne de communication à plusieurs mois pour une transformation digitale complète.'],
            ['q' => 'Travaillez-vous avec des clients hors de Côte d\'Ivoire ?', 'a' => 'Notre agence est basée à Abidjan et nous sommes implantés en Côte d\'Ivoire. Nous accompagnons ponctuellement, à distance, des clients dont l\'activité s\'étend à d\'autres pays d\'Afrique de l\'Ouest.'],
            ['q' => 'Comment se déroule la première prise de contact ?', 'a' => 'Vous remplissez le formulaire de contact ou réservez un créneau via Calendly. Notre équipe revient vers vous en moins de 48h pour cadrer votre besoin.'],
        ]" />
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
