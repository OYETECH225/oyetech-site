@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Agence de communication et publicité à Abidjan — OYETECH',
        'Stratégie de marque, création et campagnes publicitaires à fort impact à Abidjan, du brief à la diffusion, par l\'agence OYETECH.'
    );
@endphp

@section('content')
    @include('pages.services._pole')
@endsection
