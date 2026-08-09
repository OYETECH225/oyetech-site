@props(['project'])

<a href="{{ route('portfolio.show', $project) }}" class="magnetic group block overflow-hidden rounded-2xl border border-ink/8 bg-white shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl" data-reveal>
    <div class="sunburst-bg relative flex aspect-[4/3] items-center justify-center overflow-hidden bg-ink">
        @if($project->cover_url)
            <img src="{{ $project->cover_url }}" alt="{{ $project->title }}" width="600" height="450" loading="lazy"
                class="absolute inset-0 h-full w-full scale-110 object-cover transition duration-700 group-hover:scale-100">
        @else
            <span class="font-display select-none text-6xl font-extrabold text-white/15">
                {{ mb_substr($project->client, 0, 1) }}
            </span>
        @endif
        {{-- Overlay au hover --}}
        <div class="absolute inset-0 flex items-center justify-center bg-ink/70 opacity-0 backdrop-blur-sm transition duration-300 group-hover:opacity-100">
            <span class="flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-ink shadow-lg">
                Voir le projet
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </span>
        </div>
        <span class="absolute left-4 top-4 rounded-full bg-white px-3 py-1 text-xs font-semibold uppercase tracking-wide text-ink">
            {{ $project->pole }}
        </span>
    </div>
    <div class="border-t border-ink/5 p-6">
        <p class="text-xs font-semibold uppercase tracking-wider text-ink/50">{{ $project->client }}</p>
        <h3 class="mt-1.5 font-display text-lg font-bold text-ink">{{ $project->title }}</h3>
        <p class="mt-1 text-sm text-ink/55">{{ $project->sector }}</p>
    </div>
</a>
