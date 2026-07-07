<x-filament-panels::page>
    <div class="space-y-6">
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('filament.analytics.cards.visitors_7d') }}</p>
                <p class="mt-2 text-3xl font-semibold text-gray-950 dark:text-white">{{ number_format($summary['visitors7d']) }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('filament.analytics.cards.pageviews_7d') }}</p>
                <p class="mt-2 text-3xl font-semibold text-gray-950 dark:text-white">{{ number_format($summary['pageViews7d']) }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('filament.analytics.cards.visitors_30d') }}</p>
                <p class="mt-2 text-3xl font-semibold text-gray-950 dark:text-white">{{ number_format($summary['visitors30d']) }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('filament.analytics.cards.pageviews_30d') }}</p>
                <p class="mt-2 text-3xl font-semibold text-gray-950 dark:text-white">{{ number_format($summary['pageViews30d']) }}</p>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
            <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-950 dark:text-white">{{ __('filament.analytics.setup.title') }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('filament.analytics.setup.description') }}</p>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('filament.analytics.setup.credentials_hint') }}:
                    <code class="rounded bg-gray-100 px-2 py-1 text-xs dark:bg-white/10">{{ $credentialsPath }}</code>
                </div>
            </div>

            <div class="mt-4 grid gap-3 md:grid-cols-2">
                @foreach ($this->getSetupItems() as $item)
                    <div class="rounded-lg border px-4 py-3 {{ $item['ok'] ? 'border-green-200 bg-green-50 dark:border-green-500/30 dark:bg-green-500/10' : 'border-amber-200 bg-amber-50 dark:border-amber-500/30 dark:bg-amber-500/10' }}">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $item['label'] }}</p>
                        <p class="mt-1 break-all text-sm text-gray-600 dark:text-gray-300">{{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>

            @if (! $this->hasAnalyticsConfiguration())
                <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-100">
                    {{ __('filament.analytics.messages.missing_configuration') }}
                </div>
            @endif

            @if ($analyticsError)
                <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-100">
                    <p class="font-medium">{{ __('filament.analytics.messages.fetch_error') }}</p>
                    <p class="mt-1 break-all">{{ $analyticsError }}</p>
                </div>
            @endif
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
            <h2 class="text-lg font-semibold text-gray-950 dark:text-white">{{ __('filament.analytics.traffic.title') }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('filament.analytics.traffic.description') }}</p>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-white/10">
                    <thead>
                        <tr class="text-left text-gray-500 dark:text-gray-400">
                            <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.date') }}</th>
                            <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.visitors') }}</th>
                            <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.pageviews') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse ($chartLabels as $index => $label)
                            <tr>
                                <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ $label }}</td>
                                <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ number_format($chartVisitors[$index] ?? 0) }}</td>
                                <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ number_format($chartPageViews[$index] ?? 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-gray-500 dark:text-gray-400">{{ __('filament.analytics.messages.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <h2 class="text-lg font-semibold text-gray-950 dark:text-white">{{ __('filament.analytics.tables.top_pages') }}</h2>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-white/10">
                        <thead>
                            <tr class="text-left text-gray-500 dark:text-gray-400">
                                <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.page') }}</th>
                                <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.url') }}</th>
                                <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.pageviews') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                            @forelse ($topPages as $page)
                                <tr>
                                    <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ $page['title'] }}</td>
                                    <td class="py-2 pr-4 text-gray-500 dark:text-gray-400">
                                        <a href="{{ $page['url'] }}" target="_blank" rel="noreferrer" class="hover:underline">{{ $page['url'] }}</a>
                                    </td>
                                    <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ number_format($page['page_views']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-gray-500 dark:text-gray-400">{{ __('filament.analytics.messages.no_data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <h2 class="text-lg font-semibold text-gray-950 dark:text-white">{{ __('filament.analytics.tables.top_referrers') }}</h2>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-white/10">
                        <thead>
                            <tr class="text-left text-gray-500 dark:text-gray-400">
                                <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.referrer') }}</th>
                                <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.pageviews') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                            @forelse ($topReferrers as $referrer)
                                <tr>
                                    <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ $referrer['referrer'] }}</td>
                                    <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ number_format($referrer['page_views']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-4 text-gray-500 dark:text-gray-400">{{ __('filament.analytics.messages.no_data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <h2 class="text-lg font-semibold text-gray-950 dark:text-white">{{ __('filament.analytics.tables.top_browsers') }}</h2>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-white/10">
                        <thead>
                            <tr class="text-left text-gray-500 dark:text-gray-400">
                                <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.browser') }}</th>
                                <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.pageviews') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                            @forelse ($topBrowsers as $browser)
                                <tr>
                                    <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ $browser['browser'] }}</td>
                                    <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ number_format($browser['page_views']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-4 text-gray-500 dark:text-gray-400">{{ __('filament.analytics.messages.no_data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <h2 class="text-lg font-semibold text-gray-950 dark:text-white">{{ __('filament.analytics.tables.top_countries') }}</h2>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-white/10">
                        <thead>
                            <tr class="text-left text-gray-500 dark:text-gray-400">
                                <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.country') }}</th>
                                <th class="py-2 pr-4 font-medium">{{ __('filament.analytics.columns.pageviews') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                            @forelse ($topCountries as $country)
                                <tr>
                                    <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ $country['country'] }}</td>
                                    <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">{{ number_format($country['page_views']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-4 text-gray-500 dark:text-gray-400">{{ __('filament.analytics.messages.no_data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</x-filament-panels::page>
