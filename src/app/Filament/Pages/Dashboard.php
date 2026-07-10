<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardStatsWidget;
use App\Filament\Widgets\RecentEventsWidget;
use App\Filament\Widgets\RecentGalleryAlbumsWidget;
use App\Filament\Widgets\RecentRepertoireWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getWidgets(): array
    {
        return [
            DashboardStatsWidget::class,
            RecentEventsWidget::class,
            RecentGalleryAlbumsWidget::class,
            RecentRepertoireWidget::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return [
            'default' => 1,
            'lg' => 2,
        ];
    }
}
