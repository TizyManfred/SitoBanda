@extends('layouts.app')

@section('title', __('errors.500.title'))
@section('description', __('errors.500.description'))
@section('og_title', __('errors.500.title'))
@section('og_description', __('errors.500.description'))
@section('og_image', asset('images/FotoSanIppolito1.webp'))
@section('robots', 'noindex, nofollow')

@section('content')
  <section class="section section-sm section-first bg-default">
    <div class="container">
      <div class="row justify-content-center text-center">
        <div class="col-lg-8">
          <h1>500</h1>
          <p class="lead mb-2">{{ __('errors.500.description') }}</p>
          <p class="text-muted mb-4">{{ __('errors.500.message') }}</p>
          <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('home') }}" class="button button-primary button-ujarak" title="{{ __('errors.500.cta_home') }}">{{ __('errors.500.cta_home') }}</a>
            @if(Route::has('contatti'))
              <a href="{{ route('contatti') }}" class="button button-secondary button-ujarak" title="{{ __('errors.500.cta_contact') }}">{{ __('errors.500.cta_contact') }}</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
