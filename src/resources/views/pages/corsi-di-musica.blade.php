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
            <div class="box-position" style="background-image: url({{ asset('images/FotoShanghai1.jpeg') }});"></div>
        </div>
    </section>

    <!-- Corsi di Musica Content -->
    <section class="section section-lg bg-default">
        <div class="container">
            <div class="row row-50 justify-content-center">
                <!-- Main Text -->
                <div class="col-lg-10 col-xl-8">
                    <div class="course-description-wrap">
                        <h2>{{ __('Impara a Suonare con Noi') }}</h2>
                        <div class="course-main-image">
                            <img src="{{ asset('images/FotoTrento1.jpg') }}" alt="{{ __('Corsi di Musica della Banda Folk di Castello Tesino') }}" class="img-fluid">
                        </div>
                        
                        <div class="course-text mt-4">
                            <p class="lead">{{ __('La Banda Folk di Castello Tesino organizza corsi di musica per avvicinare giovani e adulti al mondo della musica bandistica.') }}</p>
                            
                            <p>{{ __('I nostri corsi sono aperti a tutti, a partire dagli 8 anni di età e senza limiti superiori. Non è mai troppo tardi per imparare a suonare uno strumento e unirsi alla nostra banda!') }}</p>
                            
                            <h4 class="mt-5">{{ __('Strumenti Insegnati') }}</h4>
                            <div class="row row-30 mt-4">
                                <div class="col-md-6">
                                    <div class="instrument-category">
                                        <h5>{{ __('Strumenti a Fiato - Legni') }}</h5>
                                        <ul class="list-marked">
                                            <li>{{ __('Clarinetto') }}</li>
                                            <li>{{ __('Flauto Traverso') }}</li>
                                            <li>{{ __('Sassofono') }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="instrument-category">
                                        <h5>{{ __('Strumenti a Fiato - Ottoni') }}</h5>
                                        <ul class="list-marked">
                                            <li>{{ __('Tromba') }}</li>
                                            <li>{{ __('Trombone') }}</li>
                                            <li>{{ __('Corno') }}</li>
                                            <li>{{ __('Euphonium/Flicorno Baritono') }}</li>
                                            <li>{{ __('Tuba') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="instrument-category">
                                        <h5>{{ __('Percussioni') }}</h5>
                                        <ul class="list-marked">
                                            <li>{{ __('Tamburo') }}</li>
                                            <li>{{ __('Timpani') }}</li>
                                            <li>{{ __('Xilofono') }}</li>
                                            <li>{{ __('Batteria') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <h4 class="mt-5">{{ __('Struttura dei Corsi') }}</h4>
                            <p>{{ __('I corsi sono strutturati in lezioni individuali di strumento e lezioni collettive di teoria e solfeggio. Le lezioni si tengono generalmente nel periodo da ottobre a maggio, presso la sede della banda in Via Venezia 18 a Castello Tesino.') }}</p>
                            
                            <div class="course-schedule mt-4">
                                <h5>{{ __('Organizzazione delle Lezioni') }}</h5>
                                <ul class="list-marked">
                                    <li><strong>{{ __('Lezioni di strumento:') }}</strong> {{ __('1 ora settimanale individuale') }}</li>
                                    <li><strong>{{ __('Lezioni di teoria musicale:') }}</strong> {{ __('1 ora settimanale in gruppo') }}</li>
                                    <li><strong>{{ __('Musica d\'insieme:') }}</strong> {{ __('1 ora settimanale (dal secondo anno)') }}</li>
                                </ul>
                            </div>
                            
                            <div class="quote-classic mt-5">
                                <div class="quote-body">
                                    <q>{{ __('La musica è un linguaggio universale che avvicina le persone e crea legami. Con i nostri corsi vogliamo offrire la possibilità a tutti, dai più giovani ai meno giovani, di avvicinarsi a questa meravigliosa forma d\'arte.') }}</q>
                                    <cite>{{ __('Maestro Ivan Villanova') }}</cite>
                                </div>
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
                                {{ __('Venerdì 27 Giugno 2025') }}</p>
                                
                                <p><strong>{{ __('Periodo dei corsi:') }}</strong><br>
                                {{ __('Da Settembre a Giugno') }}</p>
                                
                                <p><strong>{{ __('Quote di partecipazione:') }}</strong><br>
                                {{ __('€220 annuali, comprensivi di assicurazione') }}<br>
                                <small>{{ __('(Sconto di €50 dal secondo fratello)') }}</small></p>
                                
                                <p>{{ __('La quota comprende:') }}</p>
                                <ul class="list-marked">
                                    <li>{{ __('Lezioni individuali e di gruppo') }}</li>
                                    <li>{{ __('Materiale didattico') }}</li>
                                    <li>{{ __('Utilizzo gratuito dello strumento per tutta la durata dei corsi') }}</li>
                                </ul>
                                
                                <p><strong>{{ __('Per informazioni:') }}</strong><br>
                                <a href="mailto:info@bandacastellotesino.it">info@bandacastellotesino.it</a><br>
                                {{ __('Cell:') }} 328 8111676</p>
                                
                                <div class="mt-4">
                                    <a href="https://forms.gle/jwNTtArZxtXogfgz7" class="button button-lg button-primary button-block">{{ __('Compila Iscrizione') }}</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonials -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4>{{ __('Cosa Dicono i Nostri Allievi') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="testimonial">
                                    <p>"{{ __('Ho iniziato a studiare clarinetto a 10 anni e ora, dopo 5 anni, sono parte della banda. Un\'esperienza fantastica che mi ha insegnato non solo la musica ma anche il valore della collaborazione.') }}"</p>
                                    <p class="testimonial-author">- {{ __('Marco, 15 anni') }}</p>
                                </div>
                                <hr>
                                <div class="testimonial">
                                    <p>"{{ __('Da adulta pensavo fosse troppo tardi per imparare, invece dopo 2 anni suono il flauto in banda. Gli insegnanti sono pazienti e competenti.') }}"</p>
                                    <p class="testimonial-author">- {{ __('Laura, 42 anni') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Annual Concert Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="box-cta">
                        <h3>{{ __('Saggio Finale degli Allievi') }}</h3>
                        <p>{{ __('Ogni anno, nel mese di maggio, si tiene il saggio finale degli allievi dei corsi. Un\'occasione per mostrare i progressi raggiunti durante l\'anno e per esibirsi davanti a familiari e amici.') }}</p>
                        <div class="row justify-content-center mt-4">
                            <div class="col-md-8">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/VIDEO_ID" title="{{ __('Video del saggio degli allievi') }}" allowfullscreen loading="lazy"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
@endsection
