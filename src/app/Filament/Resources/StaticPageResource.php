<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaticPageResource\Pages;
use App\Models\StaticPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                                    ->options(StaticPage::PAGE_OPTIONS)
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
                    ])
                    ->columnSpan(['lg' => 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('fields.static_page.header_image'))
                            ->schema([
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
                                    ->optimize('webp')
                                    ->helperText(__('fields.static_page.header_image_path_helper')),
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

    public static function table(Table $table): Table
    {
        return $table
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
            ->bulkActions([])
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
