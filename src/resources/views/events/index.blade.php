@extends('layouts.app')

@section('title', __('events.page_title'))
@section('description', __('events.page_description'))
@section('og_title', __('events.og_title'))
@section('og_description', __('events.og_description'))

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('events.events') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('events.home') }}</a></li>
                    <li class="active">{{ __('events.events') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ \App\Models\StaticPage::headerImageUrl('events_index', 'images/FotoSanIppolito1.webp') }});"></div>
        </div>
    </section>

    <!-- Events List -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-9">
                    <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('events.upcoming_events') }}</span></h3>
                    
                    @if($upcomingEvents->count() > 0)
                        <div class="row row-30">
                            @foreach($upcomingEvents as $event)
                                <div class="col-sm-6 col-lg-6 mb-4 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-0 card-hover">
                                        <div class="position-relative img-hover-zoom">
                                            <a href="{{ route('eventi.show', $event->slug) }}">
                                                @if($event->image_path)
                                                    <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" width="570" height="370" loading="lazy" class="img-fluid" style="height: 280px; width: 100%; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('images/event-default.jpg') }}" alt="{{ $event->title }}" width="570" height="370" loading="lazy" class="img-fluid" style="height: 280px; width: 100%; object-fit: cover;">
                                                @endif
                                            </a>
                                            <div class="position-absolute top-0 left-0 bg-secondary text-white p-3 rounded-bottom bg-black-opacity-70" >
                                                <div class="text-center">
                                                    <div class="mb-0 big font-weight-bold">{{ $event->start_datetime->format('d') }}</div>
                                                    <div class="text-uppercase">{{ $event->start_datetime->translatedFormat('M') }}</div>
                                                    <div class="text-uppercase">{{ $event->start_datetime->translatedFormat('Y') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-4">
                                            <h5 class="card-title mb-3">
                                                <a href="{{ route('eventi.show', $event->slug) }}" class="text-dark text-decoration-none">{{ $event->title }}</a>
                                            </h5>
                                            <div class="d-flex mb-3 gap-4">
                                                @if($event->start_datetime->format('H:i') != '00:00')
                                                <div>
                                                    <i class="fa fa-clock-o me-1"></i>
                                                    <span class="text-muted">{{ $event->start_datetime->format('H:i') }}</span>
                                                </div>
                                                @endif
                                                <div>
                                                    <i class="fa fa-map-marker me-1"></i>
                                                    <span class="text-muted">{{ $event->location }}</span>
                                                </div>
                                            </div>
                                            <p class="card-text mb-4">{{ $event->short_description }}</p>
                                            <div class="text-center text-md-right">
                                                <a class="text-primary text-decoration-none small" href="{{ route('eventi.show', $event->slug) }}">
                                                    {{ __('events.details') }} <i class="fa fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info shadow-sm p-4">
                            <i class="fa fa-calendar-times me-2 fa-lg"></i>
                            {{ __('events.no_upcoming_events') }}
                        </div>
                    @endif
                    
                    <h3 class="oh-desktop mt-5"><span class="d-inline-block wow slideInUp">{{ __('events.past_events') }}</span></h3>
                    
                    @if($pastEvents->count() > 0)
                        <div class="row row-30">
                            @foreach($pastEvents as $event)
                                <div class="col-sm-6 col-lg-6 mb-4 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-0 card-hover" style="opacity: 0.85;">
                                        <div class="position-relative img-hover-zoom">
                                            <a href="{{ route('eventi.show', $event->slug) }}">
                                                @if($event->image_path)
                                                    <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" width="570" height="370" loading="lazy" class="img-fluid object-fit-cover" style="height: 280px; width: 100%;">
                                                @else
                                                    <img src="{{ asset('images/event-default.jpg') }}" alt="{{ $event->title }}" width="570" height="370" loading="lazy" class="img-fluid object-fit-cover" style="height: 280px; width: 100%;">
                                                @endif
                                            </a>
                                            <div class="position-absolute top-0 left-0 bg-secondary text-white p-3 rounded-bottom bg-black-opacity-70" >
                                                <div class="text-center">
                                                    <div class="mb-0 big font-weight-bold">{{ $event->start_datetime->format('d') }}</div>
                                                    <div class="text-uppercase">{{ $event->start_datetime->translatedFormat('M') }}</div>
                                                    <div class="text-uppercase">{{ $event->start_datetime->translatedFormat('Y') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-4">
                                            <h5 class="card-title mb-3">
                                                <a href="{{ route('eventi.show', $event->slug) }}" class="text-dark text-decoration-none">{{ $event->title }}</a>
                                            </h5>
                                            <div class="d-flex mb-3 gap-4">
                                                @if($event->start_datetime->format('H:i') != '00:00')
                                                <div>
                                                    <i class="fa fa-clock-o me-1"></i>
                                                    <span class="text-muted">{{ $event->start_datetime->format('H:i') }}</span>
                                                </div>
                                                @endif
                                                <div>
                                                    <i class="fa fa-map-marker me-1"></i>
                                                    <span class="text-muted">{{ $event->location }}</span>
                                                </div>
                                            </div>
                                            <p class="card-text mb-4">{{ $event->short_description }}</p>
                                            <div class="text-center text-md-right">
                                                <a class="text-primary text-decoration-none small" href="{{ route('eventi.show', $event->slug) }}">
                                                    {{ __('events.details') }} <i class="fa fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="pagination-wrap">
                            {{ $pastEvents->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('events.no_past_events') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-lg-3">
                    @include('partials.aside', ['hideAsideEvents' => true])
                </div>
            </div>
        </div>
    </section>
@endsection
