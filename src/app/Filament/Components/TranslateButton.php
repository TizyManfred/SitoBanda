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
            ->label('AI Translate')
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
            // Show notification if there's no source text to translate
            Notification::make()
                ->warning()
                ->title('No source text')
                ->body('Please add content in ' . strtoupper($sourceLocale) . ' first')
                ->send();
            return;
        }
        
        try {
            // Get translation service from container
            $translationService = app(TranslationService::class);
            
            // Call translation service to translate text
            $translated = $translationService->translate($sourceText, $sourceLocale, $currentLocale);
            
            if ($translated) {
                // Update form data with translated text
                data_set($livewire->data, "{$fieldName}.{$currentLocale}", $translated);
                
                // Show success notification
                Notification::make()
                    ->success()
                    ->title('Translation completed')
                    ->send();
            } else {
                // Show error notification
                Notification::make()
                    ->danger()
                    ->title('Translation failed')
                    ->body('Could not translate text. Please try again later.')
                    ->send();
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            Notification::make()
                ->danger()
                ->title('Translation error')
                ->body($e->getMessage())
                ->send();
        }
    }
}
