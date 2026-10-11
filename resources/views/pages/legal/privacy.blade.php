@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Politique de confidentialité et cookies — OYETECH',
        'Comment OYETECH collecte, utilise et protège vos données personnelles (loi ivoirienne n° 2013-450) : formulaire de contact, cookies, durées de conservation et droits.'
    );
@endphp

@section('content')

<x-hero eyebrow="Données personnelles" title="Politique de confidentialité" />

<section class="bg-white py-20">
    <div class="prose prose-neutral mx-auto max-w-3xl px-6 prose-headings:font-display prose-headings:tracking-tight prose-a:text-ink">
        <p>
            {{ $entreprise->get('raison_sociale') }} attache une grande importance à la protection de vos données personnelles.
            Cette politique explique quelles données nous collectons sur ce site, pourquoi, combien de temps nous les gardons
            et comment exercer vos droits, conformément à la loi ivoirienne n° 2013-450 du 19 juin 2013 relative à la protection
            des données à caractère personnel, dont l'application est contrôlée par l'Autorité de Régulation des
            Télécommunications/TIC de Côte d'Ivoire (ARTCI).
        </p>

        <h2>1. Responsable du traitement</h2>
        <ul>
            <li>{{ $entreprise->get('raison_sociale') }}, <x-legal-value :value="$entreprise->get('adresse.rue')" />, {{ $entreprise->get('adresse.ville') }}, {{ $entreprise->get('adresse.pays') }}</li>
            <li>RCCM : <x-legal-value :value="$entreprise->get('rccm')" /></li>
            <li>Représentant : {{ $entreprise->get('responsable_publication.nom') }}, {{ $entreprise->get('responsable_publication.fonction') }}</li>
            <li>Contact : <a href="mailto:{{ $entreprise->email() }}">{{ $entreprise->email() }}</a></li>
            <li>Formalités préalables auprès de l'ARTCI (référence) : <x-legal-value /></li>
        </ul>

        <h2>2. Données collectées par le formulaire de contact</h2>
        <p>Lorsque vous utilisez le <a href="{{ route('contact') }}">formulaire de contact</a>, nous collectons :</p>
        <ul>
            <li>votre nom complet, votre adresse email et votre message (obligatoires) ;</li>
            <li>le nom de votre entreprise, votre téléphone, votre pays, le pôle concerné et votre budget estimé (facultatifs).</li>
        </ul>
        <p>Nous ne collectons aucune donnée sensible et vous demandons de ne pas en indiquer dans votre message.</p>

        <h2>3. Finalités et base légale</h2>
        <ul>
            <li><strong>Répondre à votre demande</strong> et, le cas échéant, préparer une proposition commerciale : traitement fondé sur votre demande (mesures précontractuelles) et votre consentement, exprimé par l'envoi du formulaire.</li>
            <li><strong>Assurer le suivi de la relation</strong> commerciale qui en découle : intérêt légitime d'{{ $entreprise->get('nom') }}.</li>
            <li><strong>Mesurer l'audience du site et la performance de nos campagnes</strong> : uniquement avec votre consentement, donné dans le bandeau cookies.</li>
        </ul>
        <p>Vos données ne sont jamais vendues ni utilisées pour une autre finalité que celles décrites ici.</p>

        <h2>4. Durée de conservation</h2>
        <ul>
            <li>Demandes de contact et prospects : <strong>3 ans à compter du dernier contact</strong> de votre part, puis suppression.</li>
            <li>Données de clients : pendant la durée de la relation contractuelle, puis pendant les durées imposées par les obligations légales (comptables et fiscales notamment).</li>
            <li>Choix relatif aux cookies : 6 mois, après quoi votre choix vous est redemandé.</li>
        </ul>

        <h2>5. Destinataires</h2>
        <p>
            Vos données sont destinées aux seules équipes d'{{ $entreprise->get('nom') }} en charge de votre demande.
            Elles peuvent être traitées, pour notre compte et selon nos instructions, par nos prestataires techniques :
        </p>
        <ul>
            <li>l'hébergeur du site (<x-legal-value :value="$entreprise->get('hebergeur.nom')" />) ;</li>
            <li>notre prestataire de messagerie électronique, pour l'envoi des notifications de demande ;</li>
            <li>avec votre consentement uniquement : Google (Google Tag Manager, Google Analytics){{ config('services.meta_pixel.id') ? ', Meta' : '' }}{{ config('services.linkedin.partner_id') ? ', LinkedIn' : '' }} pour la mesure d'audience et la publicité ;</li>
            <li>Calendly, si vous choisissez de réserver un créneau de rendez-vous ;</li>
            <li>Google Maps, pour l'affichage de la carte sur la page contact.</li>
        </ul>

        <h2>6. Transferts hors de Côte d'Ivoire</h2>
        <p>
            Certains de ces prestataires (notamment Google, Calendly{{ config('services.meta_pixel.id') ? ', Meta' : '' }}{{ config('services.linkedin.partner_id') ? ', LinkedIn' : '' }})
            et, le cas échéant, l'hébergeur du site traitent des données hors de Côte d'Ivoire, en particulier aux États-Unis
            et dans l'Union européenne. Ces transferts sont encadrés par les garanties contractuelles proposées par ces
            prestataires et réalisés dans le respect des conditions prévues par la loi n° 2013-450.
        </p>

        <h2>7. Vos droits</h2>
        <p>Vous disposez à tout moment des droits suivants sur vos données :</p>
        <ul>
            <li><strong>droit d'accès</strong> : savoir quelles données nous détenons sur vous et en obtenir une copie ;</li>
            <li><strong>droit de rectification</strong> : faire corriger des données inexactes ou incomplètes ;</li>
            <li><strong>droit d'opposition</strong> : vous opposer, pour un motif légitime, au traitement de vos données, et sans motif à leur utilisation à des fins de prospection ;</li>
            <li><strong>droit de suppression</strong> : demander l'effacement de vos données.</li>
        </ul>
        <p>
            Pour les exercer, écrivez-nous à <a href="mailto:{{ $entreprise->email() }}">{{ $entreprise->email() }}</a>
            en précisant votre demande ; nous pourrons vous demander de justifier de votre identité. Si vous estimez, après
            nous avoir contactés, que vos droits ne sont pas respectés, vous pouvez saisir l'ARTCI
            (<a href="https://www.artci.ci" target="_blank" rel="noopener">www.artci.ci</a>).
        </p>

        <h2 id="cookies">8. Cookies et traceurs</h2>
        <p>Nous utilisons deux catégories de cookies et traceurs :</p>
        <ul>
            <li>
                <strong>Strictement nécessaires</strong> (sans consentement) : cookie de session et jeton de sécurité du formulaire
                (protection contre la falsification de requêtes), mémorisation de votre choix sur les cookies dans votre navigateur.
            </li>
            <li>
                <strong>Mesure d'audience et publicité</strong> (avec consentement) : Google Tag Manager et Google Analytics{{ config('services.meta_pixel.id') ? ', pixel Meta' : '' }}{{ config('services.linkedin.partner_id') ? ', LinkedIn Insight Tag' : '' }}.
                Ces outils ne sont chargés qu'après un clic sur « Accepter » ; sans accord, aucune requête n'est envoyée à ces services.
                Leurs durées de conservation sont fixées par chaque prestataire dans sa propre politique.
            </li>
        </ul>
        <p>
            Vous pouvez modifier votre choix à tout moment :
            <button type="button" x-data @click="$dispatch('open-cookie-banner')" class="font-semibold text-ink underline underline-offset-2 hover:no-underline">gérer les cookies</button>.
            Vous pouvez aussi configurer votre navigateur pour bloquer ou supprimer les cookies.
        </p>

        <h2>9. Sécurité</h2>
        <p>
            Nous mettons en œuvre des mesures techniques et organisationnelles adaptées pour protéger vos données : connexion
            chiffrée (HTTPS), accès à l'administration restreint et authentifié, sauvegardes régulières.
        </p>

        <h2>10. Contact et mise à jour</h2>
        <p>
            Pour toute question sur cette politique : <a href="mailto:{{ $entreprise->email() }}">{{ $entreprise->email() }}</a>.
            Cette politique peut évoluer ; la version en vigueur est celle publiée sur cette page.
        </p>
    </div>
</section>

@endsection
