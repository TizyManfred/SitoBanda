@extends('layouts.app')

@section('title', __('maestro.meta_title'))
@section('description', __('maestro.meta_description'))
@section('og_title', __('maestro.meta_title'))
@section('og_description', __('maestro.meta_description'))

@section('content')
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
                <!-- Maestro Content -->
                <section class="section section-sm section-first bg-default text-left">
                    <h2 class="title-decoration-lines-left">{{ __('maestro.name') }}</h2>
                    <h5 class="text-primary">{{ __('maestro.title') }}</h5>
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-md-12 col-lg-6">
                            <div class="wow fadeInRight">
                                <img src="{{ asset('images/FotoMaestro1.webp') }}" alt="{{ __('maestro.name') }} - {{ __('maestro.title') }}" width="519" height="564" loading="lazy">
                            </div>
                        </div>
                        <div class="col-md-10 col-lg-6">
                            <p class="text-gray-800">{{ __('maestro.bio_1') }}</p>
                            <p class="text-gray-800">{{ __('maestro.bio_2') }}</p>
                            <p class="text-gray-800">{{ __('maestro.bio_3') }}</p>
                            <p class="text-gray-800">{{ __('maestro.bio_4') }}</p>
                            <p class="text-gray-800">{{ __('maestro.bio_5') }}</p>
                        </div>
                    </div>
                </section>

                <!-- Achievements -->
                <section class="section section-sm bg-default">
                    <div class="container">
                        <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('maestro.achievements_title') }}</span></h3>
                        <div class="row row-30">
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-icon-classic">
                                    <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                                        <div class="unit-left">
                                            <div class="box-icon-classic-icon fl-bigmug-line-trophy5"></div>
                                        </div>
                                        <div class="unit-body">
                                            <h5 class="box-icon-classic-title">{{ __('maestro.achievement_1_title') }}</h5>
                                            <p>{{ __('maestro.achievement_1_desc') }}</p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-icon-classic">
                                    <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                                        <div class="unit-left">
                                            <div class="box-icon-classic-icon fl-bigmug-line-music11"></div>
                                        </div>
                                        <div class="unit-body">
                                            <h5 class="box-icon-classic-title">{{ __('maestro.achievement_2_title') }}</h5>
                                            <p>{{ __('maestro.achievement_2_desc') }}</p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-icon-classic">
                                    <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                                        <div class="unit-left">
                                            <div class="box-icon-classic-icon fl-bigmug-line-plane8"></div>
                                        </div>
                                        <div class="unit-body">
                                            <h5 class="box-icon-classic-title">{{ __('maestro.achievement_3_title') }}</h5>
                                            <p>{{ __('maestro.achievement_3_desc') }}</p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
                
            <div class="col-xl-3">
                @include('partials.aside')
            </div>
        </div>
    </div>
@endsection
