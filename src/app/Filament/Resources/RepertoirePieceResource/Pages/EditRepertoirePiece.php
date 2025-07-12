<?php

namespace App\Filament\Resources\RepertoirePieceResource\Pages;

use App\Filament\Resources\RepertoirePieceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRepertoirePiece extends EditRecord
{
    protected static string $resource = RepertoirePieceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
