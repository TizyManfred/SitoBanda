<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    protected GoogleTranslate $translator;
    
    protected int $cacheDuration = 1440;
    
    protected array $availableLanguages = ['en', 'it', 'de'];

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    /**
     * Translate text from one language to another
     *
     * @param string $text The text to translate
     * @param string $source The source language code
     * @param string $target The target language code
     * @return string|null The translated text or null on failure
     */
    public function translate(string $text, string $source, string $target): ?string
    {
        if ($source === $target || empty(trim($text))) {
            return $text;
        }

        if (!in_array($source, $this->availableLanguages) || !in_array($target, $this->availableLanguages)) {
            Log::warning('Unsupported language for translation', [
                'source' => $source,
                'target' => $target
            ]);
            return null;
        }

        $cacheKey = "translation:{$source}:{$target}:" . md5($text);
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $this->translator->setSource($source);
            $this->translator->setTarget($target);
            
            $translatedText = $this->translator->translate($text);
            
            if ($translatedText) {
                Cache::put($cacheKey, $translatedText, now()->addMinutes($this->cacheDuration));
            }
            
            return $translatedText;
        } catch (\Exception $e) {
            Log::error('Translation service exception', [
                'message' => $e->getMessage(),
                'source' => $source,
                'target' => $target,
            ]);
            
            return null;
        }
    }

    /**
     * Translate an array of strings
     *
     * @param array $texts Array of texts to translate
     * @param string $source Source language code
     * @param string $target Target language code
     * @return array Translated texts
     */
    public function translateBatch(array $texts, string $source, string $target): array
    {
        $results = [];
        
        foreach ($texts as $key => $text) {
            $results[$key] = $this->translate($text, $source, $target);
        }
        
        return $results;
    }

    /**
     * Translate JSON translatable fields
     *
     * @param array $data JSON data with locale keys
     * @param string $sourceLocale Source locale
     * @param string $targetLocale Target locale
     * @return array Updated data with translation
     */
    public function translateJsonField(array $data, string $sourceLocale, string $targetLocale): array
    {
        if (!isset($data[$sourceLocale]) || isset($data[$targetLocale])) {
            return $data;
        }

        $translated = $this->translate($data[$sourceLocale], $sourceLocale, $targetLocale);
        
        if ($translated) {
            $data[$targetLocale] = $translated;
        }
        
        return $data;
    }

    public function getAvailableLanguages(): array
    {
        return $this->availableLanguages;
    }

    public function setCacheDuration(int $minutes): self
    {
        $this->cacheDuration = $minutes;
        return $this;
    }
}
