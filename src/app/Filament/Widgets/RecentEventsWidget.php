<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

class RecentEventsWidget extends BaseWidget
{
    protected static ?string $heading = null;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('filament.dashboard.upcoming_events_title'))
            ->query(
                Event::query()
                    ->upcoming()
                    ->orderBy('start_datetime')
                    ->limit(5)
            )
            ->headerActions([
                Action::make('create')
                    ->label(__('filament.dashboard.new_event'))
                    ->icon('heroicon-m-plus')
                    ->color('primary')
                    ->url(fn () => Route::has('filament.admin.resources.events.create') ? route('filament.admin.resources.events.create') : '#'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('start_datetime')
                    ->label(__('filament.dashboard.date'))
                    ->dateTime(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament.dashboard.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label(__('filament.dashboard.location')),
            ]);
    }
}
