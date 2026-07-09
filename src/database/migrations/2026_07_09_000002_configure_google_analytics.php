<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('settings')) {
            return;
        }

        $analytics = DB::table('settings')->where('key', 'analytics_settings')->first();
        $value = $analytics ? json_decode($analytics->value, true) : [];
        $value = is_array($value) ? $value : [];
        $value = array_merge($value, [
            'enabled' => true,
            'provider' => 'ga4',
            'ga4_measurement_id' => 'G-FK7DDYZC1R',
        ]);

        DB::table('settings')->updateOrInsert(
            ['key' => 'analytics_settings'],
            [
                'value' => json_encode($value, JSON_UNESCAPED_SLASHES),
                'group' => 'analytics',
                'description' => 'Impostazioni analytics del sito',
                'updated_at' => now(),
                'created_at' => $analytics?->created_at ?? now(),
            ],
        );

        Cache::forget('setting.analytics_settings');
        Cache::forget('settings_all');
    }

    public function down(): void
    {
        // Keep the configured analytics setting when rolling back schema migrations.
    }
};
