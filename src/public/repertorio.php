<?php
/**
 * Repertorio Page
 *
 * Repertoire page for SitoBanda website
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
$pageTitle = 'Repertorio - Banda Folk di Castello Tesino';
$pageDescription = 'Il repertorio della Banda Folk di Castello Tesino include musica tradizionale trentina, marce tirolesi, classici per banda e arrangiamenti contemporanei.';
$ogTitle = 'Repertorio - Banda Folk di Castello Tesino';
$ogDescription = 'Scopri il repertorio musicale della Banda Folk di Castello Tesino dal 2012 ad oggi, con programmi regolari e speciali Blasmusik.';
$ogImage = SITE_URL . '/assets/images/FotoRepertorio1.jpg';

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
          <h1 class="breadcrumbs-custom-title">Repertorio</h1>
          <ul class="breadcrumbs-custom-path">
            <li><a href="<?php echo SITE_URL; ?>/index">Home</a></li>
            <li><a href="<?php echo SITE_URL; ?>/chi-siamo">Chi Siamo</a></li>
            <li class="active">Repertorio</li>
          </ul>
        </div>
        <div class="box-position" style="background-image: url(<?php echo SITE_URL; ?>/assets/images/FotoRepertorio1.jpg);"></div>
      </div>
    </section>

    <!-- Repertorio Content -->
    <section class="section section-lg bg-default">
      <div class="container">
        <div class="row justify-content-center text-center mb-4">
          <div class="col-lg-9">
            <h2>Il Nostro Repertorio</h2>
            <p class="lead">La Banda Folk di Castello Tesino si esibisce con un repertorio variegato che include musica tradizionale trentina, marce tirolesi, classici per banda e arrangiamenti contemporanei.</p>
          </div>
        </div>

        <!-- Accordion with Repertoire by Year -->
        <div class="row">
          <div class="col-12">
            <div class="card-group-custom card-group-corporate" id="accordion-repertoire" role="tablist" aria-multiselectable="false">
              <!-- 2025 -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a id="accordion-heading-2025" data-toggle="collapse" data-parent="#accordion-repertoire" href="#accordion-collapse-2025" aria-controls="accordion-collapse-2025" aria-expanded="true" role="button">Repertorio 2025
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse show" id="accordion-collapse-2025" aria-labelledby="accordion-heading-2025" data-parent="#accordion-repertoire" role="tabpanel">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <h5>ESTATE 2025</h5>
                        <ol class="list-marked">
                          <li>Hector Berlioz (arr. Longfield): Glory and Triumph</li>
                          <li>Giuseppe Verdi (arr. Ofburg): Nabucco – Sinfonia</li>
                          <li>Frank Ticheli: Abracadabra</li>
                          <li>Rossano Galante: The Wolves of Alaska</li>
                          <li>Arr. Ralph Ford: Go West!</li>
                          <li>Leonard Bernstein (arr. Bocook): West Side Story</li>
                          <li>Steve McMillan: Bella Romantica</li>
                          <li>Ernst Mosch: Der Solotrommlermarsch</li>
                          <li>Norbert Gälle: Böhmischer Traum</li>
                        </ol>
                      </div>
                      <div class="col-md-6">
                        <h5>BLASMUSIK 2025</h5>
                        <ol class="list-marked">
                          <li>Egerländer Liedermarsch Nr. 3</li>
                          <li>Wilkommen-Polka</li>
                          <li>Urlaubsfreuden</li>
                          <li>Bella Romantica</li>
                          <li>94er Regimentsmarsch</li>
                          <li>Speedy Gonzales</li>
                          <li>Zillertaler Hochzeitmarsch</li>
                          <li>Bozner Bergsteiger-Marsch</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
              </article>

              <!-- 2024 -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a class="collapsed" id="accordion-heading-2024" data-toggle="collapse" data-parent="#accordion-repertoire" href="#accordion-collapse-2024" aria-controls="accordion-collapse-2024" aria-expanded="false" role="button">Repertorio 2024
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse" id="accordion-collapse-2024" aria-labelledby="accordion-heading-2024" data-parent="#accordion-repertoire" role="tabpanel">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <h5>ESTATE 2024</h5>
                        <ol class="list-marked">
                          <li>Ludwig van Beethoven: York'scher Marsch</li>
                          <li>Ludwig van Beethoven: Heroic Variations</li>
                          <li>Giuseppe Verdi: Nabucco – Sinfonia</li>
                          <li>arr. Ofburg: Operetta '800</li>
                          <li>Johannes Brahms: Danza Ungherese n. 5</li>
                          <li>Dmitri Shostakovich (arr. Curnow): Folk Dances</li>
                          <li>Ernst Mosch: Der Solotrommlermarsch</li>
                          <li>arr. Franz Watz: Hofkonzert mit Strauss</li>
                        </ol>
                      </div>
                      <div class="col-md-6">
                        <h5>BLASMUSIK 2024</h5>
                        <ol class="list-marked">
                          <li>Servus Tirol</li>
                          <li>Slavonicka-Polka</li>
                          <li>Im schönen Böhmerwald</li>
                          <li>In alter Freundschaft</li>
                          <li>La Montanara</li>
                          <li>In alter Frische</li>
                          <li>Rauschendes Bächlein</li>
                          <li>Dem Land Tirol die Treue</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
              </article>

              <!-- 2023 -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a class="collapsed" id="accordion-heading-2023" data-toggle="collapse" data-parent="#accordion-repertoire" href="#accordion-collapse-2023" aria-controls="accordion-collapse-2023" aria-expanded="false" role="button">Repertorio 2023
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse" id="accordion-collapse-2023" aria-labelledby="accordion-heading-2023" data-parent="#accordion-repertoire" role="tabpanel">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <h5>NATALE 2023</h5>
                        <ol class="list-marked">
                          <li>Ludwig van Beethoven: York'scher Marsch</li>
                          <li>Ludwig van Beethoven: Heroic Variations</li>
                          <li>Johannes Brahms: Danza Ungherese n. 5</li>
                          <li>Antonín Dvořák: Danza Slava op. 72 n. 7</li>
                          <li>Albert Parlow: Amboss Polka</li>
                          <li>Thomas Koschat: Schneewalzer</li>
                          <li>Johann Strauss II: Vergnügungszug</li>
                          <li>arr. Franz Watz: Hofkonzert mit Strauss</li>
                          <li>Jacob De Haan: The Spirit of Christmas</li>
                          <li>Hayes & Johnson: Blue Christmas</li>
                          <li>Alan Silvestri: The Polar Express</li>
                        </ol>
                      </div>
                      <div class="col-md-6">
                        <h5>ESTATE 2023</h5>
                        <ol class="list-marked">
                          <li>Sergei Prokofiev: Marcia op. 99</li>
                          <li>Modest Mussorgsky: Quadri di un'esposizione</li>
                          <li>Nicolai Rimsky-Korsakov: Capriccio Espagnol</li>
                          <li>Piotr Ilic Tchaikovsky: Finale dalla Sinfonia n. 5</li>
                          <li>Dmitri Shostakovich: Folk Dances</li>
                          <li>Scott Watson: Balkan Seven</li>
                          <li>arr. Ofburg: Operetta '800</li>
                          <li>Ernst Mosch: Liebe fürs ganze Leben</li>
                          <li>Kurt Gäble: Wir Musikanten</li>
                          <li>Martin Scharnagl: Servus Tirol</li>
                        </ol>
                        
                        <h5>BLASMUSIK 2023</h5>
                        <ol class="list-marked">
                          <li>In alter Freundschaft</li>
                          <li>Goldener Herbst</li>
                          <li>Rauschendes Bächlein</li>
                          <li>Herzegowina Marsch</li>
                          <li>Aria d'Amore</li>
                          <li>In alter Frische</li>
                          <li>Fast Himmelblau</li>
                          <li>Servus Tirol</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
              <!-- 2022 -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a class="collapsed" id="accordion-heading-2022" data-toggle="collapse" data-parent="#accordion-repertoire" href="#accordion-collapse-2022" aria-controls="accordion-collapse-2022" aria-expanded="false" role="button">Repertorio 2022
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse" id="accordion-collapse-2022" aria-labelledby="accordion-heading-2022" data-parent="#accordion-repertoire" role="tabpanel">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <h5>NATALE 2022</h5>
                        <ol class="list-marked">
                          <li>Martin Scharnagl: Servus Tirol</li>
                          <li>arr. Ofburg: Operetta '800</li>
                          <li>Josef Strauss: Feuerfest – Polka française op. 269</li>
                          <li>Johann Strauss II: Auf der Jagd – Polka schnell op. 373</li>
                          <li>Gustav Holst (arr. Philip Sparke): In the Bleak Mid-Winter</li>
                          <li>Steven Reineke: Merry Christmas, Everyone!</li>
                          <li>arr. Johnnie Vinson: A Jazzy Christmas</li>
                          <li>arr. Franz Watz: Jingle Bells / Morgen Kommt der Weihnachtsmann</li>
                          <li>Julius Fucik (arr. Mnozil): Florentiner Marsch</li>
                        </ol>
                      </div>
                      <div class="col-md-6">
                        <h5>ESTATE 2022</h5>
                        <ol class="list-marked">
                          <li>Julius Fucik: Die Regimentskinder</li>
                          <li>Alfred Bösendorfer: Kleine Ungarische Rhapsodie</li>
                          <li>Franco Cesarini: Greek Folk Song Suite</li>
                          <li>Edi Sagert: Heut' scheint der Mond so schön</li>
                          <li>Kurt Gäble: Heublumen Polka</li>
                          <li>Florian Ziller: Aria d'amore</li>
                          <li>Marcel Louiguy: Cerisier rose et pommier blanc</li>
                          <li>Julius Fucik (arr. Mnozil Brass): Florentiner Marsch</li>
                        </ol>
                        
                        <h5>BLASMUSIK 2022</h5>
                        <ol class="list-marked">
                          <li>Musik, Musik!</li>
                          <li>Willkommen-Polka</li>
                          <li>Frühlingswalzer</li>
                          <li>Haspinger-Marsch</li>
                          <li>Auf der Vogelwiese</li>
                          <li>Urlaubsfreuden</li>
                          <li>Bozner Bergsteigerlied</li>
                          <li>Castaldo-Nova</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
              </article>

              <!-- 2020-2021 -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a class="collapsed" id="accordion-heading-2020-2021" data-toggle="collapse" data-parent="#accordion-repertoire" href="#accordion-collapse-2020-2021" aria-controls="accordion-collapse-2020-2021" aria-expanded="false" role="button">Repertorio 2020-2021
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse" id="accordion-collapse-2020-2021" aria-labelledby="accordion-heading-2020-2021" data-parent="#accordion-repertoire" role="tabpanel">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <h5>CONCERTO 2021</h5>
                        <ol class="list-marked">
                          <li>Tielman Susato (arr. Williams): Renaissance Dances</li>
                          <li>Jan Van der Roost: Nemu-Susato</li>
                          <li>Ludwig van Beethoven (arr. Brubaker): Heroic Variations</li>
                          <li>Johan de Meij (arr. Lavender): Hobbits Dance and Hymn</li>
                          <li>Philip Sparke: A Klezmer Karnival</li>
                          <li>Martin Scharnagl: Zeitlos</li>
                          <li>Kurt Gäble: Wir Musikanten</li>
                          <li>Julius Fucik: Attila – Marche hongroise triomphale</li>
                        </ol>
                        
                        <h5>CONCERTO 2020</h5>
                        <ol class="list-marked">
                          <li>Julius Fucik: Attila – Marche Hongroise Triomphale</li>
                          <li>Piotr Ilic Tchaikovsky (arr. Huckeby): Themes from The Nutcracker</li>
                          <li>Piotr Ilic Tchaikovsky (arr. Curnow): Finale from Symphony No. 5</li>
                          <li>James Swearingen: Eiger</li>
                          <li>Johan De Meij: (arr. Lavender): Hobbits Dance and Hymn</li>
                          <li>Kurt Gäble: Heublumen-Polka</li>
                          <li>Kurt Gäble: Fast Himmelblau</li>
                          <li>Franz Watz: Rossini-Polka</li>
                        </ol>
                      </div>
                      <div class="col-md-6">
                        <h5>CONCERTO 2019</h5>
                        <ol class="list-marked">
                          <li>Alfred Bösendorfer: Il Postiglione d'Amore</li>
                          <li>Piotr Ilic Tchaikovsky (arr. Huckeby): Themes from The Nutcracker</li>
                          <li>Piotr Ilic Tchaikovsky (arr. Curnow): Finale from Symphony No. 5</li>
                          <li>Johan De Meij: (arr. Lavender): Hobbits Dance and Hymn</li>
                          <li>Robert Sheldon: Spontaneous Combustion</li>
                          <li>arr. Philip Sparke: David of the White Rock</li>
                          <li>Alfred Reed (arr. Longfield): El Camino Real</li>
                          <li>Freddy Mercury: Somebody To Love</li>
                          <li>Martin Scharnagl: Von Freund zu Freund</li>
                        </ol>
                        
                        <h5>BLASMUSIK 2019</h5>
                        <ol class="list-marked">
                          <li>Musik musik!</li>
                          <li>Willkommen-Polka</li>
                          <li>Urlaubsfreuden</li>
                          <li>Bozner Bergsteigerlied</li>
                          <li>Slavonicka-Polka</li>
                          <li>Fast Himmelblau</li>
                          <li>Jehlička-Polka</li>
                          <li>Highland Cathedral</li>
                          <li>Castaldo-Nova</li>
                          <li>Arena Classics</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
              </article>

              <!-- 2018-2013 -->
              <article class="card card-custom card-corporate">
                <div class="card-header" role="tab">
                  <div class="card-title">
                    <a class="collapsed" id="accordion-heading-2018-2013" data-toggle="collapse" data-parent="#accordion-repertoire" href="#accordion-collapse-2018-2013" aria-controls="accordion-collapse-2018-2013" aria-expanded="false" role="button">Repertorio 2018-2013
                      <div class="card-arrow"></div>
                    </a>
                  </div>
                </div>
                <div class="collapse" id="accordion-collapse-2018-2013" aria-labelledby="accordion-heading-2018-2013" data-parent="#accordion-repertoire" role="tabpanel">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <h5>CONCERTO 2018</h5>
                        <ol class="list-marked">
                          <li>Jan Van der Roost: Condacum</li>
                          <li>Bert Appermont: Return Of The Vikings</li>
                          <li>Robert Sheldon: Spontaneous Combustion</li>
                          <li>Robert W. Smith: Encanto</li>
                          <li>Andrew Lloyd Webber (arr. Sweeney): Don't Cry for Me Argentina</li>
                          <li>Alfred Reed (arr. Longfield): El Camino Real</li>
                          <li>Franco Cesarini: Greek Folk Song Suite</li>
                          <li>James Swearingen: Eiger</li>
                          <li>Kurt Gäble: Heublumen-Polka</li>
                          <li>Julius Fucik: Die lustigen Dorfschmiede</li>
                        </ol>
                        
                        <h5>BLASMUSIK 2018</h5>
                        <ol class="list-marked">
                          <li>Musik Musik!</li>
                          <li>Jehlička-Polka</li>
                          <li>Urlaubsfreude</li>
                          <li>Jászkun-Indulò</li>
                          <li>Slavonicka-Polka</li>
                          <li>Fast Himmelblau</li>
                          <li>Willkommen-Polka</li>
                          <li>Highland Cathedral</li>
                          <li>Arena Classics</li>
                        </ol>
                        
                        <h5>ESTATE 2017</h5>
                        <ol class="list-marked">
                          <li>James Swearingen: Eiger</li>
                          <li>Jan Van der Roost: Condacum</li>
                          <li>Pierre Laplante: In The Forest Of The King</li>
                          <li>Robert W. Smith: Encanto</li>
                          <li>Marcel Louiguy: Cerisier rose et pommier blanc</li>
                          <li>Frantisek Kmoch: Musik Musik!</li>
                          <li>Siegfried Rundel: Urlaubsfreunde</li>
                          <li>Josef Poncar: Auf der Vogelwiese</li>
                          <li>Julius Fucik: Florentiner Marsch</li>
                        </ol>
                      </div>
                      
                      <div class="col-md-6">
                        <h5>BLASMUSIK 2017</h5>
                        <ol class="list-marked">
                          <li>Musik Musik!</li>
                          <li>Willkommen-Polka</li>
                          <li>Urlaubsfreunde</li>
                          <li>Andreas Hofer-Marsch</li>
                          <li>Dejvicanka-Polka</li>
                          <li>Auf der Heide blühn die letzten Rosen</li>
                          <li>Auf der Vogelwiese</li>
                          <li>Dem Land Tirol die Treue</li>
                        </ol>
                        
                        <h5>ESTATE 2016</h5>
                        <ol class="list-marked">
                          <li>Ralph Vaughan Williams: Sea Songs</li>
                          <li>Bert Appermont: Return Of The Vikings</li>
                          <li>Pierre Laplante: In The Forest Of The King</li>
                          <li>James Swearingen: Eiger</li>
                          <li>James Barnes: Yorkshire Ballad</li>
                          <li>Beethoven/Goldhammer: Festmarsch</li>
                          <li>Franz Watz: Rossini-Polka</li>
                          <li>Manuel da Falla: Ritual Fire Dance</li>
                          <li>Freddy Mercury: Somebody To Love</li>
                        </ol>
                        
                        <h5>BLASMUSIK 2016</h5>
                        <ol class="list-marked">
                          <li>Standschützen Marsch</li>
                          <li>Willkommen-Polka</li>
                          <li>Rauschendes Bächlein</li>
                          <li>Schemua-Marsch</li>
                          <li>Jehlička-Polka</li>
                          <li>Auf der Heide blühn die letzten Rosen</li>
                          <li>Auf der Vogelwiese</li>
                          <li>Dem Land Tirol die Treue</li>
                        </ol>
                      </div>
                    </div>
                    
                    <div class="row mt-4">
                      <div class="col-md-6">
                        <h5>ESTATE 2015</h5>
                        <ol class="list-marked">
                          <li>Josef Franz Wagner: 47er Regimentsmarsch</li>
                          <li>Alfred Bösendorfer: Il postiglione d'Amore</li>
                          <li>Franz Watz: Rossini-Polka</li>
                          <li>Beethoven/Goldhammer: Festmarsch</li>
                          <li>Jan Moravec: Ludwig-Polka</li>
                          <li>Alfred Bösendorfer: Kleine Ungarische Rhapsodie</li>
                          <li>Bert Appermont: Return of the Vikings</li>
                          <li>Michael Korb: Highland Cathedral</li>
                          <li>Josef Poncar: Auf der Vogelwiese</li>
                          <li>Friedrich Eichberger: Anno neun</li>
                        </ol>
                        
                        <h5>BLASMUSIK 2015</h5>
                        <ol class="list-marked">
                          <li>47er Regimentsmarsch</li>
                          <li>Slavonicka-Polka</li>
                          <li>Frühlingswalzer</li>
                          <li>Tondovi-Polka</li>
                          <li>Waidmannsheil!</li>
                          <li>Willkommen-Polka</li>
                          <li>Im schönen Böhmerwald</li>
                          <li>Auf der Vogelwiese</li>
                          <li>Dem Land Tirol die Treue</li>
                        </ol>
                      </div>
                      
                      <div class="col-md-6">
                        <h5>ESTATE 2014</h5>
                        <ol class="list-marked">
                          <li>Julius Fucik: Florentiner Marsch</li>
                          <li>Alfred Bösendorfer: Il postiglione d'Amore</li>
                          <li>Charles Gounod: Faust – Choeur des soldats</li>
                          <li>Jan Moravec: Ludwig-Polka</li>
                          <li>Gottfried Sonntag: Nibelungen Marsch</li>
                          <li>Alfred Bösendorfer: Kleine Ungarische Rhapsodie</li>
                          <li>Ralph Vaughan Williams: Sea Songs</li>
                          <li>Andrew Lloyd Webber (arr. Michael Sweeney): Don't Cry For Me Argentina</li>
                          <li>arr. Ralph Ford: Go West!</li>
                        </ol>
                        
                        <h5>BLASMUSIK 2013</h5>
                        <ol class="list-marked">
                          <li>47er Regimentsmarsch</li>
                          <li>Willkommen-Polka</li>
                          <li>Im schönen Böhmerwald</li>
                          <li>Waidmannsheil!</li>
                          <li>Slavonicka-Polka</li>
                          <li>Rauschendes Bächlein</li>
                          <li>Andreas Hofer-Marsch</li>
                          <li>Meine Liebste</li>
                          <li>Auf der Vogelwiese</li>
                          <li>Dem Land Tirol die Treue</li>
                        </ol>
                      </div>
                    </div>
                    
                    <div class="row mt-4">
                      <div class="col-12">
                        <h5>CONCERTO DI NATALE 2012</h5>
                        <ol class="list-marked">
                          <li>Steven Reineke: Merry Christmas Everyone!</li>
                          <li>Walter Tuschla: Verdi</li>
                          <li>Johann Strauss I: Sperl-Polka</li>
                          <li>Johann Strauss II: Vergnügungszug</li>
                          <li>Josef Strauss: Feuerfest</li>
                          <li>Johann Strauss II: Auf der Jagd</li>
                          <li>Franco Cesarini: Greek Folk Song Suite</li>
                          <li>Johnnie Vinson: A Jazzy Christmas</li>
                        </ol>
                        
                        <h5>CONCERTI D'ESTATE 2012</h5>
                        <ol class="list-marked">
                          <li>Julius Fučík: Die Regimentskinder</li>
                          <li>Walter Tuschla: Verdi</li>
                          <li>Josef Strauss: Feuerfest</li>
                          <li>Johann Strauss II: Vergnügungszug</li>
                          <li>Friedrich Eichberger: Anno neun</li>
                          <li>Josef Poncar: Auf der Vogelwiese</li>
                          <li>Siegfried Rundel: Im schönen Böhmerwald</li>
                          <li>August Reckling: Waidmannsheil!</li>
                          <li>Albert Parlow: Amboss-Polka</li>
                          <li>Franco Cesarini: O Charalambis (da "Greek Folk Song Suite")</li>
                          <li>Leroy Anderson: Blue Tango</li>
                          <li>Florian Pedarnig: Dem Land Tirol die Treue</li>
                        </ol>
                      </div>
                    </div>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 text-center mt-5 pt-4">
            <div class="button-wrap">
              <a class="button button-lg button-primary" href="<?php echo SITE_URL; ?>/concerti">Scopri i Nostri Concerti</a>
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
    "@type": "MusicPlaylist",
    "name": "Repertorio della Banda Folk di Castello Tesino",
    "numTracks": 15,
    "track": [
      {
        "@type": "MusicRecording",
        "name": "Von Freund zu Freund",
        "composer": "Martin Scharnagel"
      },
      {
        "@type": "MusicRecording",
        "name": "Dem Land Tirol die Treue",
        "composer": "Florian Pedarnig"
      },
      {
        "@type": "MusicRecording",
        "name": "Kaiserin Sissi Marsch",
        "composer": "Timo Dellweg"
      }
    ]
  }';
  ?>

  <!-- Page Scripts -->
  <?php include_once TEMPLATES_PATH . 'scripts.php'; ?>
</body>

</html>
