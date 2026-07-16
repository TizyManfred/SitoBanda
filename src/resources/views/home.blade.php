@extends('layouts.app')

@php
    $homeCarouselSlides = \App\Models\StaticPage::homeCarouselSlides();
    $homeFirstSlideImage = $homeCarouselSlides[0]['image_url'] ?? \App\Models\StaticPage::headerImageUrl('home', 'images/FotoSanIppolito1.webp', 0);
@endphp

@section('title', __('home.meta.title'))
@section('description', __('home.meta.description'))
@section('og_title', __('home.meta.og_title'))
@section('og_description', __('home.meta.og_description'))
@section('og_image', $homeFirstSlideImage)
@section('preloads')
    <link rel="preload" as="image" href="{{ $homeFirstSlideImage }}" fetchpriority="high">
@endsection

@section('content')
    <!-- Hero Slider -->
    <section class="section swiper-container swiper-slider swiper-slider-classic home-hero-carousel" data-loop="true" data-autoplay="5000"
      data-simulate-touch="true" data-direction="vertical" data-nav="false" aria-label="{{ __('home.hero.aria.slideshow') }}">
      <div class="swiper-wrapper text-center">
        @foreach ($homeCarouselSlides as $slide)
          <div class="swiper-slide context-dark" data-slide-bg="{{ $slide['image_url'] }}" aria-label="{{ __('home.hero.aria.slide', ['number' => $loop->iteration]) }}">
            <div class="swiper-slide-caption section-md">
              <div class="container">
                <div class="row">
                  <div class="col-md-10 col-lg-8 offset-md-1 offset-lg-2" data-caption-animate="fadeInUp" data-caption-delay="100">
                    @if(filled($slide['title'] ?? null))
                      @if($loop->first)
                        <h1 class="home-hero-title">{{ $slide['title'] }}</h1>
                      @else
                        <h2 class="home-hero-title">{{ $slide['title'] }}</h2>
                      @endif
                    @endif
                    {!! $slide['description'] ?? '' !!}
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
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
              <img src="{{ asset('images/FotoBiagio1.webp') }}" alt="{{ __('home.about.image_alt') }}" width="2048" height="1536" loading="lazy" class="img-fluid" />
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
        
        <div class="event-list event-list-home text-left">
          @if (collect($upcomingEvents)->isNotEmpty())
            @foreach ($upcomingEvents as $event)
              @include('partials.event-card', [
                'event' => $event,
                'variant' => 'upcoming',
                'detailsText' => __('home.events.details'),
                'animated' => true,
                'animationDelay' => '0.' . $loop->iteration . 's',
              ])
            @endforeach
          @else
            <div class="text-center">
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
        'image' => $homeFirstSlideImage,
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
                'description' => $event['short_description'] ?? __('home.structured.event_default_description')
            ];

            if (!empty($event['image_path'])) {
                $events[array_key_last($events)]['image'] = \Illuminate\Support\Facades\Storage::url($event['image_path']);
            }
        }
        $structuredData['event'] = $events;
    }
@endphp

@json($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
@endsection
