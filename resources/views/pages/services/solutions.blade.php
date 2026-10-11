@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Création de site web et d\'application mobile à Abidjan — OYETECH',
        'Création de sites vitrines, e-commerce, applications web métier et mobiles, automatisations : le pôle Solutions Numériques d\'OYETECH à Abidjan.'
    );
@endphp

@section('content')
    @include('pages.services._pole')
@endsection
