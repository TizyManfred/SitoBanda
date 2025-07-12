@extends('layouts.app')

@section('title', 'Abito Tradizionale - Banda Folk di Castello Tesino')
@section('description', 'Scopri l\'abito tradizionale della Banda Folk di Castello Tesino, un simbolo di identità culturale e tradizione trentina.')
@section('og_title', 'Abito Tradizionale - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri l\'abito tradizionale della Banda Folk di Castello Tesino, un simbolo di identità culturale e tradizione trentina.')

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Abito Tradizionale') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Abito Tradizionale') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/abito-tradizionale-header.jpg') }});"></div>
        </div>
    </section>

    <!-- Abito Tradizionale Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center align-items-xl-center">
                <div class="col-md-10 col-lg-5 col-xl-6">
                    <div class="wow fadeInRight">
                        <img src="{{ asset('images/abito-tradizionale-full.jpg') }}" alt="Abito Tradizionale della Banda Folk di Castello Tesino" width="519" height="564" loading="lazy">
                    </div>
                </div>
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <h2 class="title-decoration-lines-left">{{ __('Il Nostro Abito Tradizionale') }}</h2>
                    <p class="text-gray-800">{{ __('L\'abito tradizionale della Banda Folk di Castello Tesino rappresenta un importante elemento di identità culturale e un legame tangibile con la tradizione trentina. Indossato durante le manifestazioni ufficiali, le processioni religiose e i concerti più importanti, l\'abito è stato progettato per riflettere i colori e i motivi tipici del folklore locale.') }}</p>
                    <p class="text-gray-800">{{ __('La versione attuale dell\'abito è stata adottata nel 1985, in occasione dell\'80° anniversario della fondazione della banda, ed è stata realizzata seguendo i disegni e le descrizioni degli abiti storici conservati nel museo etnografico di Castello Tesino.') }}</p>
                    <p class="text-gray-800">{{ __('Ogni elemento dell\'abito ha un significato simbolico e rappresenta un aspetto della cultura e della storia della comunità di Castello Tesino.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Elementi dell'Abito -->
    <section class="section section-sm bg-default">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Elementi dell\'Abito') }}</span></h3>
            <div class="row row-30">
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                            <div class="unit-left">
                                <div class="box-icon-classic-icon bi-hat-fill"></div>
                            </div>
                            <div class="unit-body">
                                <h5 class="box-icon-classic-title">{{ __('Il Cappello') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Cappello a tesa larga di colore verde scuro, ornato con una piuma d\'aquila sul lato sinistro, simbolo di libertà e legame con la montagna.') }}</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                            <div class="unit-left">
                                <div class="box-icon-classic-icon bi-suit-heart-fill"></div>
                            </div>
                            <div class="unit-body">
                                <h5 class="box-icon-classic-title">{{ __('La Giacca') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Giacca in lana verde scuro con risvolti rossi e bottoni dorati incisi con lo stemma di Castello Tesino, simbolo di appartenenza alla comunità.') }}</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                            <div class="unit-left">
                                <div class="box-icon-classic-icon bi-palette-fill"></div>
                            </div>
                            <div class="unit-body">
                                <h5 class="box-icon-classic-title">{{ __('Il Gilet') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Gilet rosso con ricami floreali dorati, che richiamano la flora alpina e simboleggiano il legame con la natura e le stagioni.') }}</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                            <div class="unit-left">
                                <div class="box-icon-classic-icon bi-scissors"></div>
                            </div>
                            <div class="unit-body">
                                <h5 class="box-icon-classic-title">{{ __('I Pantaloni') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Pantaloni in lana nera con una striscia laterale rossa, che richiama i colori dello stemma comunale e simboleggia la forza e la determinazione.') }}</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                            <div class="unit-left">
                                <div class="box-icon-classic-icon bi-bookmark-fill"></div>
                            </div>
                            <div class="unit-body">
                                <h5 class="box-icon-classic-title">{{ __('La Cravatta') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Cravatta a farfalla nera, simbolo di eleganza e rispetto per la tradizione musicale classica europea.') }}</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column flex-xl-row">
                            <div class="unit-left">
                                <div class="box-icon-classic-icon bi-boot-fill"></div>
                            </div>
                            <div class="unit-body">
                                <h5 class="box-icon-classic-title">{{ __('Le Calzature') }}</h5>
                                <p class="box-icon-classic-text">{{ __('Scarpe nere lucide e calzini verdi, che completano l\'abito e simboleggiano il legame con la terra e le radici culturali.') }}</p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Storia dell'Abito -->
    <section class="section section-sm bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Storia dell\'Abito') }}</span></h3>
                    <div class="timeline-classic">
                        <div class="timeline-classic-item">
                            <div class="timeline-classic-period"><span>1901-1920</span></div>
                            <div class="timeline-classic-main">
                                <h5 class="timeline-classic-title">{{ __('Il Primo Abito') }}</h5>
                                <p>{{ __('Nei primi anni di attività, i musicisti della banda indossavano un semplice abito scuro con una fascia verde e rossa, i colori del comune di Castello Tesino. Non esisteva ancora un abito ufficiale, ma questa prima forma di uniformità serviva a identificare i membri della banda durante le esibizioni pubbliche.') }}</p>
                            </div>
                        </div>
                        <div class="timeline-classic-item">
                            <div class="timeline-classic-period"><span>1920-1950</span></div>
                            <div class="timeline-classic-main">
                                <h5 class="timeline-classic-title">{{ __('L\'Abito Militare') }}</h5>
                                <p>{{ __('Dopo la Prima Guerra Mondiale, la banda adottò un abito ispirato alle uniformi militari, con giacca blu scuro, bottoni dorati e berretto rigido. Questa scelta rifletteva l\'influenza delle bande militari dell\'epoca e il rispetto per i caduti in guerra.') }}</p>
                            </div>
                        </div>
                        <div class="timeline-classic-item">
                            <div class="timeline-classic-period"><span>1950-1985</span></div>
                            <div class="timeline-classic-main">
                                <h5 class="timeline-classic-title">{{ __('L\'Abito Moderno') }}</h5>
                                <p>{{ __('Nel dopoguerra, l\'abito fu modernizzato con l\'adozione di una giacca verde con risvolti rossi, pantaloni neri e cappello a tesa larga. Questo abito, più pratico e meno formale, rifletteva il cambiamento dei tempi e l\'evoluzione della banda verso un repertorio più vario.') }}</p>
                            </div>
                        </div>
                        <div class="timeline-classic-item">
                            <div class="timeline-classic-period"><span>1985-Oggi</span></div>
                            <div class="timeline-classic-main">
                                <h5 class="timeline-classic-title">{{ __('L\'Abito Tradizionale Attuale') }}</h5>
                                <p>{{ __('In occasione dell\'80° anniversario della fondazione, la banda decise di adottare un abito che richiamasse più esplicitamente la tradizione trentina. Dopo un\'accurata ricerca storica, fu creato l\'abito attuale, che combina elementi della tradizione locale con dettagli che simboleggiano l\'identità della banda.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-10 col-lg-4">
                    <div class="aside-abito">
                        <!-- Galleria -->
                        <div class="aside-abito-item">
                            <h5 class="aside-abito-title">{{ __('Galleria Storica') }}</h5>
                            <div class="row row-30" data-lightgallery="group">
                                <div class="col-6">
                                    <article class="thumbnail thumbnail-classic">
                                        <div class="thumbnail-classic-figure">
                                            <a href="{{ asset('images/abito-storico-1.jpg') }}" data-lightgallery="item">
                                                <img src="{{ asset('images/abito-storico-1.jpg') }}" alt="Abito storico 1920" width="170" height="170" loading="lazy">
                                            </a>
                                        </div>
                                    </article>
                                </div>
                                <div class="col-6">
                                    <article class="thumbnail thumbnail-classic">
                                        <div class="thumbnail-classic-figure">
                                            <a href="{{ asset('images/abito-storico-2.jpg') }}" data-lightgallery="item">
                                                <img src="{{ asset('images/abito-storico-2.jpg') }}" alt="Abito storico 1950" width="170" height="170" loading="lazy">
                                            </a>
                                        </div>
                                    </article>
                                </div>
                                <div class="col-6">
                                    <article class="thumbnail thumbnail-classic">
                                        <div class="thumbnail-classic-figure">
                                            <a href="{{ asset('images/abito-storico-3.jpg') }}" data-lightgallery="item">
                                                <img src="{{ asset('images/abito-storico-3.jpg') }}" alt="Abito storico 1970" width="170" height="170" loading="lazy">
                                            </a>
                                        </div>
                                    </article>
                                </div>
                                <div class="col-6">
                                    <article class="thumbnail thumbnail-classic">
                                        <div class="thumbnail-classic-figure">
                                            <a href="{{ asset('images/abito-attuale.jpg') }}" data-lightgallery="item">
                                                <img src="{{ asset('images/abito-attuale.jpg') }}" alt="Abito attuale" width="170" height="170" loading="lazy">
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Curiosità -->
                        <div class="aside-abito-item mt-5">
                            <h5 class="aside-abito-title">{{ __('Curiosità') }}</h5>
                            <div class="quote-minimal">
                                <div class="quote-minimal-text">
                                    <p>{{ __('Ogni bottone della giacca è realizzato a mano e riporta lo stemma di Castello Tesino.') }}</p>
                                </div>
                            </div>
                            <div class="quote-minimal">
                                <div class="quote-minimal-text">
                                    <p>{{ __('I ricami del gilet sono ispirati ai fiori alpini che crescono sul Monte Agaro.') }}</p>
                                </div>
                            </div>
                            <div class="quote-minimal">
                                <div class="quote-minimal-text">
                                    <p>{{ __('La piuma sul cappello proviene da aquile che nidificano nelle Dolomiti del Tesino.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Museo -->
                        <div class="aside-abito-item mt-5">
                            <div class="box-cta">
                                <h5 class="box-cta-title">{{ __('Visita il Museo') }}</h5>
                                <p>{{ __('Presso il Museo Etnografico di Castello Tesino è possibile ammirare una collezione di abiti storici della banda.') }}</p>
                                <a class="button button-lg button-primary button-winona" href="https://www.museotesino.it" target="_blank">{{ __('Scopri di Più') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cura e Conservazione -->
    <section class="section section-sm section-last bg-default">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Cura e Conservazione') }}</span></h3>
            <div class="row row-30 justify-content-center">
                <div class="col-sm-6 col-lg-4">
                    <article class="box-minimal">
                        <div class="box-minimal-icon bi-brush-fill"></div>
                        <h5 class="box-minimal-title">{{ __('Manutenzione') }}</h5>
                        <div class="box-minimal-text">{{ __('Gli abiti vengono regolarmente controllati e sottoposti a manutenzione da parte di sarte specializzate in abiti tradizionali. Ogni dettaglio viene curato con attenzione per preservare l\'autenticità e la qualità dei materiali.') }}</div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-minimal">
                        <div class="box-minimal-icon bi-archive-fill"></div>
                        <h5 class="box-minimal-title">{{ __('Conservazione') }}</h5>
                        <div class="box-minimal-text">{{ __('Quando non vengono utilizzati, gli abiti sono conservati in apposite custodie in un ambiente controllato per prevenire danni da umidità, luce o insetti. Questo permette di preservare i colori e i materiali nel tempo.') }}</div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-minimal">
                        <div class="box-minimal-icon bi-people-fill"></div>
                        <h5 class="box-minimal-title">{{ __('Tradizione') }}</h5>
                        <div class="box-minimal-text">{{ __('La cura dell\'abito tradizionale è parte integrante della formazione di ogni nuovo membro della banda. Attraverso questo rituale, si trasmettono non solo le tecniche di manutenzione, ma anche il rispetto per la tradizione e l\'identità culturale che l\'abito rappresenta.') }}</div>
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
