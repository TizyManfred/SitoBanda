<?php

namespace App\Console\Commands;

use App\Models\Attachment;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use App\Models\RepertoireProgram;
use App\Models\Section;
use App\Models\StaticPage;
use App\Services\ContentTranslationService;
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

    protected ContentTranslationService $contentTranslationService;

    public function __construct(ContentTranslationService $contentTranslationService)
    {
        parent::__construct();
        $this->contentTranslationService = $contentTranslationService;
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
     * @param  iterable<Model>  $models
     * @param  array<int, string>  $fields
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
            $this->contentTranslationService->translateModel($model, $fields, [$target], $force, $source);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
    }

    protected function translateStaticPages(string $source, string $target, bool $force): void
    {
        $pages = StaticPage::query()->get();
        $bar = $this->output->createProgressBar($pages->count());
        $this->info('Translating static pages...');

        foreach ($pages as $page) {
            $this->contentTranslationService->translateStaticPage($page, [$target], $force, $source);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
    }
}
