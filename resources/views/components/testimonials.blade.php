{{-- Témoignages réels uniquement (Testimonial::publishable : autorisation de publication
     + nom, fonction, entreprise, citation). Rien n'est affiché si la liste est vide. --}}
@props(['testimonials'])

@if($testimonials->isNotEmpty())
<section class="relative overflow-hidden bg-white py-28" x-data="{ active: 0, total: {{ $testimonials->count() }} }">
    <div class="relative mx-auto max-w-3xl px-6 text-center">
        <span class="section-badge mb-6 inline-flex" data-reveal>Témoignages clients</span>
        <h2 class="section-title mb-8" data-reveal>Ce que disent <span class="gradient-text">nos clients</span></h2>

        <span class="font-display select-none text-8xl leading-none text-ink/15" aria-hidden="true">&ldquo;</span>

        <div class="relative min-h-[240px]" aria-live="polite" data-reveal>
            @foreach($testimonials as $i => $testimonial)
                <div x-show="active === {{ $i }}" x-transition>
                    <div class="mb-5 flex justify-center gap-1" aria-label="{{ $testimonial->rating }} étoiles sur 5">
                        @for($s = 1; $s <= 5; $s++)
                            <svg class="h-5 w-5 {{ $s <= $testimonial->rating ? 'text-ink' : 'text-ink/15' }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.299.921-.755 1.688-1.539 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.063 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="font-display text-xl font-medium leading-relaxed text-ink/80 sm:text-2xl">
                        &ldquo;{{ $testimonial->content }}&rdquo;
                    </p>
                    <div class="mt-8 flex items-center justify-center gap-4">
                        @if($testimonial->photo_url)
                            <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->author_name }}" width="52" height="52" loading="lazy"
                                class="h-12 w-12 rounded-full object-cover ring-2 ring-ink/15">
                        @else
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-ink ring-2 ring-ink/10 font-display text-lg font-bold text-white">
                                {{ mb_substr($testimonial->author_name, 0, 1) }}
                            </span>
                        @endif
                        <div class="text-left">
                            <p class="font-display font-bold text-ink">{{ $testimonial->author_name }}</p>
                            <p class="text-sm text-ink/60">{{ $testimonial->author_role }}, {{ $testimonial->company }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10 flex justify-center gap-2">
            @foreach($testimonials as $i => $testimonial)
                <button @click="active = {{ $i }}"
                    :aria-current="active === {{ $i }}"
                    aria-label="Témoignage {{ $i + 1 }} sur {{ $testimonials->count() }}"
                    :class="active === {{ $i }} ? 'bg-ink w-8' : 'bg-ink/15 w-2.5 hover:bg-ink/25'"
                    class="h-2.5 rounded-full transition-all duration-300">
                </button>
            @endforeach
        </div>
    </div>
</section>
@endif
