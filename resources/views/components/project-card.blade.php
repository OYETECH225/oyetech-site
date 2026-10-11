@props(['project'])

@php
    $poleLabel = \App\Http\Requests\ContactRequest::POLES[$project->pole] ?? ucfirst($project->pole);
    $poleIcon = [
        'conseil' => 'heroicon-o-light-bulb',
        'communication' => 'heroicon-o-megaphone',
        'marketing' => 'heroicon-o-chart-bar',
        'solutions' => 'heroicon-o-code-bracket',
        'ilepay' => 'heroicon-o-credit-card',
    ][$project->pole] ?? 'heroicon-o-sparkles';
@endphp

<a href="{{ route('portfolio.show', $project) }}" class="group block overflow-hidden rounded-2xl border border-ink/8 bg-white shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl" data-reveal>
    <div class="sunburst-bg relative flex aspect-[4/3] items-center justify-center overflow-hidden bg-ink">
        @if($project->cover_url)
            <img src="{{ $project->cover_url }}" alt="{{ $project->title }}" width="600" height="450" loading="lazy"
                class="absolute inset-0 h-full w-full scale-110 object-cover transition duration-700 group-hover:scale-100">
        @else
            {{-- Visuel de remplacement tant qu'aucune image n'est ajoutée dans l'admin --}}
            <div class="flex flex-col items-center gap-4 text-center" aria-hidden="true">
                <span class="flex h-16 w-16 items-center justify-center rounded-2xl border border-white/15 bg-white/10 text-white">
                    <x-dynamic-component :component="$poleIcon" class="h-8 w-8" />
                </span>
                <span class="font-display text-sm font-bold uppercase tracking-widest text-white/70">{{ $poleLabel }}</span>
            </div>
        @endif
        {{-- Overlay au hover --}}
        <div class="absolute inset-0 flex items-center justify-center bg-ink/70 opacity-0 backdrop-blur-sm transition duration-300 group-hover:opacity-100">
            <span class="flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-ink shadow-lg">
                Voir le projet
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </span>
        </div>
        @if($project->cover_url)
            <span class="absolute left-4 top-4 rounded-full bg-white px-3 py-1 text-xs font-semibold uppercase tracking-wide text-ink">
                {{ $poleLabel }}
            </span>
        @endif
    </div>
    <div class="border-t border-ink/5 p-6">
        <p class="text-xs font-semibold uppercase tracking-wider text-ink/60">{{ $project->client }}</p>
        <h3 class="mt-1.5 font-display text-lg font-bold text-ink">{{ $project->title }}</h3>
        <p class="mt-1 text-sm text-ink/60">{{ $project->sector }}</p>
    </div>
</a>
