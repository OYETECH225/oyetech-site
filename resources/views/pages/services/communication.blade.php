@extends('layouts.app')

@php
    app(\App\Services\SeoService::class)->set($service->name.' — OYETECH', $service->summary);
@endphp

@section('content')
    @include('pages.services._pole')
@endsection
