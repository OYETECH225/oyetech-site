@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Création de site web et d\'application mobile à Abidjan — OYETECH',
        'Création de sites vitrines, e-commerce, applications web métier et mobiles, automatisations : le pôle Solutions Numériques d\'OYETECH à Abidjan.'
    );
@endphp

@section('pole_details')
{{-- OFFRES — contenu : config/solutions.php --}}
<section class="bg-white py-28">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <span class="mb-4 inline-block rounded-full border border-ink/15 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-ink/60">
                Nos offres
            </span>
            <h2 class="section-title">Ce que nous construisons pour vous</h2>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
            @foreach(config('solutions.offres') as $slug => $offre)
                <article data-reveal class="flex flex-col rounded-2xl border border-ink/10 bg-white p-8 shadow-sm">
                    <h3 class="font-display text-xl font-bold text-ink">{{ $offre['titre'] }}</h3>

                    <p class="mt-4 text-xs font-semibold uppercase tracking-wider text-ink/60">Pour qui</p>
                    <p class="mt-1 text-sm text-ink/70">{{ $offre['pour_qui'] }}</p>

                    <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-ink/60">Ce qui est livré</p>
                    <ul class="mt-2 space-y-1.5 text-sm text-ink/70">
                        @foreach($offre['livrables'] as $livrable)
                            <li class="flex items-start gap-2">
                                <svg class="mt-0.5 h-4 w-4 shrink-0 text-ink/40" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                {{ $livrable }}
                            </li>
                        @endforeach
                    </ul>

                    @if($offre['delai'])
                        <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-ink/60">Délai indicatif</p>
                        <p class="mt-1 text-sm text-ink/70">{{ $offre['delai'] }}</p>
                    @endif

                    <div class="mt-auto pt-8">
                        <a href="{{ route('contact', ['pole' => 'solutions-numeriques', 'offre' => $slug]) }}" class="btn-outline-dark w-full">
                            Demander un devis<span class="sr-only"> — {{ $offre['titre'] }}</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- TECHNOLOGIES — contenu : config/solutions.php --}}
<section class="bg-paper py-28">
    <div class="mx-auto max-w-6xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <span class="mb-4 inline-block rounded-full border border-ink/15 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-ink/60">
                Technologies
            </span>
            <h2 class="section-title">Des technologies éprouvées, choisies selon l'usage</h2>
        </div>

        <dl class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
            @foreach(config('solutions.technologies') as $groupe)
                <div data-reveal class="rounded-2xl bg-white p-6 shadow-sm">
                    <dt class="font-display text-lg font-bold text-ink">{{ $groupe['usage'] }}</dt>
                    <dd class="mt-2 text-sm text-ink/70">{{ $groupe['phrase'] }}</dd>
                    <dd class="mt-4 flex flex-wrap gap-2">
                        @foreach($groupe['technos'] as $techno)
                            <span class="rounded-full border border-ink/15 px-3 py-1 text-xs font-semibold text-ink/80">{{ $techno }}</span>
                        @endforeach
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>
@endsection

@section('content')
    @include('pages.services._pole')
@endsection
