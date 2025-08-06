<?php

namespace App\Filament\Resources\GalleryAlbumResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Show current image in edit mode
                Forms\Components\ViewField::make('current_image')
                    ->view('filament.forms.components.image-preview')
                    ->visible(fn ($record) => str_contains(Request::url(), '/edit') && $record?->image_path)
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'flex justify-center py-4']),
                
                // File upload for new image (only in create mode or when replacing)
                Forms\Components\FileUpload::make('image_path')
                    ->label(__('fields.gallery.image'))
                    ->image()
                    ->directory('gallery-items')
                    ->required(!str_contains(Request::url(), '/edit'))
                    ->columnSpanFull()
                    ->helperText(fn () => str_contains(Request::url(), '/edit') ? __('fields.gallery.replace_image_helper') : __('fields.gallery.upload_image_helper'))
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
                    ->visible(fn (): bool => !str_contains(Request::url(), '/edit') || !$this->getRecord()?->image_path)
                    ->dehydrated(true)
                    ->preserveFilenames(),
                
                TranslatableContainer::make(
                    Forms\Components\TextInput::make('caption')
                        ->reactive()
                )->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label(__('fields.gallery.image'))
                    ->width(200)
                    ->height(100)
                    ->square(),

                Tables\Columns\TextColumn::make('caption')
                    ->label(__('fields.gallery.caption'))
                    ->formatStateUsing(function ($record) {
                        $translations = $record->getTranslations('caption');
                        $output = [];
                        
                        foreach ($translations as $locale => $translation) {
                            $output[] = "{$locale}: {$translation}";
                        }
                        
                        return implode('\n', $output);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function($q) use ($search) {
                            $locales = array_keys(config('filament-plugin-translatable-inline.locales', ['en' => 'English']));
                            foreach ($locales as $locale) {
                                $q->orWhere("caption->{$locale}", 'like', "%{$search}%");
                            }
                        });
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        $locale = App::getLocale();
                        return $query->orderBy("caption->{$locale}", $direction);
                    })
                    ->wrap()
                    ->html()
                    ->formatStateUsing(function ($record) {
                        $translations = $record->getTranslations('caption');
                        $output = [];
                        
                        foreach ($translations as $locale => $translation) {
                            $output[] = "<div><span class='font-medium'>{$locale}:</span> {$translation}</div>";
                        }
                        
                        return implode('', $output);
                    }),

                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('fields.gallery.order')),
            ])
            ->actions([
                Tables\Actions\Action::make('moveUp')
                    ->icon('heroicon-o-arrow-up')
                    ->action(function (Model $record) {
                        $record->decrement('sort_order');
                    }),

                Tables\Actions\Action::make('moveDown')
                    ->icon('heroicon-o-arrow-down')
                    ->action(function (Model $record) {
                        $record->increment('sort_order');
                    }),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('bulkUpload')
                    ->label(__('fields.gallery.upload_multiple_images'))
                    ->icon('heroicon-o-photo')
                    ->form([
                        Forms\Components\FileUpload::make('images')
                            ->label(__('fields.gallery.images'))
                            ->multiple()
                            ->image()
                            ->directory('gallery-items')
                            ->required()
                            ->columnSpanFull()
                            ->helperText(__('fields.gallery.multiple_upload_helper'))
                            ->reorderable()
                            ->appendFiles()
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
                            ->panelLayout('grid'),
                            
                    ])
                    ->action(function (array $data): void {
                        $album = $this->getOwnerRecord();
                        $maxSortOrder = $album->items()->max('sort_order') ?? 0;
                        
                        foreach ($data['images'] as $image) {
                            if (is_string($image)) {
                                // Handle case where $image is already a string (path)
                                $filename = basename($image);
                                $path = $image;
                            } else {
                                // Handle UploadedFile object
                                $filename = $image->getClientOriginalName();
                                $path = $image->store('gallery-items', 'public');
                            }
                            
                            $maxSortOrder++;
                            
                            $caption = pathinfo($filename, PATHINFO_FILENAME);
                            
                            // Create the gallery item with translations
                            $galleryItem = $album->items()->create([
                                'image_path' => $path,
                                'sort_order' => $maxSortOrder,
                            ]);
                            
                            // Set translations for each supported locale
                            $locales = config('filament-plugin-translatable-inline.locales', ['en' => 'English']);
                            if (!is_array($locales)) {
                                $locales = ['en' => 'English']; // Fallback to English if config is invalid
                            }

                            foreach (array_keys($locales) as $locale) {
                                $galleryItem->setTranslation('caption', $locale, $caption);
                            }
                            
                            $galleryItem->save();
                        }
                    })
                    ->modalHeading(__('fields.gallery.upload_multiple_images'))
                    ->modalDescription(__('fields.gallery.multiple_upload_helper'))
                    ->modalSubmitActionLabel(__('fields.gallery.upload_all_images'))
                    ->modalWidth('4xl'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('show')
                        ->icon('heroicon-o-eye')
                        ->label(__('fields.gallery.show_selected'))
                        ->action(fn (\Illuminate\Support\Collection $records) => 
                            $records->each->update(['is_visible' => true])
                        ),
                    Tables\Actions\BulkAction::make('hide')
                        ->icon('heroicon-m-eye-slash')
                        ->label(__('fields.gallery.hide_selected'))
                        ->action(fn (\Illuminate\Support\Collection $records) => 
                            $records->each->update(['is_visible' => false])
                        ),
                ]),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }
}
