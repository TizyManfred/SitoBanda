<?php

namespace App\Filament\Resources\RepertoireYearResource\Pages;

use App\Filament\Resources\RepertoireYearResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRepertoireYears extends ListRecords
{
    protected static string $resource = RepertoireYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
