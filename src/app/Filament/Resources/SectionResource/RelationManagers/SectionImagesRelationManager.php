<?php

namespace App\Filament\Resources\SectionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectionImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';
    
    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('fields.gallery.images');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_path')
                    ->label(__('fields.common.image'))
                    ->image()
                    ->directory('section-images')
                    ->required()->downloadable()
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
                    ->optimize('webp'),
                Forms\Components\TextInput::make('caption')
                    ->label(__('fields.gallery.caption'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('display_order')
                    ->label(__('fields.section.display_order'))
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('image_path')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label(__('fields.common.image'))
                    ->square(),
                Tables\Columns\TextColumn::make('caption')
                    ->label(__('fields.gallery.caption'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_order')
                    ->label(__('fields.section.display_order'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('fields.ui.create')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('fields.ui.edit')),
                Tables\Actions\DeleteAction::make()
                    ->label(__('fields.ui.delete')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('fields.common.delete_selected')),
                ]),
            ])
            ->reorderable('display_order');
    }
}
