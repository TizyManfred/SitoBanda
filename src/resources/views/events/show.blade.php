@extends('layouts.app')

@section('title', $event->title . ' - Banda Folk di Castello Tesino')
@section('description', $event->short_description)
@section('og_title', $event->title . ' - Banda Folk di Castello Tesino')
@section('og_description', $event->short_description)
@if($event->image_path)
    @section('og_image', asset($event->image_path))
@endif

@section('styles')
<style>
    .event-meta {
        margin-bottom: 20px;
    }
    .event-meta-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .event-meta-icon {
        margin-right: 10px;
        color: #01b3a7;
        font-size: 20px;
    }
    .event-gallery {
        margin-top: 40px;
    }
    .event-map {
        height: 400px;
        margin-top: 30px;
    }
    .related-events {
        margin-top: 60px;
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ $event->title }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('eventi') }}">{{ __('Eventi') }}</a></li>
                    <li class="active">{{ $event->title }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ $event->image_path ? asset($event->image_path) : asset('images/event-default.jpg') }});"></div>
        </div>
    </section>

    <!-- Event Details -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-8">
                    <div class="event-detail">
                        <!-- Event Image -->
                        @if($event->image_path)
                            <div class="event-image mb-4">
                                <img src="{{ asset($event->image_path) }}" alt="{{ $event->title }}" class="img-fluid" loading="lazy">
                            </div>
                        @endif
                        
                        <!-- Event Meta -->
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <div class="event-meta-icon">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div>
                                    <strong>{{ __('Data') }}:</strong> 
                                    {{ $event->start_datetime->format('d/m/Y') }}
                                    @if($event->end_datetime && $event->end_datetime->format('d/m/Y') != $event->start_datetime->format('d/m/Y'))
                                        - {{ $event->end_datetime->format('d/m/Y') }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="event-meta-item">
                                <div class="event-meta-icon">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div>
                                    <strong>{{ __('Orario') }}:</strong> 
                                    {{ $event->start_datetime->format('H:i') }}
                                    @if($event->end_datetime)
                                        - {{ $event->end_datetime->format('H:i') }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="event-meta-item">
                                <div class="event-meta-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <strong>{{ __('Luogo') }}:</strong> 
                                    {{ $event->location }}
                                    @if($event->address)
                                        <div class="small text-muted">{{ $event->address }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Event Description -->
                        <div class="event-description">
                            <h3>{{ __('Descrizione dell\'evento') }}</h3>
                            <div class="event-content">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                        
                        <!-- Event Gallery -->
                        @if($event->galleryAlbum && $event->galleryAlbum->items->count() > 0)
                            <div class="event-gallery">
                                <h3>{{ __('Galleria fotografica') }}</h3>
                                <div class="row row-30">
                                    @foreach($event->galleryAlbum->items->take(6) as $item)
                                        <div class="col-sm-6 col-lg-4">
                                            <a href="{{ asset($item->file_path) }}" data-lightbox="event-gallery" data-title="{{ $item->title }}">
                                                <img src="{{ asset($item->thumbnail_path) }}" alt="{{ $item->title }}" class="img-thumbnail" loading="lazy">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @if($event->galleryAlbum->items->count() > 6)
                                    <div class="text-center mt-4">
                                        <a href="{{ route('galleria.show', $event->galleryAlbum->slug) }}" class="button button-primary button-winona">
                                            {{ __('Vedi tutte le foto') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        <!-- Event Map -->
                        @if($event->latitude && $event->longitude)
                            <div class="event-map">
                                <h3>{{ __('Mappa') }}</h3>
                                <div id="event-map" class="event-map"></div>
                            </div>
                        @endif
                        
                        <!-- Social Share -->
                        <div class="social-share mt-4">
                            <h5>{{ __('Condividi questo evento') }}</h5>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('eventi.show', $event->slug)) }}" target="_blank" aria-label="Condividi su Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(route('eventi.show', $event->slug)) }}" target="_blank" aria-label="Condividi su Twitter">
                                        <i class="bi bi-twitter"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . route('eventi.show', $event->slug)) }}" target="_blank" aria-label="Condividi su WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="mailto:?subject={{ urlencode($event->title) }}&body={{ urlencode($event->short_description . ' - ' . route('eventi.show', $event->slug)) }}" aria-label="Condividi via Email">
                                        <i class="bi bi-envelope"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Related Events -->
                        @if($relatedEvents->count() > 0)
                            <div class="related-events">
                                <h3>{{ __('Eventi correlati') }}</h3>
                                <div class="row row-30">
                                    @foreach($relatedEvents as $relatedEvent)
                                        <div class="col-sm-6">
                                            <article class="box-event">
                                                <div class="box-event-img-wrap">
                                                    <a href="{{ route('eventi.show', $relatedEvent->slug) }}">
                                                        <img src="{{ $relatedEvent->image_path ? asset($relatedEvent->image_path) : asset('images/event-default.jpg') }}" alt="{{ $relatedEvent->title }}" width="570" height="370" loading="lazy">
                                                    </a>
                                                    <div class="box-event-date">
                                                        <div class="box-event-month">{{ $relatedEvent->start_datetime->format('M') }}</div>
                                                        <div class="box-event-day">{{ $relatedEvent->start_datetime->format('d') }}</div>
                                                    </div>
                                                </div>
                                                <div class="box-event-content">
                                                    <h5 class="box-event-title"><a href="{{ route('eventi.show', $relatedEvent->slug) }}">{{ $relatedEvent->title }}</a></h5>
                                                    <div class="box-event-info">
                                                        <div class="box-event-time">
                                                            <span class="icon mdi mdi-clock"></span>
                                                            <span class="box-event-text">{{ $relatedEvent->start_datetime->format('H:i') }}</span>
                                                        </div>
                                                        <div class="box-event-place">
                                                            <span class="icon mdi mdi-map-marker"></span>
                                                            <span class="box-event-text">{{ $relatedEvent->location }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="aside-events">
                        <div class="row row-50">
                            <div class="col-md-6 col-lg-12">
                                <div class="aside-events-item">
                                    <h5 class="aside-events-title">{{ __('Prossimi Eventi') }}</h5>
                                    @if($upcomingEvents->count() > 0)
                                        <ul class="list-events">
                                            @foreach($upcomingEvents as $upcomingEvent)
                                                <li class="list-events-item">
                                                    <div class="list-events-date">
                                                        <div class="list-events-month">{{ $upcomingEvent->start_datetime->format('M') }}</div>
                                                        <div class="list-events-day">{{ $upcomingEvent->start_datetime->format('d') }}</div>
                                                    </div>
                                                    <div class="list-events-info">
                                                        <h6 class="list-events-title"><a href="{{ route('eventi.show', $upcomingEvent->slug) }}">{{ $upcomingEvent->title }}</a></h6>
                                                        <div class="list-events-location">{{ $upcomingEvent->location }}</div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <a class="button button-sm button-default-outline-2 button-wapasha" href="{{ route('eventi') }}">{{ __('Tutti gli Eventi') }}</a>
                                    @else
                                        <p>{{ __('Non ci sono eventi in programma al momento.') }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-12">
                                <div class="aside-events-item">
                                    <h5 class="aside-events-title">{{ __('Categorie di Eventi') }}</h5>
                                    <ul class="list-marked list-marked-secondary">
                                        <li><a href="#">{{ __('Concerti') }}</a></li>
                                        <li><a href="#">{{ __('Processioni') }}</a></li>
                                        <li><a href="#">{{ __('Sagre e Feste') }}</a></li>
                                        <li><a href="#">{{ __('Commemorazioni') }}</a></li>
                                        <li><a href="#">{{ __('Trasferte') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-12">
                                <div class="aside-events-item">
                                    <h5 class="aside-events-title">{{ __('Seguici sui Social') }}</h5>
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
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@if($event->latitude && $event->longitude)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        var map = L.map('event-map').setView([{{ $event->latitude }}, {{ $event->longitude }}], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        L.marker([{{ $event->latitude }}, {{ $event->longitude }}])
            .addTo(map)
            .bindPopup("{{ $event->location }}")
            .openPopup();
    });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
@endsection
