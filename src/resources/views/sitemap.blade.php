<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  @php
    $namedRoutes = [
      'home',
      'storia', 'abito-tradizionale', 'organico', 'maestro',
      'eventi', 'repertorio', 'galleria', 'contatti',
      'privacy-policy', 'corsi-di-musica', 'italia-gira-banda', 'chi-siamo',
    ];
  @endphp

  @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    @foreach($namedRoutes as $routeName)
      @if(Route::has($routeName))
        <url>
          <loc>{{ LaravelLocalization::localizeURL(route($routeName), $localeCode) }}</loc>
          <changefreq>weekly</changefreq>
          <priority>{{ $routeName === 'home' ? '1.0' : '0.7' }}</priority>
        </url>
      @endif
    @endforeach
  @endforeach
</urlset>
