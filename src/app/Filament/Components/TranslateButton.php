<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Arr;
use Filament\Notifications\Notification;
use App\Services\TranslationService;

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
        // Get current locale and determine source locale
        $currentLocale = $livewire->activeLocale;
        $sourceLocale = $currentLocale === 'it' ? 'en' : 'it';
        
        // Get source text from other locale
        $sourceText = data_get($livewire->data, "{$fieldName}.{$sourceLocale}") ?? '';
        
        if (empty(trim($sourceText))) {
            Notification::make()
                ->warning()
                ->title('Testo sorgente mancante')
                ->body('Inserisci prima il contenuto in un\'altra lingua.')
                ->send();
            return;
        }
        
        try {
            // Get translation service from container
            $translationService = app(TranslationService::class);
            
            $translated = $translationService->translate($sourceText, $sourceLocale, $currentLocale);
            
            if ($translated) {
                data_set($livewire->data, "{$fieldName}.{$currentLocale}", $translated);
                
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
    }
}
