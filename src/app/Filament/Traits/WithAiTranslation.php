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
            ->label('Traduci')
            ->icon('heroicon-o-language')
            ->tooltip('Traduci')
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
                        ->title('Testo sorgente mancante')
                        ->body('Inserisci prima il contenuto in un\'altra lingua.')
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
                            ->title('Nessuna traduzione da completare')
                            ->body('Tutte le lingue disponibili per questo campo hanno gia un valore.')
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
                            ->title('Traduzione non riuscita')
                            ->body('Impossibile tradurre il testo. Riprova più tardi.')
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->success()
                        ->title('Traduzione completata')
                        ->body('Lingue aggiornate: ' . implode(', ', $translatedLocales))
                        ->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->danger()
                        ->title('Errore di traduzione')
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
        return array_keys(LaravelLocalization::getSupportedLocales());
    }
}
