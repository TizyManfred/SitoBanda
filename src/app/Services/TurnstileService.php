<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class TurnstileService
{
    private const VERIFY_URL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    public function verify(string $token, string $expectedAction, string $expectedHostname, ?string $ipAddress = null): bool
    {
        $secretKey = (string) config('services.turnstile.secret_key');

        if ($secretKey === '') {
            Log::warning('Turnstile verification skipped because the secret key is not configured.');

            return false;
        }

        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post(self::VERIFY_URL, [
                    'secret' => $secretKey,
                    'response' => $token,
                    'remoteip' => $ipAddress,
                ]);

            $result = $response->json();
            $isValid = $response->successful()
                && ($result['success'] ?? false) === true
                && hash_equals($expectedAction, (string) ($result['action'] ?? ''))
                && hash_equals(strtolower($expectedHostname), strtolower((string) ($result['hostname'] ?? '')));

            if (! $isValid) {
                Log::notice('Turnstile rejected a contact form submission.', [
                    'action' => $result['action'] ?? null,
                    'hostname' => $result['hostname'] ?? null,
                    'error_codes' => $result['error-codes'] ?? [],
                ]);
            }

            return $isValid;
        } catch (Throwable $exception) {
            Log::warning('Turnstile verification request failed.', [
                'message' => $exception->getMessage(),
            ]);

            return false;
        }
    }
}
