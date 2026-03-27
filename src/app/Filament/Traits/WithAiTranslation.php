<?php

namespace App\Filament\Traits;

use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use App\Services\TranslationService;

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
            ->tooltip('Translate from IT')
            ->size('sm')
            ->color('gray')
            ->action(function ($get, $set) use ($field) {
                $sourceText = $get("{$field}.it") ?? '';
                
                if (empty(trim($sourceText))) {
                    Notification::make()
                        ->warning()
                        ->title('No source text')
                        ->body('Please add Italian content first')
                        ->send();
                    return;
                }
                
                try {
                    $translationService = app(TranslationService::class);
                    $failed = [];
                    
                    foreach (['en', 'de'] as $target) {
                        $translated = $translationService->translate($sourceText, 'it', $target);
                        if ($translated) {
                            $set("{$field}.{$target}", $translated);
                        } else {
                            $failed[] = $target;
                        }
                    }
                    
                    empty($failed)
                        ? Notification::make()->success()->title('Translation completed')->send()
                        : Notification::make()->danger()->title('Failed for: ' . implode(', ', $failed))->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->danger()
                        ->title('Translation error')
                        ->body($e->getMessage())
                        ->send();
                }
            });
    }
}
