<?php
/**
 * Organico Page
 *
 * Band members page for SitoBanda website
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
$pageTitle = 'Organico - Banda Folk di Castello Tesino';
$pageDescription = 'L\'organico della Banda Folk di Castello Tesino include musicisti di flauti, clarinetti, sassofoni, corni, trombe, tromboni, euphonium, tuba, percussioni e le tradizionali Marketenderinnen.';
$ogTitle = 'Organico - Banda Folk di Castello Tesino';
$ogDescription = 'Scopri i musicisti che compongono la Banda Folk di Castello Tesino, organizzati per sezioni strumentali.';
$ogImage = SITE_URL . '/assets/images/organico-banda.jpg';

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
          <h1 class="breadcrumbs-custom-title">Organico</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li><a href="chi-siamo.php">Chi Siamo</a></li>
            <li class="active">Organico</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(assets/images/organico-header.jpg);"></div>
      </div>
    </section>

    <!-- Organico Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-block">
              <p><strong>FLAUTI</strong> Loredana Dorigato, Eleonora Lucca, Daniele Zotta</p>
              <p><strong>CLARINETTI</strong> Anna Boso, Claudia Fabbro, Linda Franceschini, Miriam Franceschini, Gioia Gecele, Giorgio Moranduzzo, Giulia Moranduzzo, Gloria Moranduzzo, Valeria Villanova, Evelyn Zampiero, Anna Zotta</p>
              <p><strong>SAX CONTRALTI</strong> Alice Boso, Cristiano Toffol, Rebecca Zampiero</p>
              <p><strong>SAX TENORI</strong> Sara Fattore, Thomas Guzzo</p>
              <p><strong>FLICORNI SOPRANI</strong> Daniel Moranduzzo, Werner Moranduzzo, Daniel Terragnolo, Arianna Zampiero</p>
              <p><strong>TROMBE</strong> Luca Ambrosini, Gianni Boschetti, Lorenzo Boschetti, Giorgio Zampiero</p>
              <p><strong>CORNI</strong> Mario Ambrosini, Fulvia Nervo</p>
              <p><strong>TROMBONI</strong> Paolo Müller, Giacomo Zampiero, Italo Zampiero</p>
              <p><strong>EUPHONIUM</strong> Ivan Celli, Adriano Dorigato, Claudio Fattore, Matteo Moranduzzo, Michele Terragnolo</p>
              <p><strong>TUBA</strong> Gianluca Pasqualin</p>
              <p><strong>TIMPANI</strong> Daniel Moranduzzo</p>
              <p><strong>PERCUSSIONI</strong> Nicholas Dorigato, Michela Galvan, Tiziano Manfredi, Mattia Moranduzzo</p>
              <p><strong>Marketenderinnen</strong> Stefania Ballerin, Monica Boso, Elisa Menguzzo, Irma Simon</p>
              <p><strong>Direttore</strong> Ivan Villanova</p>
              <p><strong>Presidente</strong> Werner Moranduzzo</p>
            </div>
          </div>
        </div>

        

        <div class="row">
          <div class="col-12 text-center mt-5 pt-4">
            <div class="button-wrap">
              <a class="button button-lg button-primary" href="repertorio.php">Scopri il Nostro Repertorio</a>
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
    "description": "Banda folk tradizionale attiva dal 1901 nella Valle del Tesino, Trentino",
    "image": "' . SITE_URL . '/assets/images/organico-banda.jpg",
    "founder": "Martino Braus",
    "foundingDate": "1901",
    "genre": ["Folk Music", "Wind Band Music", "Traditional Trentino Music"],
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
    },
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
    ]
  }';
  ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
