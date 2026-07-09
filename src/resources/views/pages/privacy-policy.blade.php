@extends('layouts.app')

@php
    $contactInfo = $contactInfo ?? \App\Helpers\SettingsHelper::contactInfo();
    $siteTitle = $siteSettings['title'] ?? 'Banda Folk di Castello Tesino';
@endphp

@section('title', __('privacy.meta.title'))
@section('description', __('privacy.meta.description'))
@section('og_title', __('privacy.meta.og_title'))
@section('og_description', __('privacy.meta.og_description'))

@section('content')
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('privacy.title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('header.home') }}</a></li>
                    <li class="active">{{ __('privacy.title') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ \App\Models\StaticPage::headerImageUrl('privacy_policy', 'images/FotoSanIppolito1.webp') }});"></div>
        </div>
    </section>

    <section class="section section-sm section-first bg-default privacy-policy">
        <div class="container">
            <div class="privacy-policy__intro">
                <p class="privacy-policy__eyebrow">{{ __('privacy.updated') }}</p>
                <h2>{{ __('privacy.intro_title') }}</h2>
                <p class="lead">{{ __('privacy.intro') }}</p>
            </div>

            <div class="row row-50 justify-content-center">
                <aside class="col-lg-3 d-none d-lg-block">
                    <nav class="privacy-policy__nav" aria-label="{{ __('privacy.navigation_aria') }}">
                        <a href="#titolare">{{ __('privacy.nav.controller') }}</a>
                        <a href="#dati">{{ __('privacy.nav.data') }}</a>
                        <a href="#finalita">{{ __('privacy.nav.purposes') }}</a>
                        <a href="#cookie">{{ __('privacy.nav.cookies') }}</a>
                        <a href="#diritti">{{ __('privacy.nav.rights') }}</a>
                    </nav>
                </aside>

                <article class="col-lg-8 privacy-policy__content">
                    <section id="titolare">
                        <h3>{{ __('privacy.sections.controller_title') }}</h3>
                        <p>{!! __('privacy.sections.controller_body', ['siteTitle' => e($siteTitle)]) !!}</p>
                        <address>
                            <strong>{{ $siteTitle }}</strong><br>
                            {{ $contactInfo['address'] ?? '' }}<br>
                            <a href="mailto:{{ $contactInfo['email'] ?? '' }}">{{ $contactInfo['email'] ?? '' }}</a>
                        </address>
                    </section>

                    <section id="dati">
                        <h3>{{ __('privacy.sections.data_title') }}</h3>
                        <p>{{ __('privacy.sections.data_body') }}</p>
                    </section>

                    <section id="finalita">
                        <h3>{{ __('privacy.sections.purposes_title') }}</h3>
                        <p>{{ __('privacy.sections.purposes_body') }}</p>
                        <h4>{{ __('privacy.sections.legal_title') }}</h4>
                        <p>{{ __('privacy.sections.legal_body') }}</p>
                    </section>

                    <section>
                        <h3>{{ __('privacy.sections.recipients_title') }}</h3>
                        <p>{{ __('privacy.sections.recipients_body') }}</p>
                        <h4>{{ __('privacy.sections.transfers_title') }}</h4>
                        <p>{!! __('privacy.sections.transfers_body') !!}</p>
                    </section>

                    <section>
                        <h3>{{ __('privacy.sections.retention_title') }}</h3>
                        <p>{{ __('privacy.sections.retention_body') }}</p>
                    </section>

                    <section id="cookie">
                        <h3>{{ __('privacy.sections.cookies_title') }}</h3>
                        <p>{{ __('privacy.sections.cookies_body') }}</p>
                        <button type="button" class="button button-primary button-ujarak button-xs" data-cookie-consent-reopen>
                            {{ __('privacy.manage_cookies') }}
                        </button>
                    </section>

                    <section id="diritti">
                        <h3>{{ __('privacy.sections.rights_title') }}</h3>
                        <p>{{ __('privacy.sections.rights_body') }}</p>
                        <p>{!! __('privacy.sections.complaint_body') !!}</p>
                    </section>

                    <section>
                        <h3>{{ __('privacy.sections.automated_title') }}</h3>
                        <p>{{ __('privacy.sections.automated_body') }}</p>
                    </section>
                </article>
            </div>
        </div>
    </section>
@endsection
