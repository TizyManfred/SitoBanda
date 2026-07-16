@php
    $eventCardVariant = $variant ?? 'upcoming';
    $eventCardTitle = data_get($event, 'title', '');
    $eventCardSlug = data_get($event, 'slug');
    $eventCardLocation = data_get($event, 'location');
    $eventCardDescription = data_get($event, 'short_description');
    $eventCardImagePath = data_get($event, 'image_path');
    $eventCardDetailsText = $detailsText ?? __('events.details');
    $eventCardEyebrow = $eyebrow ?? null;
    $eventCardAnimated = $animated ?? false;
    $eventCardDelay = $animationDelay ?? null;
    $eventCardUrl = route('eventi.show', $eventCardSlug);
    $eventCardStartValue = data_get($event, 'start_datetime');
    $eventCardStart = null;

    if ($eventCardStartValue instanceof \Carbon\CarbonInterface) {
        $eventCardStart = $eventCardStartValue;
    } elseif (filled($eventCardStartValue)) {
        try {
            $eventCardStart = \Carbon\Carbon::parse($eventCardStartValue);
        } catch (\Throwable) {
            $eventCardStart = null;
        }
    }

    $eventCardImageUrl = null;
    if (filled($eventCardImagePath)) {
        $eventCardImageUrl = \Illuminate\Support\Str::startsWith($eventCardImagePath, ['http://', 'https://', '/', 'data:'])
            ? $eventCardImagePath
            : \Illuminate\Support\Facades\Storage::url($eventCardImagePath);
    }
@endphp

<article
    class="event-list-card event-list-card-{{ $eventCardVariant }}{{ $eventCardImageUrl ? '' : ' event-list-card-no-image' }} card border-0 shadow-sm overflow-hidden rounded-0 card-hover{{ $eventCardAnimated ? ' wow fadeInUp' : '' }}"
    @if($eventCardDelay !== null) data-wow-delay="{{ $eventCardDelay }}" @endif
>
    <a class="event-list-card-link" href="{{ $eventCardUrl }}" aria-label="{{ $eventCardDetailsText }}: {{ $eventCardTitle }}"></a>

    @if($eventCardImageUrl)
        <div class="event-list-card-media img-hover-zoom">
            <img src="{{ $eventCardImageUrl }}" alt="{{ $eventCardTitle }}" width="570" height="370" loading="lazy">
        </div>
    @endif

    <div class="card-body event-list-card-body">
        @if($eventCardEyebrow)
            <span class="event-list-card-context"><i class="fa fa-calendar" aria-hidden="true"></i>{{ $eventCardEyebrow }}</span>
        @endif

        @if($eventCardStart)
            <div class="event-list-card-date">
                <span class="event-list-card-date-day">{{ $eventCardStart->format('d') }}</span>
                <span>{{ $eventCardStart->translatedFormat('M') }}</span>
                <span>{{ $eventCardStart->translatedFormat('Y') }}</span>
            </div>
        @endif

        <h5 class="card-title event-card-title event-list-card-title">{{ $eventCardTitle }}</h5>

        @if(($eventCardStart && $eventCardStart->format('H:i') !== '00:00') || filled($eventCardLocation))
            <div class="event-card-meta event-list-card-meta">
                @if($eventCardStart && $eventCardStart->format('H:i') !== '00:00')
                    <div class="event-list-card-meta-item">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <span class="text-muted">{{ $eventCardStart->format('H:i') }}</span>
                    </div>
                @endif
                @if(filled($eventCardLocation))
                    <div class="event-list-card-meta-item">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <span class="text-muted event-list-card-location" title="{{ $eventCardLocation }}">{{ $eventCardLocation }}</span>
                    </div>
                @endif
            </div>
        @endif

        @if(filled($eventCardDescription))
            <p class="card-text event-card-description event-list-card-description">{{ $eventCardDescription }}</p>
        @endif

        <div class="event-list-card-footer">
            <a class="text-primary text-decoration-none small event-list-card-details" href="{{ $eventCardUrl }}">
                {{ $eventCardDetailsText }} <i class="fa fa-arrow-right ms-1" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</article>
