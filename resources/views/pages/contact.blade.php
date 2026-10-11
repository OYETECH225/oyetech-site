@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Contact — Démarrer un projet avec OYETECH à Abidjan',
        'Contactez OYETECH pour démarrer votre projet de conseil, communication, marketing digital ou solutions numériques à Abidjan. Réponse sous 48h.'
    );
@endphp

@section('content')

<x-hero eyebrow="Contact" title="Parlons de votre projet"
    subtitle="Notre équipe vous répond rapidement pour comprendre vos besoins et vous proposer la meilleure approche." />

<section class="bg-white py-24">
    <div class="mx-auto grid max-w-7xl gap-16 px-6 lg:grid-cols-2">
        <div data-aos="fade-up">
            @if(session('success'))
                <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
                <script>
                    window.dataLayer = window.dataLayer || [];
                    window.dataLayer.push({ event: 'generate_lead', form_name: 'contact' });
                </script>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-4"
                onsubmit="window.dataLayer = window.dataLayer || []; window.dataLayer.push({ event: 'form_submit', form_name: 'contact' });">
                @csrf

                {{-- Honeypot anti-spam : champ invisible, doit rester vide --}}
                <div class="absolute left-[-9999px]" aria-hidden="true">
                    <label for="website">Laisser ce champ vide</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-ink">Nom complet *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-md border-ink/20">
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-ink">Entreprise</label>
                        <input type="text" name="company" value="{{ old('company') }}" class="mt-1 w-full rounded-md border-ink/20">
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-ink">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-md border-ink/20">
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-ink">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded-md border-ink/20">
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-ink">Pays</label>
                        <input type="text" name="country" value="{{ old('country') }}" class="mt-1 w-full rounded-md border-ink/20">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-ink">Pôle concerné</label>
                        <select name="pole" class="mt-1 w-full rounded-md border-ink/20">
                            <option value="">Sélectionner</option>
                            <option value="conseil">Conseil & Stratégie</option>
                            <option value="communication">Communication & Publicité</option>
                            <option value="marketing">Marketing Digital</option>
                            <option value="solutions">Solutions Numériques</option>
                            <option value="ilepay">Ilepay</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-ink">Budget estimé</label>
                    <input type="text" name="budget" value="{{ old('budget') }}" class="mt-1 w-full rounded-md border-ink/20">
                </div>

                <div>
                    <label class="text-sm font-medium text-ink">Message *</label>
                    <textarea name="message" rows="5" required minlength="20" class="mt-1 w-full rounded-md border-ink/20">{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-dark w-full">Envoyer ma demande</button>

                <p class="text-xs leading-relaxed text-ink/60">
                    Vos données sont utilisées uniquement pour répondre à votre demande.
                    En savoir plus : <a href="{{ route('legal.privacy') }}" class="font-semibold text-ink underline underline-offset-2 hover:no-underline">politique de confidentialité</a>.
                </p>
            </form>
        </div>

        <div class="space-y-10" data-aos="fade-up">
            <div>
                <h2 class="section-title">Nos coordonnées</h2>
                <ul class="mt-6 space-y-3 text-ink/60">
                    <li>{{ $entreprise->adresse() }}</li>
                    <li><a href="mailto:{{ $entreprise->email() }}" class="hover:text-ink">{{ $entreprise->email() }}</a></li>
                    @if($entreprise->telephone())
                        <li><a href="{{ $entreprise->telephoneHref() }}" class="hover:text-ink">{{ $entreprise->telephone() }}</a></li>
                    @endif
                </ul>
                @if($entreprise->whatsappUrl() || $entreprise->calendly())
                    <div class="mt-6 flex flex-wrap gap-3">
                        @if($entreprise->whatsappUrl())
                            <a href="{{ $entreprise->whatsappUrl() }}" target="_blank" rel="noopener" class="btn-dark inline-flex items-center gap-2">
                                <x-whatsapp-icon />
                                Écrire sur WhatsApp
                            </a>
                        @endif
                        @if($entreprise->calendly())
                            <a href="{{ $entreprise->calendly() }}" target="_blank" rel="noopener" class="btn-outline-dark inline-flex">
                                Réserver un créneau sur Calendly
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <div>
                <h2 class="section-title">Nous trouver</h2>
                <div class="mt-6 overflow-hidden rounded-2xl border border-ink/10">
                    <iframe
                        title="Localisation des bureaux OYETECH à Abidjan"
                        src="https://maps.google.com/maps?q={{ rawurlencode($entreprise->adresse()) }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        class="h-[350px] w-full"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            @if(config('services.calendly.url'))
                <div>
                    <h2 class="section-title">Réserver un créneau</h2>
                    <div class="mt-6 overflow-hidden rounded-2xl border border-ink/10">
                        <iframe src="{{ config('services.calendly.url') }}" class="h-[600px] w-full" loading="lazy"></iframe>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
