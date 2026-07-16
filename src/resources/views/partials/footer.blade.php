<!-- Page Footer-->
<footer class="section section-fluid footer-classic">
  <div class="container-fluid">
    <div class="row row-30 justify-content-center">
      <div class="col-md-10 col-lg-12 col-xl-4 wow fadeInRight">
        <div class="box-footer box-footer-small">
          <div class="footer-brand">
            <h4 class="font-weight-normal">{{ __('footer.band_name') }}</h4>
          </div>
          <p class="text-width-medium">{{ __('footer.description') }}</p>
          <div class="contact-classic">
            <div class="contact-classic-item">
              <div class="unit align-items-center">
                <div class="unit-left">
                  <h6 class="contact-classic-title">{{ __('footer.phone') }}</h6>
                </div>
                <div class="unit-body contact-classic-link">
                  <a href="tel:{{ \App\Helpers\SettingsHelper::phone() }}">{{ \App\Helpers\SettingsHelper::phone() }}</a>
                </div>
              </div>
            </div>
            <div class="contact-classic-item">
              <div class="unit align-items-center">
                <div class="unit-left">
                  <h6 class="contact-classic-title">{{ __('footer.email') }}</h6>
                </div>
                <div class="unit-body contact-classic-link">
                  <a href="mailto:{{ \App\Helpers\SettingsHelper::email() }}">{{ \App\Helpers\SettingsHelper::email() }}</a>
                </div>
              </div>
            </div>
          </div>
          <p class="mt-3">{{ __('footer.follow_us') }}</p>
          <ul class="list-inline list-inline-sm footer-social-list">
            <li><a class="icon fa fa-facebook" href="{{ \App\Helpers\SettingsHelper::facebookUrl() }}" title="{{ __('footer.facebook') }}" aria-label="{{ __('footer.facebook') }}"></a></li>
            <li><a class="icon fa fa-instagram" href="{{ \App\Helpers\SettingsHelper::instagramUrl() }}" title="{{ __('footer.instagram') }}" aria-label="{{ __('footer.instagram') }}"></a></li>
            <li><a class="icon fa fa-youtube-play" href="{{ \App\Helpers\SettingsHelper::youtubeUrl() }}" title="{{ __('footer.youtube') }}" aria-label="{{ __('footer.youtube') }}"></a></li>
          </ul>
        </div>
      </div>

      <div class="col-md-10 col-lg-6 col-xl-4 wow fadeInRight" data-wow-delay=".1s">
        <div class="box-footer">
          <h4 class="font-weight-normal">{{ __('footer.contact_us') }}</h4>
          <form class="rd-form js-contact-form"
                method="post"
                action="{{ route('contatti.store') }}"
                data-error-message="{{ __('contact.messages.error') }}"
                data-turnstile-message="{{ __('contact.messages.turnstile_error') }}">
            @csrf
            <input type="hidden" name="from_footer" value="1">
            <div class="contact-form-status alert @if(session('footer_success')) alert-success @elseif(session('footer_error')) alert-danger @else d-none @endif"
                 role="status"
                 aria-live="polite"
                 tabindex="-1">
              {{ session('footer_success') ?? session('footer_error') }}
            </div>
            <div class="form-wrap">
              <input class="form-input @error('name','footer') is-invalid @enderror" id="contact-name-6" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" />
              <label class="form-label" for="contact-name-6">{{ __('footer.name') }}</label>
              @error('name','footer')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-wrap">
              <input class="form-input @error('email','footer') is-invalid @enderror" id="contact-email-6" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
              <label class="form-label" for="contact-email-6">{{ __('footer.email') }}</label>
              @error('email','footer')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-wrap">
              <label class="form-label" for="contact-message-6">{{ __('footer.message') }}</label>
              <textarea class="form-input @error('message','footer') is-invalid @enderror" id="contact-message-6" name="message" required>{{ old('message') }}</textarea>
              @error('message','footer')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            @if(config('services.turnstile.enabled') && config('services.turnstile.site_key'))
              <div class="form-wrap">
                <input type="hidden" name="cf-turnstile-response" value="">
                <div class="js-contact-turnstile"
                     data-sitekey="{{ config('services.turnstile.site_key') }}"
                     data-action="contact_footer"
                     data-appearance="interaction-only"
                     data-size="flexible"
                     data-theme="auto"></div>
                @error('cf-turnstile-response','footer')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            @endif
            <button class="button button-block button-ujarak button-secondary contact-submit" type="submit">
              <span class="contact-submit-label">{{ __('footer.send_message') }}</span>
              <span class="contact-submit-progress" hidden>
                <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
                {{ __('contact.form.sending') }}
              </span>
            </button>
          </form>
        </div>
      </div>

      <div class="col-md-10 col-lg-6 col-xl-4 wow fadeInRight" data-wow-delay=".2s">
        <div class="box-footer">
          <h4 class="font-weight-normal">{{ __('footer.quick_links') }}</h4>
          <ul class="footer-list-category">
            <li class="heading-5"><a href="{{ route('chi-siamo') }}">{{ __('footer.about_us') }}<span></span></a></li>
            <li class="heading-5"><a href="{{ route('corsi-di-musica') }}">{{ __('footer.music_courses') }}<span></span></a></li>
            <li class="heading-5"><a href="{{ route('eventi') }}">{{ __('footer.concerts') }}<span></span></a></li>
            <li class="heading-5"><a href="{{ route('galleria') }}">{{ __('footer.photo_gallery') }}<span></span></a></li>
            <li class="heading-5"><a href="{{ route('contatti') }}">{{ __('footer.contact_us') }}<span></span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container footer-bottom-panel wow fadeInUp">
    <p class="rights">
      <span>&copy;&nbsp;</span>
      <span class="copyright-year">{{ date('Y') }}</span>
      <span>&nbsp;</span>
      <span>{{ __('footer.full_band_name') }}</span>
      <span>.&nbsp;</span>
      <span>{{ __('footer.all_rights_reserved') }}</span>
    </p>
    @php
      $analytics = \App\Helpers\SettingsHelper::analytics();
      $showCookieSettings = (bool) ($analytics['enabled'] ?? false)
        && ($analytics['provider'] ?? null) === 'ga4'
        && trim((string) ($analytics['ga4_measurement_id'] ?? '')) !== '';
    @endphp
    @if ($showCookieSettings)
      <p class="mt-2 mb-0">
        <a
          href="#"
          onclick="event.preventDefault(); window.BandaCookieConsent?.reopen?.();"
        >
          {{ __('footer.manage_cookies') }}
        </a>
      </p>
    @endif
  </div>
</footer>
