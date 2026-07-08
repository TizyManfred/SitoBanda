@extends('layouts.app')

@section('title', __('organico.meta_title'))
@section('description', __('organico.meta_description'))
@section('og_title', __('organico.meta_title'))
@section('og_description', __('organico.meta_description'))

@section('styles')
<style>
    .section-image-container {
        height: 360px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .section-image-container .slick-slider,
    .section-image-container .slick-list,
    .section-image-container .slick-track,
    .section-image-container .slick-slide,
    .section-image-container .slick-slide > div,
    .section-image-container .thumbnail-classic,
    .section-image-container .thumbnail-classic figure,
    .section-image-container img {
        height: 100% !important;
        width: 100% !important;
        object-fit: cover;
    }

    .organico-members-card .card-body {
        overflow: visible;
    }

    .organico-members-card .list-group-item {
        padding-top: 0.55rem !important;
        padding-bottom: 0.55rem !important;
    }

    .organico-members-card .fa-music {
        font-size: 0.85rem;
    }

    .organico-section-title {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .organico-section-icon {
        width: 44px;
        height: 44px;
        flex: 0 0 auto;
    }
</style>
@endsection

@section('content')
    @php
        $dynamicBlocks = \App\Models\StaticPage::contentBlocks('organico');
    @endphp

    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('organico.page_title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('organico.breadcrumb_home') }}</a></li>
                    <li class="active">{{ __('organico.breadcrumb_current') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url('{{ \App\Models\StaticPage::headerImageUrl('organico', 'images/FotoOrganico1.webp') }}');"></div>
        </div>
    </section>

    <div class="container py-5">
        <div class="row">
            <div class="col-xl-9 pr-xl-5">
                <section class="section section-sm section-first bg-default text-left">
                    <div class="container">
                        <div class="row row-30">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12 text-left">
                                        @if ($dynamicBlocks !== [])
                                            @include('partials.static-page-content', ['blocks' => $dynamicBlocks])
                                        @else
                                            <h2 class="title-decoration-lines-left">{{ __('organico.intro_title') }}</h2>
                                            <p class="text-gray-800">{{ __('organico.intro_text') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                @if(isset($sections) && count($sections) > 0)
                    @foreach($sections as $section)
                        @php
                            $sectionName = method_exists($section, 'getDisplayName')
                                ? $section->getDisplayName()
                                : ($section->name ?? __('organico.unnamed_section'));
                        @endphp
                        <section class="section section-sm {{ $loop->odd ? 'bg-gray-100' : 'bg-default' }}">
                            <div class="container">
                                <div class="row row-50 justify-content-center align-items-xl-center">
                                    <div class="col-md-10 col-lg-6 col-xl-6 {{ $loop->even ? 'order-lg-2' : '' }}">
                                        <div class="wow fadeInRight">
                                            @php
                                                $sectionImages = $section->images
                                                    ? $section->images->filter(fn ($image) => filled($image->resolved_image_path))->values()
                                                    : collect();
                                            @endphp
                                            @if($sectionImages->count() > 0)
                                                <div id="gallery-{{ $section->id }}" class="carousel slide w-100 figure-classic figure-classic-left" data-ride="carousel" data-interval="{{ random_int(2000, 4000) }}" data-lightgallery="group">
                                                    <div class="carousel-inner" style="overflow: hidden;">
                                                        @foreach($sectionImages as $image)
                                                            @php
                                                                $imagePath = $image->resolved_image_path;
                                                                $imageCaption = $image->resolved_caption;
                                                            @endphp
                                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="height: 350px;">
                                                                <a href="{{ Storage::url($imagePath) }}" data-lightgallery="item">
                                                                    <img
                                                                        src="{{ Storage::url($imagePath) }}"
                                                                        class="d-block w-100 h-100"
                                                                        alt="{{ $imageCaption ?: $sectionName }}"
                                                                        loading="lazy"
                                                                        style="object-fit: cover; cursor: pointer;"
                                                                    >
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if($sectionImages->count() > 1)
                                                        <a class="carousel-control-prev" href="#gallery-{{ $section->id }}" role="button" data-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">{{ __('organico.previous') }}</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#gallery-{{ $section->id }}" role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">{{ __('organico.next') }}</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <div style="height: 350px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 8px;">
                                                    <span class="text-muted">{{ __('organico.no_image') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-lg-6 col-xl-6">
                                        <div class="card border-0 shadow-sm h-100 organico-members-card">
                                            <div class="card-header bg-primary text-white">
                                                <h4 class="mb-0 organico-section-title">
                                                    @if(filled($section->icon_class))
                                                        <span class="organico-section-icon ii-4x {{ $section->icon_class }}" aria-hidden="true"></span>
                                                    @endif
                                                    <span>{{ $sectionName }}</span>
                                                </h4>
                                            </div>
                                            <div class="card-body p-0">
                                                @if(isset($section->members) && count($section->members) > 0)
                                                    <div class="list-group list-group-flush">
                                                        @foreach($section->members as $member)
                                                            <div class="list-group-item border-0 px-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3 text-muted">
                                                                        <i class="fas fa-music"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <span class="font-weight-bold">{{ $member->first_name }} {{ $member->last_name }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="p-4 text-center text-muted">
                                                        <i class="fas fa-info-circle mr-2"></i>{{ __('organico.no_members') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endforeach
                @else
                    <section class="section section-sm bg-default text-center">
                        <div class="container">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>
                                {{ __('organico.empty_state') }}
                            </div>
                        </div>
                    </section>
                @endif

                @if(app()->getLocale() === 'it')
                    <section class="section section-sm bg-gray-100">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-8 text-center">
                                    <div class="box-cta">
                                        <h3 class="box-cta-title">{{ __('organico.cta_title') }}</h3>
                                        <p class="box-cta-text">{{ __('organico.cta_text') }}</p>
                                        <a class="button button-primary button-pipaluk" href="{{ route('contatti') }}">{{ __('organico.cta_button') }}</a>
                                    </div>
                                </div>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/waypoints@4.0.1/lib/jquery.waypoints.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/counterup2@2.0.2/dist/index.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');

        counters.forEach(counter => {
            const countUp = new CountUp(counter, counter.textContent);

            new Waypoint({
                element: counter,
                handler: function() {
                    countUp.start();
                    this.destroy();
                },
                offset: 'bottom-in-view'
            });
        });
    });
</script>
@endsection
