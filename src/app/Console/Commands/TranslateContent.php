<?php

namespace App\Console\Commands;

use App\Models\Attachment;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use App\Models\RepertoireProgram;
use App\Models\Section;
use App\Models\StaticPage;
use App\Services\TranslationService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class TranslateContent extends Command
{
    protected $signature = 'content:translate
                            {model : Content group: events, gallery, gallery-items, sections, programs, static-pages, attachments, all}
                            {--source=it : Source language code}
                            {--target=en : Target language code}
                            {--force : Overwrite existing translations}';

    protected $description = 'Auto-translate all supported content from one language to another';

    protected TranslationService $translationService;

    public function __construct(TranslationService $translationService)
    {
        parent::__construct();
        $this->translationService = $translationService;
    }

    public function handle(): int
    {
        $model = (string) $this->argument('model');
        $source = (string) $this->option('source');
        $target = (string) $this->option('target');
        $force = (bool) $this->option('force');

        $handlers = [
            'events' => fn () => $this->translateEvents($source, $target, $force),
            'gallery' => function () use ($source, $target, $force): void {
                $this->translateGalleryAlbums($source, $target, $force);
                $this->translateGalleryItems($source, $target, $force);
            },
            'gallery-items' => fn () => $this->translateGalleryItems($source, $target, $force),
            'sections' => fn () => $this->translateModels(
                Section::query()->get(),
                ['name'],
                $source,
                $target,
                $force,
                'sections',
            ),
            'programs' => fn () => $this->translateModels(
                RepertoireProgram::query()->get(),
                ['name'],
                $source,
                $target,
                $force,
                'repertoire programmes',
            ),
            'static-pages' => fn () => $this->translateStaticPages($source, $target, $force),
            'attachments' => fn () => $this->translateModels(
                Attachment::query()->get(),
                ['title', 'description'],
                $source,
                $target,
                $force,
                'attachments',
            ),
            'all' => function () use ($source, $target, $force): void {
                $this->translateEvents($source, $target, $force);
                $this->translateGalleryAlbums($source, $target, $force);
                $this->translateGalleryItems($source, $target, $force);
                $this->translateModels(
                    Section::query()->get(),
                    ['name'],
                    $source,
                    $target,
                    $force,
                    'sections',
                );
                $this->translateModels(
                    RepertoireProgram::query()->get(),
                    ['name'],
                    $source,
                    $target,
                    $force,
                    'repertoire programmes',
                );
                $this->translateStaticPages($source, $target, $force);
                $this->translateModels(
                    Attachment::query()->get(),
                    ['title', 'description'],
                    $source,
                    $target,
                    $force,
                    'attachments',
                );
            },
        ];

        if (! isset($handlers[$model])) {
            $this->error("Unknown content group: {$model}.");

            return self::FAILURE;
        }

        if ($source === $target) {
            $this->error('The source and target languages must be different.');

            return self::FAILURE;
        }

        $this->info("Starting translation from {$source} to {$target}...");
        $handlers[$model]();
        $this->info('Translation completed.');

        return self::SUCCESS;
    }

    protected function translateEvents(string $source, string $target, bool $force): void
    {
        $this->translateModels(
            Event::query()->get(),
            ['title', 'description', 'short_description'],
            $source,
            $target,
            $force,
            'events',
        );
    }

    protected function translateGalleryAlbums(string $source, string $target, bool $force): void
    {
        $this->translateModels(
            GalleryAlbum::query()->get(),
            ['title', 'description'],
            $source,
            $target,
            $force,
            'gallery albums',
        );
    }

    protected function translateGalleryItems(string $source, string $target, bool $force): void
    {
        $this->translateModels(
            GalleryItem::query()->get(),
            ['caption'],
            $source,
            $target,
            $force,
            'gallery captions',
        );
    }

    /**
     * @param iterable<Model> $models
     * @param array<int, string> $fields
     */
    protected function translateModels(
        iterable $models,
        array $fields,
        string $source,
        string $target,
        bool $force,
        string $label,
    ): void {
        $models = is_countable($models) ? $models : iterator_to_array($models);
        $bar = $this->output->createProgressBar(count($models));
        $this->info("Translating {$label}...");

        foreach ($models as $model) {
            $this->translateModel($model, $fields, $source, $target, $force);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
    }

    /**
     * @param array<int, string> $fields
     */
    protected function translateModel(
        Model $model,
        array $fields,
        string $source,
        string $target,
        bool $force,
    ): void {
        $changed = false;

        foreach ($fields as $field) {
            $translations = $model->getTranslations($field);

            if (! $this->translateMap($translations, $source, $target, $force)) {
                continue;
            }

            $model->setTranslations($field, $translations);
            $changed = true;
        }

        if ($changed) {
            $model->save();
        }
    }

    protected function translateStaticPages(string $source, string $target, bool $force): void
    {
        $pages = StaticPage::query()->get();
        $bar = $this->output->createProgressBar($pages->count());
        $this->info('Translating static pages...');

        foreach ($pages as $page) {
            $changed = false;
            $contentHtml = $page->getTranslations('content_html');

            if ($this->translateMap($contentHtml, $source, $target, $force)) {
                $page->setTranslations('content_html', $contentHtml);
                $changed = true;
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

                    if ($this->translateNestedValue($block[$field], $source, $target, $force)) {
                        $changed = true;
                    }
                }

                if (! is_array($block['image_items'] ?? null)) {
                    continue;
                }

                foreach ($block['image_items'] as &$imageItem) {
                    if (! is_array($imageItem) || ! array_key_exists('description', $imageItem)) {
                        continue;
                    }

                    if ($this->translateNestedValue($imageItem['description'], $source, $target, $force)) {
                        $changed = true;
                    }
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

                    if ($this->translateNestedValue($slide[$field], $source, $target, $force)) {
                        $changed = true;
                    }
                }
            }
            unset($slide);

            if ($changed) {
                $page->content_blocks = $contentBlocks;
                $page->header_slides = $headerSlides;
                $page->save();
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
    }

    protected function translateNestedValue(
        mixed &$value,
        string $source,
        string $target,
        bool $force,
    ): bool {
        if (is_string($value) && filled(trim($value))) {
            $value = [$source => $value];
        }

        if (! is_array($value)) {
            return false;
        }

        return $this->translateMap($value, $source, $target, $force);
    }

    /**
     * Translate one localized value map in place.
     *
     * @param array<string, mixed> $values
     */
    protected function translateMap(array &$values, string $source, string $target, bool $force): bool
    {
        $sourceText = trim((string) ($values[$source] ?? ''));

        if ($sourceText === '' || (! $force && filled(trim((string) ($values[$target] ?? ''))))) {
            return false;
        }

        $translated = $this->translationService->translate($sourceText, $source, $target);

        if (! filled($translated)) {
            return false;
        }

        $values[$target] = $translated;

        return true;
    }
}
