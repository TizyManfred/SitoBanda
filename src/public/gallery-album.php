<?php
/**
 * Gallery Album Page
 *
 * Displays individual album photos dynamically from the database
 * Following PSR-12 coding standards and accessibility best practices
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */

// Define ABSPATH to prevent direct file access
define('ABSPATH', dirname(__DIR__) . '/');

// Include configuration and database
require_once ABSPATH . 'includes/config.php';
require_once ABSPATH . 'includes/database.php';

// Get and sanitize album slug from URL
$albumSlug = isset($_GET['slug']) ? htmlspecialchars($_GET['slug'], ENT_QUOTES, 'UTF-8') : '';

// If no album slug provided, redirect to gallery index
if (empty($albumSlug)) {
    header('Location: gallery.php');
    exit;
}

// Initialize variables
$album = null;
$photos = [];
$error = null;

try {
    // Get album data by slug
    $album = Database::getRow(
        "SELECT * FROM gallery_albums 
         WHERE slug = ? AND is_published = 1",
        [$albumSlug]
    );
    
    // If album not found, set error
    if (!$album) {
        $error = "Album non trovato o non pubblicato.";
    } else {
        // Get all published photos for this album
        $photos = Database::getRows(
            "SELECT * FROM gallery_items 
             WHERE album_id = ? AND is_published = 1 
             ORDER BY sort_order ASC, created_at DESC",
            [$album['id']]
        );
        
        // Update view count for this album
        Database::query(
            "UPDATE gallery_albums SET view_count = view_count + 1 WHERE id = ?",
            [$album['id']]
        );
    }
} catch (Exception $e) {
    error_log("Gallery album page error: " . $e->getMessage());
    $error = "Si è verificato un errore durante il caricamento dell'album.";
}

// Define page-specific meta variables
$pageTitle = ($album) 
    ? htmlspecialchars($album['title']) . ' - Gallery - Banda Folk di Castello Tesino'
    : 'Album - Gallery - Banda Folk di Castello Tesino';

$pageDescription = ($album) 
    ? htmlspecialchars($album['description'] ?: 'Foto dell\'album ' . $album['title'] . ' della Banda Folk di Castello Tesino, anno ' . $album['year'])
    : 'Galleria fotografica della Banda Folk di Castello Tesino';

$ogTitle = ($album) 
    ? htmlspecialchars($album['title'] . ' - Banda Folk di Castello Tesino')
    : 'Album Fotografico - Banda Folk di Castello Tesino';

$ogDescription = $pageDescription;

$ogImage = ($album && $album['cover_image']) 
    ? SITE_URL . '/album/' . $album['id'] . '/' . $album['cover_image']
    : SITE_URL . '/assets/images/gallery-header.jpg';
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="it">

<?php
// Include the head template
include_once TEMPLATES_PATH . 'head.php';
?>
<style>
  .gallery-image-container {
    height: 250px !important;
    overflow: hidden !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    background-color: #f8f9fa !important;
  }
  .gallery-image-container img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    object-position: center !important;
  }
  .thumbnail-classic-figure {
    margin-bottom: 0 !important;
  }
  .thumbnail-classic {
    height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
  }
  .thumbnail-classic-caption {
    flex: 0 0 auto !important;
  }
</style>

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
          <h1 class="breadcrumbs-custom-title">
            <?php echo ($album) ? htmlspecialchars($album['title']) : 'Album'; ?>
          </h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="<?php echo SITE_URL; ?>/index">Home</a></li>
            <li><a href="<?php echo SITE_URL; ?>/gallery">Gallery</a></li>
            <li class="active">
              <?php echo ($album) ? htmlspecialchars($album['title']) : 'Album'; ?>
            </li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(<?php echo ($album && $album['cover_image']) ? SITE_URL . '/album/' . $album['id'] . '/' . htmlspecialchars($album['cover_image']) : 'assets/images/gallery-header.jpg'; ?>);"></div>
      </div>
    </section>

    <!-- Album Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <?php if ($error): ?>
        <!-- Error Message -->
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-body text-center py-5">
                <i class="fl-bigmug-line-exclamation-mark2 fa-3x mb-3 text-danger"></i>
                <h3>Errore</h3>
                <p><?php echo htmlspecialchars($error); ?></p>
                <a href="<?php echo SITE_URL; ?>/gallery" class="btn btn-primary mt-3">Torna alla Gallery</a>
              </div>
            </div>
          </div>
        </div>
        <?php elseif ($album): ?>
        <!-- Album Info -->
        <div class="row justify-content-center text-center mb-4">
          <div class="col-lg-9">
            <h2><?php echo htmlspecialchars($album['title']); ?></h2>
            <?php if (!empty($album['description'])): ?>
            <p class="lead"><?php echo htmlspecialchars($album['description']); ?></p>
            <?php endif; ?>
            <div class="album-meta">
              <span class="badge badge-primary"><?php echo htmlspecialchars($album['year']); ?></span>
              <span class="text-muted ml-3"><?php echo count($photos); ?> foto</span>
            </div>
          </div>
        </div>

        <?php if (!empty($photos)): ?>
        <!-- Photo Gallery -->
        <div class="row row-30" data-lightgallery="group">
          <?php foreach ($photos as $photo): ?>
          <div class="col-sm-6 col-lg-4">
            <article class="thumbnail-classic">
              <div class="thumbnail-classic-figure gallery-image-container">
                <a href="<?php echo SITE_URL; ?>/album/<?= $album['id'] . '/' . $photo['filename']; ?>" 
                   data-lightgallery="item" style="height: 100%; width: 100%;"
                   data-sub-html="<h4><?php echo htmlspecialchars($photo['title']); ?></h4><p><?php echo htmlspecialchars($photo['description']); ?></p>">
                  <img src="<?php echo SITE_URL; ?>/album/<?= $album['id'] . '/' . $photo['filename']; ?>" 
                       alt="<?php echo htmlspecialchars($photo['alt_text'] ?: $photo['title']); ?>" 
                       loading="lazy">
                </a>
              </div>
              <?php if (!empty($photo['title']) || !empty($photo['description'])): ?>
              <div class="thumbnail-classic-caption">
                <?php if (!empty($photo['title'])): ?>
                <h5 class="thumbnail-classic-title"><?php echo htmlspecialchars($photo['title']); ?></h5>
                <?php endif; ?>
                <?php if (!empty($photo['description'])): ?>
                <div class="thumbnail-classic-text">
                  <p><?php echo htmlspecialchars($photo['description']); ?></p>
                </div>
                <?php endif; ?>
              </div>
              <?php endif; ?>
            </article>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- No Photos Found -->
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-body text-center py-5">
                <i class="fl-bigmug-line-images fa-3x mb-3 text-muted"></i>
                <h3>Nessuna foto disponibile</h3>
                <p>Questo album non contiene ancora foto.</p>
                <a href="<?php echo SITE_URL; ?>/gallery" class="btn btn-primary mt-3">Torna alla Gallery</a>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- Navigation Buttons -->
        <div class="row justify-content-center mt-5">
          <div class="col-md-8 text-center">
            <a href="<?php echo SITE_URL; ?>/gallery" class="btn btn-primary">
              <i class="fl-bigmug-line-arrow-left mr-2"></i> Torna alla Gallery
            </a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <?php include_once TEMPLATES_PATH . 'footer.php'; ?>
  </div>

  <?php
  // Define structured data for this page if album exists
  if ($album) {
    $albumStructuredData = [
      "@context" => "https://schema.org",
      "@type" => "ImageGallery",
      "name" => $album['title'] . " - Banda Folk di Castello Tesino",
      "description" => $album['description'] ?: "Foto dell'album " . $album['title'] . " della Banda Folk di Castello Tesino, anno " . $album['year'],
      "datePublished" => $album['created_at'],
      "publisher" => [
        "@type" => "MusicGroup",
        "name" => "Banda Folk di Castello Tesino",
        "url" => SITE_URL
      ],
      "about" => [
        "@type" => "Event",
        "name" => $album['title'],
        "startDate" => $album['year'] . "-01-01",
        "endDate" => $album['year'] . "-12-31",
        "organizer" => [
          "@type" => "MusicGroup",
          "name" => "Banda Folk di Castello Tesino"
        ]
      ],
      "breadcrumb" => [
        "@type" => "BreadcrumbList",
        "itemListElement" => [
          [
            "@type" => "ListItem",
            "position" => 1,
            "item" => [
              "@id" => SITE_URL,
              "name" => "Home"
            ]
          ],
          [
            "@type" => "ListItem",
            "position" => 2,
            "item" => [
              "@id" => SITE_URL . "/gallery",
              "name" => "Gallery"
            ]
          ],
          [
            "@type" => "ListItem",
            "position" => 3,
            "item" => [
              "@id" => SITE_URL . "/gallery-album/" . $album['slug'],
              "name" => $album['title']
            ]
          ]
        ]
      ]
    ];
    
    // Add image list if photos exist
    if (!empty($photos)) {
      $albumStructuredData["associatedMedia"] = [];
      foreach ($photos as $i => $photo) {
        if ($i < 10) { // Limit to 10 images in structured data
          $albumStructuredData["associatedMedia"][] = [
            "@type" => "ImageObject",
            "contentUrl" => SITE_URL . "/public/assets/images/gallery/" . $photo['filename'],
            "name" => $photo['title'],
            "description" => $photo['description'],
            "caption" => $photo['title']
          ];
        }
      }
    }
    
    // Include structured data in the page
    echo '<script type="application/ld+json">' . json_encode($albumStructuredData) . '</script>';
  }
  
  // Include common scripts
  include_once TEMPLATES_PATH . 'scripts.php';
  ?>
</body>

</html>
