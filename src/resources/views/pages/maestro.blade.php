@extends('layouts.app')

@section('title', 'Il Maestro - Banda Folk di Castello Tesino')
@section('description', 'Conosci Marco Rossi, il maestro della Banda Folk di Castello Tesino. Scopri il suo percorso musicale e la sua visione artistica.')
@section('og_title', 'Il Maestro - Banda Folk di Castello Tesino')
@section('og_description', 'Conosci Marco Rossi, il maestro della Banda Folk di Castello Tesino. Scopri il suo percorso musicale e la sua visione artistica.')

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Il Maestro') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Il Maestro') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoSanIppolito1.jpg') }});"></div>
        </div>
    </section>

    <!-- Maestro Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center align-items-xl-center">
                <div class="col-md-10 col-lg-5 col-xl-6">
                    <div class="wow fadeInRight">
                        <img src="{{ asset('images/maestro.jpg') }}" alt="Marco Rossi - Maestro della Banda Folk di Castello Tesino" width="519" height="564" loading="lazy">
                    </div>
                </div>
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <h2 class="title-decoration-lines-left">{{ __('Marco Rossi') }}</h2>
                    <h5 class="text-primary">{{ __('Maestro della Banda Folk di Castello Tesino dal 2010') }}</h5>
                    <p class="text-gray-800">{{ __('Marco Rossi è nato a Trento nel 1975. Ha iniziato il suo percorso musicale all\'età di 8 anni, studiando pianoforte e tromba presso il Conservatorio di Trento. Successivamente, ha conseguito il diploma in Direzione d\'Orchestra presso lo stesso conservatorio, sotto la guida del maestro Antonio Bianchi.') }}</p>
                    <p class="text-gray-800">{{ __('La sua carriera come direttore è iniziata nel 2000, quando ha assunto la direzione della Banda Giovanile del Trentino. Nel 2005 è diventato assistente del maestro Luigi Tessaro nella Banda Folk di Castello Tesino, per poi assumerne la direzione nel 2010.') }}</p>
                    <p class="text-gray-800">{{ __('Sotto la sua guida, la Banda Folk ha ampliato il proprio repertorio, spaziando dalla musica tradizionale trentina a brani contemporanei, mantenendo sempre un forte legame con le radici culturali del territorio. Ha portato la banda a partecipare a numerosi festival internazionali, ottenendo importanti riconoscimenti.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements -->
    <section class="section section-sm bg-default">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Riconoscimenti e Traguardi') }}</span></h3>
            <div class="row row-30">
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                            <div class="unit-left">
                                <div class="box-icon-classic-icon bi-award"></div>
                            </div>
                            <div class="unit-body">
                                <h5 class="box-icon-classic-title">{{ __('Premio Eccellenza') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Concorso Nazionale Bande Musicali, Riva del Garda, 2015') }}</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                            <div class="unit-left">
                                <div class="box-icon-classic-icon bi-music-note-beamed"></div>
                            </div>
                            <div class="unit-body">
                                <h5 class="box-icon-classic-title">{{ __('Pubblicazioni') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Autore di "Armonie del Tesino", raccolta di arrangiamenti per banda di musiche tradizionali trentine') }}</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                            <div class="unit-left">
                                <div class="box-icon-classic-icon bi-globe"></div>
                            </div>
                            <div class="unit-body">
                                <h5 class="box-icon-classic-title">{{ __('Tournée Internazionali') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Ha diretto la banda in tournée in Austria, Germania, Francia e Svizzera') }}</p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Philosophy -->
    <section class="section section-sm bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('La Filosofia del Maestro') }}</span></h3>
                    <div class="quote-primary">
                        <div class="quote-primary-body">
                            <svg class="quote-primary-mark" width="35" height="25" viewBox="0 0 35 25">
                                <path d="M8.9,10.5H2.5c0-5.4,4.4-9.7,9.8-9.7v5.4C10.3,6.1,8.9,8.1,8.9,10.5z M23.2,10.5h-6.4c0-5.4,4.4-9.7,9.8-9.7v5.4C24.7,6.1,23.2,8.1,23.2,10.5z"></path>
                            </svg>
                            <div class="quote-primary-text">
                                <p>{{ __('La musica bandistica è un patrimonio culturale che va preservato e valorizzato. Il mio obiettivo come direttore è quello di mantenere viva questa tradizione, adattandola ai tempi moderni senza snaturarne l\'essenza. Credo fermamente che la banda sia un\'importante agenzia educativa e sociale, capace di unire persone di diverse generazioni e background attraverso il linguaggio universale della musica.') }}</p>
                            </div>
                        </div>
                        <div class="quote-primary-footer">
                            <cite>Marco Rossi</cite>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <h4>{{ __('Visione Artistica') }}</h4>
                        <p>{{ __('La visione artistica di Marco Rossi si basa su tre pilastri fondamentali:') }}</p>
                        <ul class="list-marked">
                            <li>{{ __('Tradizione: mantenere vivo il repertorio tradizionale trentino, valorizzando le melodie e i ritmi che caratterizzano la nostra cultura musicale.') }}</li>
                            <li>{{ __('Innovazione: esplorare nuovi generi e stili musicali, arricchendo il repertorio della banda con arrangiamenti moderni e contemporanei.') }}</li>
                            <li>{{ __('Formazione: investire nella formazione dei giovani musicisti, garantendo il futuro della banda e la trasmissione del patrimonio musicale alle nuove generazioni.') }}</li>
                        </ul>
                    </div>
                    
                    <div class="mt-5">
                        <h4>{{ __('Approccio Didattico') }}</h4>
                        <p>{{ __('Come insegnante e direttore, Marco Rossi adotta un approccio didattico basato sul rispetto delle individualità e sulla valorizzazione dei talenti di ciascun musicista. Crede fermamente che ogni persona abbia un potenziale musicale che può essere sviluppato con la giusta guida e motivazione.') }}</p>
                        <p>{{ __('Il suo metodo di insegnamento si concentra non solo sulla tecnica strumentale, ma anche sull\'ascolto, sull\'interpretazione e sulla comprensione profonda del linguaggio musicale. Grande importanza viene data anche alla musica d\'insieme, per sviluppare nei musicisti la capacità di suonare in armonia con gli altri.') }}</p>
                    </div>
                </div>
                
                <div class="col-md-10 col-lg-4">
                    <div class="aside-maestro">
                        <!-- Curriculum -->
                        <div class="aside-maestro-item">
                            <h5 class="aside-maestro-title">{{ __('Curriculum Vitae') }}</h5>
                            <ul class="list-marked list-marked-primary">
                                <li>{{ __('Diploma in Pianoforte, Conservatorio di Trento, 1996') }}</li>
                                <li>{{ __('Diploma in Tromba, Conservatorio di Trento, 1998') }}</li>
                                <li>{{ __('Diploma in Direzione d\'Orchestra, Conservatorio di Trento, 2002') }}</li>
                                <li>{{ __('Direttore Banda Giovanile del Trentino, 2000-2005') }}</li>
                                <li>{{ __('Assistente Direttore Banda Folk di Castello Tesino, 2005-2010') }}</li>
                                <li>{{ __('Direttore Banda Folk di Castello Tesino, dal 2010') }}</li>
                                <li>{{ __('Docente di Teoria e Solfeggio presso la Scuola Musicale di Borgo Valsugana, dal 2003') }}</li>
                            </ul>
                        </div>
                        
                        <!-- Masterclass -->
                        <div class="aside-maestro-item mt-5">
                            <h5 class="aside-maestro-title">{{ __('Masterclass e Corsi') }}</h5>
                            <div class="list-schedule">
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>2023</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Masterclass di Direzione Bandistica, Salisburgo') }}</span>
                                    </div>
                                </div>
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>2020</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Corso di Arrangiamento per Banda, Milano') }}</span>
                                    </div>
                                </div>
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>2018</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Seminario sulla Musica Tradizionale Europea, Vienna') }}</span>
                                    </div>
                                </div>
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>2015</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Corso di Perfezionamento in Direzione, Roma') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact -->
                        <div class="aside-maestro-item mt-5">
                            <div class="box-cta">
                                <h5 class="box-cta-title">{{ __('Contatta il Maestro') }}</h5>
                                <p>{{ __('Per informazioni sui corsi di musica o per collaborazioni artistiche') }}</p>
                                <a class="button button-lg button-primary button-winona" href="{{ route('contatti') }}">{{ __('Contattaci') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery -->
    <section class="section section-sm section-last bg-default text-md-left">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Galleria Fotografica') }}</span></h3>
            <div class="row row-30 justify-content-center" data-lightgallery="group">
                <div class="col-sm-6 col-lg-4">
                    <article class="thumbnail thumbnail-classic">
                        <div class="thumbnail-classic-figure">
                            <a href="{{ asset('images/maestro-gallery-1.jpg') }}" data-lightgallery="item">
                                <img src="{{ asset('images/maestro-gallery-1.jpg') }}" alt="Marco Rossi durante un concerto" width="370" height="270" loading="lazy">
                            </a>
                        </div>
                        <div class="thumbnail-classic-caption">
                            <p class="thumbnail-classic-title">{{ __('Concerto di Natale 2022') }}</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="thumbnail thumbnail-classic">
                        <div class="thumbnail-classic-figure">
                            <a href="{{ asset('images/maestro-gallery-2.jpg') }}" data-lightgallery="item">
                                <img src="{{ asset('images/maestro-gallery-2.jpg') }}" alt="Marco Rossi durante una prova" width="370" height="270" loading="lazy">
                            </a>
                        </div>
                        <div class="thumbnail-classic-caption">
                            <p class="thumbnail-classic-title">{{ __('Prove con la banda, 2021') }}</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="thumbnail thumbnail-classic">
                        <div class="thumbnail-classic-figure">
                            <a href="{{ asset('images/maestro-gallery-3.jpg') }}" data-lightgallery="item">
                                <img src="{{ asset('images/maestro-gallery-3.jpg') }}" alt="Marco Rossi riceve un premio" width="370" height="270" loading="lazy">
                            </a>
                        </div>
                        <div class="thumbnail-classic-caption">
                            <p class="thumbnail-classic-title">{{ __('Premio Eccellenza, 2015') }}</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/lightgallery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/plugins/zoom/lg-zoom.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/plugins/thumbnail/lg-thumbnail.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/css/lightgallery.css">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize lightGallery
        lightGallery(document.querySelector('[data-lightgallery="group"]'), {
            selector: '[data-lightgallery="item"]',
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
            download: false
        });
    });
</script>
@endsection
