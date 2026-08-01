<?php

namespace App\Filament\Actions;

use App\Filament\Actions\Concerns\HasMassTranslation;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class TranslateBulkAction extends BulkAction
{
    use HasMassTranslation;

    public static function getDefaultName(): ?string
    {
        return 'translate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('filament.translation.bulk_label'))
            ->icon('heroicon-o-language')
            ->color('primary')
            ->modalHeading(__('filament.translation.bulk_modal_title'))
            ->modalDescription(__('filament.translation.bulk_modal_description'))
            ->modalSubmitActionLabel(__('filament.translation.bulk_submit'))
            ->form($this->massTranslationSchema())
            ->action(function (Collection $records, array $data): void {
                $this->executeMassTranslation($records, $data['target_locales'] ?? []);
            });
    }
}
