@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Ilepay — Paiement de loyer en ligne en Côte d\'Ivoire | OYETECH',
        $service->summary
    );
@endphp

@section('content')

<x-breadcrumb-schema :items="['Accueil' => route('home'), 'Services' => route('services.index'), $service->name => $service->url]" />

<section class="sunburst-bg grain relative overflow-hidden bg-ink pt-40 pb-24 text-white" data-reveal-group>
    <div class="relative mx-auto max-w-4xl px-6 text-center">
        <span class="mb-4 inline-block rounded-full border border-white/20 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-white/60" data-reveal>
            Solution de paiement OYETECH
        </span>
        <h1 class="font-display text-4xl font-extrabold leading-[1.05] tracking-tight text-white sm:text-6xl" data-reveal-words>
            @foreach(explode(' ', 'Ilepay') as $word)
                <span data-reveal-word>{{ $word }}</span>{{ ' ' }}
            @endforeach
        </h1>
        <p class="mx-auto mt-6 max-w-2xl text-lg text-white/60" data-reveal>{{ $service->summary }}</p>
        <div class="mt-10 flex flex-wrap items-center justify-center gap-4" data-reveal>
            <a href="#demo" class="btn-invert">Demander une démo</a>
            <a href="{{ route('contact') }}" class="btn-outline-light">Parler à un expert</a>
        </div>
    </div>
</section>

<section class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <h2 class="section-title">Simplifier les paiements, au quotidien</h2>
            <p class="mt-4 text-ink/60">
                Ilepay est une solution digitale de paiement développée par OYETECH. Son premier usage est centré sur
                le paiement de loyer, avec une expérience simple, rapide et sécurisée pour les propriétaires,
                gestionnaires et locataires en Côte d'Ivoire.
            </p>
        </div>
        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($service->deliverables ?? [] as $feature)
                <div class="rounded-2xl bg-paper p-6 text-center" data-aos="fade-up">
                    <p class="font-semibold text-ink">{{ $feature }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-paper py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <h2 class="section-title">Cas d'usage</h2>
        </div>
        <div class="mt-14 grid gap-8 sm:grid-cols-3">
            <div class="rounded-2xl bg-white p-8 shadow-sm" data-aos="fade-up">
                <h3 class="font-bold text-ink">Propriétaires</h3>
                <p class="mt-2 text-sm text-ink/60">Suivez vos loyers encaissés et l'état de vos contrats de location en temps réel.</p>
            </div>
            <div class="rounded-2xl bg-white p-8 shadow-sm" data-aos="fade-up">
                <h3 class="font-bold text-ink">Gestionnaires & agences immobilières</h3>
                <p class="mt-2 text-sm text-ink/60">Centralisez la gestion de plusieurs biens, contrats et locataires sur une seule plateforme.</p>
            </div>
            <div class="rounded-2xl bg-white p-8 shadow-sm" data-aos="fade-up">
                <h3 class="font-bold text-ink">Locataires</h3>
                <p class="mt-2 text-sm text-ink/60">Payez votre loyer en ligne en toute sécurité, sans déplacement ni paperasse.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-24">
    <div class="mx-auto max-w-4xl px-6 text-center" data-aos="fade-up">
        <h2 class="section-title">Une solution qui a vocation à évoluer</h2>
        <p class="mt-4 text-ink/60">
            Ilepay a vocation à évoluer progressivement pour faciliter d'autres types de paiements et de services
            financiers du quotidien, tout en proposant une gestion centralisée des transactions et des justificatifs.
        </p>
    </div>
</section>

<section id="demo" class="bg-white py-24">
    <div class="mx-auto max-w-2xl px-6" data-aos="fade-up">
        <div class="text-center">
            <h2 class="section-title">Demander une démo</h2>
            <p class="mt-4 text-ink/60">Nos équipes vous présentent Ilepay et son intégration à votre activité immobilière.</p>
        </div>

        <form action="{{ route('contact.store') }}" method="POST" class="mt-10 space-y-4">
            @csrf
            <input type="hidden" name="pole" value="ilepay">

            {{-- Honeypot anti-spam : champ invisible, doit rester vide --}}
            <div class="absolute left-[-9999px]" aria-hidden="true">
                <label for="website-ilepay">Laisser ce champ vide</label>
                <input type="text" id="website-ilepay" name="website" tabindex="-1" autocomplete="off">
            </div>
            <div>
                <label class="text-sm font-medium text-ink">Nom complet</label>
                <input type="text" name="name" required class="mt-1 w-full rounded-md border-ink/20">
            </div>
            <div>
                <label class="text-sm font-medium text-ink">Entreprise / Agence</label>
                <input type="text" name="company" class="mt-1 w-full rounded-md border-ink/20">
            </div>
            <div>
                <label class="text-sm font-medium text-ink">Email</label>
                <input type="email" name="email" required class="mt-1 w-full rounded-md border-ink/20">
            </div>
            <div>
                <label class="text-sm font-medium text-ink">Message</label>
                <textarea name="message" rows="4" required minlength="20" class="mt-1 w-full rounded-md border-ink/20"></textarea>
            </div>
            <button type="submit" class="btn-dark w-full">Envoyer ma demande</button>
        </form>
    </div>
</section>

<section class="bg-paper py-24">
    <div class="mx-auto max-w-3xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <h2 class="section-title">Questions fréquentes</h2>
        </div>

        <div class="mt-12">
            <x-faq :items="app(\App\Services\Faq::class)->ilepay()" />
        </div>
    </div>
</section>

<x-cta-band title="Digitalisez la gestion de vos biens dès aujourd'hui" />

@endsection
