<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Filament\Resources\SectionResource\RelationManagers;
use App\Filament\Traits\WithAiTranslation;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Model;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class SectionResource extends Resource
{
    use Translatable;
    use WithAiTranslation;

    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    public static function getModelLabel(): string
    {
        return 'Organico';
    }
    
    public static function getPluralModelLabel(): string
    {
        return 'Organico';
    }
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.content_management');
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function getRecordTitle(?Model $record): string|null
    {
        if (! $record instanceof Section) {
            return null;
        }

        return $record->getDisplayName();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(6)
                    ->schema([
                        TranslatableContainer::make(
                            Forms\Components\TextInput::make('name')
                                ->label(__('fields.section.name'))
                                ->required()
                                ->maxLength(255)
                        )->columnSpan(5),
                        Forms\Components\Actions::make([
                            static::getTranslateAction('name'),
                        ])->columnSpan(1),
                    ]),
                Forms\Components\Select::make('icon_class')
                    ->label(__('fields.section.icon_class'))
                    ->options(static::instrumentIconOptions())
                    ->allowHtml()
                    ->native(false)
                    ->nullable()
                    ->helperText(__('fields.section.icon_helper')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('fields.section.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('icon_class')
                    ->label(__('fields.section.icon'))
                    ->formatStateUsing(function ($state) {
                        if (! $state) {
                            return '';
                        }

                        return '<i class="' . e($state) . '"></i> ' . e($state);
                    })
                    ->html()
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_order')
                    ->label(__('fields.section.display_order'))
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('display_order');
    }

    public static function getNavigationLabel(): string
    {
        return 'Organico';
    }

    public static function getTranslatableAttributes(): array
    {
        return ['name'];
    }

    public static function getTranslatableAttributesForTable(): array
    {
        return ['name'];
    }

    public static function getTranslatableAttributesForForm(): array
    {
        return ['name'];
    }

    protected static function instrumentIconOptions(): array
    {
        $instruments = [
            'clarinet',
            'drum-kit',
            'euphonium',
            'flugelhorn',
            'flute',
            'french-horn',
            'alto-saxophone',
            'baritone-saxophone',
            'timpani',
            'trombone',
            'trumpet',
            'tuba',
        ];

        $options = [];

        foreach ($instruments as $instrument) {
            $class = 'ii ii-' . $instrument;
            $options[$class] = '<i class="' . $class . '"></i> ' . __('fields.section.icons.' . $instrument);
        }

        return $options;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MembersRelationManager::class,
            RelationManagers\SectionImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
