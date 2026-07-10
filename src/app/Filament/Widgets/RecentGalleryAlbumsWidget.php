<?php

namespace App\Filament\Widgets;

use App\Models\GalleryAlbum;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

class RecentGalleryAlbumsWidget extends BaseWidget
{
    protected static ?string $heading = 'Ultimi Album';
    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                GalleryAlbum::query()
                    ->withCount('items')
                    ->latest()
                    ->limit(5)
            )
            ->headerActions([
                Action::make('create')
                    ->label('Nuovo Album')
                    ->icon('heroicon-m-plus')
                    ->color('primary')
                    ->url(fn () => Route::has('filament.admin.resources.gallery-albums.create') ? route('filament.admin.resources.gallery-albums.create') : '#')
            ])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Immagini')
                    ->counts('items'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime(),
            ]);
    }
}
