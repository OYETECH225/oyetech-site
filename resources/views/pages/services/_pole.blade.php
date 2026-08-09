<x-hero :eyebrow="'Pôle 0'.$service->order.'/05'" :title="$service->name" :subtitle="$service->summary" />

<section class="bg-white py-24">
    <div class="mx-auto max-w-3xl px-6 text-center" data-reveal>
        <p class="text-lg leading-relaxed text-ink/60">{{ $service->description }}</p>
    </div>
</section>

@if(!empty($service->deliverables))
<section class="bg-paper py-28">
    <div class="mx-auto max-w-6xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <span class="mb-4 inline-block rounded-full border border-ink/15 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-ink/45">
                Notre méthode
            </span>
            <h2 class="section-title">Nos prestations</h2>
        </div>

        <div class="relative mt-20">
            <div class="absolute inset-x-0 top-6 hidden h-px bg-ink/10 sm:block" aria-hidden="true"></div>

            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
                @foreach($service->deliverables as $i => $deliverable)
                    <div data-reveal class="relative">
                        <span class="relative z-10 flex h-12 w-12 items-center justify-center rounded-full bg-ink font-display text-sm font-bold text-white">
                            0{{ $i + 1 }}
                        </span>
                        <p class="font-display mt-5 text-lg font-bold text-ink">{{ $deliverable }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if($projects->isNotEmpty())
<section class="bg-white py-28">
    <div class="mx-auto max-w-7xl px-6">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <span class="mb-4 inline-block rounded-full border border-ink/15 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-ink/45">
                Preuves par l'exemple
            </span>
            <h2 class="section-title">Cas clients</h2>
        </div>
        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
            @foreach($projects as $project)
                <x-project-card :project="$project" />
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- UNE QUESTION ? --}}
<section class="bg-paper py-16">
    <div class="mx-auto max-w-7xl px-6">
        <div class="sunburst-bg grain flex flex-col items-center gap-6 rounded-3xl bg-ink p-10 text-center text-white sm:flex-row sm:text-left" data-reveal>
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/10">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a.39.39 0 01.292-.115c3.272-.292 5.99-2.394 5.99-5.026V7.752c0-2.632-2.718-4.734-5.99-5.026a48.554 48.554 0 00-8.452 0C2.973 3.018.254 5.12.254 7.752v5.008z" /></svg>
            </span>
            <div class="flex-1">
                <h3 class="font-display text-xl font-bold">Une question sur {{ $service->name }} ?</h3>
                <p class="mt-2 text-white/60">Notre équipe vous répond en moins de 48h, sans engagement.</p>
            </div>
            <a href="{{ route('contact') }}" class="btn-invert magnetic shrink-0">Nous contacter</a>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="bg-white py-24">
    <div class="mx-auto max-w-3xl px-6">
        <div class="text-center" data-reveal>
            <h2 class="section-title">Questions fréquentes</h2>
        </div>
        <div class="mt-12">
            <x-faq :items="[
                ['q' => 'Comment se déroule le démarrage d\'une mission '.$service->name.' ?', 'a' => 'Un premier échange permet de cadrer vos objectifs et votre contexte. Nous proposons ensuite une feuille de route avec un périmètre et un calendrier clairs.'],
                ['q' => 'Travaillez-vous avec des entreprises de toute taille ?', 'a' => 'Oui, nos méthodes s\'adaptent aussi bien aux startups qu\'aux grandes entreprises et institutions.'],
                ['q' => 'Peut-on combiner ce pôle avec d\'autres expertises OYETECH ?', 'a' => 'Tout à fait, c\'est même notre approche par défaut : nos pôles travaillent ensemble dès que votre projet le nécessite.'],
            ]" />
        </div>
    </div>
</section>

@if($otherServices->isNotEmpty())
<section class="bg-paper py-16">
    <div class="mx-auto max-w-7xl px-6 text-center" data-reveal>
        <p class="text-xs font-semibold uppercase tracking-wider text-ink/45">Découvrez nos autres pôles</p>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            @foreach($otherServices as $other)
                <a href="{{ $other->url }}" class="rounded-full border border-ink/15 bg-white px-4 py-2 text-sm font-medium text-ink/70 transition-colors hover:border-ink hover:text-ink">
                    {{ $other->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<x-cta-band :title="'Discutons de votre projet '.$service->name" />
