@extends('layouts.app')

@section('title', __('repertorio.title') . ' - Banda Folk di Castello Tesino')
@section('description', __('repertorio.description'))
@section('og_title', __('repertorio.og_title'))
@section('og_description', __('repertorio.og_description'))

@section('styles')
<!-- No custom styles, using only style.css and bootstrap.css -->
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('repertorio.breadcrumb_title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('repertorio.breadcrumb_home') }}</a></li>
                    <li class="active">{{ __('repertorio.breadcrumb_title') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoRepertorio1.jpeg') }});"></div>
        </div>
    </section>

    <!-- Repertorio Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('repertorio.main_title') }}</span></h3>
                    <p class="text-gray-800">{{ __('repertorio.main_intro') }}</p>
                    
                    @if($programs->count() > 0)
                        @php
                            // Get the latest year from the programs collection
                            $latestYear = array_key_first($programs->toArray());
                        @endphp
                        
                        <!-- Latest Year Programs - Always Visible -->
                        <div class="latest-programs mb-5">
                            <h4 class="text-primary mb-4 mt-4">{{ __('repertorio.repertorio_year', ['year' => $latestYear]) }}</h4>
                            
                            @foreach($programs[$latestYear] as $program)
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-primary text-white py-3">
                                        <h4 class="card-title mb-0">{{ $program->name }}</h4>
                                    </div>
                                    
                                    @if($program->pieces->count() > 0)
                                        <div class="card-body">
                                            <ol class="list-group list-group-flush">
                                                @foreach($program->pieces as $piece)
                                                    <li class="list-group-item d-flex flex-column border-0 py-3">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <h5 class="mb-0 text-primary">
                                                                <span class="badge badge-primary mr-2">{{ $loop->iteration }}</span>
                                                                {{ $piece->title }}
                                                            </h5>
                                                        </div>
                                                        @if($piece->composer || $piece->arranger)
                                                            <div class="mt-1">
                                                                @if($piece->composer)
                                                                    <span class="text-muted">{{ $piece->composer }}</span>
                                                                @endif
                                                                @if($piece->arranger)
                                                                    <small class="text-muted ml-2">({{ __('repertorio.table_arranger') }} {{ $piece->arranger }})</small>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    @else
                                        <div class="card-body text-center py-4">
                                            <p class="text-muted mb-0">{{ __('repertorio.no_pieces_message') }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Previous Years Programs - Compressed with Accordion -->
                        @if(count($programs) > 1)
                            <div class="previous-programs mb-5">
                                <h4 class="text-secondary mb-4 mt-4">{{ __('repertorio.previous_repertoire') }}</h4>
                                
                                <div class="accordion" id="previousYearsAccordion">
                                    @foreach($programs as $year => $yearPrograms)
                                        @if($year != $latestYear)
                                            <div class="card mb-3 border-0">
                                                <div class="card-header bg-light p-0" id="heading{{ $year }}">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left p-3 collapsed" type="button" data-toggle="collapse" 
                                                                data-target="#collapse{{ $year }}" aria-expanded="false" aria-controls="collapse{{ $year }}">
                                                            <span class="h5 text-secondary mb-0">{{ __('repertorio.repertorio_year', ['year' => $year]) }}</span>
                                                            <i class="fa fa-angle-down float-right mt-1"></i>
                                                        </button>
                                                    </h5>
                                                </div>
                                                
                                                <div id="collapse{{ $year }}" class="collapse" aria-labelledby="heading{{ $year }}" data-parent="#previousYearsAccordion">
                                                    <div class="card-body">
                                                        @foreach($yearPrograms as $program)
                                                            <div class="card border-0 shadow-sm mb-3 mx-3 mt-3">
                                                                <div class="card-header bg-light py-2">
                                                                    <h5 class="mb-0">{{ $program->name }}</h5>
                                                                </div>
                                                                
                                                                @if($program->pieces->count() > 0)
                                                                    <div class="card-body py-2">
                                                                        <ol class="list-unstyled">
                                                                            @foreach($program->pieces as $piece)
                                                                                <li class="py-1">
                                                                                    <div class="d-flex justify-content-between">
                                                                                        <strong>
                                                                                            <span class="badge badge-secondary mr-1">{{ $loop->iteration }}</span>
                                                                                            {{ $piece->title }}
                                                                                        </strong>
                                                                                        @if($piece->composer || $piece->arranger)
                                                                                            <div class="mt-1">
                                                                                                @if($piece->composer)
                                                                                                    <span class="text-muted">{{ $piece->composer }}</span>
                                                                                                @endif
                                                                                                @if($piece->arranger)
                                                                                                    <small class="text-muted ml-2">({{ __('repertorio.table_arranger') }} {{ $piece->arranger }})</small>
                                                                                                @endif
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ol>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            {{ __('repertorio.no_programs_message') }}
                        </div>
                    @endif
                    
                    <!-- Esempi musicali section removed as requested -->
                </div>
                
                <div class="col-md-10 col-lg-4">
                    <div class="aside-component">
                        <!-- Discografia section removed as requested -->
                        
                        <!-- Prossimi Concerti -->
                        <div class="aside-component-item mb-5">
                            <h4 class="text-primary">{{ __('repertorio.upcoming_concerts_title') }}</h4>
                            @if($upcomingEvents->count() > 0)
                                <ul class="list-schedule">
                                    @foreach($upcomingEvents as $event)
                                        <li class="list-schedule-item">
                                            <div class="list-schedule-left">
                                                <span>{{ \Carbon\Carbon::parse($event->start_datetime)->format('d M') }}</span>
                                            </div>
                                            <div class="list-schedule-right">
                                                <span>{{ $event->title }}, {{ $event->location }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>{{ __('repertorio.no_events_message') }}</p>
                            @endif
                            <div class="text-center mt-4">
                                <a href="{{ route('eventi') }}" class="button button-sm button-default-outline-2 button-wapasha">{{ __('repertorio.all_events_button') }}</a>
                            </div>
                        </div>
                        
                        <!-- Richiedi Spartiti -->
                        <div class="aside-component-item">
                            <div class="box-contacts p-4 bg-primary">
                                <h4 class="box-contacts-title text-white">{{ __('repertorio.sheet_music_title') }}</h4>
                                <p class="text-white">{{ __('repertorio.sheet_music_description') }}</p>
                                <a class="button button-lg button-white button-winona" href="{{ route('contatti') }}">{{ __('repertorio.contact_button') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="section section-sm bg-default">
        <div class="container">
            <div class="row row-30 justify-content-center">
                <div class="col-sm-10 col-lg-6">
                    <div class="box-cta-thin">
                        <h4 class="box-cta-thin-title">{{ __('repertorio.cta_live_title') }}</h4>
                        <p>{{ __('repertorio.cta_live_description') }}</p>
                        <a class="button button-lg button-primary button-winona" href="{{ route('eventi') }}">{{ __('repertorio.cta_live_button') }}</a>
                    </div>
                </div>
                <div class="col-sm-10 col-lg-6">
                    <div class="box-cta-thin">
                        <h4 class="box-cta-thin-title">{{ __('repertorio.cta_join_title') }}</h4>
                        <p>{{ __('repertorio.cta_join_description') }}</p>
                        <a class="button button-lg button-primary button-winona" href="{{ route('contatti') }}">{{ __('repertorio.cta_join_button') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any JavaScript functionality here
    });
</script>
@endsection
