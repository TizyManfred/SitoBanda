<!-- Page Footer-->
<footer class="section section-fluid footer-classic">
  <div class="container-fluid">
    <div class="row row-30 justify-content-center">
      <div class="col-md-10 col-lg-12 col-xl-4 wow fadeInRight">
        <div class="box-footer box-footer-small">
          <div class="footer-brand">
            <a href="{{ route('home') }}">
              <h3>{{ __('footer.band_name') }}</h3>
            </a>
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
          <h3 class="font-weight-normal">{{ __('footer.contact_us') }}</h3>
          <form class="rd-form rd-mailform" data-form-output="form-output-global" data-form-type="contact" method="post" >
            @csrf
            <div class="form-wrap">
              <input class="form-input" id="contact-name-6" type="text" name="name" data-constraints="@@Required" required />
              <label class="form-label" for="contact-name-6">{{ __('footer.name') }}</label>
            </div>
            <div class="form-wrap">
              <input class="form-input" id="contact-email-6" type="email" name="email" data-constraints="@@Email @@Required" required />
              <label class="form-label" for="contact-email-6">{{ __('footer.email') }}</label>
            </div>
            <div class="form-wrap">
              <label class="form-label" for="contact-message-6">{{ __('footer.message') }}</label>
              <textarea class="form-input" id="contact-message-6" name="message" data-constraints="@@Required" required></textarea>
            </div>
            <button class="button button-block button-ujarak button-secondary" type="submit">{{ __('footer.send_message') }}</button>
          </form>
        </div>
      </div>

      <div class="col-md-10 col-lg-6 col-xl-4 wow fadeInRight" data-wow-delay=".2s">
        <div class="box-footer">
          <h3 class="font-weight-normal">{{ __('footer.quick_links') }}</h3>
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
  </div>
</footer>
