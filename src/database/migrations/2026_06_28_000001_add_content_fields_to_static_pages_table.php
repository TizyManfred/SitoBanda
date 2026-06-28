<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('static_pages', function (Blueprint $table) {
            if (! Schema::hasColumn('static_pages', 'content_blocks')) {
                $table->json('content_blocks')->nullable()->after('admin_notes');
            }

            if (! Schema::hasColumn('static_pages', 'content_html')) {
                $table->json('content_html')->nullable()->after('content_blocks');
            }

            if (! Schema::hasColumn('static_pages', 'content_image_path')) {
                $table->string('content_image_path')->nullable()->after('content_html');
            }

            if (! Schema::hasColumn('static_pages', 'content_images')) {
                $table->json('content_images')->nullable()->after('content_image_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('static_pages', function (Blueprint $table) {
            if (Schema::hasColumn('static_pages', 'content_images')) {
                $table->dropColumn('content_images');
            }

            if (Schema::hasColumn('static_pages', 'content_image_path')) {
                $table->dropColumn('content_image_path');
            }

            if (Schema::hasColumn('static_pages', 'content_html')) {
                $table->dropColumn('content_html');
            }

            if (Schema::hasColumn('static_pages', 'content_blocks')) {
                $table->dropColumn('content_blocks');
            }
        });
    }
};
