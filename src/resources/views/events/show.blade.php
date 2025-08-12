@extends('layouts.app')

@section('title', $event->title . ' - Banda Folk di Castello Tesino')
@section('description', $event->short_description)
@section('og_title', $event->title . ' - Banda Folk di Castello Tesino')
@section('og_description', $event->short_description)
@if($event->image_path)
    @section('og_image', asset($event->image_path))
@endif

@section('styles')
<!-- Using existing classes from style.css and bootstrap.css -->
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ $event->title }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('events.home') }}</a></li>
                    <li><a href="{{ route('eventi') }}">{{ __('events.events') }}</a></li>
                    <li class="active">{{ $event->title }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ $event->image_path ? Storage::url($event->image_path) : asset('images/event-default.jpg') }});"></div>
        </div>
    </section>


    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-xl-9 pr-xl-5">
                <!-- Event Details -->
                <section class="section section-sm section-first bg-default text-md-left">
                    <div class="single-event-detail wow fadeInUp" data-wow-delay=".2s">
                        
                        <h2 class="title-decoration-lines-left">{{ $event->title }}</h2>

                        <!-- Event Image -->
                        @if($event->image_path)
                            <div class="post-featured-image position-relative mb-4 rounded-0 overflow-hidden shadow-sm wow fadeInUp mt-4" data-wow-delay=".2s">
                                <a href="{{ Storage::url($event->image_path) }}" data-lightgallery="item">
                                    <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="img-fluid w-100" loading="lazy" style="object-fit: cover; max-height: 500px;">
                                </a>
                            </div>
                        @endif
                        
                        <!-- Event Meta -->
                        <div class="event-details mb-4 p-4 bg-light shadow-sm border-start border-primary border-3">
                            <div class="d-flex mb-3 gap-4">
                                <div>
                                    <i class="far fa-calendar-alt text-primary me-2"></i>
                                    <strong>{{ __('events.date') }}:</strong> 
                                    {{ $event->start_datetime->format('d/m/Y') }}
                                    @if($event->end_datetime && $event->end_datetime->format('d/m/Y') != $event->start_datetime->format('d/m/Y'))
                                        - {{ $event->end_datetime->format('d/m/Y') }}
                                    @endif
                                </div>
                            </div>
                            
                            @if($event->start_datetime->format('H:i') != '00:00')
                                <div class="d-flex mb-3 gap-4">
                                    <div>
                                        <i class="far fa-clock text-primary me-2"></i>
                                        <strong>{{ __('events.time') }}:</strong> 
                                        {{ $event->start_datetime->format('H:i') }}
                                        @if($event->end_datetime)
                                            - {{ $event->end_datetime->format('H:i') }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <div class="d-flex mb-0 gap-4">
                                <div>
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <strong>{{ __('events.location') }}:</strong> 
                                    {{ $event->location }}
                                    @if($event->address)
                                        <div class="small text-muted mt-1">{{ $event->address }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Event Description -->
                        <div class="mb-5">
                            <h3 class="oh-desktop mb-4"><span class="d-inline-block">{{ __('events.event_description') }}</span></h3>
                            <div class="post-content">
                                {!! $event->description !!}
                            </div>
                        </div>
                        
                        <!-- Event Gallery -->
                        @if(isset($gallery) && $gallery && $gallery->items->count() > 0)
                            <div class="mb-5">
                                <h3 class="oh-desktop mb-4"><span class="d-inline-block">{{ __('events.photo_gallery') }}</span></h3>
                                <div class="row g-3">
                                    @foreach($gallery->items->take(6) as $item)
                                        <div class="col-sm-6 col-lg-4">
                                            <a href="{{ Storage::url($item->image_path) }}" data-lightbox="event-gallery" data-title="{{ $item->title ?? '' }}" class="img-hover-zoom d-block overflow-hidden shadow-sm rounded-1">
                                                <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title ?? $event->title }}" class="img-fluid w-100" loading="lazy" style="height: 180px; object-fit: cover;">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @if($gallery->items->count() > 6)
                                    <div class="text-center mt-4">
                                        <a href="{{ route('galleria.album', $gallery->slug) }}" class="btn btn-outline-primary">
                                            {{ __('events.view_all_photos') }} <i class="fas fa-images ms-2"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        <!-- Event Map -->
                        @if($event->latitude && $event->longitude)
                            <div class="mb-5">
                                <h3 class="oh-desktop mb-4"><span class="d-inline-block">{{ __('events.map') }}</span></h3>
                                <div id="event-map" class="shadow-sm rounded-1" style="height: 400px; width: 100%;"></div>
                            </div>
                        @endif
                        
                        <!-- Social Share -->
                        <div class="mb-5 p-4 bg-light rounded-1 shadow-sm">
                            <h5 class="mb-3"><i class="fas fa-share-alt text-primary me-2"></i>{{ __('events.share_event') }}</h5>
                            <div class="social-icons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('eventi.show', $event->slug)) }}" class="social-icon icon icon-sm icon-circle icon-circle-md icon-bg-white fa-facebook" target="_blank" aria-label="Condividi su Facebook"></a>
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(route('eventi.show', $event->slug)) }}" class="social-icon icon icon-sm icon-circle icon-circle-md icon-bg-white fa-twitter" target="_blank" aria-label="Condividi su Twitter"></a>
                                <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . route('eventi.show', $event->slug)) }}" class="social-icon icon icon-sm icon-circle icon-circle-md icon-bg-white fa-whatsapp" target="_blank" aria-label="Condividi su WhatsApp"></a>
                                <a href="mailto:?subject={{ urlencode($event->title) }}&body={{ urlencode($event->short_description . ' - ' . route('eventi.show', $event->slug)) }}" class="social-icon icon icon-sm icon-circle icon-circle-md icon-bg-white fa-envelope" aria-label="Condividi via Email"></a>
                            </div>
                        </div>
                        
                        <!-- Related Events -->
                        @if($relatedEvents->count() > 0)
                            <div class="mb-5">
                                <h3 class="oh-desktop mb-4"><span class="d-inline-block">{{ __('events.related_events') }}</span></h3>
                                <div class="row row-30">
                                    @foreach($relatedEvents as $relatedEvent)
                                        <div class="col-sm-6 col-lg-6 mb-4 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                                            <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-0 card-hover">
                                                <div class="position-relative img-hover-zoom">
                                                    <a href="{{ route('eventi.show', $relatedEvent->slug) }}">
                                                        @if($relatedEvent->image_path)
                                                            <img src="{{ Storage::url($relatedEvent->image_path) }}" alt="{{ $relatedEvent->title }}" width="570" height="370" loading="lazy" class="img-fluid" style="height: 240px; width: 100%; object-fit: cover;">
                                                        @else
                                                            <img src="{{ asset('images/event-default.jpg') }}" alt="{{ $relatedEvent->title }}" width="570" height="370" loading="lazy" class="img-fluid" style="height: 240px; width: 100%; object-fit: cover;">
                                                        @endif
                                                    </a>
                                                    <div class="position-absolute top-0 left-0 bg-primary text-white p-3 rounded-bottom bg-black-opacity-70" style="border-radius: 0 0 10px 0;">
                                                        <div class="text-center">
                                                            <div class="h4 mb-0 font-weight-bold">{{ $relatedEvent->start_datetime->format('d') }}</div>
                                                            <div class="small text-uppercase">{{ $relatedEvent->start_datetime->translatedFormat('M') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-4">
                                                    <h5 class="card-title mb-3">
                                                        <a href="{{ route('eventi.show', $relatedEvent->slug) }}" class="text-dark text-decoration-none">{{ $relatedEvent->title }}</a>
                                                    </h5>
                                                    <div class="d-flex mb-3 gap-4">
                                                        <div>
                                                            <i class="far fa-clock me-1"></i>
                                                            <span class="text-muted">{{ $relatedEvent->start_datetime->format('H:i') }}</span>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-map-marker-alt me-1"></i>
                                                            <span class="text-muted">{{ $relatedEvent->location }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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

<script>
    // Initialize lightbox
    document.addEventListener('DOMContentLoaded', function() {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Immagine %1 di %2',
            'alwaysShowNavOnTouchDevices': true
        });
    });
</script>

<!-- Include only if not already in your layout -->
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
@endsection
