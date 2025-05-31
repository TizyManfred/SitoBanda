<?php
/**
 * Index Page
 *
 * Main homepage for SitoBanda website
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */

// Define ABSPATH to prevent direct file access
define('ABSPATH', dirname(__DIR__) . '/');

// Include configuration
require_once ABSPATH . 'includes/config.php';
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="it">

<head>
  <title>Banda Folk di Castello Tesino - Musica Tradizionale dal 1901</title>
  <meta name="description" content="La Banda Folk di Castello Tesino, attiva dal 1901, porta avanti la tradizione musicale del Trentino con concerti, eventi e corsi di musica.">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <link rel="icon" href="<?= SITE_URL ?>/assets/images/favicon.ico" type="image/x-icon">
  
  <!-- Open Graph / Social Media Meta Tags -->
  <meta property="og:title" content="Banda Folk di Castello Tesino - Tradizione dal 1901">
  <meta property="og:description" content="Scopri la Banda Folk di Castello Tesino, custode della tradizione musicale trentina dal 1901.">
  <meta property="og:image" content="<?= SITE_URL ?>/assets/images/FotoSanIppolito1.jpg">
  <meta property="og:url" content="<?= SITE_URL ?>">
  <meta property="og:type" content="website">
  <!-- Stylesheets-->
  <link rel="stylesheet" type="text/css"
    href="//fonts.googleapis.com/css?family=Poppins:400,500%7CTeko:300,400,500%7CMaven+Pro:500">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/fonts.css">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
  <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="<?= SITE_URL ?>/assets/images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="<?= SITE_URL ?>/assets/js/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>
  <div class="preloader">
    <div class="preloader-body">
      <div class="cssload-container"><span></span><span></span><span></span><span></span>
      </div>
    </div>
  </div>

  <div class="page">
    <?php include_once TEMPLATES_PATH . 'header.php'; ?>
    

    <!-- Hero Slider -->
    <section class="section swiper-container swiper-slider swiper-slider-classic" data-loop="true" data-autoplay="5000"
      data-simulate-touch="true" data-direction="vertical" data-nav="false" aria-label="Slideshow principale">
      <div class="swiper-wrapper text-center">
        <div class="swiper-slide context-dark" data-slide-bg="assets/images/FotoSanIppolito1.jpg" aria-label="Primo slide - Banda a San Ippolito">
          <div class="swiper-slide-caption section-md">
            <div class="container">
              <div class="row">
                <div class="col-md-10 col-lg-8 offset-md-1 offset-lg-2">
                  <h1><span class="d-block" data-caption-animate="fadeInUp" data-caption-delay="100">Banda Folk</span><span class="d-block text-light" data-caption-animate="fadeInUp"
                      data-caption-delay="200">di Castello Tesino</span></h1>
                  <p class="lead" data-caption-animate="fadeInUp" data-caption-delay="350">Banda Sociale Folkloristica di Castello Tesino<br>Tradizione, Musica & Cultura<br>dal 1901</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="swiper-slide context-dark" data-slide-bg="assets/images/FotoShanghai1.jpeg" aria-label="Secondo slide - Banda a Shanghai">
          <div class="swiper-slide-caption section-md">
            <div class="container">
              <h1 data-caption-animate="fadeInLeft" data-caption-delay="0">Banda folk Castello Tesino</h1>
              <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100">Nel corso della
                nostra storia che è lunga più di 100 anni abbiamo visitato molti stati portando cio che ci caratterizza
                in tutto il mondo.</p><a class="button button-primary button-ujarak" href="#"
                data-caption-animate="fadeInUp" data-caption-delay="200">Scopri la nostra storia</a>
            </div>
          </div>
        </div>

        <div class="swiper-slide context-dark" data-slide-bg="assets/images/FotoRoma1.jpeg" aria-label="Terzo slide - Banda a Roma">
          <div class="swiper-slide-caption section-md">
            <div class="container">
              <h1 data-caption-animate="fadeInLeft" data-caption-delay="0">Banda folk <br> Castello Tesino</h1>
              <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100">La nostra banda
                ama mettersi in gioco e creare iniziative per unire persone da luoghi difersi ma ... da un unica
                passione: La musica.</p><a class="button button-primary button-ujarak" href="#"
                data-caption-animate="fadeInUp" data-caption-delay="200">Scopri italiagirabanda</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Swiper Pagination-->
      <div class="swiper-pagination__module">
        <div class="swiper-pagination__fraction"><span class="swiper-pagination__fraction-index">00</span><span
            class="swiper-pagination__fraction-divider">/</span><span
            class="swiper-pagination__fraction-count">00</span></div>
        <div class="swiper-pagination__divider"></div>
        <div class="swiper-pagination"></div>
      </div>
    </section>


    <!-- See all services-->
    <!-- Chi Siamo Section -->
    <section class="section section-sm section-first bg-default">
      <div class="container">
        <div class="row row-30 justify-content-center">
          <div class="col-md-7 col-lg-5 col-xl-6 text-lg-left wow fadeInUp">
            <div class="figure-classic figure-classic-left">
              <img src="assets/images/FotoBiagio1.jpg" alt="Banda Folk di Castello Tesino in concerto" width="513" height="561" loading="lazy" />
            </div>
          </div>

          <div class="col-lg-7 col-xl-6 d-flex align-items-center">
            <div class="row row-30">

              <div class="col-sm-6 wow fadeInRight">
                <article class="box-icon-modern box-icon-modern-custom">
                  <div>
                    <h3 class="box-icon-modern-big-title">Eventi futuri</h3>
                    <div class="box-icon-modern-decor"></div><a
                      class="button button-md button-default-outline-2 button-wapasha" href="#">Scopri le date</a>
                  </div>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".1s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon bi-hourglass-split"></div>
                  <h5 class="box-icon-modern-title"><a href="#">La nostra storia</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">Scopri di più sulla nostra storia che nasce più di 100 anni fa</p>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".2s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon bi-people-fill"></div>
                  <h5 class="box-icon-modern-title"><a href="#">Organico</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">Scopri di più sulla composizione del nostro organico</p>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".3s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon bi-magic"></div>
                  <h5 class="box-icon-modern-title"><a href="#">Maestro</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">Conosci la storia del nostro maestro e la sua cariera musicale</p>
                </article>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Latest Projects-->
    <section class="section section-sm section-fluid bg-default text-center">
      <div class="container-fluid">
        <h3 class="wow fadeInLeft">Concerti e eventi rilevanti</h3>
        <p class="wow fadeInRight" data-wow-delay=".1s">Ecco alcuni concerti e sfilate rilevanti ai quali abbiamo
          partecipato nell'ultimo periodo</p>

        <!--
          <div class="isotope-filters isotope-filters-horizontal">
            <button class="isotope-filters-toggle button button-md button-icon button-icon-right button-default-outline button-wapasha" data-custom-toggle="#isotope-3" data-custom-toggle-hide-on-blur="true"><span class="icon fa fa-caret-down"></span>Filter</button>
            <ul class="isotope-filters-list" id="isotope-3">
              <li><a class="active" href="#" data-isotope-filter="*" data-isotope-group="gallery">All</a></li>
              <li><a href="#" data-isotope-filter="Type 1" data-isotope-group="gallery">Apartments</a></li>
              <li><a href="#" data-isotope-filter="Type 2" data-isotope-group="gallery">Offices</a></li>
              <li><a href="#" data-isotope-filter="Type 3" data-isotope-group="gallery">Corporate designs</a></li>
            </ul>
          </div>
          -->

        <div class="row row-30 isotope" data-isotope-layout="fitRows" data-isotope-group="gallery"
          data-lightgallery="group">
          <div class="col-sm-6 col-lg-4 col-xxl-3 isotope-item wow fadeInLeft" data-filter="">
            <article class="thumbnail thumbnail-classic thumbnail-md">
              <div class="thumbnail-classic-figure"><img src="assets/images/FotoRoma2.jpg" alt="" width="420" height="350" />
              </div>

              <div class="thumbnail-classic-caption">
                <div class="thumbnail-classic-title-wrap"><a class="icon fl-bigmug-line-zoom60"
                    href="assets/images/fullwidth-gallery-1-1200x800-original.jpg" data-lightgallery="item"><img
                      src="assets/images/fullwidth-gallery-1-420x350.jpg" alt="" width="420" height="350" /></a>
                  <h5 class="thumbnail-classic-title"><a href="#">Roma 2024</a></h5>
                </div>
                <p class="thumbnail-classic-text">Ritrovo a Roma con le bande partecipanti a Italiagirabanda suonando a
                  piazza Montecitorio e piazza San Pietro</p>
              </div>
            </article>
          </div>

          <div class="col-sm-6 col-lg-4 col-xxl-3 isotope-item wow fadeInLeft" data-filter="Type 2"
            data-wow-delay=".1s">
            <article class="thumbnail thumbnail-classic thumbnail-md">
              <div class="thumbnail-classic-figure"><img src="assets/images/FotoTirolo1.jpg" alt="" width="420" height="350" />
              </div>

              <div class="thumbnail-classic-caption">
                <div class="thumbnail-classic-title-wrap"><a class="icon fl-bigmug-line-zoom60"
                    href="assets/images/fullwidth-gallery-2-1200x800-original.jpg" data-lightgallery="item"><img
                      src="assets/images/fullwidth-gallery-2-420x350.jpg" alt="" width="420" height="350" /></a>
                  <h5 class="thumbnail-classic-title"><a href="#">Tirolo 2024</a></h5>
                </div>
                <p class="thumbnail-classic-text">Ritiro del premio transfrontaliero: "Prestazioni di eccellenza -
                  volontariato giovanile"</p>
              </div>
            </article>
          </div>

          <div class="col-sm-6 col-lg-4 col-xxl-3 isotope-item wow fadeInLeft" data-filter="Type 1"
            data-wow-delay=".2s">
            <article class="thumbnail thumbnail-classic thumbnail-md">
              <div class="thumbnail-classic-figure"><img src="assets/images/fullwidth-gallery-3-420x350.jpg" alt="" width="420"
                  height="350" />
              </div>
              <div class="thumbnail-classic-caption">
                <div class="thumbnail-classic-title-wrap"><a class="icon fl-bigmug-line-zoom60"
                    href="assets/images/grid-gallery-1-1200x800-original.jpg" data-lightgallery="item"><img
                      src="assets/images/fullwidth-gallery-3-420x350.jpg" alt="" width="420" height="350" /></a>
                  <h5 class="thumbnail-classic-title"><a href="#">861 E. Oklahoma Dr</a></h5>
                </div>
                <p class="thumbnail-classic-text">We work hard on every project to deliver top-notch interior design
                  concepts that satisfy your wishes.</p>
              </div>
            </article>
          </div>

          <div class="col-sm-6 col-lg-4 col-xxl-3 isotope-item wow fadeInLeft" data-filter="Type 3"
            data-wow-delay=".3s">
            <article class="thumbnail thumbnail-classic thumbnail-md">
              <div class="thumbnail-classic-figure"><img src="assets/images/fullwidth-gallery-4-420x350.jpg" alt="" width="420"
                  height="350" />
              </div>
              <div class="thumbnail-classic-caption">
                <div class="thumbnail-classic-title-wrap"><a class="icon fl-bigmug-line-zoom60"
                    href="assets/images/fullwidth-gallery-4-1200x800-original.jpg" data-lightgallery="item"><img
                      src="assets/images/fullwidth-gallery-4-420x350.jpg" alt="" width="420" height="350" /></a>
                  <h5 class="thumbnail-classic-title"><a href="#">14 Pulaski Str</a></h5>
                </div>
                <p class="thumbnail-classic-text">We work hard on every project to deliver top-notch interior design
                  concepts that satisfy your wishes.</p>
              </div>
            </article>
          </div>

          <div class="col-sm-6 col-lg-4 col-xxl-3 isotope-item wow fadeInRight" data-filter="Type 2">
            <article class="thumbnail thumbnail-classic thumbnail-md">
              <div class="thumbnail-classic-figure"><img src="assets/images/fullwidth-gallery-5-420x350.jpg" alt="" width="420"
                  height="350" />
              </div>
              <div class="thumbnail-classic-caption">
                <div class="thumbnail-classic-title-wrap"><a class="icon fl-bigmug-line-zoom60"
                    href="assets/images/fullwidth-gallery-5-1200x800-original.jpg" data-lightgallery="item"><img
                      src="assets/images/fullwidth-gallery-5-420x350.jpg" alt="" width="420" height="350" /></a>
                  <h5 class="thumbnail-classic-title"><a href="#">8381 Peg Shop Str</a></h5>
                </div>
                <p class="thumbnail-classic-text">We work hard on every project to deliver top-notch interior design
                  concepts that satisfy your wishes.</p>
              </div>
            </article>
          </div>

          <div class="col-sm-6 col-lg-4 col-xxl-3 isotope-item wow fadeInRight" data-filter="Type 1"
            data-wow-delay=".1s">
            <article class="thumbnail thumbnail-classic thumbnail-md">
              <div class="thumbnail-classic-figure"><img src="assets/images/fullwidth-gallery-6-420x350.jpg" alt="" width="420"
                  height="350" />
              </div>
              <div class="thumbnail-classic-caption">
                <div class="thumbnail-classic-title-wrap"><a class="icon fl-bigmug-line-zoom60"
                    href="assets/images/fullwidth-gallery-6-1200x800-original.jpg" data-lightgallery="item"><img
                      src="assets/images/fullwidth-gallery-6-420x350.jpg" alt="" width="420" height="350" /></a>
                  <h5 class="thumbnail-classic-title"><a href="#">830 Bridge Str</a></h5>
                </div>
                <p class="thumbnail-classic-text">We work hard on every project to deliver top-notch interior design
                  concepts that satisfy your wishes.</p>
              </div>
            </article>
          </div>

          <div class="col-sm-6 col-lg-4 col-xxl-3 isotope-item wow fadeInRight" data-filter="Type 3"
            data-wow-delay=".2s">
            <article class="thumbnail thumbnail-classic thumbnail-md">
              <div class="thumbnail-classic-figure"><img src="assets/images/fullwidth-gallery-7-420x350.jpg" alt="" width="420"
                  height="350" />
              </div>
              <div class="thumbnail-classic-caption">
                <div class="thumbnail-classic-title-wrap"><a class="icon fl-bigmug-line-zoom60"
                    href="assets/images/fullwidth-gallery-7-1200x800-original.jpg" data-lightgallery="item"><img
                      src="assets/images/fullwidth-gallery-7-420x350.jpg" alt="" width="420" height="350" /></a>
                  <h5 class="thumbnail-classic-title"><a href="#">29 Water Ln</a></h5>
                </div>
                <p class="thumbnail-classic-text">We work hard on every project to deliver top-notch interior design
                  concepts that satisfy your wishes.</p>
              </div>
            </article>
          </div>

          <div class="col-sm-6 col-lg-4 col-xxl-3 isotope-item wow fadeInRight" data-filter="Type 2"
            data-wow-delay=".3s">
            <article class="thumbnail thumbnail-classic thumbnail-md">
              <div class="thumbnail-classic-figure"><img src="assets/images/fullwidth-gallery-8-420x350.jpg" alt="" width="420"
                  height="350" />
              </div>
              <div class="thumbnail-classic-caption">
                <div class="thumbnail-classic-title-wrap"><a class="icon fl-bigmug-line-zoom60"
                    href="assets/images/fullwidth-gallery-8-1200x800-original.jpg" data-lightgallery="item"><img
                      src="assets/images/fullwidth-gallery-8-420x350.jpg" alt="" width="420" height="350" /></a>
                  <h5 class="thumbnail-classic-title"><a href="#">7262 Blue Spring Dr</a></h5>
                </div>
                <p class="thumbnail-classic-text">We work hard on every project to deliver top-notch interior design
                  concepts that satisfy your wishes.</p>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <!-- La Nostra Storia -->
    <section class="section section-sm bg-default" id="storia">
      <div class="container">
        <div class="row row-50 row-xl-24 justify-content-center align-items-center align-items-lg-start text-left">
          <div class="col-md-6 col-lg-5 col-xl-4 text-center"><a class="text-img" href="<?= SITE_URL ?>/storia.php">
            <span class="counter">120</span></a>
          </div>

          <div class="col-sm-8 col-md-6 col-lg-5 col-xl-4"></div>

          <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4 wow fadeInRight" data-wow-delay=".1s" style="padding-left: 150px;">
            <div class="text-width-extra-small offset-top-lg-24 wow fadeInUp">
              <h3 class="title-decoration-lines-left">Anni di storia</h3>
              <p class="text-gray-500">Storia ormai secolare che ha unito generazioni tutte accumunate per la stessa passione per la musica. Di padre in figlio questa tradizione è stata tramandata negli anni</p>
              <a class="button button-secondary button-pipaluk" href="<?= SITE_URL ?>/storia.php">Scopri di più</a>
            </div>
          </div>

        </div>
      </div>
    </section>


    <!-- What people Say-->
    <section class="section section-sm section-bottom-70 section-fluid bg-default">
      <div class="container-fluid">
        <h3>Cosa dicono le persone</h3>
        <div class="row row-50 row-sm">

          <div class="col-md-6 col-xl-4 wow fadeInRight">
            <article class="quote-modern quote-modern-custom">
              <div class="unit unit-spacing-md align-items-center">
                <div class="unit-left"><a class="quote-modern-figure" href="#"><img class="img-circles"
                      src="<?= SITE_URL ?>/assets/images/user-11-75x75.jpg" alt="" width="75" height="75" /></a></div>
                <div class="unit-body">
                  <h5 class="quote-modern-cite"><a href="#">Catherine Williams</a></h5>
                  <p class="quote-modern-status">Local shop owner</p>
                </div>
              </div>
              <div class="quote-modern-text">
                <p class="q">I chose Creator because of their knowledge, experience and attention to detail that has
                  proven invaluable to me in creating a superior finished project, which attracts more clients to my
                  shop.</p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-4 wow fadeInRight" data-wow-delay=".1s">
            <article class="quote-modern quote-modern-custom">
              <div class="unit unit-spacing-md align-items-center">
                <div class="unit-left"><a class="quote-modern-figure" href="#"><img class="img-circles"
                      src="<?= SITE_URL ?>/assets/images/user-12-75x75.jpg" alt="" width="75" height="75" /></a></div>
                <div class="unit-body">
                  <h5 class="quote-modern-cite"><a href="#">Rupert Wood</a></h5>
                  <p class="quote-modern-status">House owner</p>
                </div>
              </div>
              <div class="quote-modern-text">
                <p class="q">This agency was highly recommended to me. The sensitivity, knowledge, vision and ultimate
                  execution this firm brought to the table was tremendous. Thank you for the amazing interior!</p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-4 wow fadeInRight" data-wow-delay=".2s">
            <article class="quote-modern quote-modern-custom">
              <div class="unit unit-spacing-md align-items-center">
                <div class="unit-left"><a class="quote-modern-figure" href="#"><img class="img-circles"
                      src="<?= SITE_URL ?>/assets/images/user-20-75x75.jpg" alt="" width="75" height="75" /></a></div>
                <div class="unit-body">
                  <h5 class="quote-modern-cite"><a href="#">Samantha Brown</a></h5>
                  <p class="quote-modern-status">Freelancer</p>
                </div>
              </div>
              <div class="quote-modern-text">
                <p class="q">Your professional guidance gave me results that far exceeded my expectations. My clients
                  thoroughly enjoy the fun, relaxing ambience that the interior design creates. Thank you!</p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-4 wow fadeInRight">
            <article class="quote-modern quote-modern-custom">
              <div class="unit unit-spacing-md align-items-center">
                <div class="unit-left"><a class="quote-modern-figure" href="#"><img class="img-circles"
                      src="<?= SITE_URL ?>/assets/images/user-11-75x75.jpg" alt="" width="75" height="75" /></a></div>
                <div class="unit-body">
                  <h5 class="quote-modern-cite"><a href="#">Catherine Williams</a></h5>
                  <p class="quote-modern-status">Local shop owner</p>
                </div>
              </div>
              <div class="quote-modern-text">
                <p class="q">I chose Creator because of their knowledge, experience and attention to detail that has
                  proven invaluable to me in creating a superior finished project, which attracts more clients to my
                  shop.</p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-4 wow fadeInRight" data-wow-delay=".1s">
            <article class="quote-modern quote-modern-custom">
              <div class="unit unit-spacing-md align-items-center">
                <div class="unit-left"><a class="quote-modern-figure" href="#"><img class="img-circles"
                      src="<?= SITE_URL ?>/assets/images/user-12-75x75.jpg" alt="" width="75" height="75" /></a></div>
                <div class="unit-body">
                  <h5 class="quote-modern-cite"><a href="#">Rupert Wood</a></h5>
                  <p class="quote-modern-status">House owner</p>
                </div>
              </div>
              <div class="quote-modern-text">
                <p class="q">This agency was highly recommended to me. The sensitivity, knowledge, vision and ultimate
                  execution this firm brought to the table was tremendous. Thank you for the amazing interior!</p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-4 wow fadeInRight" data-wow-delay=".2s">
            <article class="quote-modern quote-modern-custom">
              <div class="unit unit-spacing-md align-items-center">
                <div class="unit-left"><a class="quote-modern-figure" href="#"><img class="img-circles"
                      src="<?= SITE_URL ?>/assets/images/user-20-75x75.jpg" alt="" width="75" height="75" /></a></div>
                <div class="unit-body">
                  <h5 class="quote-modern-cite"><a href="#">Samantha Brown</a></h5>
                  <p class="quote-modern-status">Freelancer</p>
                </div>
              </div>
              <div class="quote-modern-text">
                <p class="q">Your professional guidance gave me results that far exceeded my expectations. My clients
                  thoroughly enjoy the fun, relaxing ambience that the interior design creates. Thank you!</p>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>


    <!-- Upcoming Events Section -->
    <section class="section section-sm bg-default" id="prossimi-eventi">
      <div class="container">
        <h3 class="wow fadeInLeft">Prossimi Eventi</h3>
        <p class="wow fadeInRight" data-wow-delay=".1s">Ecco i nostri prossimi appuntamenti dove potrete ascoltarci dal vivo</p>
        
        <div class="row row-30 justify-content-center">
          <!-- Event Card 1 -->
          <div class="col-md-6 col-lg-4 wow fadeInUp">
            <article class="card event-card">
              <div class="card-body">
                <time datetime="2025-06-15T20:00" class="event-date">
                  <span class="event-day">15</span>
                  <span class="event-month">Giugno</span>
                </time>
                <h4 class="event-title">Concerto Estivo</h4>
                <p class="event-location"><i class="bi bi-geo-alt"></i> Piazza Maggiore, Castello Tesino</p>
                <p class="event-time"><i class="bi bi-clock"></i> 20:00</p>
                <a href="<?= SITE_URL ?>/eventi.php" class="button button-primary button-ujarak">Dettagli</a>
              </div>
            </article>
          </div>
          
          <!-- Event Card 2 -->
          <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".1s">
            <article class="card event-card">
              <div class="card-body">
                <time datetime="2025-07-10T21:00" class="event-date">
                  <span class="event-day">10</span>
                  <span class="event-month">Luglio</span>
                </time>
                <h4 class="event-title">Festival Folkloristico</h4>
                <p class="event-location"><i class="bi bi-geo-alt"></i> Pieve Tesino</p>
                <p class="event-time"><i class="bi bi-clock"></i> 21:00</p>
                <a href="<?= SITE_URL ?>/eventi.php" class="button button-primary button-ujarak">Dettagli</a>
              </div>
            </article>
          </div>
          
          <!-- Event Card 3 -->
          <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay=".2s">
            <article class="card event-card">
              <div class="card-body">
                <time datetime="2025-08-05T19:30" class="event-date">
                  <span class="event-day">5</span>
                  <span class="event-month">Agosto</span>
                </time>
                <h4 class="event-title">Concerto in Piazza</h4>
                <p class="event-location"><i class="bi bi-geo-alt"></i> Cinte Tesino</p>
                <p class="event-time"><i class="bi bi-clock"></i> 19:30</p>
                <a href="<?= SITE_URL ?>/eventi.php" class="button button-primary button-ujarak">Dettagli</a>
              </div>
            </article>
          </div>
        </div>
        
        <div class="text-center mt-5">
          <a href="<?= SITE_URL ?>/eventi.php" class="button button-lg button-primary">Vedi Tutti gli Eventi</a>
        </div>
      </div>
    </section>
    
    <!-- Music Player Section -->
    <section class="section section-sm bg-default" id="ascolta">
      <div class="container">
        <h3 class="wow fadeInLeft">Ascolta la Nostra Musica</h3>
        <p class="wow fadeInRight" data-wow-delay=".1s">Ecco alcune delle nostre esecuzioni più recenti</p>
        
        <div class="music-player-container">
          <div class="row">
            <div class="col-lg-8 mx-auto wow fadeIn">
              <div class="music-player">
                <div class="track-info">
                  <h4 class="track-title">Marcia Trentina</h4>
                  <p class="track-album">Album: Tradizioni Tesine</p>
                </div>
                <div class="player-controls">
                  <audio id="audio-player" controls preload="metadata">
                    <source src="assets/audio/sample-track.mp3" type="audio/mpeg">
                    Il tuo browser non supporta l'elemento audio.
                  </audio>
                </div>
                <div class="track-list mt-4">
                  <div class="track-item active">
                    <span class="track-number">1.</span>
                    <span class="track-name">Marcia Trentina</span>
                    <span class="track-duration">3:45</span>
                  </div>
                  <div class="track-item">
                    <span class="track-number">2.</span>
                    <span class="track-name">Inno del Tesino</span>
                    <span class="track-duration">4:12</span>
                  </div>
                  <div class="track-item">
                    <span class="track-number">3.</span>
                    <span class="track-name">Valsugana</span>
                    <span class="track-duration">3:28</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
        <?php include_once TEMPLATES_PATH . 'footer.php'; ?>
  </div>
  <!-- Global Mailform Output-->
  <div class="snackbars" id="form-output-global"></div>
  <!-- Structured Data for Band Website -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "MusicGroup",
    "name": "Banda Folk di Castello Tesino",
    "url": "https://www.bandafolkcastellotesino.it",
    "image": "assets/images/FotoSanIppolito1.jpg",
    "description": "La Banda Folk di Castello Tesino è attiva dal 1901 e porta avanti la tradizione musicale del Trentino con concerti, eventi e corsi di musica.",
    "genre": "Folk Music",
    "foundingDate": "1901",
    "event": [
      {
        "@type": "Event",
        "name": "Concerto Estivo",
        "startDate": "2025-06-15T20:00",
        "location": {
          "@type": "Place",
          "name": "Piazza Maggiore",
          "address": "Castello Tesino, Trentino, Italia"
        }
      },
      {
        "@type": "Event",
        "name": "Festival Folkloristico",
        "startDate": "2025-07-10T21:00",
        "location": {
          "@type": "Place",
          "name": "Pieve Tesino",
          "address": "Pieve Tesino, Trentino, Italia"
        }
      }
    ]
  }
  </script>
  
  <!-- Javascript-->
  <script src="<?= SITE_URL ?>/assets/js/core.min.js"></script>
  <script src="<?= SITE_URL ?>/assets/js/script.js"></script>
</body>

</html>