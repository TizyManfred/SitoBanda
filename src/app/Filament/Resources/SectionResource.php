<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Filament\Resources\SectionResource\RelationManagers;
use App\Models\Section;
use App\Services\TranslationService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\TrashedFilter;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.section');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.section_plural');
    }
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.content_management');
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        TranslatableContainer::make(
                            Forms\Components\TextInput::make('name')
                                ->label(__('fields.section.name'))
                                ->required()
                                ->maxLength(255)
                        )->columnSpan(5),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('translateName')
                                ->icon('heroicon-o-language')
                                ->tooltip('Translate from IT')
                                ->size('sm')
                                ->color('gray')
                                ->action(function ($get, $set) {
                                    $sourceText = $get('name.it') ?? '';
                                    if (empty(trim($sourceText))) {
                                        Notification::make()->warning()->title('No source text')->body('Please add an Italian name first')->send();
                                        return;
                                    }
                                    $translationService = app(TranslationService::class);
                                    $failed = [];
                                    foreach (['en', 'de'] as $target) {
                                        $translated = $translationService->translate($sourceText, 'it', $target);
                                        $translated ? $set('name.' . $target, $translated) : $failed[] = $target;
                                    }
                                    empty($failed)
                                        ? Notification::make()->success()->title('Name translated')->send()
                                        : Notification::make()->danger()->title('Failed for: ' . implode(', ', $failed))->send();
                                })
                        ])->columnSpan(1),
                    ])->columns(6),
                Forms\Components\TextInput::make('icon_class')
                    ->label(__('fields.section.icon_class'))
                    ->maxLength(255)
                    ->helperText(__('fields.section.icon_helper')),
                Forms\Components\TextInput::make('display_order')
                    ->label(__('fields.section.display_order'))
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('fields.section.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('icon_class')
                    ->label(__('fields.section.icon'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_order')
                    ->label(__('fields.section.display_order'))
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('display_order');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MembersRelationManager::class,
            RelationManagers\SectionImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
