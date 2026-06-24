<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepertoireProgramResource\Pages;
use App\Filament\Traits\WithAiTranslation;
use App\Models\RepertoireProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class RepertoireProgramResource extends Resource
{
    use Translatable;
    use WithAiTranslation;

    protected static ?string $model = RepertoireProgram::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-musical-note';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $navigationLabel = 'Repertorio';
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.content_management');
    }
    protected static ?string $modelLabel = 'Programma';
    
    protected static ?string $pluralModelLabel = 'Repertorio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(6)
                    ->schema([
                        TranslatableContainer::make(
                            Forms\Components\TextInput::make('name')
                                ->label(__('fields.repertoire_program.name'))
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Estate, Natale, Blasmusik...')
                        )->columnSpan(5),
                        Forms\Components\Actions::make([
                            static::getTranslateAction('name'),
                        ])->columnSpan(1),
                    ]),
                    
                Forms\Components\TextInput::make('year')
                    ->label(__('fields.repertoire_program.year'))
                    ->required()
                    ->integer()
                    ->default(date('Y')),
                    
                
                Forms\Components\Toggle::make('is_published')
                    ->label(__('fields.repertoire_program.is_published'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('fields.repertoire_program.name'))
                    ->searchable(),
                    
                Tables\Columns\IconColumn::make('is_published')
                    ->label(__('fields.repertoire_program.is_published'))
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('pieces_count')
                    ->label(__('fields.repertoire_program.pieces_count'))
                    ->counts('pieces'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('fields.common.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('year', 'desc')
            ->reorderable('display_order')
            ->groups(['year'])
            ->defaultGroup('year')
            ->filters([
                    
                Tables\Filters\SelectFilter::make('year')
                    ->label(__('fields.repertoire_program.year'))
                    ->options(function () {
                        return RepertoireProgram::distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray();
                    }),
                    
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label(__('fields.repertoire_program.is_published')),
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
            RelationManagers\RepertoirePiecesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepertoirePrograms::route('/'),
            'create' => Pages\CreateRepertoireProgram::route('/create'),
            'edit' => Pages\EditRepertoireProgram::route('/{record}/edit'),
        ];
    }

    public static function getTranslatableAttributes(): array
    {
        return ['name'];
    }
}
