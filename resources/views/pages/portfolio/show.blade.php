@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        $project->title.' — OYETECH',
        $project->challenge
    );
@endphp

@section('content')

<x-hero eyebrow="{{ ucfirst($project->pole) }} — {{ $project->client }}" :title="$project->title" />

<section class="bg-white py-24">
    <div class="mx-auto max-w-4xl px-6 space-y-12">
        <div data-aos="fade-up">
            <h2 class="section-title">Le défi</h2>
            <p class="mt-4 text-ink/60">{{ $project->challenge }}</p>
        </div>
        <div data-aos="fade-up">
            <h2 class="section-title">Notre solution</h2>
            <p class="mt-4 text-ink/60">{{ $project->solution }}</p>
        </div>
        <div class="rounded-2xl bg-paper p-8" data-aos="fade-up">
            <h2 class="section-title">Résultats</h2>
            <p class="mt-4 font-medium text-ink font-semibold">{{ $project->results }}</p>
        </div>
    </div>
</section>

@if($related->isNotEmpty())
<section class="bg-paper py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <h2 class="section-title">Autres réalisations</h2>
        </div>
        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($related as $item)
                <x-project-card :project="$item" />
            @endforeach
        </div>
    </div>
</section>
@endif

<x-cta-band title="Discutons de votre prochain projet" />

@endsection
