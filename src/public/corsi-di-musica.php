<?php
/**
 * Corsi di Musica Page
 *
 * Music courses page for SitoBanda website
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
$pageTitle = 'Corsi di Musica - Banda Folk di Castello Tesino';
$pageDescription = 'I corsi di musica della Banda Folk di Castello Tesino: impara a suonare uno strumento e unisciti alla nostra banda. Corsi per tutte le età.';
$ogTitle = 'Corsi di Musica - Banda Folk di Castello Tesino';
$ogDescription = 'Scopri i corsi di musica offerti dalla Banda Folk di Castello Tesino per strumenti a fiato e percussioni. Aperto a tutti dai bambini agli adulti.';
$ogImage = SITE_URL . '/assets/images/corsi-musica-header.jpg';

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
          <h1 class="breadcrumbs-custom-title">Corsi di Musica</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li class="active">Corsi di Musica</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(assets/images/corsi-musica-header.jpg);"></div>
      </div>
    </section>

    <!-- Corsi di Musica Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row row-50 justify-content-center">
          <!-- Main Text -->
          <div class="col-lg-10 col-xl-8">
            <div class="course-description-wrap">
              <h2>Impara a Suonare con Noi</h2>
              <div class="course-main-image">
                <img src="assets/images/corsi-musica-main.jpg" alt="Corsi di Musica della Banda Folk di Castello Tesino" class="img-fluid">
              </div>
              
              <div class="course-text mt-4">
                <p class="lead">La Banda Folk di Castello Tesino organizza corsi di musica per avvicinare giovani e adulti al mondo della musica bandistica.</p>
                
                <p>I nostri corsi sono aperti a tutti, a partire dagli 8 anni di età e senza limiti superiori. Non è mai troppo tardi per imparare a suonare uno strumento e unirsi alla nostra banda!</p>
                
                <h4 class="mt-5">Strumenti Insegnati</h4>
                <div class="row row-30 mt-4">
                  <div class="col-md-6">
                    <div class="instrument-category">
                      <h5>Strumenti a Fiato - Legni</h5>
                      <ul class="list-marked">
                        <li>Clarinetto</li>
                        <li>Flauto Traverso</li>
                        <li>Sassofono</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="instrument-category">
                      <h5>Strumenti a Fiato - Ottoni</h5>
                      <ul class="list-marked">
                        <li>Tromba</li>
                        <li>Trombone</li>
                        <li>Corno</li>
                        <li>Euphonium/Flicorno Baritono</li>
                        <li>Tuba</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-6">
                    <div class="instrument-category">
                      <h5>Percussioni</h5>
                      <ul class="list-marked">
                        <li>Tamburo</li>
                        <li>Timpani</li>
                        <li>Xilofono</li>
                        <li>Batteria</li>
                      </ul>
                    </div>
                  </div>
                </div>
                
                <h4 class="mt-5">Struttura dei Corsi</h4>
                <p>I corsi sono strutturati in lezioni individuali di strumento e lezioni collettive di teoria e solfeggio. Le lezioni si tengono generalmente nel periodo da ottobre a maggio, presso la sede della banda in Via Venezia 18 a Castello Tesino.</p>
                
                <div class="course-schedule mt-4">
                  <h5>Organizzazione delle Lezioni</h5>
                  <ul class="list-marked">
                    <li><strong>Lezioni di strumento:</strong> 1 ora settimanale individuale</li>
                    <li><strong>Lezioni di teoria musicale:</strong> 1 ora settimanale in gruppo</li>
                    <li><strong>Musica d'insieme:</strong> 1 ora settimanale (dal secondo anno)</li>
                  </ul>
                </div>
                
                <div class="quote-classic mt-5">
                  <div class="quote-body">
                    <q>La musica è un linguaggio universale che avvicina le persone e crea legami. Con i nostri corsi vogliamo offrire la possibilità a tutti, dai più giovani ai meno giovani, di avvicinarsi a questa meravigliosa forma d'arte.</q>
                    <cite>Maestro Ivan Villanova</cite>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Sidebar -->
          <div class="col-lg-10 col-xl-4">
            <div class="aside-component">
              <div class="card">
                <div class="card-header">
                  <h4>Iscrizioni A.A. 2023-2024</h4>
                </div>
                <div class="card-body">
                  <p><strong>Periodo di iscrizione:</strong><br>
                  1 Settembre - 15 Ottobre 2023</p>
                  
                  <p><strong>Inizio corsi:</strong><br>
                  20 Ottobre 2023</p>
                  
                  <p><strong>Quote di partecipazione:</strong><br>
                  €220 annuali (€180 per gli under 14)</p>
                  
                  <p>La quota comprende:</p>
                  <ul class="list-marked">
                    <li>Lezioni individuali e di gruppo</li>
                    <li>Materiale didattico</li>
                    <li>Prestito dello strumento per i primi 2 anni</li>
                  </ul>
                  
                  <div class="mt-4">
                    <a href="contatti.php" class="button button-lg button-primary button-block">Richiedi Informazioni</a>
                  </div>
                </div>
              </div>
              
              <!-- Testimonials -->
              <div class="card mt-4">
                <div class="card-header">
                  <h4>Cosa Dicono i Nostri Allievi</h4>
                </div>
                <div class="card-body">
                  <div class="testimonial">
                    <p>"Ho iniziato a studiare clarinetto a 10 anni e ora, dopo 5 anni, sono parte della banda. Un'esperienza fantastica che mi ha insegnato non solo la musica ma anche il valore della collaborazione."</p>
                    <p class="testimonial-author">- Marco, 15 anni</p>
                  </div>
                  <hr>
                  <div class="testimonial">
                    <p>"Da adulta pensavo fosse troppo tardi per imparare, invece dopo 2 anni suono il flauto in banda. Gli insegnanti sono pazienti e competenti."</p>
                    <p class="testimonial-author">- Laura, 42 anni</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Annual Concert Section -->
        <div class="row mt-5">
          <div class="col-12">
            <div class="box-cta">
              <h3>Saggio Finale degli Allievi</h3>
              <p>Ogni anno, nel mese di maggio, si tiene il saggio finale degli allievi dei corsi. Un'occasione per mostrare i progressi raggiunti durante l'anno e per esibirsi davanti a familiari e amici.</p>
              <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/VIDEO_ID" title="Video del saggio degli allievi" allowfullscreen loading="lazy"></iframe>
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

  <?php
  // Define structured data for this page
  $pageStructuredData = '{
    "@context": "https://schema.org",
    "@type": "Course",
    "name": "Corsi di Musica della Banda Folk di Castello Tesino",
    "description": "Corsi di musica per strumenti a fiato e percussioni organizzati dalla Banda Folk di Castello Tesino, aperti a tutti a partire dagli 8 anni.",
    "provider": {
      "@type": "Organization",
      "name": "Banda Folk di Castello Tesino",
      "sameAs": "' . SITE_URL . '"
    },
    "hasCourseInstance": {
      "@type": "CourseInstance",
      "courseMode": ["onsite"],
      "location": {
        "@type": "Place",
        "name": "Sede della Banda Folk di Castello Tesino",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "Via Venezia 18",
          "addressLocality": "Castello Tesino",
          "addressRegion": "TN",
          "postalCode": "38053",
          "addressCountry": "IT"
        }
      },
      "startDate": "2023-10-20",
      "endDate": "2024-05-31",
      "offers": {
        "@type": "Offer",
        "price": "220",
        "priceCurrency": "EUR"
      }
    }
  }';
  ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
