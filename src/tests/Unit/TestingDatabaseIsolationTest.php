<?php

namespace Tests\Unit;

use Tests\TestCase;

class TestingDatabaseIsolationTest extends TestCase
{
    public function test_tests_use_an_in_memory_sqlite_database(): void
    {
        $this->assertSame('testing', app()->environment());
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
    }
}
