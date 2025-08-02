<?php

namespace App\Filament\Resources\RepertoireResource\Pages;

use App\Filament\Resources\RepertoireResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRepertoires extends ListRecords
{
    protected static string $resource = RepertoireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
