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
            if (Schema::hasColumn('gallery_items', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('gallery_items', 'title')) {
                $table->dropColumn('title');
            }
            $table->text('caption')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropIfExist('caption');

            $table->text('description')->nullable()->default('');
            $table->text('title')->default('');
        });
    }
};
