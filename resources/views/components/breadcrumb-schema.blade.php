{{-- JSON-LD BreadcrumbList. $items : [libellé => URL], de l'accueil à la page courante --}}
@props(['items'])
<x-json-ld :data="[
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($items)->keys()->map(fn ($name, $i) => [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $name,
        'item' => $items[$name],
    ])->all(),
]" />
