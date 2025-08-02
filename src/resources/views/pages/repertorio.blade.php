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
            <div class="box-position" style="background-image: url({{ asset('images/FotoSanIppolito2.jpg') }});"></div>
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
                        @foreach($programs as $year => $yearPrograms)
                            <h4 class="text-primary mt-5">{{ __('repertorio.repertorio_year', ['year' => $year]) }}</h4>
                            
                            @foreach($yearPrograms as $program)
                                <div class="box-minimal mb-4">
                                    <div class="box-minimal-header bg-default p-3 shadow-sm rounded">
                                        <h5 class="box-minimal-title mt-0">{{ $program->title }}</h5>
                                    </div>
                                    
                                    @if($program->description)
                                        <div class="box-minimal-text px-3 mb-3">
                                            {{ $program->description }}
                                        </div>
                                    @endif
                                    
                                    @if($program->pieces->count() > 0)
                                        <div class="box-minimal-body p-0">
                                            <div class="table-custom-responsive">
                                                <table class="table-custom table-custom-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('repertorio.table_title') }}</th>
                                                            <th>{{ __('repertorio.table_composer') }}</th>
                                                            <th>{{ __('repertorio.table_genre') }}</th>
                                                            <th>{{ __('repertorio.table_duration') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($program->pieces as $piece)
                                                            <tr>
                                                                <td>
                                                                    <div class="font-weight-bold">{{ $piece->title }}</div>
                                                                    @if($piece->description)
                                                                        <div class="small text-gray-600 mt-1">{{ $piece->description }}</div>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div>{{ $piece->composer }}</div>
                                                                    @if($piece->arranger)
                                                                        <div class="small">{{ __('repertorio.table_arranger') }}: {{ $piece->arranger }}</div>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $piece->genre ?? '-' }}</td>
                                                                <td>{{ $piece->duration ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <div class="box-minimal-text text-center py-3">
                                            {{ __('repertorio.no_pieces_message') }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            {{ __('repertorio.no_programs_message') }}
                        </div>
                    @endif
                    
                    <!-- Esempi musicali -->
                    <div class="box-info mt-5">
                        <h4>{{ __('repertorio.examples_title') }}</h4>
                        <div class="row row-30">
                            <div class="col-lg-12">
                                <div class="unit unit-spacing-md flex-column flex-sm-row">
                                    <div class="unit-body">
                                        <h5>{{ __('repertorio.san_ippolito_title') }}</h5>
                                        <span class="badge badge-secondary">{{ __('repertorio.san_ippolito_badge') }}</span>
                                        <p class="mt-3">{{ __('repertorio.san_ippolito_description') }}</p>
                                        <audio class="w-100 mt-2" controls>
                                            <source src="{{ asset('assets/audio/marcia-san-ippolito.mp3') }}" type="audio/mpeg">
                                            {{ __('Il tuo browser non supporta l\'elemento audio.') }}
                                        </audio>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="unit unit-spacing-md flex-column flex-sm-row">
                                    <div class="unit-body">
                                        <h5>{{ __('repertorio.suite_trentina_title') }}</h5>
                                        <p class="mt-3">{{ __('repertorio.suite_trentina_description') }}</p>
                                        <audio class="w-100 mt-2" controls>
                                            <source src="{{ asset('assets/audio/suite-trentina.mp3') }}" type="audio/mpeg">
                                            {{ __('Il tuo browser non supporta l\'elemento audio.') }}
                                        </audio>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-10 col-lg-4">
                    <div class="aside-component">
                        <!-- Discografia -->
                        <div class="aside-component-item bg-gray-100 rounded p-4 mb-5">
                            <h4 class="text-primary">{{ __('repertorio.discography_title') }}</h4>
                            <div class="row row-30">
                                <div class="col-6 col-md-6 col-lg-12">
                                    <article class="thumbnail-classic">
                                        <div class="thumbnail-classic-figure">
                                            <img src="{{ asset('images/cd-echi-tesino.jpg') }}" alt="CD Echi dal Tesino" width="270" height="280" loading="lazy">
                                        </div>
                                        <div class="thumbnail-classic-caption">
                                            <h5 class="thumbnail-classic-title">{{ __('repertorio.cd_echi_tesino_title') }}</h5>
                                            <p class="thumbnail-classic-text">{{ __('repertorio.cd_echi_tesino_description') }}</p>
                                        </div>
                                    </article>
                                </div>
                                <div class="col-6 col-md-6 col-lg-12">
                                    <article class="thumbnail-classic">
                                        <div class="thumbnail-classic-figure">
                                            <img src="{{ asset('images/cd-centenario.jpg') }}" alt="CD Centenario" width="270" height="280" loading="lazy">
                                        </div>
                                        <div class="thumbnail-classic-caption">
                                            <h5 class="thumbnail-classic-title">{{ __('repertorio.cd_centenario_title') }}</h5>
                                            <p class="thumbnail-classic-text">{{ __('repertorio.cd_centenario_description') }}</p>
                                        </div>
                                    </article>
                                </div>
                                <div class="col-6 col-md-6 col-lg-12">
                                    <article class="thumbnail-classic">
                                        <div class="thumbnail-classic-figure">
                                            <img src="{{ asset('images/cd-armonie-tesino.jpg') }}" alt="CD Armonie del Tesino" width="270" height="280" loading="lazy">
                                        </div>
                                        <div class="thumbnail-classic-caption">
                                            <h5 class="thumbnail-classic-title">{{ __('repertorio.cd_armonie_tesino_title') }}</h5>
                                            <p class="thumbnail-classic-text">{{ __('repertorio.cd_armonie_tesino_description') }}</p>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                        
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
