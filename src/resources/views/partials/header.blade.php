<!-- Page Header-->
<header class="section page-header">
  <!-- RD Navbar-->
  <div class="rd-navbar-wrap">
    <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed"
      data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static"
      data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static"
      data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static"
      data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px"
      data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
      <div class="rd-navbar-main-outer">
        <div class="rd-navbar-main">
          <!-- RD Navbar Panel-->
          <div class="rd-navbar-panel">
            <!-- RD Navbar Toggle-->
            <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap" aria-label="{{ __('Toggle navigation menu') }}" title="{{ __('Toggle navigation menu') }}">
              <span></span>
            </button>
            <!-- RD Navbar Brand-->
            <div class="rd-navbar-brand">
              <a class="brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-default.png') }}" class="mr-2" alt="" width="43" height="43" style="width: 43px; height: 43px;" />
                <h4>{{ __('Banda Folk di Castello Tesino') }}</h4>
              </a>
            </div>
          </div>

          <div class="rd-navbar-main-element">
            <div class="rd-navbar-nav-wrap">
              @include('partials.language-switcher')

              <!-- RD Navbar Search-->
              <div class="rd-navbar-search">
                <button class="rd-navbar-search-toggle" data-rd-navbar-toggle=".rd-navbar-search">
                  <span></span>
                </button>
                <form class="rd-search" method="GET">
                  <div class="form-wrap">
                    <label class="form-label" for="rd-navbar-search-form-input">{{ __('Search...') }}</label>
                    <input class="rd-navbar-search-form-input form-input" id="rd-navbar-search-form-input"
                      type="text" name="q" autocomplete="off" />
                  </div>
                  <button class="rd-search-form-submit fl-bigmug-line-search74" type="submit" aria-label="{{ __('Search') }}" title="{{ __('Search') }}"></button>
                </form>
              </div>

              <!-- RD Navbar Share -->
              <div class="rd-navbar-share fl-bigmug-line-share27" data-rd-navbar-toggle=".rd-navbar-share-list">
                <ul class="list-inline rd-navbar-share-list">
                  <!-- Facebook -->
                  <li class="rd-navbar-share-list-item">
                    <a class="icon fa fa-facebook"
                      href="https://www.facebook.com/bandafolkcastellotesino"
                      target="_blank" rel="noopener noreferrer" 
                      title="{{ __('Follow us on Facebook') }}" 
                      aria-label="{{ __('Facebook') }}">
                    </a>
                  </li>

                  <!-- Instagram -->
                  <li class="rd-navbar-share-list-item">
                    <a class="icon fa fa-instagram"
                      href="https://www.instagram.com/bandafolkcastellotesino"
                      target="_blank" rel="noopener noreferrer"
                      title="{{ __('Follow us on Instagram') }}"
                      aria-label="{{ __('Instagram') }}">
                    </a>
                  </li>

                  <!-- YouTube -->
                  <li class="rd-navbar-share-list-item">
                    <a class="icon fa fa-youtube-play"
                      href="https://www.youtube.com/bandafolkcastellotesino"
                      target="_blank" rel="noopener noreferrer"
                      title="{{ __('Watch our videos on YouTube') }}"
                      aria-label="{{ __('YouTube') }}">
                    </a>
                  </li>
                </ul>
              </div>

              <!-- RD Navbar Nav-->
              <ul class="rd-navbar-nav">
                <li class="rd-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                  <a class="rd-nav-link" href="{{ route('home') }}">{{ __('header.home') }}</a>
                </li>
                <li class="rd-nav-item {{ request()->routeIs(['chi-siamo', 'storia', 'organico', 'maestro', 'repertorio', 'abito-tradizionale']) ? 'active' : '' }} rd-nav-item--has-dropdown rd-navbar-submenu">
                  <a class="rd-nav-link" href="{{ route('chi-siamo') }}">{{ __('header.chi-siamo') }}</a>
                  <ul class="rd-menu rd-navbar-dropdown">
                    <li class="rd-dropdown-item">
                      <a class="rd-dropdown-link" href="{{ route('storia') }}">{{ __('header.storia') }}</a>
                    </li>
                    <li class="rd-dropdown-item">
                      <a class="rd-dropdown-link" href="{{ route('abito-tradizionale') }}">{{ __('header.abito-tradizionale') }}</a>
                    </li>
                    <li class="rd-dropdown-item">
                      <a class="rd-dropdown-link" href="{{ route('maestro') }}">{{ __('header.maestro') }}</a>
                    </li>
                    <li class="rd-dropdown-item">
                      <a class="rd-dropdown-link" href="{{ route('organico') }}">{{ __('header.organico') }}</a>
                    </li>
                    <li class="rd-dropdown-item">
                      <a class="rd-dropdown-link" href="{{ route('repertorio') }}">{{ __('header.repertorio') }}</a>
                    </li>
                  </ul>
                </li>
                <li class="rd-nav-item {{ request()->routeIs('corsi-di-musica') ? 'active' : '' }}">
                  <a class="rd-nav-link" href="{{ route('corsi-di-musica') }}">{{ __('header.corsi-di-musica') }}</a>
                </li>
                <li class="rd-nav-item {{ request()->routeIs(['eventi', 'italia-gira-banda']) ? 'active' : '' }} rd-nav-item--has-dropdown rd-navbar-submenu">
                  <a class="rd-nav-link" href="{{ route('eventi') }}">{{ __('header.eventi') }}</a>
                  <ul class="rd-menu rd-navbar-dropdown">
                    <li class="rd-dropdown-item">
                      <a class="rd-dropdown-link" href="{{ route('eventi') }}">{{ __('header.eventi') }}</a>
                    </li>
                    <li class="rd-dropdown-item">
                      <a class="rd-dropdown-link" href="{{ route('italia-gira-banda') }}">{{ __('header.italia-gira-banda') }}</a>
                    </li>
                  </ul>
                </li>
                <li class="rd-nav-item {{ request()->routeIs('galleria') ? 'active' : '' }}">
                  <a class="rd-nav-link" href="{{ LaravelLocalization::transRoute('galleria') }}">{{ __('header.galleria') }}</a>
                </li>
                <li class="rd-nav-item {{ request()->routeIs('contatti') ? 'active' : '' }}">
                  <a class="rd-nav-link" href="{{ LaravelLocalization::transRoute('contatti') }}">{{ __('header.contatti') }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>
