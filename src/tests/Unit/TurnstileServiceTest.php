<?php

namespace Tests\Unit;

use App\Services\TurnstileService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TurnstileServiceTest extends TestCase
{
    public function test_it_accepts_a_valid_token_for_the_expected_form_and_hostname(): void
    {
        config(['services.turnstile.secret_key' => 'test-secret']);

        Http::fake([
            '*' => Http::response([
                'success' => true,
                'action' => 'contact_footer',
                'hostname' => 'www.bandacastellotesino.it',
                'error-codes' => [],
            ]),
        ]);

        $result = app(TurnstileService::class)->verify(
            'valid-token',
            'contact_footer',
            'www.bandacastellotesino.it',
            '127.0.0.1',
        );

        $this->assertTrue($result);
    }

    public function test_it_rejects_a_token_created_for_another_form(): void
    {
        config(['services.turnstile.secret_key' => 'test-secret']);

        Http::fake([
            '*' => Http::response([
                'success' => true,
                'action' => 'contact_page',
                'hostname' => 'www.bandacastellotesino.it',
                'error-codes' => [],
            ]),
        ]);

        $result = app(TurnstileService::class)->verify(
            'valid-token',
            'contact_footer',
            'www.bandacastellotesino.it',
        );

        $this->assertFalse($result);
    }

    public function test_it_rejects_a_token_created_on_another_hostname(): void
    {
        config(['services.turnstile.secret_key' => 'test-secret']);

        Http::fake([
            '*' => Http::response([
                'success' => true,
                'action' => 'contact_page',
                'hostname' => 'example.com',
                'error-codes' => [],
            ]),
        ]);

        $result = app(TurnstileService::class)->verify(
            'valid-token',
            'contact_page',
            'www.bandacastellotesino.it',
        );

        $this->assertFalse($result);
    }
}
