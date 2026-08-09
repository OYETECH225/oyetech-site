@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Contact — OYETECH',
        'Contactez OYETECH pour démarrer votre projet de conseil, communication, marketing digital ou solutions numériques à Abidjan.'
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
            </form>
        </div>

        <div class="space-y-10" data-aos="fade-up">
            <div>
                <h2 class="section-title">Nos coordonnées</h2>
                <ul class="mt-6 space-y-3 text-ink/60">
                    <li>Abidjan, Côte d'Ivoire</li>
                    <li><a href="mailto:contact@oyetech.ci" class="hover:text-ink">contact@oyetech.ci</a></li>
                    <li><a href="tel:+2250000000000" class="hover:text-ink">+225 00 00 00 00 00</a></li>
                </ul>
            </div>

            <div>
                <h2 class="section-title">Nous trouver</h2>
                <div class="mt-6 overflow-hidden rounded-2xl border border-ink/10">
                    <iframe
                        title="Localisation des bureaux OYETECH à Abidjan"
                        src="https://maps.google.com/maps?q=Abidjan%2C%20C%C3%B4te%20d%27Ivoire&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        class="h-[350px] w-full"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <p class="mt-2 text-xs text-ink/45">Localisation indicative — adresse exacte des bureaux à venir.</p>
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
