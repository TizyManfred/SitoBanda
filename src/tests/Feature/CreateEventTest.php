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
                'title' => $this->localizedValues('Evento di prova'),
                'short_description' => $this->localizedValues('Test'),
                'description' => $this->localizedValues('<p>Test</p>'),
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
                'title' => $this->localizedValues('Evento di prova'),
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

    /**
     * Build a translatable value map with the same text for every supported locale.
     *
     * @return array<string, string>
     */
    private function localizedValues(string $value): array
    {
        $locales = array_keys(config('laravellocalization.supportedLocales', []));

        return array_fill_keys($locales, $value);
    }
}
