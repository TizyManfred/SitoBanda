@extends('layouts.app')

@section('title', __('gallery.title') . ' - ' . config('app.name'))
@section('description', __('gallery.description'))
@section('og_title', __('gallery.title') . ' - ' . config('app.name'))
@section('og_description', __('gallery.description'))

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

@section('styles')
<!-- Using existing classes from style.css and bootstrap.css -->
@endsection

@section('content')
<!-- Breadcrumbs -->
<section class="breadcrumbs-custom-inset">
    <div class="breadcrumbs-custom context-dark bg-overlay-60">
        <div class="container">
            <h1 class="breadcrumbs-custom-title">{{ __('gallery.title') }}</h1>
            <ul class="breadcrumbs-custom-path">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="active">{{ __('gallery.breadcrumb') }}</li>
            </ul>
        </div>
        <div class="box-position" style="background-image: url({{ asset('images/FotoGalleria1.jpg') }});"></div>
    </div>
</section>

<!-- Gallery Section -->
<section class="section section-sm section-first bg-default">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-5">
                <h2 class="title-decoration-lines-center mb-3">{{ __('gallery.header') }}</h2>
                <p class="lead text-muted">{{ __('gallery.subheader') }}</p>
            </div>
        </div>
        

        
        <!-- Albums Grid -->
        <div class="row">
            @if(isset($albums) && $albums->count() > 0)
                @foreach($albums as $album)
                    <a href="{{ route('galleria.album', $album->slug ?? $album->slug->it) }}" class="d-block col-md-6 col-lg-4 mb-5 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div >
                            <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-0 card-hover-scale">
                                <div class="position-relative img-hover-zoom">
                                    @if($album->items->first())
                                        <img src="{{ Storage::url($album->items->first()->image_path) }}" 
                                                class="img-fluid" 
                                                alt="{{ $album->title }}" 
                                                loading="lazy"
                                                style="height: 220px; width: 100%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/placeholder-album.jpg') }}" 
                                                class="card-img-top img-fluid" 
                                                alt="{{ $album->title }}" 
                                                loading="lazy"
                                                style="height: 220px; width: 100%; object-fit: cover;">
                                    @endif
                                    <div class="position-absolute top-0 right-0 bg-primary text-white p-2 rounded bg-black-opacity-60">
                                        <i class="far fa-images"></i> {{ $album->items_count }}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title mb-2">
                                        <span class="text-dark text-decoration-none">{{ $album->title }}</span>
                                    </h5>
                                    @if($album->description)
                                        <p class="card-text text-muted small mb-3">
                                            {{ Str::limit($album->description, 120) }}
                                        </p>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-light text-dark">
                                            <i class="far fa-calendar-alt me-1"></i> {{ $album->created_at->translatedFormat(__('M Y')) }}
                                        </span>
                                        <span class="btn btn-sm btn-outline-primary">
                                            {{ __('gallery.view_album') }} <i class="fas fa-arrow-right ms-1"></i>
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
                            <i class="fas fa-home me-2"></i> {{ __('gallery.back_to_home') }}
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
@endsection
