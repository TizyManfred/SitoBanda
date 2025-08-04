@extends('layouts.app')

@section('title', __('storia.meta_title'))
@section('description', __('storia.meta_description'))
@section('og_title', __('storia.meta_title'))
@section('og_description', __('storia.meta_description'))

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('storia.breadcrumb_storia') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('storia.breadcrumb_home') }}</a></li>
                    <li class="active">{{ __('storia.breadcrumb_storia') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoStoria1.jpg') }});"></div>
        </div>
    </section>

    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-12">
                <!-- Storia Content -->
                <section class="section section-sm section-first bg-default text-md-left">
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-md-10 col-lg-7 col-xl-6">
                            <h2 class="title-decoration-lines-left">{{ __('storia.section_title') }}</h2>
                            <p class="text-gray-800">{{ __('storia.intro_p1') }}</p>
                            <p class="text-gray-800">{{ __('storia.intro_p2') }}</p>
                        </div>
                        <div class="col-md-10 col-lg-5 col-xl-6">
                            <div class="wow fadeInRight">
                                <img src="{{ asset('images/FotoStoria2.jpg') }}" alt="Banda Folk di Castello Tesino - Foto storica" width="519" height="564" loading="lazy">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Milestones -->
                <section class="section section-sm bg-gray-100">
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-md-10 col-lg-5 col-xl-6">
                            <div class="wow fadeInRight">
                                <img src="{{ asset('images/FotoStoria3.jpg') }}" alt="Banda Folk di Castello Tesino - Tappe storiche" width="519" height="564" loading="lazy">
                            </div>
                        </div>
                        <div class="col-md-10 col-lg-7 col-xl-6">
                            <div class="text-md-left">
                                <h3 class="title-decoration-lines-left">{{ __('storia.milestones_title') }}</h3>
                                <p>{{ __('storia.milestones_p1') }}</p>
                                <p>{{ __('storia.milestones_p2') }}</p>
                                <p>{{ __('storia.milestones_p3') }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Shanghai Success -->
                <section class="section section-sm bg-default">
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-md-10 col-lg-7 col-xl-6">
                            <div class="box-cta-solano text-left">
                                <h3 class="wow-outer"><span class="wow slideInUp">{{ __('storia.shanghai_title') }}</span></h3>
                                <p class="wow-outer"><span class="wow slideInDown" data-wow-delay=".05s">{{ __('storia.shanghai_p1') }}</span></p>
                            </div>
                        </div>
                        <div class="col-md-10 col-lg-5 col-xl-6">
                            <div class="wow fadeInLeft">
                                <img src="{{ asset('images/FotoStoria4.jpeg') }}" alt="Banda Folk di Castello Tesino a Shanghai" width="519" height="564" loading="lazy">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Continue Reading -->
                <section class="section section-sm section-last bg-gray-100 text-center">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <h4>{{ __('storia.continue_reading') }}</h4>
                            <a class="button button-primary button-winona" href="{{ route('abito-tradizionale') }}">{{ __('storia.traditional_attire_link') }}</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
