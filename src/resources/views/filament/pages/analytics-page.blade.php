<x-filament-panels::page>
    @php
        $chartWidth = 1000;
        $chartHeight = 260;
        $chartPlotLeft = 48;
        $chartPlotRight = 990;
        $chartPlotTop = 10;
        $chartPlotBottom = 250;
        $chartPlotWidth = $chartPlotRight - $chartPlotLeft;
        $chartPlotHeight = $chartPlotBottom - $chartPlotTop;
        $chartMaxValue = max(array_merge($chartVisitors, $chartPageViews, [1]));
        $chartStep = max(1, (int) ceil($chartMaxValue / 4));
        $chartMax = $chartStep * 4;
        $chartCount = max(count($chartLabels), 1);
        $visitorsPoints = [];
        $pageViewsPoints = [];
        $chartTicks = [];

        foreach ($chartLabels as $index => $label) {
            $x = $chartCount > 1
                ? $chartPlotLeft + (($index / ($chartCount - 1)) * $chartPlotWidth)
                : $chartPlotLeft + ($chartPlotWidth / 2);
            $visitorsPoints[] = round($x, 2).','.round($chartPlotBottom - (($chartVisitors[$index] ?? 0) / $chartMax * $chartPlotHeight), 2);
            $pageViewsPoints[] = round($x, 2).','.round($chartPlotBottom - (($chartPageViews[$index] ?? 0) / $chartMax * $chartPlotHeight), 2);
        }

        for ($index = 0; $index <= 4; $index++) {
            $chartTicks[] = [
                'value' => $chartMax - ($chartStep * $index),
                'y' => $chartPlotTop + (($chartPlotHeight / 4) * $index),
            ];
        }

        $maxPageViews = max(array_column($topPages, 'page_views') ?: [1]);
        $maxReferrerViews = max(array_column($topReferrers, 'page_views') ?: [1]);
        $maxUserTypeVisitors = max(array_column($userTypes, 'visitors') ?: [1]);
        $maxBrowserViews = max(array_column($topBrowsers, 'page_views') ?: [1]);
        $maxCountryViews = max(array_column($topCountries, 'page_views') ?: [1]);
        $maxOperatingSystemViews = max(array_column($topOperatingSystems, 'page_views') ?: [1]);
        $summaryCards = [
            ['label' => __('filament.analytics.cards.visitors_7d'), 'value' => number_format($summary['visitors7d']), 'icon' => 'users', 'tone' => 'violet'],
            ['label' => __('filament.analytics.cards.pageviews_7d'), 'value' => number_format($summary['pageViews7d']), 'icon' => 'eye', 'tone' => 'sky'],
            ['label' => __('filament.analytics.cards.visitors_30d'), 'value' => number_format($summary['visitors30d']), 'icon' => 'users', 'tone' => 'amber'],
            ['label' => __('filament.analytics.cards.pageviews_30d'), 'value' => number_format($summary['pageViews30d']), 'icon' => 'eye', 'tone' => 'emerald'],
            ['label' => __('filament.analytics.cards.pageviews_per_visitor_7d'), 'value' => number_format($summary['pageViewsPerVisitor7d'], 2), 'icon' => 'ratio', 'tone' => 'rose'],
            ['label' => __('filament.analytics.cards.pageviews_per_visitor_30d'), 'value' => number_format($summary['pageViewsPerVisitor30d'], 2), 'icon' => 'ratio', 'tone' => 'indigo'],
        ];
    @endphp

    <style>
        .analytics-grid { display: grid; gap: 1.25rem; }
        .analytics-kpis { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem; }
        .analytics-card { position: relative; overflow: hidden; border: 1px solid rgb(229 231 235); border-radius: 1rem; background: white; box-shadow: 0 1px 2px rgb(0 0 0 / .04); }
        .analytics-kpi { padding: 1.25rem; }
        .analytics-kpi::after { content: ''; position: absolute; width: 7rem; height: 7rem; right: -3rem; top: -3.5rem; border-radius: 999px; background: var(--accent); opacity: .11; }
        .analytics-kpi-head { display: flex; align-items: center; justify-content: space-between; gap: .75rem; }
        .analytics-kpi-icon { display: grid; place-items: center; width: 2.5rem; height: 2.5rem; border-radius: .75rem; color: var(--accent); background: color-mix(in srgb, var(--accent) 11%, transparent); }
        .analytics-kpi-label { margin-top: 1rem; color: rgb(107 114 128); font-size: .78rem; font-weight: 600; letter-spacing: .045em; text-transform: uppercase; }
        .analytics-kpi-value { margin-top: .3rem; color: rgb(17 24 39); font-size: 2rem; font-weight: 700; line-height: 1; letter-spacing: -.04em; }
        .analytics-section { padding: 1.5rem; }
        .analytics-heading { color: rgb(17 24 39); font-size: 1rem; font-weight: 700; }
        .analytics-subheading { margin-top: .25rem; color: rgb(107 114 128); font-size: .875rem; }
        .analytics-chart-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; }
        .analytics-chart-meta { display: flex; flex-wrap: wrap; align-items: center; justify-content: flex-end; gap: .7rem 1rem; }
        .analytics-unit { padding: .25rem .5rem; border: 1px solid rgb(229 231 235); border-radius: .45rem; color: rgb(107 114 128); font-size: .7rem; font-weight: 700; }
        .analytics-legend { display: flex; flex-wrap: wrap; gap: 1rem; color: rgb(107 114 128); font-size: .78rem; }
        .analytics-legend span { display: flex; align-items: center; gap: .4rem; }
        .analytics-legend i { width: .65rem; height: .65rem; border-radius: 999px; }
        .analytics-chart { margin-top: 1.5rem; height: 18rem; position: relative; }
        .analytics-chart svg { width: 100%; height: 100%; overflow: visible; }
        .analytics-chart-grid line { stroke: rgb(229 231 235); stroke-width: 1; stroke-dasharray: 4 7; }
        .analytics-chart-tick { fill: rgb(107 114 128); font-size: 22px; font-variant-numeric: tabular-nums; }
        .analytics-axis { display: flex; justify-content: space-between; margin-top: .65rem; color: rgb(156 163 175); font-size: .72rem; }
        .analytics-two-col { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.25rem; }
        .analytics-list { margin-top: 1rem; display: grid; gap: .35rem; }
        .analytics-list-scroll { max-height: 35rem; overflow-y: auto; padding-right: .3rem; scrollbar-width: thin; }
        .analytics-row { position: relative; display: grid; grid-template-columns: minmax(0, 1fr) auto; align-items: center; gap: 1rem; min-height: 3.3rem; padding: .65rem .75rem; border-radius: .7rem; overflow: hidden; }
        .analytics-row:hover { background: rgb(249 250 251); }
        .analytics-row-bar { position: absolute; inset: 0 auto 0 0; width: var(--width); background: rgb(99 102 241 / .06); pointer-events: none; }
        .analytics-row-main, .analytics-row-value { position: relative; z-index: 1; min-width: 0; }
        .analytics-row-main, .analytics-row-title, .analytics-row-meta { display: block; }
        .analytics-row-title { overflow: hidden; color: rgb(55 65 81); font-size: .875rem; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }
        .analytics-row-meta { overflow: hidden; margin-top: .18rem; color: rgb(156 163 175); font-size: .75rem; text-overflow: ellipsis; white-space: nowrap; }
        .analytics-row-value { color: rgb(55 65 81); font-size: .875rem; font-weight: 700; font-variant-numeric: tabular-nums; }
        .analytics-row-unit { margin-left: .15rem; color: rgb(156 163 175); font-size: .65rem; font-weight: 600; text-transform: uppercase; }
        .analytics-page-row { border-radius: .7rem; }
        .analytics-page-row summary { cursor: pointer; list-style: none; }
        .analytics-page-row summary::-webkit-details-marker { display: none; }
        .analytics-page-row[open] { background: rgb(249 250 251); }
        .analytics-page-details { position: relative; z-index: 1; display: grid; gap: .35rem; padding: 0 .75rem .8rem; color: rgb(107 114 128); font-size: .78rem; }
        .analytics-page-url { overflow-wrap: anywhere; user-select: all; }
        .analytics-table-wrap { overflow-x: auto; margin-top: 1rem; }
        .analytics-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
        .analytics-table th, .analytics-table td { padding: .7rem .8rem; border-bottom: 1px solid rgb(229 231 235); text-align: left; }
        .analytics-table th { color: rgb(107 114 128); font-size: .72rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
        .analytics-table td { color: rgb(55 65 81); }
        .analytics-table .numeric { text-align: right; font-variant-numeric: tabular-nums; }
        .analytics-empty { padding: 2.5rem 1rem; color: rgb(156 163 175); font-size: .875rem; text-align: center; }
        .analytics-setup-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; }
        .analytics-status { display: inline-flex; align-items: center; gap: .4rem; padding: .35rem .65rem; border-radius: 999px; background: rgb(16 185 129 / .1); color: rgb(5 150 105); font-size: .75rem; font-weight: 700; }
        .analytics-status.warning { background: rgb(245 158 11 / .12); color: rgb(180 83 9); }
        .analytics-status-dot { width: .45rem; height: .45rem; border-radius: 999px; background: currentColor; }
        .analytics-setup-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: .75rem; margin-top: 1.25rem; }
        .analytics-setup-item { padding: .85rem; border: 1px solid rgb(229 231 235); border-radius: .75rem; }
        .analytics-setup-label { color: rgb(107 114 128); font-size: .72rem; font-weight: 600; text-transform: uppercase; }
        .analytics-setup-value { overflow: hidden; margin-top: .3rem; color: rgb(55 65 81); font-size: .8rem; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }
        .analytics-alert { margin-top: 1rem; padding: .8rem 1rem; border-radius: .7rem; background: rgb(245 158 11 / .1); color: rgb(146 64 14); font-size: .82rem; }
        .analytics-alert.error { background: rgb(239 68 68 / .1); color: rgb(185 28 28); }
        @media (max-width: 1024px) { .analytics-kpis, .analytics-setup-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 768px) { .analytics-two-col { grid-template-columns: 1fr; } .analytics-chart-head, .analytics-setup-head { flex-direction: column; } }
        @media (max-width: 540px) { .analytics-kpis, .analytics-setup-grid { grid-template-columns: 1fr; } .analytics-section { padding: 1.1rem; } }
        .dark .analytics-card { border-color: rgb(255 255 255 / .1); background: rgb(17 24 39); }
        .dark .analytics-kpi-value, .dark .analytics-heading { color: white; }
        .dark .analytics-kpi-label, .dark .analytics-subheading, .dark .analytics-legend { color: rgb(156 163 175); }
        .dark .analytics-chart-grid line { stroke: rgb(255 255 255 / .1); }
        .dark .analytics-unit { border-color: rgb(255 255 255 / .1); }
        .dark .analytics-row:hover { background: rgb(255 255 255 / .035); }
        .dark .analytics-page-row[open] { background: rgb(255 255 255 / .035); }
        .dark .analytics-row-bar { background: rgb(129 140 248 / .08); }
        .dark .analytics-row-title, .dark .analytics-row-value, .dark .analytics-setup-value { color: rgb(229 231 235); }
        .dark .analytics-setup-item { border-color: rgb(255 255 255 / .1); }
        .dark .analytics-table th, .dark .analytics-table td { border-color: rgb(255 255 255 / .1); }
        .dark .analytics-table td { color: rgb(229 231 235); }
    </style>

    <div class="analytics-grid">
        <section class="analytics-kpis">
            @foreach ($summaryCards as $card)
                <article class="analytics-card analytics-kpi" style="--accent: {{ match ($card['tone']) { 'sky' => '#0ea5e9', 'amber' => '#f59e0b', 'emerald' => '#10b981', 'rose' => '#f43f5e', 'indigo' => '#6366f1', default => '#8b5cf6' } }}">
                    <div class="analytics-kpi-head">
                        <div class="analytics-kpi-icon">
                            @if ($card['icon'] === 'users')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.1a9.4 9.4 0 0 0 2.3.3 9.4 9.4 0 0 0 3.8-.8 4.3 4.3 0 0 0-7.9-2.6M15 19.1v-.03c0-1.1-.28-2.14-.78-3.04M15 19.1v.1A12.3 12.3 0 0 1 9.5 20.5c-2 0-3.86-.47-5.5-1.3v-.13A5.5 5.5 0 0 1 14.22 16M12 7.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm6.75 2.25a2.75 2.75 0 1 1-5.5 0 2.75 2.75 0 0 1 5.5 0Z"/></svg>
                            @elseif ($card['icon'] === 'eye')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12Z"/><circle cx="12" cy="12" r="2.75"/></svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 18 16 6M7 7h.01M17 17h.01"/><circle cx="7" cy="7" r="2.25"/><circle cx="17" cy="17" r="2.25"/></svg>
                            @endif
                        </div>
                    </div>
                    <p class="analytics-kpi-label">{{ $card['label'] }}</p>
                    <p class="analytics-kpi-value">{{ $card['value'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="analytics-card analytics-section">
            <div class="analytics-chart-head">
                <div>
                    <h2 class="analytics-heading">{{ __('filament.analytics.traffic.title') }}</h2>
                    <p class="analytics-subheading">{{ __('filament.analytics.traffic.description') }}</p>
                </div>
                <div class="analytics-chart-meta">
                    <span class="analytics-unit">{{ __('filament.analytics.traffic.unit') }}</span>
                    <div class="analytics-legend">
                        <span><i style="background:#8b5cf6"></i>{{ __('filament.analytics.columns.visitors') }}</span>
                        <span><i style="background:#0ea5e9"></i>{{ __('filament.analytics.columns.pageviews') }}</span>
                    </div>
                </div>
            </div>

            @if (count($chartLabels))
                <div class="analytics-chart">
                    <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" preserveAspectRatio="none" role="img" aria-label="{{ __('filament.analytics.traffic.description') }}">
                        <g class="analytics-chart-grid">
                            @foreach ($chartTicks as $tick)
                                <line x1="{{ $chartPlotLeft }}" y1="{{ $tick['y'] }}" x2="{{ $chartPlotRight }}" y2="{{ $tick['y'] }}"/>
                                <text class="analytics-chart-tick" x="0" y="{{ $tick['y'] + 7 }}">{{ number_format($tick['value']) }}</text>
                            @endforeach
                        </g>
                        <polyline points="{{ implode(' ', $pageViewsPoints) }}" fill="none" stroke="#0ea5e9" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"/>
                        <polyline points="{{ implode(' ', $visitorsPoints) }}" fill="none" stroke="#8b5cf6" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"/>
                    </svg>
                </div>
                <div class="analytics-axis">
                    <span>{{ $chartLabels[0] }}</span>
                    @if (count($chartLabels) > 2)<span>{{ $chartLabels[(int) floor((count($chartLabels) - 1) / 2)] }}</span>@endif
                    @if (count($chartLabels) > 1)<span>{{ $chartLabels[count($chartLabels) - 1] }}</span>@endif
                </div>
            @else
                <div class="analytics-empty">{{ __('filament.analytics.messages.no_data') }}</div>
            @endif
        </section>

        <section class="analytics-card analytics-section">
            <h2 class="analytics-heading">{{ __('filament.analytics.daily.title') }}</h2>
            <p class="analytics-subheading">{{ __('filament.analytics.daily.description') }}</p>
            @if (count($dailyTraffic))
                <div class="analytics-table-wrap">
                    <table class="analytics-table">
                        <thead>
                            <tr>
                                <th>{{ __('filament.analytics.columns.date') }}</th>
                                <th class="numeric">{{ __('filament.analytics.columns.visitors') }}</th>
                                <th class="numeric">{{ __('filament.analytics.columns.pageviews') }}</th>
                                <th class="numeric">{{ __('filament.analytics.columns.pageviews_per_visitor') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dailyTraffic as $day)
                                <tr>
                                    <td><time datetime="{{ $day['date'] }}">{{ $day['date_label'] }}</time></td>
                                    <td class="numeric">{{ number_format($day['visitors']) }}</td>
                                    <td class="numeric">{{ number_format($day['page_views']) }}</td>
                                    <td class="numeric">{{ number_format($day['visitors'] > 0 ? $day['page_views'] / $day['visitors'] : 0, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="analytics-empty">{{ __('filament.analytics.messages.no_data') }}</div>
            @endif
        </section>

        <section class="analytics-two-col">
            <article class="analytics-card analytics-section">
                <h2 class="analytics-heading">{{ __('filament.analytics.tables.top_pages') }}</h2>
                <p class="analytics-subheading">{{ __('filament.analytics.tables.top_pages_hint') }}</p>
                <div class="analytics-list {{ count($topPages) > 10 ? 'analytics-list-scroll' : '' }}">
                    @forelse ($topPages as $page)
                        <details class="analytics-page-row">
                            <summary class="analytics-row" style="--width: {{ round(($page['page_views'] / $maxPageViews) * 100) }}%">
                                <span class="analytics-row-bar"></span>
                                <span class="analytics-row-main"><span class="analytics-row-title">{{ $page['title'] }}</span><span class="analytics-row-meta">{{ $page['url'] }}</span></span>
                                <span class="analytics-row-value">{{ number_format($page['page_views']) }} <small class="analytics-row-unit">{{ __('filament.analytics.abbreviations.pageviews') }}</small></span>
                            </summary>
                            <div class="analytics-page-details">
                                <strong>{{ __('filament.analytics.columns.recorded_url') }}</strong>
                                <span class="analytics-page-url">{{ $page['url'] }}</span>
                            </div>
                        </details>
                    @empty
                        <div class="analytics-empty">{{ __('filament.analytics.messages.no_data') }}</div>
                    @endforelse
                </div>
            </article>

            @foreach ([
                ['title' => __('filament.analytics.tables.top_referrers'), 'hint' => __('filament.analytics.tables.top_referrers_hint'), 'items' => $topReferrers, 'label' => 'referrer', 'metric' => 'page_views', 'unit' => __('filament.analytics.abbreviations.pageviews'), 'max' => $maxReferrerViews],
                ['title' => __('filament.analytics.tables.user_types'), 'hint' => __('filament.analytics.tables.user_types_hint'), 'items' => $userTypes, 'label' => 'type', 'metric' => 'visitors', 'unit' => __('filament.analytics.abbreviations.visitors'), 'max' => $maxUserTypeVisitors],
                ['title' => __('filament.analytics.tables.top_browsers'), 'hint' => __('filament.analytics.tables.pageviews_hint'), 'items' => $topBrowsers, 'label' => 'browser', 'metric' => 'page_views', 'unit' => __('filament.analytics.abbreviations.pageviews'), 'max' => $maxBrowserViews],
                ['title' => __('filament.analytics.tables.top_countries'), 'hint' => __('filament.analytics.tables.pageviews_hint'), 'items' => $topCountries, 'label' => 'country', 'metric' => 'page_views', 'unit' => __('filament.analytics.abbreviations.pageviews'), 'max' => $maxCountryViews],
                ['title' => __('filament.analytics.tables.top_operating_systems'), 'hint' => __('filament.analytics.tables.pageviews_hint'), 'items' => $topOperatingSystems, 'label' => 'operating_system', 'metric' => 'page_views', 'unit' => __('filament.analytics.abbreviations.pageviews'), 'max' => $maxOperatingSystemViews],
            ] as $ranking)
                <article class="analytics-card analytics-section">
                    <h2 class="analytics-heading">{{ $ranking['title'] }}</h2>
                    <p class="analytics-subheading">{{ $ranking['hint'] }}</p>
                    <div class="analytics-list {{ count($ranking['items']) > 10 ? 'analytics-list-scroll' : '' }}">
                        @forelse ($ranking['items'] as $item)
                            <div class="analytics-row" title="{{ $item[$ranking['label']] }}" style="--width: {{ round(($item[$ranking['metric']] / $ranking['max']) * 100) }}%">
                                <span class="analytics-row-bar"></span>
                                <span class="analytics-row-main"><span class="analytics-row-title">{{ $item[$ranking['label']] }}</span></span>
                                <span class="analytics-row-value">{{ number_format($item[$ranking['metric']]) }} <small class="analytics-row-unit">{{ $ranking['unit'] }}</small></span>
                            </div>
                        @empty
                            <div class="analytics-empty">{{ __('filament.analytics.messages.no_data') }}</div>
                        @endforelse
                    </div>
                </article>
            @endforeach
        </section>

        <section class="analytics-card analytics-section">
            <div class="analytics-setup-head">
                <div>
                    <h2 class="analytics-heading">{{ __('filament.analytics.setup.title') }}</h2>
                    <p class="analytics-subheading">{{ __('filament.analytics.setup.description') }}</p>
                </div>
                <span class="analytics-status {{ $this->hasAnalyticsConfiguration() ? '' : 'warning' }}">
                    <i class="analytics-status-dot"></i>{{ $this->hasAnalyticsConfiguration() ? 'GA4' : __('filament.analytics.not_set') }}
                </span>
            </div>
            <div class="analytics-setup-grid">
                @foreach ($this->getSetupItems() as $item)
                    <div class="analytics-setup-item" title="{{ $item['value'] }}">
                        <p class="analytics-setup-label">{{ $item['label'] }}</p>
                        <p class="analytics-setup-value">{{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>
            @if (! $this->hasAnalyticsConfiguration())
                <div class="analytics-alert">{{ __('filament.analytics.messages.missing_configuration') }}</div>
            @endif
            @if ($analyticsError)
                <div class="analytics-alert error"><strong>{{ __('filament.analytics.messages.fetch_error') }}</strong><br>{{ $analyticsError }}</div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
