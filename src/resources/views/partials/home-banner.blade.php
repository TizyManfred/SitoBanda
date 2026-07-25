@if (($homeBanner['visible'] ?? false) && filled($homeBanner['headline'] ?? null))
    <aside class="home-banner" aria-label="{{ __('home.banner.aria_label') }}">
        <div class="container">
            <div class="home-banner__inner">
                @if(filled($homeBanner['image'] ?? null))
                    <div class="home-banner__visual" aria-hidden="true">
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($homeBanner['image']) }}"
                            alt=""
                            loading="eager"
                        >
                        @if(filled($homeBanner['badge'] ?? null))
                            <span class="home-banner__badge home-banner__badge--overlay">{{ $homeBanner['badge'] }}</span>
                        @endif
                    </div>
                @elseif(filled($homeBanner['badge'] ?? null))
                    <span class="home-banner__badge">{{ $homeBanner['badge'] }}</span>
                @endif

                <div class="home-banner__content">
                    <strong class="home-banner__headline">{{ $homeBanner['headline'] }}</strong>
                    @if(filled($homeBanner['body'] ?? null))
                        <p class="home-banner__text">{{ $homeBanner['body'] }}</p>
                    @endif
                </div>

                @if(filled($homeBanner['cta_label'] ?? null) && filled($homeBanner['cta_url'] ?? null))
                    <a
                        class="button button-primary button-ujarak home-banner__cta"
                        href="{{ $homeBanner['cta_url'] }}"
                        title="{{ $homeBanner['cta_label'] }}"
                    >
                        <span>{{ $homeBanner['cta_label'] }}</span>
                        <span class="home-banner__arrow" aria-hidden="true">&rarr;</span>
                    </a>
                @endif
            </div>
        </div>
    </aside>
@endif
