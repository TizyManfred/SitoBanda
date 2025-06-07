<?php
/**
 * Maestro Page
 *
 * Page about the band conductor for SitoBanda website
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
$pageTitle = 'Maestro - Banda Folk di Castello Tesino';
$pageDescription = 'Ivan Villanova, direttore della Banda Folk di Castello Tesino dal 2003, è un clarinettista di livello internazionale che ha suonato in prestigiose orchestre in Europa, USA, Emirati Arabi e Giappone.';
$ogTitle = 'Maestro Ivan Villanova - Banda Folk di Castello Tesino';
$ogDescription = 'Scopri il percorso musicale e le realizzazioni del Maestro Ivan Villanova, direttore della Banda Folk di Castello Tesino.';
$ogImage = SITE_URL . '/assets/images/FotoMaestro1.jpg';

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
          <h1 class="breadcrumbs-custom-title">Il Nostro Maestro</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="<?php echo SITE_URL; ?>/index">Home</a></li>
            <li><a href="<?php echo SITE_URL; ?>/chi-siamo">Chi Siamo</a></li>
            <li class="active">Maestro</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(<?php echo SITE_URL; ?>/assets/images/FotoMaestro1.jpg);"></div>
      </div>
    </section>

    <!-- Maestro Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row row-50">
          <div class="col-lg-5 pr-xl-5">
            <div class="image-height-1 wow fadeIn">
              <img src="<?php echo SITE_URL; ?>/assets/images/FotoMaestro2.jpg" alt="Maestro Ivan Villanova" width="470" loading="lazy" />
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-block">
              <h2>IVAN VILLANOVA</h2>
              <p>Dopo il diploma in clarinetto si perfeziona con Fabio di Casola al Conservatorio della Svizzera Italiana e viene premiato in numerosi concorsi nazionali ed internazionali, tra i quali il 1° Premio assoluto al “Città di Stresa” 1996. Ha suonato come Primo Clarinetto nell'Orchestra Sinfonica dell'Emilia-Romagna “Fondazione Arturo Toscanini”, l'Orchestra del Gran Teatro “La Fenice”, la Filarmonia Veneta e l'Orchestra d'Archi Italiana, collaborando inoltre con L'Orchestra di Padova e del Veneto, l'Orchestra del Teatro “G. Verdi” di Trieste, La Filarmonica di Modena e la Symphonica Toscanini (diretta da Lorin Maazel), con tournée in Europa, USA, Emirati Arabi e Giappone. È docente di Clarinetto alla Scuola Musicale di Primiero ed ha insegnato clarinetto ai Corsi Internazionali di Perfezionamento di Spilimbergo.</p>
              <p>Si diploma in Direzione all'Istituto Superiore Europeo Bandistico sotto la guida di Jan Cober, Felix Hauswirth e Carlo Pirola, e nel 2009 vi consegue anche il Diploma Superiore, perfezionandosi poi con Jan Cober alla Bläserakademie Sächsen e con Douglas Bostock alla Bund Deutscher Blasmusikverbände. Direttore principale della Dolomiti Wind Orchestra, guida la Banda Folkloristica di Castello Tesino e la Banda Città di Feltre. Ha insegnato Direzione ai Corsi Internazionali di Spilimbergo, a fianco di José Rafael Pascual-Vilaplana.</p>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-12">
            <div class="card-group-custom card-group-corporate" id="accordion1" role="tablist" aria-multiselectable="false">
              <!-- Attività Musicale -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a class="collapsed" id="accordion1-card-head-aqutbwhs" data-toggle="collapse" data-parent="#accordion1" href="#accordion1-card-body-kwemateu" aria-controls="accordion1-card-body-kwemateu" aria-expanded="false" role="button">Attività Musicale
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse" id="accordion1-card-body-kwemateu" aria-labelledby="accordion1-card-head-aqutbwhs" data-parent="#accordion1" role="tabpanel">
                  <div class="card-body">
                    <p>Oltre alla direzione della Banda Folk di Castello Tesino, il Maestro Villanova ha un'intensa attività musicale che include:</p>
                    <ul class="list-marked">
                      <li>Direzione della Dolomiti Wind Orchestra</li>
                      <li>Insegnamento presso varie scuole di musica in Trentino e Vienna</li>
                      <li>Partecipazione come giurato in concorsi internazionali di clarinetto</li>
                      <li>Esibizioni come solista in prestigiose sale da concerto europee</li>
                      <li>Masterclass e seminari di perfezionamento per clarinettisti</li>
                    </ul>
                  </div>
                </div>
              </article>
              <!-- Premi e Riconoscimenti -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a class="collapsed" id="accordion1-card-head-dwsuoxfi" data-toggle="collapse" data-parent="#accordion1" href="#accordion1-card-body-mvturbyd" aria-controls="accordion1-card-body-mvturbyd" aria-expanded="false" role="button">Premi e Riconoscimenti
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse" id="accordion1-card-body-mvturbyd" aria-labelledby="accordion1-card-head-dwsuoxfi" data-parent="#accordion1" role="tabpanel">
                  <div class="card-body">
                    <ul class="list-marked">
                      <li>"Premio Valentino Bucchi" di Roma</li>
                      <li>Premio "Città di Stresa"</li>
                      <li>Premio "Rovere d'oro"</li>
                      <li>Riconoscimento per l'eccellenza musicale dalla Provincia Autonoma di Trento</li>
                      <li>Best Popularity Award al Shanghai Tourism Festival 2018 (con la Banda Folk di Castello Tesino)</li>
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
              <a class="button button-lg button-primary" href="organico.php">Scopri l'Organico della Banda</a>
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
    "@type": "Person",
    "name": "Ivan Villanova",
    "jobTitle": "Direttore",
    "description": "Direttore della Banda Folk di Castello Tesino dal 2003, clarinettista di fama internazionale",
    "image": "' . SITE_URL . '/assets/images/FotoMaestro1.jpg",
    "worksFor": {
      "@type": "MusicGroup",
      "name": "Banda Folk di Castello Tesino",
      "url": "' . SITE_URL . '"
    },
    "knowsAbout": ["Clarinetto", "Direzione bandistica", "Musica tradizionale trentina"]
  }';
  ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
