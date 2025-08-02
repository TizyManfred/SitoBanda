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
        Schema::create('repertoire_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "ESTATE 2025"
            $table->integer('year'); // e.g. 2025
            $table->string('season'); // e.g. "ESTATE", "BLASMUSIK", "NATALE"
            $table->integer('display_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repertoire_programs');
    }
};
