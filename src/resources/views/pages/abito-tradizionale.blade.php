@extends('layouts.app')

@section('title', 'Abito Tradizionale - Banda Folk di Castello Tesino')
@section('description', 'Scopri la storia e i dettagli del costume tradizionale Tesino, un simbolo dell\'identità culturale della valle e della nostra banda.')
@section('og_title', 'Abito Tradizionale - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri la storia e i dettagli del costume tradizionale Tesino, un simbolo dell\'identità culturale della valle e della nostra banda.')

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('L\'Abito Tradizionale') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('L\'Abito Tradizionale') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoAbito1.jpg') }});"></div>
        </div>
    </section>

    <!-- Abito Tradizionale Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50 justify-content-center align-items-xl-center">
                <div class="col-md-10 col-lg-5 col-xl-6">
                    <div class="wow fadeInRight">
                        <img src="{{ asset('images/FotoAbito2.jpg') }}" alt="Abito Tradizionale della Banda Folk di Castello Tesino" width="519" height="564" loading="lazy">
                    </div>
                </div>
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <h2 class="title-decoration-lines-left">{{ __('Il Costume Tradizionale Tesino') }}</h2>
                    <p class="text-gray-800">{{ __('Disgiungere la storia del costume folkloristico tesino dall’epopea degli abitanti della valle, viaggiatori ambulanti in tutto il mondo a partire dall’inizio del 1600, sminuirebbe il significato di uno degli abiti più antichi ed interessanti dell’intero arco alpino.') }}</p>
                    <p class="text-gray-800">{{ __('Negli ultimi quattro secoli il costume tesino femminile si è progressivamente arricchito di dettagli portati dai tesini di ritorno dai loro viaggi oltralpe: scialli colorati, collane di granati, velluto francese e prezioso panno lenci.') }}</p>
                    <p class="text-gray-800">{{ __('Dal 1981 la Banda di Castello Tesino ha fatto proprio il costume tesino, sfoggiandolo con orgoglio e tramandando la testimonianza dell’antica cultura e storia della Valle del Tesino.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Elementi dell'Abito -->
    <section class="section section-sm bg-default">
        <div class="container">
            <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Elementi del Costume Femminile') }}</span></h3>
            <div class="row row-30">
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit-left"><div class="box-icon-classic-icon bi-person-standing-dress"></div></div>
                        <div class="unit-body">
                            <h5 class="box-icon-classic-title">{{ __('La Veste e il Dapè') }}</h5>
                            <p class="box-icon-classic-text">{{ __('Veste in panno nero con fitte pieghe, più lunga dietro. Si conclude con un “dapè” (balza) rosso o giallo, che indicava lo stato civile della donna.') }}</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit-left"><div class="box-icon-classic-icon bi-suit-heart-fill"></div></div>
                        <div class="unit-body">
                            <h5 class="box-icon-classic-title">{{ __('Il Salvacuore e la Finta') }}</h5>
                            <p class="box-icon-classic-text">{{ __('Una pettorina rigida in velluto nero (“salvacore”), decorata a mano, protegge il petto sopra una camiciola bianca ricamata (“finta”).') }}</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit-left"><div class="box-icon-classic-icon bi-palette-fill"></div></div>
                        <div class="unit-body">
                            <h5 class="box-icon-classic-title">{{ __('Grembiule e Scialle') }}</h5>
                            <p class="box-icon-classic-text">{{ __('Grembiule e scialle a frange, caratterizzati da vivaci motivi floreali multicolore su un elegante fondo scuro, portati dai viaggiatori.') }}</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit-left"><div class="box-icon-classic-icon bi-gem"></div></div>
                        <div class="unit-body">
                            <h5 class="box-icon-classic-title">{{ __('I Gioielli') }}</h5>
                            <p class="box-icon-classic-text">{{ __('Fili dispari di granati, spille e orecchini in filigrana d’oro a cestello (“piroli”) completano l’abito, incorniciando il viso.') }}</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit-left"><div class="box-icon-classic-icon bi-person-vcard"></div></div>
                        <div class="unit-body">
                            <h5 class="box-icon-classic-title">{{ __('L\'Acconciatura') }}</h5>
                            <p class="box-icon-classic-text">{{ __('I capelli, divisi da una scriminatura centrale, sono intrecciati a corona e ornati da una crestina in pizzo e spilloni, o raccolti in un “cucco”.') }}</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-icon-classic">
                        <div class="unit-left"><div class="box-icon-classic-icon bi-person-standing"></div></div>
                        <div class="unit-body">
                            <h5 class="box-icon-classic-title">{{ __('Il Costume Maschile') }}</h5>
                            <p class="box-icon-classic-text">{{ __('La versione maschile del costume è più recente, risale al secolo scorso e si ispira agli abiti tradizionali tirolesi.') }}</p>
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
                    <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">{{ __('Storia e Adozione') }}</span></h3>
                    <p>{{ __('La storia del costume è legata all\'epopea dei commercianti ambulanti tesini. Per secoli, il costume femminile si è evoluto, arricchendosi di elementi esotici portati a casa dai viaggiatori. La versione maschile è più recente e risale al secolo scorso. La Banda Folkloristica di Castello Tesino ha adottato ufficialmente questo abito nel 1981, diventando un\'ambasciatrice della cultura e della storia locale. Questo abito non è solo un\'uniforme, ma un simbolo vivente della resilienza, dei viaggi e delle tradizioni della Valle del Tesino.') }}</p>
                </div>
                <div class="col-md-10 col-lg-4">
                    <div class="aside-abito">
                        <!-- Museo -->
                        <div class="aside-abito-item mt-5">
                            <div class="box-cta">
                                <h5 class="box-cta-title">{{ __('Visita il Museo') }}</h5>
                                <p>{{ __('Presso il Museo Etnografico di Castello Tesino è possibile ammirare una collezione di abiti storici.') }}</p>
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
                        <div class="box-minimal-text">{{ __('Gli abiti vengono regolarmente controllati e sottoposti a manutenzione da parte di sarte specializzate in abiti tradizionali per preservare l\'autenticità e la qualità dei materiali.') }}</div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-minimal">
                        <div class="box-minimal-icon bi-archive-fill"></div>
                        <h5 class="box-minimal-title">{{ __('Conservazione') }}</h5>
                        <div class="box-minimal-text">{{ __('Quando non utilizzati, gli abiti sono conservati in apposite custodie in un ambiente controllato per proteggerli da umidità, luce e insetti, preservando colori e materiali.') }}</div>
                    </article>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <article class="box-minimal">
                        <div class="box-minimal-icon bi-people-fill"></div>
                        <h5 class="box-minimal-title">{{ __('Tradizione') }}</h5>
                        <div class="box-minimal-text">{{ __('La cura dell\'abito è parte integrante della formazione di ogni membro. Si trasmettono le tecniche di manutenzione e il rispetto per la tradizione e l\'identità culturale che l\'abito rappresenta.') }}</div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
{{-- Scripts for lightgallery can be added here if needed --}}
@endsection
