<div class="language-switcher">
    <div class="current-language" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false" aria-label="{{ __('header.select_language') }}">
        <span class="language-flag-{{ LaravelLocalization::getCurrentLocale() }}"></span>
        <span class="language-code">{{ strtoupper(LaravelLocalization::getCurrentLocale()) }}</span>
        <i class="bi bi-caret-down-fill"></i>
    </div>
    <div class="language-dropdown">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <a rel="alternate" class="language-option {{ LaravelLocalization::getCurrentLocale() === $localeCode ? 'active' : '' }}" data-locale="{{ $localeCode }}" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                <span class="language-flag-{{ explode('_', $properties['regional'])[0] }}"></span>
                <span class="language-name">{{ $properties['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
