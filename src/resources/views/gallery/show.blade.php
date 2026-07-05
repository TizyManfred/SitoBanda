@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

$metaDescription = Str::limit(
    trim(strip_tags($album->description ?: '')),
    160
);

if ($metaDescription === '') {
    $metaDescription = Str::limit(
        collect([
            $album->title,
            $images->count() . ' ' . trans_choice('gallery.photos', $images->count()),
            $album->start_date?->translatedFormat('F Y'),
        ])->filter()->implode(' - '),
        160
    );
}

$coverImage = $images->count() > 0 ? Storage::url($images->first()->image_path) : asset('images/FotoGalleria1.webp');
$currentSlug = $album->getTranslation('slug', app()->getLocale(), false) ?: $album->slug;
$canonicalUrl = route('galleria.album', $currentSlug);
$alternateUrls = [];
$defaultLocale = LaravelLocalization::getDefaultLocale();

foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
    $localizedSlug = $album->getTranslation('slug', $localeCode, false);

    if (filled($localizedSlug)) {
        $alternateUrls[$localeCode] = LaravelLocalization::getLocalizedURL(
            $localeCode,
            route('galleria.album', $localizedSlug),
            [],
            $localeCode !== $defaultLocale
        );
    }
}

$shareUrl = $canonicalUrl;
$shareText = $album->title . ' - ' . $metaDescription;
@endphp

@section('title', $album->title . ' - Galleria - Banda Folk di Castello Tesino')
@section('description', $metaDescription)
@section('canonical', $canonicalUrl)
@section('og_title', $album->title . ' - Galleria - Banda Folk di Castello Tesino')
@section('og_description', $metaDescription)
@section('og_type', 'article')
@section('og_image', $coverImage)

@section('alternate_urls')
@foreach($alternateUrls as $localeCode => $alternateUrl)
    <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ $alternateUrl }}" />
@endforeach
@if(isset($alternateUrls[$defaultLocale]))
    <link rel="alternate" hreflang="x-default" href="{{ $alternateUrls[$defaultLocale] }}" />
@endif
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
            <div class="container">
                <h1 class="breadcrumbs-custom-title">{{ $album->title }}</h1>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="{{ route('home') }}">{{ __('header.home') }}</a></li>
                    <li><a href="{{ route('galleria') }}">{{ __('gallery.breadcrumb') }}</a></li>
                    <li class="active">{{ $album->title }}</li>
                </ul>
            </div>
            <div class="box-position" style="background-image: url({{ $coverImage }}); background-position: center center;"></div>
        </div>
    </section>

    <!-- Gallery Content -->
    <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-12">
                    <!-- Album Info -->
                    <div class="post">
                        <div class="box-inset-1">
                            {{-- <h2 class="mb-4 title-decoration-lines-left">{{ $album->title }}</h2> --}}
                            
                            <div class="row box-event-modern-meta gallery-detail-meta">
                                @if($album->start_date)
                                    <div class="col-auto box-event-modern-meta-item mr-3">
                                        <i class="fa fa-calendar mr-1"></i> <span class="font-weight-bold">{{ $album->start_date->translatedFormat('d M Y') }}</span>
                                    </div>
                                @endif
                                <div class="col-auto box-event-modern-meta-item mr-3">
                                    <i class="fa fa-image mr-1"></i> <span class="font-weight-bold">{{ $images->count() }}</span> {{ trans_choice('gallery.photos', $images->count()) }}
                                </div>
                                <div class="col-auto box-event-modern-meta-item">
                                    <i class="fa fa-eye mr-1"></i> <span class="font-weight-bold">{{ $album->view_count ?? 0 }}</span> {{ __('gallery.views') }}
                                </div>
                            </div>
                            
                            @if(filled(trim(strip_tags($album->description))))
                                <div class="post-content gallery-detail-description mt-4">
                                    {!! $album->description !!}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Gallery Images -->
                    <div class="mt-5 mb-5">
                        <h4 class="heading-4 mb-4">{{ __('gallery.photos_heading') }}</h4>
                        <div class="divider"></div>
                        
                        <div class="row row-30 offset-top-40" data-lightgallery="group">
                            @forelse($images as $image)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="thumbnail-classic">
                                        <div class="thumbnail-classic-figure">
                                            <a href="{{ Storage::url($image->image_path) }}" data-lightgallery="item" data-title="{{ $image->caption ?? $album->title }}" data-sub-html="{{ e($image->caption ?? $album->title) }}">
                                                <div class="image-height-1">
                                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->caption ?? $album->title }}" loading="lazy">
                                                </div>
                                            </a>
                                        </div>
                                        @if($image->caption)
                                        <div class="thumbnail-classic-caption">
                                            <div class="thumbnail-classic-title-wrap">
                                                <h6 class="thumbnail-classic-title">{{ $image->caption }}</h6>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="box-default">
                                        <p>{{ __('gallery.no_images') }}</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        
                        <!-- Pagination -->
                        @if($images instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="pagination-wrap mt-4">
                                {{ $images->links() }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="gallery-detail-footer">
                        <div class="row row-30 align-items-stretch">
                            @if(isset($event) && $event)
                                <div class="col-lg-7">
                                    <article class="gallery-related-event">
                                        @if($event->image_path)
                                            <div class="gallery-related-event-image">
                                                <a href="{{ route('eventi.show', $event->slug) }}">
                                                    <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" loading="lazy">
                                                </a>
                                            </div>
                                        @endif
                                        <div class="gallery-related-event-body">
                                            <span class="gallery-panel-eyebrow"><i class="fa fa-calendar mr-1"></i>{{ __('gallery.related_event') }}</span>
                                            <h4 class="heading-4"><a href="{{ route('eventi.show', $event->slug) }}">{{ $event->title }}</a></h4>
                                            @if($event->start_datetime || $event->location)
                                                <div class="gallery-related-event-meta">
                                                    @if($event->start_datetime)
                                                        <span><i class="fa fa-clock-o mr-1"></i>{{ $event->start_datetime->translatedFormat('d M Y') }}</span>
                                                    @endif
                                                    @if($event->location)
                                                        <span><i class="fa fa-map-marker mr-1"></i>{{ $event->location }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                            @if($event->short_description)
                                                <p>{{ Str::limit($event->short_description, 150) }}</p>
                                            @endif
                                            <a href="{{ route('eventi.show', $event->slug) }}" class="button button-sm button-default-outline button-wapasha">
                                                {{ __('gallery.event_details') }}
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            @endif

                            <div class="{{ isset($event) && $event ? 'col-lg-5' : 'col-lg-12' }}">
                                <div class="gallery-share-panel">
                                    <span class="gallery-panel-eyebrow"><i class="fa fa-share-alt mr-1"></i>{{ __('gallery.share_album') }}</span>
                                    <h4 class="heading-4">{{ __('gallery.share_title') }}</h4>
                                    <div class="share-actions share-actions-compact mt-3">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" class="share-action share-action-facebook" aria-label="{{ __('gallery.share_facebook') }}"><i class="fa fa-facebook"></i><span>Facebook</span></a>
                                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($album->title) }}&url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" class="share-action share-action-twitter" aria-label="{{ __('gallery.share_twitter') }}"><i class="fa fa-twitter"></i><span>Twitter</span></a>
                                        <a href="https://wa.me/?text={{ urlencode($shareText . ' - ' . $shareUrl) }}" target="_blank" rel="noopener" class="share-action share-action-whatsapp" aria-label="{{ __('gallery.share_whatsapp') }}"><i class="fa fa-whatsapp"></i><span>WhatsApp</span></a>
                                        <a href="mailto:?subject={{ urlencode($album->title) }}&body={{ urlencode($shareText . ' - ' . $shareUrl) }}" class="share-action share-action-email" aria-label="{{ __('gallery.share_email') }}"><i class="fa fa-envelope"></i><span>Email</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($otherAlbums->count() > 0)
                            <div class="gallery-other-albums">
                                <div class="gallery-section-heading">
                                    <h4 class="heading-4">{{ __('gallery.other_albums') }}</h4>
                                    <a href="{{ route('galleria') }}">{{ __('gallery.all_albums') }} <i class="fa fa-arrow-right ml-1"></i></a>
                                </div>
                                <div class="row row-30">
                                    @foreach($otherAlbums as $otherAlbum)
                                        @php
                                            $otherCover = $otherAlbum->items()->where('is_featured', 1)->first()
                                                ?? $otherAlbum->items()->orderBy('sort_order', 'asc')->first();
                                            $otherCount = $otherAlbum->items_count ?? $otherAlbum->items()->count();
                                        @endphp
                                        <div class="col-sm-6 col-lg-3">
                                            <a href="{{ route('galleria.album', $otherAlbum->slug) }}" class="gallery-mini-card">
                                                <img src="{{ $otherCover && $otherCover->image_path ? Storage::url($otherCover->image_path) : asset('images/FotoGalleria1.webp') }}" alt="{{ $otherAlbum->title }}" loading="lazy">
                                                <span>
                                                    <strong>{{ $otherAlbum->title }}</strong>
                                                    <small>{{ $otherCount }} {{ trans_choice('gallery.photos', $otherCount) }}</small>
                                                </span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('structured_data')
@php
    $structuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => __('header.home'),
                        'item' => route('home'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => __('gallery.breadcrumb'),
                        'item' => route('galleria'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 3,
                        'name' => $album->title,
                        'item' => url()->current(),
                    ],
                ],
            ],
            [
                '@type' => 'ImageGallery',
                'name' => $album->title,
                'description' => $metaDescription,
                'url' => url()->current(),
                'image' => [url($coverImage)],
            ],
        ],
    ];
@endphp

@json($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
@endsection
