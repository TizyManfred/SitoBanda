<?php

namespace App\Filament\Traits;

use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use App\Services\TranslationService;

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
            ->icon('heroicon-o-language')
            ->tooltip('AI Translate')
            ->size('sm')
            ->color('gray')
            ->action(function ($livewire, $component) use ($field) {
                // Get current locale and determine source locale
                $currentLocale = $livewire->activeLocale;
                $sourceLocale = $currentLocale === 'it' ? 'en' : 'it';
                
                // Path to the data in the form using dot notation
                $fieldPath = $field;
                
                // Get source text from other locale
                $sourceText = data_get($livewire->data, "{$fieldPath}.{$sourceLocale}") ?? '';
                
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
                        data_set($livewire->data, "{$fieldPath}.{$currentLocale}", $translated);
                        
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
            });
    }
}
