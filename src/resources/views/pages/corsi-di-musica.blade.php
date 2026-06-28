@extends('layouts.app')

@section('title', __('corsi-di-musica.meta.title'))
@section('description', __('corsi-di-musica.meta.description'))
@section('og_title', __('corsi-di-musica.meta.og_title'))
@section('og_description', __('corsi-di-musica.meta.og_description'))

@section('content')
    @php($dynamicBlocks = \App\Models\StaticPage::contentBlocks('corsi_di_musica'))

    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('corsi-di-musica.title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('header.home') }}</a></li>
                    <li class="active">{{ __('corsi-di-musica.title') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ \App\Models\StaticPage::headerImageUrl('corsi_di_musica', 'images/FotoShanghai1.webp') }});"></div>
        </div>
    </section>

    <!-- Corsi di Musica Content -->
    @if ($dynamicBlocks !== [])
        <div class="container py-5">
            @include('partials.static-page-content', ['blocks' => $dynamicBlocks])
        </div>
    @else
    <section class="section section-sm section-first bg-default text-left">
        <div class="container">
            <div class="row row-50">
                <!-- Main Text -->
                <div class="col-lg-10 col-xl-8">
                    <div class="container">
                        <h2 class="title-decoration-lines-left">{{ __('corsi-di-musica.content.heading') }}</h2>
                        <div class="row row-50">
                            <div class="col-lg-6 col-xl-6">
                                <div class="figure-classic figure-classic-left">
                                    <img src="{{ \App\Models\StaticPage::contentImageUrl('corsi_di_musica', 'images/FotoTrento1.webp', 0) }}" alt="{{ __('corsi-di-musica.content.image_alt') }}" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6">
                                <p>{{ __('corsi-di-musica.content.paragraph_1') }}</p>
                                <p>{{ __('corsi-di-musica.content.paragraph_2') }}</p>
                                <p>{{ __('corsi-di-musica.content.paragraph_3') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-10 col-xl-4">
                    <div class="aside-component">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('corsi-di-musica.sidebar.enrollment_title') }}</h4>
                            </div>
                            <div class="card-body">
                                <p><strong>{{ __('corsi-di-musica.sidebar.expiration_label') }}</strong><br>
                                {{ \Carbon\Carbon::parse(\App\Helpers\SettingsHelper::coursesInfo()['expiration_date'])->translatedFormat('d F Y') }}</p>
                                
                                <p><strong>{{ __('corsi-di-musica.sidebar.period_label') }}</strong><br>
                                da {{ \Carbon\Carbon::parse(\App\Helpers\SettingsHelper::coursesInfo()['start_date'])->translatedFormat('F') }} a {{ \Carbon\Carbon::parse(\App\Helpers\SettingsHelper::coursesInfo()['end_date'])->translatedFormat('F') }}</p>
                                
                                <p><strong>{{ __('corsi-di-musica.sidebar.fees_label') }}</strong><br>
                                {!! nl2br(\App\Helpers\SettingsHelper::coursesInfo()['price']) !!}
                                
                                <p><strong>{{ __('corsi-di-musica.sidebar.info_label') }}</strong><br>
                                <a href="mailto:{{ \App\Helpers\SettingsHelper::coursesInfo()['contact_email'] }}">{{ \App\Helpers\SettingsHelper::coursesInfo()['contact_email'] }}</a><br>
                                {{ __('corsi-di-musica.sidebar.phone_label') }} {{ \App\Helpers\SettingsHelper::coursesInfo()['phone'] }}</p>
                                
                                <div class="mt-4">
                                    <a href="{{ \App\Helpers\SettingsHelper::coursesInfo()['forms_link'] }}" class="button button-primary button-ujarak w-100">{{ __('corsi-di-musica.sidebar.cta') }}</a>
                                </div>
                            </div>
                        </div>
                        
                        @if(isset(\App\Helpers\SettingsHelper::coursesInfo()['testimonials']) && count(\App\Helpers\SettingsHelper::coursesInfo()['testimonials']) > 0)
                        <!-- Testimonials -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4 class="mb-0">{{ __('corsi-di-musica.sidebar.testimonials_title') }}</h4>
                            </div>
                            <ul class="list-group list-group-flush">
                                @foreach (\App\Helpers\SettingsHelper::coursesInfo()['testimonials'] as $testimonial)
                                    <li class="list-group-item">
                                        <blockquote class="mb-1">{!! nl2br($testimonial['text']) !!}</blockquote>
                                        <small class="text-muted d-block">— {{ $testimonial['name'] }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    @endif

    
@endsection
