@props(['items' => []])

@php
    // Réponse en texte brut, échappée, puis liens optionnels posés sur le texte indiqué
    $formatAnswer = function (array $item): string {
        $html = e($item['a']);
        foreach ($item['liens'] ?? [] as $label => $url) {
            $link = '<a href="'.e($url).'" class="font-semibold text-ink underline underline-offset-2 hover:no-underline"'
                .(str_starts_with($url, url('/')) ? '' : ' target="_blank" rel="noopener"').'>'.e($label).'</a>';
            $html = preg_replace('/'.preg_quote(e($label), '/').'/u', $link, $html, 1);
        }
        return $html;
    };
    $faqId = 'faq-'.substr(md5(json_encode($items)), 0, 6);
@endphp

<div class="space-y-4" x-data="{ open: null }">
    @foreach($items as $i => $item)
        <div class="overflow-hidden rounded-2xl border border-ink/8 bg-white shadow-sm transition duration-200 hover:border-ink/20 hover:shadow-md" data-reveal>
            <button type="button" @click="open = open === {{ $i }} ? null : {{ $i }}" :aria-expanded="open === {{ $i }}" aria-controls="{{ $faqId }}-{{ $i }}"
                class="flex min-h-14 w-full items-center justify-between gap-4 px-6 py-4 text-left font-semibold text-ink">
                {{ $item['q'] }}
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full transition duration-300"
                    :class="open === {{ $i }} ? 'bg-ink text-white rotate-180' : 'bg-ink/5 text-ink/50'" aria-hidden="true">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </span>
            </button>
            <div id="{{ $faqId }}-{{ $i }}" x-show="open === {{ $i }}" x-collapse class="border-t border-ink/5 px-6 pb-5 pt-4 text-sm leading-relaxed text-ink/60">
                {!! $formatAnswer($item) !!}
            </div>
        </div>
    @endforeach
</div>

{{-- JSON-LD FAQPage généré à partir des mêmes données que la FAQ affichée --}}
@if($items)
    <x-json-ld :data="[
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($item) => [
            '@type' => 'Question',
            'name' => $item['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
        ], $items),
    ]" />
@endif
