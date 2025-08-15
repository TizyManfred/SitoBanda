<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryItemResource\Pages;
use App\Models\GalleryItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;
    protected static ?string $navigationIcon = null; // Hidden from navigation menu
    protected static ?int $navigationSort = 2;
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.gallery_item');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.gallery_item_plural');
    }
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.content_management');
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return false; // This completely hides the resource from navigation
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('images')
                            ->label(__('fields.gallery.images'))
                            ->multiple()
                            ->directory('gallery-items')
                            ->preserveFilenames()
                            ->image()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->imagePreviewHeight('250')
                            ->required()
                            ->columnSpanFull()
                            ->helperText(__('fields.gallery.images_helper'))
                            ->reorderable()
                            ->appendFiles()
                            ->downloadable()
                            ->openable()
                            ->previewable(true)
                            ->imageEditorViewportWidth('1920')
                            ->imageEditorViewportHeight('1080')
                            ->optimize('webp'),

                        Forms\Components\TextInput::make('title')
                            ->label(__('fields.gallery.title'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label(__('fields.gallery.description'))
                            ->helperText(__('fields.gallery.description_helper'))
                            ->maxLength(65535)
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('taken_at')
                            ->label(__('fields.gallery.date_taken'))
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Forms\Components\Toggle::make('is_visible')
                            ->label(__('fields.gallery.visible'))
                            ->default(true),

                        Forms\Components\Toggle::make('is_featured')
                            ->label(__('fields.gallery.featured'))
                            ->helperText(__('fields.gallery.featured_helper')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label(__('fields.gallery.image'))
                    ->size(80)
                    ->square()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label(__('fields.gallery.visible'))
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label(__('fields.gallery.featured'))
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('taken_at')
                    ->label(__('fields.gallery.date_taken'))
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_visible')
                    ->label(__('fields.gallery.only_visible'))
                    ->query(fn ($query) => $query->where('is_visible', true)),
                
                Tables\Filters\Filter::make('is_featured')
                    ->label(__('fields.gallery.only_featured'))
                    ->query(fn ($query) => $query->where('is_featured', true)),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryItems::route('/'),
            'create' => Pages\CreateGalleryItem::route('/create'),
            'edit' => Pages\EditGalleryItem::route('/{record}/edit'),
        ];
    }
}
