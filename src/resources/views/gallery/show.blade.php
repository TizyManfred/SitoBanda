@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

$metaDescription = Str::limit(
    trim($album->description ?: ''),
    160
);

if ($metaDescription === '') {
    $metaDescription = Str::limit(
        collect([
            $album->title,
            $images->count() . ' ' . trans_choice('gallery.photos', $images->count()),
            $album->start_date?->translatedFormat('F Y'),
        ])->filter()->implode(' - '),
        160
    );
}

$coverImage = $images->count() > 0 ? Storage::url($images->first()->image_path) : asset('images/gallery-default.jpg');
@endphp

@section('title', $album->title . ' - Galleria - Banda Folk di Castello Tesino')
@section('description', $metaDescription)
@section('og_title', $album->title . ' - Galleria - Banda Folk di Castello Tesino')
@section('og_description', $metaDescription)
@section('og_type', 'article')
@section('og_image', $coverImage)


@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ $album->title }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('header.home') }}</a></li>
                    <li><a href="{{ route('galleria') }}">{{ __('gallery.breadcrumb') }}</a></li>
                    <li class="active">{{ $album->title }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ $coverImage }}); background-position: center center;"></div>
        </div>
    </section>

    <!-- Gallery Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-12">
                    <!-- Album Info -->
                    <div class="post">
                        <div class="box-inset-1">
                            {{-- <h2 class="mb-4 title-decoration-lines-left">{{ $album->title }}</h2> --}}
                            
                            <div class="row box-event-modern-meta">
                                @if($album->start_date)
                                    <div class="col-auto box-event-modern-meta-item mr-3">
                                        <i class="fa fa-calendar mr-1"></i> <span class="font-weight-bold">{{ $album->start_date->translatedFormat(__('d M Y')) }}</span>
                                    </div>
                                @endif
                                <div class="col-auto box-event-modern-meta-item mr-3">
                                    <i class="fa fa-image mr-1"></i> <span class="font-weight-bold">{{ $images->count() }}</span> {{ __('foto') }}
                                </div>
                                <div class="col-auto box-event-modern-meta-item">
                                    <i class="fa fa-eye mr-1"></i> <span class="font-weight-bold">{{ $album->view_count ?? 0 }}</span> {{ __('visualizzazioni') }}
                                </div>
                            </div>
                            
                            @if($album->description)
                                <div class="mt-3">
                                    <p class="font-weight-normal">{{ $album->description }}</p>
                                </div>
                            @endif
                        
                        @if(isset($event) && $event)
                            <div class="mt-4 pt-3">
                                <h5 class="heading-5">{{ __('Evento correlato') }}</h5>
                                <div class="box-event-modern">
                                    <div class="box-event-modern-figure">
                                        @if($event->image_path)
                                            <a href="{{ route('eventi.show', $event->slug) }}">
                                                <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="img-responsive" loading="lazy">
                                            </a>
                                        @else
                                            <a href="{{ route('eventi.show', $event->slug) }}">
                                                <img src="{{ asset('images/event-default.jpg') }}" alt="{{ $event->title }}" class="img-responsive" loading="lazy">
                                            </a>
                                        @endif
                                    </div>
                                    <div class="box-event-modern-body">
                                        <div class="box-event-modern-date">
                                            <div class="box-event-modern-date-day">{{ $event->start_datetime->format('d') }}</div>
                                            <div class="box-event-modern-date-month">{{ $event->start_datetime->format('M') }}</div>
                                        </div>
                                        <h5 class="box-event-modern-title"><a href="{{ route('eventi.show', $event->slug) }}">{{ $event->title }}</a></h5>
                                        <div class="box-event-modern-text">
                                            <p>{{ Str::limit($event->short_description, 120) }}</p>
                                        </div>
                                        <div class="box-event-modern-info">
                                            <span><i class="fa fa-map-marker mr-1"></i> {{ $event->location }}</span>
                                        </div>
                                        <a href="{{ route('eventi.show', $event->slug) }}" class="button button-sm button-default-outline button-wapasha">
                                            {{ __('Dettagli Evento') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Gallery Images -->
                    <div class="mt-5 mb-5">
                        <h4 class="heading-4 mb-4">{{ __('Foto') }}</h4>
                        <div class="divider"></div>
                        
                        <div class="row row-30 offset-top-40" data-lightgallery="group">
                            @forelse($images as $image)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="thumbnail-classic">
                                        <div class="thumbnail-classic-figure">
                                            <a href="{{ Storage::url($image->image_path) }}" data-lightgallery="item" data-title="{{ $image->caption ?? $album->title }}">
                                                <div class="image-height-1">
                                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->caption ?? $album->title }}" loading="lazy">
                                                </div>
                                            </a>
                                        </div>
                                        @if($image->caption)
                                        <div class="thumbnail-classic-caption">
                                            <div class="thumbnail-classic-title-wrap">
                                                <h6 class="thumbnail-classic-title">{{ $image->caption }}</h6>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="box-default">
                                        <p>{{ __('Non ci sono immagini disponibili in questo album.') }}</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        
                        <!-- Pagination -->
                        @if($images instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="pagination-wrap mt-4">
                                {{ $images->links() }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="aside">
                        <!-- Other Albums -->
                        @if($otherAlbums->count() > 0)
                            <div class="aside-item mb-5">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light border-0">
                                        <h5 class="mb-0">
                                            <i class="fas fa-images me-2 text-primary"></i>
                                            {{ __('Altri Album') }}
                                        </h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="list-group list-group-flush">
                                            @foreach($otherAlbums as $otherAlbum)
                                                <a href="{{ route('galleria.album', $otherAlbum->slug) }}" class="list-group-item list-group-item-action border-0 py-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="position-relative">
                                                                @php
                                                                    $coverImage = null;
                                                                    if ($otherAlbum->items()->count() > 0) {
                                                                        $coverImage = $otherAlbum->items()->where('is_featured', 1)->first() ?? $otherAlbum->items()->orderBy('sort_order', 'asc')->first();
                                                                    }
                                                                @endphp
                                                                <img src="{{ $coverImage && $coverImage->image_path ? Storage::url($coverImage->image_path) : asset('images/gallery-default.jpg') }}" 
                                                                     class="rounded" 
                                                                     alt="{{ $otherAlbum->title }}" 
                                                                     loading="lazy"
                                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                                <div class="position-absolute top-0 start-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                                     style="width: 20px; height: 20px; font-size: 10px;">
                                                                    <i class="fas fa-images"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="mb-1 text-dark">{{ $otherAlbum->title }}</h6>
                                                            <small class="text-muted">
                                                                <i class="fas fa-calendar me-1"></i>
                                                                @if($otherAlbum->year)
                                                                    {{ $otherAlbum->year }}
                                                                @elseif($otherAlbum->start_date)
                                                                    {{ $otherAlbum->start_date->format('Y') }}
                                                                @endif
                                                                • {{ $otherAlbum->items_count }} {{ __('foto') }}
                                                            </small>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-chevron-right text-muted"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="card-footer bg-light border-0 text-center">
                                        <a href="{{ route('galleria') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-th-large me-1"></i>
                                            {{ __('Tutti gli Album') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Archive -->
                        <div class="aside-item mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light border-0">
                                    <h5 class="mb-0">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                        {{ __('Archivio') }}
                                    </h5>
                                </div>
                                <div class="card-body p-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach(range(date('Y'), date('Y') - 4) as $year)
                                            <a href="{{ route('galleria', ['year' => $year]) }}" 
                                               class="badge badge-pill badge-outline-primary transition-all hover-scale-sm">
                                                {{ $year }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Social Links -->
                        <div class="aside-item">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light border-0">
                                    <h5 class="mb-0">
                                        <i class="fas fa-share-alt me-2 text-primary"></i>
                                        {{ __('Seguici sui Social') }}
                                    </h5>
                                </div>
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="https://www.facebook.com/bandafolk" 
                                           target="_blank" 
                                           class="btn btn-outline-primary btn-sm rounded-circle"
                                           aria-label="Facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="https://www.instagram.com/bandafolk" 
                                           target="_blank" 
                                           class="btn btn-outline-danger btn-sm rounded-circle"
                                           aria-label="Instagram">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a href="https://www.youtube.com/bandafolk" 
                                           target="_blank" 
                                           class="btn btn-outline-danger btn-sm rounded-circle"
                                           aria-label="YouTube">
                                            <i class="fab fa-youtube"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('structured_data')
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "{{ __('header.home') }}",
                    "item": "{{ route('home') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "{{ __('gallery.breadcrumb') }}",
                    "item": "{{ route('galleria') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": @json($album->title),
                    "item": "{{ url()->current() }}"
                }
            ]
        },
        {
            "@type": "ImageGallery",
            "name": @json($album->title),
            "description": @json($metaDescription),
            "url": "{{ url()->current() }}",
            "image": ["{{ url($coverImage) }}"]
        }
    ]
}
@endsection
