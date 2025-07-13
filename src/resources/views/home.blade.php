@extends('layouts.app')

@section('title', __('home.meta.title'))
@section('description', __('home.meta.description'))
@section('og_title', __('home.meta.og_title'))
@section('og_description', __('home.meta.og_description'))
@section('og_image', asset('images/FotoSanIppolito1.jpg'))

@section('content')
    <!-- Hero Slider -->
    <section class="section swiper-container swiper-slider swiper-slider-classic" data-loop="true" data-autoplay="5000"
      data-simulate-touch="true" data-direction="vertical" data-nav="false" aria-label="Slideshow principale">
      <div class="swiper-wrapper text-center">
        <div class="swiper-slide context-dark" data-slide-bg="{{ asset('images/FotoSanIppolito1.jpg') }}" aria-label="Primo slide - Banda a San Ippolito">
          <div class="swiper-slide-caption section-md">
            <div class="container">
              <div class="row">
                <div class="col-md-10 col-lg-8 offset-md-1 offset-lg-2">
                  <h1><span class="d-block" data-caption-animate="fadeInUp" data-caption-delay="100">{{ __('home.hero.title') }}</span><span class="d-block text-light" data-caption-animate="fadeInUp"
                      data-caption-delay="200">{{ __('home.hero.subtitle') }}</span></h1>
                  <p class="lead" data-caption-animate="fadeInUp" data-caption-delay="350">{!! __('home.hero.description') !!}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="swiper-slide context-dark" data-slide-bg="{{ asset('images/FotoShanghai1.jpeg') }}" aria-label="Secondo slide - Banda a Shanghai">
          <div class="swiper-slide-caption section-md">
            <div class="container">
              <h1 data-caption-animate="fadeInLeft" data-caption-delay="0">{!! __('home.hero.slide2.title') !!}</h1>
              <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100">{{ __('home.hero.slide2.text') }}</p>
              <a class="button button-primary button-ujarak" href="{{ route('italia-gira-banda') }}"
                data-caption-animate="fadeInUp" data-caption-delay="200">{{ __('home.hero.slide2.cta') }}</a>
            </div>
          </div>
        </div>

        <div class="swiper-slide context-dark" data-slide-bg="{{ asset('images/FotoRoma1.jpeg') }}" aria-label="Terzo slide - Banda a Roma">
          <div class="swiper-slide-caption section-md">
            <div class="container">
              <h1 data-caption-animate="fadeInLeft" data-caption-delay="0">{!! __('home.hero.slide3.title') !!}</h1>
              <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100">{{ __('home.hero.slide3.text') }}</p>
              <a class="button button-primary button-ujarak" href="{{ route('chi-siamo') }}" data-caption-animate="fadeInUp"
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
              <img src="{{ asset('images/FotoBiagio1.jpg') }}" alt="{{ __('Banda Folk di Castello Tesino in concerto') }}" width="513" height="561" loading="lazy" />
            </div>
          </div>

          <div class="col-lg-7 col-xl-6 d-flex align-items-center">
            <div class="row row-30">

              <div class="col-sm-6 wow fadeInRight">
                <article class="box-icon-modern box-icon-modern-custom">
                  <div>
                    <h3 class="box-icon-modern-big-title">{{ __('home.about.events') }}</h3>
                    <div class="box-icon-modern-decor"></div><a
                      class="button button-md button-default-outline-2 button-wapasha" href="{{ route('eventi') }}">{{ __('home.about.events_cta') }}</a>
                  </div>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".1s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon bi-hourglass-split"></div>
                  <h5 class="box-icon-modern-title"><a href="{{ route('storia') }}">{{ __('home.about.history') }}</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">{{ __('home.about.history_text') }}</p>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".2s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon bi-people-fill"></div>
                  <h5 class="box-icon-modern-title"><a href="{{ route('organico') }}">{{ __('home.about.members') }}</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">{{ __('home.about.members_text') }}</p>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".3s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon bi-magic"></div>
                  <h5 class="box-icon-modern-title"><a href="{{ route('maestro') }}">{{ __('home.about.conductor') }}</a></h5>
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
        <div class="row row-50 row-xl-24 justify-content-center align-items-center align-items-lg-start text-left">
          <div class="col-md-6 col-lg-5 col-xl-4 text-center">
            <a class="text-img" href="{{ route('storia') }}">
              <span class="counter">120</span>
            </a>
          </div>

          <div class="col-sm-8 col-md-6 col-lg-5 col-xl-4"></div>

          <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4 wow fadeInRight" data-wow-delay=".1s" style="padding-left: 150px;">
            <div class="text-width-extra-small offset-top-lg-24 wow fadeInUp">
              <h3 class="title-decoration-lines-left">{{ __('home.history.years') }}</h3>
              <p class="text-gray-500">{{ __('home.history.text') }}</p>
              <a class="button button-secondary button-pipaluk" href="{{ route('storia') }}">{{ __('home.history.cta') }}</a>
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
        
        <div class="row row-30 justify-content-center">
          @if (!empty($upcomingEvents))
            @foreach ($upcomingEvents as $event)
              <div class="col-md-6 col-lg-4">
                <div class="card event-card">
                  @if (!empty($event['image_path']))
                    <img src="{{ $event['image_path'] }}" class="card-img-top" alt="{{ $event['title'] }}">
                  @endif
                  <div class="card-body">
                    <h5 class="card-title">{{ $event['title'] }}</h5>
                    <div class="event-meta">
                      <span><i class="bi bi-calendar-event"></i> {{ __('home.events.date') }}: {{ \Carbon\Carbon::parse($event['start_datetime'])->format('d/m/Y H:i') }}</span>
                      @if (!empty($event['location']))
                        <span><i class="bi bi-geo-alt"></i> {{ __('home.events.location') }}: {{ $event['location'] }}</span>
                      @endif
                    </div>
                    @if (!empty($event['short_description']))
                      <p class="card-text">{{ $event['short_description'] }}</p>
                    @endif
                    <a href="{{ route('eventi.show', $event['slug']) }}" class="btn btn-primary">{{ __('home.events.details') }}</a>
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
            <a href="{{ route('eventi') }}" class="button button-primary button-ujarak">{{ __('home.events.all_events') }}</a>
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
        'description' => 'La Banda Folk di Castello Tesino, attiva dal 1901, porta avanti la tradizione musicale del Trentino con concerti, eventi e corsi di musica.',
        'image' => asset('images/FotoSanIppolito1.jpg'),
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
                'description' => $event['short_description'] ?? 'Evento della Banda Folk di Castello Tesino'
            ];
        }
        $structuredData['event'] = $events;
    }
@endphp
<script type="application/ld+json">
    {!! json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection
