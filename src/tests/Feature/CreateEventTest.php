<?php

namespace Tests\Feature;

use App\Filament\Resources\EventResource\Pages\CreateEvent;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_an_event_with_a_start_date(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateEvent::class)
            ->fillForm([
                'title' => [
                    'it' => 'Evento di prova',
                    'en' => 'Test event',
                    'de' => 'Testveranstaltung',
                ],
                'short_description' => [
                    'it' => 'Test',
                    'en' => 'Test',
                    'de' => 'Test',
                ],
                'description' => [
                    'it' => '<p>Test</p>',
                    'en' => '<p>Test</p>',
                    'de' => '<p>Test</p>',
                ],
                'location' => 'Castello Tesino',
                'start_datetime' => '2024-07-07 00:00:00',
                'is_featured' => false,
                'is_public' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(Event::class, [
            'location' => 'Castello Tesino',
            'start_datetime' => '2024-07-07 00:00:00',
        ]);
    }

    public function test_start_date_can_be_added_after_required_validation_fails(): void
    {
        $this->actingAs(User::factory()->create());

        $component = Livewire::test(CreateEvent::class)
            ->fillForm([
                'title' => [
                    'it' => 'Evento di prova',
                    'en' => 'Test event',
                    'de' => 'Testveranstaltung',
                ],
                'location' => 'Castello Tesino',
                'is_featured' => false,
                'is_public' => true,
            ])
            ->call('create')
            ->assertHasFormErrors(['start_datetime' => 'required']);

        $component
            ->set('data.start_datetime', '2024-07-07 00:00:00')
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseCount(Event::class, 1);
    }
}
