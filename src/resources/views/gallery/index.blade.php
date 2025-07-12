@extends('layouts.app')

@section('title', 'Galleria - Banda Folk di Castello Tesino')
@section('description', 'Esplora la galleria fotografica della Banda Folk di Castello Tesino. Immagini dei nostri concerti, eventi e momenti speciali.')
@section('og_title', 'Galleria - Banda Folk di Castello Tesino')
@section('og_description', 'Esplora la galleria fotografica della Banda Folk di Castello Tesino. Immagini dei nostri concerti, eventi e momenti speciali.')

@section('styles')
<style>
    .gallery-album {
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }
    .gallery-album:hover {
        transform: translateY(-5px);
    }
    .gallery-album-img {
        position: relative;
        overflow: hidden;
        border-radius: 5px;
    }
    .gallery-album-img img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .gallery-album:hover .gallery-album-img img {
        transform: scale(1.05);
    }
    .gallery-album-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
        padding: 20px;
        color: white;
    }
    .gallery-album-title {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }
    .gallery-album-count {
        font-size: 14px;
        opacity: 0.8;
    }
    .gallery-album-year {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: rgba(1, 179, 167, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 14px;
        font-weight: 600;
    }
    .gallery-filter {
        margin-bottom: 30px;
    }
    .gallery-filter .btn {
        margin-right: 5px;
        margin-bottom: 10px;
    }
    .gallery-filter .btn.active {
        background-color: #01b3a7;
        color: white;
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Galleria') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Galleria') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoSanIppolito1.jpg') }});"></div>
        </div>
    </section>

    <!-- Gallery Albums -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Album Fotografici') }}</span></h3>
            
            <!-- Gallery Filter -->
            <div class="gallery-filter">
                <div class="btn-group" role="group" aria-label="Gallery filter">
                    <button type="button" class="btn btn-outline-primary active" data-filter="*">{{ __('Tutti') }}</button>
                    <button type="button" class="btn btn-outline-primary" data-filter=".concerti">{{ __('Concerti') }}</button>
                    <button type="button" class="btn btn-outline-primary" data-filter=".trasferte">{{ __('Trasferte') }}</button>
                    <button type="button" class="btn btn-outline-primary" data-filter=".eventi">{{ __('Eventi') }}</button>
                </div>
            </div>
            
            @if($albums->count() > 0)
                <div class="row row-30 gallery-grid">
                    @foreach($albums as $album)
                        <div class="col-sm-6 col-lg-4 gallery-item {{ $album->category ?? 'altri' }}">
                            <div class="gallery-album">
                                <a href="{{ route('galleria.show', $album->slug) }}" class="gallery-album-link">
                                    <div class="gallery-album-img">
                                        @if($album->cover_image_path)
                                            <img src="{{ asset($album->cover_image_path) }}" alt="{{ $album->title }}" loading="lazy">
                                        @else
                                            <img src="{{ asset('images/gallery-default.jpg') }}" alt="{{ $album->title }}" loading="lazy">
                                        @endif
                                        <div class="gallery-album-overlay">
                                            <h4 class="gallery-album-title">{{ $album->title }}</h4>
                                            <div class="gallery-album-count">
                                                {{ $album->items->count() }} {{ __('foto') }}
                                            </div>
                                        </div>
                                        @if($album->year)
                                            <div class="gallery-album-year">{{ $album->year }}</div>
                                        @endif
                                    </div>
                                </a>
                                <div class="gallery-album-info mt-2">
                                    <p class="gallery-album-description">
                                        {{ Str::limit($album->description, 100) }}
                                    </p>
                                    <a href="{{ route('galleria.show', $album->slug) }}" class="button button-sm button-default-outline-2 button-wapasha">
                                        {{ __('Visualizza Album') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="pagination-wrap">
                    {{ $albums->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    {{ __('Non ci sono album fotografici disponibili al momento.') }}
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Isotope
        var grid = document.querySelector('.gallery-grid');
        var iso = new Isotope(grid, {
            itemSelector: '.gallery-item',
            layoutMode: 'fitRows'
        });
        
        // Filter items on button click
        document.querySelector('.gallery-filter').addEventListener('click', function(event) {
            if (!event.target.matches('button')) return;
            
            var filterValue = event.target.getAttribute('data-filter');
            
            // Update active class
            document.querySelectorAll('.gallery-filter .btn').forEach(function(btn) {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Filter items
            if (filterValue === '*') {
                iso.arrange({ filter: '*' });
            } else {
                iso.arrange({ filter: filterValue });
            }
        });
    });
</script>
@endsection
