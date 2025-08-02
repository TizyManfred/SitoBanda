<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepertoireResource\Pages;
use App\Filament\Resources\RepertoireResource\RelationManagers;
use App\Models\RepertoireYear;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RepertoireResource extends Resource
{
    protected static ?string $model = RepertoireYear::class;

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';
    
    public static function getNavigationGroup(): string
    {
        return __('filament.navigation_groups.content_management');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('filament.resources.repertoire');
    }
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.repertoire_year');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.repertoire_year_plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('year')
                    ->label(__('fields.repertoire.year'))
                    ->required()
                    ->maxLength(4),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('year')
                    ->label(__('fields.repertoire.year'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('display_order')
                    ->label(__('fields.common.display_order'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('fields.common.is_active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('fields.common.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('fields.common.is_active'))
                    ->boolean()
                    ->trueLabel(__('fields.repertoire.active_years'))
                    ->falseLabel(__('fields.repertoire.inactive_years')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProgramsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepertoires::route('/'),
            'create' => Pages\CreateRepertoire::route('/create'),
            'edit' => Pages\EditRepertoire::route('/{record}/edit'),
        ];
    }
}
