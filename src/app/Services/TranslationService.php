<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

// Import helper functions for IDE support
use function Illuminate\Support\config;
use function Illuminate\Support\now;

class TranslationService
{
    /**
     * The base URL for the DeepL API
     */
    protected string $baseUrl;
    
    /**
     * API key for the DeepL service (required)
     */
    protected string $apiKey;
    
    /**
     * Cache duration for translations in minutes
     */
    protected int $cacheDuration = 1440; // 24 hours
    
    /**
     * Available languages for translation
     */
    protected array $availableLanguages = ['en', 'it'];

    /**
     * Create a new translation service instance
     */
    public function __construct()
    {
        $this->baseUrl = config('services.translation.url', 'https://api-free.deepl.com/v2/translate');
        $this->apiKey = config('services.translation.api_key');
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
        // Don't translate if source and target are the same
        if ($source === $target || empty(trim($text))) {
            return $text;
        }

        // Check if languages are supported
        // DeepL uses different language codes (en-US, en-GB, etc.) but we're keeping our simple codes
        if (!in_array($source, $this->availableLanguages) || !in_array($target, $this->availableLanguages)) {
            Log::warning('Unsupported language for translation', [
                'source' => $source,
                'target' => $target
            ]);
            return null;
        }

        // Generate a cache key for this translation
        $cacheKey = "translation:{$source}:{$target}:" . md5($text);
        
        // Check if we have a cached translation
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            // DeepL API expects 'text' instead of 'q', 'source_lang' instead of 'source',
            // and 'target_lang' instead of 'target'
            $payload = [
                'text' => [$text], // DeepL expects an array of strings
                'source_lang' => strtoupper($source), // DeepL uses uppercase language codes
                'target_lang' => strtoupper($target),
                'preserve_formatting' => 1,
            ];
            
            // DeepL requires auth key in header
            $response = Http::withHeaders([
                'Authorization' => 'DeepL-Auth-Key ' . $this->apiKey,
            ])->post($this->baseUrl, $payload);
            
            if ($response->successful()) {
                // DeepL returns translations in a different format
                $translatedText = $response->json()['translations'][0]['text'] ?? null;
                
                // Cache the result if successful
                if ($translatedText) {
                    Cache::put($cacheKey, $translatedText, now()->addMinutes($this->cacheDuration));
                }
                
                return $translatedText;
            }
            
            Log::error('Translation API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            
            return null;
        } catch (\Exception $e) {
            Log::error('Translation service exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return null;
        }
    }

    /**
     * Get available languages from the translation service
     *
     * @return array An array of available language codes
     */
    public function getAvailableLanguages(): array
    {
        return $this->availableLanguages;
    }

    /**
     * Set the API key for the translation service
     *
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * Set the base URL for the translation service
     *
     * @param string $url
     * @return $this
     */
    public function setBaseUrl(string $url): self
    {
        $this->baseUrl = $url;
        return $this;
    }
}
