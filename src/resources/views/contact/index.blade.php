@extends('layouts.app')

@section('title', 'Contatti - Banda Folk di Castello Tesino')
@section('description', 'Contatta la Banda Folk di Castello Tesino per informazioni su eventi, corsi di musica o collaborazioni.')
@section('og_title', 'Contatti - Banda Folk di Castello Tesino')
@section('og_description', 'Contatta la Banda Folk di Castello Tesino per informazioni su eventi, corsi di musica o collaborazioni.')

@section('styles')
<style>
    .contact-form {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }
    .form-input {
        height: 50px;
        padding: 10px 20px;
    }
    .form-label {
        font-weight: 500;
    }
    .contact-info-item {
        margin-bottom: 30px;
    }
    .contact-info-icon {
        font-size: 24px;
        color: #01b3a7;
        margin-right: 15px;
    }
    .g-recaptcha {
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('Contatti') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="active">{{ __('Contatti') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ asset('images/FotoSanIppolito1.webp') }});"></div>
        </div>
    </section>

    <!-- Contact Form and Info -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-5">
                    <div class="inset-right-1">
                        <h3>{{ __('Informazioni di Contatto') }}</h3>
                        <p>{{ __('Hai domande sulla Banda Folk di Castello Tesino? Vuoi partecipare ai nostri corsi di musica o richiedere informazioni sui nostri eventi? Contattaci utilizzando il modulo o i recapiti qui sotto.') }}</p>
                        
                        <div class="contact-info mt-4">
                            <div class="contact-info-item d-flex align-items-center">
                                <div class="contact-info-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="contact-info-text">
                                    <h5>{{ __('Indirizzo') }}</h5>
                                    <p>Via Roma 12, 38053 Castello Tesino (TN)</p>
                                </div>
                            </div>
                            
                            <div class="contact-info-item d-flex align-items-center">
                                <div class="contact-info-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div class="contact-info-text">
                                    <h5>{{ __('Telefono') }}</h5>
                                    <p><a href="tel:+393401234567">+39 340 123 4567</a></p>
                                </div>
                            </div>
                            
                            <div class="contact-info-item d-flex align-items-center">
                                <div class="contact-info-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="contact-info-text">
                                    <h5>{{ __('Email') }}</h5>
                                    <p><a href="mailto:info@bandafolk.it">info@bandafolk.it</a></p>
                                </div>
                            </div>
                            
                            <div class="contact-info-item d-flex align-items-center">
                                <div class="contact-info-icon">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="contact-info-text">
                                    <h5>{{ __('Orari Prove') }}</h5>
                                    <p>{{ __('Venerdì: 20:30 - 22:30') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="social-links mt-4">
                            <h5>{{ __('Seguici sui Social') }}</h5>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="https://www.facebook.com/bandafolk" target="_blank" aria-label="Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://www.instagram.com/bandafolk" target="_blank" aria-label="Instagram">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://www.youtube.com/bandafolk" target="_blank" aria-label="YouTube">
                                        <i class="bi bi-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <h3>{{ __('Inviaci un Messaggio') }}</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form class="contact-form rd-form" method="POST" action="{{ route('contatti.store') }}">
                        @csrf
                        <div class="row row-20">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">{{ __('Nome e Cognome') }} *</label>
                                    <input class="form-control form-input @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="email">{{ __('Email') }} *</label>
                                    <input class="form-control form-input @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="subject">{{ __('Oggetto') }} *</label>
                                    <input class="form-control form-input @error('subject') is-invalid @enderror" id="subject" type="text" name="subject" value="{{ old('subject') }}" required>
                                    @error('subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="message">{{ __('Messaggio') }} *</label>
                                    <textarea class="form-control form-input @error('message') is-invalid @enderror" id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                    @error('g-recaptcha-response')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input @error('privacy_policy') is-invalid @enderror" id="privacy_policy" name="privacy_policy" required>
                                    <label class="form-check-label" for="privacy_policy">
                                        {{ __('Ho letto e accetto la') }} <a href="{{ route('privacy-policy') }}" target="_blank">{{ __('Privacy Policy') }}</a> *
                                    </label>
                                    @error('privacy_policy')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 mt-3">
                                <button class="button button-primary button-pipaluk" type="submit">{{ __('Invia Messaggio') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map -->
    <section class="section section-sm section-last">
        <div class="container">
            <h3 class="text-center mb-4">{{ __('Dove Siamo') }}</h3>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2773.9762024893257!2d11.628333!3d46.064722!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDXCsDAzJzUzLjAiTiAxMcKwMzcnNDIuMCJF!5e0!3m2!1sit!2sit!4v1625764842986!5m2!1sit!2sit" 
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" 
                    title="Mappa della sede della Banda Folk di Castello Tesino"></iframe>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
