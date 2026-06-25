<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Arr;
use Filament\Notifications\Notification;
use App\Services\TranslationService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use function app;

class TranslateButton extends Component
{
    protected string $fieldName = '';
    
    /**
     * Set the field name to translate
     */
    public function field(string $name): static
    {
        $this->fieldName = $name;
        return $this;
    }
    
    /**
     * Create a new TranslateButton instance
     */
    public static function make(): static
    {
        return (new static())
            ->label('Traduci')
            ->icon('heroicon-o-language')
            ->color('gray')
            ->size('sm')
            ->action(function ($livewire) {
                static::handleTranslation($livewire, static::getInstance()->fieldName);
            });
    }
    
    /**
     * Handle the translation action
     */
    protected static function handleTranslation($livewire, string $fieldName): void
    {
        $locales = array_keys(LaravelLocalization::getSupportedLocales());
        $translations = data_get($livewire->data, $fieldName, []);

        [$sourceLocale, $sourceText] = static::resolveSourceTranslation($translations, $locales);
        
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
                ->filter(fn (string $locale) => blank(trim((string) data_get($translations, $locale, ''))))
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
                    data_set($livewire->data, "{$fieldName}.{$targetLocale}", $translated);
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
    }

    protected static function resolveSourceTranslation(array $translations, array $locales): array
    {
        if (in_array('it', $locales, true)) {
            $preferredText = trim((string) data_get($translations, 'it', ''));

            if ($preferredText !== '') {
                return ['it', $preferredText];
            }
        }

        foreach ($locales as $locale) {
            $text = trim((string) data_get($translations, $locale, ''));

            if ($text !== '') {
                return [$locale, $text];
            }
        }

        return [config('app.fallback_locale', 'it'), ''];
    }
}
