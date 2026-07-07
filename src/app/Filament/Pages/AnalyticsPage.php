<?php

namespace App\Filament\Pages;

use App\Helpers\SettingsHelper;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Throwable;

class AnalyticsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $slug = 'analytics';

    protected static ?int $navigationSort = 110;

    protected static string $view = 'filament.pages.analytics-page';

    public array $summary = [];

    public array $chartLabels = [];

    public array $chartVisitors = [];

    public array $chartPageViews = [];

    public array $topPages = [];

    public array $topReferrers = [];

    public array $topBrowsers = [];

    public array $topCountries = [];

    public ?string $analyticsError = null;

    public array $analyticsSettings = [];

    public string $credentialsPath = '';

    public bool $credentialsFileExists = false;

    public function mount(): void
    {
        $this->analyticsSettings = SettingsHelper::analytics();
        $this->credentialsPath = (string) config('analytics.service_account_credentials_json');
        $this->credentialsFileExists = is_file($this->credentialsPath);

        $this->summary = [
            'visitors7d' => 0,
            'pageViews7d' => 0,
            'visitors30d' => 0,
            'pageViews30d' => 0,
        ];

        if (! $this->hasAnalyticsConfiguration()) {
            return;
        }

        try {
            $last7Days = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));
            $last30Days = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));

            $this->summary = [
                'visitors7d' => (int) $last7Days->sum('activeUsers'),
                'pageViews7d' => (int) $last7Days->sum('screenPageViews'),
                'visitors30d' => (int) $last30Days->sum('activeUsers'),
                'pageViews30d' => (int) $last30Days->sum('screenPageViews'),
            ];

            $this->chartLabels = $last30Days
                ->map(fn (array $row): string => $row['date']->format('d/m'))
                ->values()
                ->all();

            $this->chartVisitors = $last30Days
                ->map(fn (array $row): int => (int) $row['activeUsers'])
                ->values()
                ->all();

            $this->chartPageViews = $last30Days
                ->map(fn (array $row): int => (int) $row['screenPageViews'])
                ->values()
                ->all();

            $this->topPages = Analytics::fetchMostVisitedPages(Period::days(30), 10)
                ->map(function (array $row): array {
                    return [
                        'title' => $row['pageTitle'] ?: '(senza titolo)',
                        'url' => $row['fullPageUrl'],
                        'page_views' => (int) $row['screenPageViews'],
                    ];
                })
                ->values()
                ->all();

            $this->topReferrers = Analytics::fetchTopReferrers(Period::days(30), 10)
                ->filter(fn (array $row): bool => ($row['pageReferrer'] ?? '') !== '')
                ->map(function (array $row): array {
                    return [
                        'referrer' => $row['pageReferrer'],
                        'page_views' => (int) $row['screenPageViews'],
                    ];
                })
                ->values()
                ->all();

            $this->topBrowsers = Analytics::fetchTopBrowsers(Period::days(30), 10)
                ->map(function (array $row): array {
                    return [
                        'browser' => $row['browser'],
                        'page_views' => (int) $row['screenPageViews'],
                    ];
                })
                ->values()
                ->all();

            $this->topCountries = Analytics::fetchTopCountries(Period::days(30), 10)
                ->map(function (array $row): array {
                    return [
                        'country' => $row['country'],
                        'page_views' => (int) $row['screenPageViews'],
                    ];
                })
                ->values()
                ->all();
        } catch (Throwable $exception) {
            report($exception);

            $this->analyticsError = $exception->getMessage();
        }
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.navigation.analytics');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.system');
    }

    public function getTitle(): string
    {
        return __('filament.navigation.analytics');
    }

    public function hasAnalyticsConfiguration(): bool
    {
        return ($this->analyticsSettings['provider'] ?? null) === 'ga4'
            && ($this->analyticsSettings['ga4_property_id'] ?? '') !== ''
            && $this->credentialsFileExists;
    }

    public function getSetupItems(): Collection
    {
        return collect([
            [
                'label' => __('filament.analytics.setup.provider'),
                'value' => $this->analyticsSettings['provider'] ?? 'none',
                'ok' => ($this->analyticsSettings['provider'] ?? null) === 'ga4',
            ],
            [
                'label' => __('filament.analytics.setup.measurement_id'),
                'value' => $this->analyticsSettings['ga4_measurement_id'] ?: __('filament.analytics.not_set'),
                'ok' => ($this->analyticsSettings['ga4_measurement_id'] ?? '') !== '',
            ],
            [
                'label' => __('filament.analytics.setup.property_id'),
                'value' => $this->analyticsSettings['ga4_property_id'] ?: __('filament.analytics.not_set'),
                'ok' => ($this->analyticsSettings['ga4_property_id'] ?? '') !== '',
            ],
            [
                'label' => __('filament.analytics.setup.credentials_file'),
                'value' => $this->credentialsPath,
                'ok' => $this->credentialsFileExists,
            ],
        ]);
    }
}
