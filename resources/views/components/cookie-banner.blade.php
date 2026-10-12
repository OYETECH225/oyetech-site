{{-- Bandeau de consentement : logique dans resources/js/consent.js. « Refuser » et
     « Accepter » ont volontairement le même style. Rouvert via « Gérer les cookies » (footer). --}}
<section x-data="cookieConsent" x-show="open" x-cloak x-transition.opacity
    @open-cookie-banner.window="reopen()"
    role="region" aria-labelledby="cookie-banner-title"
    class="fixed inset-x-4 bottom-4 z-[60] mx-auto max-w-2xl rounded-2xl border border-ink/10 bg-white p-6 text-ink shadow-2xl shadow-black/20 sm:inset-x-6">
    <h2 id="cookie-banner-title" x-ref="title" tabindex="-1" class="font-display text-lg font-bold focus:outline-none">
        Votre choix sur les cookies
    </h2>
    <p class="mt-2 text-sm leading-relaxed text-ink/70">
        Avec votre accord, nous utilisons des traceurs de mesure d'audience et de publicité (Google, et le cas échéant Meta et LinkedIn)
        pour comprendre l'utilisation du site et améliorer nos services. Vous pouvez refuser : le site fonctionne normalement.
        Vous pourrez changer d'avis à tout moment via « Gérer les cookies » en bas de page.
        <a href="{{ route('legal.privacy') }}#cookies" class="font-semibold text-ink underline underline-offset-2 hover:no-underline">En savoir plus sur les cookies</a>
    </p>
    <div class="mt-5 grid gap-3 sm:grid-cols-2">
        <button type="button" @click="refuse()" class="btn-dark w-full">Refuser</button>
        <button type="button" @click="accept()" class="btn-dark w-full">Accepter</button>
    </div>
</section>
