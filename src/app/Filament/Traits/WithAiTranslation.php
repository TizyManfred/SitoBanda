<?php

namespace App\Filament\Traits;

use App\Services\TranslationService;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Import helpers for IDE support
use function Illuminate\Support\data_get;
use function Illuminate\Support\data_set;
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
                $currentLocale = $livewire->activeLocale;
                $fieldPath = $field;

                [$sourceLocale, $sourceText] = static::resolveSourceTranslation($livewire->data, $fieldPath, $currentLocale);
                
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
                    $translated = $translationService->translate($sourceText, $sourceLocale, $currentLocale);
                    
                    if ($translated) {
                        data_set($livewire->data, "{$fieldPath}.{$currentLocale}", $translated);
                        
                        Notification::make()
                            ->success()
                            ->title('Traduzione completata')
                            ->send();
                    } else {
                        Notification::make()
                            ->danger()
                            ->title('Traduzione non riuscita')
                            ->body('Impossibile tradurre il testo. Riprova più tardi.')
                            ->send();
                    }
                } catch (\Exception $e) {
                    Notification::make()
                        ->danger()
                        ->title('Errore di traduzione')
                        ->body($e->getMessage())
                        ->send();
                }
            });
    }

    protected static function resolveSourceTranslation(array $data, string $field, string $currentLocale): array
    {
        $locales = array_keys(LaravelLocalization::getSupportedLocales());

        if (in_array('it', $locales, true) && $currentLocale !== 'it') {
            $preferredText = trim((string) (data_get($data, "{$field}.it") ?? ''));

            if ($preferredText !== '') {
                return ['it', $preferredText];
            }
        }

        foreach ($locales as $locale) {
            if ($locale === $currentLocale) {
                continue;
            }

            $text = trim((string) (data_get($data, "{$field}.{$locale}") ?? ''));

            if ($text !== '') {
                return [$locale, $text];
            }
        }

        return [$currentLocale, ''];
    }
}
