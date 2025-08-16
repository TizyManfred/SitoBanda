@extends('layouts.app')

@section('title', __('home.meta.title'))
@section('description', __('home.meta.description'))
@section('og_title', __('home.meta.og_title'))
@section('og_description', __('home.meta.og_description'))
@section('og_image', asset('images/FotoSanIppolito1.webp'))

@section('content')
    <!-- Hero Slider -->
    <section class="section swiper-container swiper-slider swiper-slider-classic" data-loop="true" data-autoplay="5000"
      data-simulate-touch="true" data-direction="vertical" data-nav="false" aria-label="{{ __('home.hero.aria.slideshow') }}">
      <div class="swiper-wrapper text-center">
        <div class="swiper-slide context-dark" data-slide-bg="{{ asset('images/FotoSanIppolito1.webp') }}" aria-label="{{ __('home.hero.aria.slide1') }}">
          <div class="swiper-slide-caption section-md">
            <div class="container">
              <div class="row">
                <div class="col-md-10 col-lg-8 offset-md-1 offset-lg-2">
                  <h1>
                    <span class="d-block" data-caption-animate="fadeInUp" data-caption-delay="100">
                      {{ __('home.hero.title') }} 
                    </span>
                    <span class="d-block text-light" data-caption-animate="fadeInUp"
                      data-caption-delay="200">
                      {{ __('home.hero.subtitle') }} 
                    </span>
                  </h1>
                  <p class="lead" data-caption-animate="fadeInUp" data-caption-delay="350">{!! __('home.hero.description') !!}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="swiper-slide context-dark" data-slide-bg="{{ asset('images/FotoShanghai1.webp') }}" aria-label="{{ __('home.hero.aria.slide2') }}">
          <div class="swiper-slide-caption section-md">
            <div class="container">
              <h2 data-caption-animate="fadeInLeft" data-caption-delay="0">{!! __('home.hero.slide2.title') !!}</h2>
              <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100">{{ __('home.hero.slide2.text') }}</p>
              <a class="button button-primary button-ujarak" href="{{ route('italia-gira-banda') }}" title="{{ __('home.hero.slide2.cta') }}"
                data-caption-animate="fadeInUp" data-caption-delay="200">{{ __('home.hero.slide2.cta') }}</a>
            </div>
          </div>
        </div>

        <div class="swiper-slide context-dark" data-slide-bg="{{ asset('images/FotoRoma1.webp') }}" aria-label="{{ __('home.hero.aria.slide3') }}">
          <div class="swiper-slide-caption section-md">
            <div class="container">
              <h2 data-caption-animate="fadeInLeft" data-caption-delay="0">{!! __('home.hero.slide3.title') !!}</h2>
              <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100">{{ __('home.hero.slide3.text') }}</p>
              <a class="button button-primary button-ujarak" href="{{ route('chi-siamo') }}" title="{{ __('home.hero.slide3.cta') }}" data-caption-animate="fadeInUp"
                data-caption-delay="200">{{ __('home.hero.slide3.cta') }}</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Swiper Pagination-->
      <div class="swiper-pagination__module">
        <div class="swiper-pagination__fraction"><span class="swiper-pagination__fraction-index">00</span><span
            class="swiper-pagination__fraction-divider">/</span><span
            class="swiper-pagination__fraction-count">00</span></div>
        <div class="swiper-pagination__divider"></div>
        <div class="swiper-pagination"></div>
      </div>
    </section>

    <!-- Chi Siamo Section -->
    <section class="section section-sm section-first bg-default">
      <div class="container">
        <div class="row row-30 justify-content-center">
          <div class="col-md-7 col-lg-5 col-xl-6 text-lg-left wow fadeInUp">
            <div class="figure-classic figure-classic-left">
              <img src="{{ asset('images/FotoBiagio1.webp') }}" alt="{{ __('home.about.image_alt') }}" width="100%" height="auto" loading="lazy" />
            </div>
          </div>

          <div class="col-lg-7 col-xl-6 d-flex align-items-center">
            <div class="row row-30">

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".1s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon"><i class="fa fa-history"></i></div>
                  <h5 class="box-icon-modern-title"><a href="{{ route('storia') }}" title="{{ __('home.about.history') }}">{{ __('home.about.history') }}</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">{{ __('home.about.history_text') }}</p>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".1s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon"><i class="fa fa-star"></i></div>
                  <h5 class="box-icon-modern-title"><a href="{{ route('abito-tradizionale') }}" title="{{ __('home.about.abito_tradizionale') }}">{{ __('home.about.abito_tradizionale') }}</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">{{ __('home.about.abito_tradizionale_text') }}</p>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".2s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon"><i class="fa fa-users"></i></div>
                  <h5 class="box-icon-modern-title"><a href="{{ route('organico') }}" title="{{ __('home.about.members') }}">{{ __('home.about.members') }}</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">{{ __('home.about.members_text') }}</p>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".3s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon"><i class="fa fa-music"></i></div>
                  <h5 class="box-icon-modern-title"><a href="{{ route('maestro') }}" title="{{ __('home.about.conductor') }}">{{ __('home.about.conductor') }}</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">{{ __('home.about.conductor_text') }}</p>
                </article>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- La Nostra Storia -->
    <section class="section section-sm bg-default" id="storia">
      <div class="container">
        <div class="row row-xl-24 justify-content-center align-items-center align-items-lg-start text-left">
          <div class="col-md-6 text-center text-md-right">
            <a class="text-img" href="{{ route('storia') }}" title="{{ __('home.about.history') }}">
              <span class="counter">{{ abs(\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::parse('1901-01-01'))) }}</span>
            </a>
          </div>
          <div class="col-md-6 wow fadeInRight" data-wow-delay=".1s" style="padding-left: 10px;">
            <div class="offset-top-lg-24 wow fadeInUp">
              <h3 class="title-decoration-lines-left">{{ __('home.history.years') }}</h3>
              <p class="text-gray-500">{{ __('home.history.text') }}</p>
            </div>
            <div class="offset-top-lg-24 wow fadeInUp text-center text-md-left mt-3">
              <a class="button button-secondary button-pipaluk" href="{{ route('storia') }}" title="{{ __('home.history.cta') }}">{{ __('home.history.cta') }}</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="section section-sm bg-default" id="prossimi-eventi">
      <div class="container">
        <div class="row row-50 justify-content-center align-items-center">
          <div class="col-md-10 col-lg-8 col-xl-7 text-center">
            <h3>{{ __('home.events.title') }}</h3>
            <p class="text-gray-500">{{ __('home.events.subtitle') }}</p>
          </div>
        </div>
        
        <div class="row row-30 justify-content-center text-left">
          @if (!empty($upcomingEvents))
            @foreach ($upcomingEvents as $event)
              @php
                  $start = !empty($event['start_datetime']) ? \Carbon\Carbon::parse($event['start_datetime']) : null;
              @endphp
              <div class="col-sm-6 col-lg-4 mb-4 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-0 card-hover">
                  <div class="position-relative img-hover-zoom">
                    <a href="{{ route('eventi.show', $event['slug']) }}" title="{{ $event['title'] }}">
                      @if (!empty($event['image_path']))
                        @php
                            $src = \Illuminate\Support\Str::startsWith($event['image_path'], ['http://', 'https://', '/', 'data:'])
                                ? $event['image_path']
                                : \Illuminate\Support\Facades\Storage::url($event['image_path']);
                        @endphp
                        <img src="{{ $src }}" alt="{{ $event['title'] }}" width="570" height="370" loading="lazy" class="img-fluid" style="height: 280px; width: 100%; object-fit: cover;">
                      @else
                        <img src="{{ asset('images/event-default.jpg') }}" alt="{{ $event['title'] }}" width="570" height="370" loading="lazy" class="img-fluid" style="height: 280px; width: 100%; object-fit: cover;">
                      @endif
                    </a>
                    @if($start)
                      <div class="position-absolute top-0 left-0 bg-secondary text-white p-3 rounded-bottom bg-black-opacity-70">
                        <div class="text-left">
                          <div class="mb-0 big font-weight-bold">{{ $start->format('d') }}</div>
                          <div class="text-uppercase">{{ $start->translatedFormat('M') }}</div>
                          <div class="text-uppercase">{{ $start->translatedFormat('Y') }}</div>
                        </div>
                      </div>
                    @endif
                  </div>
                  <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                      <a href="{{ route('eventi.show', $event['slug']) }}" class="text-dark text-decoration-none" title="{{ $event['title'] }}">{{ $event['title'] }}</a>
                    </h5>
                    <div class="d-flex mb-3 gap-4">
                      @if($start && $start->format('H:i') !== '00:00')
                        <div>
                          <i class="fa fa-clock-o me-1"></i>
                          <span class="text-muted">{{ $start->format('H:i') }}</span>
                        </div>
                      @endif
                      @if (!empty($event['location']))
                        <div>
                          <i class="fa fa-map-marker me-1"></i>
                          <span class="text-muted">{{ $event['location'] }}</span>
                        </div>
                      @endif
                    </div>
                    @if (!empty($event['short_description']))
                      <p class="card-text mb-4">{{ $event['short_description'] }}</p>
                    @endif
                    <div class="text-center text-md-right">
                      <a class="text-primary text-decoration-none small" href="{{ route('eventi.show', $event['slug']) }}" title="{{ __('home.events.details') }}: {{ $event['title'] }}">
                        {{ __('home.events.details') }} <i class="fa fa-arrow-right ms-1"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="col-12 text-center">
              <p>{{ __('home.events.no_events') }}</p>
            </div>
          @endif
        </div>
        
        <div class="row mt-4">
          <div class="col-12 text-center">
            <a href="{{ route('eventi') }}" class="button button-primary button-ujarak" title="{{ __('home.events.all_events') }}">{{ __('home.events.all_events') }}</a>
          </div>
        </div>
      </div>
    </section>

@endsection

@section('structured_data')
@php
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'MusicGroup',
        'name' => 'Banda Folk di Castello Tesino',
        'description' => __('home.structured.description'),
        'image' => asset('images/FotoSanIppolito1.webp'),
        'url' => url('/'),
        'genre' => ['Folk', 'Traditional', 'Marching Band'],
        'foundingDate' => '1901',
        'location' => [
            '@type' => 'Place',
            'name' => 'Castello Tesino',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Castello Tesino',
                'addressRegion' => 'TN',
                'addressCountry' => 'IT'
            ]
        ]
    ];

    if (!empty($upcomingEvents)) {
        $events = [];
        foreach ($upcomingEvents as $event) {
            $events[] = [
                '@type' => 'Event',
                'name' => $event['title'],
                'startDate' => $event['start_datetime'],
                'location' => [
                    '@type' => 'Place',
                    'name' => $event['location'] ?? 'Castello Tesino',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressLocality' => $event['location'] ?? 'Castello Tesino',
                        'addressRegion' => 'TN',
                        'addressCountry' => 'IT'
                    ]
                ],
                'image' => $event['image_path'] ?? asset('images/event-placeholder.jpg'),
                'description' => $event['short_description'] ?? __('home.structured.event_default_description')
            ];
        }
        $structuredData['event'] = $events;
    }
@endphp
{!! json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
@endsection
