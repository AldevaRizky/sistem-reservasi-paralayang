@extends('layouts.landing')
@section('title', 'Beranda')
@section('content')
    @include('partials.landing.hero')
    @include('partials.landing.about')
    @include('partials.landing.paragliding.package')
    @include('partials.landing.camping.packages')
    @include('partials.landing.contact')
@endsection
