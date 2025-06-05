<?php
/**
 * Concerti Page
 *
 * Concerts calendar page for SitoBanda website
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
$pageTitle = 'Concerti - Banda Folk di Castello Tesino';
$pageDescription = 'Calendario dei concerti ed esibizioni della Banda Folk di Castello Tesino, con date, orari e luoghi degli eventi passati e futuri.';
$ogTitle = 'Concerti ed Eventi - Banda Folk di Castello Tesino';
$ogDescription = 'Scopri le prossime esibizioni ed eventi della Banda Folk di Castello Tesino. Partecipa ai nostri concerti in Italia e all\'estero.';
$ogImage = SITE_URL . '/assets/images/concerto-header.jpg';

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
          <h1 class="breadcrumbs-custom-title">Concerti</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li><a href="eventi.php">Eventi</a></li>
            <li class="active">Concerti</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(assets/images/concerto-header.jpg);"></div>
      </div>
    </section>

    <!-- Concerti Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row justify-content-center text-center mb-4">
          <div class="col-lg-9">
            <h2>I Nostri Prossimi Concerti</h2>
            <p class="lead">La Banda Folk di Castello Tesino si esibisce regolarmente durante l'anno in occasioni speciali, festival e celebrazioni. Ecco i nostri prossimi appuntamenti:</p>
          </div>
        </div>

        <!-- Upcoming Concerts -->
        <div class="row row-50">
          <?php
          // Current date for comparing with event dates
          $currentDate = new DateTime('2025-06-01');
          
          // Sample upcoming concerts - in a real implementation, this would come from a database
          $upcomingConcerts = [
            [
              'title' => 'Concerto Estivo',
              'date' => '2025-06-15',
              'time' => '20:00',
              'location' => 'Piazza Maggiore, Castello Tesino',
              'description' => 'Tradizionale concerto estivo con repertorio di Blasmusik e musiche popolari trentine.',
              'image' => 'concerto-estivo.jpg'
            ],
            [
              'title' => 'Festival Folkloristico',
              'date' => '2025-07-10',
              'time' => '21:00',
              'location' => 'Pieve Tesino, Trentino',
              'description' => 'Partecipazione al Festival Folkloristico con bande da tutta la regione.',
              'image' => 'festival-folkloristico.jpg'
            ],
            [
              'title' => 'Festa di San Giorgio',
              'date' => '2025-08-23',
              'time' => '17:30',
              'location' => 'Chiesa di San Giorgio, Castello Tesino',
              'description' => 'Concerto in occasione della festa patronale di San Giorgio.',
              'image' => 'san-giorgio.jpg'
            ]
          ];

          foreach ($upcomingConcerts as $concert) :
            $eventDate = new DateTime($concert['date']);
            $formattedDate = $eventDate->format('d/m/Y');
          ?>
          <div class="col-md-6 col-lg-4">
            <div class="post-modern wow fadeIn">
              <div class="post-modern-figure">
                <img src="assets/images/concerti/<?= $concert['image'] ?>" alt="<?= $concert['title'] ?>" width="370" height="255" loading="lazy">
                <div class="post-modern-date">
                  <time datetime="<?= $concert['date'] ?>T<?= $concert['time'] ?>">
                    <span class="post-modern-date-month"><?= $eventDate->format('M') ?></span>
                    <span class="post-modern-date-day"><?= $eventDate->format('d') ?></span>
                  </time>
                </div>
              </div>
              <h4 class="post-modern-title"><?= $concert['title'] ?></h4>
              <ul class="post-modern-meta">
                <li><i class="fa fa-clock-o"></i> <?= $concert['time'] ?></li>
                <li><i class="fa fa-map-marker"></i> <?= $concert['location'] ?></li>
              </ul>
              <p><?= $concert['description'] ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Past Concerts -->
        <div class="row justify-content-center text-center mt-5 mb-4">
          <div class="col-lg-9">
            <h2>Concerti Passati</h2>
            <p>Rivivi alcuni dei nostri concerti più significativi degli ultimi anni:</p>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Data</th>
                <th>Evento</th>
                <th>Luogo</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><time datetime="2024-12-22">22/12/2024</time></td>
                <td>Concerto di Natale</td>
                <td>Chiesa Parrocchiale, Castello Tesino</td>
              </tr>
              <tr>
                <td><time datetime="2024-09-08">08/09/2024</time></td>
                <td>Festa delle Brise a Caoria</td>
                <td>Caoria, Valle del Vanoi</td>
              </tr>
              <tr>
                <td><time datetime="2024-08-12">12/08/2024</time></td>
                <td>Concerto d'Estate</td>
                <td>Piazza Maggiore, Castello Tesino</td>
              </tr>
              <tr>
                <td><time datetime="2024-04-23">23/04/2024</time></td>
                <td>Festa di San Giorgio</td>
                <td>Chiesa di San Giorgio, Castello Tesino</td>
              </tr>
              <tr>
                <td><time datetime="2023-12-26">26/12/2023</time></td>
                <td>Concerto di Santo Stefano</td>
                <td>Teatro Comunale, Castello Tesino</td>
              </tr>
              <tr>
                <td><time datetime="2023-09-14">14/09/2023</time></td>
                <td>Sommer Bier Fest</td>
                <td>San Martino di Castrozza</td>
              </tr>
              <tr>
                <td><time datetime="2023-07-13">13/07/2023</time></td>
                <td>Festival Bandistico</td>
                <td>Auronzo di Cadore</td>
              </tr>
              <tr>
                <td><time datetime="2023-06-29">29/06/2023</time></td>
                <td>Concerto Estivo</td>
                <td>Zortea, Valle del Vanoi</td>
              </tr>
              <tr>
                <td><time datetime="2023-06-15">15/06/2023</time></td>
                <td>Festa della Musica</td>
                <td>Valdobbiadene</td>
              </tr>
              <tr>
                <td><time datetime="2018-09-13">13-20/09/2018</time></td>
                <td>Shanghai Tourism Festival</td>
                <td>Shanghai, Cina</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="row">
          <div class="col-12 text-center mt-5 pt-4">
            <div class="button-wrap">
              <a class="button button-lg button-primary" href="gallery.php">Guarda le Foto</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include_once TEMPLATES_PATH . 'footer.php'; ?>
  </div>

  <?php
  // Define structured data for this page - Events
  $pageStructuredData = '{
    "@context": "https://schema.org",
    "@type": "EventSeries",
    "name": "Concerti della Banda Folk di Castello Tesino",
    "description": "Calendario dei concerti ed esibizioni della Banda Folk di Castello Tesino",
    "url": "' . SITE_URL . '/concerti.php",
    "image": "' . SITE_URL . '/assets/images/concerto-header.jpg",
    "organizer": {
      "@type": "MusicGroup",
      "name": "Banda Folk di Castello Tesino",
      "url": "' . SITE_URL . '"
    },
    "subEvent": [
      {
        "@type": "Event",
        "name": "Concerto Estivo",
        "description": "Tradizionale concerto estivo con repertorio di Blasmusik e musiche popolari trentine.",
        "startDate": "2025-06-15T20:00",
        "endDate": "2025-06-15T22:00",
        "location": {
          "@type": "Place",
          "name": "Piazza Maggiore",
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Castello Tesino",
            "addressRegion": "TN",
            "addressCountry": "IT"
          }
        },
        "performer": {
          "@type": "MusicGroup",
          "name": "Banda Folk di Castello Tesino"
        }
      },
      {
        "@type": "Event",
        "name": "Festival Folkloristico",
        "description": "Partecipazione al Festival Folkloristico con bande da tutta la regione.",
        "startDate": "2025-07-10T21:00",
        "endDate": "2025-07-10T23:00",
        "location": {
          "@type": "Place",
          "name": "Pieve Tesino",
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Pieve Tesino",
            "addressRegion": "TN",
            "addressCountry": "IT"
          }
        },
        "performer": {
          "@type": "MusicGroup",
          "name": "Banda Folk di Castello Tesino"
        }
      }
    ]
  }';
  ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
