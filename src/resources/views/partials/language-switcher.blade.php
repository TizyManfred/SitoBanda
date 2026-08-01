@php
    $flagKey = function (string $localeCode, array $properties): string {
        if ($localeCode === 'pt-BR') {
            return 'br';
        }

        return explode('_', $properties['regional'] ?? '')[0];
    };
    $currentLocaleCode = LaravelLocalization::getCurrentLocale();
    $currentLocaleProperties = LaravelLocalization::getSupportedLocales()[$currentLocaleCode] ?? [];
@endphp
<div class="language-switcher">
    <div class="current-language" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false" aria-label="{{ __('header.select_language') }}">
        <span class="language-flag-{{ $flagKey($currentLocaleCode, $currentLocaleProperties) }}"></span>
        <span class="language-code">{{ strtoupper($currentLocaleCode) }}</span>
        <i class="bi bi-caret-down-fill"></i>
    </div>
    <div class="language-dropdown">
        @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
            <a rel="alternate" class="language-option {{ $currentLocaleCode === $localeCode ? 'active' : '' }}" data-locale="{{ $localeCode }}" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                <span class="language-flag-{{ $flagKey($localeCode, $properties) }}"></span>
                <span class="language-name">{{ $properties['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
