<?php
/**
 * Meta Tags Template
 *
 * Contains SEO meta tags and Open Graph tags for social media
 *
 * @author   SitoBanda Team
 * @version  1.1.0
 */
?>
<!-- Primary Meta Tags -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
<meta name="description" content="<?php echo $pageDescription ?? 'La Banda Folk di Castello Tesino, attiva dal 1901, porta avanti la tradizione musicale del Trentino con concerti, eventi e corsi di musica.'; ?>">
<meta name="keywords" content="<?php echo $keywords ?? 'banda musicale, Castello Tesino, musica tradizionale trentina, corsi di musica, eventi musicali, Trentino, banda folk'; ?>"">
<meta name="author" content="Banda Folk di Castello Tesino">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="7 days">
<meta name="language" content="it">
<meta name="geo.region" content="IT-TN">
<meta name="geo.placename" content="Castello Tesino">

<!-- Canonical URL -->
<link rel="canonical" href="<?php echo $canonicalUrl ?? SITE_URL . $_SERVER['REQUEST_URI']; ?>">

<!-- Open Graph / Social Media Meta Tags -->
<meta property="og:title" content="<?php echo $ogTitle ?? 'Banda Folk di Castello Tesino - Tradizione dal 1901'; ?>">
<meta property="og:description" content="<?php echo $ogDescription ?? 'Scopri la Banda Folk di Castello Tesino, custode della tradizione musicale trentina dal 1901.'; ?>">
<meta property="og:image" content="<?php echo $ogImage ?? SITE_URL . '/assets/images/FotoSanIppolito1.jpg'; ?>">
<meta property="og:url" content="<?php echo $ogUrl ?? SITE_URL . $_SERVER['REQUEST_URI']; ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="it_IT">
<meta property="og:site_name" content="Banda Folk di Castello Tesino">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $ogTitle ?? 'Banda Folk di Castello Tesino - Tradizione dal 1901'; ?>">
<meta name="twitter:description" content="<?php echo $ogDescription ?? 'Scopri la Banda Folk di Castello Tesino, custode della tradizione musicale trentina dal 1901.'; ?>">
<meta name="twitter:image" content="<?php echo $ogImage ?? SITE_URL . '/assets/images/FotoSanIppolito1.jpg'; ?>">

<!-- Additional Meta Tags -->
<meta name="theme-color" content="#1a365d">
<link rel="shortcut icon" href="<?php echo SITE_URL; ?>/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo SITE_URL; ?>/favicon.ico" type="image/x-icon">

<!-- Apple Touch Icons -->
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo SITE_URL; ?>/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo SITE_URL; ?>/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo SITE_URL; ?>/favicon-16x16.png">
<link rel="manifest" href="<?php echo SITE_URL; ?>/site.webmanifest">

<!-- Preconnect to external domains -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Structured Data / JSON-LD -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "MusicGroup",
  "name": "Banda Folk di Castello Tesino",
  "url": "<?php echo SITE_URL; ?>",
  "logo": "<?php echo SITE_URL; ?>/assets/images/logo.png",
  "image": "<?php echo $ogImage ?? SITE_URL . '/assets/images/FotoSanIppolito1.jpg'; ?>",",
  "description": "<?php echo $pageDescription ?? 'La Banda Folk di Castello Tesino, attiva dal 1901, porta avanti la tradizione musicale del Trentino con concerti, eventi e corsi di musica.'; ?>",
  "foundingDate": "1901",
  "genre": ["Folk", "Musica tradizionale trentina", "Musica da banda"],
  "sameAs": [
    "https://www.facebook.com/bandafolkcastellotesino",
    "https://www.instagram.com/bandafolkcastellotesino"
  ],
  "location": {
    "@type": "Place",
    "name": "Castello Tesino, Trentino-Alto Adige, Italia"
  }
}
</script>
