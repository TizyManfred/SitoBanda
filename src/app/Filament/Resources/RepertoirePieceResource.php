<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepertoirePieceResource\Pages;
use App\Models\RepertoirePiece;
use App\Models\RepertoireProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RepertoirePieceResource extends Resource
{
    protected static ?string $model = RepertoirePiece::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationGroup = 'Repertorio';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $navigationLabel = 'Brani';
    
    protected static ?string $modelLabel = 'Brano';
    
    protected static ?string $pluralModelLabel = 'Brani';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('repertoire_program_id')
                    ->label(__('fields.repertoire_piece.program'))
                    ->options(function () {
                        return RepertoireProgram::orderBy('year', 'desc')
                            ->orderBy('display_order')
                            ->get()
                            ->pluck('name', 'id');
                    })
                    ->required()
                    ->searchable(),
                    
                Forms\Components\TextInput::make('title')
                    ->label(__('fields.repertoire_piece.title'))
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('composer')
                    ->label(__('fields.repertoire_piece.composer'))
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('arranger')
                    ->label(__('fields.repertoire_piece.arranger'))
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('genre')
                    ->label(__('fields.repertoire_piece.genre'))
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('duration')
                    ->label(__('fields.repertoire_piece.duration'))
                    ->placeholder('MM:SS')
                    ->maxLength(10),
                    
                Forms\Components\Textarea::make('description')
                    ->label(__('fields.repertoire_piece.description'))
                    ->columnSpanFull(),
                    
                Forms\Components\TextInput::make('display_order')
                    ->label(__('fields.repertoire_piece.display_order'))
                    ->integer()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('fields.repertoire_piece.title'))
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('program.name')
                    ->label(__('fields.repertoire_piece.program'))
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('composer')
                    ->label(__('fields.repertoire_piece.composer'))
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('arranger')
                    ->label(__('fields.repertoire_piece.arranger'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('duration')
                    ->label(__('fields.repertoire_piece.duration')),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('fields.common.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('repertoire_program_id')
                    ->label(__('fields.repertoire_piece.program'))
                    ->options(function () {
                        return RepertoireProgram::orderBy('year', 'desc')
                            ->orderBy('display_order')
                            ->get()
                            ->pluck('name', 'id');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-musical-note';
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hide from navigation as we'll manage pieces via relation manager
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepertoirePieces::route('/'),
            'create' => Pages\CreateRepertoirePiece::route('/create'),
            'edit' => Pages\EditRepertoirePiece::route('/{record}/edit'),
        ];
    }
}
