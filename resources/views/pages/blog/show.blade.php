@extends('layouts.app')

@php
    $seoTitle = $article->meta_title ?: $article->title;
    $seoDescription = $article->meta_description ?: $article->excerpt;

    app(\App\Services\SeoService::class)->set(
        $seoTitle.' — OYETECH',
        $seoDescription,
        $article->cover_url
    );

    $organization = ['@type' => 'Organization', '@id' => rtrim($entreprise->get('url'), '/').'/#organization', 'name' => $entreprise->get('nom')];

    \Artesaos\SEOTools\Facades\SEOTools::jsonLdMulti()->setType('Article');
    \Artesaos\SEOTools\Facades\SEOTools::jsonLdMulti()->addValue('headline', $article->title);
    \Artesaos\SEOTools\Facades\SEOTools::jsonLdMulti()->addValue('datePublished', $article->published_at?->toIso8601String());
    \Artesaos\SEOTools\Facades\SEOTools::jsonLdMulti()->addValue('dateModified', ($article->updated_at ?? $article->published_at)?->toIso8601String());
    \Artesaos\SEOTools\Facades\SEOTools::jsonLdMulti()->addValue('articleSection', $article->category);
    \Artesaos\SEOTools\Facades\SEOTools::jsonLdMulti()->addValue('mainEntityOfPage', route('blog.show', $article));
    \Artesaos\SEOTools\Facades\SEOTools::jsonLdMulti()->addValue('author', $organization);
    \Artesaos\SEOTools\Facades\SEOTools::jsonLdMulti()->addValue('publisher', $organization + ['logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo-full.png')]]);
    \Artesaos\SEOTools\Facades\SEOTools::jsonLdMulti()->setImages([$article->cover_url ?? asset(\App\Services\SeoService::DEFAULT_IMAGE)]);
@endphp

@section('content')

<x-breadcrumb-schema :items="['Accueil' => route('home'), 'Insights' => route('blog.index'), $article->title => route('blog.show', $article)]" />

{{-- Barre de progression de lecture --}}
<div class="fixed left-0 top-0 z-[60] h-1 w-full bg-ink/10" aria-hidden="true">
    <div class="h-full bg-ink transition-[width] duration-150 motion-reduce:transition-none"
        x-data="{ progress: 0 }"
        x-init="
            const update = () => {
                const doc = document.documentElement;
                const max = doc.scrollHeight - doc.clientHeight;
                progress = max > 0 ? Math.min(100, (doc.scrollTop / max) * 100) : 0;
            };
            window.addEventListener('scroll', update, { passive: true });
            update();
        "
        :style="`width: ${progress}%`"></div>
</div>

<x-hero eyebrow="{{ $article->category }}" :title="$article->title" />

<section class="bg-white py-24">
    <div class="mx-auto max-w-3xl px-6">
        <p class="text-sm text-ink/60" data-reveal>{{ $article->published_at?->translatedFormat('d F Y') }}</p>

        <div class="prose prose-neutral drop-cap mt-8 max-w-none prose-headings:font-display prose-headings:tracking-tight prose-a:text-ink prose-a:underline prose-blockquote:font-display prose-blockquote:border-ink prose-blockquote:text-2xl prose-blockquote:font-bold prose-blockquote:not-italic prose-blockquote:text-ink"
            data-reveal>
            {!! $article->content !!}
        </div>
    </div>
</section>

@if($related->isNotEmpty())
<section class="bg-paper py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <h2 class="section-title">À lire aussi</h2>
        </div>
        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
            @foreach($related as $item)
                <x-article-card :article="$item" />
            @endforeach
        </div>
    </div>
</section>
@endif

<x-cta-band title="Un projet en tête ? Parlons-en." />

@endsection
