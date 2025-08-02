<?php

namespace App\Filament\Resources\RepertoireResource\Pages;

use App\Filament\Resources\RepertoireResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRepertoire extends EditRecord
{
    protected static string $resource = RepertoireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
