@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Insights — OYETECH',
        'Articles stratégiques d\'OYETECH sur l\'innovation digitale, la fintech, le marketing et la stratégie en Afrique de l\'Ouest.'
    );
@endphp

@section('content')

<x-hero eyebrow="Insights" title="Nos réflexions sur la transformation digitale"
    subtitle="Innovation, fintech, marketing et stratégie : nos experts partagent leur regard sur les enjeux digitaux en Afrique de l'Ouest." />

<section class="bg-white py-28" x-data="{
        filter: new URLSearchParams(window.location.search).get('categorie') || 'all',
        setFilter(key) {
            this.filter = key;
            const url = new URL(window.location);
            key === 'all' ? url.searchParams.delete('categorie') : url.searchParams.set('categorie', key);
            window.history.replaceState({}, '', url);
        },
    }">
    <div class="mx-auto max-w-7xl px-6">
        @php $categories = $articles->pluck('category')->unique(); @endphp

        @if($categories->count() > 1)
            <div class="flex flex-wrap justify-center gap-2" role="group" aria-label="Filtrer les articles par catégorie" data-reveal>
                <button @click="setFilter('all')" :aria-pressed="filter === 'all'"
                    :class="filter === 'all' ? 'bg-ink text-white' : 'bg-paper text-ink/60'"
                    class="min-h-11 rounded-full px-4 py-2 text-sm font-medium transition">Tous</button>
                @foreach($categories as $category)
                    <button @click="setFilter('{{ $category }}')" :aria-pressed="filter === '{{ $category }}'"
                        :class="filter === '{{ $category }}' ? 'bg-ink text-white' : 'bg-paper text-ink/60'"
                        class="min-h-11 rounded-full px-4 py-2 text-sm font-medium transition">{{ $category }}</button>
                @endforeach
            </div>
        @endif

        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
            @forelse($articles as $article)
                <div x-show="filter === 'all' || filter === '{{ $article->category }}'" x-transition>
                    <x-article-card :article="$article" />
                </div>
            @empty
                <p class="col-span-full text-center text-ink/60">Aucun article publié pour le moment.</p>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    </div>
</section>

@endsection
