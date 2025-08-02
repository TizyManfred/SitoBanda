<?php

namespace App\Filament\Resources\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RepertoirePiecesRelationManager extends RelationManager
{
    protected static string $relationship = 'pieces';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('fields.repertoire_piece.relation_title');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('fields.repertoire_piece.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('composer')
                    ->label(__('fields.repertoire_piece.composer'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('arranger')
                    ->label(__('fields.repertoire_piece.arranger'))
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('fields.repertoire_piece.title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('composer')
                    ->label(__('fields.repertoire_piece.composer'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('arranger')
                    ->label(__('fields.repertoire_piece.arranger'))
                    ->searchable(),
            ])
            ->defaultSort('display_order')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data, $livewire): array {
                        // Get the maximum display_order value and add 1
                        $maxOrder = $livewire->getOwnerRecord()->pieces()->max('display_order') ?? -1;
                        $data['display_order'] = $maxOrder + 1;
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('display_order')
            ->defaultSort('display_order');
    }
}
