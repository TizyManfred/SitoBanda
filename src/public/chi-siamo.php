<?php
/**
 * Chi Siamo Page
 *
 * Main about us page for SitoBanda website
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

<?php
// Define page-specific meta variables
$pageTitle = 'Chi Siamo - Banda Folk di Castello Tesino';
$pageDescription = 'La Banda Folk di Castello Tesino, attiva dal 1901, è custode della tradizione musicale trentina: scopri la nostra storia, l\'organico e il repertorio.';
$ogTitle = 'Chi Siamo - Banda Folk di Castello Tesino';
$ogDescription = 'Scopri la Banda Folk di Castello Tesino: la storia dal 1901 ad oggi, il nostro maestro, i musicisti e il repertorio tradizionale trentino.';
$ogImage = SITE_URL . '/assets/images/chi-siamo-header.jpg';

// Include the head template
include_once TEMPLATES_PATH . 'head.php';
?>

<body>
  <div class="preloader">
    <div class="preloader-body">
      <div class="cssload-container"><span></span><span></span><span></span><span></span>
      </div>
    </div>
  </div>

  <div class="page">
    <?php include_once TEMPLATES_PATH . 'header.php'; ?>

    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
      <div class="breadcrumbs-custom context-dark">
        <div class="container">
          <h1 class="breadcrumbs-custom-title">Chi Siamo</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li class="active">Chi Siamo</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(assets/images/chi-siamo-header.jpg);"></div>
      </div>
    </section>

    <!-- Chi Siamo Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row justify-content-center text-center mb-4">
          <div class="col-lg-9">
            <h2>La Banda Folk di Castello Tesino</h2>
            <p class="lead">Dal 1901 portiamo avanti la tradizione musicale della Valle del Tesino, mescolando l'antico costume tradizionale con la passione per la musica bandistica e folkloristica.</p>
          </div>
        </div>

        <!-- About Us Cards -->
        <div class="row row-30 row-md-50">
          <!-- Storia -->
          <div class="col-sm-6 col-lg-4">
            <article class="box-icon-classic">
              <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column text-lg-center flex-xl-row text-xl-left">
                <div class="unit-left">
                  <div class="box-icon-classic-icon fl-bigmug-line-circular220"></div>
                </div>
                <div class="unit-body">
                  <h5 class="box-icon-classic-title"><a href="storia.php">Storia</a></h5>
                  <p class="box-icon-classic-text">La tradizione musicale bandistica di Castello Tesino risale al 1901, con una storia ricca di eventi e cambiamenti che hanno portato alla banda che siamo oggi.</p>
                  <a href="storia.php" class="button button-sm button-primary">Scopri di più</a>
                </div>
              </div>
            </article>
          </div>
          
          <!-- Abito Tradizionale -->
          <div class="col-sm-6 col-lg-4">
            <article class="box-icon-classic">
              <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column text-lg-center flex-xl-row text-xl-left">
                <div class="unit-left">
                  <div class="box-icon-classic-icon fl-bigmug-line-up104"></div>
                </div>
                <div class="unit-body">
                  <h5 class="box-icon-classic-title"><a href="abito-tradizionale.php">L'Abito Tradizionale</a></h5>
                  <p class="box-icon-classic-text">L'abito tradizionale della Valle del Tesino, risalente al XVII secolo, rappresenta la prosperità e la ricchezza culturale del nostro territorio.</p>
                  <a href="abito-tradizionale.php" class="button button-sm button-primary">Scopri di più</a>
                </div>
              </div>
            </article>
          </div>
          
          <!-- Maestro -->
          <div class="col-sm-6 col-lg-4">
            <article class="box-icon-classic">
              <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column text-lg-center flex-xl-row text-xl-left">
                <div class="unit-left">
                  <div class="box-icon-classic-icon fl-bigmug-line-user144"></div>
                </div>
                <div class="unit-body">
                  <h5 class="box-icon-classic-title"><a href="maestro.php">Il Maestro</a></h5>
                  <p class="box-icon-classic-text">Dal 2003, la banda è guidata dal Maestro Ivan Villanova, clarinettista di fama internazionale con un ricco curriculum artistico.</p>
                  <a href="maestro.php" class="button button-sm button-primary">Scopri di più</a>
                </div>
              </div>
            </article>
          </div>
          
          <!-- Organico -->
          <div class="col-sm-6 col-lg-4">
            <article class="box-icon-classic">
              <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column text-lg-center flex-xl-row text-xl-left">
                <div class="unit-left">
                  <div class="box-icon-classic-icon fl-bigmug-line-two311"></div>
                </div>
                <div class="unit-body">
                  <h5 class="box-icon-classic-title"><a href="organico.php">Organico</a></h5>
                  <p class="box-icon-classic-text">I musicisti che compongono la banda rappresentano il cuore pulsante del nostro gruppo, suddivisi per sezioni strumentali.</p>
                  <a href="organico.php" class="button button-sm button-primary">Scopri di più</a>
                </div>
              </div>
            </article>
          </div>
          
          <!-- Repertorio -->
          <div class="col-sm-6 col-lg-4">
            <article class="box-icon-classic">
              <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column text-lg-center flex-xl-row text-xl-left">
                <div class="unit-left">
                  <div class="box-icon-classic-icon fl-bigmug-line-note35"></div>
                </div>
                <div class="unit-body">
                  <h5 class="box-icon-classic-title"><a href="repertorio.php">Repertorio</a></h5>
                  <p class="box-icon-classic-text">Il nostro repertorio spazia dalla musica tradizionale trentina a brani moderni, con un'attenzione particolare alla Blasmusik alpina.</p>
                  <a href="repertorio.php" class="button button-sm button-primary">Scopri di più</a>
                </div>
              </div>
            </article>
          </div>
          
          <!-- Corsi di Musica -->
          <div class="col-sm-6 col-lg-4">
            <article class="box-icon-classic">
              <div class="unit box-icon-classic-body flex-column flex-md-row text-md-left flex-lg-column text-lg-center flex-xl-row text-xl-left">
                <div class="unit-left">
                  <div class="box-icon-classic-icon fl-bigmug-line-musical118"></div>
                </div>
                <div class="unit-body">
                  <h5 class="box-icon-classic-title"><a href="corsi-di-musica.php">Corsi di Musica</a></h5>
                  <p class="box-icon-classic-text">La banda organizza corsi di musica per strumenti a fiato e percussioni, aperti a tutti a partire dagli 8 anni, senza limiti di età.</p>
                  <a href="corsi-di-musica.php" class="button button-sm button-primary">Scopri di più</a>
                </div>
              </div>
            </article>
          </div>
        </div>

        <!-- Video Presentation -->
        <div class="row mt-5">
          <div class="col-12">
            <div class="video-container text-center">
              <h3>Guarda il Video di Presentazione</h3>
              <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/VIDEO_ID" title="Video di presentazione della Banda Folk di Castello Tesino" allowfullscreen loading="lazy"></iframe>
              </div>
              <p class="mt-3">Un breve video che racconta la storia e le attività della nostra banda folk.</p>
            </div>
          </div>
        </div>

        <!-- Call to Action -->
        <div class="row mt-5">
          <div class="col-12 text-center">
            <div class="box-cta">
              <h3>Vuoi Unirti alla Nostra Banda?</h3>
              <p>Sei un musicista o desideri imparare a suonare uno strumento? La Banda Folk di Castello Tesino è sempre aperta a nuovi membri!</p>
              <a href="contatti.php" class="button button-lg button-primary">Contattaci</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include_once TEMPLATES_PATH . 'footer.php'; ?>
  </div>

  <?php
  // Define structured data for this page
  $pageStructuredData = '{
    "@context": "https://schema.org",
    "@type": "MusicGroup",
    "name": "Banda Folk di Castello Tesino",
    "description": "La Banda Folk di Castello Tesino è attiva dal 1901 e porta avanti la tradizione musicale del Trentino con concerti, eventi e corsi di musica.",
    "image": "' . SITE_URL . '/assets/images/chi-siamo-header.jpg",
    "founder": "Martino Braus",
    "foundingDate": "1901",
    "genre": ["Folk Music", "Wind Band Music", "Traditional Trentino Music"],
    "subOrganization": [
      {
        "@type": "MusicGroup",
        "name": "Gruppo Musicale Allievi"
      }
    ],
    "member": [
      {
        "@type": "Person",
        "name": "Ivan Villanova",
        "jobTitle": "Direttore"
      },
      {
        "@type": "Person",
        "name": "Werner Moranduzzo",
        "jobTitle": "Presidente"
      }
    ],
    "location": {
      "@type": "Place",
      "name": "Castello Tesino",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Castello Tesino",
        "addressRegion": "TN",
        "postalCode": "38053",
        "addressCountry": "IT"
      }
    }
  }';
  ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
