@props(['transparent' => false])

<header x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 24)"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
    :class="scrolled ? 'bg-ink/95 shadow-lg backdrop-blur' : '{{ $transparent ? 'bg-transparent' : 'bg-ink' }}'">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('images/logo-full.png') }}" alt="OYETECH" width="535" height="107" class="h-7 w-auto brightness-0 invert">
        </a>

        <div class="hidden items-center gap-8 lg:flex">
            <a href="{{ route('home') }}" class="text-sm font-medium text-white/70 transition hover:text-white">Accueil</a>
            <a href="{{ route('about') }}" class="text-sm font-medium text-white/70 transition hover:text-white">À propos</a>

            <div class="relative" x-data="{ servicesOpen: false }" @mouseleave="servicesOpen = false">
                <button @mouseenter="servicesOpen = true" :aria-expanded="servicesOpen"
                    class="flex items-center gap-1 text-sm font-medium text-white/70 transition hover:text-white">
                    Services
                    <svg class="h-4 w-4 transition-transform duration-200" :class="servicesOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="servicesOpen" x-cloak x-transition class="absolute left-0 top-full w-64 pt-2">
                    <div class="overflow-hidden rounded-2xl bg-white p-2 shadow-2xl">
                        <a href="{{ route('services.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-ink hover:bg-ink/5">Tous nos pôles</a>
                        <a href="{{ route('services.conseil') }}" class="block rounded-xl px-4 py-3 text-sm text-ink/60 hover:bg-ink/5 hover:text-ink">Conseil & Stratégie</a>
                        <a href="{{ route('services.communication') }}" class="block rounded-xl px-4 py-3 text-sm text-ink/60 hover:bg-ink/5 hover:text-ink">Communication & Publicité</a>
                        <a href="{{ route('services.marketing') }}" class="block rounded-xl px-4 py-3 text-sm text-ink/60 hover:bg-ink/5 hover:text-ink">Marketing Digital</a>
                        <a href="{{ route('services.solutions') }}" class="block rounded-xl px-4 py-3 text-sm text-ink/60 hover:bg-ink/5 hover:text-ink">Solutions Numériques</a>
                        <a href="{{ route('services.ilepay') }}" class="block rounded-xl px-4 py-3 text-sm text-ink/60 hover:bg-ink/5 hover:text-ink">Ilepay</a>
                    </div>
                </div>
            </div>

            <a href="{{ route('portfolio.index') }}" class="text-sm font-medium text-white/70 transition hover:text-white">Réalisations</a>
            <a href="{{ route('blog.index') }}" class="text-sm font-medium text-white/70 transition hover:text-white">Insights</a>
        </div>

        <div class="hidden lg:block">
            <a href="{{ route('contact') }}" class="btn-invert magnetic">Démarrer un projet</a>
        </div>

        <button @click="open = !open" :aria-expanded="open" aria-label="Menu" aria-controls="mobile-menu"
            class="flex min-h-11 min-w-11 items-center justify-center text-white lg:hidden">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </nav>

    <div id="mobile-menu" x-show="open" x-cloak x-transition class="border-t border-white/10 bg-ink px-6 pb-6 lg:hidden">
        <div class="space-y-1 pt-3">
            <a href="{{ route('home') }}" class="block rounded-xl px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white">Accueil</a>
            <a href="{{ route('about') }}" class="block rounded-xl px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white">À propos</a>
            <a href="{{ route('services.index') }}" class="block rounded-xl px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white">Services</a>
            <a href="{{ route('portfolio.index') }}" class="block rounded-xl px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white">Réalisations</a>
            <a href="{{ route('blog.index') }}" class="block rounded-xl px-4 py-3 text-white/70 hover:bg-white/5 hover:text-white">Insights</a>
            <a href="{{ route('contact') }}" class="btn-invert mt-3 block text-center">Démarrer un projet</a>
        </div>
    </div>
</header>
