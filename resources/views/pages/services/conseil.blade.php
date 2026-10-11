@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Conseil en stratégie et transformation digitale à Abidjan — OYETECH',
        'Cabinet de conseil à Abidjan : stratégie, transformation digitale et gouvernance pour les entreprises et institutions d\'Afrique de l\'Ouest.'
    );
@endphp

@section('content')
    @include('pages.services._pole')
@endsection
