<?php

namespace App\Filament\Resources\GalleryItemResource\Pages;

use App\Filament\Resources\GalleryItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGalleryItem extends EditRecord
{
    protected static string $resource = GalleryItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        // Additional logic after updating a gallery item
    }
}
