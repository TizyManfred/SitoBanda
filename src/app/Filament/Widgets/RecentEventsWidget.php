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
    protected static ?string $heading = 'Prossimi Eventi';
    protected int|string|array $columnSpan = 'full';
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Event::query()
                    ->upcoming()
                    ->orderBy('start_datetime')
                    ->limit(5)
            )
            ->headerActions([
                Action::make('create')
                    ->label('Nuovo Evento')
                    ->icon('heroicon-m-plus')
                    ->color('primary')
                    ->url(fn () => Route::has('filament.admin.resources.events.create') ? route('filament.admin.resources.events.create') : '#'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('start_datetime')
                    ->label('Data')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Luogo'),
            ]);
    }
}
