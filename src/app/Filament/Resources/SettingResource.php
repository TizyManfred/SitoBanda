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

    protected static ?string $navigationLabel = 'Impostazioni';

    protected static ?string $modelLabel = 'Impostazione';

    protected static ?string $pluralModelLabel = 'Impostazioni';

    protected static ?int $navigationSort = 100;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informazioni Generali')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Chiave')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        
                        Forms\Components\Select::make('group')
                            ->label('Gruppo')
                            ->options([
                                'general' => 'Generale',
                                'contact' => 'Contatti',
                                'social' => 'Social Media',
                                'courses' => 'Corsi',
                                'events' => 'Eventi',
                                'media' => 'Media',
                            ])
                            ->required()
                            ->default('general'),
                        
                        Forms\Components\Textarea::make('description')
                            ->label('Descrizione')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Valori')
                    ->schema([
                        self::getValueFieldsForGroup(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected static function getValueFieldsForGroup(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            // Contact Info Fields
            Forms\Components\Group::make([
                Forms\Components\TextInput::make('phone')
                    ->label('Telefono')
                    ->tel(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email(),
                Forms\Components\TextInput::make('whatsapp')
                    ->label('WhatsApp')
                    ->tel(),
                Forms\Components\Textarea::make('address')
                    ->label('Indirizzo')
                    ->rows(2),
            ])
            ->statePath('value')
            ->visible(fn (Forms\Get $get): bool => $get('group') === 'contact')
            ->columns(2),

            // Social Links Fields
            Forms\Components\Group::make([
                Forms\Components\TextInput::make('facebook')
                    ->label('Facebook')
                    ->url()
                    ->prefixIcon('heroicon-m-globe-alt'),
                Forms\Components\TextInput::make('youtube')
                    ->label('YouTube')
                    ->url()
                    ->prefixIcon('heroicon-m-globe-alt'),
                Forms\Components\TextInput::make('instagram')
                    ->label('Instagram')
                    ->url()
                    ->prefixIcon('heroicon-m-globe-alt'),
                Forms\Components\TextInput::make('spotify')
                    ->label('Spotify')
                    ->url()
                    ->prefixIcon('heroicon-m-globe-alt'),
            ])
            ->statePath('value')
            ->visible(fn (Forms\Get $get): bool => $get('group') === 'social')
            ->columns(2),

            // Course Info Fields
            Forms\Components\Group::make([
                Forms\Components\DatePicker::make('start_date')
                    ->label('Data Inizio'),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Data Fine'),
                Forms\Components\DatePicker::make('expiration_date')
                    ->label('Scadenza Iscrizioni'),
                Forms\Components\TextInput::make('contact_email')
                    ->label('Email Contatto')
                    ->email(),
                Forms\Components\TextInput::make('phone')
                    ->label('Telefono Contatto')
                    ->tel(),
                Forms\Components\TextArea::make('price')
                    ->label('Prezzo'),
                Forms\Components\TextInput::make('forms_link')
                    ->label('Link Form'),
                Forms\Components\TextInput::make('location')
                    ->label('Luogo')
                    ->columnSpanFull(),
                Forms\Components\Group::make([
                    Forms\Components\Repeater::make('testimonials')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nome'),
                            Forms\Components\TextArea::make('text')
                                ->label('Testo'),
                        ])
                        ->columns(1)
                ])
                ->columnSpanFull(),
            ])
            ->statePath('value')
            ->visible(fn (Forms\Get $get): bool => $get('group') === 'courses')
            ->columns(2),

            // Site Info Fields
            Forms\Components\Group::make([
                Forms\Components\TextInput::make('title')
                    ->label('Titolo Sito')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tagline')
                    ->label('Slogan')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Descrizione')
                    ->rows(3),
                Forms\Components\TextInput::make('logo_url')
                    ->label('URL Logo')
                    ->url(),
            ])
            ->statePath('value')
            ->visible(fn (Forms\Get $get): bool => $get('group') === 'general')
            ->columns(2),

            // Generic JSON editor for other groups
            Forms\Components\KeyValue::make('value')
                ->label('Valori')
                ->keyLabel('Chiave')
                ->valueLabel('Valore')
                ->visible(fn (Forms\Get $get): bool => !in_array($get('group'), ['contact', 'social', 'courses', 'general'])),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Chiave')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('group')
                    ->label('Gruppo')
                    ->colors([
                        'primary' => 'general',
                        'success' => 'contact',
                        'warning' => 'social',
                        'info' => 'courses',
                        'danger' => 'events',
                        'secondary' => 'media',
                    ]),
                
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrizione')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Aggiornato')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('Gruppo')
                    ->options([
                        'general' => 'Generale',
                        'contact' => 'Contatti',
                        'social' => 'Social Media',
                        'courses' => 'Corsi',
                        'events' => 'Eventi',
                        'media' => 'Media',
                    ]),
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
                    ->label('Gruppo')
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
