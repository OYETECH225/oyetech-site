@props(['article'])

<a href="{{ route('blog.show', $article) }}" class="magnetic group block overflow-hidden rounded-2xl border border-ink/8 bg-white shadow-sm transition duration-300 hover:-translate-y-2 hover:border-ink/20 hover:shadow-xl" data-reveal>
    <div class="sunburst-bg relative flex aspect-[16/9] items-center justify-center overflow-hidden bg-ink">
        @if($article->cover_url)
            <img src="{{ $article->cover_url }}" alt="{{ $article->title }}" width="640" height="360" loading="lazy"
                class="absolute inset-0 h-full w-full scale-110 object-cover transition duration-700 group-hover:scale-100">
        @else
            <span class="font-display select-none text-5xl font-extrabold uppercase text-white/15">
                {{ $article->category }}
            </span>
        @endif
    </div>
    <div class="p-6">
        <p class="text-xs font-semibold uppercase tracking-wider text-ink/50">{{ $article->category }}</p>
        <h3 class="mt-2 font-display text-lg font-bold text-ink">{{ $article->title }}</h3>
        <p class="mt-2 line-clamp-2 text-sm text-ink/60">{{ $article->excerpt }}</p>
        <div class="mt-4 flex items-center justify-between">
            <p class="text-xs text-ink/40">{{ $article->published_at?->translatedFormat('d F Y') }}</p>
            <span class="flex items-center gap-1 text-xs font-semibold text-ink opacity-0 transition-all group-hover:opacity-100 group-hover:gap-1.5">
                Lire
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </span>
        </div>
    </div>
</a>
