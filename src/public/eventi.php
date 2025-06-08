<?php
/**
 * Eventi Page
 *
 * Events and concerts page for SitoBanda website
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */

// Define ABSPATH to prevent direct file access
define('ABSPATH', dirname(__DIR__) . '/');

// Include configuration
require_once ABSPATH . 'includes/config.php';
require_once ABSPATH . 'includes/database.php';

// Fetch events from database
try {
    $db = Database::getInstance();
    
    // Get current date for filtering
    $today = date('Y-m-d H:i:s');
    
    // Fetch upcoming events
    $upcomingStmt = $db->prepare("
        SELECT e.*, IFNULL(g.title, '') as gallery_title, IFNULL(g.slug, '') as gallery_slug
        FROM events e
        LEFT JOIN gallery_albums g ON e.gallery_id = g.id
        WHERE e.is_public = 1 
        AND e.start_datetime >= :today
        ORDER BY e.start_datetime ASC
    ");
    $upcomingStmt->bindParam(':today', $today, PDO::PARAM_STR);
    $upcomingStmt->execute();
    $upcomingEvents = $upcomingStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch past events
    $pastStmt = $db->prepare("
        SELECT e.*, IFNULL(g.title, '') as gallery_title, IFNULL(g.slug, '') as gallery_slug
        FROM events e
        LEFT JOIN gallery_albums g ON e.gallery_id = g.id
        WHERE e.is_public = 1 
        AND e.start_datetime < :today
        ORDER BY e.start_datetime DESC
        LIMIT 20
    ");
    $pastStmt->bindParam(':today', $today, PDO::PARAM_STR);
    $pastStmt->execute();
    $pastEvents = $pastStmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    error_log('Error fetching events: ' . $e->getMessage());
    $upcomingEvents = [];
    $pastEvents = [];
}

// Italian month names
$italianMonths = [
    1 => 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno',
    'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'
];
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="it">

<?php
// Define page-specific meta variables
$pageTitle = 'Eventi - Banda Folk di Castello Tesino';
$pageDescription = 'Calendario completo degli eventi e concerti della Banda Folk di Castello Tesino, con date, orari e luoghi degli eventi passati e futuri.';
$ogTitle = 'Eventi e Concerti - Banda Folk di Castello Tesino';
$ogDescription = 'Scopri tutti i nostri eventi e prossime esibizioni. La Banda Folk di Castello Tesino si esibisce in concerti, festival e celebrazioni in tutta Italia e all\'estero.';
$ogImage = SITE_URL . '/assets/images/FotoEventi1.jpeg';

// Include the head template
include_once TEMPLATES_PATH . 'head.php';
?>

<body class="page-eventi">
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
          <h1 class="breadcrumbs-custom-title">Eventi</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="<?php echo SITE_URL; ?>/index">Home</a></li>
            <li class="active">Eventi</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(<?php echo SITE_URL; ?>/assets/images/FotoEventi1.jpeg);"></div>
      </div>
    </section>

    <!-- Eventi Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <?php if (!empty($upcomingEvents)): ?>
        <div class="row justify-content-center text-center mb-4">
          <div class="col-lg-9">
            <h2>I Nostri Prossimi Eventi</h2>
            <p class="lead">La Banda Folk di Castello Tesino si esibisce regolarmente durante l'anno in occasioni speciali, festival e celebrazioni. Ecco i nostri prossimi appuntamenti:</p>
          </div>
        </div>

        <!-- Upcoming Events -->

        <div class="row row-30">
          <?php 
          $animationDelay = 0;
          foreach ($upcomingEvents as $event) : 
            $eventDate = new DateTime($event['start_datetime']);
            $day = $eventDate->format('j');
            $month = mb_substr($italianMonths[(int)$eventDate->format('n')], 0, 3); // Short month name
            $time = $eventDate->format('H:i');
            $imagePath = !empty($event['image_path']) ? 
                       htmlspecialchars($event['image_path']) : 
                       'assets/images/event-placeholder.jpg';
            $animationDelay += 0.1;
          ?>
          <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="<?php echo number_format($animationDelay, 1); ?>s">
            <div class="event-card">
              <div class="event-image-container">
                <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                     class="event-image"
                     alt="<?php echo htmlspecialchars($event['title']); ?>"
                     loading="lazy">
                <div class="event-date">
                  <span class="event-day"><?php echo $day; ?></span>
                  <span class="event-month"><?php echo $month; ?></span>
                </div>
              </div>
              <div class="event-content">
                <h3 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                
                <div class="event-meta">
                  <?php if (!empty($event['location'])): ?>
                  <div class="mb-2">
                    <i class="fa fa-lg fa-map-marker"></i> 
                    <span><?php echo htmlspecialchars($event['location']); ?></span>
                  </div>
                  <?php endif; ?>
                </div>
                
                <?php if (!empty($event['description'])): ?>
                <div class="event-description">
                  <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <?php else: ?>
        <div class="row justify-content-center text-center">
          <div class="col-lg-8">
            <div class="alert alert-info">
              <h4>Nessun evento in programma al momento</h4>
              <p>Torna a trovarci presto per scoprire i prossimi appuntamenti!</p>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($pastEvents)): ?>
        <!-- Past Events -->
        <div class="row justify-content-center text-center mt-5 mb-4">
          <div class="col-lg-9">
            <h2>Eventi Passati</h2>
            <p>Rivivi alcuni dei nostri eventi più significativi degli ultimi anni:</p>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Data</th>
                <th>Evento</th>
                <th>Luogo</th>
                <?php if (!empty(array_column($pastEvents, 'gallery_id'))): ?>
                <th>Galleria</th>
                <?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pastEvents as $event): 
                $eventDate = new DateTime($event['start_datetime']);
                $formattedDate = $eventDate->format('d/m/Y');
              ?>
              <tr>
                <td><time datetime="<?php echo $eventDate->format('Y-m-d'); ?>"><?php echo $formattedDate; ?></time></td>
                <td><?php echo htmlspecialchars($event['title']); ?></td>
                <td><?php echo !empty($event['location']) ? htmlspecialchars($event['location']) : '-'; ?></td>
                <?php if (!empty($event['gallery_id'])): ?>
                <td><a href="gallery-album/<?php echo htmlspecialchars($event['gallery_slug']); ?>">Guarda le foto</a></td>
                <?php endif; ?>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        
        <div class="row">
          <div class="col-12 text-center mt-5 pt-4">
            <div class="button-wrap">
              <a class="button button-lg button-primary" href="<?php echo SITE_URL; ?>/gallery">Guarda la Galleria Completa</a>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <?php include_once TEMPLATES_PATH . 'footer.php'; ?>
  </div>

  <?php
  // Prepare structured data for upcoming events
  $eventsForStructuredData = [];
  
  // Only include upcoming events in the structured data
  foreach (array_slice($upcomingEvents, 0, 5) as $event) {
    $eventDate = new DateTime($event['start_datetime']);
    $endDate = clone $eventDate;
    $endDate->modify('+2 hours'); // Assuming events are 2 hours long
    
    $eventData = [
      "@type" => "Event",
      "name" => $event['title'],
      "startDate" => $eventDate->format('c'),
      "endDate" => $endDate->format('c'),
      "location" => [
        "@type" => "Place",
        "name" => $event['location'] ?? 'Luogo da definire',
        "address" => [
          "@type" => "PostalAddress",
          "addressLocality" => $event['location'] ?? 'Castello Tesino',
          "addressRegion" => "TN",
          "addressCountry" => "IT"
        ]
      ],
      "performer" => [
        "@type" => "MusicGroup",
        "name" => "Banda Folk di Castello Tesino"
      ]
    ];
    
    if (!empty($event['description'])) {
      $eventData['description'] = $event['description'];
    }
    
    $eventsForStructuredData[] = $eventData;
  }
  
  // Only output structured data if we have events
  if (!empty($eventsForStructuredData)) {
    $pageStructuredData = [
      "@context" => "https://schema.org",
      "@type" => "EventSeries",
      "name" => "Eventi della Banda Folk di Castello Tesino",
      "description" => "Calendario degli eventi e concerti della Banda Folk di Castello Tesino",
      "url" => SITE_URL . '/eventi',
      "image" => SITE_URL . '/assets/images/FotoEventi1.jpeg',
      "organizer" => [
        "@type" => "MusicGroup",
        "name" => "Banda Folk di Castello Tesino",
        "url" => SITE_URL
      ]
    ];
    
    // If we have exactly one event, output it directly
    if (count($eventsForStructuredData) === 1) {
      $pageStructuredData = array_merge($pageStructuredData, $eventsForStructuredData[0]);
    } 
    // If we have multiple events, use subEvent
    elseif (count($eventsForStructuredData) > 1) {
      $pageStructuredData['subEvent'] = $eventsForStructuredData;
    }
    
    // Convert to JSON and escape for HTML output
    $pageStructuredData = json_encode($pageStructuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  } else {
    $pageStructuredData = null;
  }
  ?>
  <?php if (!empty($pageStructuredData)): ?>
  <script type="application/ld+json">
  <?php echo $pageStructuredData; ?>
  </script>
  <?php endif; ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
