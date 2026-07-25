<?php

namespace App\Filament\Pages;

use App\Filament\Support\OptimizedImageUpload;
use App\Helpers\SettingsHelper;
use App\Models\Setting;
use App\Models\StaticPage;
use App\Services\TranslationService;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HomepageStaticPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $slug = 'homepage';

    protected static ?int $navigationSort = 44;

    protected static string $view = 'filament.pages.homepage-static-page';

    public ?array $data = [];

    public function mount(): void
    {
        $staticPage = $this->resolveHomePage();

        $slides = $staticPage->header_slides;

        if ($slides === null && ($staticPage->header_images ?? []) !== []) {
            $slides = collect($staticPage->header_images)
                ->filter()
                ->map(fn (string $image): array => [
                    'image' => $image,
                    'title' => [],
                    'description' => [],
                ])
                ->values()
                ->all();
        }

        $this->form->fill([
            'home_banner' => SettingsHelper::homeBanner(),
            'header_slides' => $slides ?? [],
            'admin_notes' => $staticPage->admin_notes,
            'is_active' => $staticPage->is_active,
        ]);
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.homepage_static.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.content_management');
    }

    public function getTitle(): string
    {
        return __('filament.homepage_static.title');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament.homepage_static.home_banner_section'))
                    ->description(__('filament.homepage_static.home_banner_section_description'))
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Toggle::make('home_banner.enabled')
                                    ->label(__('filament.homepage_static.home_banner_enabled'))
                                    ->default(true)
                                    ->live(),
                                Forms\Components\DatePicker::make('home_banner.start_date')
                                    ->label(__('filament.homepage_static.home_banner_start_date'))
                                    ->helperText(__('filament.homepage_static.home_banner_start_date_hint'))
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->closeOnDateSelection(),
                                Forms\Components\DatePicker::make('home_banner.end_date')
                                    ->label(__('filament.homepage_static.home_banner_end_date'))
                                    ->helperText(__('filament.homepage_static.home_banner_end_date_hint'))
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->afterOrEqual('home_banner.start_date')
                                    ->closeOnDateSelection(),
                            ])
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('home_banner.image')
                            ->label(__('filament.homepage_static.home_banner_image'))
                            ->helperText(__('filament.homepage_static.home_banner_image_hint'))
                            ->image()
                            ->disk('public')
                            ->directory('static-pages/home-banner')
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageEditorAspectRatios([
                                '16:9',
                            ])
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675')
                            ->maxSize(5120)
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->previewable(true)
                            ->saveUploadedFileUsing(OptimizedImageUpload::webp('static-pages/home-banner', quality: 72, maxWidth: 1200, maxHeight: 675))
                            ->columnSpanFull(),
                        Forms\Components\Tabs::make('home_banner_translations')
                            ->tabs(static::translationTabs(
                                fn (string $locale): array => static::homeBannerContentSchema($locale),
                            ))
                            ->columnSpanFull(),
                        Forms\Components\Actions::make([
                            static::translateHomeBannerAction(),
                        ])
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
                Forms\Components\Section::make(__('filament.homepage_static.carousel_section'))
                    ->schema([
                        Forms\Components\Repeater::make('header_slides')
                            ->label(__('filament.homepage_static.slides'))
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label(__('fields.common.image'))
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
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\Tabs::make('slide_content_translations')
                                    ->tabs(static::translationTabs(
                                        fn (string $locale): array => static::slideContentSchema($locale),
                                    ))
                                    ->columnSpanFull(),
                                Forms\Components\Actions::make([
                                    static::translateSlideContentAction(),
                                ])
                                    ->columnSpanFull(),
                            ])
                            ->itemLabel(function (array $state): ?string {
                                $image = $state['image'] ?? null;

                                if (is_array($image)) {
                                    $image = collect($image)->first();
                                }

                                return collect($state['title'] ?? [])->filter()->first()
                                    ?: strip_tags(collect($state['description'] ?? [])->filter()->first() ?? '')
                                    ?: $image;
                            })
                            ->addActionLabel(__('filament.homepage_static.add_slide'))
                            ->reorderable()
                            ->collapsible()
                            ->cloneable()
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make(__('fields.static_page.page_details'))
                    ->schema([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label(__('fields.static_page.admin_notes'))
                            ->rows(3),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('fields.static_page.is_active'))
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected static function homeBannerContentSchema(string $locale): array
    {
        return [
            Forms\Components\TextInput::make("home_banner.badge.{$locale}")
                ->label(__('filament.homepage_static.home_banner_badge'))
                ->maxLength(40)
                ->columnSpanFull(),
            Forms\Components\TextInput::make("home_banner.headline.{$locale}")
                ->label(__('filament.homepage_static.home_banner_headline'))
                ->maxLength(160)
                ->required()
                ->columnSpanFull(),
            Forms\Components\Textarea::make("home_banner.body.{$locale}")
                ->label(__('filament.homepage_static.home_banner_body'))
                ->rows(3)
                ->maxLength(300)
                ->columnSpanFull(),
            Forms\Components\TextInput::make("home_banner.cta_label.{$locale}")
                ->label(__('filament.homepage_static.home_banner_cta'))
                ->maxLength(80)
                ->columnSpanFull(),
            Forms\Components\TextInput::make("home_banner.cta_url.{$locale}")
                ->label(__('filament.homepage_static.home_banner_cta_url'))
                ->helperText(__('filament.homepage_static.home_banner_cta_url_hint'))
                ->placeholder(__('filament.homepage_static.home_banner_cta_url_placeholder'))
                ->maxLength(2048)
                ->columnSpanFull(),
        ];
    }

    protected static function slideContentSchema(string $locale): array
    {
        return [
            Forms\Components\TextInput::make("title.{$locale}")
                ->label(__('filament.homepage_static.slide_title'))
                ->maxLength(160)
                ->columnSpanFull(),
            Forms\Components\RichEditor::make("description.{$locale}")
                ->label(__('filament.homepage_static.slide_description'))
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

    protected static function translateSlideContentAction(): Action
    {
        return Action::make('translateSlideContent')
            ->label(__('filament.homepage_static.translate_slide'))
            ->icon('heroicon-o-language')
            ->tooltip(__('filament.homepage_static.translate_slide'))
            ->size('sm')
            ->color('gray')
            ->action(function (Forms\Get $get, Forms\Set $set): void {
                $locales = array_keys(LaravelLocalization::getSupportedLocales());
                $title = (array) ($get('title') ?? []);
                $description = (array) ($get('description') ?? []);
                $sourceLocale = static::resolveTranslationSourceLocale($locales, $title, $description);

                if (! $sourceLocale) {
                    Notification::make()
                        ->warning()
                        ->title(__('fields.static_page.translation_source_missing'))
                        ->body(__('fields.static_page.translation_source_missing_body'))
                        ->send();

                    return;
                }

                $sourceTitle = trim((string) ($title[$sourceLocale] ?? ''));
                $sourceDescription = trim((string) ($description[$sourceLocale] ?? ''));
                $translationService = app(TranslationService::class);
                $translatedLocales = [];

                foreach ($locales as $targetLocale) {
                    if ($targetLocale === $sourceLocale) {
                        continue;
                    }

                    $localeUpdated = false;

                    if ($sourceTitle !== '' && blank(trim((string) ($title[$targetLocale] ?? '')))) {
                        $translatedTitle = $translationService->translate($sourceTitle, $sourceLocale, $targetLocale);

                        if (filled($translatedTitle)) {
                            $set("title.{$targetLocale}", $translatedTitle);
                            $localeUpdated = true;
                        }
                    }

                    if ($sourceDescription !== '' && blank(trim((string) ($description[$targetLocale] ?? '')))) {
                        $translatedDescription = $translationService->translate($sourceDescription, $sourceLocale, $targetLocale);

                        if (filled($translatedDescription)) {
                            $set("description.{$targetLocale}", $translatedDescription);
                            $localeUpdated = true;
                        }
                    }

                    if ($localeUpdated) {
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

    protected static function translateHomeBannerAction(): Action
    {
        return Action::make('translateHomeBanner')
            ->label(__('filament.homepage_static.translate_home_banner'))
            ->icon('heroicon-o-language')
            ->tooltip(__('filament.homepage_static.translate_home_banner'))
            ->size('sm')
            ->color('gray')
            ->action(function (Forms\Get $get, Forms\Set $set): void {
                $locales = array_keys(LaravelLocalization::getSupportedLocales());
                $fields = ['badge', 'headline', 'body', 'cta_label'];
                $content = collect($fields)
                    ->mapWithKeys(fn (string $field): array => [
                        $field => (array) ($get("home_banner.{$field}") ?? []),
                    ])
                    ->all();
                $sourceLocale = static::resolveTranslationSourceLocale($locales, ...array_values($content));

                if (! $sourceLocale) {
                    Notification::make()
                        ->warning()
                        ->title(__('fields.static_page.translation_source_missing'))
                        ->body(__('fields.static_page.translation_source_missing_body'))
                        ->send();

                    return;
                }

                $translationService = app(TranslationService::class);
                $translatedLocales = [];

                foreach ($locales as $targetLocale) {
                    if ($targetLocale === $sourceLocale) {
                        continue;
                    }

                    $localeUpdated = false;

                    foreach ($fields as $field) {
                        $sourceText = trim((string) ($content[$field][$sourceLocale] ?? ''));
                        $targetText = trim((string) ($content[$field][$targetLocale] ?? ''));

                        if ($sourceText === '' || $targetText !== '') {
                            continue;
                        }

                        $translatedText = $translationService->translate($sourceText, $sourceLocale, $targetLocale);

                        if (filled($translatedText)) {
                            $set("home_banner.{$field}.{$targetLocale}", $translatedText);
                            $localeUpdated = true;
                        }
                    }

                    if ($localeUpdated) {
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

    protected static function resolveTranslationSourceLocale(array $locales, array ...$contentFields): ?string
    {
        if (
            in_array('it', $locales, true)
            && collect($contentFields)->contains(fn (array $content): bool => filled($content['it'] ?? null))
        ) {
            return 'it';
        }

        foreach ($locales as $locale) {
            if (collect($contentFields)->contains(fn (array $content): bool => filled($content[$locale] ?? null))) {
                return $locale;
            }
        }

        return null;
    }

    protected static function translationTabs(callable $schemaFactory): array
    {
        return collect(LaravelLocalization::getSupportedLocales())
            ->map(fn (array $properties, string $locale): Forms\Components\Tabs\Tab => Forms\Components\Tabs\Tab::make(
                $properties['native'] ?? strtoupper($locale),
            )->schema($schemaFactory($locale)))
            ->values()
            ->all();
    }

    public function save(): void
    {
        $state = $this->form->getState();

        Setting::set(
            'home_announcement_banner',
            $state['home_banner'] ?? [],
            'events',
            __('filament.homepage_static.home_banner_setting_description'),
        );

        $this->resolveHomePage()->update([
            'label' => 'Homepage',
            'route_name' => 'home',
            'view_name' => 'home',
            'fallback_header_image_path' => 'images/FotoSanIppolito1.webp',
            'header_slides' => $state['header_slides'] ?? [],
            'admin_notes' => $state['admin_notes'] ?? null,
            'is_active' => $state['is_active'] ?? true,
        ]);

        Notification::make()
            ->success()
            ->title(__('filament.homepage_static.saved'))
            ->send();
    }

    protected function resolveHomePage(): StaticPage
    {
        return StaticPage::query()->firstOrCreate(
            ['page_key' => 'home'],
            [
                'label' => 'Homepage',
                'route_name' => 'home',
                'view_name' => 'home',
                'fallback_header_image_path' => 'images/FotoSanIppolito1.webp',
                'is_active' => true,
            ],
        );
    }
}
