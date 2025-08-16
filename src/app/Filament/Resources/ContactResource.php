<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteAction;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.contact');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.contact_plural');
    }
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation_groups.content_management');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('fields.sections.message_information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('fields.contact.name'))
                            ->disabled()
                            ->columnSpan(4),
                        Forms\Components\TextInput::make('email')
                            ->label(__('fields.contact.email'))
                            ->email()
                            ->disabled()
                            ->columnSpan(4),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('fields.contact.phone'))
                            ->disabled()
                            ->columnSpan(4),
                        Forms\Components\TextInput::make('subject')
                            ->label(__('fields.contact.subject'))
                            ->disabled()
                            ->columnSpan(8),
                        Forms\Components\TextInput::make('status')
                            ->label(__('fields.contact.status'))
                            ->disabled()
                            ->columnSpan(2),
                        Forms\Components\DateTimePicker::make('read_at')
                            ->label(__('fields.contact.read_at'))
                            ->disabled()
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('message')
                            ->label(__('fields.contact.message'))
                            ->columnSpanFull()
                            ->disabled(),
                    ])
                    ->columns(12),
                Forms\Components\Section::make(__('fields.sections.metadata'))
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label(__('fields.contact.ip_address'))
                            ->disabled()
                            ->columnSpan(6),
                        Forms\Components\TextInput::make('user_agent')
                            ->label(__('fields.contact.user_agent'))
                            ->disabled()
                            ->columnSpan(12),
                    ])
                    ->columns(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('fields.contact.name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('fields.contact.email'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('subject')
                    ->label(__('fields.contact.subject'))
                    ->searchable(),
                IconColumn::make('read')
                    ->label(__('fields.contact.read'))
                    ->state(fn (Contact $record): bool => (bool) $record->read_at)
                    ->boolean(),
                TextColumn::make('status')
                    ->label(__('fields.contact.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'processed', 'read' => 'success',
                        'archived' => 'gray',
                        default => 'secondary',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('read_at')
                    ->dateTime()
                    ->label(__('fields.contact.read_at'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('read_state')
                    ->label(__('fields.contact.read_status'))
                    ->placeholder(__('fields.any'))
                    ->trueLabel(__('fields.contact.read_messages'))
                    ->falseLabel(__('fields.contact.unread_messages'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('read_at'),
                        false: fn (Builder $query) => $query->whereNull('read_at'),
                        blank: fn (Builder $query) => $query,
                    ),
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(__('fields.contact.view')),
                Action::make('markAsRead')
                    ->label(__('fields.contact.mark_as_read'))
                    ->icon('heroicon-o-envelope-open')
                    ->visible(fn (Contact $record): bool => is_null($record->read_at))
                    ->action(fn (Contact $record) => $record->update([
                        'read_at' => now(),
                        'status' => $record->status ?: 'read',
                    ])),
                Action::make('markAsUnread')
                    ->label(__('fields.contact.mark_as_unread'))
                    ->icon('heroicon-o-envelope')
                    ->visible(fn (Contact $record): bool => ! is_null($record->read_at))
                    ->action(fn (Contact $record) => $record->update([
                        'read_at' => null,
                        'status' => $record->status === 'read' ? 'new' : $record->status,
                    ])),
                RestoreAction::make()
                    ->visible(fn (Contact $record): bool => method_exists($record, 'trashed') ? $record->trashed() : false),
                ForceDeleteAction::make()
                    ->visible(fn (Contact $record): bool => method_exists($record, 'trashed') ? $record->trashed() : false),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
