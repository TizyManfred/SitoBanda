<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repertoire_pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('repertoire_programs')->onDelete('cascade');
            $table->string('composer')->nullable();
            $table->string('arranger')->nullable();
            $table->string('title');
            $table->string('duration', 20)->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE repertoire_pieces ADD FULLTEXT ft_search(composer, arranger, title)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('repertoire_pieces');
    }
};
