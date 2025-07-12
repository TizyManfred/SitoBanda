<?php

namespace App\Filament\Resources\RepertoireProgramResource\Pages;

use App\Filament\Resources\RepertoireProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRepertoirePrograms extends ListRecords
{
    protected static string $resource = RepertoireProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
