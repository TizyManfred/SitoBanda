<?php

namespace App\Filament\Resources;

use App\Filament\Actions\TranslateAllAction;
use App\Filament\Actions\TranslateBulkAction;
use App\Filament\Resources\StaticPageResource\Pages;
use App\Filament\Support\OptimizedImageUpload;
use App\Models\StaticPage;
use App\Services\TranslationService;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StaticPageResource extends Resource
{
    protected static ?string $model = StaticPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 45;

    public static function getModelLabel(): string
    {
        return __('filament.resources.static_page');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.static_page_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.content_management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('fields.static_page.page_details'))
                            ->schema([
                                Forms\Components\Select::make('page_key')
                                    ->label(__('fields.static_page.page'))
                                    ->options(collect(StaticPage::PAGE_OPTIONS)->except('home')->all())
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, ?string $state): void {
                                        if (! $state) {
                                            return;
                                        }

                                        $set('label', StaticPage::PAGE_OPTIONS[$state] ?? $state);
                                    }),
                                Forms\Components\TextInput::make('label')
                                    ->label(__('fields.static_page.label'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('admin_notes')
                                    ->label(__('fields.static_page.admin_notes'))
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Forms\Components\Section::make(__('fields.static_page.page_content'))
                            ->schema([
                                Forms\Components\Repeater::make('content_blocks')
                                    ->label(__('fields.static_page.content_blocks'))
                                    ->schema([
                                        Forms\Components\TextInput::make('admin_label')
                                            ->label(__('fields.static_page.content_block_admin_label'))
                                            ->maxLength(120)
                                            ->helperText(__('fields.static_page.content_block_admin_label_helper')),
                                        Forms\Components\Select::make('layout')
                                            ->label(__('fields.static_page.content_block_layout'))
                                            ->options([
                                                'text' => __('fields.static_page.content_block_layouts.text'),
                                                'text_image_right' => __('fields.static_page.content_block_layouts.text_image_right'),
                                                'image_left_text' => __('fields.static_page.content_block_layouts.image_left_text'),
                                                'gallery' => __('fields.static_page.content_block_layouts.gallery'),
                                            ])
                                            ->default('text_image_right')
                                            ->required(),
                                        Forms\Components\Tabs::make('content_block_translations')
                                            ->tabs(static::translationTabs(
                                                fn (string $locale): array => static::contentBlockTranslationSchema($locale),
                                            ))
                                            ->columnSpanFull(),
                                        Forms\Components\Actions::make([
                                            static::translateContentBlockAction(),
                                        ])
                                            ->columnSpanFull(),
                                        Forms\Components\Repeater::make('image_items')
                                            ->label(__('fields.static_page.content_block_images'))
                                            ->schema([
                                                Forms\Components\FileUpload::make('image')
                                                    ->label(__('fields.common.image'))
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('static-pages/content-images')
                                                    ->imageEditor()
                                                    ->imageResizeMode('cover')
                                                    ->imageEditorAspectRatios([
                                                        null,
                                                        '1:1',
                                                        '4:3',
                                                        '16:9',
                                                        '3:4',
                                                    ])
                                                    ->imageResizeTargetWidth('2560')
                                                    ->imageResizeTargetHeight('2560')
                                                    ->maxSize(10240)
                                                    ->visibility('public')
                                                    ->openable()
                                                    ->downloadable()
                                                    ->previewable(true)
                                                    ->saveUploadedFileUsing(OptimizedImageUpload::webp('static-pages/content-images', quality: 65, maxWidth: 1920, maxHeight: 1920))
                                                    ->required()
                                                    ->columnSpanFull(),
                                                Forms\Components\Tabs::make('image_description_translations')
                                                    ->tabs(static::translationTabs(
                                                        fn (string $locale): array => static::imageDescriptionSchema($locale),
                                                    ))
                                                    ->columnSpanFull(),
                                                Forms\Components\Actions::make([
                                                    static::translateImageDescriptionAction(),
                                                ])
                                                    ->columnSpanFull(),
                                            ])
                                            ->itemLabel(function (array $state): ?string {
                                                $image = $state['image'] ?? null;

                                                if (is_array($image)) {
                                                    $image = collect($image)->first();
                                                }

                                                return collect($state['description'] ?? [])->filter()->first() ?: $image;
                                            })
                                            ->addActionLabel(__('fields.static_page.add_content_block_image'))
                                            ->reorderable()
                                            ->collapsible()
                                            ->cloneable()
                                            ->helperText(__('fields.static_page.content_block_images_helper'))
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->itemLabel(fn (array $state): ?string => $state['admin_label']
                                        ?? collect($state['title'] ?? [])->filter()->first()
                                        ?? null)
                                    ->addActionLabel(__('fields.static_page.add_content_block'))
                                    ->reorderable()
                                    ->collapsible()
                                    ->cloneable()
                                    ->columnSpanFull(),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('fields.static_page.header_image'))
                            ->schema([
                                Forms\Components\FileUpload::make('header_images')
                                    ->label(__('fields.static_page.home_header_images'))
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->disk('public')
                                    ->directory('static-pages/header-images')
                                    ->imageEditor()
                                    ->imageResizeMode('cover')
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '21:9',
                                        '3:1',
                                    ])
                                    ->imageResizeTargetWidth('2560')
                                    ->imageResizeTargetHeight('1440')
                                    ->maxSize(10240)
                                    ->visibility('public')
                                    ->openable()
                                    ->downloadable()
                                    ->previewable(true)
                                    ->saveUploadedFileUsing(OptimizedImageUpload::webp('static-pages/header-images', quality: 70, maxWidth: 2560, maxHeight: 1440))
                                    ->helperText(__('fields.static_page.home_header_images_helper'))
                                    ->visible(fn (Forms\Get $get): bool => $get('page_key') === 'home'),
                                Forms\Components\FileUpload::make('header_image_path')
                                    ->label(__('fields.static_page.header_image_path'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('static-pages/header-images')
                                    ->imageEditor()
                                    ->imageResizeMode('cover')
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '21:9',
                                        '3:1',
                                    ])
                                    ->imageResizeTargetWidth('2560')
                                    ->imageResizeTargetHeight('1440')
                                    ->maxSize(10240)
                                    ->visibility('public')
                                    ->openable()
                                    ->downloadable()
                                    ->previewable(true)
                                    ->saveUploadedFileUsing(OptimizedImageUpload::webp('static-pages/header-images', quality: 70, maxWidth: 2560, maxHeight: 1440))
                                    ->helperText(__('fields.static_page.header_image_path_helper'))
                                    ->visible(fn (Forms\Get $get): bool => $get('page_key') !== 'home'),
                                Forms\Components\TextInput::make('fallback_header_image_path')
                                    ->label(__('fields.static_page.fallback_header_image_path'))
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText(__('fields.static_page.fallback_header_image_path_helper')),
                                Forms\Components\Toggle::make('is_active')
                                    ->label(__('fields.static_page.is_active'))
                                    ->default(true)
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    protected static function contentBlockTranslationSchema(string $locale): array
    {
        return [
            Forms\Components\TextInput::make("title.{$locale}")
                ->label(__('fields.static_page.content_block_title'))
                ->maxLength(255),
            Forms\Components\RichEditor::make("body.{$locale}")
                ->label(__('fields.static_page.content_block_body'))
                ->toolbarButtons([
                    'blockquote',
                    'bold',
                    'bulletList',
                    'h2',
                    'h3',
                    'italic',
                    'link',
                    'orderedList',
                    'redo',
                    'strike',
                    'underline',
                    'undo',
                ])
                ->columnSpanFull(),
        ];
    }

    protected static function imageDescriptionSchema(string $locale): array
    {
        return [
            Forms\Components\Textarea::make("description.{$locale}")
                ->label(__('fields.static_page.content_block_image_description'))
                ->rows(2)
                ->maxLength(500),
        ];
    }

    protected static function translationTabs(callable $schemaFactory): array
    {
        return collect(LaravelLocalization::getLocalesOrder())
            ->map(fn (array $properties, string $locale): Forms\Components\Tabs\Tab => Forms\Components\Tabs\Tab::make(
                $properties['native'] ?? strtoupper($locale),
            )->schema($schemaFactory($locale)))
            ->values()
            ->all();
    }

    protected static function translateContentBlockAction(): Action
    {
        return Action::make('translateContentBlock')
            ->label(__('fields.static_page.translate_content_block'))
            ->icon('heroicon-o-language')
            ->tooltip(__('fields.static_page.translate_content_block'))
            ->size('sm')
            ->color('gray')
            ->action(function (Forms\Get $get, Forms\Set $set): void {
                $locales = array_keys(LaravelLocalization::getLocalesOrder());
                $title = (array) ($get('title') ?? []);
                $body = (array) ($get('body') ?? []);

                $sourceLocale = static::resolveContentBlockSourceLocale($locales, $title, $body);

                if (! $sourceLocale) {
                    Notification::make()
                        ->warning()
                        ->title(__('fields.static_page.translation_source_missing'))
                        ->body(__('fields.static_page.translation_source_missing_body'))
                        ->send();

                    return;
                }

                $sourceTitle = trim((string) ($title[$sourceLocale] ?? ''));
                $sourceBody = trim((string) ($body[$sourceLocale] ?? ''));
                $translationService = app(TranslationService::class);
                $translatedLocales = [];

                foreach ($locales as $targetLocale) {
                    if ($targetLocale === $sourceLocale) {
                        continue;
                    }

                    $updatedTarget = false;

                    if ($sourceTitle !== '' && blank(trim((string) ($title[$targetLocale] ?? '')))) {
                        $translatedTitle = $translationService->translate($sourceTitle, $sourceLocale, $targetLocale);

                        if (filled($translatedTitle)) {
                            $set("title.{$targetLocale}", $translatedTitle);
                            $updatedTarget = true;
                        }
                    }

                    if ($sourceBody !== '' && blank(trim((string) ($body[$targetLocale] ?? '')))) {
                        $translatedBody = $translationService->translate($sourceBody, $sourceLocale, $targetLocale);

                        if (filled($translatedBody)) {
                            $set("body.{$targetLocale}", $translatedBody);
                            $updatedTarget = true;
                        }
                    }

                    if ($updatedTarget) {
                        $translatedLocales[] = $targetLocale;
                    }
                }

                if ($translatedLocales === []) {
                    Notification::make()
                        ->warning()
                        ->title(__('fields.static_page.translation_nothing_to_update'))
                        ->body(__('fields.static_page.translation_nothing_to_update_body'))
                        ->send();

                    return;
                }

                Notification::make()
                    ->success()
                    ->title(__('fields.static_page.translation_completed'))
                    ->body(__('fields.static_page.translation_completed_body', ['locales' => implode(', ', $translatedLocales)]))
                    ->send();
            });
    }

    protected static function translateImageDescriptionAction(): Action
    {
        return Action::make('translateImageDescription')
            ->label(__('fields.static_page.translate_image_description'))
            ->icon('heroicon-o-language')
            ->tooltip(__('fields.static_page.translate_image_description'))
            ->size('sm')
            ->color('gray')
            ->action(function (Forms\Get $get, Forms\Set $set): void {
                $locales = array_keys(LaravelLocalization::getLocalesOrder());
                $description = (array) ($get('description') ?? []);
                $sourceLocale = static::resolveImageDescriptionSourceLocale($locales, $description);

                if (! $sourceLocale) {
                    Notification::make()
                        ->warning()
                        ->title(__('fields.static_page.image_translation_source_missing'))
                        ->body(__('fields.static_page.image_translation_source_missing_body'))
                        ->send();

                    return;
                }

                $sourceDescription = trim((string) ($description[$sourceLocale] ?? ''));
                $translationService = app(TranslationService::class);
                $translatedLocales = [];

                foreach ($locales as $targetLocale) {
                    if ($targetLocale === $sourceLocale || filled(trim((string) ($description[$targetLocale] ?? '')))) {
                        continue;
                    }

                    $translatedDescription = $translationService->translate($sourceDescription, $sourceLocale, $targetLocale);

                    if (filled($translatedDescription)) {
                        $set("description.{$targetLocale}", $translatedDescription);
                        $translatedLocales[] = $targetLocale;
                    }
                }

                if ($translatedLocales === []) {
                    Notification::make()
                        ->warning()
                        ->title(__('fields.static_page.translation_nothing_to_update'))
                        ->body(__('fields.static_page.translation_nothing_to_update_body'))
                        ->send();

                    return;
                }

                Notification::make()
                    ->success()
                    ->title(__('fields.static_page.translation_completed'))
                    ->body(__('fields.static_page.translation_completed_body', ['locales' => implode(', ', $translatedLocales)]))
                    ->send();
            });
    }

    protected static function resolveContentBlockSourceLocale(array $locales, array $title, array $body): ?string
    {
        if (in_array('it', $locales, true) && (filled($title['it'] ?? null) || filled($body['it'] ?? null))) {
            return 'it';
        }

        foreach ($locales as $locale) {
            if (filled($title[$locale] ?? null) || filled($body[$locale] ?? null)) {
                return $locale;
            }
        }

        return null;
    }

    protected static function resolveImageDescriptionSourceLocale(array $locales, array $description): ?string
    {
        if (in_array('it', $locales, true) && filled($description['it'] ?? null)) {
            return 'it';
        }

        foreach ($locales as $locale) {
            if (filled($description[$locale] ?? null)) {
                return $locale;
            }
        }

        return null;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('page_key', '!=', 'home'))
            ->columns([
                Tables\Columns\ImageColumn::make('header_image_preview_url')
                    ->label(__('fields.static_page.header_image'))
                    ->width(140)
                    ->height(70),
                Tables\Columns\TextColumn::make('label')
                    ->label(__('fields.static_page.label'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('fields.static_page.is_active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('fields.common.updated_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    TranslateBulkAction::make()
                        ->staticPage(),
                ]),
            ])
            ->headerActions([
                TranslateAllAction::make()
                    ->modelClass(StaticPage::class)
                    ->staticPage(),
            ])
            ->defaultSort('label');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStaticPages::route('/'),
            'create' => Pages\CreateStaticPage::route('/create'),
            'edit' => Pages\EditStaticPage::route('/{record}/edit'),
        ];
    }
}
