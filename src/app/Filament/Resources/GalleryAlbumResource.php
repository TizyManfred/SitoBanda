<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryAlbumResource\Pages;
use App\Filament\Resources\GalleryAlbumResource\RelationManagers;
use App\Models\GalleryAlbum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Tables\Filters\TrashedFilter;
use Filament\SpatieLaravelTranslatablePlugin;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class GalleryAlbumResource extends Resource
{
    protected static ?string $model = GalleryAlbum::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(4)
            ->schema([
                TranslatableContainer::make(
                    Forms\Components\TextInput::make('title')
                        ->label(__('fields.gallery.title'))
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true),
                    )
                    ->columnSpan(2),
                Forms\Components\DatePicker::make('start_date')
                    ->label(__('fields.gallery.start_date'))
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->columnSpan(1),
                Forms\Components\DatePicker::make('end_date')
                    ->label(__('fields.gallery.end_date'))
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->after('start_date')
                    ->columnSpan(1),
                TranslatableContainer::make(
                    Forms\Components\Textarea::make('description')
                        ->label(__('fields.gallery.description'))
                )->columnSpanFull(),
                Forms\Components\TextInput::make('year')
                    ->label(__('fields.gallery.year'))
                    ->required()
                    ->numeric()
                    ->default(fn () => now()->year),
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
            ]);
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
                Tables\Columns\TextColumn::make('year')
                    ->label(__('fields.gallery.year'))
                    ->numeric()
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
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
