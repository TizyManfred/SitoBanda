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

// Include database connection
require_once ABSPATH . 'includes/database.php';

// Fetch events from database
$events = [];
try {
    // Get database connection
    $pdo = Database::getInstance();
    
    // Query to get public events, ordered by featured status (featured first) and then by date (newest first)
    $query = "SELECT * FROM events 
             WHERE is_public = 1 AND start_datetime <= NOW()
             ORDER BY is_featured DESC, start_datetime DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Log the error
    error_log("Error fetching events: " . $e->getMessage());
}

// Process events data for the template
$processedEvents = [];
$delay = 0;
$delayIncrement = 1; // Increment by 1 for integer operations (will be divided by 10 when used)

// Fetch upcoming events (today and future)
try {
    $db = Database::getInstance();
    $sql = "
        SELECT e.*, IFNULL(g.title, '') as gallery_title
        FROM events e
        LEFT JOIN gallery_albums g ON e.gallery_id = g.id
        WHERE e.is_public = 1 
        AND e.start_datetime >= NOW()
        ORDER BY e.start_datetime ASC
        LIMIT 3
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $upcomingEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log('Error fetching upcoming events: ' . $e->getMessage());
    $upcomingEvents = [];
}

foreach ($events as $event) {
    // Format date
    $eventDate = new DateTime($event['start_datetime']);
    $formattedDate = $eventDate->format('d/m/Y');
    
    // Set default image if none is provided
    $imagePath = !empty($event['image_path']) ? 
               SITE_URL . '/' . $event['image_path'] : 
               'assets/images/event-placeholder.jpg';
    
    // Animation class (alternate between fadeInLeft and fadeInRight)
    // Multiply by 10 to work with integers and avoid floating-point modulo
    $animationClass = (int)($delay * 10) % 2 == 0 ? 'fadeInLeft' : 'fadeInRight';
    
    // Add featured class if event is featured
    $featuredClass = $event['is_featured'] ? ' featured-event' : '';
    
    // Store processed event data
    $processedEvents[] = [
        'title' => $event['title'],
        'slug' => $event['slug'],
        'start_datetime' => $event['start_datetime'],
        'formatted_date' => $formattedDate,
        'location' => $event['location'] ?? '',
        'short_description' => $event['short_description'] ?? '',
        'image_path' => $imagePath,
        'is_featured' => $event['is_featured'],
        'animation_class' => $animationClass,
        'featured_class' => $featuredClass,
        'delay' => $delay
    ];
    
    // Increment delay for next item (using integer values)
    $delay += $delayIncrement;
}

// Define page-specific meta variables
$pageTitle = 'Banda Folk di Castello Tesino - Musica Tradizionale dal 1901';
$pageDescription = 'La Banda Folk di Castello Tesino, attiva dal 1901, porta avanti la tradizione musicale del Trentino con concerti, eventi e corsi di musica.';
$ogTitle = 'Banda Folk di Castello Tesino - Tradizione dal 1901';
$ogDescription = 'Scopri la Banda Folk di Castello Tesino, custode della tradizione musicale trentina dal 1901.';
$ogImage = SITE_URL . '/assets/images/FotoSanIppolito1.jpg';
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="it">

<?php
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
                      class="button button-md button-default-outline-2 button-wapasha" href="<?php echo SITE_URL; ?>/eventi">Scopri le date</a>
                  </div>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".1s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon bi-hourglass-split"></div>
                  <h5 class="box-icon-modern-title"><a href="<?php echo SITE_URL; ?>/storia">La nostra storia</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">Scopri di più sulla nostra storia che nasce più di 100 anni fa</p>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".2s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon bi-people-fill"></div>
                  <h5 class="box-icon-modern-title"><a href="<?php echo SITE_URL; ?>/organico">Organico</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">Scopri di più sulla composizione del nostro organico</p>
                </article>
              </div>

              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".3s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon bi-magic"></div>
                  <h5 class="box-icon-modern-title"><a href="<?php echo SITE_URL; ?>/maestro">Maestro</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">Conosci la storia del nostro maestro e la sua carriera musicale</p>
                </article>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Latest events-->
    <section class="section section-sm section-fluid bg-default text-center">
      <div class="container-fluid">
        <h3 class="wow fadeInLeft">Concerti e eventi rilevanti</h3>
        <p class="wow fadeInRight" data-wow-delay=".1s">Ecco alcuni concerti e sfilate rilevanti ai quali abbiamo
          partecipato nell'ultimo periodo</p>

        <div class="row row-30 isotope" data-isotope-layout="fitRows" data-isotope-group="gallery" data-lightgallery="group">
          <?php if (!empty($processedEvents)): ?>
            <?php foreach ($processedEvents as $event): ?>
              <div class="col-sm-6 col-lg-4 col-xxl-3 isotope-item wow fadeInLeft" data-wow-delay="<?php echo $event['delay'] / 10; ?>s">
                <article class="thumbnail thumbnail-classic thumbnail-md">
                  <div class="thumbnail-classic-figure">
                    <img src="<?php echo htmlspecialchars($event['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($event['title']); ?>" 
                         width="420" 
                         height="350" />
                  </div>
                  <div class="thumbnail-classic-caption">
                    <div class="thumbnail-classic-title-wrap">
                      <a class="icon fl-bigmug-line-zoom60" 
                         href="<?php echo htmlspecialchars($event['image_path']); ?>" 
                         data-lightgallery="item">
                        <img src="<?php echo htmlspecialchars($event['image_path']); ?>" 
                             alt="" 
                             width="420" 
                             height="350" />
                      </a>
                      <h5 class="thumbnail-classic-title">
                        <a href="<?php echo SITE_URL; ?>/eventi/<?php echo htmlspecialchars($event['slug']); ?>">
                          <?php echo htmlspecialchars($event['title']); ?>
                        </a>
                      </h5>
                    </div>
                    <p class="thumbnail-classic-text">
                      <?php echo !empty($event['short_description']) ? htmlspecialchars($event['short_description']) : '&nbsp;'; ?>
                    </p>
                  </div>
                </article>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12">
              <p>Nessun evento in programma al momento. Torna presto per aggiornamenti!</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    
    <style>
    /* Style for featured events */
    .featured-event {
      order: -1; /* Move featured items to the top */
    }
    .featured-event .thumbnail-classic {
      border: 2px solid #ffc107; /* Yellow border for featured events */
      box-shadow: 0 0 15px rgba(255, 193, 7, 0.3);
    }
    .event-meta {
      margin: 10px 0;
      color: #666;
      font-size: 0.9em;
    }
    .event-meta span {
      display: block;
      margin-bottom: 5px;
    }
    .badge-warning {
      background-color: #ffc107;
      color: #212529;
      margin-top: 5px;
      display: inline-block;
    }
    </style>

    <!-- La Nostra Storia -->
    <section class="section section-sm bg-default" id="storia">
      <div class="container">
        <div class="row row-50 row-xl-24 justify-content-center align-items-center align-items-lg-start text-left">
          <div class="col-md-6 col-lg-5 col-xl-4 text-center"><a class="text-img" href="<?= SITE_URL ?>/storia">
            <span class="counter">120</span></a>
          </div>

          <div class="col-sm-8 col-md-6 col-lg-5 col-xl-4"></div>

          <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4 wow fadeInRight" data-wow-delay=".1s" style="padding-left: 150px;">
            <div class="text-width-extra-small offset-top-lg-24 wow fadeInUp">
              <h3 class="title-decoration-lines-left">Anni di storia</h3>
              <p class="text-gray-500">Storia ormai secolare che ha unito generazioni tutte accumunate per la stessa passione per la musica. Di padre in figlio questa tradizione è stata tramandata negli anni</p>
              <a class="button button-secondary button-pipaluk" href="<?= SITE_URL ?>/storia">Scopri di più</a>
            </div>
          </div>

        </div>
      </div>
    </section>


    <!-- What people Say-->
    <!-- <section class="section section-sm section-bottom-70 section-fluid bg-default">
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
    </section> -->


    <!-- Upcoming Events Section -->
    <section class="section section-sm bg-default" id="prossimi-eventi">
      <div class="container">
        <h3 class="wow fadeInLeft">Prossimi Eventi</h3>
        <p class="wow fadeInRight" data-wow-delay=".1s">Ecco i nostri prossimi appuntamenti dove potrete ascoltarci dal vivo</p>
        
        <div class="row row-30 justify-content-center">
          <?php if (!empty($upcomingEvents)): ?>
            <?php 
            $delay = 0;
            foreach ($upcomingEvents as $event): 
                // Format date and time
                $eventDate = new DateTime($event['start_datetime']);
                $day = $eventDate->format('j');
                
                // Italian month names
                $italianMonths = [
                    1 => 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno',
                    'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'
                ];
                $month = $italianMonths[(int)$eventDate->format('n')];
                
                // Set animation delay
                $animationDelay = $delay * 0.1;
                $delay++;
            ?>
              <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="<?php echo $animationDelay; ?>s">
                <article class="card event-card">
                  <div class="card-body">
                    <time datetime="<?php echo $eventDate->format('Y-m-d\TH:i'); ?>" class="event-date">
                      <span class="event-day"><?php echo $day; ?></span>
                      <span class="event-month"><?php echo $month; ?></span>
                    </time>
                    <h4 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h4>
                    <?php if (!empty($event['location'])): ?>
                      <p class="event-location"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($event['location']); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo SITE_URL; ?>/eventi/<?php echo htmlspecialchars($event['slug']); ?>" class="button button-primary button-ujarak">Dettagli</a>
                  </div>
                </article>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12">
              <p>Nessun evento in programma al momento. Torna presto per aggiornamenti!</p>
            </div>
          <?php endif; ?>
        </div>
        
        <?php if (!empty($upcomingEvents)): ?>
        <div class="text-center mt-5">
          <a href="<?php echo SITE_URL; ?>/eventi" class="button button-lg button-primary">Vedi Tutti gli Eventi</a>
        </div>
        <?php endif; ?>
      </div>
    </section>
    
    <?php include_once TEMPLATES_PATH . 'footer.php'; ?>
  </div>
  <?php
  // Define structured data for the home page
  $pageStructuredData = '{
    "@context": "https://schema.org",
    "@type": "MusicGroup",
    "name": "Banda Folk di Castello Tesino",
    "url": "https://www.bandafolkcastellotesino.it",
    "image": "' . SITE_URL . '/assets/images/FotoSanIppolito1.jpg",
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
  }';
  
  include_once TEMPLATES_PATH . 'scripts.php';
  ?>
</body>

</html>