<!-- Page Footer-->
<footer class="section section-fluid footer-classic">
  <div class="container-fluid">
    <div class="row row-30 justify-content-center">
      <div class="col-md-10 col-lg-12 col-xl-4 wow fadeInRight">
        <div class="box-footer box-footer-small">
          <div class="footer-brand">
            <a href="{{ route('home') }}">
              <h3>{{ __('Banda Folk di Castello Tesino') }}</h3>
            </a>
          </div>
          <p class="text-width-medium">{{ __('Dal 1901 portiamo avanti la tradizione musicale del Trentino, unendo la passione per la musica folkloristica alle radici culturali del territorio tesino.') }}</p>
          <div class="contact-classic">
            <div class="contact-classic-item">
              <div class="unit align-items-center">
                <div class="unit-left">
                  <h6 class="contact-classic-title">Telefono</h6>
                </div>
                <div class="unit-body contact-classic-link">
                  <a href="tel:+393401234567">+39 340 123 4567</a>
                </div>
              </div>
            </div>
            <div class="contact-classic-item">
              <div class="unit align-items-center">
                <div class="unit-left">
                  <h6 class="contact-classic-title">Email</h6>
                </div>
                <div class="unit-body contact-classic-link">
                  <a href="mailto:info@bandafolkcastellotesino.it">info@bandafolkcastellotesino.it</a>
                </div>
              </div>
            </div>
          </div>
          <ul class="list-inline list-inline-sm footer-social-list">
            <li><a class="icon fa fa-facebook" href="https://www.facebook.com/bandafolkcastellotesino" title="Facebook" aria-label="Facebook della Banda Folk"></a></li>
            <li><a class="icon fa fa-instagram" href="https://www.instagram.com/bandafolkcastellotesino" title="Instagram" aria-label="Instagram della Banda Folk"></a></li>
            <li><a class="icon fa fa-youtube-play" href="https://www.youtube.com/bandafolkcastellotesino" title="YouTube" aria-label="Canale YouTube della Banda Folk"></a></li>
          </ul>
        </div>
      </div>

      <div class="col-md-10 col-lg-6 col-xl-4 wow fadeInRight" data-wow-delay=".1s">
        <div class="box-footer">
          <h3 class="font-weight-normal">{{ __('Contattaci') }}</h3>
          <form class="rd-form rd-mailform" data-form-output="form-output-global" data-form-type="contact" method="post" >
            @csrf
            <div class="form-wrap">
              <input class="form-input" id="contact-name-6" type="text" name="name" data-constraints="@@Required" required />
              <label class="form-label" for="contact-name-6">{{ __('Nome') }}</label>
            </div>
            <div class="form-wrap">
              <input class="form-input" id="contact-email-6" type="email" name="email" data-constraints="@@Email @@Required" required />
              <label class="form-label" for="contact-email-6">{{ __('E-mail') }}</label>
            </div>
            <div class="form-wrap">
              <label class="form-label" for="contact-message-6">{{ __('Messaggio') }}</label>
              <textarea class="form-input" id="contact-message-6" name="message" data-constraints="@@Required" required></textarea>
            </div>
            <button class="button button-block button-ujarak button-secondary" type="submit">{{ __('Invia Messaggio') }}</button>
          </form>
        </div>
      </div>

      <div class="col-md-10 col-lg-6 col-xl-4 wow fadeInRight" data-wow-delay=".2s">
        <div class="box-footer">
          <h3 class="font-weight-normal">{{ __('Collegamenti Rapidi') }}</h3>
          <ul class="footer-list-category">
            <li class="heading-5"><a href="{{ route('chi-siamo') }}">{{ __('Chi Siamo') }}<span></span></a></li>
            <li class="heading-5"><a href="{{ route('corsi-di-musica') }}">{{ __('Corsi di Musica') }}<span></span></a></li>
            <li class="heading-5"><a href="{{ route('eventi') }}">{{ __('Concerti') }}<span></span></a></li>
            <li class="heading-5"><a href="{{ route('gallery') }}">{{ __('Galleria Fotografica') }}<span></span></a></li>
            <li class="heading-5"><a href="{{ route('contatti') }}">{{ __('Contattaci') }}<span></span></a></li>
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
      <span>{{ __('Banda Folk di Castello Tesino') }}</span>
      <span>.&nbsp;</span>
      <span>{{ __('Tutti i diritti riservati') }}</span>
    </p>
  </div>
</footer>
