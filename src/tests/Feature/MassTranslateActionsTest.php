<?php

namespace Tests\Feature;

use App\Filament\Resources\EventResource\Pages\ListEvents;
use App\Models\Event;
use App\Models\User;
use App\Services\TranslationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\Support\FakeTranslationService;
use Tests\TestCase;

class MassTranslateActionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
        $this->app->instance(TranslationService::class, new FakeTranslationService);
    }

    public function test_bulk_action_translates_selected_events(): void
    {
        $selected = $this->makeEvent(['it' => 'Evento selezionato']);
        $other = $this->makeEvent(['it' => 'Evento non selezionato']);

        Livewire::test(ListEvents::class)
            ->callTableBulkAction('translate', [$selected->getKey()], [
                'target_locales' => ['en', 'de'],
            ]);

        $this->assertSame('[en] Evento selezionato', $selected->refresh()->getTranslation('title', 'en'));
        $this->assertSame('[de] Evento selezionato', $selected->refresh()->getTranslation('title', 'de'));
        $this->assertSame('Evento non selezionato', $other->refresh()->getTranslation('title', 'it'));
        $this->assertArrayNotHasKey('en', $other->refresh()->getTranslations('title'));
    }

    public function test_bulk_action_does_not_overwrite_existing_translations(): void
    {
        $event = $this->makeEvent([
            'it' => 'Evento',
            'en' => 'Existing event',
        ]);

        Livewire::test(ListEvents::class)
            ->callTableBulkAction('translate', [$event->getKey()], [
                'target_locales' => ['en'],
            ]);

        $this->assertSame('Existing event', $event->refresh()->getTranslation('title', 'en'));
    }

    public function test_header_action_translates_all_events(): void
    {
        $first = $this->makeEvent(['it' => 'Primo evento']);
        $second = $this->makeEvent(['it' => 'Secondo evento']);

        Livewire::test(ListEvents::class)
            ->callTableAction('translateAll', data: ['target_locales' => ['en']]);

        $this->assertSame('[en] Primo evento', $first->refresh()->getTranslation('title', 'en'));
        $this->assertSame('[en] Secondo evento', $second->refresh()->getTranslation('title', 'en'));
    }

    /**
     * @param  array<string, string>  $titles
     */
    private function makeEvent(array $titles): Event
    {
        return Event::create([
            'title' => $titles,
            'location' => 'Castello Tesino',
            'start_datetime' => now()->addDay(),
            'is_featured' => false,
            'is_public' => true,
        ]);
    }
}
