@extends('layouts.app')

@section('title', 'Storia - Banda Folk di Castello Tesino')
@section('description', 'Scopri la storia della Banda Folk di Castello Tesino, un\'istituzione musicale con oltre 120 anni di tradizione nel Trentino.')
@section('og_title', 'Storia - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri la storia della Banda Folk di Castello Tesino, un\'istituzione musicale con oltre 120 anni di tradizione nel Trentino.')

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Storia') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Storia') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoStorica1.jpg') }});"></div>
        </div>
    </section>

    <!-- Storia Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center align-items-xl-center">
                <div class="col-md-10 col-lg-5 col-xl-6">
                    <div class="wow fadeInRight">
                        <img src="{{ asset('images/FotoStorica2.jpg') }}" alt="Banda Folk di Castello Tesino - Foto storica" width="519" height="564" loading="lazy">
                    </div>
                </div>
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <h2 class="title-decoration-lines-left">{{ __('Le Origini') }}</h2>
                    <p class="text-gray-800">{{ __('La Banda Folk di Castello Tesino nasce ufficialmente nel 1901, ma le sue radici affondano ancora più indietro nel tempo. Già nella seconda metà dell\'800, infatti, esisteva a Castello Tesino un gruppo di musicisti che si esibiva in occasione delle principali festività religiose e civili del paese.') }}</p>
                    <p class="text-gray-800">{{ __('La fondazione ufficiale avviene grazie all\'impegno del maestro Giovanni Broccato, che riunisce un gruppo di appassionati musicisti locali e dà vita alla prima formazione strutturata della banda. In quegli anni, la banda era composta principalmente da strumenti a fiato e percussioni, e il repertorio era incentrato su marce militari e brani della tradizione popolare trentina.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline -->
    <section class="section section-sm bg-default">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('La Nostra Storia') }}</span></h3>
            <div class="timeline-classic">
                <div class="timeline-classic-item">
                    <div class="timeline-classic-period"><span>1901-1915</span></div>
                    <div class="timeline-classic-main">
                        <h5 class="timeline-classic-title">{{ __('La Fondazione e i Primi Anni') }}</h5>
                        <p>{{ __('La Banda Folk viene fondata ufficialmente nel 1901 sotto la guida del maestro Giovanni Broccato. In questi primi anni, la banda si esibisce principalmente durante le feste patronali, le processioni religiose e gli eventi civili del paese. L\'attività viene interrotta con lo scoppio della Prima Guerra Mondiale, quando molti musicisti vengono chiamati al fronte.') }}</p>
                    </div>
                </div>
                <div class="timeline-classic-item">
                    <div class="timeline-classic-period"><span>1919-1939</span></div>
                    <div class="timeline-classic-main">
                        <h5 class="timeline-classic-title">{{ __('La Ripresa e il Periodo tra le Due Guerre') }}</h5>
                        <p>{{ __('Dopo la fine della Prima Guerra Mondiale, la banda riprende la sua attività sotto la direzione del maestro Antonio Sordo. In questo periodo, il repertorio si amplia includendo anche brani di musica classica e operistica. La banda partecipa a numerosi concorsi regionali, ottenendo importanti riconoscimenti. L\'attività viene nuovamente interrotta con lo scoppio della Seconda Guerra Mondiale.') }}</p>
                    </div>
                </div>
                <div class="timeline-classic-item">
                    <div class="timeline-classic-period"><span>1945-1970</span></div>
                    <div class="timeline-classic-main">
                        <h5 class="timeline-classic-title">{{ __('Il Dopoguerra e la Rinascita') }}</h5>
                        <p>{{ __('Nel dopoguerra, la banda riprende la sua attività sotto la guida del maestro Luigi Tessaro. Questo periodo è caratterizzato da un rinnovato entusiasmo e da un ampliamento dell\'organico. La banda inizia a partecipare a festival e manifestazioni anche al di fuori del Trentino, facendosi conoscere a livello nazionale. Nel 1965 viene istituita la prima scuola di musica per formare nuovi musicisti.') }}</p>
                    </div>
                </div>
                <div class="timeline-classic-item">
                    <div class="timeline-classic-period"><span>1970-2000</span></div>
                    <div class="timeline-classic-main">
                        <h5 class="timeline-classic-title">{{ __('L\'Espansione e l\'Internazionalizzazione') }}</h5>
                        <p>{{ __('Sotto la direzione del maestro Roberto Bianchi, la banda vive un periodo di grande espansione. Il repertorio si arricchisce di brani moderni e contemporanei, pur mantenendo un forte legame con la tradizione. In questi anni, la banda inizia a partecipare a festival internazionali, esibendosi in Austria, Germania, Francia e Svizzera. Nel 1985 viene registrato il primo disco, "Echi dal Tesino", contenente brani della tradizione trentina.') }}</p>
                    </div>
                </div>
                <div class="timeline-classic-item">
                    <div class="timeline-classic-period"><span>2000-Oggi</span></div>
                    <div class="timeline-classic-main">
                        <h5 class="timeline-classic-title">{{ __('Il Nuovo Millennio') }}</h5>
                        <p>{{ __('Con l\'arrivo del nuovo millennio, la Banda Folk di Castello Tesino continua a crescere e a rinnovarsi. Sotto la guida dell\'attuale maestro Marco Rossi, la banda ha ampliato ulteriormente il proprio repertorio, spaziando dalla musica tradizionale a quella contemporanea, dal folk al jazz. La scuola di musica è stata potenziata, permettendo l\'ingresso di numerosi giovani musicisti. Nel 2001 sono stati celebrati i 100 anni di attività con una serie di concerti ed eventi speciali. Oggi la banda conta circa 30 elementi e continua a essere un punto di riferimento culturale per Castello Tesino e per tutto il Trentino.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Photo Gallery -->
    <section class="section section-sm section-last bg-default text-md-left">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Galleria Storica') }}</span></h3>
            <div class="row row-30 justify-content-center" data-lightgallery="group">
                <div class="col-sm-6 col-lg-4">
                    <article class="thumbnail thumbnail-classic">
                        <div class="thumbnail-classic-figure">
                            <a href="{{ asset('images/FotoStorica3.jpg') }}" data-lightgallery="item">
                                <img src="{{ asset('images/FotoStorica3.jpg') }}" alt="Banda Folk di Castello Tesino - Foto storica 1" width="370" height="270" loading="lazy">
                            </a>
                        </div>
                        <div class="thumbnail-classic-caption">
                            <p class="thumbnail-classic-title">{{ __('La banda negli anni \'20') }}</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="thumbnail thumbnail-classic">
                        <div class="thumbnail-classic-figure">
                            <a href="{{ asset('images/FotoStorica4.jpg') }}" data-lightgallery="item">
                                <img src="{{ asset('images/FotoStorica4.jpg') }}" alt="Banda Folk di Castello Tesino - Foto storica 2" width="370" height="270" loading="lazy">
                            </a>
                        </div>
                        <div class="thumbnail-classic-caption">
                            <p class="thumbnail-classic-title">{{ __('Concerto del 1950') }}</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="thumbnail thumbnail-classic">
                        <div class="thumbnail-classic-figure">
                            <a href="{{ asset('images/FotoStorica5.jpg') }}" data-lightgallery="item">
                                <img src="{{ asset('images/FotoStorica5.jpg') }}" alt="Banda Folk di Castello Tesino - Foto storica 3" width="370" height="270" loading="lazy">
                            </a>
                        </div>
                        <div class="thumbnail-classic-caption">
                            <p class="thumbnail-classic-title">{{ __('Prima trasferta all\'estero, 1975') }}</p>
                        </div>
                    </article>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('galleria') }}" class="button button-primary button-winona">{{ __('Visita la Galleria Completa') }}</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section section-sm bg-default">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Testimonianze') }}</span></h3>
            <div class="row row-sm row-40 row-md-50">
                <div class="col-sm-6 col-md-4">
                    <article class="quote-modern">
                        <div class="quote-modern-text">
                            <div class="q">{{ __('Ho iniziato a suonare nella banda quando avevo solo 12 anni, nel 1960. Sono passati più di 60 anni e ancora oggi, quando sento le note della nostra marcia, mi emoziono come il primo giorno.') }}</div>
                        </div>
                        <h5 class="quote-modern-author">{{ __('Giuseppe Broccato') }}</h5>
                        <p class="quote-modern-status">{{ __('Musicista dal 1960') }}</p>
                    </article>
                </div>
                <div class="col-sm-6 col-md-4">
                    <article class="quote-modern">
                        <div class="quote-modern-text">
                            <div class="q">{{ __('La Banda Folk è stata per me una seconda famiglia. Ho imparato non solo a suonare uno strumento, ma anche il valore della disciplina, del lavoro di squadra e dell\'amicizia.') }}</div>
                        </div>
                        <h5 class="quote-modern-author">{{ __('Maria Tessaro') }}</h5>
                        <p class="quote-modern-status">{{ __('Musicista dal 1985') }}</p>
                    </article>
                </div>
                <div class="col-sm-6 col-md-4">
                    <article class="quote-modern">
                        <div class="quote-modern-text">
                            <div class="q">{{ __('Come sindaco di Castello Tesino, sono orgoglioso della nostra banda. È un patrimonio culturale che ha saputo rinnovarsi nel tempo, mantenendo vive le nostre tradizioni e portando il nome del nostro paese in tutta Europa.') }}</div>
                        </div>
                        <h5 class="quote-modern-author">{{ __('Paolo Rossi') }}</h5>
                        <p class="quote-modern-status">{{ __('Ex Sindaco di Castello Tesino') }}</p>
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
