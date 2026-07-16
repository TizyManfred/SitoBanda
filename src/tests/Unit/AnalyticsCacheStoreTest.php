<?php

namespace Tests\Unit;

use Google\Auth\FetchAuthTokenInterface;
use Illuminate\Cache\FileStore;
use Illuminate\Cache\Repository;
use Mockery;
use ReflectionProperty;
use Spatie\Analytics\AnalyticsClient;
use Tests\TestCase;

class AnalyticsCacheStoreTest extends TestCase
{
    public function test_analytics_uses_the_binary_safe_file_cache_store(): void
    {
        config([
            'analytics.service_account_credentials_json' => Mockery::mock(FetchAuthTokenInterface::class),
        ]);

        $client = app(AnalyticsClient::class);
        $cacheProperty = new ReflectionProperty($client, 'cache');
        $cache = $cacheProperty->getValue($client);

        $this->assertInstanceOf(Repository::class, $cache);
        $this->assertInstanceOf(FileStore::class, $cache->getStore());
    }
}
