@props(['title', 'subtitle' => null, 'eyebrow' => null])

<section class="grain relative overflow-hidden bg-ink pt-40 pb-24 text-white">
    <div class="grid-dark absolute inset-0" style="--grid-size:80px; --grid-speed:34s" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-4xl px-6 text-center">
        @if($eyebrow)
            <span class="mb-4 inline-block rounded-full border border-white/20 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-white/60">
                {{ $eyebrow }}
            </span>
        @endif

        {{-- Titre affiché dès le premier rendu : c'est l'élément LCP des pages intérieures --}}
        <h1 class="font-display text-4xl font-extrabold leading-[1.05] tracking-tight text-white sm:text-5xl">{{ $title }}</h1>

        @if($subtitle)
            <p class="mx-auto mt-6 max-w-2xl text-lg text-white/60">{{ $subtitle }}</p>
        @endif

        {{ $slot }}
    </div>
</section>
