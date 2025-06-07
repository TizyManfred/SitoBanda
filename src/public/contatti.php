<?php
/**
 * Contatti Page
 *
 * Contact page for SitoBanda website
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
$pageTitle = 'Contatti - Banda Folk di Castello Tesino';
$pageDescription = 'Contatta la Banda Folk di Castello Tesino per informazioni, richieste di concerti, o iscrizioni ai corsi di musica.';
$ogTitle = 'Contatti - Banda Folk di Castello Tesino';
$ogDescription = 'Metti mi piace alla nostra pagina Facebook e contatta la Banda Folk di Castello Tesino per informazioni sui concerti o proposte di collaborazione.';
$ogImage = SITE_URL . '/assets/images/FotoContatti1.jpg';

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
          <h1 class="breadcrumbs-custom-title">Contatti</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="<?php echo SITE_URL; ?>/index">Home</a></li>
            <li class="active">Contatti</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(<?php echo SITE_URL; ?>/assets/images/FotoContatti1.jpg);"></div>
      </div>
    </section>

    <!-- Contatti Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row row-50">
          <!-- Contact Info -->
          <div class="col-lg-5 pr-xl-5">
            <div class="contact-info-wrap">
              <h2>Informazioni di Contatto</h2>
              <div class="contact-info-list">
                <div class="contact-info-item">
                  <div class="icon">
                    <span class="fa fa-map-marker"></span>
                  </div>
                  <div class="text">
                    <h5>Indirizzo</h5>
                    <p>Banda Sociale Folkloristica di Castello Tesino<br>Via Venezia 18, 38053 Castello Tesino (TN)</p>
                  </div>
                </div>
                <div class="contact-info-item">
                  <div class="icon">
                    <span class="fa fa-phone"></span>
                  </div>
                  <div class="text">
                    <h5>Telefono</h5>
                    <p><a href="tel:+393208476252">+39 320 8476252</a></p>
                  </div>
                </div>
                <div class="contact-info-item">
                  <div class="icon">
                    <span class="fa fa-envelope"></span>
                  </div>
                  <div class="text">
                    <h5>Email</h5>
                    <p><a href="mailto:info@bandacastellotesino.it">info@bandacastellotesino.it</a></p>
                  </div>
                </div>
              </div>
              
              <div class="social-links mt-4">
                <h5>Seguici sui Social</h5>
                <div class="social-list">
                  <a href="https://www.facebook.com/bandacastellotesino" target="_blank" class="social-icon" aria-label="Facebook della Banda Folk di Castello Tesino">
                    <span class="fa fa-facebook"></span>
                  </a>
                  <a href="https://www.instagram.com/bandacastellotesino" target="_blank" class="social-icon" aria-label="Instagram della Banda Folk di Castello Tesino">
                    <span class="fa fa-instagram"></span>
                  </a>
                </div>
              </div>
              
              <div class="five-per-mille-block mt-5 p-4 bg-light">
                <h4>5 x Mille</h4>
                <p>Dona il tuo 5 x mille alla Banda Folk di Castello Tesino! A te non costa nulla e per noi è un gesto prezioso.</p>
                <p class="font-weight-bold">Il nostro codice fiscale è 01517580229</p>
                <p>Grazie!</p>
              </div>
            </div>
          </div>
          
          <!-- Contact Form -->
          <div class="col-lg-7">
            <div class="contact-form-wrap">
              <h2>Scrivici</h2>
              <p>Per avere informazioni sui nostri concerti o se vuoi proporci qualche nuova uscita non esitare a contattarci al numero <strong>320 8476252</strong> o inviandoci una mail compilando il form sottostante!</p>
              
              <form class="rd-form rd-mailform" id="contact-form" method="post" action="<?php echo SITE_URL; ?>/contatti">
                <div class="row row-20">
                  <div class="col-md-6">
                    <div class="form-wrap">
                      <input class="form-input" id="contact-name" type="text" name="name" data-constraints="@Required" required>
                      <label class="form-label" for="contact-name">Il tuo nome (richiesto)</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-wrap">
                      <input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Email @Required" required>
                      <label class="form-label" for="contact-email">La tua email (richiesto)</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-wrap">
                      <input class="form-input" id="contact-phone" type="tel" name="phone">
                      <label class="form-label" for="contact-phone">Il tuo numero di telefono (facoltativo)</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-wrap">
                      <input class="form-input" id="contact-subject" type="text" name="subject" data-constraints="@Required" required>
                      <label class="form-label" for="contact-subject">Oggetto</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-wrap">
                      <textarea class="form-input" id="contact-message" name="message" data-constraints="@Required" required></textarea>
                      <label class="form-label" for="contact-message">Il tuo messaggio</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-wrap">
                      <div class="recaptcha-wrap">
                        <!-- Add reCAPTCHA div here -->
                        <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 text-center">
                    <button class="button button-lg button-primary" type="submit">Invia Messaggio</button>
                  </div>
                </div>
              </form>
              
              <div class="contact-form-response mt-4">
                <!-- Response messages will appear here after form submission -->
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
    "@type": "Organization",
    "name": "Banda Folk di Castello Tesino",
    "url": "' . SITE_URL . '",
    "logo": "' . SITE_URL . '/assets/images/logo-banda.png",
    "image": "' . SITE_URL . '/assets/images/FotoContatti1.jpg",
    "description": "La Banda Folk di Castello Tesino è attiva dal 1901 e porta avanti la tradizione musicale del Trentino con concerti, eventi e corsi di musica.",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Via Venezia 18",
      "addressLocality": "Castello Tesino",
      "addressRegion": "TN",
      "postalCode": "38053",
      "addressCountry": "IT"
    },
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "+39 320 8476252",
      "email": "info@bandacastellotesino.it",
      "contactType": "General Inquiries"
    },
    "sameAs": [
      "https://www.facebook.com/bandacastellotesino",
      "https://www.instagram.com/bandacastellotesino"
    ]
  }';
  ?>

  <!-- reCAPTCHA Script -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  
  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
