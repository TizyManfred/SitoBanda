@extends('layouts.app')

@php
    $hasActiveFilters = collect($filters ?? [])->filter(function ($value) {
        if (is_bool($value)) {
            return $value === true;
        }

        return filled($value);
    })->isNotEmpty();
@endphp

@section('title', __('events.page_title'))
@section('description', __('events.page_description'))
@section('og_title', __('events.og_title'))
@section('og_description', __('events.og_description'))
@if($hasActiveFilters)
    @section('canonical', route('eventi'))
    @section('robots', 'noindex, follow')
@endif

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
                        <div class="event-list event-list-upcoming">
                            @foreach($upcomingEvents as $event)
                                @include('partials.event-card', [
                                    'event' => $event,
                                    'variant' => 'upcoming',
                                    'animated' => true,
                                    'animationDelay' => '0.' . $loop->iteration . 's',
                                ])
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
                        <div class="event-list event-list-past">
                            @foreach($pastEvents as $event)
                                @include('partials.event-card', [
                                    'event' => $event,
                                    'variant' => 'past',
                                    'animated' => true,
                                    'animationDelay' => '0.' . $loop->iteration . 's',
                                ])
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
