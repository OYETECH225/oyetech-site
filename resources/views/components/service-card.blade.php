@props(['service'])

<a href="{{ $service->url }}"
    class="magnetic group relative block overflow-hidden rounded-2xl border border-ink/8 bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-2 hover:border-ink/20 hover:shadow-xl hover:shadow-black/5"
    data-reveal>
    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-ink/6 text-ink transition-all duration-300 group-hover:bg-ink group-hover:text-white group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-black/20">
        <x-dynamic-component :component="$service->icon ?? 'heroicon-o-sparkles'" class="h-7 w-7" />
    </div>
    <h3 class="font-display text-lg font-bold text-ink">{{ $service->name }}</h3>
    <p class="mt-2 text-sm leading-relaxed text-ink/60">{{ $service->summary }}</p>
    <span class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-ink transition-all group-hover:gap-2">
        En savoir plus
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
    </span>
    <div class="pointer-events-none absolute -right-4 -top-4 h-20 w-20 rounded-full bg-ink/3 transition-all duration-500 group-hover:scale-[3]"></div>
</a>
