@extends('layouts.app')

@section('title', 'Eventi - Banda Folk di Castello Tesino')
@section('description', 'Calendario degli eventi e concerti della Banda Folk di Castello Tesino. Scopri dove e quando puoi ascoltarci dal vivo.')
@section('og_title', 'Eventi - Banda Folk di Castello Tesino')
@section('og_description', 'Calendario degli eventi e concerti della Banda Folk di Castello Tesino. Scopri dove e quando puoi ascoltarci dal vivo.')

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Eventi') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Eventi') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoSanIppolito1.jpg') }});"></div>
        </div>
    </section>

    <!-- Events List -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-8">
                    <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Prossimi Eventi') }}</span></h3>
                    
                    @if($upcomingEvents->count() > 0)
                        <div class="row row-30">
                            @foreach($upcomingEvents as $event)
                                <div class="col-sm-6 col-lg-6">
                                    <article class="box-event">
                                        <div class="box-event-img-wrap">
                                            @if($event->image_path)
                                                <a href="{{ route('eventi.show', $event->slug) }}">
                                                    <img src="{{ asset($event->image_path) }}" alt="{{ $event->title }}" width="570" height="370" loading="lazy">
                                                </a>
                                            @else
                                                <a href="{{ route('eventi.show', $event->slug) }}">
                                                    <img src="{{ asset('images/event-default.jpg') }}" alt="{{ $event->title }}" width="570" height="370" loading="lazy">
                                                </a>
                                            @endif
                                            <div class="box-event-date">
                                                <div class="box-event-month">{{ $event->start_datetime->format('M') }}</div>
                                                <div class="box-event-day">{{ $event->start_datetime->format('d') }}</div>
                                            </div>
                                        </div>
                                        <div class="box-event-content">
                                            <h5 class="box-event-title"><a href="{{ route('eventi.show', $event->slug) }}">{{ $event->title }}</a></h5>
                                            <div class="box-event-info">
                                                <div class="box-event-time">
                                                    <span class="icon mdi mdi-clock"></span>
                                                    <span class="box-event-text">{{ $event->start_datetime->format('H:i') }}</span>
                                                </div>
                                                <div class="box-event-place">
                                                    <span class="icon mdi mdi-map-marker"></span>
                                                    <span class="box-event-text">{{ $event->location }}</span>
                                                </div>
                                            </div>
                                            <p class="box-event-description">{{ $event->short_description }}</p>
                                            <a class="button button-sm button-default-outline-2 button-wapasha" href="{{ route('eventi.show', $event->slug) }}">{{ __('Dettagli') }}</a>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('Non ci sono eventi in programma al momento. Torna a visitarci presto per aggiornamenti!') }}
                        </div>
                    @endif
                    
                    <h3 class="oh-desktop mt-5"><span class="d-inline-block wow slideInUp">{{ __('Eventi Passati') }}</span></h3>
                    
                    @if($pastEvents->count() > 0)
                        <div class="row row-30">
                            @foreach($pastEvents as $event)
                                <div class="col-sm-6 col-lg-6">
                                    <article class="box-event box-event-past">
                                        <div class="box-event-img-wrap">
                                            @if($event->image_path)
                                                <a href="{{ route('eventi.show', $event->slug) }}">
                                                    <img src="{{ asset($event->image_path) }}" alt="{{ $event->title }}" width="570" height="370" loading="lazy">
                                                </a>
                                            @else
                                                <a href="{{ route('eventi.show', $event->slug) }}">
                                                    <img src="{{ asset('images/event-default.jpg') }}" alt="{{ $event->title }}" width="570" height="370" loading="lazy">
                                                </a>
                                            @endif
                                            <div class="box-event-date">
                                                <div class="box-event-month">{{ $event->start_datetime->format('M') }}</div>
                                                <div class="box-event-day">{{ $event->start_datetime->format('d') }}</div>
                                            </div>
                                        </div>
                                        <div class="box-event-content">
                                            <h5 class="box-event-title"><a href="{{ route('eventi.show', $event->slug) }}">{{ $event->title }}</a></h5>
                                            <div class="box-event-info">
                                                <div class="box-event-time">
                                                    <span class="icon mdi mdi-clock"></span>
                                                    <span class="box-event-text">{{ $event->start_datetime->format('H:i') }}</span>
                                                </div>
                                                <div class="box-event-place">
                                                    <span class="icon mdi mdi-map-marker"></span>
                                                    <span class="box-event-text">{{ $event->location }}</span>
                                                </div>
                                            </div>
                                            <p class="box-event-description">{{ $event->short_description }}</p>
                                            @if($event->galleryAlbum)
                                                <a class="button button-sm button-default-outline-2 button-wapasha" href="{{ route('galleria.show', $event->galleryAlbum->slug) }}">{{ __('Guarda le Foto') }}</a>
                                            @else
                                                <a class="button button-sm button-default-outline-2 button-wapasha" href="{{ route('eventi.show', $event->slug) }}">{{ __('Dettagli') }}</a>
                                            @endif
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="pagination-wrap">
                            {{ $pastEvents->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('Non ci sono eventi passati da mostrare.') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-lg-4">
                    <div class="aside-events">
                        <div class="row row-50">
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
                                    <h5 class="aside-events-title">{{ __('Archivio Eventi') }}</h5>
                                    <ul class="list-marked list-marked-secondary">
                                        @foreach(range(date('Y'), date('Y') - 4) as $year)
                                            <li><a href="#">{{ $year }}</a></li>
                                        @endforeach
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
