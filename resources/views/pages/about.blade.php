@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'À propos d\'OYETECH, cabinet stratégique et agence digitale à Abidjan',
        'Vision, mission, valeurs et gouvernance d\'OYETECH, cabinet stratégique et acteur technologique basé à Abidjan, intervenant en Afrique.'
    );
@endphp

@section('content')

<x-hero eyebrow="À propos" title="Cabinet stratégique et acteur technologique opérationnel"
    subtitle="OYETECH réunit conseil, communication, marketing digital et solutions numériques au service de la croissance de ses clients en Afrique." />

<section class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="grid gap-12 sm:grid-cols-2">
            <div data-aos="fade-up">
                <h2 class="section-title">Notre vision</h2>
                <p class="mt-4 text-ink/60">
                    Devenir le partenaire stratégique et technologique de référence des organisations qui structurent
                    l'avenir économique de l'Afrique de l'Ouest.
                </p>
            </div>
            <div data-aos="fade-up">
                <h2 class="section-title">Notre mission</h2>
                <p class="mt-4 text-ink/60">
                    Accompagner entreprises, institutions et startups dans leur transformation digitale, en combinant
                    rigueur stratégique, créativité et excellence technologique.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="bg-paper py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <h2 class="section-title">Nos valeurs</h2>
        </div>
        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach([
                ['title' => 'Exigence', 'text' => 'Une rigueur stratégique et technique à chaque étape de nos missions.'],
                ['title' => 'Innovation', 'text' => 'Une veille constante sur les technologies et usages qui transforment nos marchés.'],
                ['title' => 'Intégrité', 'text' => 'Une relation de confiance et de transparence avec chacun de nos clients.'],
                ['title' => 'Impact', 'text' => 'Des résultats mesurables, orientés performance et retour sur investissement.'],
            ] as $value)
                <div class="rounded-2xl bg-white p-6 text-center shadow-sm" data-aos="fade-up">
                    <h3 class="font-bold text-ink">{{ $value['title'] }}</h3>
                    <p class="mt-2 text-sm text-ink/60">{{ $value['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="grid gap-12 sm:grid-cols-2">
            <div data-aos="fade-up">
                <h2 class="section-title">Gouvernance</h2>
                <p class="mt-4 text-ink/60">
                    OYETECH s'appuie sur une gouvernance structurée, pilotée par un comité de direction garant de la
                    qualité stratégique et opérationnelle de chaque mission confiée à l'agence.
                </p>
            </div>
            <div data-aos="fade-up">
                <h2 class="section-title">Expertise stratégique</h2>
                <p class="mt-4 text-ink/60">
                    @if($entreprise->afficheAnciennete()){{ $entreprise->anciennete() }} ans d'expérience, depuis {{ $entreprise->anneeCreation() }}, @else Une expertise @endif en conseil, communication, marketing digital et développement
                    de solutions numériques, au service d'entreprises et d'institutions en Afrique.
                </p>
            </div>
        </div>
    </div>
</section>

@if($team->isNotEmpty())
<section class="bg-paper py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <h2 class="section-title">Équipe dirigeante</h2>
        </div>

        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($team as $member)
                <x-team-card :member="$member" :bio="true" data-aos="fade-up" />
            @endforeach
        </div>
    </div>
</section>
@endif

<x-cta-band title="Construisons ensemble votre prochain chapitre" />

@endsection
