<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class NominatimGeocoder
{
    /**
     * @return array{latitude: float, longitude: float, display_name: string}|null
     */
    public function geocode(string $query): ?array
    {
        $query = trim($query);

        if ($query === '') {
            return null;
        }

        $cacheKey = 'nominatim:geocode:'.hash('sha256', mb_strtolower($query));
        $cached = Cache::get($cacheKey);

        if (is_array($cached) && array_key_exists('found', $cached)) {
            return $cached['found'] ? $cached['result'] : null;
        }

        if (! Cache::add('nominatim:request-in-progress', true, now()->addSecond())) {
            throw new RuntimeException('Nominatim request rate exceeded.');
        }

        $endpoint = rtrim((string) config('services.nominatim.endpoint'), '/');
        $userAgent = (string) config('services.nominatim.user_agent');
        $email = trim((string) config('services.nominatim.email'));
        $parameters = [
            'q' => $query,
            'format' => 'jsonv2',
            'limit' => 1,
        ];

        if ($email !== '') {
            $parameters['email'] = $email;
        }

        $response = Http::acceptJson()
            ->withHeaders([
                'User-Agent' => $userAgent,
                'Accept-Language' => app()->getLocale(),
            ])
            ->timeout((int) config('services.nominatim.timeout', 10))
            ->get($endpoint.'/search', $parameters)
            ->throw();

        $match = $response->json('0');
        $latitude = filter_var($match['lat'] ?? null, FILTER_VALIDATE_FLOAT);
        $longitude = filter_var($match['lon'] ?? null, FILTER_VALIDATE_FLOAT);

        if ($latitude === false || $longitude === false || abs($latitude) > 90 || abs($longitude) > 180) {
            Cache::put($cacheKey, ['found' => false], now()->addDay());

            return null;
        }

        $result = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'display_name' => (string) ($match['display_name'] ?? $query),
        ];

        Cache::put($cacheKey, ['found' => true, 'result' => $result], now()->addDays(30));

        return $result;
    }
}
