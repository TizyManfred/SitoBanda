@extends('layouts.app')

@section('title', __('abito.meta.title'))
@section('description', __('abito.meta.description'))
@section('og_title', __('abito.meta.og_title'))
@section('og_description', __('abito.meta.og_description'))

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/abito.css') }}?v={{ filemtime(public_path('css/abito.css')) }}">
@endsection

@section('content')
    @php
        $dynamicBlocks = \App\Models\StaticPage::contentBlocks('abito_tradizionale');
        $costumeElementGroups = [
            [
                'title' => __('abito.elements.accessories'),
                'items' => [
                    ['key' => 'apron', 'image' => 'images/abito/grembiule-scialle.webp', 'icon' => 'fa-star'],
                    ['key' => 'jewelry', 'image' => 'images/abito/gioielli.webp', 'icon' => 'fa-diamond'],
                    ['key' => 'hairstyle', 'image' => 'images/abito/acconciatura.webp', 'icon' => 'fa-user'],
                ],
            ],
            [
                'title' => __('abito.elements.structure'),
                'items' => [
                    ['key' => 'dress', 'image' => 'images/abito/veste.webp', 'icon' => 'fa-female'],
                    ['key' => 'colors', 'image' => 'images/abito/colori-dape.webp', 'icon' => 'fa-heart'],
                    ['key' => 'protection', 'image' => 'images/abito/salvacore.webp', 'icon' => 'fa-shield'],
                ],
            ],
        ];
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
                <section class="section section-sm bg-default costume-elements">
                    <div class="container">
                        <div class="costume-elements-heading text-center">
                            <span class="costume-elements-mark" aria-hidden="true"><i class="fa fa-star"></i></span>
                            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('abito.elements.title') }}</span></h3>
                        </div>

                        @foreach ($costumeElementGroups as $group)
                            <div class="costume-elements-group{{ $loop->last ? '' : ' mb-5' }}">
                                <h4 class="costume-elements-group-title">{{ $group['title'] }}</h4>

                                <div class="row row-30 costume-elements-grid">
                                    @foreach ($group['items'] as $element)
                                        @php
                                            $imageExists = file_exists(public_path($element['image']));
                                            $title = __('abito.elements.' . $element['key'] . '.title');
                                        @endphp
                                        <div class="col-md-6 col-lg-4 d-flex">
                                            <article class="costume-element-card wow fadeInUp">
                                                <div class="costume-element-media">
                                                    @if ($imageExists)
                                                        <img src="{{ asset($element['image']) }}" alt="{{ $title }}" width="640" height="480" loading="lazy">
                                                    @else
                                                        <div class="costume-element-placeholder" aria-hidden="true">
                                                            <i class="fa {{ $element['icon'] }}"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="costume-element-body">
                                                    <span class="costume-element-icon" aria-hidden="true"><i class="fa {{ $element['icon'] }}"></i></span>
                                                    <h5 class="costume-element-title">{{ $title }}</h5>
                                                    <p class="costume-element-text">{{ __('abito.elements.' . $element['key'] . '.text') }}</p>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
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
