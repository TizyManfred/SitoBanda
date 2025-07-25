<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_items', 'legacy_path')) {
                $table->dropColumn('legacy_path');
            }
            if (Schema::hasColumn('gallery_items', 'legacy_sort_order')) {
                $table->dropColumn('legacy_sort_order');
            }
            if (Schema::hasColumn('gallery_items', 'legacy_is_published')) {
                $table->dropColumn('legacy_is_published');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->string('legacy_path', 255)->nullable()->after('image_path');
            $table->unsignedInteger('legacy_sort_order')->default(0)->after('legacy_path');
            $table->boolean('legacy_is_published')->default(false)->after('legacy_sort_order');
        });
    }
};
