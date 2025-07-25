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
        Schema::table('gallery_albums', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('title');

            $table->json('description')->nullable();
            $table->json('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gallery_albums', function (Blueprint $table) {
            $table->text('description')->change();
            $table->string('title')->change();
        });
    }
};
