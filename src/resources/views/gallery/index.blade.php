@extends('layouts.app')

@php
    $hasListingQuery = request()->query() !== [];
@endphp

@section('title', __('gallery.title') . ' - ' . config('app.name'))
@section('description', __('gallery.description'))
@section('og_title', __('gallery.title') . ' - ' . config('app.name'))
@section('og_description', __('gallery.description'))
@if($hasListingQuery)
    @section('canonical', route('galleria'))
    @section('robots', 'noindex, follow')
@endif

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('gallery.title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('header.home') }}</a></li>
                    <li class="active">{{ __('gallery.breadcrumb') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ \App\Models\StaticPage::headerImageUrl('gallery_index', 'images/FotoGalleria1.webp') }});"></div>
        </div>
    </section>

    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-xl-9 pr-xl-5">

                <!-- Gallery Section -->
                <section class="section section-sm section-first bg-default text-left">
                    <div class="container">
                        <h2 class="title-decoration-lines-left mb-3">{{ __('gallery.header') }}</h2>
                        <p class="">{{ __('gallery.subheader') }}</p>
                        
                        <!-- Albums Grid -->
                        <div class="row">
                            @if(isset($albums) && $albums->count() > 0)
                                @foreach($albums as $album)
                                    <a href="{{ route('galleria.album', $album->slug ?? $album->slug->it) }}" class="d-block col-md-6 col-lg-4 mb-5 wow fadeInUp gallery-album-card-link" data-wow-delay="0.{{ $loop->iteration }}s">
                                        <div >
                                            <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-0 card-hover-scale">
                                                <div class="position-relative img-hover-zoom">
                                                    @if($album->items && $album->items->count() > 0)
                                                        @php $carouselId = 'album-carousel-' . $album->id; @endphp
                                                        <div id="{{ $carouselId }}" class="carousel slide" data-ride="carousel" data-interval="{{ random_int(4000, 6000) }}">
                                                            <div class="carousel-inner" style="height: 220px;">
                                                                @foreach($album->items as $loopIndex => $item)
                                                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                                        <img src="{{ Storage::url($item->image_path) }}"
                                                                            class="d-block w-100 img-fluid"
                                                                            alt="{{ $album->title }}"
                                                                            loading="lazy"
                                                                            style="height: 220px; width: 100%; object-fit: cover;">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img src="{{ asset('images/FotoGalleria1.webp') }}"
                                                            class="card-img-top img-fluid" 
                                                            alt="{{ $album->title }}" 
                                                            loading="lazy"
                                                            style="height: 220px; width: 100%; object-fit: cover;">
                                                    @endif
                                                    <div class="position-absolute top-0 right-0 bg-primary text-white p-2 rounded bg-black-opacity-60">
                                                        <i class="fa fa-image"></i> {{ $album->items_count }}
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title mb-2 gallery-album-card-title">
                                                        <span class="text-dark text-decoration-none">{{ $album->title }}</span>
                                                    </h5>
                                                    @if($album->description)
                                                        <p class="card-text text-muted small mb-3">
                                                            {{ Str::limit(strip_tags($album->description), 120) }}
                                                        </p>
                                                    @endif
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @if($album->start_date)
                                                            <span class="badge bg-light text-dark">
                                                                <i class="fa fa-calendar me-1"></i> {{ $album->start_date->translatedFormat('M Y') }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-light text-dark">
                                                                <i class="fa fa-images me-1"></i> {{ trans_choice('gallery.photos', $album->items_count ?? 0, ['count' => $album->items_count ?? 0]) }}
                                                            </span>
                                                        @endif
                                                        <span class="btn btn-sm btn-outline-primary">
                                                            {{ __('gallery.view_album') }} <i class="fa fa-arrow-right ms-1"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <div class="mb-4">
                                            <i class="far fa-images fa-4x text-primary mb-3"></i>
                                        </div>
                                        <h4 class="mb-3">{{ __('gallery.no_albums') }}</h4>
                                        <p class="text-muted mb-4">{{ __('gallery.check_back') }}</p>
                                        <a href="{{ route('home') }}" class="btn btn-primary">
                                            <i class="fa fa-home me-2"></i> {{ __('gallery.back_to_home') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Pagination -->
                        @if(isset($albums) && method_exists($albums, 'hasPages') && $albums->hasPages())
                            <div class="d-flex justify-content-center mt-5">
                                {{ $albums->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                </section>
            </div> 
            <div class="col-xl-3">
                @include('partials.aside')
            </div>
        </div>
    </div>
@endsection
