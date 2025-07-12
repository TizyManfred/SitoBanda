@extends('layouts.app')

@section('title', 'Chi Siamo - Banda Folk di Castello Tesino')
@section('description', 'Scopri la storia e la missione della Banda Folk di Castello Tesino, un\'istituzione musicale attiva dal 1901 che porta avanti la tradizione musicale trentina.')
@section('og_title', 'Chi Siamo - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri la storia e la missione della Banda Folk di Castello Tesino, un\'istituzione musicale attiva dal 1901.')

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Chi Siamo') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Chi Siamo') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoSanIppolito1.jpg') }});"></div>
        </div>
    </section>

    <!-- Chi Siamo Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center align-items-xl-center">
                <div class="col-md-10 col-lg-5 col-xl-6">
                    <div class="wow fadeInRight">
                        <img src="{{ asset('images/FotoBiagio1.jpg') }}" alt="Banda Folk di Castello Tesino" width="519" height="564" loading="lazy">
                    </div>
                </div>
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <h2 class="title-decoration-lines-left">{{ __('La Banda Folk di Castello Tesino') }}</h2>
                    <p class="text-gray-800">{{ __('La Banda Folk di Castello Tesino è un\'istituzione musicale che nasce nel 1901, vantando quindi più di 120 anni di storia. La nostra missione è quella di portare avanti la tradizione musicale del Trentino, unendo generazioni diverse attraverso la passione per la musica.') }}</p>
                    <p class="text-gray-800">{{ __('Siamo un gruppo di musicisti amatoriali che si dedica con passione alla musica bandistica, partecipando a numerosi eventi e manifestazioni sia in Italia che all\'estero. Il nostro repertorio spazia dalla musica tradizionale trentina a brani classici e contemporanei.') }}</p>
                    <p class="text-gray-800">{{ __('La Banda Folk è composta da circa 30 elementi di diverse età, dai giovani allievi ai veterani con decenni di esperienza. Questa diversità generazionale è uno dei nostri punti di forza, permettendo uno scambio continuo di esperienze e conoscenze.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="section section-sm section-last bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center">
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <h3>{{ __('I Nostri Valori') }}</h3>
                    <div class="row row-30">
                        <div class="col-sm-6">
                            <article class="box-icon-classic">
                                <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                                    <div class="unit-left">
                                        <div class="box-icon-classic-icon bi-music-note-beamed"></div>
                                    </div>
                                    <div class="unit-body">
                                        <h5 class="box-icon-classic-title">{{ __('Tradizione') }}</h5>
                                        <p class="box-icon-classic-text">{{ __('Manteniamo viva la tradizione musicale trentina, tramandandola di generazione in generazione.') }}</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6">
                            <article class="box-icon-classic">
                                <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                                    <div class="unit-left">
                                        <div class="box-icon-classic-icon bi-people-fill"></div>
                                    </div>
                                    <div class="unit-body">
                                        <h5 class="box-icon-classic-title">{{ __('Comunità') }}</h5>
                                        <p class="box-icon-classic-text">{{ __('Creiamo un senso di appartenenza e comunità attraverso la musica e le esperienze condivise.') }}</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6">
                            <article class="box-icon-classic">
                                <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                                    <div class="unit-left">
                                        <div class="box-icon-classic-icon bi-book"></div>
                                    </div>
                                    <div class="unit-body">
                                        <h5 class="box-icon-classic-title">{{ __('Formazione') }}</h5>
                                        <p class="box-icon-classic-text">{{ __('Offriamo corsi di musica per tutte le età, promuovendo l\'educazione musicale nel territorio.') }}</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6">
                            <article class="box-icon-classic">
                                <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                                    <div class="unit-left">
                                        <div class="box-icon-classic-icon bi-globe"></div>
                                    </div>
                                    <div class="unit-body">
                                        <h5 class="box-icon-classic-title">{{ __('Internazionalità') }}</h5>
                                        <p class="box-icon-classic-text">{{ __('Portiamo la nostra musica e tradizioni oltre i confini nazionali, partecipando a eventi internazionali.') }}</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-lg-5 col-xl-6">
                    <div class="row row-30 justify-content-center">
                        <div class="col-sm-6">
                            <article class="box-icon-modern box-icon-modern-custom">
                                <div>
                                    <h3 class="box-icon-modern-big-title">{{ __('Unisciti a Noi') }}</h3>
                                    <div class="box-icon-modern-decor"></div>
                                    <p class="box-icon-modern-text">{{ __('Sei appassionato di musica? Vuoi imparare a suonare uno strumento o far parte della nostra banda? Contattaci per informazioni sui corsi e sulle modalità di partecipazione.') }}</p>
                                    <a class="button button-md button-default-outline-2 button-wapasha" href="{{ route('corsi-di-musica') }}">{{ __('Scopri i Corsi') }}</a>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6">
                            <img src="{{ asset('images/FotoRoma1.jpeg') }}" alt="Banda Folk di Castello Tesino a Roma" width="300" height="300" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
