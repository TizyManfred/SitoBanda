<?php

namespace App\Filament\Resources\SectionResource\RelationManagers;

use App\Filament\Support\OptimizedImageUpload;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SectionImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';
    
    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('fields.gallery.images');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->uploadImageFormSchema());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('resolved_image_path')
            ->columns([
                Tables\Columns\ImageColumn::make('resolved_image_path')
                    ->label(__('fields.common.image'))
                    ->square(),
                Tables\Columns\TextColumn::make('galleryItem.album.title')
                    ->label(__('fields.section.gallery_item'))
                    ->formatStateUsing(fn ($state, $record): string => $record->galleryItem
                        ? static::formatGalleryItemTableLabel($record->galleryItem)
                        : __('fields.section.uploaded_image'))
                    ->wrap(),
                Tables\Columns\TextColumn::make('caption')
                    ->label(__('fields.gallery.caption'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_order')
                    ->label(__('fields.section.display_order'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\CreateAction::make('uploadImage')
                        ->label(__('fields.section.upload_image'))
                        ->icon('heroicon-o-arrow-up-tray')
                        ->modalHeading(__('fields.section.upload_image'))
                        ->form($this->uploadImageFormSchema())
                        ->mutateFormDataUsing(function (array $data): array {
                            $data['gallery_item_id'] = null;

                            return $data;
                        }),
                    Tables\Actions\CreateAction::make('selectFromGallery')
                        ->label(__('fields.section.select_from_gallery'))
                        ->icon('heroicon-o-photo')
                        ->modalHeading(__('fields.section.select_from_gallery'))
                        ->form($this->galleryImageFormSchema())
                        ->mutateFormDataUsing(function (array $data): array {
                            $data['image_path'] = null;

                            return $data;
                        }),
                ])
                    ->label(__('fields.ui.create'))
                    ->icon('heroicon-o-plus')
                    ->button(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('fields.ui.edit'))
                    ->form(fn ($record): array => $record->gallery_item_id
                        ? $this->galleryImageFormSchema()
                        : $this->uploadImageFormSchema()),
                Tables\Actions\DeleteAction::make()
                    ->label(__('fields.ui.delete')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('fields.common.delete_selected')),
                ]),
            ])
            ->reorderable('display_order');
    }

    protected function uploadImageFormSchema(): array
    {
        return [
            Forms\Components\FileUpload::make('image_path')
                ->label(__('fields.common.image'))
                ->image()
                ->directory('section-images')
                ->required()
                ->downloadable()
                ->openable()
                ->previewable(true)
                ->imageEditor()
                ->imageResizeMode('cover')
                ->imageEditorAspectRatios([
                    null,
                    '1:1',
                    '4:3',
                    '16:9',
                    '21:9',
                    '3:4',
                    '9:16',
                    '9:21',
                ])
                ->imageResizeTargetWidth('2560')
                ->imageResizeTargetHeight('2560')
                ->saveUploadedFileUsing(OptimizedImageUpload::webp('section-images', quality: 65, maxWidth: 1920, maxHeight: 1920)),
            ...$this->sharedImageFormSchema(),
        ];
    }

    protected function galleryImageFormSchema(): array
    {
        return [
            Forms\Components\Select::make('gallery_album_id')
                ->label(__('fields.section.gallery_album'))
                ->options(fn (): array => GalleryAlbum::query()
                    ->orderByDesc('start_date')
                    ->orderByDesc('id')
                    ->get()
                    ->mapWithKeys(fn (GalleryAlbum $album): array => [
                        $album->id => static::formatGalleryAlbumOptionLabel($album),
                    ])
                    ->all())
                ->default(fn ($record): ?int => $record?->galleryItem?->album_id)
                ->dehydrated(false)
                ->searchable()
                ->live()
                ->required()
                ->afterStateUpdated(fn (Set $set): mixed => $set('gallery_item_id', null))
                ->columnSpanFull(),

            Forms\Components\Select::make('gallery_item_id')
                ->label(__('fields.section.gallery_item'))
                ->helperText(__('fields.section.gallery_item_helper'))
                ->options(fn (Get $get): array => static::galleryItemOptions($get('gallery_album_id')))
                ->allowHtml()
                ->searchable()
                ->live()
                ->required()
                ->columnSpanFull(),

            Forms\Components\Placeholder::make('gallery_item_preview')
                ->label(__('fields.gallery.preview'))
                ->content(fn (Get $get): HtmlString => static::galleryItemPreview($get('gallery_item_id')))
                ->visible(fn (Get $get): bool => filled($get('gallery_item_id')))
                ->columnSpanFull(),

            ...$this->sharedImageFormSchema(),
        ];
    }

    protected function sharedImageFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('caption')
                ->label(__('fields.gallery.caption'))
                ->maxLength(255),
            Forms\Components\TextInput::make('display_order')
                ->label(__('fields.section.display_order'))
                ->numeric()
                ->default(0),
        ];
    }

    protected static function formatGalleryItemOptionLabel(GalleryItem $item): string
    {
        $locale = App::getLocale();
        $caption = $item->getTranslation('caption', $locale, false)
            ?: collect($item->getTranslations('caption'))->filter()->first();

        return $caption
            ? Str::limit($caption, 80)
            : __('fields.gallery.image') . ' #' . $item->id;
    }

    protected static function formatGalleryItemTableLabel(GalleryItem $item): string
    {
        return static::formatGalleryAlbumOptionLabel($item->album) . ' - ' . static::formatGalleryItemOptionLabel($item);
    }

    protected static function formatGalleryAlbumOptionLabel(?GalleryAlbum $album): string
    {
        if (! $album) {
            return __('filament.resources.gallery_album');
        }

        $locale = App::getLocale();

        return $album->getTranslation('title', $locale, false)
            ?: collect($album->getTranslations('title'))->filter()->first()
            ?: __('filament.resources.gallery_album') . ' #' . $album->id;
    }

    protected static function galleryItemOptions($albumId): array
    {
        if (! $albumId) {
            return [];
        }

        return GalleryItem::query()
            ->where('album_id', $albumId)
            ->whereNotNull('image_path')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->mapWithKeys(fn (GalleryItem $item): array => [
                $item->id => static::formatGalleryItemDropdownOptionLabel($item),
            ])
            ->all();
    }

    protected static function formatGalleryItemDropdownOptionLabel(GalleryItem $item): string
    {
        $url = e(Storage::url($item->image_path));
        $label = e(static::formatGalleryItemOptionLabel($item));

        return <<<HTML
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="{$url}" alt="" style="width: 128px; height: 96px; object-fit: cover; border-radius: 6px; flex: 0 0 auto;">
                <span style="white-space: normal; line-height: 1.3;">{$label}</span>
            </div>
        HTML;
    }

    protected static function galleryItemPreview($galleryItemId): HtmlString
    {
        if (! $galleryItemId) {
            return new HtmlString('');
        }

        $item = GalleryItem::find($galleryItemId);

        if (! $item?->image_path) {
            return new HtmlString('');
        }

        $url = e(Storage::url($item->image_path));
        $label = e(static::formatGalleryItemOptionLabel($item));

        return new HtmlString(<<<HTML
            <div class="space-y-2">
                <img src="{$url}" alt="{$label}" style="max-height: 320px; width: 100%; object-fit: contain; border-radius: 8px;">
                <p class="text-sm text-gray-500">{$label}</p>
            </div>
        HTML);
    }
}
