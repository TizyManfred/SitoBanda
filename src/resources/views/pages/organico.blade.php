@extends('layouts.app')

@section('title', 'Organico - Banda Folk di Castello Tesino')
@section('description', 'Scopri i musicisti e le sezioni strumentali che compongono la Banda Folk di Castello Tesino.')
@section('og_title', 'Organico - Banda Folk di Castello Tesino')
@section('og_description', 'Scopri i musicisti e le sezioni strumentali che compongono la Banda Folk di Castello Tesino.')

@section('styles')
<style>
    .section-image-container {
        height: 360px; /* Reduced by 20% from 450px */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .section-image-container .slick-slider,
    .section-image-container .slick-list,
    .section-image-container .slick-track,
    .section-image-container .slick-slide,
    .section-image-container .slick-slide > div,
    .section-image-container .thumbnail-classic,
    .section-image-container .thumbnail-classic figure,
    .section-image-container img {
        height: 100% !important;
        width: 100% !important;
        object-fit: cover;
    }
    .card-body {
        max-height: 380px; /* Adjusted to fit the new layout */
        overflow-y: auto;
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h2 class="breadcrumbs-custom-title">Organico</h2>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="/">Home</a></li>
                    <li class="active">Organico</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url('/images/FotoOrganico1.jpg');"></div>
        </div>
    </section>


    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-xl-9 pr-xl-5">
                <!-- Organico Intro -->
                <section class="section section-sm section-first bg-default text-md-left">
                    <div class="container">
                        <div class="row row-30">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12 text-md-left">
                                        <h2 class="title-decoration-lines-left">{{ __('I Nostri Musicisti') }}</h2>
                                        <p class="text-gray-800">{{ __('La Banda Folk di Castello Tesino è composta da musicisti di diverse età e background, uniti dalla passione per la musica. Ogni sezione strumentale contribuisce con il proprio timbro e colore alla creazione del suono caratteristico della nostra banda.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sections Loop -->
                @if(isset($sections) && count($sections) > 0)
                    @foreach($sections as $section)
                        <section class="section section-sm {{ $loop->odd ? 'bg-gray-100' : 'bg-default' }}">
                            <div class="container">
                                <div class="row row-50 justify-content-center align-items-xl-center">
                                    <div class="col-md-10 col-lg-6 col-xl-6 {{ $loop->even ? 'order-lg-2' : '' }}">
                                        <div class="wow fadeInRight" >
                                            @if(isset($section->images) && $section->images->count() > 0)
                                                <div id="gallery-{{ $section->id }}" class="carousel slide" data-ride="carousel" data-interval="{{ random_int(2000, 4000) }}" data-lightgallery="group">
                                                    <div class="carousel-inner" style="overflow: hidden;">
                                                        @foreach($section->images as $index => $image)
                                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="height: 350px;">
                                                                <a href="/storage/{{ $image->image_path }}" 
                                                                data-lightgallery="item"
                                                                >
                                                                    <img src="/storage/{{ $image->image_path }}" 
                                                                        class="d-block w-100 h-100"
                                                                        alt="{{ $image->caption ?? 'Sezione musicale' }} - Immagine {{ $loop->iteration }}" 
                                                                        loading="lazy"
                                                                        style="object-fit: cover; cursor: pointer;"
                                                                    >
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if($section->images->count() > 1)
                                                        <a class="carousel-control-prev" href="#gallery-{{ $section->id }}" role="button" data-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Precedente</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#gallery-{{ $section->id }}" role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Successiva</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <div style="height: 350px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 8px;">
                                                    <span class="text-muted">Nessuna immagine disponibile</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-lg-6 col-xl-6">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                                <h4 class="mb-0">
                                                    @if(isset($section->icon_class) && $section->icon_class)
                                                        <i class="{{ $section->icon_class }} me-2"></i>
                                                    @endif
                                                    {{ $section->name ?? 'Sezione senza nome' }}
                                                </h4>
                                                <span class="badge bg-white text-primary">{{ is_countable($section->members) ? count($section->members) : 0 }} Musicisti</span>
                                            </div>
                                            <div class="card-body p-0">
                                                @if(isset($section->members) && count($section->members) > 0)
                                                    @php
                                                        $members = $section->members->sortBy('last_name')->sortBy('first_name');
                                                    @endphp
                                                    <div class="list-group list-group-flush">
                                                        @foreach($members as $member)
                                                            <div class="list-group-item border-0 py-3 px-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3 text-muted">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <span class="font-weight-bold">{{ $member->first_name }} {{ $member->last_name }}</span>
                                                                            @if(isset($member->instrument) && $member->instrument)
                                                                                <span class="badge bg-light text-dark ms-2">{{ $member->instrument }}</span>
                                                                            @endif
                                                                        </div>
                                                                        @if(isset($member->role) && $member->role)
                                                                            <div class="small text-muted mt-1">{{ $member->role }}</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="p-4 text-center text-muted">
                                                        <i class="fas fa-info-circle me-2"></i>Nessun musicista in questa sezione.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endforeach
                @else
                    <section class="section section-sm bg-default text-center">
                        <div class="container">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Le sezioni e i musicisti non sono ancora stati caricati. Torna a trovarci presto!
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Join Us CTA -->
                <section class="section section-sm bg-gray-100">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8 text-center">
                                <div class="box-cta">
                                    <h3 class="box-cta-title">Vuoi far parte della nostra banda?</h3>
                                    <p class="box-cta-text">Cerchiamo sempre nuovi talenti! Contattaci per informazioni su come unirti a noi.</p>
                                    <a class="button button-primary button-pipaluk" href="{{ route('contatti') }}">Contattaci</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Sidebar -->
            <div class="col-xl-3">
                @include('partials.aside')
            </div>
        </div>
    </div>
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
