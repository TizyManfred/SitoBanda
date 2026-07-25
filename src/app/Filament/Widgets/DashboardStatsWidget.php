<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use App\Models\Member;
use App\Models\RepertoirePiece;
use App\Models\RepertoireProgram;
use App\Models\Section;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat as StatWidget;

class DashboardStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        return [
            StatWidget::make(__('filament.dashboard.total_events'), Event::count())
                ->description(__('filament.dashboard.upcoming_events', ['count' => Event::upcoming()->count()]))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),
                
            StatWidget::make(__('filament.dashboard.photo_albums'), GalleryAlbum::count())
                ->description(__('filament.dashboard.total_images', ['count' => GalleryItem::count()]))
                ->descriptionIcon('heroicon-m-photo')
                ->color('primary'),
                
            StatWidget::make(__('filament.dashboard.repertoire_pieces'), RepertoirePiece::count())
                ->description(__('filament.dashboard.programs', ['count' => RepertoireProgram::count()]))
                ->descriptionIcon('heroicon-m-musical-note')
                ->color('warning'),
                
            StatWidget::make(__('filament.dashboard.band_members'), Member::count())
                ->description(__('filament.dashboard.sections', ['count' => Section::count()]))
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }
}
