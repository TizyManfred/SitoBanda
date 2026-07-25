<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Support\OptimizedImageUpload;
use App\Filament\Traits\WithAiTranslation;
use App\Models\Event;
use App\Services\NominatimGeocoder;
use Filament\Forms;
use Filament\Forms\Components\Actions;
// Import helpers for IDE support
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

use function app;

class EventResource extends Resource
{
    use Translatable;
    use WithAiTranslation;

    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function getModelLabel(): string
    {
        return __('filament.resources.event');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.event_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.content_management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Left column - Main content
                Group::make()
                    ->schema([
                        Section::make(__('fields.event.event_details'))
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        TranslatableContainer::make(
                                            Forms\Components\TextInput::make('title')
                                                ->label(__('fields.event.title'))
                                                ->required()
                                                ->maxLength(255)
                                                ->live(onBlur: true)
                                        )->columnSpan(5),

                                        Actions::make([
                                            static::getTranslateAction('title'),
                                        ])->columnSpan(1),
                                    ])
                                    ->columns(6),

                                Forms\Components\Grid::make()
                                    ->schema([
                                        TranslatableContainer::make(
                                            Forms\Components\Textarea::make('short_description')
                                                ->label(__('fields.event.short_description'))
                                                ->maxLength(255)
                                        )->columnSpan(5),

                                        Actions::make([
                                            static::getTranslateAction('short_description'),
                                        ])->columnSpan(1),
                                    ])
                                    ->columns(6),

                                Forms\Components\Grid::make()
                                    ->schema([
                                        TranslatableContainer::make(
                                            Forms\Components\RichEditor::make('description')
                                                ->label(__('fields.event.description'))
                                        )->columnSpan(5),

                                        Actions::make([
                                            static::getTranslateAction('description'),
                                        ])->columnSpan(1),
                                    ])
                                    ->columns(6),
                            ])
                            ->collapsible(),

                        Section::make(__('fields.event.location_details'))
                            ->schema([
                                Forms\Components\TextInput::make('location')
                                    ->label(__('fields.event.location'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('address')
                                    ->label(__('fields.event.address'))
                                    ->columnSpanFull(),
                                Actions::make([
                                    Actions\Action::make('placeOnMap')
                                        ->label(__('geocoding.place_on_map'))
                                        ->icon('heroicon-o-map-pin')
                                        ->color('gray')
                                        ->action(function (Get $get, Set $set, $livewire): void {
                                            $query = collect([$get('location'), $get('address')])
                                                ->filter(fn ($value): bool => filled(trim((string) $value)))
                                                ->implode(', ');

                                            if ($query === '') {
                                                Notification::make()
                                                    ->warning()
                                                    ->title(__('geocoding.missing_address_title'))
                                                    ->body(__('geocoding.missing_address_body'))
                                                    ->send();

                                                return;
                                            }

                                            try {
                                                $match = app(NominatimGeocoder::class)->geocode($query);

                                                if ($match === null) {
                                                    Notification::make()
                                                        ->warning()
                                                        ->title(__('geocoding.not_found_title'))
                                                        ->body(__('geocoding.not_found_body'))
                                                        ->send();

                                                    return;
                                                }

                                                $latitude = number_format($match['latitude'], 7, '.', '');
                                                $longitude = number_format($match['longitude'], 7, '.', '');

                                                $set('latitude', $latitude);
                                                $set('longitude', $longitude);
                                                $livewire->dispatch(
                                                    'event-location-geocoded',
                                                    latitude: $latitude,
                                                    longitude: $longitude,
                                                );

                                                Notification::make()
                                                    ->success()
                                                    ->title(__('geocoding.success_title'))
                                                    ->body(__('geocoding.success_body', ['place' => $match['display_name']]))
                                                    ->send();
                                            } catch (\Throwable $exception) {
                                                report($exception);

                                                Notification::make()
                                                    ->danger()
                                                    ->title(__('geocoding.error_title'))
                                                    ->body(__('geocoding.error_body'))
                                                    ->send();
                                            }
                                        }),
                                ])
                                    ->alignEnd()
                                    ->columnSpanFull(),
                                Forms\Components\Grid::make([
                                    'default' => 2,
                                ])
                                    ->schema([
                                        Forms\Components\TextInput::make('latitude')
                                            ->label(__('fields.event.latitude'))
                                            ->numeric()
                                            ->placeholder(__('fields.event.lat_placeholder'))
                                            ->helperText(__('fields.event.decimal_format')),
                                        Forms\Components\TextInput::make('longitude')
                                            ->label(__('fields.event.longitude'))
                                            ->numeric()
                                            ->placeholder(__('fields.event.long_placeholder'))
                                            ->helperText(__('fields.event.decimal_format')),
                                    ]),
                                Forms\Components\ViewField::make('location_map')
                                    ->view('filament.forms.components.event-location-map')
                                    ->columnSpanFull(),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 2]),

                // Right sidebar
                Group::make()
                    ->schema([
                        Section::make(__('fields.common.media'))
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->label(__('fields.event.cover_image'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('event-images')
                                    ->imageEditor()
                                    ->imageResizeMode('cover')
                                    ->maxSize(5120 * 2) // 10MB
                                    ->helperText(__('fields.common.max_filesize', ['size' => '10MB']))
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
                                    ->visibility('public')
                                    ->openable()
                                    ->downloadable()
                                    ->previewable(true)
                                    ->saveUploadedFileUsing(OptimizedImageUpload::webp('event-images', quality: 65, maxWidth: 1920, maxHeight: 1920)),
                                Forms\Components\Select::make('gallery_id')
                                    ->label(__('fields.event.photo_gallery'))
                                    ->relationship('galleryAlbum', 'title')
                                    ->searchable()
                                    ->preload(),
                            ]),

                        Section::make(__('fields.common.date_time'))
                            ->schema([
                                Forms\Components\DateTimePicker::make('start_datetime')
                                    ->required()
                                    ->label(__('fields.event.start_datetime'))
                                    ->native(false)
                                    ->live()
                                    ->displayFormat('D, d M Y H:i'),
                                Forms\Components\DateTimePicker::make('end_datetime')
                                    ->label(__('fields.event.end_datetime'))
                                    ->native(false)
                                    ->live()
                                    ->displayFormat('D, d M Y H:i')
                                    ->after('start_datetime'),
                            ]),

                        Section::make(__('fields.event.publication'))
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label(__('fields.event.featured_event'))
                                    ->helperText(__('fields.event.featured_helper'))
                                    ->default(false)
                                    ->required(),
                                Forms\Components\Toggle::make('is_public')
                                    ->label(__('fields.event.publicly_visible'))
                                    ->helperText(__('fields.event.public_helper'))
                                    ->default(true)
                                    ->required(),
                            ]),

                        Section::make(__('fields.attachment.relation_title'))
                            ->schema([
                                Forms\Components\Repeater::make('attachments')
                                    ->hiddenLabel()
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\FileUpload::make('file_path')
                                            ->label(__('fields.attachment.file'))
                                            ->disk('local')
                                            ->directory('attachments')
                                            ->acceptedFileTypes([
                                                'application/pdf',
                                                'application/msword',
                                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                                'application/vnd.ms-excel',
                                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                                'application/vnd.ms-powerpoint',
                                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                                'text/plain',
                                                'text/csv',
                                                'image/jpeg',
                                                'image/png',
                                                'image/webp',
                                            ])
                                            ->maxSize(20480)
                                            ->visibility('private')
                                            ->openable()
                                            ->downloadable()
                                            ->required()
                                            ->helperText(__('fields.attachment.file_helper')),
                                        ...static::attachmentTitleFields(),
                                        Forms\Components\Toggle::make('is_public')
                                            ->label(__('fields.attachment.is_public'))
                                            ->helperText(__('fields.attachment.is_public_helper'))
                                            ->default(true)
                                            ->required(),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => collect($state['title'] ?? [])->filter()->first())
                                    ->addActionLabel(__('fields.attachment.add'))
                                    ->orderColumn('display_order')
                                    ->collapsible()
                                    ->collapsed()
                                    ->defaultItems(0),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    /**
     * Build attachment title inputs for every configured public language.
     *
     * @return array<int, Forms\Components\TextInput>
     */
    protected static function attachmentTitleFields(): array
    {
        return collect(array_keys(config('laravellocalization.supportedLocales', [])))
            ->map(fn (string $locale): Forms\Components\TextInput => Forms\Components\TextInput::make("title.{$locale}")
                ->label(__('fields.attachment.title_'.$locale))
                ->required($locale === 'it')
                ->maxLength(255))
            ->values()
            ->all();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('start_datetime', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')->label(__('fields.event.cover_image'))
                    ->width(100)
                    ->height(60),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('fields.event.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label(__('fields.event.location'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_datetime')
                    ->label(__('fields.event.start_datetime'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label(__('fields.event.featured_event'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_public')
                    ->label(__('fields.event.public_event'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('fields.event.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()
                    ->label(__('fields.event.trashed_filter')),
                SelectFilter::make('is_featured')
                    ->label(__('fields.event.featured_filter'))
                    ->options([
                        true => __('fields.event.featured'),
                        false => __('fields.event.not_featured'),
                    ]),
                SelectFilter::make('is_public')
                    ->label(__('fields.event.visibility_filter'))
                    ->options([
                        true => __('fields.event.public'),
                        false => __('fields.event.private'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('actions.edit')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('actions.delete')),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->label(__('actions.force_delete')),
                    Tables\Actions\RestoreBulkAction::make()
                        ->label(__('actions.restore')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getTranslatableAttributes(): array
    {
        return ['title', 'description', 'short_description', 'slug'];
    }

    public static function getTranslatableAttributesForTable(): array
    {
        return ['title'];
    }

    public static function getTranslatableAttributesForForm(): array
    {
        return ['title', 'description', 'short_description', 'slug'];
    }
}
