@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set(
        'Agence de marketing digital à Abidjan — OYETECH',
        'Marketing digital à Abidjan : acquisition, réseaux sociaux, conversion et fidélisation pilotées par la donnée, par l\'agence OYETECH.'
    );
@endphp

@section('content')
    @include('pages.services._pole')
@endsection
