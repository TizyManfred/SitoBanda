<?php
/**
 * Admin Head Template - AdminLTE 3 Version
 *
 * Contains head section and opening body tag
 * Following PSR-12 coding standards and accessibility best practices
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

// Default page title if not set
if (!isset($pageTitle)) {
    $pageTitle = 'Admin Panel';
}

// Generate page title
$fullPageTitle = $pageTitle . ' - Admin Banda Folk di Castello Tesino';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($fullPageTitle); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo SITE_URL; ?>/public/assets/images/favicon.ico" type="image/x-icon">
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/cdf1aa91ca.js" crossorigin="anonymous" async></script>
    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/admin/assets/adminlte/css/adminlte.min.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/admin/assets/css/custom-admin.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/admin/assets/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/admin/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    
    <?php if (isset($additionalStyles) && is_array($additionalStyles)): ?>
    <!-- Page specific styles -->
    <?php foreach ($additionalStyles as $style): ?>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/admin/<?php echo htmlspecialchars($style); ?>">
    <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- No index meta tag for admin area -->
    <meta name="robots" content="noindex, nofollow">
</head>
<body class="hold-transition sidebar-mini<?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true' ? ' dark-mode' : ''; ?>">
<div class="wrapper">
