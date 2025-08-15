@extends('layouts.app')

@section('title', 'Corsi di Musica 2024-2025 - Banda Folk di Castello Tesino')
@section('description', 'I corsi di musica della Banda Folk di Castello Tesino: impara a suonare uno strumento e unisciti alla nostra banda. Iscrizioni aperte per l\'anno 2024-2025.')
@section('og_title', 'Corsi di Musica 2024-2025 - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri i corsi di musica offerti dalla Banda Folk di Castello Tesino per strumenti a fiato e percussioni. Iscrizioni aperte fino al 27 Giugno 2025.')

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Corsi di Musica') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Corsi di Musica') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoShanghai1.webp') }});"></div>
        </div>
    </section>

    <!-- Corsi di Musica Content -->
    <section class="section section-sm section-first bg-default text-left">
        <div class="container">
            <div class="row row-50">
                <!-- Main Text -->
                <div class="col-lg-10 col-xl-8">
                    <div class="container">
                        <h2 class="title-decoration-lines-left">{{ __('Impara a Suonare con Noi') }}</h2>
                        <div class="row row-50">
                            <div class="col-lg-6 col-xl-6">
                                <img src="{{ asset('images/FotoTrento1.webp') }}" alt="{{ __('Corsi di Musica della Banda Folk di Castello Tesino') }}" class="img-fluid">
                            </div>
                            <div class="col-lg-6 col-xl-6">
                                <p>{{ __('La Banda Folk di Castello Tesino organizza corsi di musica per avvicinare giovani e adulti al mondo della musica bandistica.') }}</p>
                                <p>{{ __('I corsi sono aperti a tutti, a partire dagli 8 anni di età e senza limiti superiori. Non è mai troppo tardi per imparare a suonare uno strumento e unirsi alla nostra banda!') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-10 col-xl-4">
                    <div class="aside-component">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('Iscrizioni A.A. 2024-2025') }}</h4>
                            </div>
                            <div class="card-body">
                                <p><strong>{{ __('Scadenza iscrizioni:') }}</strong><br>
                                {{ \Carbon\Carbon::parse(\App\Helpers\SettingsHelper::coursesInfo()['expiration_date'])->translatedFormat('d F Y') }}</p>
                                
                                <p><strong>{{ __('Periodo dei corsi:') }}</strong><br>
                                da {{ \Carbon\Carbon::parse(\App\Helpers\SettingsHelper::coursesInfo()['start_date'])->translatedFormat('F') }} a {{ \Carbon\Carbon::parse(\App\Helpers\SettingsHelper::coursesInfo()['end_date'])->translatedFormat('F') }}</p>
                                
                                <p><strong>{{ __('Quote di partecipazione:') }}</strong><br>
                                {!! nl2br(\App\Helpers\SettingsHelper::coursesInfo()['price']) !!}
                                
                                <p><strong>{{ __('Per informazioni:') }}</strong><br>
                                <a href="mailto:{{ \App\Helpers\SettingsHelper::coursesInfo()['contact_email'] }}">{{ \App\Helpers\SettingsHelper::coursesInfo()['contact_email'] }}</a><br>
                                {{ __('Cell:') }} {{ \App\Helpers\SettingsHelper::coursesInfo()['phone'] }}</p>
                                
                                <div class="mt-4">
                                    <a href="{{ \App\Helpers\SettingsHelper::coursesInfo()['forms_link'] }}" class="button button-primary button-ujarak w-100">{{ __('Compila Iscrizione') }}</a>
                                </div>
                            </div>
                        </div>
                        
                        @if(isset(\App\Helpers\SettingsHelper::coursesInfo()['testimonials']) && count(\App\Helpers\SettingsHelper::coursesInfo()['testimonials']) > 0)
                        <!-- Testimonials -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4 class="mb-0">{{ __('Cosa Dicono i Nostri Allievi') }}</h4>
                            </div>
                            <ul class="list-group list-group-flush">
                                @foreach (\App\Helpers\SettingsHelper::coursesInfo()['testimonials'] as $testimonial)
                                    <li class="list-group-item">
                                        <blockquote class="mb-1">{!! nl2br($testimonial['text']) !!}</blockquote>
                                        <small class="text-muted d-block">— {{ $testimonial['name'] }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    
@endsection
