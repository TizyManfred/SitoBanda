@extends('layouts.app')

@section('title', __('abito.meta.title'))
@section('description', __('abito.meta.description'))
@section('og_title', __('abito.meta.og_title'))
@section('og_description', __('abito.meta.og_description'))

@section('content')
    @php
        $dynamicBlocks = \App\Models\StaticPage::contentBlocks('abito_tradizionale');
    @endphp

    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('abito.title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('abito.home') }}</a></li>
                    <li class="active">{{ __('abito.title') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ \App\Models\StaticPage::headerImageUrl('abito_tradizionale', 'images/FotoAbito1.webp') }});"></div>
        </div>
    </section>



    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-xl-9 pr-xl-5">
                @if ($dynamicBlocks !== [])
                    @include('partials.static-page-content', ['blocks' => $dynamicBlocks])
                @else
                <!-- Abito Tradizionale Content -->
                <section class="section section-sm section-first bg-default text-left">
                    <div class="container">
                        <h2 class="title-decoration-lines-left">{{ __('abito.main.title') }}</h2>
                        <div class="row row-50 justify-content-center align-items-xl-center">
                            <div class="col-md-10 col-lg-5 col-xl-6">
                                <div class="figure-classic figure-classic-left wow fadeInRight">
                                    <img src="{{ \App\Models\StaticPage::contentImageUrl('abito_tradizionale', 'images/FotoAbito2.webp', 0) }}" alt="Abito Tradizionale della Banda Folk di Castello Tesino" width="519" height="564" loading="lazy">
                                </div>
                            </div>
                            <div class="col-md-10 col-lg-7 col-xl-6">
                                <p class="text-gray-800">{{ __('abito.main.intro') }}</p>
                                <p class="text-gray-800">{{ __('abito.main.evolution') }}</p>
                                <p class="text-gray-800">{{ __('abito.main.adoption') }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Elementi dell'Abito -->
                <section class="section section-sm bg-default">
                    <div class="container">
                        <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('abito.elements.title') }}</span></h3>
                        
                        <!-- Accessori e Ornamenti -->
                        <div class="row row-30 mb-5">
                            <div class="col-12">
                                <h4 class="text-center mb-4" style="color: #666; font-weight: 300;">{{ __('abito.elements.accessories') }}</h4>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-icon-classic">
                                    <div class="unit-left"><div class="box-icon-classic-icon"><i class="fa fa-star"></i></div></div>
                                    <div class="unit-body">
                                        <h5 class="box-icon-classic-title">{{ __('abito.elements.apron.title') }}</h5>
                                        <p class="box-icon-classic-text">{{ __('abito.elements.apron.text') }}</p>
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-icon-classic">
                                    <div class="unit-left"><div class="box-icon-classic-icon"><i class="fa fa-diamond"></i></div></div>
                                    <div class="unit-body">
                                        <h5 class="box-icon-classic-title">{{ __('abito.elements.jewelry.title') }}</h5>
                                        <p class="box-icon-classic-text">{{ __('abito.elements.jewelry.text') }}</p>
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-icon-classic">
                                    <div class="unit-left"><div class="box-icon-classic-icon"><i class="fa fa-user"></i></div></div>
                                    <div class="unit-body">
                                        <h5 class="box-icon-classic-title">{{ __('abito.elements.hairstyle.title') }}</h5>
                                        <p class="box-icon-classic-text">{{ __('abito.elements.hairstyle.text') }}</p>
                                    </div>
                                </article>
                            </div>
                        </div>

                        <!-- Struttura dell'Abito -->
                        <div class="row row-30">
                            <div class="col-12">
                                <h4 class="text-center mb-4" style="color: #666; font-weight: 300;">{{ __('abito.elements.structure') }}</h4>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-icon-classic">
                                    <div class="unit-left"><div class="box-icon-classic-icon"><i class="fa fa-female"></i></div></div>
                                    <div class="unit-body">
                                        <h5 class="box-icon-classic-title">{{ __('abito.elements.dress.title') }}</h5>
                                        <p class="box-icon-classic-text">{{ __('abito.elements.dress.text') }}</p>
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-icon-classic">
                                    <div class="unit-left"><div class="box-icon-classic-icon"><i class="fa fa-heart"></i></div></div>
                                    <div class="unit-body">
                                        <h5 class="box-icon-classic-title">{{ __('abito.elements.colors.title') }}</h5>
                                        <p class="box-icon-classic-text">{{ __('abito.elements.colors.text') }}</p>
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-icon-classic">
                                    <div class="unit-left"><div class="box-icon-classic-icon"><i class="fa fa-shield"></i></div></div>
                                    <div class="unit-body">
                                        <h5 class="box-icon-classic-title">{{ __('abito.elements.protection.title') }}</h5>
                                        <p class="box-icon-classic-text">{{ __('abito.elements.protection.text') }}</p>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Costume Maschile -->
                <section class="section section-sm bg-default text-md-left">
                    <div class="container">
                        <div class="row row-50 justify-content-center">
                            <div class="col-md-12 col-lg-12">
                                <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('abito.male.title') }}</span></h3>
                                <p>{{ __('abito.male.description') }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Storia dell'Abito -->
                <section class="section section-sm bg-default text-md-left">
                    <div class="container">
                        <div class="row row-50 justify-content-center">
                            <div class="col-md-12 col-lg-12">
                                <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('abito.history.title') }}</span></h3>
                                <p>{{ __('abito.history.text') }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Cura e Conservazione -->
                <section class="section section-sm section-last bg-default">
                    <div class="container">
                        <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('abito.care.title') }}</span></h3>
                        <div class="row row-30 justify-content-center">
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-minimal">
                                    <div class="box-minimal-icon"><i class="fa fa-wrench"></i></div>
                                    <h5 class="box-minimal-title">{{ __('abito.care.maintenance.title') }}</h5>
                                    <div class="box-minimal-text">{{ __('abito.care.maintenance.text') }}</div>
                                </article>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-minimal">
                                    <div class="box-minimal-icon"><i class="fa fa-archive"></i></div>
                                    <h5 class="box-minimal-title">{{ __('abito.care.storage.title') }}</h5>
                                    <div class="box-minimal-text">{{ __('abito.care.storage.text') }}</div>
                                </article>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <article class="box-minimal">
                                    <div class="box-minimal-icon"><i class="fa fa-users"></i></div>
                                    <h5 class="box-minimal-title">{{ __('abito.care.tradition.title') }}</h5>
                                    <div class="box-minimal-text">{{ __('abito.care.tradition.text') }}</div>
                                </article>
                            </div>
                        </div>
                    </div>
                </section>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="col-xl-3">
                @include('partials.aside')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
{{-- Scripts for lightgallery can be added here if needed --}}
@endsection
