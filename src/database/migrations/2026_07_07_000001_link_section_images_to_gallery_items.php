<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('section_images', function (Blueprint $table) {
            $table->foreignId('gallery_item_id')
                ->nullable()
                ->after('section_id')
                ->constrained('gallery_items')
                ->nullOnDelete();

            $table->string('image_path')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('section_images')
            ->leftJoin('gallery_items', 'section_images.gallery_item_id', '=', 'gallery_items.id')
            ->whereNull('section_images.image_path')
            ->update([
                'section_images.image_path' => DB::raw("COALESCE(gallery_items.image_path, '')"),
            ]);

        Schema::table('section_images', function (Blueprint $table) {
            $table->dropConstrainedForeignId('gallery_item_id');
            $table->string('image_path')->nullable(false)->change();
        });
    }
};
