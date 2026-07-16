<?php

namespace Tests\Unit;

use App\Services\NominatimGeocoder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NominatimGeocoderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
        config([
            'services.nominatim.endpoint' => 'https://nominatim.test',
            'services.nominatim.user_agent' => 'SitoBanda test suite',
            'services.nominatim.email' => 'admin@example.com',
            'services.nominatim.timeout' => 5,
        ]);
    }

    public function test_it_returns_the_first_match_and_identifies_the_application(): void
    {
        Http::fake([
            'nominatim.test/*' => Http::response([[
                'lat' => '46.0635123',
                'lon' => '11.6321456',
                'display_name' => 'Castello Tesino, Trentino, Italia',
            ]]),
        ]);

        $result = app(NominatimGeocoder::class)->geocode('Castello Tesino');

        $this->assertSame(46.0635123, $result['latitude']);
        $this->assertSame(11.6321456, $result['longitude']);
        $this->assertSame('Castello Tesino, Trentino, Italia', $result['display_name']);

        Http::assertSent(fn ($request): bool => $request->url() === 'https://nominatim.test/search?q=Castello%20Tesino&format=jsonv2&limit=1&email=admin%40example.com'
            && $request->hasHeader('User-Agent', 'SitoBanda test suite'));
    }

    public function test_it_caches_repeated_queries(): void
    {
        Http::fake([
            '*' => Http::response([[
                'lat' => '46.0635123',
                'lon' => '11.6321456',
                'display_name' => 'Castello Tesino, Trentino, Italia',
            ]]),
        ]);

        $geocoder = app(NominatimGeocoder::class);

        $geocoder->geocode('Castello Tesino');
        $geocoder->geocode('Castello Tesino');

        Http::assertSentCount(1);
    }

    public function test_it_returns_null_when_no_place_matches(): void
    {
        Http::fake(['*' => Http::response([])]);

        $this->assertNull(app(NominatimGeocoder::class)->geocode('Unknown place'));
    }
}
