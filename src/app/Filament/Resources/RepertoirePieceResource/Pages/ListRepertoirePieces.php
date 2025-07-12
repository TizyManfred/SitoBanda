<?php

namespace App\Filament\Resources\RepertoirePieceResource\Pages;

use App\Filament\Resources\RepertoirePieceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRepertoirePieces extends ListRecords
{
    protected static string $resource = RepertoirePieceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
