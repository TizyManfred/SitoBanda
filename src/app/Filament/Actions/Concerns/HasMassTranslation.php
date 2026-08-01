<?php

namespace App\Filament\Actions\Concerns;

use App\Models\StaticPage;
use App\Services\ContentTranslationService;
use Filament\Forms\Components\CheckboxList;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use function app;

trait HasMassTranslation
{
    /** @var array<int, string> */
    protected array $translatableFields = [];

    protected bool $translateStaticPage = false;

    protected bool $includeAttachments = false;

    /**
     * @param  array<int, string>  $fields
     */
    public function translatableFields(array $fields): static
    {
        $this->translatableFields = $fields;

        return $this;
    }

    public function staticPage(): static
    {
        $this->translateStaticPage = true;

        return $this;
    }

    public function includeAttachments(): static
    {
        $this->includeAttachments = true;

        return $this;
    }

    /**
     * @return array<int, CheckboxList>
     */
    protected function massTranslationSchema(): array
    {
        return [
            CheckboxList::make('target_locales')
                ->label(__('filament.translation.bulk_targets_label'))
                ->options(fn (): array => collect(LaravelLocalization::getLocalesOrder())
                    ->reject(fn (array $properties, string $code): bool => $code === 'it')
                    ->map(fn (array $properties): string => $properties['native'])
                    ->all())
                ->default(fn (): array => array_keys(collect(LaravelLocalization::getLocalesOrder())
                    ->reject(fn (array $properties, string $code): bool => $code === 'it')
                    ->all()))
                ->columns(2)
                ->required(),
        ];
    }

    /**
     * @param  iterable<int, Model>  $records
     * @param  array<int, string>  $targets
     */
    protected function executeMassTranslation(iterable $records, array $targets): void
    {
        $service = app(ContentTranslationService::class);
        $updated = [];
        $translatedRecords = 0;

        foreach ($records as $record) {
            $before = $updated;

            if ($this->translateStaticPage && $record instanceof StaticPage) {
                $updated = $this->mergeUpdated($updated, $service->translateStaticPage($record, $targets));
            } elseif ($this->translatableFields !== []) {
                $updated = $this->mergeUpdated($updated, $service->translateModel($record, $this->translatableFields, $targets));
            }

            if ($this->includeAttachments && method_exists($record, 'attachments')) {
                foreach ($record->attachments as $attachment) {
                    $updated = $this->mergeUpdated($updated, $service->translateModel($attachment, ['title', 'description'], $targets));
                }
            }

            if ($updated !== $before) {
                $translatedRecords++;
            }
        }

        if ($updated === []) {
            Notification::make()
                ->warning()
                ->title(__('filament.translation.bulk_nothing'))
                ->body(__('filament.translation.bulk_nothing_body'))
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament.translation.bulk_completed'))
            ->body(__('filament.translation.bulk_completed_body', [
                'count' => $translatedRecords,
                'locales' => implode(', ', array_keys($updated)),
            ]))
            ->send();
    }

    /**
     * @param  array<string, int>  $current
     * @param  array<string, int>  $incoming
     * @return array<string, int>
     */
    protected function mergeUpdated(array $current, array $incoming): array
    {
        foreach ($incoming as $locale => $count) {
            $current[$locale] = ($current[$locale] ?? 0) + $count;
        }

        return $current;
    }
}
