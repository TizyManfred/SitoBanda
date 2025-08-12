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
            <div class="col-xl-9 pr-xl-5">
                <!-- Storia Content -->
                <section class="section section-sm section-first bg-default text-left">
                    <h2 class="title-decoration-lines-left">{{ __('storia.section_title') }}</h2>
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-md-10 col-lg-7 col-xl-6">
                            <p class="text-gray-800">{{ __('storia.intro_p1') }}</p>
                            <p class="text-gray-800">{{ __('storia.intro_p2') }}</p>
                        </div>
                        <div class="col-md-10 col-lg-5 col-xl-6">
                            <a href="{{ asset('images/FotoStoria2.jpg') }}" data-lightgallery="item">
                                <div class="wow fadeInRight">
                                    <img src="{{ asset('images/FotoStoria2.jpg') }}" alt="Banda Folk di Castello Tesino - Foto storica" class="aspect-ratio-16-9 object-fit-cover" width="100%" loading="lazy">
                                </div>
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Milestones -->
                <section class="section section-sm bg-gray-100">
                    <h3 class="title-decoration-lines-left text-left">{{ __('storia.milestones_title') }}</h3>
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-md-10 col-lg-5 col-xl-6">
                            <div id="milestones-carousel" class="carousel slide wow fadeInLeft" data-ride="carousel" data-interval="{{ random_int(6000, 12000) }}">
                                <div class="carousel-inner" style="height: 350px;" data-lightgallery="group">
                                    <div class="carousel-item active">
                                        <a href="{{ asset('images/FotoStoria3.jpg') }}" data-lightgallery="item">
                                            <img src="{{ asset('images/FotoStoria3.jpg') }}" 
                                                 class="d-block w-100 img-fluid"
                                                 alt="Banda Folk di Castello Tesino - Tappe storiche" 
                                                 loading="lazy"
                                                 style="height: 350px; width: 100%; object-fit: cover; cursor: pointer;">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a href="{{ asset('images/FotoStoria4.jpg') }}" data-lightgallery="item">
                                            <img src="{{ asset('images/FotoStoria4.jpg') }}" 
                                                 class="d-block w-100 img-fluid"
                                                 alt="Banda Folk di Castello Tesino - Tappe storiche" 
                                                 loading="lazy"
                                                 style="height: 350px; width: 100%; object-fit: cover; cursor: pointer;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 col-lg-7 col-xl-6">
                            <div class="text-md-left">
                                <p>{{ __('storia.milestones_p1') }}</p>
                                <p>{{ __('storia.milestones_p2') }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Shanghai Success -->
                <section class="section section-sm bg-default">
                    <h3 class="title-decoration-lines-left text-left">{{ __('storia.shanghai_title') }}</h3>
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-md-10 col-lg-7 col-xl-6">
                            <div class="box-cta-solano text-left">
                                <p>{{ __('storia.shanghai_p1') }}</p>
                            </div>
                        </div>
                        <div class="col-md-10 col-lg-5 col-xl-6">
                            <div id="shanghai-carousel" class="carousel slide wow fadeInLeft" data-ride="carousel" data-interval="{{ random_int(6000, 12000) }}">
                                <div class="carousel-inner" style="height: 350px;" data-lightgallery="group">
                                    <div class="carousel-item active">
                                        <a href="{{ asset('images/FotoStoria5.jpeg') }}" data-lightgallery="item">
                                            <img src="{{ asset('images/FotoStoria5.jpeg') }}" 
                                                 class="d-block w-100 img-fluid"
                                                 alt="Banda Folk di Castello Tesino a Shanghai" 
                                                 loading="lazy"
                                                 style="height: 350px; width: 100%; object-fit: cover; cursor: pointer;">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a href="{{ asset('images/FotoStoria6.jpg') }}" data-lightgallery="item">
                                            <img src="{{ asset('images/FotoStoria6.jpg') }}" 
                                                 class="d-block w-100 img-fluid"
                                                 alt="Banda Folk di Castello Tesino a Shanghai" 
                                                 loading="lazy"
                                                 style="height: 350px; width: 100%; object-fit: cover; cursor: pointer;">
                                        </a>
                                    </div>
                                </div>
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

            <div class="col-xl-3">
                @include('partials.aside')
            </div>
        </div>
    </div>
@endsection
