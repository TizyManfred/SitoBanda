<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('sections')) {
            return;
        }

        if (! Schema::hasColumn('sections', 'name_json')) {
            Schema::table('sections', function (Blueprint $table) {
                $table->json('name_json')->nullable()->after('id');
            });
        }

        $selectColumns = ['id', 'name_json'];
        if (Schema::hasColumn('sections', 'name')) {
            $selectColumns[] = 'name';
        }

        $sections = DB::table('sections')->select($selectColumns)->get();

        foreach ($sections as $section) {
            DB::table('sections')
                ->where('id', $section->id)
                ->update([
                    'name_json' => json_encode(
                        $this->normalizeTranslations(
                            $section->name_json ?: ($section->name ?? null)
                        )
                    ),
                ]);
        }

        if (Schema::hasColumn('sections', 'name')) {
            Schema::table('sections', function (Blueprint $table) {
                if ($this->indexExists('sections', 'sections_name_unique')) {
                    $table->dropUnique('sections_name_unique');
                }

                $table->dropColumn('name');
            });
        }

        if (Schema::hasColumn('sections', 'name_json') && ! Schema::hasColumn('sections', 'name')) {
            Schema::table('sections', function (Blueprint $table) {
                $table->renameColumn('name_json', 'name');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('sections') || ! Schema::hasColumn('sections', 'name')) {
            return;
        }

        if (! Schema::hasColumn('sections', 'name_string')) {
            Schema::table('sections', function (Blueprint $table) {
                $table->string('name_string')->nullable()->after('id');
            });
        }

        $sections = DB::table('sections')->select('id', 'name', 'name_string')->get();

        foreach ($sections as $section) {
            DB::table('sections')
                ->where('id', $section->id)
                ->update([
                    'name_string' => $section->name_string ?: $this->extractItalianName($section->name),
                ]);
        }

        if (Schema::hasColumn('sections', 'name')) {
            Schema::table('sections', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }

        if (Schema::hasColumn('sections', 'name_string') && ! Schema::hasColumn('sections', 'name')) {
            Schema::table('sections', function (Blueprint $table) {
                $table->renameColumn('name_string', 'name');
                $table->unique('name');
            });
        }
    }

    private function indexExists(string $table, string $index): bool
    {
        return (bool) DB::table('information_schema.statistics')
            ->where('table_schema', DB::raw('database()'))
            ->where('table_name', $table)
            ->where('index_name', $index)
            ->exists();
    }

    private function normalizeTranslations(mixed $value): array
    {
        $decoded = is_string($value) ? json_decode($value, true) : $value;

        if (is_array($decoded)) {
            $italian = $decoded['it'] ?? (reset($decoded) ?: '');

            return [
                'it' => $italian,
                'en' => $decoded['en'] ?? '',
                'de' => $decoded['de'] ?? '',
            ];
        }

        return [
            'it' => (string) ($value ?? ''),
            'en' => '',
            'de' => '',
        ];
    }

    private function extractItalianName(mixed $value): string
    {
        $decoded = is_string($value) ? json_decode($value, true) : $value;

        if (is_array($decoded)) {
            return (string) ($decoded['it'] ?? (reset($decoded) ?: ''));
        }

        return (string) ($value ?? '');
    }
};
