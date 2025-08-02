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
        Schema::create('repertoire_pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repertoire_program_id')->constrained('repertoire_programs')->onDelete('cascade');
            $table->string('title');
            $table->string('composer')->nullable();
            $table->string('arranger')->nullable();
            $table->string('genre')->nullable();
            $table->string('duration')->nullable(); // Duration in format MM:SS
            $table->text('description')->nullable();
            $table->integer('display_order')->default(0);
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
        Schema::dropIfExists('repertoire_pieces');
    }
};
