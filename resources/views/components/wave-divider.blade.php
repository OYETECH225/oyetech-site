@props(['fill' => '#ffffff', 'flip' => false, 'height' => '64'])

<div class="pointer-events-none {{ $flip ? 'absolute top-0 left-0 w-full rotate-180' : 'absolute bottom-0 left-0 w-full' }}" aria-hidden="true" style="height:{{ $height }}px; overflow:hidden; line-height:0;">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 {{ $height }}" preserveAspectRatio="none"
        style="display:block; width:100%; height:100%;" fill="{{ $fill }}">
        <path d="M0,{{ $height/2 }} C360,{{ $height }} 720,0 1080,{{ $height/2 }} C1260,{{ $height * 0.75 }} 1350,{{ $height * 0.25 }} 1440,{{ $height/2 }} L1440,{{ $height }} L0,{{ $height }} Z"/>
    </svg>
</div>
