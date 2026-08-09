@props(['title', 'subtitle' => null, 'buttonLabel' => 'Démarrer un projet', 'buttonUrl' => null])

<section class="relative overflow-hidden py-24 text-white">
    {{-- Fond noir --}}
    <div class="absolute inset-0 bg-ink" aria-hidden="true"></div>
    {{-- Blobs morphants --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="blob absolute -left-20 top-0 h-[350px] w-[350px] bg-white/5"
             style="--blob-morph:17s; --blob-float:22s;"></div>
        <div class="blob absolute -bottom-10 right-0 h-[300px] w-[300px] bg-white/4"
             style="--blob-morph:22s; --blob-float:28s; animation-delay:-9s,-14s;"></div>
    </div>
    <div class="grid-dark absolute inset-0" style="--grid-size:72px; --grid-speed:28s" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-3xl px-6 text-center" data-reveal>
        <h2 class="font-display text-3xl font-extrabold leading-[1.05] tracking-tight text-white sm:text-5xl">{{ $title }}</h2>
        @if($subtitle)
            <p class="mt-5 text-lg text-white/70">{{ $subtitle }}</p>
        @endif
        <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ $buttonUrl ?? route('contact') }}" class="btn-invert magnetic inline-flex items-center gap-2">
                {{ $buttonLabel }}
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
            <a href="{{ route('portfolio.index') }}" class="btn-outline-light magnetic">Voir nos projets</a>
        </div>
    </div>
</section>
