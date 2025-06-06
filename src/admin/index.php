<?php
/**
 * Admin Dashboard
 *
 * Main admin dashboard for SitoBanda website
 * Following PSR-12 coding standards and security best practices
 */

// Define ABSPATH for security
define('ABSPATH', dirname(__DIR__) . '/');

// Include configuration and authentication
require_once ABSPATH . 'includes/config.php';
require_once ABSPATH . 'includes/functions.php';
require_once ABSPATH . 'includes/auth.php';
require_once ABSPATH . 'includes/database.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not authenticated
Auth::requireLogin();

// Get current user
$currentUser = Auth::getCurrentUser();

$pdo = Database::getInstance();
    
// Total albums count
$stmt = $pdo->query("SELECT COUNT(*) FROM gallery_albums");
$totalAlbums = $stmt->fetchColumn();

// Get gallery statistics
$galleryStats = [];
try {
    
    // Total photos count
    $stmt = $pdo->query("SELECT COUNT(*) FROM gallery_items");
    $totalPhotos = $stmt->fetchColumn();
    
    // Published albums count
    $stmt = $pdo->query("SELECT COUNT(*) FROM gallery_albums WHERE is_published = 1");
    $publishedAlbums = $stmt->fetchColumn();
    
    // Photos added this month
    $stmt = $pdo->query("SELECT COUNT(*) FROM gallery_items WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)");
    $recentPhotos = $stmt->fetchColumn();
    
    // Recent gallery activities
    $recentActivities = [];
    
    // Get recently updated albums
    $stmt = $pdo->query("SELECT title, updated_at FROM gallery_albums ORDER BY updated_at DESC LIMIT 5");
    $recentAlbums = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($recentAlbums as $album) {
        $timeAgo = timeAgo($album['updated_at']);
        $recentActivities[] = [
            'user' => 'Sistema',
            'action' => 'aggiornato',
            'item' => 'Album: ' . $album['title'],
            'time' => $timeAgo,
            'icon' => 'images'
        ];
    }
    
    // Get recently added photos
    $stmt = $pdo->query("SELECT i.title, a.title as album_title, i.created_at 
                        FROM gallery_items i 
                        JOIN gallery_albums a ON i.album_id = a.id 
                        ORDER BY i.created_at DESC LIMIT 3");
    $recentlyAddedPhotos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($recentlyAddedPhotos as $photo) {
        $timeAgo = timeAgo($photo['created_at']);
        $recentActivities[] = [
            'user' => 'Sistema',
            'action' => 'aggiunto foto a',
            'item' => $photo['album_title'] . ': ' . $photo['title'],
            'time' => $timeAgo,
            'icon' => 'image'
        ];
    }
    
    // Sort activities by time
    usort($recentActivities, function($a, $b) {
        return strtotime($a['time']) - strtotime($b['time']);
    });
    
    // Get the 5 most recent activities
    $recentActivities = array_slice($recentActivities, 0, 5);
    
} catch (Exception $e) {
    error_log("Error fetching gallery stats: " . $e->getMessage());
    $totalAlbums = 0;
    $totalPhotos = 0;
    $publishedAlbums = 0;
    $recentPhotos = 0;
    $recentActivities = [];
}

// Stats for the dashboard cards
$stats = [
    'albums' => [
        'count' => $totalAlbums,
        'label' => 'Album',
        'icon' => 'images',
        'color' => 'info',
        'change' => ''
    ],
    'photos' => [
        'count' => $totalPhotos,
        'label' => 'Foto',
        'icon' => 'camera',
        'color' => 'success',
        'change' => ''
    ],
    'published' => [
        'count' => $publishedAlbums,
        'label' => 'Pubblicati',
        'icon' => 'eye',
        'color' => 'primary',
        'change' => ''
    ],
    'recent' => [
        'count' => $recentPhotos,
        'label' => 'Nuove foto',
        'icon' => 'plus-circle',
        'color' => 'warning',
        'change' => 'questo mese'
    ]
];

// Get recent gallery items - In a real app, this would come from database
$recentGalleryItems = [];

// Page title
$pageTitle = 'Dashboard';

// Include new template structure
include_once __DIR__ . '/templates/head_adminlte.php';
include_once __DIR__ . '/templates/header_adminlte.php';
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="d-flex justify-content-between">
                    <h1 class="h2">Dashboard Galleria</h1>
                    <div class="btn-toolbar">
                        <div class="btn-group mr-2">
                            <a href="gallery/upload.php" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Carica Foto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Gallery Stats -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-images mr-2"></i> Statistiche Galleria
                            </h3>
                            <div class="card-tools">
                                <a href="gallery/" class="btn btn-sm btn-primary">
                                    <i class="fas fa-folder-open mr-1"></i> Gestisci Galleria
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($stats as $key => $stat): ?>
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-<?php echo $stat['color']; ?> elevation-1">
                                            <i class="fas fa-<?php echo $stat['icon']; ?>"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><?php echo $stat['label']; ?></span>
                                            <span class="info-box-number">
                                                <?php echo number_format($stat['count'], 0, ',', '.'); ?>
                                                <?php if (!empty($stat['change'])): ?>
                                                <small class="d-block text-muted"><?php echo $stat['change']; ?></small>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-images mr-2"></i>
                                Gestione Galleria
                            </h5>
                            <a href="gallery/index.php" class="btn btn-sm btn-outline-primary">
                                Vai alla Galleria
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Attività Recenti</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <ul class="list-group list-group-flush">
                                                <?php foreach ($recentActivities as $activity): ?>
                                                <li class="list-group-item">
                                                    <div class="d-flex">
                                                        <div class="activity-icon mr-3">
                                                            <i class="fas fa-<?php echo htmlspecialchars($activity['icon']); ?>"></i>
                                                        </div>
                                                        <div>
                                                            <div class="font-weight-bold"><?php echo htmlspecialchars($activity['user']); ?></div>
                                                            <div>
                                                                <?php echo htmlspecialchars($activity['action']); ?>:
                                                                <span class="font-weight-bold"><?php echo htmlspecialchars($activity['item']); ?></span>
                                                            </div>
                                                            <small class="text-muted">
                                                                <i class="far fa-clock mr-1"></i>
                                                                <?php echo htmlspecialchars($activity['time']); ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Azioni Rapide</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row text-center">
                                                <div class="col-6 mb-4">
                                                    <a href="gallery/upload.php" class="d-block quick-link p-3">
                                                        <div class="quick-link-icon mb-2">
                                                            <i class="fas fa-upload fa-2x"></i>
                                                        </div>
                                                        <span>Carica Foto</span>
                                                    </a>
                                                </div>
                                                <div class="col-6 mb-4">
                                                    <a href="gallery/add_album.php" class="d-block quick-link p-3">
                                                        <div class="quick-link-icon mb-2">
                                                            <i class="fas fa-folder-plus fa-2x"></i>
                                                        </div>
                                                        <span>Nuovo Album</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/templates/body_end_adminlte.php'; ?>
