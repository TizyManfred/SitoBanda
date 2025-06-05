<?php
/**
 * Repertorio Page
 *
 * Repertoire page for SitoBanda website
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
$pageTitle = 'Repertorio - Banda Folk di Castello Tesino';
$pageDescription = 'Il repertorio della Banda Folk di Castello Tesino include musica tradizionale trentina, marce tirolesi, classici per banda e arrangiamenti contemporanei.';
$ogTitle = 'Repertorio - Banda Folk di Castello Tesino';
$ogDescription = 'Scopri il repertorio musicale della Banda Folk di Castello Tesino dal 2012 ad oggi, con programmi regolari e speciali Blasmusik.';
$ogImage = SITE_URL . '/assets/images/repertorio.jpg';

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
          <h1 class="breadcrumbs-custom-title">Repertorio</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li><a href="chi-siamo.php">Chi Siamo</a></li>
            <li class="active">Repertorio</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(assets/images/repertorio-header.jpg);"></div>
      </div>
    </section>

    <!-- Repertorio Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row justify-content-center text-center mb-4">
          <div class="col-lg-9">
            <h2>Il Nostro Repertorio</h2>
            <p class="lead">La Banda Folk di Castello Tesino si esibisce con un repertorio variegato che include musica tradizionale trentina, marce tirolesi, classici per banda e arrangiamenti contemporanei.</p>
          </div>
        </div>

        <!-- Accordion with Repertoire by Year -->
        <div class="row">
          <div class="col-12">
            <div class="card-group-custom card-group-corporate" id="accordion-repertoire" role="tablist" aria-multiselectable="false">
              <!-- 2025 -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a id="accordion-heading-2025" data-toggle="collapse" data-parent="#accordion-repertoire" href="#accordion-collapse-2025" aria-controls="accordion-collapse-2025" aria-expanded="true" role="button">Repertorio 2025
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse show" id="accordion-collapse-2025" aria-labelledby="accordion-heading-2025" data-parent="#accordion-repertoire" role="tabpanel">
                  <div class="card-body">
                    <h5>Programma Concerto</h5>
                    <ul class="list-marked">
                      <li>Kaiserin Sissi Marsch - Timo Dellweg</li>
                      <li>Highlights from Chess - Arr. Johan de Meij</li>
                      <li>Oregon - Jacob de Haan</li>
                      <li>Fiemme Ski - Marco Somadossi</li>
                      <li>Ein Leben Lang - Martin Scharnagl</li>
                      <li>Concerto d'Amore - Jacob de Haan</li>
                    </ul>
                    <h5>Programma Blasmusik</h5>
                    <ul class="list-marked">
                      <li>Von Freund zu Freund - Martin Scharnagel</li>
                      <li>Dem Land Tirol die Treue - Florian Pedarnig</li>
                      <li>Feuerfest - Josef Strauss</li>
                      <li>Mein Heimatland - Thomas Greiner</li>
                      <li>Bergvagantenmarsch - Herbert Pixner, arr. Markus Linder</li>
                    </ul>
                  </div>
                </div>
              </article>
              
              <!-- 2024 -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a class="collapsed" id="accordion-heading-2024" data-toggle="collapse" data-parent="#accordion-repertoire" href="#accordion-collapse-2024" aria-controls="accordion-collapse-2024" aria-expanded="false" role="button">Repertorio 2024
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse" id="accordion-collapse-2024" aria-labelledby="accordion-heading-2024" data-parent="#accordion-repertoire" role="tabpanel">
                  <div class="card-body">
                    <h5>Programma Concerto</h5>
                    <ul class="list-marked">
                      <li>Jubelklänge - Ernst Uebel</li>
                      <li>The Lion King - Hans Zimmer, arr. Calvin Custer</li>
                      <li>Ross Roy - Jacob de Haan</li>
                      <li>Moment for Morricone - Ennio Morricone, arr. Johan de Meij</li>
                      <li>80er KULT(tour) - Medley, arr. Thiemo Kraas</li>
                    </ul>
                    <h5>Programma Blasmusik</h5>
                    <ul class="list-marked">
                      <li>Abel Tasman - Alexander Pfluger</li>
                      <li>Kaiserin Sissi - Timo Dellweg</li>
                      <li>Von Freund zu Freund - Martin Scharnagel</li>
                      <li>Böhmischer Traum - Norbert Gälle</li>
                      <li>Dem Land Tirol die Treue - Florian Pedarnig</li>
                    </ul>
                  </div>
                </div>
              </article>
              
              <!-- 2023 -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a class="collapsed" id="accordion-heading-2023" data-toggle="collapse" data-parent="#accordion-repertoire" href="#accordion-collapse-2023" aria-controls="accordion-collapse-2023" aria-expanded="false" role="button">Repertorio 2023
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse" id="accordion-collapse-2023" aria-labelledby="accordion-heading-2023" data-parent="#accordion-repertoire" role="tabpanel">
                  <div class="card-body">
                    <h5>Programma Concerto</h5>
                    <ul class="list-marked">
                      <li>Deutschmeister Regimentsmarsch - W. A. Jurek</li>
                      <li>Oregon - Jacob de Haan</li>
                      <li>Hindenburg - M. Leemann</li>
                      <li>Concerto D'Amore - Jacob de Haan</li>
                      <li>The Second Waltz - D. Shostakovich</li>
                      <li>Flashing Winds - Jan Van der Roost</li>
                    </ul>
                    <h5>Programma Natalizio</h5>
                    <ul class="list-marked">
                      <li>Carol of the Bells - arr. Sean O'Loughlin</li>
                      <li>White Christmas - Irving Berlin</li>
                      <li>Adeste Fideles - arr. Elliot Del Borgo</li>
                      <li>Christmas Fantasia - arr. Franco Cesarini</li>
                    </ul>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 text-center mt-5 pt-4">
            <div class="button-wrap">
              <a class="button button-lg button-primary" href="concerti.php">Scopri i Nostri Concerti</a>
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
    "@type": "MusicPlaylist",
    "name": "Repertorio della Banda Folk di Castello Tesino",
    "numTracks": 15,
    "track": [
      {
        "@type": "MusicRecording",
        "name": "Von Freund zu Freund",
        "composer": "Martin Scharnagel"
      },
      {
        "@type": "MusicRecording",
        "name": "Dem Land Tirol die Treue",
        "composer": "Florian Pedarnig"
      },
      {
        "@type": "MusicRecording",
        "name": "Kaiserin Sissi Marsch",
        "composer": "Timo Dellweg"
      }
    ]
  }';
  ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
