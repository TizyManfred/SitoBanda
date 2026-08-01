<?php

namespace Tests\Support;

use App\Services\TranslationService;

class FakeTranslationService extends TranslationService
{
    public function translate(string $text, string $source, string $target): ?string
    {
        if ($source === $target || trim($text) === '') {
            return $text;
        }

        return "[{$target}] {$text}";
    }
}
