{{-- Valeur d'une page légale ; si elle n'est pas encore fournie, repère bien visible --}}
@props(['value' => null])
@if(filled($value))
    {{ $value }}
@else
    <mark class="rounded bg-yellow-200 px-1 font-semibold text-ink">{{ \App\Services\Entreprise::A_FOURNIR }}</mark>
@endif
