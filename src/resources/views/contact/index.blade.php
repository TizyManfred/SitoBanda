@extends('layouts.app')

@section('title', __('contact.meta.title'))
@section('description', __('contact.meta.description'))
@section('og_title', __('contact.meta.og_title'))
@section('og_description', __('contact.meta.og_description'))


@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ __('contact.breadcrumbs.title') }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('contact.breadcrumbs.home') }}</a></li>
                    <li class="active">{{ __('contact.breadcrumbs.title') }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ \App\Models\StaticPage::headerImageUrl('contact', 'images/FotoSanIppolito1.webp') }});"></div>
        </div>
    </section>

    <!-- Contact Form and Info -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-5">
                    <div class="inset-right-1">
                        <h3>{{ __('contact.headings.contact_info') }}</h3>
                        <p>{{ __('contact.intro') }}</p>

                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 d-flex align-items-start">
                                        <i class="bi bi-geo-alt me-3 fs-4 text-primary"></i>
                                        <div>
                                            <h5 class="mb-1">{{ __('contact.labels.address') }}</h5>
                                            <p class="mb-0">{{ \App\Helpers\SettingsHelper::contactInfo()['address'] }}</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0 d-flex align-items-start">
                                        <i class="bi bi-telephone me-3 fs-4 text-primary"></i>
                                        <div>
                                            <h5 class="mb-1">{{ __('contact.labels.phone') }}</h5>
                                            <p class="mb-0"><a href="tel:{{ \App\Helpers\SettingsHelper::phone() }}">{{ \App\Helpers\SettingsHelper::phone() }}</a></p>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0 d-flex align-items-start">
                                        <i class="bi bi-envelope me-3 fs-4 text-primary"></i>
                                        <div>
                                            <h5 class="mb-1">{{ __('contact.labels.email') }}</h5>
                                            <p class="mb-0"><a href="mailto:{{ \App\Helpers\SettingsHelper::email() }}">{{ \App\Helpers\SettingsHelper::email() }}</a></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-body">
                                <h5 class="mb-3">{{ __('contact.headings.follow_us') }}</h5>
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item mr-3">
                                        <a href="{{ \App\Helpers\SettingsHelper::facebookUrl() }}" target="_blank" aria-label="Facebook" class="text-decoration-none big">
                                            <i class="fa fa-facebook fs-4"></i> Facebook
                                        </a>
                                    </li>
                                    <li class="list-inline-item mr-3">
                                        <a href="{{ \App\Helpers\SettingsHelper::instagramUrl() }}" target="_blank" aria-label="Instagram" class="text-decoration-none big">
                                            <i class="fa fa-instagram fs-4"></i> Instagram
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="{{ \App\Helpers\SettingsHelper::youtubeUrl() }}" target="_blank" aria-label="YouTube" class="text-decoration-none big">
                                            <i class="fa fa-youtube fs-4"></i> YouTube
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <h3>{{ __('contact.headings.send_message') }}</h3>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form class="js-contact-form"
                                  method="POST"
                                  action="{{ route('contatti.store') }}"
                                  data-error-message="{{ __('contact.messages.error') }}"
                                  data-turnstile-message="{{ __('contact.messages.turnstile_error') }}">
                                @csrf
                                <div class="contact-form-status alert @if(session('success')) alert-success @elseif(session('error')) alert-danger @else d-none @endif"
                                     role="status"
                                     aria-live="polite"
                                     tabindex="-1">
                                    {{ session('success') ?? session('error') }}
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="sr-only" for="name">{{ __('contact.form.name') }} *</label>
                                        <input class="form-input @error('name','contact') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="{{ __('contact.form.name') }} *">
                                        @error('name','contact')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <label class="sr-only" for="email">{{ __('contact.form.email') }} *</label>
                                        <input class="form-input @error('email','contact') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('contact.form.email') }} *">
                                        @error('email','contact')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="sr-only" for="subject">{{ __('contact.form.subject') }} *</label>
                                    <input class="form-input @error('subject','contact') is-invalid @enderror" id="subject" type="text" name="subject" value="{{ old('subject') }}" required placeholder="{{ __('contact.form.subject') }} *">
                                    @error('subject','contact')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="sr-only" for="message">{{ __('contact.form.message') }} *</label>
                                    <textarea class="form-input @error('message','contact') is-invalid @enderror" id="message" name="message" rows="6" required placeholder="{{ __('contact.form.message') }} *">{{ old('message') }}</textarea>
                                    @error('message','contact')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if(config('services.turnstile.enabled') && config('services.turnstile.site_key'))
                                    <div class="form-group mb-3">
                                        <input type="hidden" name="cf-turnstile-response" value="">
                                        <div class="js-contact-turnstile"
                                             data-sitekey="{{ config('services.turnstile.site_key') }}"
                                             data-action="contact_page"
                                             data-appearance="interaction-only"
                                             data-size="flexible"
                                             data-theme="auto"></div>
                                        @error('cf-turnstile-response','contact')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <div class="form-group mb-3">
                                    <div class="form-input d-flex align-items-center @error('privacy_policy','contact') has-error @enderror" style="gap: 12px; min-height: 60px;">
                                        <input class="@error('privacy_policy','contact') is-invalid @enderror" type="checkbox" value="1" id="privacy_policy" name="privacy_policy" required {{ old('privacy_policy') ? 'checked' : '' }}
                                               style="width:18px; height:18px; margin:0; flex:0 0 auto; accent-color:#50ba87; border-radius:3px;">
                                        <label for="privacy_policy" style="margin:0; user-select: none; cursor: pointer; flex: 0 0 auto;">
                                            {{ __('contact.form.privacy_text') }} *
                                        </label>
                                        <a href="{{ route('privacy-policy') }}" target="_blank" style="flex: 0 0 auto;">{{ __('contact.form.privacy_link') }}</a>
                                    </div>
                                    @error('privacy_policy','contact')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button class="btn btn-primary btn-lg btn-block contact-submit" type="submit">
                                    <span class="contact-submit-label">{{ __('contact.form.submit') }}</span>
                                    <span class="contact-submit-progress" hidden>
                                        <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
                                        {{ __('contact.form.sending') }}
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
