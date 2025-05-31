<?php
/**
 * Admin Header Template
 *
 * Includes the HTML head, navigation, and sidebar for the admin area
 * Following PSR-12 coding standards and accessibility best practices
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

// Get current user if available
$currentUser = Auth::isLoggedIn() ? Auth::getCurrentUser() : null;

// Default page title if not set
if (!isset($pageTitle)) {
    $pageTitle = 'Admin Panel';
}

// Check if it's the login page
$isLoginPage = basename($_SERVER['PHP_SELF']) === 'login.php';

// Generate page title
$fullPageTitle = $pageTitle . ' - Admin Banda Folk di Castello Tesino';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($fullPageTitle); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="../public/assets/images/favicon.ico" type="image/x-icon">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $isLoginPage ? '' : 'assets/css/admin.css'; ?>">
    
    <!-- No index meta tag for admin area -->
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
    <?php if (!$isLoginPage && $currentUser): ?>
    <!-- Admin Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white navbar-admin">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="../public/assets/images/logo.png" alt="Banda Folk di Castello Tesino" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarAdmin">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope"></i>
                            <span class="badge badge-danger badge-counter">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">Messaggi</h6>
                            <a class="dropdown-item d-flex align-items-center" href="messages/view.php?id=1">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">25 Maggio 2024</div>
                                    <span class="font-weight-bold">Maria Bianchi - Richiesta Informazioni</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="messages/view.php?id=2">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">24 Maggio 2024</div>
                                    <span class="font-weight-bold">Antonio Verdi - Richiesta Concerto</span>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="messages/index.php">Visualizza tutti i messaggi</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge badge-warning badge-counter">2</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
                            <h6 class="dropdown-header">Notifiche</h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">25 Maggio 2024</div>
                                    <span>Promemoria: Aggiorna gli eventi estivi!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-calendar-check text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">23 Maggio 2024</div>
                                    <span>Evento "Concerto di Primavera" tra 7 giorni</span>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Visualizza tutte le notifiche</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../public/index.php" target="_blank" title="Visualizza sito">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown user-dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="assets/img/user-profile.jpg" alt="User" class="mr-2">
                            <span class="d-none d-lg-inline-block">
                                <?php echo htmlspecialchars($currentUser['first_name'] ?? $currentUser['username']); ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profilo
                            </a>
                            <a class="dropdown-item" href="settings/index.php">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Impostazioni
                            </a>
                            <a class="dropdown-item" href="logs/index.php">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Log Attività
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Page Container -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $pageTitle === 'Dashboard' ? 'active' : ''; ?>" href="index.php">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($pageTitle, 'Eventi') !== false ? 'active' : ''; ?>" href="events/index.php">
                                <i class="fas fa-calendar-alt"></i>
                                Eventi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($pageTitle, 'Membri') !== false ? 'active' : ''; ?>" href="members/index.php">
                                <i class="fas fa-users"></i>
                                Membri
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($pageTitle, 'Galleria') !== false ? 'active' : ''; ?>" href="gallery/index.php">
                                <i class="fas fa-images"></i>
                                Galleria
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($pageTitle, 'Messaggi') !== false ? 'active' : ''; ?>" href="messages/index.php">
                                <i class="fas fa-envelope"></i>
                                Messaggi
                                <span class="badge badge-danger">3</span>
                            </a>
                        </li>
                        
                        <li class="sidebar-heading">Contenuti</li>
                        
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($pageTitle, 'Pagine') !== false ? 'active' : ''; ?>" href="pages/index.php">
                                <i class="fas fa-file-alt"></i>
                                Pagine
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($pageTitle, 'Menu') !== false ? 'active' : ''; ?>" href="menu/index.php">
                                <i class="fas fa-bars"></i>
                                Menu
                            </a>
                        </li>
                        
                        <li class="sidebar-heading">Sistema</li>
                        
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($pageTitle, 'Utenti') !== false ? 'active' : ''; ?>" href="users/index.php">
                                <i class="fas fa-user-shield"></i>
                                Utenti
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($pageTitle, 'Impostazioni') !== false ? 'active' : ''; ?>" href="settings/index.php">
                                <i class="fas fa-cogs"></i>
                                Impostazioni
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($pageTitle, 'Backup') !== false ? 'active' : ''; ?>" href="backup/index.php">
                                <i class="fas fa-database"></i>
                                Backup
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- Main Content Area -->
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <?php endif; ?>
