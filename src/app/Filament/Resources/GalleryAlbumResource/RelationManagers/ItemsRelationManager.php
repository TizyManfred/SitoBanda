<?php

namespace App\Filament\Resources\GalleryAlbumResource\RelationManagers;

use App\Filament\Traits\WithAiTranslation;
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
use Filament\Notifications\Notification;
use App\Models\GalleryItem;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Http\UploadedFile;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ItemsRelationManager extends RelationManager
{
    use WithAiTranslation;

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
                    ->optimize('webp'),
                
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
                            $locales = array_keys(LaravelLocalization::getSupportedLocales());
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
                        // Use our new multi-image uploader component
                        \App\Filament\Forms\Components\MultiImageUploader::make('images')
                            ->label(__('fields.gallery.images'))
                            ->directory('gallery-items')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                            ->maxFiles(50)
                            ->maxSize(5120) // 5MB
                            ->columnSpanFull()
                    ])

                    ->action(function (array $data): void {
                        $record = $this->getOwnerRecord();
                        $images = $data['images'] ?? [];
                        
                        if (empty($images) || !is_array($images)) {
                            Notification::make()
                                ->title(__('fields.gallery.no_images_selected'))
                                ->warning()
                                ->send();
                            return;
                        }
                        
                        // Get the next sort order
                        $maxSort = GalleryItem::where('album_id', $record->id)->max('sort_order') ?? 0;
                        
                        // Process each image
                        $count = 0;
                        foreach ($images as $imageData) {
                            // Skip invalid entries - handle both old and new format
                            if (!is_array($imageData)) {
                                // Handle simple string paths (fallback)
                                if (is_string($imageData) && !empty($imageData)) {
                                    GalleryItem::create([
                                        'album_id' => $record->id,
                                        'image_path' => $imageData,
                                        'caption' => [
                                            'it' => '',
                                            'en' => '',
                                            'de' => '',
                                        ],
                                        'sort_order' => ++$maxSort,
                                    ]);
                                    $count++;
                                }
                                continue;
                            }
                            
                            // Extract data from the image object and handle uploads
                            $imagePath = $imageData['path'] ?? $imageData['url'] ?? null;

                            // If a file was provided (via Livewire temp upload), store it
                            if (isset($imageData['file'])) {
                                $fileVal = $imageData['file'];
                                try {
                                    if ($fileVal instanceof TemporaryUploadedFile || $fileVal instanceof UploadedFile) {
                                        $storedPath = $fileVal->store('gallery-items', 'public');
                                        $imagePath = $storedPath;
                                    } elseif (is_string($fileVal)) {
                                        // Livewire often serializes temp files as strings like "livewire-file:..."
                                        $tmp = TemporaryUploadedFile::unserializeFromLivewire($fileVal);
                                        if ($tmp instanceof TemporaryUploadedFile) {
                                            $storedPath = $tmp->store('gallery-items', 'public');
                                            $imagePath = $storedPath;
                                        }
                                    } elseif (is_array($fileVal) && isset($fileVal['temporaryUploadedFile'])) {
                                        // Some shapes wrap the serialized value
                                        $tmp = TemporaryUploadedFile::unserializeFromLivewire($fileVal['temporaryUploadedFile']);
                                        if ($tmp instanceof TemporaryUploadedFile) {
                                            $storedPath = $tmp->store('gallery-items', 'public');
                                            $imagePath = $storedPath;
                                        }
                                    }
                                } catch (\Throwable $e) {
                                    // Skip this file if upload fails
                                }
                            }

                            // If we don't have a valid path and we only have a client preview data URL, decode and store it
                            if ((empty($imagePath) || (is_string($imagePath) && str_starts_with($imagePath, 'blob:'))) && isset($imageData['preview']) && is_string($imageData['preview'])) {
                                $preview = $imageData['preview'];
                                if (str_starts_with($preview, 'data:image/')) {
                                    try {
                                        // Extract extension and base64 payload
                                        [$meta, $data] = explode(',', $preview, 2);
                                        if (preg_match('/data:image\/(\w+);base64/i', $meta, $m)) {
                                            $ext = strtolower($m[1]);
                                        } else {
                                            $ext = 'png';
                                        }
                                        $binary = base64_decode($data, true);
                                        if ($binary !== false) {
                                            $uuid = method_exists(Str::class, 'uuid') ? (string) Str::uuid() : uniqid('img_', true);
                                            $filename = 'gallery-items/' . $uuid . '.' . $ext;
                                            Storage::disk('public')->put($filename, $binary);
                                            $imagePath = $filename;
                                        }
                                    } catch (\Throwable $e) {
                                        // fall through; we'll skip if still invalid
                                    }
                                }
                            }

                            // Accept common valid URL forms (absolute/relative). Skip only when empty or blob:
                            if (empty($imagePath) || (is_string($imagePath) && str_starts_with($imagePath, 'blob:'))) {
                                continue;
                            }
                            
                            $captions = $imageData['captions'] ?? [];
                            
                            // Create translations array
                            $translations = [];
                            foreach ($captions as $locale => $caption) {
                                $translations[$locale] = trim($caption);
                            }
                            
                            // Ensure we have at least empty captions for both locales
                            if (empty($translations)) {
                                $translations = [
                                    'it' => '',
                                    'en' => '',
                                    'de' => '',
                                ];
                            }
                            
                            // Create the gallery item
                            GalleryItem::create([
                                'album_id' => $record->id,
                                'image_path' => $imagePath,
                                'caption' => $translations, // Use array directly if model supports HasTranslations
                                'sort_order' => ++$maxSort,
                            ]);
                            
                            $count++;
                        }
                        
                        Notification::make()
                            ->title(__('fields.gallery.images_uploaded', ['count' => $count]))
                            ->success()
                            ->send();
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
