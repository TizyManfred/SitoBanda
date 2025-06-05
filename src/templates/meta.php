<?php
/**
 * Meta Tags Template
 *
 * Contains SEO meta tags and Open Graph tags for social media
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */
?>
<meta name="description" content="<?php echo $pageDescription ?? 'La Banda Folk di Castello Tesino, attiva dal 1901, porta avanti la tradizione musicale del Trentino con concerti, eventi e corsi di musica.'; ?>">

<!-- Open Graph / Social Media Meta Tags -->
<meta property="og:title" content="<?php echo $ogTitle ?? 'Banda Folk di Castello Tesino - Tradizione dal 1901'; ?>">
<meta property="og:description" content="<?php echo $ogDescription ?? 'Scopri la Banda Folk di Castello Tesino, custode della tradizione musicale trentina dal 1901.'; ?>">
<meta property="og:image" content="<?php echo $ogImage ?? SITE_URL . '/assets/images/FotoSanIppolito1.jpg'; ?>">
<meta property="og:url" content="<?php echo $ogUrl ?? SITE_URL; ?>">
<meta property="og:type" content="website">
