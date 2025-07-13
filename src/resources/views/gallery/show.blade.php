@extends('layouts.app')

@section('title', $album->title . ' - Galleria - Banda Folk di Castello Tesino')
@section('description', $album->description ? $album->description : 'Galleria fotografica ' . $album->title . ' della Banda Folk di Castello Tesino')
@section('og_title', $album->title . ' - Galleria - Banda Folk di Castello Tesino')
@section('og_description', $album->description ? $album->description : 'Galleria fotografica ' . $album->title . ' della Banda Folk di Castello Tesino')
@if($album->cover_image_path)
    @section('og_image', asset($album->cover_image_path))
@endif

@section('styles')
<style>
    .gallery-container {
        margin-bottom: 30px;
    }
    .gallery-item {
        margin-bottom: 30px;
    }
    .gallery-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 5px;
        transition: transform 0.3s ease;
    }
    .gallery-item a:hover img {
        transform: scale(1.03);
    }
    .album-info {
        margin-bottom: 30px;
    }
    .album-meta {
        margin-bottom: 20px;
    }
    .album-meta-item {
        display: inline-block;
        margin-right: 20px;
        color: #777;
    }
    .album-meta-item i {
        margin-right: 5px;
        color: #01b3a7;
    }
    .album-description {
        margin-bottom: 30px;
    }
    .related-albums {
        margin-top: 60px;
    }
    .related-album {
        margin-bottom: 20px;
    }
    .related-album img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 5px;
    }
    .related-album-title {
        margin-top: 10px;
        font-size: 16px;
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ $album->title }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('galleria') }}">{{ __('Galleria') }}</a></li>
                    <li class="active">{{ $album->title }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ $album->cover_image_path ? asset($album->cover_image_path) : asset('images/gallery-default.jpg') }});"></div>
        </div>
    </section>

    <!-- Gallery Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Album Info -->
                    <div class="album-info">
                        <div class="album-meta">
                            @if($album->year)
                                <div class="album-meta-item">
                                    <i class="bi bi-calendar"></i> {{ $album->year }}
                                </div>
                            @endif
                            <div class="album-meta-item">
                                <i class="bi bi-images"></i> {{ $images->count() }} {{ __('foto') }}
                            </div>
                            <div class="album-meta-item">
                                <i class="bi bi-eye"></i> {{ $album->view_count ?? 0 }} {{ __('visualizzazioni') }}
                            </div>
                        </div>
                        
                        @if($album->description)
                            <div class="album-description">
                                <p>{{ $album->description }}</p>
                            </div>
                        @endif
                        
                        @if($event)
                            <div class="album-event">
                                <h5>{{ __('Evento correlato') }}</h5>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                @if($event->image_path)
                                                    <img src="{{ asset($event->image_path) }}" alt="{{ $event->title }}" class="img-fluid rounded" loading="lazy">
                                                @else
                                                    <img src="{{ asset('images/event-default.jpg') }}" alt="{{ $event->title }}" class="img-fluid rounded" loading="lazy">
                                                @endif
                                            </div>
                                            <div class="col-md-8">
                                                <h5>{{ $event->title }}</h5>
                                                <p class="text-muted">
                                                    <i class="bi bi-calendar-event"></i> {{ $event->start_datetime->format('d/m/Y') }}
                                                    <i class="bi bi-geo-alt ms-3"></i> {{ $event->location }}
                                                </p>
                                                <p>{{ Str::limit($event->short_description, 100) }}</p>
                                                <a href="{{ route('eventi.show', $event->slug) }}" class="button button-sm button-default-outline-2 button-wapasha">
                                                    {{ __('Dettagli Evento') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Gallery Images -->
                    <div class="gallery-container">
                        <div class="row row-30 gallery-grid">
                            @forelse($images as $image)
                                <div class="col-sm-6 col-lg-4 gallery-item">
                                    <a href="{{ asset($image->file_path) }}" data-lightbox="album-gallery" data-title="{{ $image->title ?? $album->title }}">
                                        <img src="{{ asset($image->thumbnail_path ?? $image->file_path) }}" alt="{{ $image->title ?? $album->title }}" loading="lazy">
                                    </a>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        {{ __('Non ci sono immagini disponibili in questo album.') }}
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        
                        <!-- Pagination -->
                        @if($images instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="pagination-wrap">
                                {{ $images->links() }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Social Share -->
                    <div class="social-share mt-4">
                        <h5>{{ __('Condividi questa galleria') }}</h5>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('galleria.show', $album->slug)) }}" target="_blank" aria-label="Condividi su Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($album->title) }}&url={{ urlencode(route('galleria.show', $album->slug)) }}" target="_blank" aria-label="Condividi su Twitter">
                                    <i class="bi bi-twitter"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://wa.me/?text={{ urlencode($album->title . ' - ' . route('galleria.show', $album->slug)) }}" target="_blank" aria-label="Condividi su WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="mailto:?subject={{ urlencode($album->title) }}&body={{ urlencode(($album->description ?? '') . ' - ' . route('galleria.show', $album->slug)) }}" aria-label="Condividi via Email">
                                    <i class="bi bi-envelope"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="aside-gallery">
                        <!-- Other Albums -->
                        @if($otherAlbums->count() > 0)
                            <div class="aside-gallery-item">
                                <h5 class="aside-gallery-title">{{ __('Altri Album') }}</h5>
                                <div class="row row-20">
                                    @foreach($otherAlbums as $otherAlbum)
                                        <div class="col-6 col-lg-6">
                                            <div class="related-album">
                                                <a href="{{ route('galleria.show', $otherAlbum->slug) }}">
                                                    <img src="{{ $otherAlbum->cover_image_path ? asset($otherAlbum->cover_image_path) : asset('images/gallery-default.jpg') }}" alt="{{ $otherAlbum->title }}" loading="lazy">
                                                    <h6 class="related-album-title">{{ $otherAlbum->title }}</h6>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-center mt-4">
                                    <a href="{{ route('galleria') }}" class="button button-sm button-default-outline-2 button-wapasha">
                                        {{ __('Tutti gli Album') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Archive -->
                        <div class="aside-gallery-item mt-5">
                            <h5 class="aside-gallery-title">{{ __('Archivio') }}</h5>
                            <ul class="list-marked list-marked-secondary">
                                @foreach(range(date('Y'), date('Y') - 4) as $year)
                                    <li><a href="{{ route('galleria', ['year' => $year]) }}">{{ $year }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <!-- Social Links -->
                        <div class="aside-gallery-item mt-5">
                            <h5 class="aside-gallery-title">{{ __('Seguici sui Social') }}</h5>
                            <ul class="list-inline social-list">
                                <li class="list-inline-item">
                                    <a href="https://www.facebook.com/bandafolk" target="_blank" aria-label="Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://www.instagram.com/bandafolk" target="_blank" aria-label="Instagram">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://www.youtube.com/bandafolk" target="_blank" aria-label="YouTube">
                                        <i class="bi bi-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': "{{ __('Immagine %1 di %2') }}"
        });
    });
</script>
@endsection
