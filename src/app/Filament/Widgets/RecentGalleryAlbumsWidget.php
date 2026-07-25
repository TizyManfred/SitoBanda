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
    protected static ?string $heading = null;
    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('filament.dashboard.recent_albums_title'))
            ->query(
                GalleryAlbum::query()
                    ->withCount('items')
                    ->latest()
                    ->limit(5)
            )
            ->headerActions([
                Action::make('create')
                    ->label(__('filament.dashboard.new_album'))
                    ->icon('heroicon-m-plus')
                    ->color('primary')
                    ->url(fn () => Route::has('filament.admin.resources.gallery-albums.create') ? route('filament.admin.resources.gallery-albums.create') : '#')
            ])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament.dashboard.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label(__('filament.dashboard.images'))
                    ->counts('items'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.dashboard.created_at'))
                    ->dateTime(),
            ]);
    }
}
