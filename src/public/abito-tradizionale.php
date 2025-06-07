<?php
/**
 * Abito Tradizionale Page
 *
 * Traditional outfit page for SitoBanda website
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */

// Define ABSPATH to prevent direct file access
define('ABSPATH', dirname(__DIR__) . '/');

// Include configuration
require_once ABSPATH . 'includes/config.php';
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="it">

<?php
// Define page-specific meta variables
$pageTitle = 'L\'Abito Tradizionale - Banda Folk di Castello Tesino';
$pageDescription = 'L\'abito tradizionale della Valle del Tesino ha origine nel XVII secolo: un costume festoso e prestigioso che testimonia la prosperità della valle attraverso gli ornamenti tipici femminili.';
$ogTitle = 'L\'Abito Tradizionale - Banda Folk di Castello Tesino';
$ogDescription = 'Scopri lo storico abito tradizionale della Valle del Tesino, riadottato dalla Banda Folk nel 1981 per onorarne la tradizione secolare.';
$ogImage = SITE_URL . '/assets/images/FotoAbito1.jpg';

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
          <h1 class="breadcrumbs-custom-title">L'Abito Tradizionale</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="<?php echo SITE_URL; ?>/index">Home</a></li>
            <li><a href="<?php echo SITE_URL; ?>/chi-siamo">Chi Siamo</a></li>
            <li class="active">L'Abito Tradizionale</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(<?php echo SITE_URL; ?>/assets/images/FotoAbito1.jpg);"></div>
      </div>
    </section>

    <!-- Abito Tradizionale Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row row-50">
          <div class="col-lg-6 pr-xl-5">
            <div class="image-height-1 wow fadeIn">
              <img src="<?php echo SITE_URL; ?>/assets/images/FotoAbito2.jpg" alt="Costume tradizionale femminile tesino" width="518" loading="lazy" />
            </div>
          </div>
          <div class="col-lg-6">
            <div class="text-block">
              <h3>IL COSTUME TESINO</h3>
              <p>Disgiungere la storia del costume folkloristico tesino dall'epopea degli abitanti della valle, viaggiatori ambulanti in tutto il mondo a partire dall'inizio del 1600, sminuirebbe il significato di uno degli abiti più antichi ed interessanti dell'intero arco alpino. Negli ultimi quattro secoli il costume tesino femminile (la versione maschile è più recente e risale al secolo scorso) si è progressivamente arricchito di dettagli strettamente legati alle vicende dei tesini all'estero che, di ritorno a casa, portavamo alle proprie donne come souvenir dai loro viaggi oltralpe scialli colorati tirolesi, collane di granati della Carinzia, velluto francese e prezioso panno lenci.</p>
              
              <p>Così come si è evoluto e ci è stato tramandato, il costume femminile consta oggi di una veste in panno nero che cade plissettata in fittissime piegoline distribuite a gruppetti di tre e leggermente più lunga di dietro. L'abito, sostenuta una ricca sottoveste, si conclude in basso con un "dapè" in panno alto circa venti centimetri e lungo fino a dodici metri. Il colore rosso o giallo della balza indicava anticamente lo stato civile della donna, rispettivamente in cerca di marito o vedova e maritata. L'abbottonatura è anteriore e, nella zona del decolletè, presenta un'ampia scollatura che lascia spazio alla "finta", cioè ad una camiciola bianca priva di maniche recante complessi ricami (le originali "ovre") ed un colletto alto diversi centimetri. Il petto è protetto da una pettorina rigida (il "salvacore"), realizzata solitamente in velluto nero e finemente decorata a mano con fili di seta e in qualche caso perline e pagliette. Grembiule e scialle a frange sono solitamente caratterizzati da motivi floreali multicolore su un elegante fondo scuro.</p>
              
              <p>Particolare cura è posta nell'acconciatura dei capelli che sono divisi equamente da una scriminatura centrale e poi intrecciati a partire dalla base dalla nuca fino a circondare il capo come una corona, a cui si appoggia una crestina in pizzo nero e nella quale vengono infilati degli spilloni. In alternativa, le donne maritate, formano un "cucco", sul quale, con uno spillone, si fissava un nastro nero svolazzante.</p>
              
              <p>Il costume è completato dai caratteristici gioielli: un numero dispari di fili di "granate" spicca sulla "finta" insieme alla spilla, gli orecchini in filigrana d'oro a cestelli (i "piroli") rigorosamente fatti a mano, incorniciano il viso.</p>
              
              <p>Dal 1981 la Banda di Castello Tesino ha fatto proprio il costume tesino diventando banda folkloristica e da allora sfoggia con orgoglio, continuando a tramandare nel tempo, quello che non è solo un abito ma la testimonianza dell'antica cultura e storia della Valle del Tesino.</p>
            </div>
          </div>
        </div>

        <div class="row row-50 pt-5">
          <div class="col-lg-6 order-lg-2">
            <div class="image-height-1 wow fadeIn">
              <img src="<?php echo SITE_URL; ?>/assets/images/FotoAbito3.jpg" alt="Costume tradizionale maschile tesino" width="518" loading="lazy" />
            </div>
          </div>
          <div class="col-lg-6">
            <div class="text-block wow fadeInLeft">
              <h3>L'Evoluzione storica del Costume</h3>
              <p>L'evoluzione del costume popolare femminile si intreccia con la storia del commercio ambulante che ha caratterizzato per quattro secoli la vita economica e culturale della zona. I Tesini furono infatti protagonisti di importanti scambi culturali con tutta l'Europa centro-orientale.</p>
              <p>Elemento caratteristico è la rotonda, un ampio velo di pizzo bianco, che copre le spalle e la parte superiore del busto, che le donne indossavano nelle più importanti occasioni come le feste e la Santa Messa.</p>
              <p>Dorati bottoni, cinture preziose e altri ornamenti erano componenti tipici che manifestavano la prosperità e l'influenza delle famiglie.</p>
              <p>Il costume maschile, più sobrio ma altrettanto elegante, è caratterizzato da pantaloni scuri, gilet, giacca e cappello tipico locale.</p>
              <p>La ricostruzione filologica di questi abiti è frutto di un attento studio delle fonti storiche e iconografiche, grazie ai quali la banda può oggi presentarsi con abiti fedeli alla tradizione secolare del territorio.</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 text-center mt-5 pt-4">
            <div class="button-wrap">
              <a class="button button-lg button-primary" href="<?php echo SITE_URL; ?>/maestro">Scopri il nostro Maestro</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include_once TEMPLATES_PATH . 'footer.php'; ?>
  </div>

  <?php
  // Define structured data for this page
  $pageStructuredData = '{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "L\'Abito Tradizionale della Banda Folk di Castello Tesino",
    "description": "Dettagli e storia del costume tradizionale della Valle del Tesino indossato dalla Banda Folk",
    "image": "' . SITE_URL . '/assets/images/FotoAbito1.jpg",
    "datePublished": "2025-06-01",
    "publisher": {
      "@type": "Organization",
      "name": "Banda Folk di Castello Tesino",
      "logo": {
        "@type": "ImageObject",
        "url": "' . SITE_URL . '/assets/images/logo-banda.png"
      }
    }
  }';
  ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
