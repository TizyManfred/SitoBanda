<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('static_pages')) {
            return;
        }

        if (! Schema::hasColumn('static_pages', 'header_images')) {
            Schema::table('static_pages', function (Blueprint $table) {
                $table->json('header_images')->nullable()->after('header_image_path');
            });
        }

        $heroImages = DB::table('static_pages')
            ->whereIn('page_key', ['home_hero_1', 'home_hero_2', 'home_hero_3'])
            ->orderByRaw(<<<'SQL'
                CASE page_key
                    WHEN 'home_hero_1' THEN 1
                    WHEN 'home_hero_2' THEN 2
                    WHEN 'home_hero_3' THEN 3
                    ELSE 4
                END
                SQL)
            ->get();

        $headerImages = $heroImages
            ->pluck('header_image_path')
            ->filter()
            ->values()
            ->all();

        $homeValues = [
            'label' => 'Homepage',
            'route_name' => 'home',
            'view_name' => 'home',
            'fallback_header_image_path' => 'images/FotoSanIppolito1.webp',
            'is_active' => true,
            'updated_at' => now(),
        ];

        if ($headerImages !== []) {
            $homeValues['header_images'] = json_encode($headerImages);
        }

        if (DB::table('static_pages')->where('page_key', 'home')->exists()) {
            DB::table('static_pages')
                ->where('page_key', 'home')
                ->update($homeValues);
        } else {
            DB::table('static_pages')->insert(array_merge($homeValues, [
                'page_key' => 'home',
                'created_at' => now(),
            ]));
        }

        DB::table('static_pages')
            ->whereIn('page_key', ['home_hero_1', 'home_hero_2', 'home_hero_3'])
            ->delete();
    }

    public function down(): void
    {
        if (! Schema::hasTable('static_pages')) {
            return;
        }

        DB::table('static_pages')->where('page_key', 'home')->delete();
    }
};
