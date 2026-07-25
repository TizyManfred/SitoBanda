<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventAttachmentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_attachments_are_polymorphic_and_ordered(): void
    {
        $event = $this->createEvent();

        $event->attachments()->create([
            'title' => ['it' => 'Secondo documento'],
            'file_path' => 'attachments/secondo.pdf',
            'display_order' => 2,
            'is_public' => true,
        ]);

        $first = $event->attachments()->create([
            'title' => ['it' => 'Primo documento'],
            'file_path' => 'attachments/primo.pdf',
            'display_order' => 1,
            'is_public' => true,
        ]);

        $this->assertInstanceOf(Event::class, $first->attachable);
        $this->assertSame(
            ['Primo documento', 'Secondo documento'],
            $event->attachments()->get()->map->displayTitle('it')->all()
        );
    }

    public function test_event_page_only_displays_public_attachments(): void
    {
        $event = $this->createEvent();

        $event->attachments()->create([
            'title' => ['it' => 'Regolamento pubblico'],
            'file_path' => 'attachments/regolamento.pdf',
            'is_public' => true,
        ]);

        $event->attachments()->create([
            'title' => ['it' => 'Documento riservato'],
            'file_path' => 'attachments/riservato.pdf',
            'is_public' => false,
        ]);

        $response = $this->get(route('eventi.show', $event->getTranslation('slug', 'it')));

        $response
            ->assertOk()
            ->assertSee('Regolamento pubblico')
            ->assertDontSee('Documento riservato');
    }

    public function test_only_public_attachments_of_public_content_can_be_downloaded(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('attachments/regolamento.pdf', 'PDF content');

        $event = $this->createEvent();
        $attachment = $event->attachments()->create([
            'title' => ['it' => 'Regolamento lotteria'],
            'file_path' => 'attachments/regolamento.pdf',
            'is_public' => true,
        ]);

        $this->get(route('attachments.download', $attachment))
            ->assertOk()
            ->assertDownload('regolamento-lotteria.pdf');

        $attachment->update(['is_public' => false]);

        $this->get(route('attachments.download', $attachment))->assertNotFound();
    }

    private function createEvent(): Event
    {
        return Event::create([
            'title' => [
                'it' => 'Evento con documenti',
                'en' => 'Event with documents',
                'de' => 'Veranstaltung mit Dokumenten',
            ],
            'description' => [
                'it' => '<p>Descrizione</p>',
                'en' => '<p>Description</p>',
                'de' => '<p>Beschreibung</p>',
            ],
            'location' => 'Castello Tesino',
            'start_datetime' => now()->addDay(),
            'is_featured' => false,
            'is_public' => true,
        ]);
    }
}
