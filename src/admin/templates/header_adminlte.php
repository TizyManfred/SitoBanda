<?php
/**
 * Admin Header Template - AdminLTE 3 Version
 *
 * Contains only navbar and sidebar components
 * Following PSR-12 coding standards and accessibility best practices
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

// Get current user if available
$currentUser = Auth::isLoggedIn() ? Auth::getCurrentUser() : null;

// Check if it's the login page
$isLoginPage = basename($_SERVER['PHP_SELF']) === 'login.php';

// Determine which menu item should be active
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$currentDir = dirname($_SERVER['PHP_SELF']);
$currentDir = (strpos($currentDir, '/') !== false) ? basename($currentDir) : $currentDir;
?>

<?php if (!$isLoginPage && $currentUser): ?>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?php echo SITE_URL; ?>/admin/index.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?php echo SITE_URL; ?>" target="_blank" class="nav-link">Visualizza Sito</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Dark Mode Toggle -->
            <li class="nav-item">
                <button class="nav-link btn" id="darkModeToggle">
                    <i class="fas <?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true' ? 'fa-sun' : 'fa-moon'; ?>"></i>
                </button>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?php echo SITE_URL; ?>/admin/index.php" class="brand-link">
            <img src="<?php echo SITE_URL; ?>/public/assets/images/favicon.ico" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Banda Folk Admin</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?php echo SITE_URL; ?>/admin/assets/adminlte/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="<?php echo SITE_URL; ?>/admin/profile.php" class="d-block"><?php echo htmlspecialchars($currentUser['first_name'] ?? $currentUser['username']); ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="<?php echo SITE_URL; ?>/admin/index.php" class="nav-link <?php echo $currentPage === 'index' && $currentDir === 'admin' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo SITE_URL; ?>/admin/gallery/index.php" class="nav-link <?php echo $currentDir === 'gallery' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Galleria</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo SITE_URL; ?>/admin/migrations.php" class="nav-link <?php echo $currentPage === 'migrations' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-code-branch"></i>
                            <p>Migrazioni</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo SITE_URL; ?>/admin/logout.php" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
<?php endif; ?>
