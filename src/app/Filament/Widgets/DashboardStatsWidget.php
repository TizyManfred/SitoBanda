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
            StatWidget::make('Totale Eventi', Event::count())
                ->description('Eventi in programma: ' . Event::upcoming()->count())
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),
                
            StatWidget::make('Album Fotografici', GalleryAlbum::count())
                ->description('Immagini totali: ' . GalleryItem::count())
                ->descriptionIcon('heroicon-m-photo')
                ->color('primary'),
                
            StatWidget::make('Pezzi nel Repertorio', RepertoirePiece::count())
                ->description('Programmi: ' . RepertoireProgram::count())
                ->descriptionIcon('heroicon-m-musical-note')
                ->color('warning'),
                
            StatWidget::make('Membri della Banda', Member::count())
                ->description('Sezioni: ' . Section::count())
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }
}
