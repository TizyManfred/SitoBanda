<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('static_pages') || Schema::hasColumn('static_pages', 'header_slides')) {
            return;
        }

        Schema::table('static_pages', function (Blueprint $table) {
            $table->json('header_slides')->nullable()->after('header_images');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('static_pages') || ! Schema::hasColumn('static_pages', 'header_slides')) {
            return;
        }

        Schema::table('static_pages', function (Blueprint $table) {
            $table->dropColumn('header_slides');
        });
    }
};
