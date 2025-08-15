@extends('layouts.app')

@php
  $funny = collect(__('errors.404.funny'));
  // Ensure we have a collection (in case translator returns a single string)
  if (!($funny instanceof \Illuminate\Support\Collection)) {
      $funny = collect([$funny]);
  }
  $randomFunny = $funny->shuffle()->first();
@endphp

@section('title', __('errors.404.title'))
@section('description', __('errors.404.description'))
@section('og_title', __('errors.404.title'))
@section('og_description', __('errors.404.description'))
@section('og_image', asset('images/FotoSanIppolito1.webp'))

@section('content')
  <section class="section section-sm section-first bg-default">
    <div class="container">
      <div class="row justify-content-center text-center">
        <div class="col-lg-8">
          <h1>404</h1>
          <p class="lead mb-2">{{ __('errors.404.description') }}</p>
          <p class="text-muted mb-4">{{ $randomFunny }}</p>
          <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('home') }}" class="button button-primary button-ujarak" title="{{ __('errors.404.cta_home') }}">{{ __('errors.404.cta_home') }}</a>
            @if(Route::has('eventi'))
              <a href="{{ route('eventi') }}" class="button button-secondary button-ujarak" title="{{ __('errors.404.cta_events') }}">{{ __('errors.404.cta_events') }}</a>
            @endif
            @if(Route::has('repertorio'))
              <a href="{{ route('repertorio') }}" class="button button-secondary button-ujarak" title="{{ __('errors.404.cta_repertoire') }}">{{ __('errors.404.cta_repertoire') }}</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
