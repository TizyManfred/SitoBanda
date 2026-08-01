<?php

namespace App\Services;

use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Model;

class ContentTranslationService
{
    public function __construct(
        protected TranslationService $translationService,
    ) {}

    /**
     * Translate the given translatable fields of one record into the missing target locales.
     *
     * @param  array<int, string>  $fields
     * @param  array<int, string>  $targetLocales
     * @return array<string, int> Locale code => number of translated values
     */
    public function translateModel(
        Model $model,
        array $fields,
        array $targetLocales,
        bool $force = false,
        string $source = 'it',
    ): array {
        $targetLocales = $this->normalizeTargets($targetLocales, $source);
        $updated = [];

        if ($targetLocales === []) {
            return $updated;
        }

        foreach ($fields as $field) {
            $translations = $model->getTranslations($field);

            if (! is_array($translations)) {
                continue;
            }

            $before = $translations;
            $this->translateMap($translations, $source, $targetLocales, $force, $updated);

            if ($translations !== $before) {
                $model->setTranslations($field, $translations);
            }
        }

        if ($updated !== []) {
            $model->save();
        }

        return $updated;
    }

    /**
     * Translate the nested content of a static page (HTML content, content blocks, header slides).
     *
     * @param  array<int, string>  $targetLocales
     * @return array<string, int> Locale code => number of translated values
     */
    public function translateStaticPage(
        StaticPage $page,
        array $targetLocales,
        bool $force = false,
        string $source = 'it',
    ): array {
        $targetLocales = $this->normalizeTargets($targetLocales, $source);
        $updated = [];

        if ($targetLocales === []) {
            return $updated;
        }

        $contentHtml = $page->getTranslations('content_html');

        if (is_array($contentHtml)) {
            $before = $contentHtml;
            $this->translateMap($contentHtml, $source, $targetLocales, $force, $updated);

            if ($contentHtml !== $before) {
                $page->setTranslations('content_html', $contentHtml);
            }
        }

        $contentBlocks = is_array($page->content_blocks) ? $page->content_blocks : [];

        foreach ($contentBlocks as &$block) {
            if (! is_array($block)) {
                continue;
            }

            foreach (['title', 'body'] as $field) {
                if (! array_key_exists($field, $block)) {
                    continue;
                }

                $this->translateNestedValue($block[$field], $source, $targetLocales, $force, $updated);
            }

            $imageItems = $block['image_items'] ?? null;

            if (! is_array($imageItems)) {
                continue;
            }

            foreach ($block['image_items'] as &$imageItem) {
                if (! is_array($imageItem) || ! array_key_exists('description', $imageItem)) {
                    continue;
                }

                $this->translateNestedValue($imageItem['description'], $source, $targetLocales, $force, $updated);
            }
            unset($imageItem);
        }
        unset($block);

        $headerSlides = is_array($page->header_slides) ? $page->header_slides : [];

        foreach ($headerSlides as &$slide) {
            if (! is_array($slide)) {
                continue;
            }

            foreach (['title', 'description'] as $field) {
                if (! array_key_exists($field, $slide)) {
                    continue;
                }

                $this->translateNestedValue($slide[$field], $source, $targetLocales, $force, $updated);
            }
        }
        unset($slide);

        if ($updated !== []) {
            $page->content_blocks = $contentBlocks;
            $page->header_slides = $headerSlides;
            $page->save();
        }

        return $updated;
    }

    /**
     * Translate one localized value in place, converting plain strings into localized maps.
     *
     * @param  array<string, mixed>  $targetLocales
     */
    protected function translateNestedValue(
        mixed &$value,
        string $source,
        array $targetLocales,
        bool $force,
        array &$updated,
    ): void {
        if (is_string($value) && filled(trim($value))) {
            $value = [$source => $value];
        }

        if (! is_array($value)) {
            return;
        }

        $this->translateMap($value, $source, $targetLocales, $force, $updated);
    }

    /**
     * Translate one localized value map in place, skipping locales that already have a value.
     *
     * @param  array<string, mixed>  $values
     * @param  array<int, string>  $targetLocales
     * @param  array<string, int>  $updated
     */
    protected function translateMap(
        array &$values,
        string $source,
        array $targetLocales,
        bool $force,
        array &$updated,
    ): void {
        [$sourceLocale, $sourceText] = $this->resolveSource($values, $source);

        if ($sourceText === '') {
            return;
        }

        foreach ($targetLocales as $target) {
            if (! $force && filled(trim((string) ($values[$target] ?? '')))) {
                continue;
            }

            $translated = $this->translationService->translate($sourceText, $sourceLocale, $target);

            if (! filled($translated)) {
                continue;
            }

            $values[$target] = $translated;
            $updated[$target] = ($updated[$target] ?? 0) + 1;
        }
    }

    /**
     * @param  array<string, mixed>  $values
     * @return array{0: string, 1: string} Source locale and text
     */
    protected function resolveSource(array $values, string $preferredSource): array
    {
        $preferred = trim((string) ($values[$preferredSource] ?? ''));

        if ($preferred !== '') {
            return [$preferredSource, $preferred];
        }

        foreach ($values as $locale => $value) {
            if (! is_string($value)) {
                continue;
            }

            $text = trim($value);

            if ($text !== '') {
                return [$locale, $text];
            }
        }

        return ['', ''];
    }

    /**
     * @param  array<int, string>  $targetLocales
     * @return array<int, string>
     */
    protected function normalizeTargets(array $targetLocales, string $source): array
    {
        return array_values(array_unique(array_filter(
            $targetLocales,
            fn (string $locale): bool => $locale !== $source && $locale !== '',
        )));
    }
}
