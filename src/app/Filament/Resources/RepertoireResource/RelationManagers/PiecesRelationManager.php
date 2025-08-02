<?php

namespace App\Filament\Resources\RepertoireResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PiecesRelationManager extends RelationManager
{
    protected static string $relationship = 'pieces';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('fields.repertoire.title'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('composer')
                    ->label(__('fields.repertoire.composer'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('arranger')
                    ->label(__('fields.repertoire.arranger'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('genre')
                    ->label(__('fields.repertoire.genre'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('duration')
                    ->label(__('fields.repertoire.duration'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('display_order')
                    ->label(__('fields.common.display_order'))
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('description')
                    ->label(__('fields.repertoire.description'))
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('fields.common.is_active'))
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('fields.repertoire.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('composer')
                    ->label(__('fields.repertoire.composer'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('arranger')
                    ->label(__('fields.repertoire.arranger'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_order')
                    ->label(__('fields.common.display_order'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('fields.common.is_active'))
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
