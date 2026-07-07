@extends('layouts.app')

@section('title', __('maestro.meta_title'))
@section('description', __('maestro.meta_description'))
@section('og_title', __('maestro.meta_title'))
@section('og_description', __('maestro.meta_description'))

@section('content')
    @php
        $dynamicBlocks = \App\Models\StaticPage::contentBlocks('maestro');
    @endphp

    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('maestro.page_title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('header.home') }}</a></li>
                    <li class="active">{{ __('maestro.page_title') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ \App\Models\StaticPage::headerImageUrl('maestro', 'images/FotoSanIppolito1.webp') }});"></div>
        </div>
    </section>

    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-xl-9 pr-xl-5">
                @if ($dynamicBlocks !== [])
                    @include('partials.static-page-content', ['blocks' => $dynamicBlocks])
                @else
                <!-- Maestro Content -->
                <section class="section section-sm section-first bg-default text-left">
                    <h2 class="title-decoration-lines-left">{{ __('maestro.name') }}</h2>
                    <h5 class="text-primary">{{ __('maestro.title') }}</h5>
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-md-12 col-lg-6">
                            <div class="figure-classic figure-classic-left wow fadeInRight">
                                <img src="{{ \App\Models\StaticPage::contentImageUrl('maestro', 'images/FotoMaestro1.webp', 0) }}" alt="{{ __('maestro.name') }} - {{ __('maestro.title') }}" width="519" height="564" loading="lazy">
                            </div>
                        </div>
                        <div class="col-md-10 col-lg-6">
                            @foreach (array_filter([
                                __('maestro.bio_1'),
                                __('maestro.bio_2'),
                                __('maestro.bio_3'),
                                __('maestro.bio_4'),
                                __('maestro.bio_5'),
                            ]) as $paragraph)
                                <p class="text-gray-800">{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>
                </section>
                @endif
            </div>
                
            <div class="col-xl-3">
                @include('partials.aside')
            </div>
        </div>
    </div>
@endsection
