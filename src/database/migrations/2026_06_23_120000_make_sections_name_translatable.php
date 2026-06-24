<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $sections = DB::table('sections')->select('id', 'name')->get();

        Schema::table('sections', function (Blueprint $table) {
            $table->json('name_json')->nullable()->after('id');
        });

        foreach ($sections as $section) {
            DB::table('sections')
                ->where('id', $section->id)
                ->update([
                    'name_json' => json_encode([
                        'it' => $section->name,
                        'en' => '',
                        'de' => '',
                    ]),
                ]);
        }

        Schema::table('sections', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->dropColumn('name');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->renameColumn('name_json', 'name');
        });
    }

    public function down(): void
    {
        $sections = DB::table('sections')->select('id', 'name')->get();

        Schema::table('sections', function (Blueprint $table) {
            $table->string('name_string')->nullable()->after('id');
        });

        foreach ($sections as $section) {
            $translations = json_decode($section->name, true);

            DB::table('sections')
                ->where('id', $section->id)
                ->update([
                    'name_string' => $translations['it'] ?? (reset($translations) ?: ''),
                ]);
        }

        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->renameColumn('name_string', 'name');
            $table->unique('name');
        });
    }
};
