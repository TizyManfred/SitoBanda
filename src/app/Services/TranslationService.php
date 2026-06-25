<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    protected int $cacheDuration = 1440;

    protected array $availableLanguages;

    protected array $httpOptions;

    protected ?string $customUrl;

    public function __construct()
    {
        $this->availableLanguages = array_keys(config('laravellocalization.supportedLocales', []));
        $this->httpOptions = [
            'timeout' => (float) config('services.translation.timeout', 10),
        ];
        $this->customUrl = config('services.translation.url');
    }

    public function translate(string $text, string $source, string $target): ?string
    {
        if ($source === $target || empty(trim($text))) {
            return $text;
        }

        if (! in_array($source, $this->availableLanguages, true) || ! in_array($target, $this->availableLanguages, true)) {
            Log::warning('Unsupported language for translation', [
                'source' => $source,
                'target' => $target,
            ]);

            return null;
        }

        $cacheKey = "translation:google:{$source}:{$target}:" . md5($text);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $translator = new GoogleTranslate($target, $source, $this->httpOptions, preserveParameters: true);

            if (filled($this->customUrl)) {
                $translator->setUrl($this->customUrl);
            }

            $translatedText = $translator->translate($text);

            if (filled($translatedText)) {
                Cache::put($cacheKey, $translatedText, now()->addMinutes($this->cacheDuration));
            }

            return $translatedText;
        } catch (\Throwable $e) {
            Log::error('Translation service exception', [
                'message' => $e->getMessage(),
                'source' => $source,
                'target' => $target,
            ]);

            return null;
        }
    }

    public function getAvailableLanguages(): array
    {
        return $this->availableLanguages;
    }

    public function setBaseUrl(?string $url): self
    {
        $this->customUrl = $url;

        return $this;
    }
}
