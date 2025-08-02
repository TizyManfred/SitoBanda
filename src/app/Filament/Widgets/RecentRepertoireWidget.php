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
    protected static ?string $heading = 'Ultimi Pezzi Aggiunti al Repertorio';
    protected int|string|array $columnSpan = 2;
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                RepertoirePiece::query()
                    ->with('program')
                    ->latest()
                    ->limit(5)
            )
            ->headerActions([
                Action::make('create')
                    ->label('Nuovo Pezzo')
                    ->icon('heroicon-m-plus')
                    ->color('warning')
                    ->url(fn () => Route::has('filament.admin.resources.repertoire-pieces.create') ? route('filament.admin.resources.repertoire-pieces.create') : '#'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('composer')
                    ->label('Compositore'),
                Tables\Columns\TextColumn::make('program.title')
                    ->label('Programma'),
            ]);
    }
}
