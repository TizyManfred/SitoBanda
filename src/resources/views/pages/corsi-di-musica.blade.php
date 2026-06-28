@extends('layouts.app')

@section('title', __('corsi-di-musica.meta.title'))
@section('description', __('corsi-di-musica.meta.description'))
@section('og_title', __('corsi-di-musica.meta.og_title'))
@section('og_description', __('corsi-di-musica.meta.og_description'))

@section('content')
    @php($dynamicBlocks = \App\Models\StaticPage::contentBlocks('corsi_di_musica'))

    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('corsi-di-musica.title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('header.home') }}</a></li>
                    <li class="active">{{ __('corsi-di-musica.title') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ \App\Models\StaticPage::headerImageUrl('corsi_di_musica', 'images/FotoShanghai1.webp') }});"></div>
        </div>
    </section>

    <!-- Corsi di Musica Content -->
    <section class="section section-sm section-first bg-default text-left">
        <div class="container">
            <div class="row row-50">
                <!-- Main Text -->
                <div class="col-lg-10 col-xl-8">
                    @if ($dynamicBlocks !== [])
                        @include('partials.static-page-content', ['blocks' => $dynamicBlocks, 'embedded' => true])
                    @else
                        <div class="container">
                            <h2 class="title-decoration-lines-left">{{ __('corsi-di-musica.content.heading') }}</h2>
                            <div class="row row-50">
                                <div class="col-lg-6 col-xl-6">
                                    <div class="figure-classic figure-classic-left">
                                        <img src="{{ \App\Models\StaticPage::contentImageUrl('corsi_di_musica', 'images/FotoTrento1.webp', 0) }}" alt="{{ __('corsi-di-musica.content.image_alt') }}" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6">
                                    <p>{{ __('corsi-di-musica.content.paragraph_1') }}</p>
                                    <p>{{ __('corsi-di-musica.content.paragraph_2') }}</p>
                                    <p>{{ __('corsi-di-musica.content.paragraph_3') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-10 col-xl-4">
                    @include('partials.courses-sidebar')
                </div>
            </div>
            
        </div>
    </section>

    
@endsection
