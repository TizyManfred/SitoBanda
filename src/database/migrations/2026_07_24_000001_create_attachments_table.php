<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->morphs('attachable');
            $table->json('title');
            $table->json('description')->nullable();
            $table->string('disk')->default('local');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->index(['attachable_type', 'attachable_id', 'is_public'], 'attachments_public_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
