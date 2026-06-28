@extends('layouts.app')

@section('title', __('italia-gira-banda.meta.title'))
@section('description', __('italia-gira-banda.meta.description'))
@section('og_title', __('italia-gira-banda.meta.og_title'))
@section('og_description', __('italia-gira-banda.meta.og_description'))

@section('content')
    @php($dynamicBlocks = \App\Models\StaticPage::contentBlocks('italia_gira_banda'))

    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('italia-gira-banda.title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('italia-gira-banda.home') }}</a></li>
                    <li class="active">{{ __('italia-gira-banda.title') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ \App\Models\StaticPage::headerImageUrl('italia_gira_banda', 'images/FotoRoma1.webp') }});"></div>
        </div>
    </section>

    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-xl-9 pr-xl-5">
                @if ($dynamicBlocks !== [])
                    @include('partials.static-page-content', ['blocks' => $dynamicBlocks])
                @else
                <!-- Italia Gira Banda Content -->
                <section class="section section-sm section-first bg-default text-left">
                    <h2 class="title-decoration-lines-left">{{ __('italia-gira-banda.intro.title') }}</h2>
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-md-10 col-lg-7 col-xl-6">
                            <p class="text-gray-800">{{ __('italia-gira-banda.intro.p1') }}</p>
                            <p class="text-gray-800">{{ __('italia-gira-banda.intro.p2') }}</p>
                            <p class="text-gray-800">{{ __('italia-gira-banda.intro.p3') }}</p>
                        </div>
                        <div class="col-md-10 col-lg-5 col-xl-6">
                            <a href="{{ \App\Models\StaticPage::contentImageUrl('italia_gira_banda', 'images/FotoRoma2.webp', 0) }}" data-lightgallery="item">
                                <div class="figure-classic figure-classic-left wow fadeInRight">
                                    <img src="{{ \App\Models\StaticPage::contentImageUrl('italia_gira_banda', 'images/FotoRoma2.webp', 0) }}"
                                         alt="{{ __('italia-gira-banda.images.rome_alt') }}"
                                         class="aspect-ratio-16-9 object-fit-cover"
                                         width="100%"
                                         loading="lazy">
                                </div>
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Roma -->
                <section class="section section-sm bg-gray-100">
                    <h3 class="title-decoration-lines-left text-left">{{ __('italia-gira-banda.rome.title') }}</h3>
                    <div class="row row-50 justify-content-center align-items-xl-center">
                        <div class="col-md-10 col-lg-5 col-xl-6">
                            <a href="{{ \App\Models\StaticPage::contentImageUrl('italia_gira_banda', 'images/FotoRoma3.webp', 1) }}" data-lightgallery="item">
                                <div class="figure-classic figure-classic-left wow fadeInLeft">
                                    <img src="{{ \App\Models\StaticPage::contentImageUrl('italia_gira_banda', 'images/FotoRoma3.webp', 1) }}"
                                         alt="{{ __('italia-gira-banda.images.group_alt') }}"
                                         class="aspect-ratio-16-9 object-fit-cover"
                                         width="100%"
                                         loading="lazy">
                                </div>
                            </a>
                        </div>
                        <div class="col-md-10 col-lg-7 col-xl-6">
                            <div class="text-left">
                                <p>{{ __('italia-gira-banda.rome.p1') }}</p>
                                <p>{{ __('italia-gira-banda.rome.p2') }}</p>
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                <!-- Interactive Book -->
                <section class="section section-sm bg-default">
                    <h3 class="title-decoration-lines-left text-left">{{ __('italia-gira-banda.book.title') }}</h3>
                    <p class="text-gray-800">{{ __('italia-gira-banda.book.description') }}</p>
                    <div class="mb-4" style="height: min(80vh, 760px); min-height: 520px;">
                        <iframe
                            src="{{ asset('books/italia-gira-banda/index.html') }}"
                            title="{{ __('italia-gira-banda.book.title') }}"
                            style="width: 100%; height: 100%; border: 0;"
                            loading="lazy"
                            allowfullscreen>
                        </iframe>
                    </div>
                    <a class="button button-primary button-winona"
                       href="{{ asset('books/italia-gira-banda/index.html') }}"
                       target="_blank"
                       rel="noopener">
                        {{ __('italia-gira-banda.book.open') }}
                    </a>
                </section>

                <!-- Call to Action -->
                <section class="section section-sm section-last bg-default text-center">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <h4>{{ __('italia-gira-banda.cta.title') }}</h4>
                            <a class="button button-primary button-winona" href="{{ route('storia') }}">{{ __('italia-gira-banda.cta.button') }}</a>
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
