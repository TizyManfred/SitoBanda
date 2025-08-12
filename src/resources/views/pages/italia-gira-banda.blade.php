@extends('layouts.app')

@section('title', 'Italia Gira Banda - Banda Folk di Castello Tesino')
@section('description', 'Scopri il progetto "Italia Gira Banda", un\'iniziativa nazionale che coinvolge la Banda Folk di Castello Tesino e altre formazioni bandistiche italiane.')
@section('og_title', 'Italia Gira Banda - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri il progetto "Italia Gira Banda", un\'iniziativa nazionale che coinvolge la Banda Folk di Castello Tesino e altre formazioni bandistiche italiane.')

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
