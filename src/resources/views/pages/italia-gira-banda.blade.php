@extends('layouts.app')

@section('title', 'Italia Gira Banda - Banda Folk di Castello Tesino')
@section('description', 'Scopri il progetto "Italia Gira Banda", un\'iniziativa nazionale che coinvolge la Banda Folk di Castello Tesino e altre formazioni bandistiche italiane.')
@section('og_title', 'Italia Gira Banda - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri il progetto "Italia Gira Banda", un\'iniziativa nazionale che coinvolge la Banda Folk di Castello Tesino e altre formazioni bandistiche italiane.')

@section('styles')
<style>
    .event-card {
        margin-bottom: 30px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .event-card:hover {
        transform: translateY(-5px);
    }
    .event-card-header {
        position: relative;
        overflow: hidden;
    }
    .event-card-header img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .event-card:hover .event-card-header img {
        transform: scale(1.05);
    }
    .event-card-date {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: rgba(1, 179, 167, 0.9);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }
    .event-card-body {
        padding: 20px;
        background-color: #fff;
    }
    .event-card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .event-card-location {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        color: #777;
    }
    .event-card-location i {
        margin-right: 5px;
        color: #01b3a7;
    }
    .event-card-description {
        margin-bottom: 15px;
        font-size: 14px;
        color: #555;
    }
    .partner-logo {
        height: 80px;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    .partner-logo:hover {
        filter: grayscale(0%);
        opacity: 1;
    }
    .map-container {
        height: 400px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Italia Gira Banda') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Italia Gira Banda') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/italia-gira-banda-header.jpg') }});"></div>
        </div>
    </section>

    <!-- Progetto Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center align-items-xl-center">
                <div class="col-md-10 col-lg-5 col-xl-6">
                    <div class="wow fadeInRight">
                        <img src="{{ asset('images/italia-gira-banda-logo.jpg') }}" alt="Logo Italia Gira Banda" width="519" height="564" loading="lazy">
                    </div>
                </div>
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <h2 class="title-decoration-lines-left">{{ __('Il Progetto') }}</h2>
                    <p class="text-gray-800">{{ __('Italia Gira Banda è un\'iniziativa nazionale nata nel 2018 con l\'obiettivo di valorizzare e promuovere il patrimonio culturale rappresentato dalle bande musicali italiane. Il progetto coinvolge oltre 100 formazioni bandistiche da tutta Italia, creando una rete di scambio culturale e musicale senza precedenti.') }}</p>
                    <p class="text-gray-800">{{ __('La Banda Folk di Castello Tesino partecipa attivamente al progetto dal 2019, ospitando bande provenienti da altre regioni italiane e portando la propria musica e le proprie tradizioni in giro per l\'Italia.') }}</p>
                    <p class="text-gray-800">{{ __('Attraverso concerti, masterclass, workshop e scambi culturali, Italia Gira Banda mira a:') }}</p>
                    <ul class="list-marked">
                        <li>{{ __('Preservare e valorizzare il patrimonio musicale bandistico italiano') }}</li>
                        <li>{{ __('Favorire lo scambio di esperienze tra musicisti di diverse regioni') }}</li>
                        <li>{{ __('Promuovere il turismo culturale nei piccoli centri') }}</li>
                        <li>{{ __('Coinvolgere i giovani nella pratica musicale bandistica') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Eventi Passati -->
    <section class="section section-sm bg-default">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Eventi Passati') }}</span></h3>
            <div class="row row-30">
                <div class="col-md-6 col-lg-4">
                    <div class="event-card">
                        <div class="event-card-header">
                            <img src="{{ asset('images/italia-gira-banda-event1.jpg') }}" alt="Evento Italia Gira Banda a Castello Tesino">
                            <div class="event-card-date">15-17 Luglio 2022</div>
                        </div>
                        <div class="event-card-body">
                            <h5 class="event-card-title">{{ __('Festival delle Bande di Montagna') }}</h5>
                            <div class="event-card-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>Castello Tesino, Trentino</span>
                            </div>
                            <p class="event-card-description">{{ __('Un weekend di musica e tradizioni con la partecipazione della Banda Musicale di Aosta e della Banda Cittadina di Cortina d\'Ampezzo.') }}</p>
                            <a href="{{ route('galleria') }}" class="button button-sm button-default-outline-2 button-wapasha">{{ __('Guarda le Foto') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="event-card">
                        <div class="event-card-header">
                            <img src="{{ asset('images/italia-gira-banda-event2.jpg') }}" alt="Evento Italia Gira Banda a Palermo">
                            <div class="event-card-date">10-12 Settembre 2021</div>
                        </div>
                        <div class="event-card-body">
                            <h5 class="event-card-title">{{ __('Incontro delle Tradizioni') }}</h5>
                            <div class="event-card-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>Palermo, Sicilia</span>
                            </div>
                            <p class="event-card-description">{{ __('La nostra banda ha portato le melodie e le tradizioni trentine in Sicilia, esibendosi insieme alla Banda Musicale di Palermo.') }}</p>
                            <a href="{{ route('galleria') }}" class="button button-sm button-default-outline-2 button-wapasha">{{ __('Guarda le Foto') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="event-card">
                        <div class="event-card-header">
                            <img src="{{ asset('images/italia-gira-banda-event3.jpg') }}" alt="Evento Italia Gira Banda a Matera">
                            <div class="event-card-date">20-22 Maggio 2020</div>
                        </div>
                        <div class="event-card-body">
                            <h5 class="event-card-title">{{ __('Bande nei Sassi') }}</h5>
                            <div class="event-card-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>Matera, Basilicata</span>
                            </div>
                            <p class="event-card-description">{{ __('Un evento speciale nella città dei Sassi, con concerti e sfilate che hanno visto la partecipazione di 5 bande da tutta Italia.') }}</p>
                            <a href="{{ route('galleria') }}" class="button button-sm button-default-outline-2 button-wapasha">{{ __('Guarda le Foto') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Prossimi Eventi -->
    <section class="section section-sm bg-default text-md-left">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Prossimi Eventi') }}</span></h3>
            <div class="row row-50 justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="box-event">
                        <div class="box-event-date">
                            <div class="box-event-date-day">12-14</div>
                            <div class="box-event-date-month">Agosto</div>
                        </div>
                        <div class="box-event-body">
                            <h4 class="box-event-title">{{ __('Festival delle Dolomiti') }}</h4>
                            <div class="box-event-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>Castello Tesino, Trentino</span>
                            </div>
                            <p class="box-event-description">{{ __('Un weekend di musica e tradizioni con la partecipazione della Banda Musicale di Cortina d\'Ampezzo e della Banda Cittadina di Bolzano. Concerti, sfilate e workshop per tutte le età.') }}</p>
                            <div class="box-event-button">
                                <a class="button button-primary button-winona" href="{{ route('eventi') }}">{{ __('Dettagli Evento') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-event">
                        <div class="box-event-date">
                            <div class="box-event-date-day">23-25</div>
                            <div class="box-event-date-month">Settembre</div>
                        </div>
                        <div class="box-event-body">
                            <h4 class="box-event-title">{{ __('Melodie del Sud') }}</h4>
                            <div class="box-event-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>Lecce, Puglia</span>
                            </div>
                            <p class="box-event-description">{{ __('La nostra banda parteciperà a questo importante festival nel cuore del Salento, portando le melodie e le tradizioni trentine in Puglia. Un\'occasione unica per uno scambio culturale tra Nord e Sud Italia.') }}</p>
                            <div class="box-event-button">
                                <a class="button button-primary button-winona" href="{{ route('eventi') }}">{{ __('Dettagli Evento') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-event">
                        <div class="box-event-date">
                            <div class="box-event-date-day">15-17</div>
                            <div class="box-event-date-month">Ottobre</div>
                        </div>
                        <div class="box-event-body">
                            <h4 class="box-event-title">{{ __('Incontro Nazionale Italia Gira Banda') }}</h4>
                            <div class="box-event-location">
                                <i class="bi bi-geo-alt"></i>
                                <span>Roma, Lazio</span>
                            </div>
                            <p class="box-event-description">{{ __('L\'evento annuale che riunisce tutte le bande partecipanti al progetto. Tre giorni di musica, workshop, dibattiti e concerti nel cuore della capitale.') }}</p>
                            <div class="box-event-button">
                                <a class="button button-primary button-winona" href="{{ route('eventi') }}">{{ __('Dettagli Evento') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-10 col-lg-4">
                    <div class="aside-events">
                        <!-- Mappa -->
                        <div class="aside-events-item">
                            <h5 class="aside-events-title">{{ __('La Mappa del Progetto') }}</h5>
                            <div class="map-container">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5551971.488506595!2d7.9699397672656245!3d41.87592867620403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12d4fe82448dd203%3A0xe22cf55c24635e6f!2sItaly!5e0!3m2!1sen!2sit!4v1657536236428!5m2!1sen!2sit" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <p class="text-muted mt-2">{{ __('Le località coinvolte nel progetto Italia Gira Banda') }}</p>
                        </div>
                        
                        <!-- Statistiche -->
                        <div class="aside-events-item mt-5">
                            <h5 class="aside-events-title">{{ __('Il Progetto in Numeri') }}</h5>
                            <div class="row row-30">
                                <div class="col-6">
                                    <div class="counter-classic">
                                        <div class="counter-classic-number"><span class="counter">120</span>+</div>
                                        <h5 class="counter-classic-title">{{ __('Bande Coinvolte') }}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="counter-classic">
                                        <div class="counter-classic-number"><span class="counter">20</span></div>
                                        <h5 class="counter-classic-title">{{ __('Regioni') }}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="counter-classic">
                                        <div class="counter-classic-number"><span class="counter">250</span>+</div>
                                        <h5 class="counter-classic-title">{{ __('Eventi') }}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="counter-classic">
                                        <div class="counter-classic-number"><span class="counter">5000</span>+</div>
                                        <h5 class="counter-classic-title">{{ __('Musicisti') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Download -->
                        <div class="aside-events-item mt-5">
                            <div class="box-cta">
                                <h5 class="box-cta-title">{{ __('Scarica la Brochure') }}</h5>
                                <p>{{ __('Tutte le informazioni sul progetto Italia Gira Banda in un unico documento.') }}</p>
                                <a class="button button-lg button-primary button-winona" href="{{ asset('assets/docs/brochure-italia-gira-banda.pdf') }}" target="_blank">{{ __('Download PDF') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partner -->
    <section class="section section-sm section-last bg-default">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Partner del Progetto') }}</span></h3>
            <div class="row row-30 justify-content-center">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="#" class="box-sponsor">
                        <img class="partner-logo" src="{{ asset('images/partner-1.png') }}" alt="Ministero della Cultura" loading="lazy">
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="#" class="box-sponsor">
                        <img class="partner-logo" src="{{ asset('images/partner-2.png') }}" alt="ANBIMA" loading="lazy">
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="#" class="box-sponsor">
                        <img class="partner-logo" src="{{ asset('images/partner-3.png') }}" alt="Federazione Bande Italiane" loading="lazy">
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="#" class="box-sponsor">
                        <img class="partner-logo" src="{{ asset('images/partner-4.png') }}" alt="Regione Trentino Alto Adige" loading="lazy">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="section section-sm bg-default">
        <div class="container">
            <div class="box-cta">
                <div class="box-cta-inner">
                    <h3>{{ __('Vuoi Partecipare al Progetto?') }}</h3>
                    <p>{{ __('Se sei un musicista o fai parte di una banda e vuoi partecipare al progetto Italia Gira Banda, contattaci per maggiori informazioni.') }}</p>
                </div>
                <div class="box-cta-inner">
                    <a class="button button-lg button-primary button-winona" href="{{ route('contatti') }}">{{ __('Contattaci') }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/waypoints@4.0.1/lib/jquery.waypoints.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/counterup2@2.0.2/dist/index.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize counter
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const countUp = new CountUp(counter, counter.textContent);
            
            new Waypoint({
                element: counter,
                handler: function() {
                    countUp.start();
                    this.destroy();
                },
                offset: 'bottom-in-view'
            });
        });
    });
</script>
@endsection
