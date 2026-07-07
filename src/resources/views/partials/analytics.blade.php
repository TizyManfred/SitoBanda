@php
    $analytics = $analyticsSettings ?? \App\Helpers\SettingsHelper::analytics();
    $isEnabled = (bool) ($analytics['enabled'] ?? false);
    $provider = $analytics['provider'] ?? 'none';
    $ga4MeasurementId = trim((string) ($analytics['ga4_measurement_id'] ?? ''));
    $plausibleDomain = trim((string) ($analytics['plausible_domain'] ?? ''));
    $plausibleScriptUrl = trim((string) ($analytics['plausible_script_url'] ?? 'https://plausible.io/js/script.js'));
@endphp

@if($isEnabled && $provider === 'ga4' && $ga4MeasurementId !== '')
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('consent', 'default', {
            'ad_storage': 'denied',
            'ad_user_data': 'denied',
            'ad_personalization': 'denied',
            'analytics_storage': 'denied'
        });
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($ga4MeasurementId) }}"></script>
    <script>
        gtag('js', new Date());
        gtag('config', @json($ga4MeasurementId));
    </script>
@endif

@if($isEnabled && $provider === 'plausible' && $plausibleDomain !== '')
    <script
        defer
        data-domain="{{ e($plausibleDomain) }}"
        src="{{ e($plausibleScriptUrl) }}"
    ></script>
@endif
