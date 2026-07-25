<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = null;

    protected static ?string $modelLabel = null;

    protected static ?string $pluralModelLabel = null;

    public static function getNavigationLabel(): string
    {
        return __('filament.navigation.settings');
    }

    public static function getModelLabel(): string
    {
        return __('filament.settings.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.settings.models');
    }

    protected static ?int $navigationSort = 100;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament.settings.general_section'))
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label(__('filament.settings.key'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('group')
                            ->label(__('filament.settings.group'))
                            ->options(self::getGroupOptions())
                            ->required()
                            ->default('general')
                            ->live(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('filament.settings.description'))
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make(__('filament.settings.values'))
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema(fn (Forms\Get $get): array => self::getValueSchema($get('group') ?? 'general'))
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function normalizeValueForGroup(?string $group, mixed $value): array
    {
        $value = is_array($value) ? $value : [];

        return match ($group) {
            'contact' => self::onlyKeys($value, ['phone', 'email', 'whatsapp', 'address']),
            'social' => self::onlyKeys($value, ['facebook', 'youtube', 'instagram', 'spotify']),
            'courses' => self::normalizeCoursesValue($value),
            'analytics' => self::onlyKeys($value, ['enabled', 'provider', 'ga4_measurement_id', 'ga4_property_id', 'plausible_domain', 'plausible_script_url']),
            'general' => self::onlyKeys($value, ['title', 'tagline', 'description', 'logo_url']),
            default => $value,
        };
    }

    protected static function getValueSchema(string $group): array
    {
        return match ($group) {
            'contact' => [
                Forms\Components\Group::make([
                    Forms\Components\TextInput::make('value.phone')
                        ->label(__('fields.common.phone'))
                        ->tel(),
                    Forms\Components\TextInput::make('value.email')
                        ->label(__('fields.common.email'))
                        ->email(),
                    Forms\Components\TextInput::make('value.whatsapp')
                        ->label(__('filament.settings.whatsapp'))
                        ->tel(),
                    Forms\Components\Textarea::make('value.address')
                        ->label(__('fields.common.address'))
                        ->rows(2),
                ])->columns(2),
            ],
            'social' => [
                Forms\Components\Group::make([
                    Forms\Components\TextInput::make('value.facebook')
                        ->label('Facebook')
                        ->url()
                        ->prefixIcon('heroicon-m-globe-alt'),
                    Forms\Components\TextInput::make('value.youtube')
                        ->label('YouTube')
                        ->url()
                        ->prefixIcon('heroicon-m-globe-alt'),
                    Forms\Components\TextInput::make('value.instagram')
                        ->label('Instagram')
                        ->url()
                        ->prefixIcon('heroicon-m-globe-alt'),
                    Forms\Components\TextInput::make('value.spotify')
                        ->label('Spotify')
                        ->url()
                        ->prefixIcon('heroicon-m-globe-alt'),
                ])->columns(2),
            ],
            'courses' => [
                Forms\Components\Group::make([
                    Forms\Components\DatePicker::make('value.start_date')
                        ->label(__('filament.settings.start_date')),
                    Forms\Components\DatePicker::make('value.end_date')
                        ->label(__('filament.settings.end_date')),
                    Forms\Components\DatePicker::make('value.expiration_date')
                        ->label(__('filament.settings.expiration_date')),
                    Forms\Components\TextInput::make('value.contact_email')
                        ->label(__('filament.settings.contact_email'))
                        ->email(),
                    Forms\Components\TextInput::make('value.phone')
                        ->label(__('filament.settings.contact_phone'))
                        ->tel(),
                    Forms\Components\Textarea::make('value.price')
                        ->label(__('filament.settings.price')),
                    Forms\Components\TextInput::make('value.forms_link')
                        ->label(__('filament.settings.forms_link')),
                    Forms\Components\TextInput::make('value.location')
                        ->label(__('fields.event.location'))
                        ->columnSpanFull(),
                    Forms\Components\Repeater::make('value.testimonials')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label(__('fields.common.name')),
                            Forms\Components\Textarea::make('text')
                                ->label(__('filament.settings.text')),
                        ])
                        ->columns(1)
                        ->columnSpanFull(),
                ])->columns(2),
            ],
            'analytics' => [
                Forms\Components\Group::make([
                    Forms\Components\Toggle::make('value.enabled')
                        ->label(__('filament.settings.enable_analytics'))
                        ->default(false)
                        ->live(),
                    Forms\Components\Select::make('value.provider')
                        ->label(__('filament.settings.provider'))
                        ->options([
                            'none' => __('filament.settings.none'),
                            'ga4' => 'Google Analytics 4',
                            'plausible' => 'Plausible',
                        ])
                        ->default('none')
                        ->live(),
                    Forms\Components\TextInput::make('value.ga4_measurement_id')
                        ->label('GA4 Measurement ID')
                        ->placeholder('G-XXXXXXXXXX')
                        ->visible(fn (Forms\Get $get): bool => ($get('value.provider') ?? 'none') === 'ga4'),
                    Forms\Components\TextInput::make('value.ga4_property_id')
                        ->label('GA4 Property ID')
                        ->placeholder('123456789')
                        ->visible(fn (Forms\Get $get): bool => ($get('value.provider') ?? 'none') === 'ga4'),
                    Forms\Components\TextInput::make('value.plausible_domain')
                        ->label('Plausible Domain')
                        ->placeholder('bandacastellotesino.it')
                        ->visible(fn (Forms\Get $get): bool => ($get('value.provider') ?? 'none') === 'plausible'),
                    Forms\Components\TextInput::make('value.plausible_script_url')
                        ->label('Plausible Script URL')
                        ->placeholder('https://plausible.io/js/script.js')
                        ->default('https://plausible.io/js/script.js')
                        ->url()
                        ->visible(fn (Forms\Get $get): bool => ($get('value.provider') ?? 'none') === 'plausible'),
                ])->columns(2),
            ],
            'general' => [
                Forms\Components\Group::make([
                    Forms\Components\TextInput::make('value.title')
                        ->label(__('filament.settings.site_title'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('value.tagline')
                        ->label(__('filament.settings.tagline'))
                        ->maxLength(255),
                    Forms\Components\Textarea::make('value.description')
                        ->label(__('filament.settings.description'))
                        ->rows(3),
                    Forms\Components\TextInput::make('value.logo_url')
                        ->label(__('filament.settings.logo_url'))
                        ->url(),
                ])->columns(2),
            ],
            default => [
                Forms\Components\KeyValue::make('value')
                    ->label(__('filament.settings.values'))
                    ->keyLabel('Chiave')
                    ->valueLabel('Valore'),
            ],
        };
    }

    protected static function getGroupOptions(): array
    {
        return [
            'general' => __('filament.settings.groups.general'),
            'contact' => __('filament.settings.groups.contact'),
            'social' => __('filament.settings.groups.social'),
            'courses' => __('filament.settings.groups.courses'),
            'analytics' => __('filament.settings.groups.analytics'),
            'events' => __('filament.settings.groups.events'),
            'media' => __('filament.settings.groups.media'),
        ];
    }

    protected static function onlyKeys(array $value, array $keys): array
    {
        return array_filter(
            array_intersect_key($value, array_flip($keys)),
            fn ($item) => !($item === null || $item === '')
        );
    }

    protected static function normalizeCoursesValue(array $value): array
    {
        $normalized = self::onlyKeys($value, [
            'start_date',
            'end_date',
            'expiration_date',
            'contact_email',
            'phone',
            'price',
            'forms_link',
            'location',
            'testimonials',
        ]);

        $normalized['testimonials'] = array_values(array_filter(
            $normalized['testimonials'] ?? [],
            fn ($testimonial) => is_array($testimonial)
                && (($testimonial['name'] ?? '') !== '' || ($testimonial['text'] ?? '') !== '')
        ));

        return $normalized;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label(__('filament.settings.key'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('group')
                    ->label(__('filament.settings.group'))
                    ->colors([
                        'primary' => 'general',
                        'success' => 'contact',
                        'warning' => 'social',
                        'info' => 'courses',
                        'gray' => 'analytics',
                        'danger' => 'events',
                        'secondary' => 'media',
                    ]),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('filament.settings.description'))
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = (string) $column->getState();

                        if (strlen($state) <= 50) {
                            return null;
                        }

                        return $state;
                    }),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament.settings.updated_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label(__('filament.settings.group'))
                    ->options(self::getGroupOptions()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('group')
            ->groups([
                Tables\Grouping\Group::make('group')
                    ->label(__('filament.settings.group'))
                    ->collapsible(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
