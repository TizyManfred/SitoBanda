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
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                <!-- RD Navbar Brand-->
                <div class="rd-navbar-brand">
                  <a class="brand d-flex align-items-center" href="<?=SITE_URL ?>/">
                    <img src="<?=SITE_URL ?>/assets/images/logo-default.png" class="mr-2" alt="" width="43" height="43" style="width: 43px; height: 43px;" />
                    <h4>Banda Folk di Castello Tesino</h4>
                  </a>
                </div>
              </div>


              <div class="rd-navbar-main-element">
                <div class="rd-navbar-nav-wrap">

                  <!-- RD Navbar Search-->
                  <div class="rd-navbar-search">
                    <button class="rd-navbar-search-toggle"
                      data-rd-navbar-toggle=".rd-navbar-search"><span></span></button>
                    <form class="rd-search" action="#" method="GET">
                      <div class="form-wrap">
                        <label class="form-label" for="rd-navbar-search-form-input">Search...</label>
                        <input class="rd-navbar-search-form-input form-input" id="rd-navbar-search-form-input"
                          type="text" name="s" autocomplete="off" />
                      </div>
                      <button class="rd-search-form-submit fl-bigmug-line-search74" type="submit"></button>
                    </form>
                  </div>

                  <!-- RD Navbar Share -->
                  <div class="rd-navbar-share fl-bigmug-line-share27" data-rd-navbar-toggle=".rd-navbar-share-list">
                    <ul class="list-inline rd-navbar-share-list">
                      <!-- Facebook Share -->
                      <li class="rd-navbar-share-list-item">
                        <a class="icon fa fa-facebook"
                          href="<?php echo SOCIAL_FACEBOOK; ?>"
                          target="_blank" rel="noopener noreferrer" title="Seguici su Facebook"></a>
                      </li>

                      <!-- Instagram -->
                      <li class="rd-navbar-share-list-item">
                        <a class="icon fa fa-instagram" 
                          href="<?php echo SOCIAL_INSTAGRAM; ?>" 
                          target="_blank" rel="noopener noreferrer" title="Seguici su Instagram"></a>
                      </li>

                      <!-- YouTube -->
                      <li class="rd-navbar-share-list-item">
                        <a class="icon fa fa-youtube-play" 
                          href="<?php echo SOCIAL_YOUTUBE; ?>" 
                          target="_blank" rel="noopener noreferrer" title="Guarda i nostri video"></a>
                      </li>
                    </ul>
                  </div>

                  <!-- RD Navbar Nav-->
                  <ul class="rd-navbar-nav">
                    <li class="rd-nav-item<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? ' active' : ''; ?>"><a class="rd-nav-link" href="/">Home</a>
                    </li>
                    <li class="rd-nav-item<?php echo (basename($_SERVER['PHP_SELF']) == 'chi-siamo.php') ? ' active' : ''; ?>"><a class="rd-nav-link" href="<?=SITE_URL ?>/chi-siamo">Chi Siamo</a>
                      <ul class="rd-menu rd-navbar-dropdown">
                        <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="<?=SITE_URL ?>/storia">Storia</a></li>
                        <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="<?=SITE_URL ?>/abito-tradizionale">L'Abito Tradizionale</a></li>
                        <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="<?=SITE_URL ?>/maestro">Maestro</a></li>
                        <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="<?=SITE_URL ?>/organico">Organico</a></li>
                        <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="<?=SITE_URL ?>/repertorio">Repertorio</a></li>
                      </ul>
                    </li>
                    <li class="rd-nav-item<?php echo (basename($_SERVER['PHP_SELF']) == 'corsi-di-musica.php') ? ' active' : ''; ?>"><a class="rd-nav-link" href="<?=SITE_URL ?>/corsi-di-musica">Corsi di Musica</a>
                    </li>
                    <li class="rd-nav-item<?php echo (in_array(basename($_SERVER['PHP_SELF']), ['eventi.php', 'italia-gira-banda.php'])) ? ' active' : ''; ?>"><a class="rd-nav-link" href="<?=SITE_URL ?>/eventi">Eventi</a>
                      <ul class="rd-menu rd-navbar-dropdown">
                        <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="<?=SITE_URL ?>/eventi">Eventi</a></li>
                        <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="<?=SITE_URL ?>/italia-gira-banda">Italia Gira Banda</a></li>
                      </ul>
                    </li>
                    <li class="rd-nav-item<?php echo (basename($_SERVER['PHP_SELF']) == 'gallery.php') ? ' active' : ''; ?>"><a class="rd-nav-link" href="<?=SITE_URL ?>/gallery">Gallery</a>
                    </li>
                    <li class="rd-nav-item<?php echo (basename($_SERVER['PHP_SELF']) == 'contatti.php') ? ' active' : ''; ?>"><a class="rd-nav-link" href="<?=SITE_URL ?>/contatti">Contatti</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>