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
        Schema::table('events', function (Blueprint $table) {
            // Add the foreign key constraint
            $table->foreign('gallery_id')
                  ->references('id')
                  ->on('gallery_albums')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Drop the foreign key constraint
            // The name follows the convention: table_column_foreign
            $table->dropForeign(['gallery_id']);
        });
    }
};
