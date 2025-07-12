@extends('layouts.app')

@section('title', 'Organico - Banda Folk di Castello Tesino')
@section('description', 'Scopri i musicisti e le sezioni strumentali che compongono la Banda Folk di Castello Tesino.')
@section('og_title', 'Organico - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri i musicisti e le sezioni strumentali che compongono la Banda Folk di Castello Tesino.')

@section('styles')
<style>
    .section-card {
        margin-bottom: 40px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .section-header {
        background-color: #01b3a7;
        color: white;
        padding: 20px;
        position: relative;
    }
    .section-header h4 {
        margin: 0;
        font-weight: 600;
    }
    .section-icon {
        font-size: 24px;
        margin-right: 10px;
        vertical-align: middle;
    }
    .section-body {
        padding: 20px;
        background-color: #fff;
    }
    .member-item {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    .member-item:last-child {
        border-bottom: none;
    }
    .member-name {
        font-weight: 500;
    }
    .member-role {
        color: #777;
        font-size: 14px;
    }
    .section-count {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 5px 15px;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Organico') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Organico') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoSanIppolito1.jpg') }});"></div>
        </div>
    </section>

    <!-- Organico Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('I Nostri Musicisti') }}</span></h3>
                    <p class="text-gray-800">{{ __('La Banda Folk di Castello Tesino è composta da musicisti di diverse età e background, uniti dalla passione per la musica. Ogni sezione strumentale contribuisce con il proprio timbro e colore alla creazione del suono caratteristico della nostra banda.') }}</p>
                    
                    @if($sections->count() > 0)
                        @foreach($sections as $section)
                            <div class="section-card">
                                <div class="section-header">
                                    <h4>
                                        @if($section->icon_class)
                                            <i class="section-icon {{ $section->icon_class }}"></i>
                                        @endif
                                        {{ $section->name }}
                                    </h4>
                                    <span class="section-count">{{ $section->members->count() }} {{ __('musicisti') }}</span>
                                </div>
                                <div class="section-body">
                                    @if($section->members->count() > 0)
                                        @foreach($section->members->sortBy('display_order') as $member)
                                            <div class="member-item">
                                                <div class="member-name">{{ $member->first_name }} {{ $member->last_name }}</div>
                                                @if($member->role)
                                                    <div class="member-role">{{ $member->role }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">{{ __('Nessun musicista in questa sezione.') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            {{ __('Non ci sono sezioni disponibili al momento.') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-md-10 col-lg-4 col-xl-5">
                    <div class="aside-organico">
                        <!-- Maestro -->
                        <div class="aside-organico-item">
                            <h4 class="aside-organico-title">{{ __('Il Maestro') }}</h4>
                            <div class="team-classic team-classic-sm">
                                <figure class="team-classic-figure">
                                    <img src="{{ asset('images/maestro.jpg') }}" alt="Maestro della Banda Folk di Castello Tesino" width="370" height="370" loading="lazy">
                                </figure>
                                <div class="team-classic-caption">
                                    <h5 class="team-classic-name">Marco Rossi</h5>
                                    <p class="team-classic-status">{{ __('Maestro dal 2010') }}</p>
                                    <p class="team-classic-text">{{ __('Diplomato al Conservatorio di Trento in direzione d\'orchestra, ha una lunga esperienza nella direzione di formazioni bandistiche. Ha portato innovazione nel repertorio della banda, pur mantenendo un forte legame con la tradizione.') }}</p>
                                    <a class="button button-sm button-default-outline-2 button-wapasha" href="{{ route('maestro') }}">{{ __('Biografia Completa') }}</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="aside-organico-item mt-5">
                            <h4 class="aside-organico-title">{{ __('La Banda in Numeri') }}</h4>
                            <div class="row row-30">
                                <div class="col-6">
                                    <div class="counter-classic">
                                        <div class="counter-classic-number"><span class="counter">{{ $sections->count() }}</span></div>
                                        <h5 class="counter-classic-title">{{ __('Sezioni') }}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="counter-classic">
                                        <div class="counter-classic-number"><span class="counter">{{ $totalMembers }}</span></div>
                                        <h5 class="counter-classic-title">{{ __('Musicisti') }}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="counter-classic">
                                        <div class="counter-classic-number"><span class="counter">122</span></div>
                                        <h5 class="counter-classic-title">{{ __('Anni di Storia') }}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="counter-classic">
                                        <div class="counter-classic-number"><span class="counter">30</span>+</div>
                                        <h5 class="counter-classic-title">{{ __('Concerti all\'Anno') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Join Us -->
                        <div class="aside-organico-item mt-5">
                            <div class="box-cta">
                                <h4 class="box-cta-title">{{ __('Unisciti a Noi!') }}</h4>
                                <p>{{ __('Sei appassionato di musica? Vuoi imparare a suonare uno strumento o far parte della nostra banda?') }}</p>
                                <a class="button button-lg button-primary button-winona" href="{{ route('contatti') }}">{{ __('Contattaci') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section section-sm bg-default">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Cosa Dicono i Nostri Musicisti') }}</span></h3>
            <div class="row row-sm row-40 row-md-50">
                <div class="col-sm-6 col-md-4">
                    <article class="quote-modern">
                        <div class="quote-modern-text">
                            <div class="q">{{ __('Far parte della banda mi ha permesso di crescere non solo come musicista, ma anche come persona. Ho trovato amici che condividono la mia stessa passione.') }}</div>
                        </div>
                        <h5 class="quote-modern-author">{{ __('Laura Bianchi') }}</h5>
                        <p class="quote-modern-status">{{ __('Clarinetto') }}</p>
                    </article>
                </div>
                <div class="col-sm-6 col-md-4">
                    <article class="quote-modern">
                        <div class="quote-modern-text">
                            <div class="q">{{ __('Suonare nella banda è un\'esperienza unica. La sensazione di creare musica insieme ad altri musicisti è qualcosa di magico che ti resta dentro.') }}</div>
                        </div>
                        <h5 class="quote-modern-author">{{ __('Marco Verdi') }}</h5>
                        <p class="quote-modern-status">{{ __('Tromba') }}</p>
                    </article>
                </div>
                <div class="col-sm-6 col-md-4">
                    <article class="quote-modern">
                        <div class="quote-modern-text">
                            <div class="q">{{ __('Ho iniziato a suonare nella banda quando avevo 10 anni. Oggi, dopo 15 anni, non potrei immaginare la mia vita senza questa grande famiglia musicale.') }}</div>
                        </div>
                        <h5 class="quote-modern-author">{{ __('Andrea Neri') }}</h5>
                        <p class="quote-modern-status">{{ __('Percussioni') }}</p>
                    </article>
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
