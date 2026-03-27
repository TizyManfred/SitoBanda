<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing string values to JSON before changing column type
        DB::table('sections')->get()->each(function ($section) {
            $name = $section->name;
            if ($name && !$this->isJson($name)) {
                DB::table('sections')
                    ->where('id', $section->id)
                    ->update(['name' => json_encode(['it' => $name])]);
            }
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->json('name')->change();
        });
    }

    public function down(): void
    {
        // Convert JSON back to string (use 'it' locale as canonical value)
        DB::table('sections')->get()->each(function ($section) {
            $decoded = json_decode($section->name, true);
            if (is_array($decoded)) {
                DB::table('sections')
                    ->where('id', $section->id)
                    ->update(['name' => $decoded['it'] ?? $decoded[array_key_first($decoded)] ?? '']);
            }
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->string('name')->change();
            $table->unique('name');
        });
    }

    private function isJson(string $value): bool
    {
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }
};
