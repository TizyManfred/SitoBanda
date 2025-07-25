@extends('layouts.app')

@section('title', 'Il Maestro - Banda Folk di Castello Tesino')
@section('description', 'Conosci Ivan Villanova, il maestro della Banda Folk di Castello Tesino. Diplomato in clarinetto, si è perfezionato con Fabio di Casola al Conservatorio della Svizzera Italiana.')
@section('og_title', 'Il Maestro - Banda Folk di Castello Tesino')
@section('og_description', 'Conosci Ivan Villanova, il maestro della Banda Folk di Castello Tesino. Diplomato in clarinetto, si è perfezionato con Fabio di Casola al Conservatorio della Svizzera Italiana.')

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
                    <h2 class="title-decoration-lines-left">{{ __('Ivan Villanova') }}</h2>
                    <h5 class="text-primary">{{ __('Maestro della Banda Folk di Castello Tesino') }}</h5>
                    <p class="text-gray-800">{{ __('Dopo il diploma in clarinetto si perfeziona con Fabio di Casola al Conservatorio della Svizzera Italiana e viene premiato in numerosi concorsi nazionali ed internazionali, tra i quali il 1° Premio assoluto al "Città di Stresa" 1996.') }}</p>
                    <p class="text-gray-800">{{ __('Ha suonato come Primo Clarinetto nell\'Orchestra Sinfonica dell\'Emilia-Romagna "Fondazione Arturo Toscanini", l\'Orchestra del Gran Teatro "La Fenice", la Filarmonia Veneta e l\'Orchestra d\'Archi Italiana, collaborando inoltre con L\'Orchestra di Padova e del Veneto, l\'Orchestra del Teatro "G. Verdi" di Trieste, La Filarmonica di Modena e la Symphonica Toscanini (diretta da Lorin Maazel), con tournée in Europa, USA, Emirati Arabi e Giappone.') }}</p>
                    <p class="text-gray-800">{{ __('È docente di Clarinetto alla Scuola Musicale di Primiero ed ha insegnato clarinetto ai Corsi Internazionali di Perfezionamento di Spilimbergo. Si diploma in Direzione all\'Istituto Superiore Europeo Bandistico sotto la guida di Jan Cober, Felix Hauswirth e Carlo Pirola, e nel 2009 vi consegue anche il Diploma Superiore, perfezionandosi poi con Jan Cober alla Bläserakademie Sächsen e con Douglas Bostock alla Bund Deutscher Blasmusikverbände.') }}</p>
                    <p class="text-gray-800">{{ __('Direttore principale della Dolomiti Wind Orchestra, guida la Banda Folkloristica di Castello Tesino e la Banda Città di Feltre. Ha insegnato Direzione ai Corsi Internazionali di Spilimbergo, a fianco di José Rafael Pascual-Vilaplana.') }}</p>
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
                                <h5 class="box-icon-classic-title">{{ __('1° Premio Assoluto') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Concorso "Città di Stresa" 1996') }}</p>
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
                                <h5 class="box-icon-classic-title">{{ __('Orchestre Prestigiose') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Primo Clarinetto in Orchestra Sinfonica Emilia-Romagna, La Fenice, Filarmonia Veneta') }}</p>
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
                                <p class="box-icon-classic-text">{{ __('Tournée in Europa, USA, Emirati Arabi e Giappone con la Symphonica Toscanini') }}</p>
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
                                <p>{{ __('La musica è un linguaggio universale che unisce le persone. Come direttore, il mio obiettivo è valorizzare sia la tradizione musicale del nostro territorio che l\'innovazione artistica, creando un ponte tra passato e futuro attraverso l\'arte bandistica.') }}</p>
                            </div>
                        </div>
                        <div class="quote-primary-footer">
                            <cite>Ivan Villanova</cite>
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
                                <li>{{ __('Diploma in Clarinetto') }}</li>
                                <li>{{ __('Perfezionamento con Fabio di Casola al Conservatorio della Svizzera Italiana') }}</li>
                                <li>{{ __('1° Premio assoluto al "Città di Stresa" 1996') }}</li>
                                <li>{{ __('Primo Clarinetto Orchestra Sinfonica Emilia-Romagna "Fondazione Arturo Toscanini"') }}</li>
                                <li>{{ __('Primo Clarinetto Orchestra del Gran Teatro "La Fenice"') }}</li>
                                <li>{{ __('Diploma in Direzione all\'Istituto Superiore Europeo Bandistico') }}</li>
                                <li>{{ __('Diploma Superiore in Direzione (2009)') }}</li>
                                <li>{{ __('Docente di Clarinetto alla Scuola Musicale di Primiero') }}</li>
                                <li>{{ __('Direttore principale della Dolomiti Wind Orchestra') }}</li>
                                <li>{{ __('Direttore Banda Folkloristica di Castello Tesino') }}</li>
                                <li>{{ __('Direttore Banda Città di Feltre') }}</li>
                            </ul>
                        </div>
                        
                        <!-- Masterclass -->
                        <div class="aside-maestro-item mt-5">
                            <h5 class="aside-maestro-title">{{ __('Masterclass e Corsi') }}</h5>
                            <div class="list-schedule">
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>2009</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Diploma Superiore in Direzione, Istituto Superiore Europeo Bandistico') }}</span>
                                    </div>
                                </div>
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>Ongoing</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Perfezionamento con Jan Cober alla Bläserakademie Sächsen') }}</span>
                                    </div>
                                </div>
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>Ongoing</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Perfezionamento con Douglas Bostock alla Bund Deutscher Blasmusikverbände') }}</span>
                                    </div>
                                </div>
                                <div class="list-schedule-item">
                                    <div class="list-schedule-left">
                                        <span>Various</span>
                                    </div>
                                    <div class="list-schedule-right">
                                        <span>{{ __('Docente di Direzione ai Corsi Internazionali di Spilimbergo') }}</span>
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
