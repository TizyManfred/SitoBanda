<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryItemResource\Pages;
use App\Filament\Support\OptimizedImageUpload;
use App\Filament\Traits\WithAiTranslation;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class GalleryItemResource extends Resource
{
    use WithAiTranslation;

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
                        Forms\Components\Select::make('album_id')
                            ->label(__('filament.resources.gallery_album'))
                            ->options(fn (): array => GalleryAlbum::query()
                                ->orderByDesc('start_date')
                                ->get()
                                ->mapWithKeys(fn (GalleryAlbum $album): array => [
                                    $album->id => $album->getTranslation('title', App::getLocale(), false)
                                        ?: collect($album->getTranslations('title'))->filter()->first()
                                        ?: (string) $album->id,
                                ])
                                ->all())
                            ->searchable()
                            ->required(),

                        Forms\Components\FileUpload::make('image_path')
                            ->label(__('fields.gallery.image'))
                            ->directory('gallery-items')
                            ->image()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->imagePreviewHeight('250')
                            ->required()
                            ->columnSpanFull()
                            ->helperText(__('fields.gallery.upload_image_helper'))
                            ->downloadable()
                            ->openable()
                            ->previewable(true)
                            ->imageEditorViewportWidth('1920')
                            ->imageEditorViewportHeight('1080')
                            ->saveUploadedFileUsing(OptimizedImageUpload::webp('gallery-items', quality: 65, maxWidth: 1920, maxHeight: 1080)),

                        Forms\Components\Grid::make(6)
                            ->schema([
                                TranslatableContainer::make(
                                    Forms\Components\TextInput::make('caption')
                                        ->label(__('fields.gallery.caption'))
                                        ->reactive()
                                )->columnSpan(5),
                                Forms\Components\Actions::make([
                                    static::getTranslateAction('caption'),
                                ])->columnSpan(1),
                            ])
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('taken_at')
                            ->label(__('fields.gallery.date_taken'))
                            ->native(false)
                            ->displayFormat('d/m/Y'),

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

                Tables\Columns\TextColumn::make('album.title')
                    ->label(__('filament.resources.gallery_album'))
                    ->formatStateUsing(fn (GalleryItem $record): string => $record->album?->getTranslation('title', App::getLocale(), false)
                        ?: collect($record->album?->getTranslations('title') ?? [])->filter()->first()
                        ?: '-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('caption')
                    ->label(__('fields.gallery.caption'))
                    ->formatStateUsing(function (GalleryItem $record): string {
                        $translations = $record->getTranslations('caption');

                        return collect($translations)
                            ->filter(fn ($translation): bool => filled($translation))
                            ->map(fn ($translation, string $locale): string => "<div><span class='font-medium'>{$locale}:</span> " . e($translation) . '</div>')
                            ->implode('');
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function (Builder $query) use ($search): void {
                            foreach (array_keys(LaravelLocalization::getLocalesOrder()) as $locale) {
                                $query->orWhere("caption->{$locale}", 'like', "%{$search}%");
                            }
                        });
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('caption->' . App::getLocale(), $direction);
                    })
                    ->wrap()
                    ->html(),

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
