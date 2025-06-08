<?php
/**
 * Gallery Page
 *
 * Photo gallery page for SitoBanda website
 * Displays albums grouped by year dynamically from the database
 *
 * @author   SitoBanda Team
 * @version  1.1.0
 */

// Define ABSPATH to prevent direct file access
define('ABSPATH', dirname(__DIR__) . '/');

// Include configuration and database
require_once ABSPATH . 'includes/config.php';
require_once ABSPATH . 'includes/database.php';

// Fetch all published albums grouped by year
$albums = [];
$years = [];

try {
    // Get all published albums ordered by year (desc) and title
    $albumsData = Database::getRows(
        "SELECT * FROM gallery_albums 
         WHERE is_published = 1 
         ORDER BY year DESC, title ASC"
    );
    
    // Group albums by year
    foreach ($albumsData as $album) {
        $year = $album['year'];
        
        if (!isset($albums[$year])) {
            $albums[$year] = [];
            $years[] = $year;
        }
        
        // Get photo count for this album
        $photoCount = Database::getRow(
            "SELECT COUNT(*) as count FROM gallery_items 
             WHERE album_id = ? AND is_published = 1",
            [$album['id']]
        );
        
        $album['photo_count'] = $photoCount['count'] ?? 0;
        $albums[$year][] = $album;
    }
} catch (Exception $e) {
    error_log("Gallery page error: " . $e->getMessage());
    // If database error, create empty arrays to avoid breaking the page
    $albums = [];
    $years = [];
}
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="it">

<?php
// Define page-specific meta variables
$pageTitle = 'Gallery - Banda Folk di Castello Tesino';
$pageDescription = 'Galleria fotografica delle esibizioni e dei concerti della Banda Folk di Castello Tesino in Italia e all\'estero.';
$ogTitle = 'Galleria Fotografica - Banda Folk di Castello Tesino';
$ogDescription = 'Sfoglia le foto dei concerti ed esibizioni della Banda Folk di Castello Tesino in Italia e all\'estero.';
$ogImage = SITE_URL . '/assets/images/FotoGallery1.jpg';

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
          <h1 class="breadcrumbs-custom-title">Gallery</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li class="active">Gallery</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(<?php echo SITE_URL; ?>/assets/images/FotoGallery1.jpg);"></div>
      </div>
    </section>

    <!-- Gallery Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row justify-content-center text-center mb-4">
          <div class="col-lg-9">
            <h2>I Nostri Album Fotografici</h2>
            <p class="lead">Sfoglia le immagini delle nostre esibizioni in Italia e all'estero. Le fotografie raccontano la storia e la passione della nostra banda attraverso i luoghi e le persone che abbiamo incontrato.</p>
          </div>
        </div>

        <?php if (!empty($years)): ?>
        <!-- Album Years Selector -->
        <div class="row mb-5">
          <div class="col-12">
            <div class="tabs-custom tabs-horizontal tabs-line" id="tabs-gallery">
              <ul class="nav nav-tabs">
                <?php foreach ($years as $index => $year): ?>
                <li class="nav-item" role="presentation">
                  <a class="nav-link <?php echo ($index === 0) ? 'active' : ''; ?>" 
                     href="#tabs-gallery-<?php echo $index + 1; ?>" 
                     data-toggle="tab"><?php echo htmlspecialchars($year); ?></a>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>

        <!-- Album Content -->
        <div class="tab-content">
          <?php foreach ($years as $index => $year): ?>
          <!-- <?php echo $year; ?> Albums -->
          <div class="tab-pane fade <?php echo ($index === 0) ? 'show active' : ''; ?>" id="tabs-gallery-<?php echo $index + 1; ?>">
            <div class="row row-30" data-lightgallery="group">
              <?php foreach ($albums[$year] as $album): ?>
              <div class="col-sm-6 col-lg-4">
                <div class="gallery-item-wrap">
                  <a href="gallery-album/<?php echo htmlspecialchars($album['slug']); ?>" class="gallery-album">
                    <div class="gallery-item">
                      <div class="gallery-img-container">
                        <img src="<?php echo SITE_URL; ?>/album/<?= $album['id'] ?>/<?= htmlspecialchars($album['cover_image']); ?>" 
                             alt="<?php echo htmlspecialchars($album['title']); ?>" 
                             width="370" height="276" loading="lazy">
                      </div>
                      <div class="gallery-item-caption">
                        <h4><?php echo htmlspecialchars($album['title']); ?></h4>
                        <p class="text-white-50"><?php echo htmlspecialchars($album['photo_count']); ?> Foto</p>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- No Albums Found -->
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-body text-center py-5">
                <i class="fas fa-images fa-3x mb-3 text-muted"></i>
                <h3>Nessun album disponibile</h3>
                <p>Al momento non ci sono album fotografici pubblicati. Visita questa pagina più tardi.</p>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <?php include_once TEMPLATES_PATH . 'footer.php'; ?>
  </div>

  <?php
  // Define structured data for this page
  $pageStructuredData = '{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "Galleria Fotografica - Banda Folk di Castello Tesino",
    "description": "Galleria fotografica delle esibizioni e dei concerti della Banda Folk di Castello Tesino in Italia e all\'estero.",
    "publisher": {
      "@type": "MusicGroup",
      "name": "Banda Folk di Castello Tesino",
      "url": "' . SITE_URL . '"
    },
    "breadcrumb": {
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "item": {
            "@id": "' . SITE_URL . '",
            "name": "Home"
          }
        },
        {
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@id": "' . SITE_URL . '/gallery",
            "name": "Gallery"
          }
        }
      ]
    }
  }';

  // Include structured data in the page
  echo '<script type="application/ld+json">' . $pageStructuredData . '</script>';
  
  // Include common scripts
  include_once TEMPLATES_PATH . 'scripts.php';
  ?>
</body>

</html>
