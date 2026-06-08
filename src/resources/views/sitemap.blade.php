<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  @php
    $namedRoutes = [
      'home'       => 1.0,
      'chi-siamo'  => 0.8,
      'storia'     => 0.8,
      'organico'   => 0.8,
      'maestro'    => 0.8,
      'repertorio' => 0.8,
      'abito-tradizionale' => 0.7,
      'italia-gira-banda'  => 0.7,
      'corsi-di-musica'    => 0.7,
      'privacy-policy'     => 0.3,
      'eventi'     => 0.9,
      'galleria'   => 0.9,
      'contatti'   => 0.7,
    ];

    $events = \App\Models\Event::public()->get();
    $galleries = \App\Models\GalleryAlbum::where('is_published', 1)->get();
  @endphp

  @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    @foreach($namedRoutes as $routeName => $priority)
      @if(Route::has($routeName))
        <url>
          <loc>{{ LaravelLocalization::localizeURL(route($routeName), $localeCode) }}</loc>
          <changefreq>weekly</changefreq>
          <priority>{{ $priority }}</priority>
        </url>
      @endif
    @endforeach

    @foreach($events as $event)
      @continue(!Route::has('eventi.show'))
      <url>
        <loc>{{ LaravelLocalization::localizeURL(route('eventi.show', $event->getTranslation('slug', $localeCode)), $localeCode) }}</loc>
        <lastmod>{{ $event->updated_at->toW3cString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
      </url>
    @endforeach

    @foreach($galleries as $album)
      @continue(!Route::has('galleria.album'))
      <url>
        <loc>{{ LaravelLocalization::localizeURL(route('galleria.album', $album->getTranslation('slug', $localeCode)), $localeCode) }}</loc>
        <lastmod>{{ $album->updated_at->toW3cString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
      </url>
    @endforeach
  @endforeach
</urlset>
