<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repertoire_pieces', function (Blueprint $table) {
            $table->dropColumn(['genre', 'duration', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repertoire_pieces', function (Blueprint $table) {
            $table->string('genre')->nullable();
            $table->string('duration')->nullable();
            $table->text('description')->nullable();
        });
    }
};
