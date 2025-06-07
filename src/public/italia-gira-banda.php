<?php
/**
 * Italia Gira Banda Page
 *
 * Information about the national band tour event
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
$pageTitle = 'Italia Gira Banda - Banda Folk di Castello Tesino';
$pageDescription = 'Italia Gira Banda è l\'evento che unisce le bande folkloristiche italiane in un percorso di condivisione e performance attraverso l\'intero territorio nazionale.';
$ogTitle = 'Italia Gira Banda - Banda Folk di Castello Tesino';
$ogDescription = 'Scopri il progetto Italia Gira Banda e le esibizioni della Banda Folk di Castello Tesino nelle città italiane che aderiscono all\'iniziativa.';
$ogImage = SITE_URL . '/assets/images/italia-gira-banda-header.jpg';

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
          <h1 class="breadcrumbs-custom-title">Italia Gira Banda</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li class="active">Italia Gira Banda</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(assets/images/italia-gira-banda-header.jpg);"></div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row row-50 justify-content-center">
          <!-- Main Text -->
          <div class="col-lg-10 col-xl-8">
            <div class="event-description-wrap">
              <h2>Il Progetto "Italia Gira Banda"</h2>
              <div class="event-main-image">
                <img src="assets/images/italia-gira-banda-logo.jpg" alt="Logo del progetto Italia Gira Banda" class="img-fluid">
              </div>
              
              <div class="event-text mt-4">
                <p class="lead">Italia Gira Banda è un progetto nazionale che nasce dalla volontà di creare una rete tra le bande folkloristiche italiane, promuovendo la condivisione di esperienze musicali e tradizioni culturali.</p>
                
                <p>Il progetto prevede un itinerario attraverso l'Italia, durante il quale le bande aderenti si esibiscono in diverse città, presentando il proprio repertorio tradizionale e condividendo il palcoscenico con le formazioni locali.</p>
                
                <h4 class="mt-5">Gli Obiettivi del Progetto</h4>
                <ul class="list-marked">
                  <li>Valorizzare il patrimonio musicale delle tradizioni folkloristiche regionali</li>
                  <li>Creare occasioni di scambio culturale tra musicisti di diversa provenienza</li>
                  <li>Promuovere il turismo culturale nei territori coinvolti</li>
                  <li>Rinnovare l'interesse verso la musica bandistica, soprattutto tra i giovani</li>
                  <li>Preservare e diffondere le tradizioni locali attraverso la musica</li>
                </ul>
                
                <h4 class="mt-5">La Nostra Partecipazione</h4>
                <p>La Banda Folk di Castello Tesino aderisce con entusiasmo all'iniziativa Italia Gira Banda fin dalla sua prima edizione. Per noi rappresenta un'occasione preziosa per far conoscere la tradizione musicale trentina al di fuori dei confini provinciali e, allo stesso tempo, arricchire il nostro bagaglio culturale attraverso il confronto con altre realtà bandistiche italiane.</p>
                
                <p>Nel corso degli anni, ci siamo esibiti in numerose città italiane, portando con noi non solo la nostra musica, ma anche il nostro caratteristico abito tradizionale, simbolo identitario della Valle del Tesino.</p>
                
                <div class="quote-classic">
                  <div class="quote-body">
                    <q>Italia Gira Banda rappresenta per noi non solo un'occasione di esibizione, ma un vero e proprio momento di crescita artistica e umana, attraverso lo scambio di esperienze con altre realtà bandistiche italiane.</q>
                    <cite>Werner Moranduzzo, Presidente della Banda Folk di Castello Tesino</cite>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Edizioni Section -->
        <div class="row mt-5">
          <div class="col-12">
            <h3 class="text-center mb-4">Le Nostre Edizioni</h3>
          </div>
        </div>
        
        <div class="row row-30">
          <!-- Edizione 2019 -->
          <div class="col-md-6 col-lg-4">
            <article class="event-card">
              <div class="event-card-body">
                <div class="event-card-header">
                  <h4>Edizione 2019: Toscana</h4>
                  <p class="event-date"><span class="fa fa-calendar"></span> 14-16 Giugno 2019</p>
                </div>
                <div class="event-image">
                  <img src="assets/images/italia-gira-banda-2019.jpg" alt="Italia Gira Banda 2019 in Toscana" class="img-fluid">
                </div>
                <div class="event-details">
                  <p>La banda si è esibita nelle piazze di Follonica, Castiglione della Pescaia e Marina di Grosseto, in collaborazione con la Filarmonica Follonichese.</p>
                  <a href="gallery-album/italia-gira-banda-2019" class="button button-sm button-primary">Guarda le foto</a>
                </div>
              </div>
            </article>
          </div>
          
          <!-- Edizione 2018 -->
          <div class="col-md-6 col-lg-4">
            <article class="event-card">
              <div class="event-card-body">
                <div class="event-card-header">
                  <h4>Edizione 2018: Veneto</h4>
                  <p class="event-date"><span class="fa fa-calendar"></span> 8-10 Giugno 2018</p>
                </div>
                <div class="event-image">
                  <img src="assets/images/italia-gira-banda-2018.jpg" alt="Italia Gira Banda 2018 in Veneto" class="img-fluid">
                </div>
                <div class="event-details">
                  <p>Partecipazione alle manifestazioni a Chioggia e Sottomarina, con la partecipazione della Banda Cittadina di Chioggia e un grande concerto finale sul lungomare.</p>
                  <a href="gallery-album/italia-gira-banda-2018" class="button button-sm button-primary">Guarda le foto</a>
                </div>
              </div>
            </article>
          </div>
          
          <!-- Edizione 2017 -->
          <div class="col-md-6 col-lg-4">
            <article class="event-card">
              <div class="event-card-body">
                <div class="event-card-header">
                  <h4>Edizione 2017: Sicilia</h4>
                  <p class="event-date"><span class="fa fa-calendar"></span> 22-25 Maggio 2017</p>
                </div>
                <div class="event-image">
                  <img src="assets/images/italia-gira-banda-2017.jpg" alt="Italia Gira Banda 2017 in Sicilia" class="img-fluid">
                </div>
                <div class="event-details">
                  <p>Trasferta siciliana con esibizioni a Catania, Taormina e Siracusa insieme alle bande locali, creando un suggestivo incontro tra la tradizione alpina e quella mediterranea.</p>
                  <a href="gallery-album/italia-gira-banda-2017" class="button button-sm button-primary">Guarda le foto</a>
                </div>
              </div>
            </article>
          </div>
        </div>
        
        <!-- Prossima Edizione -->
        <div class="row mt-5">
          <div class="col-12">
            <div class="box-cta text-center">
              <h3>Prossima Edizione: Lombardia 2023</h3>
              <p>Segui le nostre pagine social e il calendario dei concerti per rimanere aggiornato sulla prossima edizione di Italia Gira Banda!</p>
              <a href="concerti.php" class="button button-lg button-primary">Calendario Concerti</a>
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
    "@type": "Event",
    "name": "Italia Gira Banda",
    "description": "Progetto nazionale che unisce le bande folkloristiche italiane in un percorso di condivisione e performance attraverso l\'intero territorio nazionale",
    "image": "' . SITE_URL . '/assets/images/italia-gira-banda-header.jpg",
    "organizer": {
      "@type": "Organization",
      "name": "Associazione Italia Gira Banda",
      "url": "http://www.italiagirabanda.it"
    },
    "performer": {
      "@type": "MusicGroup",
      "name": "Banda Folk di Castello Tesino"
    },
    "location": {
      "@type": "Place",
      "name": "Varie città italiane",
      "address": {
        "@type": "PostalAddress",
        "addressCountry": "IT"
      }
    },
    "subEvent": [
      {
        "@type": "Event",
        "name": "Italia Gira Banda 2019 - Toscana",
        "startDate": "2019-06-14",
        "endDate": "2019-06-16",
        "location": {
          "@type": "Place",
          "name": "Follonica, Toscana",
          "address": {
            "@type": "PostalAddress",
            "addressRegion": "Toscana",
            "addressCountry": "IT"
          }
        }
      },
      {
        "@type": "Event",
        "name": "Italia Gira Banda 2018 - Veneto",
        "startDate": "2018-06-08",
        "endDate": "2018-06-10",
        "location": {
          "@type": "Place",
          "name": "Chioggia, Veneto",
          "address": {
            "@type": "PostalAddress",
            "addressRegion": "Veneto",
            "addressCountry": "IT"
          }
        }
      }
    ]
  }';
  ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
