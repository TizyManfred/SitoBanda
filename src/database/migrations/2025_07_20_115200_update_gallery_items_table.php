<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->integer('sort_order')->unsigned()->default(0);

            if (Schema::hasColumn('gallery_items', 'alt_text')) {
                $table->dropColumn('alt_text');
            }
        });
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->string('alt_text')->nullable();
            $table->dropColumn('sort_order');
        });
    }
};