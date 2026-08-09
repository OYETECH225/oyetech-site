@props(['reverse' => false])

<div data-marquee class="overflow-hidden" role="presentation" aria-hidden="true">
    <div class="marquee-track {{ $reverse ? 'marquee-reverse' : '' }}">
        {{ $slot }}
    </div>
</div>
