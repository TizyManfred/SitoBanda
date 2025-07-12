<?php

namespace App\Filament\Resources\RepertoireYearResource\Pages;

use App\Filament\Resources\RepertoireYearResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRepertoireYear extends EditRecord
{
    protected static string $resource = RepertoireYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
