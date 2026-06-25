<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\Member;
use App\Models\RepertoirePiece;
use App\Services\TranslationService;
use Illuminate\Console\Command;

class TranslateContent extends Command
{
    protected $signature = 'content:translate 
                            {model : The model to translate (events, gallery, members, repertoire, all)}
                            {--source=it : Source language code}
                            {--target=en : Target language code}
                            {--force : Overwrite existing translations}';

    protected $description = 'Auto-translate content from one language to another';

    protected TranslationService $translationService;

    public function __construct(TranslationService $translationService)
    {
        parent::__construct();
        $this->translationService = $translationService;
    }

    public function handle(): int
    {
        $model = $this->argument('model');
        $source = $this->option('source');
        $target = $this->option('target');
        $force = $this->option('force');

        $this->info("Starting translation from {$source} to {$target}...");

        match ($model) {
            'events' => $this->translateEvents($source, $target, $force),
            'gallery' => $this->translateGallery($source, $target, $force),
            'members' => $this->translateMembers($source, $target, $force),
            'repertoire' => $this->translateRepertoire($source, $target, $force),
            'all' => $this->translateAll($source, $target, $force),
            default => $this->error("Unknown model: {$model}. Use: events, gallery, members, repertoire, or all")
        };

        $this->info('Translation completed!');
        return Command::SUCCESS;
    }

    protected function translateEvents(string $source, string $target, bool $force): void
    {
        $this->info('Translating Events...');
        $events = Event::all();
        $bar = $this->output->createProgressBar($events->count());

        foreach ($events as $event) {
            $this->translateModel($event, ['title', 'description', 'short_description'], $source, $target, $force);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }

    protected function translateGallery(string $source, string $target, bool $force): void
    {
        $this->info('Translating Gallery Albums...');
        $albums = GalleryAlbum::all();
        $bar = $this->output->createProgressBar($albums->count());

        foreach ($albums as $album) {
            $this->translateModel($album, ['title', 'description'], $source, $target, $force);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }

    protected function translateMembers(string $source, string $target, bool $force): void
    {
        $this->info('Translating Members...');
        $members = Member::all();
        $bar = $this->output->createProgressBar($members->count());

        foreach ($members as $member) {
            $this->translateModel($member, ['bio'], $source, $target, $force);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }

    protected function translateRepertoire(string $source, string $target, bool $force): void
    {
        $this->info('Translating Repertoire Pieces...');
        $pieces = RepertoirePiece::all();
        $bar = $this->output->createProgressBar($pieces->count());

        foreach ($pieces as $piece) {
            $this->translateModel($piece, ['description'], $source, $target, $force);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }

    protected function translateAll(string $source, string $target, bool $force): void
    {
        $this->translateEvents($source, $target, $force);
        $this->translateGallery($source, $target, $force);
        $this->translateMembers($source, $target, $force);
        $this->translateRepertoire($source, $target, $force);
    }

    protected function translateModel($model, array $fields, string $source, string $target, bool $force): void
    {
        foreach ($fields as $field) {
            $data = $model->getTranslations($field);
            
            if (!isset($data[$source])) {
                continue;
            }

            if (isset($data[$target]) && !$force) {
                continue;
            }

            $translated = $this->translationService->translate($data[$source], $source, $target);
            
            if ($translated) {
                $model->setTranslation($field, $target, $translated);
            }
        }

        $model->save();
    }
}
