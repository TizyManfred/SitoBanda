@php
    // Default values that can be overridden when including this partial
    $title = $title ?? __('events.upcoming_events');
    $showViewAll = $showViewAll ?? true;
    $viewAllUrl = $viewAllUrl ?? route('eventi');
    $viewAllText = $viewAllText ?? __('events.all_events');
    
    // Get upcoming events for the sidebar if items are not provided
    $items = $items ?? collect();
    if ($items->isEmpty()) {
        $items = \App\Models\Event::public()
            ->upcoming()
            ->orderBy('start_datetime', 'asc')
            ->limit(3)
            ->get();
    }
    
    // Define the 5xMille donation information
    $cinquePerMille = [
        'title' => __('aside.cinque_per_mille.title') ?? '5 x Mille',
        'text' => __('aside.cinque_per_mille.text') ?? 'Dona il tuo 5 x mille alla Banda Folk di Castello Tesino! A te non costa nulla e per noi è un gesto prezioso. Il nostro codice fiscale è 01517580229 Grazie!',
        'icon' => 'fas fa-hand-holding-heart'
    ];
@endphp

@unless(!empty($hideAsideEvents) && $hideAsideEvents)
    {{-- Events Section --}}
    @if($title || $items->count() > 0)
        <div class="box-contacts mb-4 wow fadeInUp" data-wow-delay=".1s">
            <div class="">
                @if($title)
                    <div class="box-contacts-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h5 class="box-contacts-link mb-3">
                        {{ $title }}
                    </h5>
                @endif
                
                @if($items->count() > 0)
                    <div class="mb-3">
                        @foreach($items as $item)
                            <a href="{{ route('eventi.show', $item->slug) }}">
                                <div class="mb-3 pb-3" style="border-bottom: 1px solid #f0f0f0;">
                                    <div class="d-flex">
                                        <div class="d-flex px-4 w-100 gap-3">
                                            {{-- Event Image (Small) --}}
                                            @if(isset($item->image_path) && $item->image_path)
                                                <div class="ms-2 position-relative">
                                                    <img 
                                                        src="{{ Storage::url($item->image_path) }}" 
                                                        alt="{{ $item->title }}" 
                                                        style="width: 100px; height: 100px; min-width: 100px; min-height: 100px; object-fit: cover;"
                                                    >

                                                    {{-- Event Date --}}
                                                    <div class="text-center me-3 position-absolute top-0 start-0 z-index-1 bg-black-opacity-70" style="min-width: 48px;">
                                                        <div class="bg-primary text-white rounded px-2 py-1">
                                                            <div style="font-size: 18px; font-weight: bold; line-height: 1;">{{ $item->start_datetime->translatedFormat('d') }}</div>
                                                            <div style="font-size: 12px; text-transform: uppercase;">{{ $item->start_datetime->translatedFormat('M') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Event Content --}}
                                            <div class="flex-grow-1">
                                                <h6 class="text-left" style="font-weight: 600;">{{ $item->title }}</h6>
                                                @if(isset($item->start_datetime))
                                                    <p class="text-left small text-muted">
                                                        <i class="fa fa-calendar me-1"></i>
                                                        {{ $item->start_datetime->translatedFormat('d M Y') }}
                                                        @if($item->start_datetime->format('H:i') != '00:00')
                                                            - {{ $item->start_datetime->format('H:i') }}
                                                        @endif
                                                    </p>
                                                @endif
                                                @if(isset($item->location))
                                                    <p class="text-left small text-muted">
                                                        <i class="fa fa-map-marker me-1"></i>
                                                        {{ $item->location }}
                                                    </p>
                                                @endif
                                                @if(isset($item->short_description))
                                                    <p class="text-left small text-muted">
                                                        {{ Str::limit($item->short_description, 80, '...') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    @if($showViewAll)
                        <div class="text-center mb-3">
                            <a href="{{ $viewAllUrl }}" class="button button-primary button-ujarak" style="min-width: auto; padding: 10px 20px; font-size: 14px;">
                                <i class="fas fa-calendar-week me-1"></i>{{ $viewAllText }}
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center text-muted mb-3">
                        <i class="far fa-calendar-alt mb-2" style="font-size: 24px;"></i>
                        <p class="mb-0" style="font-size: 14px;">
                            {{ $emptyText ?? __('eventi.nessun_evento_programmato') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endunless

{{-- Social following links --}}
<div class="box-contacts mb-4 wow fadeInUp py-4" data-wow-delay=".1s" style="min-height: auto;">
    <div class="box-contacts-body">
        <h5 class="box-contacts-link mb-3">
            {{ __('aside.follow_us') }}
        </h5>
        <p class="mb-3">{{ __('aside.follow_us_text') }}</p>
        <div class="mb-3 d-flex align-items-center gap-3 footer-social-list justify-content-center" >
            <a href="{{ \App\Helpers\SettingsHelper::facebookUrl() }}" target="_blank" class="icon fa fa-facebook"></a>
            <a href="{{ \App\Helpers\SettingsHelper::instagramUrl() }}" target="_blank" class="icon fa fa-instagram"></a>
            <a href="{{ \App\Helpers\SettingsHelper::youtubeUrl() }}" target="_blank" class="icon fa fa-youtube"></a>
        </div>
    </div>
</div>

@if (LaravelLocalization::getCurrentLocale() == "it")
{{-- 5 x Mille Donation Section --}}
<div class="box-contacts wow fadeInUp py-4" data-wow-delay=".2s" style="min-height: auto;">
    <div class="box-contacts-body">        
        <h5 class="box-contacts-link mb-3">
            {{ $cinquePerMille['title'] }}
        </h5>
        
        <p class="mb-3" style="font-size: 14px; line-height: 1.5;">
            {{ $cinquePerMille['text'] }}
        </p>
        
        <div class="text-center">
            <div class="bg-light border rounded p-3 mb-3">
                <div class="text-muted mb-1" style="font-size: 12px; text-transform: uppercase;">Codice Fiscale</div>
                <div style="font-family: 'Courier New', monospace; font-size: 18px; font-weight: bold; color: #50ba87;">
                    01517580229
                </div>
            </div>
        </div>
    </div>
</div>
@endif

