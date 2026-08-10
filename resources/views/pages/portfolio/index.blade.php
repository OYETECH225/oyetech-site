@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Réalisations — OYETECH',
        'Découvrez les projets et études de cas menés par OYETECH pour ses clients en Afrique et en Europe, avec des résultats chiffrés.'
    );
@endphp

@section('content')

<x-hero eyebrow="Réalisations" title="Des résultats concrets pour nos clients"
    subtitle="Découvrez nos études de cas et les résultats chiffrés obtenus pour nos clients à travers nos cinq pôles d'expertise." />

<section class="bg-white py-24" x-data="{ filter: 'all' }">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-wrap justify-center gap-2" data-aos="fade-up">
            @foreach(['all' => 'Tous', 'conseil' => 'Conseil', 'communication' => 'Communication', 'marketing' => 'Marketing', 'solutions' => 'Solutions', 'ilepay' => 'Ilepay'] as $key => $label)
                <button @click="filter = '{{ $key }}'"
                    :class="filter === '{{ $key }}' ? 'bg-ink text-white' : 'bg-paper text-ink/60'"
                    class="rounded-full px-4 py-2 text-sm font-medium transition">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($projects as $project)
                <div x-show="filter === 'all' || filter === '{{ $project->pole }}'">
                    <x-project-card :project="$project" />
                </div>
            @empty
                <p class="col-span-full text-center text-ink/60">Aucune réalisation publiée pour le moment.</p>
            @endforelse
        </div>
    </div>
</section>

<x-cta-band title="Votre projet pourrait être notre prochaine réussite" />

@endsection
