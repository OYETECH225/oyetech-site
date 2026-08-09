@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'À propos — OYETECH',
        'Vision, mission, valeurs et gouvernance d\'OYETECH, cabinet stratégique et acteur technologique de référence en Côte d\'Ivoire.'
    );
@endphp

@section('content')

<x-hero eyebrow="À propos" title="Cabinet stratégique et acteur technologique opérationnel"
    subtitle="OYETECH réunit conseil, communication, marketing digital et solutions numériques au service de la croissance de ses clients en Côte d'Ivoire." />

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
                    Plus de 12 ans d'expérience cumulée en conseil, communication, marketing digital et développement
                    de solutions numériques, au service d'entreprises et d'institutions de Côte d'Ivoire.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="bg-paper py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <h2 class="section-title">Équipe dirigeante</h2>
        </div>

        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($team as $member)
                <div class="rounded-2xl bg-white p-6 text-center shadow-sm" data-aos="fade-up">
                    @if($member->photo_url)
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" width="96" height="96" loading="lazy" class="mx-auto h-24 w-24 rounded-full object-cover">
                    @else
                        <div class="mx-auto h-24 w-24 rounded-full bg-ink/5"></div>
                    @endif
                    <h3 class="mt-4 font-bold text-ink">{{ $member->name }}</h3>
                    <p class="text-sm text-ink/60">{{ $member->role }}</p>
                    @if($member->bio)
                        <p class="mt-2 text-sm text-ink/60">{{ $member->bio }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<x-cta-band title="Construisons ensemble votre prochain chapitre" />

@endsection
