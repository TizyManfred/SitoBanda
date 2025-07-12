@extends('layouts.app')

@section('title', 'Repertorio - Banda Folk di Castello Tesino')
@section('description', 'Scopri il repertorio musicale della Banda Folk di Castello Tesino: marce tradizionali, musica folk, brani classici e contemporanei.')
@section('og_title', 'Repertorio - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri il repertorio musicale della Banda Folk di Castello Tesino: marce tradizionali, musica folk, brani classici e contemporanei.')

@section('styles')
<style>
    .repertoire-category {
        margin-bottom: 40px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .repertoire-header {
        background-color: #01b3a7;
        color: white;
        padding: 20px;
        position: relative;
    }
    .repertoire-header h4 {
        margin: 0;
        font-weight: 600;
    }
    .repertoire-body {
        padding: 20px;
        background-color: #fff;
    }
    .repertoire-item {
        padding: 15px;
        border-bottom: 1px solid #eee;
        transition: all 0.3s ease;
    }
    .repertoire-item:last-child {
        border-bottom: none;
    }
    .repertoire-item:hover {
        background-color: #f9f9f9;
    }
    .repertoire-title {
        font-weight: 500;
        margin-bottom: 5px;
    }
    .repertoire-composer {
        color: #777;
        font-size: 14px;
    }
    .repertoire-year {
        font-size: 12px;
        color: #999;
    }
    .repertoire-description {
        margin-top: 10px;
        font-size: 14px;
    }
    .audio-player {
        margin-top: 10px;
        width: 100%;
    }
    .badge-featured {
        background-color: #ff9a9a;
        color: #fff;
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 10px;
        margin-left: 10px;
        vertical-align: middle;
    }
    .badge-new {
        background-color: #01b3a7;
        color: #fff;
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 10px;
        margin-left: 10px;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Repertorio') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Repertorio') }}</li>
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
                    <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Il Nostro Repertorio') }}</span></h3>
                    <p class="text-gray-800">{{ __('Il repertorio della Banda Folk di Castello Tesino è vasto e variegato, spaziando dalle tradizionali marce alle composizioni contemporanee. La nostra missione è quella di preservare il patrimonio musicale trentino, arricchendolo con nuove sonorità e arrangiamenti moderni.') }}</p>
                    
                    <!-- Marce Tradizionali -->
                    <div class="repertoire-category">
                        <div class="repertoire-header">
                            <h4>{{ __('Marce Tradizionali') }}</h4>
                        </div>
                        <div class="repertoire-body">
                            <div class="repertoire-item">
                                <div class="repertoire-title">
                                    {{ __('Marcia di San Ippolito') }}
                                    <span class="badge-featured">{{ __('Brano Simbolo') }}</span>
                                </div>
                                <div class="repertoire-composer">{{ __('Compositore: Giovanni Broccato') }}</div>
                                <div class="repertoire-year">{{ __('Anno: 1905') }}</div>
                                <div class="repertoire-description">
                                    {{ __('Composta dal fondatore della banda in onore del patrono di Castello Tesino, questa marcia è diventata il brano simbolo della nostra formazione.') }}
                                </div>
                                <audio class="audio-player" controls>
                                    <source src="{{ asset('assets/audio/marcia-san-ippolito.mp3') }}" type="audio/mpeg">
                                    {{ __('Il tuo browser non supporta l\'elemento audio.') }}
                                </audio>
                            </div>
                            <div class="repertoire-item">
                                <div class="repertoire-title">{{ __('Inno al Tesino') }}</div>
                                <div class="repertoire-composer">{{ __('Compositore: Antonio Sordo') }}</div>
                                <div class="repertoire-year">{{ __('Anno: 1925') }}</div>
                                <div class="repertoire-description">
                                    {{ __('Un omaggio musicale alla valle del Tesino, con melodie che richiamano i paesaggi montani e le tradizioni locali.') }}
                                </div>
                            </div>
                            <div class="repertoire-item">
                                <div class="repertoire-title">{{ __('Marcia Alpina') }}</div>
                                <div class="repertoire-composer">{{ __('Compositore: Luigi Tessaro') }}</div>
                                <div class="repertoire-year">{{ __('Anno: 1950') }}</div>
                                <div class="repertoire-description">
                                    {{ __('Una marcia che celebra la tradizione alpina del Trentino, con ritmi decisi e melodie evocative.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Musica Folk -->
                    <div class="repertoire-category">
                        <div class="repertoire-header">
                            <h4>{{ __('Musica Folk') }}</h4>
                        </div>
                        <div class="repertoire-body">
                            <div class="repertoire-item">
                                <div class="repertoire-title">{{ __('Suite Trentina') }}</div>
                                <div class="repertoire-composer">{{ __('Compositore: Roberto Bianchi') }}</div>
                                <div class="repertoire-year">{{ __('Anno: 1985') }}</div>
                                <div class="repertoire-description">
                                    {{ __('Una raccolta di melodie tradizionali trentine arrangiate per banda, che include danze popolari e canti della montagna.') }}
                                </div>
                                <audio class="audio-player" controls>
                                    <source src="{{ asset('assets/audio/suite-trentina.mp3') }}" type="audio/mpeg">
                                    {{ __('Il tuo browser non supporta l\'elemento audio.') }}
                                </audio>
                            </div>
                            <div class="repertoire-item">
                                <div class="repertoire-title">{{ __('Danze del Tesino') }}</div>
                                <div class="repertoire-composer">{{ __('Compositore: Marco Rossi') }}</div>
                                <div class="repertoire-year">{{ __('Anno: 2012') }}</div>
                                <div class="repertoire-description">
                                    {{ __('Un\'opera originale del nostro attuale maestro, che reinterpreta in chiave moderna le danze tradizionali della valle del Tesino.') }}
                                </div>
                            </div>
                            <div class="repertoire-item">
                                <div class="repertoire-title">
                                    {{ __('Echi della Montagna') }}
                                    <span class="badge-new">{{ __('Nuovo') }}</span>
                                </div>
                                <div class="repertoire-composer">{{ __('Compositore: Marco Rossi') }}</div>
                                <div class="repertoire-year">{{ __('Anno: 2023') }}</div>
                                <div class="repertoire-description">
                                    {{ __('La nostra più recente composizione originale, che evoca i suoni e le atmosfere delle montagne trentine attraverso un linguaggio musicale contemporaneo.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Musica Classica e Operistica -->
                    <div class="repertoire-category">
                        <div class="repertoire-header">
                            <h4>{{ __('Musica Classica e Operistica') }}</h4>
                        </div>
                        <div class="repertoire-body">
                            <div class="repertoire-item">
                                <div class="repertoire-title">{{ __('Selezione da "La Traviata"') }}</div>
                                <div class="repertoire-composer">{{ __('Compositore: Giuseppe Verdi, arr. Marco Rossi') }}</div>
                                <div class="repertoire-year">{{ __('Arrangiamento: 2015') }}</div>
                                <div class="repertoire-description">
                                    {{ __('Una selezione delle arie più celebri dell\'opera di Verdi, arrangiate per banda dal nostro maestro.') }}
                                </div>
                            </div>
                            <div class="repertoire-item">
                                <div class="repertoire-title">{{ __('Ouverture "Le Nozze di Figaro"') }}</div>
                                <div class="repertoire-composer">{{ __('Compositore: W.A. Mozart, arr. Roberto Bianchi') }}</div>
                                <div class="repertoire-year">{{ __('Arrangiamento: 1990') }}</div>
                                <div class="repertoire-description">
                                    {{ __('La celebre ouverture dell\'opera di Mozart, adattata per la formazione bandistica.') }}
                                </div>
                            </div>
                            <div class="repertoire-item">
                                <div class="repertoire-title">{{ __('Sinfonia n. 9 "Dal Nuovo Mondo" (estratti)') }}</div>
                                <div class="repertoire-composer">{{ __('Compositore: Antonín Dvořák, arr. Marco Rossi') }}</div>
                                <div class="repertoire-year">{{ __('Arrangiamento: 2018') }}</div>
                                <div class="repertoire-description">
                                    {{ __('Una selezione di temi dalla celebre sinfonia di Dvořák, con particolare attenzione al secondo movimento "Largo".') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Musica Contemporanea -->
                    <div class="repertoire-category">
                        <div class="repertoire-header">
                            <h4>{{ __('Musica Contemporanea') }}</h4>
                        </div>
                        <div class="repertoire-body">
                            <div class="repertoire-item">
                                <div class="repertoire-title">{{ __('Highlights da "Il Re Leone"') }}</div>
                                <div class="repertoire-composer">{{ __('Compositore: Hans Zimmer, arr. Marco Rossi') }}</div>
                                <div class="repertoire-year">{{ __('Arrangiamento: 2020') }}</div>
                                <div class="repertoire-description">
                                    {{ __('Una selezione delle musiche più celebri dal film Disney, arrangiate per banda.') }}
                                </div>
                            </div>
                            <div class="repertoire-item">
                                <div class="repertoire-title">
                                    {{ __('Medley "ABBA Gold"') }}
                                    <span class="badge-new">{{ __('Nuovo') }}</span>
                                </div>
                                <div class="repertoire-composer">{{ __('Compositore: ABBA, arr. Marco Rossi') }}</div>
                                <div class="repertoire-year">{{ __('Arrangiamento: 2023') }}</div>
                                <div class="repertoire-description">
                                    {{ __('Un medley dei più grandi successi degli ABBA, arrangiati in chiave bandistica.') }}
                                </div>
                            </div>
                            <div class="repertoire-item">
                                <div class="repertoire-title">{{ __('Suite da "Game of Thrones"') }}</div>
                                <div class="repertoire-composer">{{ __('Compositore: Ramin Djawadi, arr. Marco Rossi') }}</div>
                                <div class="repertoire-year">{{ __('Arrangiamento: 2019') }}</div>
                                <div class="repertoire-description">
                                    {{ __('I temi principali della celebre serie TV, adattati per la nostra formazione bandistica.') }}
                                </div>
                                <audio class="audio-player" controls>
                                    <source src="{{ asset('assets/audio/got-suite.mp3') }}" type="audio/mpeg">
                                    {{ __('Il tuo browser non supporta l\'elemento audio.') }}
                                </audio>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-10 col-lg-4">
                    <div class="aside-repertorio">
                        <!-- Discografia -->
                        <div class="aside-repertorio-item">
                            <h4 class="aside-repertorio-title">{{ __('La Nostra Discografia') }}</h4>
                            <div class="row row-30">
                                <div class="col-6 col-md-6 col-lg-12">
                                    <article class="product">
                                        <div class="product-figure">
                                            <img src="{{ asset('images/cd-echi-tesino.jpg') }}" alt="CD Echi dal Tesino" width="270" height="280" loading="lazy">
                                        </div>
                                        <h5 class="product-title">{{ __('Echi dal Tesino') }}</h5>
                                        <p class="product-text">{{ __('1985 - Il nostro primo album, con brani della tradizione trentina.') }}</p>
                                    </article>
                                </div>
                                <div class="col-6 col-md-6 col-lg-12">
                                    <article class="product">
                                        <div class="product-figure">
                                            <img src="{{ asset('images/cd-centenario.jpg') }}" alt="CD Centenario" width="270" height="280" loading="lazy">
                                        </div>
                                        <h5 class="product-title">{{ __('Centenario') }}</h5>
                                        <p class="product-text">{{ __('2001 - Album celebrativo per i 100 anni della banda.') }}</p>
                                    </article>
                                </div>
                                <div class="col-6 col-md-6 col-lg-12">
                                    <article class="product">
                                        <div class="product-figure">
                                            <img src="{{ asset('images/cd-armonie-tesino.jpg') }}" alt="CD Armonie del Tesino" width="270" height="280" loading="lazy">
                                        </div>
                                        <h5 class="product-title">{{ __('Armonie del Tesino') }}</h5>
                                        <p class="product-text">{{ __('2015 - Raccolta di arrangiamenti originali del maestro Marco Rossi.') }}</p>
                                    </article>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Prossimi Concerti -->
                        <div class="aside-repertorio-item mt-5">
                            <h4 class="aside-repertorio-title">{{ __('Prossimi Concerti') }}</h4>
                            <div class="list-schedule">
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>{{ __('15 Ago') }}</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Concerto di Ferragosto, Piazza Maggiore') }}</span>
                                    </div>
                                </div>
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>{{ __('10 Set') }}</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Festival delle Bande, Borgo Valsugana') }}</span>
                                    </div>
                                </div>
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>{{ __('25 Dic') }}</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Concerto di Natale, Chiesa Parrocchiale') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <a href="{{ route('eventi') }}" class="button button-sm button-default-outline-2 button-wapasha">{{ __('Tutti gli Eventi') }}</a>
                            </div>
                        </div>
                        
                        <!-- Richiedi Spartiti -->
                        <div class="aside-repertorio-item mt-5">
                            <div class="box-cta">
                                <h4 class="box-cta-title">{{ __('Richiedi gli Spartiti') }}</h4>
                                <p>{{ __('Sei interessato agli spartiti dei nostri brani? Contattaci per maggiori informazioni.') }}</p>
                                <a class="button button-lg button-primary button-winona" href="{{ route('contatti') }}">{{ __('Contattaci') }}</a>
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
                        <h4 class="box-cta-thin-title">{{ __('Vuoi Ascoltarci dal Vivo?') }}</h4>
                        <p>{{ __('Consulta il nostro calendario eventi e vieni a trovarci ai nostri prossimi concerti.') }}</p>
                        <a class="button button-lg button-primary button-winona" href="{{ route('eventi') }}">{{ __('Calendario Eventi') }}</a>
                    </div>
                </div>
                <div class="col-sm-10 col-lg-6">
                    <div class="box-cta-thin">
                        <h4 class="box-cta-thin-title">{{ __('Vuoi Suonare con Noi?') }}</h4>
                        <p>{{ __('Sei un musicista e vorresti entrare a far parte della nostra banda? Contattaci per informazioni.') }}</p>
                        <a class="button button-lg button-primary button-winona" href="{{ route('contatti') }}">{{ __('Unisciti a Noi') }}</a>
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
