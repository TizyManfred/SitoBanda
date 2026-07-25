<?php

namespace App\Filament\Widgets;

use App\Models\RepertoirePiece;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

class RecentRepertoireWidget extends BaseWidget
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
            ->heading(__('filament.dashboard.recent_pieces_title'))
            ->query(
                RepertoirePiece::query()
                    ->with('program')
                    ->latest()
                    ->limit(5)
            )
            ->headerActions([
                Action::make('create')
                    ->label(__('filament.dashboard.new_piece'))
                    ->icon('heroicon-m-plus')
                    ->color('warning')
                    ->url(fn () => Route::has('filament.admin.resources.repertoire-pieces.create') ? route('filament.admin.resources.repertoire-pieces.create') : '#'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament.dashboard.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('composer')
                    ->label(__('filament.dashboard.composer')),
                Tables\Columns\TextColumn::make('program.title')
                    ->label(__('filament.dashboard.program')),
            ]);
    }
}
