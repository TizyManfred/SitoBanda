<?php
/**
 * Storia Page
 *
 * History page for SitoBanda website
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
$pageTitle = 'Storia - Banda Folk di Castello Tesino';
$pageDescription = 'La tradizione musicale bandistica di Castello Tesino risale al 1901: grazie all\'acquisto di strumenti da parte di Martino Braus fu possibile costituire un complesso che partecipò nel 1903 ad un concorso musicale a Trento durante la Feste Vigiliane.';
$ogTitle = 'Storia - Banda Folk di Castello Tesino';
$ogDescription = 'La tradizione musicale bandistica di Castello Tesino risale al 1901. Scopri la centenaria storia della Banda Folk di Castello Tesino.';
$ogImage = SITE_URL . '/assets/images/FotoStoria1.jpg';

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
          <h1 class="breadcrumbs-custom-title">Storia</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="<?php echo SITE_URL; ?>/index">Home</a></li>
            <li><a href="<?php echo SITE_URL; ?>/chi-siamo">Chi Siamo</a></li>
            <li class="active">Storia</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(<?php echo SITE_URL; ?>/assets/images/FotoStoria1.jpg);"></div>
      </div>
    </section>

    <!-- Storia Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row row-50">
          <div class="col-lg-6 pr-xl-5">
            <div class="image-height-1 wow fadeIn" style="background-image: url(<?php echo SITE_URL; ?>/assets/images/FotoStoria2.jpg);"></div>
          </div>
          <div class="col-lg-6">
            <div class="text-block">
              <h3>Un po' di Storia…</h3>
              <p>La tradizione musicale bandistica di Castello Tesino risale al 1901: grazie all'acquisto di strumenti da parte di Martino Braus fu possibile costituire un complesso che partecipò nel 1903 ad un concorso musicale a Trento durante la Feste Vigiliane. Fu quella la prima uscita ufficiale, che fruttò alla Banda "pergamena e bandiera". Nel 1909 fu redatto il primo Statuto che venne approvato dall'Imperial Regia Luogotenenza di Innsbruck. Nel 1964 Carlo Deflorian e Bruno Zanettin ripresero l'attività della banda portando la sede all'Oratorio. Nel 1981 il sodalizio venne dotato dei tradizionali ed antichi costumi del Tesino e rinominato Banda Sociale Folkloristica. L'intensa attività, con il Maestro Lele Lauter, trovò il meritato coronamento nell'incisione di un LP.</p>
              <p>Nel 2001 la Banda, diretta dal M° Claudio Dorigato, ha festeggiato il suo primo centenario di fondazione attraverso un'apprezzata rassegna alla quale hanno partecipato numerosi complessi bandistici trentini.</p>
            </div>
          </div>
        </div>

        <div class="row row-50 pt-5">
          <div class="col-lg-6 order-lg-2">
            <div class="image-height-1 wow fadeIn" style="background-image: url(<?php echo SITE_URL; ?>/assets/images/FotoStoria3.jpeg);"></div>
          </div>
          <div class="col-lg-6">
            <div class="text-block wow fadeInLeft">
              <p>Dal 2003 è guidata dal M° <a href="<?php echo SITE_URL; ?>/maestro">Ivan Villanova</a>, ed il presidente in carica è Werner Moranduzzo. Il complesso possiede un gustoso repertorio di Blasmusik, e questa caratteristica, unita all'autenticità e bellezza dei costumi tradizionali della Valle del Tesino, porta la nostra Banda ad essere frequentemente invitata in numerose località nazionali.</p>
              <p>Nel 2008 ha rappresentato a Roma il Trentino nella "Festa della Musica Popolare" in onore di Santa Cecilia, promossa dal Ministero dei Beni Culturali. Successivamente è stata ospite di numerose rassegne nazionali e internazionali tra le quali: Raduno bandistico nazionale di Gubbio (PG), Rassegna Arcadia musica e sapori (Val di Sole), Internationales Blasmusikertreffen di Wolfsberg (Austria), Traubenfest di Merano (BZ), Festival Internazionale di Giulianova (TE), FAKS Festival di Rovigno (Croazia), Rassegna Bandistica di Follonica (GR).</p>
              <p>Nel 2018 viene invitata, unica banda italiana, al Shanghai Tourism Festival, ottenendo il Best Popularity Award tra i 57 gruppi partecipanti!</p>
              <p class="font-weight-bold mt-4">Associazione di Promozione Sociale – Iscrizione n. 108/5, Sez. A del registro provinciale</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 text-center mt-5 pt-4">
            <div class="button-wrap">
              <a class="button button-lg button-primary" href="<?php echo SITE_URL; ?>/abito-tradizionale">Scopri l'Abito Tradizionale</a>
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
    "@type": "Article",
    "headline": "Storia della Banda Folk di Castello Tesino",
    "description": "La storia della Banda Folk di Castello Tesino dal 1901 ad oggi",
    "image": "' . SITE_URL . '/assets/images/FotoStoria1.jpg",
    "datePublished": "2025-06-01",
    "publisher": {
      "@type": "Organization",
      "name": "Banda Folk di Castello Tesino",
      "logo": {
        "@type": "ImageObject",
        "url": "' . SITE_URL . '/assets/images/logo-banda.png"
      }
    }
  }';
  ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
