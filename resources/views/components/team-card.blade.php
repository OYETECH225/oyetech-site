{{-- Membre de l'équipe : photo si disponible, sinon avatar à initiales ; lien LinkedIn optionnel --}}
@props(['member', 'bio' => false])

@php
    $linkedin = $member->linkedin_url
        ? (preg_match('#^https?://#', $member->linkedin_url) ? $member->linkedin_url : 'https://'.$member->linkedin_url)
        : null;
@endphp

<div {{ $attributes->merge(['class' => 'group rounded-2xl border border-ink/8 bg-white p-6 text-center shadow-sm transition duration-300 hover:-translate-y-2 hover:border-ink/20 hover:shadow-xl hover:shadow-black/5']) }}>
    @if($member->photo_url)
        <img src="{{ $member->photo_url }}" alt="{{ $member->display_name }}" width="96" height="96" loading="lazy"
            class="mx-auto h-24 w-24 rounded-full object-cover ring-4 ring-ink/5 transition group-hover:ring-ink/15">
    @else
        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-ink" aria-hidden="true">
            <span class="font-display text-2xl font-extrabold text-white/80">{{ $member->initials }}</span>
        </div>
    @endif
    <h3 class="mt-4 font-display font-bold text-ink">{{ $member->display_name }}</h3>
    <p class="text-sm font-medium text-ink/60">{{ $member->role }}</p>
    @if($bio && $member->bio)
        <p class="mt-2 text-sm text-ink/60">{{ $member->bio }}</p>
    @endif
    @if($linkedin)
        <a href="{{ $linkedin }}" target="_blank" rel="noopener" aria-label="Profil LinkedIn de {{ $member->display_name }} (nouvel onglet)"
            class="mx-auto mt-4 flex h-9 w-9 items-center justify-center rounded-full border border-ink/10 text-ink/50 transition hover:border-ink/30 hover:text-ink">
            <svg class="h-4 w-4" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        </a>
    @endif
</div>
