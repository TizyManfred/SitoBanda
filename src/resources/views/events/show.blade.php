@extends('layouts.app')

@php
    $metaDescription = \Illuminate\Support\Str::limit(
        trim($event->short_description ?: strip_tags($event->description ?: '')),
        160
    );

    if ($metaDescription === '') {
        $metaDescription = \Illuminate\Support\Str::limit(
            collect([
                $event->title,
                $event->location,
                optional($event->start_datetime)->translatedFormat('d F Y'),
            ])->filter()->implode(' - '),
            160
        );
    }

    $eventImage = $event->image_path ? \Illuminate\Support\Facades\Storage::url($event->image_path) : null;
    $eventDate = $event->start_datetime;
    $currentSlug = $event->getTranslation('slug', app()->getLocale(), false) ?: $event->slug;
    $canonicalUrl = route('eventi.show', $currentSlug);
    $alternateUrls = [];
    $defaultLocale = LaravelLocalization::getDefaultLocale();

    foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
        $localizedSlug = $event->getTranslation('slug', $localeCode, false);

        if (filled($localizedSlug)) {
            $alternateUrls[$localeCode] = LaravelLocalization::getLocalizedURL(
                $localeCode,
                route('eventi.show', $localizedSlug),
                [],
                $localeCode !== $defaultLocale
            );
        }
    }

    $shareUrl = $canonicalUrl;
    $shareText = $event->title . ' - ' . $metaDescription;
@endphp

@section('title', $event->title . ' - Banda Folk di Castello Tesino')
@section('description', $metaDescription)
@section('canonical', $canonicalUrl)
@section('og_title', $event->title . ' - Banda Folk di Castello Tesino')
@section('og_description', $metaDescription)
@section('og_type', 'article')
@if($eventImage)
    @section('og_image', $eventImage)
@endif

@section('alternate_urls')
@foreach($alternateUrls as $localeCode => $alternateUrl)
    <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ $alternateUrl }}" />
@endforeach
@if(isset($alternateUrls[$defaultLocale]))
    <link rel="alternate" hreflang="x-default" href="{{ $alternateUrls[$defaultLocale] }}" />
@endif
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
            <div class="box-position" style="background-image: url({{ \App\Models\StaticPage::headerImageUrl('events_index', 'images/FotoSanIppolito1.webp') }});"></div>
        </div>
    </section>


    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-xl-9 pr-xl-5">
                <!-- Event Details -->
                <section class="section section-sm section-first bg-default text-left">
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
                                    <i class="fa fa-calendar text-primary me-2"></i>
                                    <strong>{{ __('events.date') }}:</strong> 
                                    {{ $eventDate ? $eventDate->format('d/m/Y') : __('events.date_not_available') }}
                                    @if($eventDate && $event->end_datetime && $event->end_datetime->format('d/m/Y') != $eventDate->format('d/m/Y'))
                                        - {{ $event->end_datetime->format('d/m/Y') }}
                                    @endif
                                </div>
                            </div>
                            
                            @if($eventDate && $eventDate->format('H:i') != '00:00')
                                <div class="d-flex mb-3 gap-4">
                                    <div>
                                        <i class="fa fa-clock-o text-primary me-2"></i>
                                        <strong>{{ __('events.time') }}:</strong> 
                                        {{ $eventDate->format('H:i') }}
                                        @if($event->end_datetime)
                                            - {{ $event->end_datetime->format('H:i') }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <div class="d-flex mb-0 gap-4">
                                <div>
                                    <i class="fa fa-map-marker text-primary me-2"></i>
                                    <strong>{{ __('events.location') }}:</strong> 
                                    {{ $event->location ?: __('events.location_not_available') }}
                                    @if($event->address)
                                        <div class="small text-muted mt-1">{{ $event->address }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Event Description -->
                        <div class="mb-5">
                            <h3 class="oh-desktop mb-4"><span class="d-inline-block">{{ __('events.event_description') }}</span></h3>
                            @if($event->description)
                                <div class="post-content">
                                    {!! $event->description !!}
                                </div>
                            @else
                                <p class="text-muted">{{ __('events.description_not_available') }}</p>
                            @endif
                        </div>

                        @if($event->attachments->isNotEmpty())
                            <div class="mb-5">
                                <h3 class="oh-desktop mb-4"><span class="d-inline-block">{{ __('events.attachments') }}</span></h3>
                                <div class="row">
                                    @foreach($event->attachments as $attachment)
                                        @php
                                            $extension = strtolower($attachment->extension());
                                            $icon = match ($extension) {
                                                'pdf' => 'fa-file-pdf-o',
                                                'doc', 'docx' => 'fa-file-word-o',
                                                'xls', 'xlsx', 'csv' => 'fa-file-excel-o',
                                                'ppt', 'pptx' => 'fa-file-powerpoint-o',
                                                'jpg', 'jpeg', 'png', 'webp' => 'fa-file-image-o',
                                                default => 'fa-file-o',
                                            };
                                        @endphp
                                        <div class="col-12 mb-3">
                                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between p-4 bg-light shadow-sm border-start border-primary border-3">
                                                <div class="d-flex align-items-start mb-3 mb-md-0 pr-md-4">
                                                    <i class="fa {{ $icon }} fa-2x text-primary mr-3" aria-hidden="true"></i>
                                                    <div>
                                                        <h4 class="heading-5 mb-1">{{ $attachment->displayTitle() }}</h4>
                                                        @if($attachment->description)
                                                            <p class="mb-1 text-muted">{{ $attachment->description }}</p>
                                                        @endif
                                                        <small class="text-muted">
                                                            {{ $attachment->extension() }}
                                                            @if($attachment->humanReadableSize())
                                                                · {{ $attachment->humanReadableSize() }}
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                                <a
                                                    href="{{ $attachment->url() }}"
                                                    class="button button-primary button-pipaluk"
                                                    download
                                                >
                                                    <i class="fa fa-download mr-2" aria-hidden="true"></i>{{ __('events.download_attachment') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <!-- Event Gallery -->
                        @if(isset($gallery) && $gallery && $gallery->items->count() > 0)
                            <div class="mb-5">
                                <h3 class="oh-desktop mb-4"><span class="d-inline-block">{{ __('events.photo_gallery') }}</span></h3>
                                @php $__limit = min($gallery->items->count(), 4); @endphp
                                <div class="row">
                                    @foreach($gallery->items->take($__limit) as $item)
                                        <div class="col-6 col-md-3 mb-3">
                                            <div class="overflow-hidden">
                                                <img class="aspect-ratio-16-9 object-fit-cover w-100" src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title ?? $event->title }}" loading="lazy">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-center mt-4">
                                    <a href="{{ route('galleria.album', $gallery->slug) }}" class="button button-secondary button-pipaluk">
                                        {{ __('events.view_all_photos') }} <i class="fa fa-images ms-2"></i>
                                    </a>
                                </div>
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
                        <div class="event-share-panel mb-5">
                            <div class="event-share-copy">
                                <span class="gallery-panel-eyebrow"><i class="fa fa-share-alt mr-1"></i>{{ __('events.share_event') }}</span>
                                <h4 class="heading-4">{{ __('events.share_title') }}</h4>
                            </div>
                            <div class="share-actions">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" class="share-action share-action-facebook" target="_blank" rel="noopener" aria-label="{{ __('events.share_facebook') }}"><i class="fa fa-facebook"></i><span>Facebook</span></a>
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode($shareUrl) }}" class="share-action share-action-twitter" target="_blank" rel="noopener" aria-label="{{ __('events.share_twitter') }}"><i class="fa fa-twitter"></i><span>Twitter</span></a>
                                <a href="https://wa.me/?text={{ urlencode($shareText . ' - ' . $shareUrl) }}" class="share-action share-action-whatsapp" target="_blank" rel="noopener" aria-label="{{ __('events.share_whatsapp') }}"><i class="fa fa-whatsapp"></i><span>WhatsApp</span></a>
                                <a href="mailto:?subject={{ urlencode($event->title) }}&body={{ urlencode($shareText . ' - ' . $shareUrl) }}" class="share-action share-action-email" aria-label="{{ __('events.share_email') }}"><i class="fa fa-envelope"></i><span>Email</span></a>
                            </div>
                        </div>
                        
                        <!-- Related Events -->
                        @if($relatedEvents->count() > 0)
                            <div class="mb-5">
                                <h3 class="oh-desktop mb-4"><span class="d-inline-block">{{ __('events.related_events') }}</span></h3>
                                <div class="event-list event-list-related">
                                    @foreach($relatedEvents as $relatedEvent)
                                        @include('partials.event-card', [
                                            'event' => $relatedEvent,
                                            'variant' => 'upcoming',
                                            'animated' => true,
                                            'animationDelay' => '0.' . $loop->iteration . 's',
                                        ])
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

@section('structured_data')
@php
    $eventSchema = [
        '@type' => 'Event',
        'name' => $event->title,
        'description' => $metaDescription,
        'url' => url()->current(),
        'startDate' => optional($event->start_datetime)->toIso8601String(),
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        'eventStatus' => 'https://schema.org/EventScheduled',
        'location' => [
            '@type' => 'Place',
            'name' => $event->location,
            'address' => $event->address ?: $event->location,
        ],
        'organizer' => [
            '@type' => 'Organization',
            'name' => 'Banda Folk di Castello Tesino',
            'url' => route('home'),
        ],
    ];

    if ($event->end_datetime) {
        $eventSchema['endDate'] = $event->end_datetime->toIso8601String();
    }

    if ($eventImage) {
        $eventSchema['image'] = [url($eventImage)];
    }

    $structuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => __('events.home'),
                        'item' => route('home'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => __('events.events'),
                        'item' => route('eventi'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 3,
                        'name' => $event->title,
                        'item' => url()->current(),
                    ],
                ],
            ],
            $eventSchema,
        ],
    ];
@endphp

@json($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
@endsection

@section('scripts')
@if($event->latitude && $event->longitude)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        var map = L.map('event-map').setView([{{ $event->latitude }}, {{ $event->longitude }}], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        L.marker([{{ $event->latitude }}, {{ $event->longitude }}])
            .addTo(map)
            .bindPopup(@json($event->location ?: __('events.location_not_available')))
            .openPopup();
    });
</script>
@endif

<script>
    // Simple left-to-right rotating gallery (non-carousel)
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('eventGalleryTrack');
        if (!track) return;

        const slides = track.querySelectorAll('.rotating-slide');
        // If there's 0 or 1 real slide, no rotation needed
        if (slides.length <= 1) return;

        // We appended a cloned first slide for seamless looping; the last index is the clone
        const lastIndex = slides.length - 1;
        let index = 0;
        const durationMs = 600;
        const delay = Math.floor(5000 + Math.random() * 5000); // 5-10s

        const step = () => {
            index += 1;
            track.style.transition = `transform ${durationMs}ms ease-in-out`;
            track.style.transform = `translateX(-${index * 100}%)`;
        };

        track.addEventListener('transitionend', () => {
            if (index === lastIndex) {
                // Jump back to start without animation
                track.style.transition = 'none';
                track.style.transform = 'translateX(0)';
                index = 0;
                // Force reflow then restore transition for next cycles
                void track.offsetWidth;
                track.style.transition = `transform ${durationMs}ms ease-in-out`;
            }
        });

        setInterval(step, delay);
    });
    </script>
@endsection
