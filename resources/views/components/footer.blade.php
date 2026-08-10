<footer class="bg-ink text-white/60">
    <div class="mx-auto max-w-7xl px-6 py-16">
        <div class="grid gap-12 lg:grid-cols-4">
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="inline-flex items-center">
                    <img src="{{ asset('images/logo-full.png') }}" alt="OYETECH" width="535" height="107" class="h-7 w-auto brightness-0 invert">
                </a>
                <p class="mt-4 text-sm leading-relaxed text-white/50">
                    Agence digitale et cabinet stratégique basé à Abidjan, au service des entreprises et institutions en Afrique et en Europe.
                </p>
                <div class="mt-6 flex gap-3">
                    <a href="#" aria-label="LinkedIn" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 text-white/35 transition hover:border-white/30 hover:bg-white/8 hover:text-white/70">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter / X" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 text-white/35 transition hover:border-white/30 hover:bg-white/8 hover:text-white/70">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="Facebook" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 text-white/35 transition hover:border-white/30 hover:bg-white/8 hover:text-white/70">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 text-white/35 transition hover:border-white/30 hover:bg-white/8 hover:text-white/70">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider text-white">Pôles</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('services.conseil') }}" class="inline-block transition hover:translate-x-1 hover:text-white">Conseil & Stratégie</a></li>
                    <li><a href="{{ route('services.communication') }}" class="inline-block transition hover:translate-x-1 hover:text-white">Communication & Publicité</a></li>
                    <li><a href="{{ route('services.marketing') }}" class="inline-block transition hover:translate-x-1 hover:text-white">Marketing Digital</a></li>
                    <li><a href="{{ route('services.solutions') }}" class="inline-block transition hover:translate-x-1 hover:text-white">Solutions Numériques</a></li>
                    <li><a href="{{ route('services.ilepay') }}" class="inline-block transition hover:translate-x-1 hover:text-white">Ilepay</a></li>
                </ul>
            </div>

            <div>
                <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider text-white">Liens utiles</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('about') }}" class="inline-block transition hover:translate-x-1 hover:text-white">À propos</a></li>
                    <li><a href="{{ route('portfolio.index') }}" class="inline-block transition hover:translate-x-1 hover:text-white">Réalisations</a></li>
                    <li><a href="{{ route('blog.index') }}" class="inline-block transition hover:translate-x-1 hover:text-white">Insights</a></li>
                    <li><a href="{{ route('contact') }}" class="inline-block transition hover:translate-x-1 hover:text-white">Contact</a></li>
                </ul>
            </div>

            <div>
                <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider text-white">Contact</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Abidjan, Côte d'Ivoire
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:contact@oyetech.ci" class="transition hover:text-white">contact@oyetech.ci</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:+2250000000000" class="transition hover:text-white">+225 00 00 00 00 00</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 text-xs text-white/35 sm:flex-row">
            <p>&copy; {{ now()->year }} OYETECH SARL. Tous droits réservés.</p>
            <p>Conçu et développé par OYETECH — Abidjan, Côte d'Ivoire</p>
        </div>
    </div>
</footer>
