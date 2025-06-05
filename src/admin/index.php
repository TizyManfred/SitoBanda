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

// Get gallery stats - In a real app, these would come from database
$stats = [
    'gallery' => [
        'count' => 84,
        'label' => 'Foto',
        'icon' => 'images',
        'color' => 'warning',
        'change' => '+5 questo mese'
    ]
];

// Get recent activities - In a real app, this would come from database
$recentActivities = [
    [
        'user' => 'Admin',
        'action' => 'ha caricato nuove foto',
        'item' => 'Galleria "Sfilata San Ippolito"',
        'time' => '1 giorno fa',
        'icon' => 'upload'
    ],
    [
        'user' => 'Admin',
        'action' => 'ha modificato la galleria',
        'item' => 'Album "Concerto Estate"',
        'time' => '3 giorni fa',
        'icon' => 'edit'
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
            <!-- Welcome Alert -->
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info"></i> Benvenuto, <?php echo htmlspecialchars($currentUser['first_name'] ?? $currentUser['username']); ?>!</h5>
                        Questa è la dashboard amministrativa del sito della Banda Folk di Castello Tesino. Da qui puoi gestire tutti i contenuti del sito.
                    </div>
                </div>
            </div>

            <!-- Stats Cards / Info boxes -->
            <div class="row">
                <?php foreach ($stats as $key => $stat): ?>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-<?php echo $stat['color']; ?>"><i class="fas fa-<?php echo $stat['icon']; ?>"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo $stat['label']; ?></span>
                            <span class="info-box-number"><?php echo $stat['count']; ?></span>
                            <span class="text-sm"><?php echo $stat['change']; ?></span>
                            <div class="progress">
                                <div class="progress-bar bg-<?php echo $stat['color']; ?>" style="width: 100%"></div>
                            </div>
                            <a href="<?php echo $key; ?>/index.php" class="text-<?php echo $stat['color']; ?> small">
                                Visualizza dettagli <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
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
