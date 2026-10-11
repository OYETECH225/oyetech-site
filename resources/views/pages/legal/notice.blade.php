@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Mentions légales — OYETECH',
        'Mentions légales du site oyetech-ci.com : éditeur OYETECH SARL (Abidjan, Côte d\'Ivoire), responsable de publication, hébergeur et propriété intellectuelle.'
    );
@endphp

@section('content')

<x-hero eyebrow="Informations légales" title="Mentions légales" />

<section class="bg-white py-20">
    <div class="prose prose-neutral mx-auto max-w-3xl px-6 prose-headings:font-display prose-headings:tracking-tight prose-a:text-ink">
        <h2>Éditeur du site</h2>
        <p>
            Le site <a href="{{ $entreprise->get('url') }}">{{ preg_replace('#^https?://#', '', $entreprise->get('url')) }}</a> est édité par :
        </p>
        <ul>
            <li><strong>Raison sociale :</strong> {{ $entreprise->get('raison_sociale') }}</li>
            <li><strong>Forme juridique :</strong> <x-legal-value :value="$entreprise->get('forme_juridique')" /></li>
            <li><strong>Capital social :</strong> <x-legal-value :value="$entreprise->get('capital')" /></li>
            <li><strong>RCCM :</strong> <x-legal-value :value="$entreprise->get('rccm')" /></li>
            <li><strong>Siège social :</strong> <x-legal-value :value="$entreprise->get('adresse.rue')" />, {{ $entreprise->get('adresse.ville') }}, {{ $entreprise->get('adresse.pays') }}</li>
            <li><strong>Téléphone :</strong>
                @if($entreprise->telephone())
                    <a href="{{ $entreprise->telephoneHref() }}">{{ $entreprise->telephone() }}</a>
                @else
                    <x-legal-value />
                @endif
            </li>
            <li><strong>Email :</strong> <a href="mailto:{{ $entreprise->email() }}">{{ $entreprise->email() }}</a></li>
        </ul>

        <h2>Responsable de la publication</h2>
        <p>
            {{ $entreprise->get('responsable_publication.nom') }}, {{ $entreprise->get('responsable_publication.fonction') }}.
        </p>

        <h2>Hébergeur</h2>
        <ul>
            <li><strong>Nom :</strong> <x-legal-value :value="$entreprise->get('hebergeur.nom')" /></li>
            <li><strong>Adresse :</strong> <x-legal-value :value="$entreprise->get('hebergeur.adresse')" /></li>
            <li><strong>Site web :</strong>
                @if($entreprise->get('hebergeur.site'))
                    <a href="{{ $entreprise->get('hebergeur.site') }}" target="_blank" rel="noopener">{{ $entreprise->get('hebergeur.site') }}</a>
                @else
                    <x-legal-value />
                @endif
            </li>
        </ul>

        <h2>Propriété intellectuelle</h2>
        <p>
            L'ensemble des éléments de ce site (textes, logos, marques, visuels, mise en page, code) est la propriété exclusive
            de {{ $entreprise->get('raison_sociale') }} ou fait l'objet d'une autorisation d'utilisation. Toute reproduction,
            représentation, modification ou adaptation, totale ou partielle, sans autorisation écrite préalable est interdite.
        </p>
        <p>
            Les marques et logos de clients ou de partenaires éventuellement présentés sur le site restent la propriété de
            leurs titulaires respectifs et ne sont reproduits qu'avec leur accord.
        </p>

        <h2>Crédits</h2>
        <p>
            Conception, développement et contenus : {{ $entreprise->get('nom') }}, {{ $entreprise->get('adresse.ville') }}.
            Polices de caractères : Inter et Bricolage Grotesque (Google Fonts, licence SIL Open Font License).
        </p>

        <h2>Données personnelles et cookies</h2>
        <p>
            Le traitement de vos données personnelles et l'usage des cookies sont décrits dans notre
            <a href="{{ route('legal.privacy') }}">politique de confidentialité</a>.
        </p>

        <h2>Droit applicable</h2>
        <p>
            Le présent site et ses mentions légales sont soumis au droit ivoirien.
        </p>
    </div>
</section>

@endsection
