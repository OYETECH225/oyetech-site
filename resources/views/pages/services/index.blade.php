@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Nos pôles d\'expertise — OYETECH',
        'Découvrez les cinq pôles d\'expertise d\'OYETECH : conseil & stratégie, communication, marketing digital, solutions numériques et Ilepay.'
    );
@endphp

@section('content')

<x-hero eyebrow="Nos services" title="Cinq pôles, une seule ambition"
    subtitle="Une expertise complète pour accompagner chaque étape de votre transformation digitale." />

<section class="bg-white py-28">
    <div class="mx-auto max-w-7xl px-6">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
            @foreach($services as $service)
                <a href="{{ $service->url }}" data-reveal
                    class="magnetic group relative block overflow-hidden rounded-3xl border border-ink/10 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-2xl motion-reduce:transition-none">
                    <div class="sunburst-bg grain relative flex h-40 items-center justify-center overflow-hidden bg-ink">
                        <x-dynamic-component :component="$service->icon ?? 'heroicon-o-sparkles'" class="h-12 w-12 text-white/30 transition-transform duration-300 group-hover:scale-110" />
                        <span class="absolute -bottom-5 right-6 flex h-12 w-12 items-center justify-center rounded-full bg-white text-ink shadow-lg transition-transform duration-300 group-hover:rotate-45">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </span>
                    </div>

                    <div class="p-8 pt-10">
                        <h2 class="font-display text-2xl font-bold text-ink">{{ $service->name }}</h2>
                        <p class="mt-3 text-ink/60">{{ $service->summary }}</p>

                        @if(!empty($service->deliverables))
                            <ul class="mt-6 space-y-2 text-sm text-ink/60">
                                @foreach(array_slice($service->deliverables, 0, 3) as $deliverable)
                                    <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4 shrink-0 text-ink/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        {{ $deliverable }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <span class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-ink group-hover:gap-2 transition-all">
                            Explorer ce pôle
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<x-cta-band title="Un projet en tête ? Parlons-en." />

@endsection
