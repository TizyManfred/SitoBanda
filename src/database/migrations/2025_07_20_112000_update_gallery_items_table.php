<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            // Add new columns
            $table->string('image_path')->after('alt_text');
            $table->integer('order_column')->default(0)->after('image_path');
            $table->boolean('is_visible')->default(true)->after('order_column');
            $table->boolean('is_featured')->default(false)->after('is_visible');
            $table->dateTime('taken_at')->nullable()->after('is_featured');
            
            // Rename existing columns for consistency
            $table->renameColumn('path', 'legacy_path');
            $table->renameColumn('sort_order', 'legacy_sort_order');
            $table->renameColumn('is_published', 'legacy_is_published');
        });
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['image_path', 'order_column', 'is_visible', 'is_featured', 'taken_at']);
            
            // Restore original column names
            $table->renameColumn('legacy_path', 'path');
            $table->renameColumn('legacy_sort_order', 'sort_order');
            $table->renameColumn('legacy_is_published', 'is_published');
        });
    }
};
