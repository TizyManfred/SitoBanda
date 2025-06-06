<?php
/**
 * Head Template
 *
 * Contains all head tag content for SitoBanda website
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */
?>
<head>
  <title><?php echo $pageTitle ?? 'Banda Folk di Castello Tesino - Musica Tradizionale dal 1901'; ?></title>
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <link rel="icon" href="<?= SITE_URL ?>/assets/images/favicon.ico" type="image/x-icon">
  
  <?php include_once TEMPLATES_PATH . 'meta.php'; ?>
  
  <!-- Stylesheets-->
  <link rel="stylesheet" type="text/css"
    href="//fonts.googleapis.com/css?family=Poppins:400,500%7CTeko:300,400,500%7CMaven+Pro:500">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/fonts.css">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
  
  <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="<?= SITE_URL ?>/assets/images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="<?= SITE_URL ?>/assets/js/html5shiv.min.js"></script>
    <![endif]-->
</head>
