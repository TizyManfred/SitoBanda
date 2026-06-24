<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $programs = DB::table('repertoire_programs')->select('id', 'name')->get();

        Schema::table('repertoire_programs', function (Blueprint $table) {
            $table->json('name_json')->nullable()->after('id');
        });

        foreach ($programs as $program) {
            DB::table('repertoire_programs')
                ->where('id', $program->id)
                ->update([
                    'name_json' => json_encode([
                        'it' => $program->name,
                        'en' => '',
                        'de' => '',
                    ]),
                ]);
        }

        Schema::table('repertoire_programs', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('repertoire_programs', function (Blueprint $table) {
            $table->renameColumn('name_json', 'name');
        });
    }

    public function down(): void
    {
        $programs = DB::table('repertoire_programs')->select('id', 'name')->get();

        Schema::table('repertoire_programs', function (Blueprint $table) {
            $table->string('name_string')->nullable()->after('id');
        });

        foreach ($programs as $program) {
            $translations = json_decode($program->name, true);

            DB::table('repertoire_programs')
                ->where('id', $program->id)
                ->update([
                    'name_string' => $translations['it'] ?? (reset($translations) ?: ''),
                ]);
        }

        Schema::table('repertoire_programs', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('repertoire_programs', function (Blueprint $table) {
            $table->renameColumn('name_string', 'name');
        });
    }
};
