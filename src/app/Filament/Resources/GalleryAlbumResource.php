<?php

namespace App\Filament\Resources;

use App\Filament\Actions\TranslateAllAction;
use App\Filament\Actions\TranslateBulkAction;
use App\Filament\Resources\GalleryAlbumResource\Pages;
use App\Filament\Resources\GalleryAlbumResource\RelationManagers;
use App\Filament\Traits\WithAiTranslation;
use App\Models\GalleryAlbum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class GalleryAlbumResource extends Resource
{
    use Translatable;
    use WithAiTranslation;

    protected static ?string $model = GalleryAlbum::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getRecordTitle(?Model $record): ?string
    {
        if (! $record instanceof GalleryAlbum) {
            return null;
        }

        $locale = app()->getLocale();
        $fallbackLocale = config('app.fallback_locale');

        return $record->getTranslation('title', $locale, false)
            ?: $record->getTranslation('title', $fallbackLocale, false)
            ?: collect($record->getTranslations('title'))->filter()->first()
            ?: null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make(6)
                            ->schema([
                                TranslatableContainer::make(
                                    Forms\Components\TextInput::make('title')
                                        ->label(__('fields.gallery.title'))
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->columnSpanFull(),
                                )->columnSpan(5),
                                Forms\Components\Actions::make([
                                    static::getTranslateAction('title'),
                                ])->columnSpan(1),
                            ]),
                        Forms\Components\Grid::make(6)
                            ->schema([
                                TranslatableContainer::make(
                                    Forms\Components\RichEditor::make('description')
                                        ->label(__('fields.gallery.description'))
                                        ->columnSpanFull()
                                )->columnSpan(5),
                                Forms\Components\Actions::make([
                                    static::getTranslateAction('description'),
                                ])->columnSpan(1),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label(__('fields.gallery.start_date'))
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->closeOnDateSelection(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label(__('fields.gallery.end_date'))
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->closeOnDateSelection()
                            ->after('start_date'),
                        Forms\Components\TextInput::make('view_count')
                            ->label(__('fields.gallery.view_count'))
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\Toggle::make('is_published')
                            ->label(__('fields.gallery.is_published'))
                            ->default(true)
                            ->required(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image_path')
                    ->label(__('fields.gallery.cover_image'))
                    ->getStateUsing(function ($record) {
                        // Use first image from album items as cover if available
                        if ($record->items()->count() > 0) {
                            return $record->items()->first()->image_path;
                        }

                        return $record->cover_image_path;
                    })
                    ->width(100)
                    ->height(60),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('fields.gallery.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('fields.gallery.start_date'))
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('fields.gallery.end_date'))
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label(__('fields.gallery.is_published'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('view_count')
                    ->label(__('fields.gallery.view_count'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('fields.common.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    TranslateBulkAction::make()
                        ->translatableFields(['title', 'description']),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                TranslateAllAction::make()
                    ->modelClass(GalleryAlbum::class)
                    ->translatableFields(['title', 'description']),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.gallery_album');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.gallery_album_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.content_management');
    }

    public static function getTranslatableAttributes(): array
    {
        return ['title', 'description'];
    }

    public static function getTranslatableAttributesForTable(): array
    {
        return ['title'];
    }

    public static function getTranslatableAttributesForForm(): array
    {
        return ['title', 'description'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryAlbums::route('/'),
            'create' => Pages\CreateGalleryAlbum::route('/create'),
            'edit' => Pages\EditGalleryAlbum::route('/{record}/edit'),
        ];
    }
}
