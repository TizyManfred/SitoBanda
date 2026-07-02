<?php

namespace App\Filament\Resources\GalleryAlbumResource\Pages;

use App\Filament\Resources\GalleryAlbumResource;
use App\Models\Event;
use App\Models\GalleryAlbum;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;

class ListGalleryAlbums extends ListRecords
{
    protected static string $resource = GalleryAlbumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ActionGroup::make([
                Actions\CreateAction::make()
                    ->label(__('fields.gallery.create_empty'))
                    ->icon('heroicon-o-plus'),
                Actions\Action::make('createFromEvent')
                    ->label(__('fields.gallery.create_from_event'))
                    ->icon('heroicon-o-calendar-days')
                    ->modalHeading(__('fields.gallery.create_from_event'))
                    ->modalSubmitActionLabel(__('fields.gallery.create_from_event_submit'))
                    ->form([
                        Forms\Components\Select::make('event_id')
                            ->label(__('fields.gallery.source_event'))
                            ->options(fn (): array => Event::query()
                                ->orderByDesc('start_datetime')
                                ->get()
                                ->mapWithKeys(fn (Event $event): array => [
                                    $event->id => static::getEventOptionLabel($event),
                                ])
                                ->all())
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data): void {
                        $event = Event::findOrFail($data['event_id']);

                        $album = DB::transaction(function () use ($event): GalleryAlbum {
                            $album = GalleryAlbum::create([
                                'title' => $event->getTranslations('title'),
                                'description' => $event->getTranslations('description'),
                                'start_date' => $event->start_datetime?->toDateString(),
                                'end_date' => $event->end_datetime?->toDateString(),
                                'is_published' => true,
                                'view_count' => 0,
                            ]);

                            $event->galleryAlbum()->associate($album);
                            $event->save();

                            return $album;
                        });

                        Notification::make()
                            ->title(__('fields.gallery.created_from_event_success'))
                            ->success()
                            ->send();

                        $this->redirect(GalleryAlbumResource::getUrl('edit', ['record' => $album]));
                    }),
            ])
                ->label(__('fields.gallery.create'))
                ->icon('heroicon-o-plus')
                ->button(),
        ];
    }

    protected static function getEventOptionLabel(Event $event): string
    {
        $locale = app()->getLocale();
        $fallbackLocale = config('app.fallback_locale');

        $title = $event->getTranslation('title', $locale, false)
            ?: $event->getTranslation('title', $fallbackLocale, false)
            ?: collect($event->getTranslations('title'))->filter()->first()
            ?: __('fields.event.title');

        $date = $event->start_datetime?->format('d/m/Y');

        return $date ? "{$title} ({$date})" : $title;
    }
}
