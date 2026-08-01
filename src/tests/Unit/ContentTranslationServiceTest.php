<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\StaticPage;
use App\Services\ContentTranslationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\FakeTranslationService;
use Tests\TestCase;

class ContentTranslationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ContentTranslationService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new ContentTranslationService(new FakeTranslationService);
    }

    public function test_it_translates_missing_locales_of_a_model(): void
    {
        $event = $this->makeEvent(['title' => ['it' => 'Concerto di Natale']]);

        $updated = $this->service->translateModel($event, ['title'], ['en', 'fr']);

        $this->assertSame(['en' => 1, 'fr' => 1], $updated);
        $this->assertSame('Concerto di Natale', $event->getTranslation('title', 'it'));
        $this->assertSame('[en] Concerto di Natale', $event->getTranslation('title', 'en'));
        $this->assertSame('[fr] Concerto di Natale', $event->getTranslation('title', 'fr'));
    }

    public function test_it_does_not_overwrite_existing_translations(): void
    {
        $event = $this->makeEvent(['title' => ['it' => 'Concerto', 'en' => 'Concert']]);

        $updated = $this->service->translateModel($event, ['title'], ['en', 'de']);

        $this->assertSame(['de' => 1], $updated);
        $this->assertSame('Concert', $event->getTranslation('title', 'en'));
        $this->assertSame('[de] Concerto', $event->getTranslation('title', 'de'));
    }

    public function test_it_uses_another_language_as_source_when_italian_is_missing(): void
    {
        $event = $this->makeEvent(['title' => ['en' => 'New Year Concert']]);

        $this->service->translateModel($event, ['title'], ['de']);

        $this->assertSame('[de] New Year Concert', $event->getTranslation('title', 'de'));
    }

    public function test_it_returns_empty_when_nothing_is_missing(): void
    {
        $event = $this->makeEvent(['title' => ['it' => 'Concerto', 'en' => 'Concert']]);

        $updated = $this->service->translateModel($event, ['title'], ['en']);

        $this->assertSame([], $updated);
    }

    public function test_it_translates_nested_static_page_content(): void
    {
        $page = StaticPage::where('page_key', 'home')->firstOrFail();

        $page->content_html = ['it' => '<p>Ciao</p>'];
        $page->content_blocks = [
            [
                'title' => ['it' => 'Introduzione'],
                'body' => ['it' => 'Testo introduttivo'],
                'image_items' => [
                    ['description' => ['it' => 'Foto della banda']],
                ],
            ],
            [
                'title' => 'Titolo semplice',
                'body' => null,
            ],
        ];
        $page->header_slides = [
            ['title' => 'Slideshow', 'description' => ['it' => 'Descrizione']],
        ];
        $page->save();

        $updated = $this->service->translateStaticPage($page, ['en']);

        $this->assertArrayHasKey('en', $updated);
        $this->assertSame('[en] <p>Ciao</p>', $page->getTranslation('content_html', 'en'));
        $this->assertSame('[en] Introduzione', $page->content_blocks[0]['title']['en']);
        $this->assertSame('[en] Testo introduttivo', $page->content_blocks[0]['body']['en']);
        $this->assertSame('[en] Foto della banda', $page->content_blocks[0]['image_items'][0]['description']['en']);
        $this->assertSame(['it' => 'Titolo semplice', 'en' => '[en] Titolo semplice'], $page->content_blocks[1]['title']);
        $this->assertSame('[en] Slideshow', $page->header_slides[0]['title']['en']);
        $this->assertSame('[en] Descrizione', $page->header_slides[0]['description']['en']);
    }

    public function test_slug_keeps_previous_value_when_generated_slug_is_empty(): void
    {
        $event = $this->makeEvent(['title' => ['it' => 'Concerto']]);

        $event->slug = ['it' => 'concerto', 'zh' => 'concerto-cinese'];
        $event->save();

        $event->title = ['it' => 'Nuovo concerto', 'zh' => '新音乐会'];
        $event->save();

        $this->assertSame('nuovo-concerto', $event->getTranslation('slug', 'it'));
        $this->assertSame('concerto-cinese', $event->getTranslation('slug', 'zh'));
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function makeEvent(array $attributes): Event
    {
        return Event::create(array_merge([
            'title' => ['it' => 'Concerto'],
            'location' => 'Castello Tesino',
            'start_datetime' => now()->addDay(),
        ], $attributes));
    }
}
