<?php

namespace Tests\Feature;

use App\Mail\ContactFormSubmission;
use App\Services\TurnstileService;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ViewErrorBag;
use Mockery;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);
        config(['services.turnstile.enabled' => true]);
    }

    public function test_contact_form_returns_json_and_sends_configured_bcc_recipients(): void
    {
        Mail::fake();

        config([
            'mail.admin_address' => 'danielezotta@gmail.com',
            'mail.bcc_addresses' => [
                'segreteria@example.com',
                'SEGreteria@example.com',
                'invalid-address',
                'danielezotta@gmail.com',
                'direttivo@example.com',
            ],
        ]);

        $this->mock(TurnstileService::class)
            ->shouldReceive('verify')
            ->once()
            ->with(
                'valid-token',
                'contact_page',
                Mockery::type('string'),
                Mockery::any(),
            )
            ->andReturnTrue();

        $response = $this->postJson(route('contatti.store'), [
            'name' => 'Mario Rossi',
            'email' => 'mario@example.com',
            'subject' => 'Richiesta informazioni',
            'message' => 'Vorrei ricevere maggiori informazioni.',
            'privacy_policy' => '1',
            'cf-turnstile-response' => 'valid-token',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('message', __('contact.messages.success'));

        $this->assertDatabaseHas('contact_submissions', [
            'email' => 'mario@example.com',
            'subject' => 'Richiesta informazioni',
        ]);

        Mail::assertSent(ContactFormSubmission::class, function (ContactFormSubmission $mail): bool {
            return $mail->hasTo('danielezotta@gmail.com')
                && $mail->hasBcc('segreteria@example.com')
                && $mail->hasBcc('direttivo@example.com')
                && count($mail->bcc) === 2;
        });
    }

    public function test_contact_form_returns_localized_json_validation_errors(): void
    {
        Mail::fake();

        $response = $this->postJson(route('contatti.store'), []);

        $response
            ->assertUnprocessable()
            ->assertJsonPath('message', __('contact.messages.validation_error'))
            ->assertJsonValidationErrors([
                'name',
                'email',
                'subject',
                'message',
                'privacy_policy',
                'cf-turnstile-response',
            ]);

        Mail::assertNothingSent();
    }

    public function test_contact_form_explains_when_the_turnstile_token_is_not_ready(): void
    {
        Mail::fake();

        $response = $this->postJson(route('contatti.store'), [
            'name' => 'Mario Rossi',
            'email' => 'mario@example.com',
            'subject' => 'Richiesta informazioni',
            'message' => 'Vorrei ricevere maggiori informazioni.',
            'privacy_policy' => '1',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonPath('message', __('contact.messages.turnstile_error'))
            ->assertJsonValidationErrors('cf-turnstile-response');

        Mail::assertNothingSent();
    }

    public function test_contact_form_skips_turnstile_when_it_is_disabled(): void
    {
        Mail::fake();

        config([
            'services.turnstile.enabled' => false,
            'mail.admin_address' => 'danielezotta@gmail.com',
            'mail.bcc_addresses' => [],
        ]);

        $this->mock(TurnstileService::class)
            ->shouldNotReceive('verify');

        $response = $this->postJson(route('contatti.store'), [
            'name' => 'Mario Rossi',
            'email' => 'mario@example.com',
            'subject' => 'Richiesta informazioni',
            'message' => 'Vorrei ricevere maggiori informazioni.',
            'privacy_policy' => '1',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('message', __('contact.messages.success'));

        Mail::assertSent(ContactFormSubmission::class);
    }

    public function test_contact_page_does_not_render_turnstile_when_it_is_disabled(): void
    {
        config([
            'services.turnstile.enabled' => false,
            'services.turnstile.site_key' => 'configured-but-disabled',
        ]);

        $this->view('contact.index', ['errors' => new ViewErrorBag])
            ->assertDontSee('js-contact-turnstile', false)
            ->assertDontSee('challenges.cloudflare.com/turnstile', false);
    }
}
