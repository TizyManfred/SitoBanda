<?php

namespace App\Filament\Actions;

use App\Filament\Actions\Concerns\HasMassTranslation;
use Filament\Tables\Actions\Action;

class TranslateAllAction extends Action
{
    use HasMassTranslation;

    protected ?string $modelClass = null;

    public function modelClass(string $model): static
    {
        $this->modelClass = $model;

        return $this;
    }

    public static function getDefaultName(): ?string
    {
        return 'translateAll';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('filament.translation.bulk_all_label'))
            ->icon('heroicon-o-language')
            ->color('primary')
            ->modalHeading(__('filament.translation.bulk_modal_title'))
            ->modalDescription(__('filament.translation.bulk_modal_description'))
            ->modalSubmitActionLabel(__('filament.translation.bulk_submit'))
            ->form($this->massTranslationSchema())
            ->action(function (array $data): void {
                $model = $this->modelClass;

                if (! $model || ! class_exists($model)) {
                    return;
                }

                $this->executeMassTranslation($model::query()->get(), $data['target_locales'] ?? []);
            });
    }
}
