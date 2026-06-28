@extends('layouts.app')

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

    <section class="section section-sm section-first bg-default text-left">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9">
                    <p class="lead text-gray-800 mb-5">{{ __('privacy.intro') }}</p>

                    <div class="row row-30">
                        <div class="col-md-6">
                            <div class="box-default shadow-sm h-100">
                                <h3 class="title-decoration-lines-left">{{ __('privacy.sections.controller_title') }}</h3>
                                <p>{{ __('privacy.sections.controller_body') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-default shadow-sm h-100">
                                <h3 class="title-decoration-lines-left">{{ __('privacy.sections.data_title') }}</h3>
                                <p>{{ __('privacy.sections.data_body') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-default shadow-sm h-100">
                                <h3 class="title-decoration-lines-left">{{ __('privacy.sections.purpose_title') }}</h3>
                                <p>{{ __('privacy.sections.purpose_body') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-default shadow-sm h-100">
                                <h3 class="title-decoration-lines-left">{{ __('privacy.sections.storage_title') }}</h3>
                                <p>{{ __('privacy.sections.storage_body') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box-default shadow-sm mt-4">
                        <h3 class="title-decoration-lines-left">{{ __('privacy.sections.rights_title') }}</h3>
                        <p class="mb-0">{{ __('privacy.sections.rights_body') }}</p>
                    </div>

                    <div class="alert alert-light border mt-4 mb-0">
                        {{ __('privacy.cta') }}
                        <a href="{{ route('contatti') }}">{{ __('contact.breadcrumbs.title') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
