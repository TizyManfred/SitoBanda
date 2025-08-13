@extends('layouts.app')

@section('title', 'Chi Siamo - Banda Folk di Castello Tesino')
@section('description', 'Scopri la storia e la missione della Banda Folk di Castello Tesino, un\'istituzione musicale attiva dal 1901 che porta avanti la tradizione musicale trentina.')
@section('og_title', 'Chi Siamo - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri la storia e la missione della Banda Folk di Castello Tesino, un\'istituzione musicale attiva dal 1901.')

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('chi-siamo.breadcrumb_title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('chi-siamo.breadcrumb_home') }}</a></li>
                    <li class="active">{{ __('chi-siamo.breadcrumb_title') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoSanIppolito1.jpg') }});"></div>
        </div>
    </section>

    <!-- Chi Siamo Content -->
    <section class="section section-sm section-first bg-default text-left">
        <div class="container">
            <h2 class="title-decoration-lines-left">{{ __('chi-siamo.section_title') }}</h2>
            <div class="row row-50 justify-content-center">
                <div class="col-md-12 col-lg-12">
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-lg-6 mt-4">
                            <div class="wow fadeInRight">
                                <img src="{{ asset('images/FotoBiagio1.jpg') }}" alt="Banda Folk di Castello Tesino" class="img-fluid rounded shadow-sm" loading="lazy">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <p class="text-gray-800">{{ __('chi-siamo.intro_p1') }}</p>
                            <p class="text-gray-800">{{ __('chi-siamo.intro_p2') }}</p>
                            <p class="text-gray-800">{{ __('chi-siamo.intro_p3') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Discover More -->
    <section class="section section-sm bg-gray-100 text-left">
        <div class="container">
            <h2 class="title-decoration-lines-left">{{ __('chi-siamo.discover_more_title') }}</h2>
            <div class="row row-50">
                <div class="col-md-6 col-lg-4">
                    <article class="box-icon-modern box-icon-modern-custom">
                        <div>
                            <h3 class="box-icon-modern-big-title">{{ __('chi-siamo.history_title') }}</h3>
                            <div class="box-icon-modern-decor"></div>
                            <p class="box-icon-modern-text">{{ __('chi-siamo.history_text') }}</p>
                            <a class="button button-md button-default-outline-2 button-wapasha" href="{{ route('storia') }}">{{ __('chi-siamo.history_button') }}</a>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="box-icon-modern box-icon-modern-custom">
                        <div>
                            <h3 class="box-icon-modern-big-title">{{ __('chi-siamo.attire_title') }}</h3>
                            <div class="box-icon-modern-decor"></div>
                            <p class="box-icon-modern-text">{{ __('chi-siamo.attire_text') }}</p>
                            <a class="button button-md button-default-outline-2 button-wapasha" href="{{ route('abito-tradizionale') }}">{{ __('chi-siamo.attire_button') }}</a>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="box-icon-modern box-icon-modern-custom">
                        <div>
                            <h3 class="box-icon-modern-big-title">{{ __('chi-siamo.conductor_title') }}</h3>
                            <div class="box-icon-modern-decor"></div>
                            <p class="box-icon-modern-text">{{ __('chi-siamo.conductor_text') }}</p>
                            <a class="button button-md button-default-outline-2 button-wapasha" href="{{ route('maestro') }}">{{ __('chi-siamo.conductor_button') }}</a>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="box-icon-modern box-icon-modern-custom">
                        <div>
                            <h3 class="box-icon-modern-big-title">{{ __('chi-siamo.members_title') }}</h3>
                            <div class="box-icon-modern-decor"></div>
                            <p class="box-icon-modern-text">{{ __('chi-siamo.members_text') }}</p>
                            <a class="button button-md button-default-outline-2 button-wapasha" href="{{ route('organico') }}">{{ __('chi-siamo.members_button') }}</a>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="box-icon-modern box-icon-modern-custom">
                        <div>
                            <h3 class="box-icon-modern-big-title">{{ __('chi-siamo.repertoire_title') }}</h3>
                            <div class="box-icon-modern-decor"></div>
                            <p class="box-icon-modern-text">{{ __('chi-siamo.repertoire_text') }}</p>
                            <a class="button button-md button-default-outline-2 button-wapasha" href="{{ route('repertorio') }}">{{ __('chi-siamo.repertoire_button') }}</a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="section section-md bg-gray-100 text-md-left">
        <div class="container">
            <h2 class="title-decoration-lines-left">{{ __('chi-siamo.values_title') }}</h2>
            <div class="row row-50">
                <div class="col-md-6 col-lg-3">
                    <article class="box-icon-modern wow slideInUp">
                        <div class="box-icon-modern-icon"><i class="fa fa-music"></i></div>
                        <h5 class="box-icon-modern-title">{{ __('chi-siamo.value_tradition_title') }}</h5>
                        <div class="box-icon-modern-decor"></div>
                        <p class="box-icon-modern-text">{{ __('chi-siamo.value_tradition_text') }}</p>
                    </article>
                </div>
                <div class="col-md-6 col-lg-3">
                    <article class="box-icon-modern wow slideInUp" data-wow-delay=".1s">
                        <div class="box-icon-modern-icon"><i class="fa fa-users"></i></div>
                        <h5 class="box-icon-modern-title">{{ __('chi-siamo.value_community_title') }}</h5>
                        <div class="box-icon-modern-decor"></div>
                        <p class="box-icon-modern-text">{{ __('chi-siamo.value_community_text') }}</p>
                    </article>
                </div>
                <div class="col-md-6 col-lg-3">
                    <article class="box-icon-modern wow slideInUp" data-wow-delay=".2s">
                        <div class="box-icon-modern-icon"><i class="fa fa-book"></i></div>
                        <h5 class="box-icon-modern-title">{{ __('chi-siamo.value_training_title') }}</h5>
                        <div class="box-icon-modern-decor"></div>
                        <p class="box-icon-modern-text">{{ __('chi-siamo.value_training_text') }}</p>
                    </article>
                </div>
                <div class="col-md-6 col-lg-3">
                    <article class="box-icon-modern wow slideInUp" data-wow-delay=".3s">
                        <div class="box-icon-modern-icon"><i class="fa fa-globe"></i></div>
                        <h5 class="box-icon-modern-title">{{ __('chi-siamo.value_internationality_title') }}</h5>
                        <div class="box-icon-modern-decor"></div>
                        <p class="box-icon-modern-text">{{ __('chi-siamo.value_internationality_text') }}</p>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
