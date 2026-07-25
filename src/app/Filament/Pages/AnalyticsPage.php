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

    public array $dailyTraffic = [];

    public array $topPages = [];

    public array $topReferrers = [];

    public array $userTypes = [];

    public array $topBrowsers = [];

    public array $topCountries = [];

    public array $topOperatingSystems = [];

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
            'pageViewsPerVisitor7d' => 0,
            'pageViewsPerVisitor30d' => 0,
        ];

        if (! $this->hasAnalyticsConfiguration()) {
            return;
        }

        try {
            $last7Days = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));
            $last30Days = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
            $chartDays = $last30Days
                ->sortBy(fn (array $row): int => $row['date']->getTimestamp())
                ->values();
            $dailyDays = $last30Days
                ->sortByDesc(fn (array $row): int => $row['date']->getTimestamp())
                ->values();

            $visitors7d = (int) $last7Days->sum('activeUsers');
            $pageViews7d = (int) $last7Days->sum('screenPageViews');
            $visitors30d = (int) $last30Days->sum('activeUsers');
            $pageViews30d = (int) $last30Days->sum('screenPageViews');

            $this->summary = [
                'visitors7d' => $visitors7d,
                'pageViews7d' => $pageViews7d,
                'visitors30d' => $visitors30d,
                'pageViews30d' => $pageViews30d,
                'pageViewsPerVisitor7d' => $visitors7d > 0 ? $pageViews7d / $visitors7d : 0,
                'pageViewsPerVisitor30d' => $visitors30d > 0 ? $pageViews30d / $visitors30d : 0,
            ];

            $this->dailyTraffic = $dailyDays
                ->map(function (array $row): array {
                    return [
                        'date' => $row['date']->format('Y-m-d'),
                        'date_label' => $row['date']->translatedFormat('d M Y'),
                        'visitors' => (int) $row['activeUsers'],
                        'page_views' => (int) $row['screenPageViews'],
                    ];
                })
                ->values()
                ->all();

            $this->chartLabels = $chartDays
                ->map(fn (array $row): string => $row['date']->format('d/m'))
                ->values()
                ->all();

            $this->chartVisitors = $chartDays
                ->map(fn (array $row): int => (int) $row['activeUsers'])
                ->values()
                ->all();

            $this->chartPageViews = $chartDays
                ->map(fn (array $row): int => (int) $row['screenPageViews'])
                ->values()
                ->all();

            $this->topPages = Analytics::fetchMostVisitedPages(Period::days(30), 20)
                ->map(function (array $row): array {
                    return [
                        'title' => $row['pageTitle'] ?: __('filament.analytics.untitled_page'),
                        'url' => (string) $row['fullPageUrl'],
                        'page_views' => (int) $row['screenPageViews'],
                    ];
                })
                ->values()
                ->all();

            $this->topReferrers = Analytics::fetchTopReferrers(Period::days(30), 20)
                ->filter(fn (array $row): bool => ($row['pageReferrer'] ?? '') !== '')
                ->map(function (array $row): array {
                    return [
                        'referrer' => $row['pageReferrer'],
                        'page_views' => (int) $row['screenPageViews'],
                    ];
                })
                ->values()
                ->all();

            $this->userTypes = Analytics::fetchUserTypes(Period::days(30))
                ->map(function (array $row): array {
                    $type = trim((string) ($row['newVsReturning'] ?? ''));
                    $translationKey = in_array($type, ['new', 'returning'], true)
                        ? $type
                        : 'not_set';

                    return [
                        'type' => __("filament.analytics.user_types.{$translationKey}"),
                        'visitors' => (int) $row['activeUsers'],
                    ];
                })
                ->values()
                ->all();

            $this->topBrowsers = Analytics::fetchTopBrowsers(Period::days(30), 20)
                ->map(function (array $row): array {
                    return [
                        'browser' => $row['browser'],
                        'page_views' => (int) $row['screenPageViews'],
                    ];
                })
                ->values()
                ->all();

            $this->topCountries = Analytics::fetchTopCountries(Period::days(30), 20)
                ->map(function (array $row): array {
                    $country = trim((string) ($row['country'] ?? ''));

                    return [
                        'country' => $country === '' || $country === '(not set)'
                            ? __('filament.analytics.not_set')
                            : $country,
                        'page_views' => (int) $row['screenPageViews'],
                    ];
                })
                ->values()
                ->all();

            $this->topOperatingSystems = Analytics::fetchTopOperatingSystems(Period::days(30), 20)
                ->map(function (array $row): array {
                    return [
                        'operating_system' => $row['operatingSystem'],
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
                'value' => ($this->analyticsSettings['ga4_measurement_id'] ?? '') ?: __('filament.analytics.not_set'),
                'ok' => ($this->analyticsSettings['ga4_measurement_id'] ?? '') !== '',
            ],
            [
                'label' => __('filament.analytics.setup.property_id'),
                'value' => ($this->analyticsSettings['ga4_property_id'] ?? '') ?: __('filament.analytics.not_set'),
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
