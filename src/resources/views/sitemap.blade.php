<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xhtml="http://www.w3.org/1999/xhtml"
>
  @php
    $supportedLocales = LaravelLocalization::getSupportedLocales();
    $defaultLocale = LaravelLocalization::getDefaultLocale();

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

    $localizedRouteUrl = function (string $routeName, string $localeCode, array|string|null $parameters = null) use ($defaultLocale) {
      $parameters ??= [];

      return LaravelLocalization::getLocalizedURL(
        $localeCode,
        route($routeName, $parameters),
        [],
        $localeCode !== $defaultLocale
      );
    };
  @endphp

  @foreach($supportedLocales as $localeCode => $properties)
    @foreach($namedRoutes as $routeName => $priority)
      @if(Route::has($routeName))
        @php
          $alternateUrls = [];

          foreach ($supportedLocales as $alternateLocale => $alternateProperties) {
            $alternateUrls[$alternateLocale] = $localizedRouteUrl($routeName, $alternateLocale);
          }
        @endphp
        <url>
          <loc>{{ $alternateUrls[$localeCode] }}</loc>
          @foreach($alternateUrls as $alternateLocale => $alternateUrl)
            <xhtml:link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ $alternateUrl }}" />
          @endforeach
          <xhtml:link rel="alternate" hreflang="x-default" href="{{ $alternateUrls[$defaultLocale] }}" />
          <changefreq>weekly</changefreq>
          <priority>{{ $priority }}</priority>
        </url>
      @endif
    @endforeach

    @foreach($events as $event)
      @continue(!Route::has('eventi.show'))
      @php
        $alternateUrls = [];

        foreach ($supportedLocales as $alternateLocale => $alternateProperties) {
          $localizedSlug = $event->getTranslation('slug', $alternateLocale, false);

          if (filled($localizedSlug)) {
            $alternateUrls[$alternateLocale] = $localizedRouteUrl('eventi.show', $alternateLocale, $localizedSlug);
          }
        }
      @endphp
      @continue(empty($alternateUrls[$localeCode]))
      <url>
        <loc>{{ $alternateUrls[$localeCode] }}</loc>
        @foreach($alternateUrls as $alternateLocale => $alternateUrl)
          <xhtml:link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ $alternateUrl }}" />
        @endforeach
        @if(isset($alternateUrls[$defaultLocale]))
          <xhtml:link rel="alternate" hreflang="x-default" href="{{ $alternateUrls[$defaultLocale] }}" />
        @endif
        <lastmod>{{ $event->updated_at->toW3cString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
      </url>
    @endforeach

    @foreach($galleries as $album)
      @continue(!Route::has('galleria.album'))
      @php
        $alternateUrls = [];

        foreach ($supportedLocales as $alternateLocale => $alternateProperties) {
          $localizedSlug = $album->getTranslation('slug', $alternateLocale, false);

          if (filled($localizedSlug)) {
            $alternateUrls[$alternateLocale] = $localizedRouteUrl('galleria.album', $alternateLocale, $localizedSlug);
          }
        }
      @endphp
      @continue(empty($alternateUrls[$localeCode]))
      <url>
        <loc>{{ $alternateUrls[$localeCode] }}</loc>
        @foreach($alternateUrls as $alternateLocale => $alternateUrl)
          <xhtml:link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ $alternateUrl }}" />
        @endforeach
        @if(isset($alternateUrls[$defaultLocale]))
          <xhtml:link rel="alternate" hreflang="x-default" href="{{ $alternateUrls[$defaultLocale] }}" />
        @endif
        <lastmod>{{ $album->updated_at->toW3cString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
      </url>
    @endforeach
  @endforeach
</urlset>
