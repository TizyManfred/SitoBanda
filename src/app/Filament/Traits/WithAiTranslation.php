<?php

namespace App\Filament\Traits;

use App\Services\TranslationService;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use function app;

/**
 * Adds AI translation capabilities to Filament TranslatableContainer components
 */
trait WithAiTranslation
{
    /**
     * Get the translation action for a field
     *
     * @param string $field The field name to translate
     * @return \Filament\Forms\Components\Actions\Action The translation action
     */
    public static function getTranslateAction(string $field): \Filament\Forms\Components\Actions\Action
    {
        return Action::make('translate' . ucfirst($field))
            ->label(__('filament.translation.button'))
            ->icon('heroicon-o-language')
            ->tooltip(__('filament.translation.button'))
            ->size('sm')
            ->color('gray')
            ->action(function ($livewire, $component) use ($field) {
                $fieldPath = $field;
                $locales = static::getTranslationLocales();
                $existingTranslations = data_get($livewire->data, $fieldPath, []);

                [$sourceLocale, $sourceText] = static::resolveSourceTranslation($livewire->data, $fieldPath);

                if (empty(trim($sourceText))) {
                    Notification::make()
                        ->warning()
                        ->title(__('filament.translation.source_missing'))
                        ->body(__('filament.translation.source_missing_body'))
                        ->send();
                    return;
                }

                try {
                    $translationService = app(TranslationService::class);
                    $targetLocales = collect($locales)
                        ->reject(fn (string $locale) => $locale === $sourceLocale)
                        ->filter(fn (string $locale) => blank(trim((string) data_get($existingTranslations, $locale, ''))))
                        ->values();

                    if ($targetLocales->isEmpty()) {
                        Notification::make()
                            ->warning()
                            ->title(__('filament.translation.nothing_to_update'))
                            ->body(__('filament.translation.nothing_to_update_body'))
                            ->send();

                        return;
                    }

                    $translatedLocales = [];

                    foreach ($targetLocales as $targetLocale) {
                        $translated = $translationService->translate($sourceText, $sourceLocale, $targetLocale);

                        if (filled($translated)) {
                            data_set($livewire->data, "{$fieldPath}.{$targetLocale}", $translated);
                            $translatedLocales[] = $targetLocale;
                        }
                    }

                    if ($translatedLocales === []) {
                        Notification::make()
                            ->danger()
                        ->title(__('filament.translation.failed'))
                        ->body(__('filament.translation.failed_body'))
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->success()
                    ->title(__('filament.translation.completed'))
                    ->body(__('filament.translation.completed_body', ['locales' => implode(', ', $translatedLocales)]))
                        ->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->danger()
                    ->title(__('filament.translation.error'))
                        ->body($e->getMessage())
                        ->send();
                }
            });
    }

    protected static function resolveSourceTranslation(array $data, string $field): array
    {
        $locales = static::getTranslationLocales();

        if (in_array('it', $locales, true)) {
            $preferredText = trim((string) (data_get($data, "{$field}.it") ?? ''));

            if ($preferredText !== '') {
                return ['it', $preferredText];
            }
        }

        foreach ($locales as $locale) {
            $text = trim((string) (data_get($data, "{$field}.{$locale}") ?? ''));

            if ($text !== '') {
                return [$locale, $text];
            }
        }

        return [config('app.fallback_locale', 'it'), ''];
    }

    protected static function getTranslationLocales(): array
    {
        return array_keys(LaravelLocalization::getLocalesOrder());
    }
}
