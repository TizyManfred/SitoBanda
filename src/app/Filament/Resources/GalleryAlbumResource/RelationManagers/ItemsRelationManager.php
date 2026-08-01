<?php

namespace App\Filament\Resources\GalleryAlbumResource\RelationManagers;

use App\Filament\Forms\Components\MultiImageUploader;
use App\Filament\Support\OptimizedImageUpload;
use App\Filament\Traits\WithAiTranslation;
use App\Models\GalleryItem;
use App\Services\TranslationService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class ItemsRelationManager extends RelationManager
{
    use WithAiTranslation;

    protected static string $relationship = 'items';

    public function translateBulkUploadCaption(array $captions): array
    {
        $locales = array_keys(LaravelLocalization::getLocalesOrder());
        $captions = collect($captions)
            ->map(fn ($caption) => is_string($caption) ? trim($caption) : '')
            ->only($locales)
            ->all();

        $sourceLocale = collect(['it', App::getLocale(), ...$locales])
            ->first(fn ($locale) => filled($captions[$locale] ?? null));

        if (! $sourceLocale) {
            return $captions;
        }

        $sourceText = $captions[$sourceLocale];
        $translationService = app(TranslationService::class);

        foreach ($locales as $targetLocale) {
            if ($targetLocale === $sourceLocale || filled($captions[$targetLocale] ?? null)) {
                continue;
            }

            $translated = $translationService->translate($sourceText, $sourceLocale, $targetLocale);

            if (filled($translated)) {
                $captions[$targetLocale] = $translated;
            }
        }

        foreach ($locales as $locale) {
            $captions[$locale] ??= '';
        }

        return $captions;
    }

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
                    ->required(! str_contains(Request::url(), '/edit'))
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
                    ->visible(fn (): bool => ! str_contains(Request::url(), '/edit') || ! $this->getRecord()?->image_path)
                    ->dehydrated(true)
                    ->saveUploadedFileUsing(OptimizedImageUpload::webp('gallery-items', quality: 65, maxWidth: 1920, maxHeight: 1920)),

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
            ->recordTitleAttribute('image_path')
            ->contentGrid([
                'default' => 1,
                'md' => 2,
                'xl' => 3,
                '2xl' => 4,
            ])
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('image_path')
                        ->label(__('fields.gallery.image'))
                        ->width('100%')
                        ->height(200)
                        ->extraImgAttributes([
                            'class' => 'rounded-lg bg-gray-100 object-contain dark:bg-gray-800',
                        ])
                        ->url(fn (GalleryItem $record): string => Storage::disk('public')->url($record->image_path))
                        ->openUrlInNewTab(),

                    Tables\Columns\TextColumn::make('caption')
                        ->label(__('fields.gallery.caption'))
                        ->searchable(query: function (Builder $query, string $search): Builder {
                            return $query->where(function ($query) use ($search) {
                                $locales = array_keys(LaravelLocalization::getLocalesOrder());

                                foreach ($locales as $locale) {
                                    $query->orWhere("caption->{$locale}", 'like', "%{$search}%");
                                }
                            });
                        })
                        ->sortable(query: function (Builder $query, string $direction): Builder {
                            $locale = App::getLocale();

                            return $query->orderBy("caption->{$locale}", $direction);
                        })
                        ->wrap()
                        ->html()
                        ->formatStateUsing(function (GalleryItem $record): string {
                            $translations = $record->getTranslations('caption');
                            $output = [];

                            foreach ($translations as $locale => $translation) {
                                $output[] = "<div><span class='font-medium'>{$locale}:</span> {$translation}</div>";
                            }

                            return implode('', $output);
                        }),
                ])->space(3),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('bulkUpload')
                    ->label(__('fields.gallery.upload_multiple_images'))
                    ->icon('heroicon-o-photo')
                    ->form([
                        // Use our new multi-image uploader component
                        MultiImageUploader::make('images')
                            ->label(__('fields.gallery.images'))
                            ->directory('gallery-items')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                            ->maxFiles(50)
                            ->maxSize(5120) // 5MB
                            ->columnSpanFull(),
                    ])

                    ->action(function (array $data): void {
                        $record = $this->getOwnerRecord();
                        $images = $data['images'] ?? [];

                        if (empty($images) || ! is_array($images)) {
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
                            if (! is_array($imageData)) {
                                // Handle simple string paths (fallback)
                                if (is_string($imageData) && ! empty($imageData)) {
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
                                            $filename = 'gallery-items/'.$uuid.'.'.$ext;
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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }
}
