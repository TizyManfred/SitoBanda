<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if ($this->indexExists('members', 'members_first_name_last_name_unique')) {
                $table->dropUnique('members_first_name_last_name_unique');
            }
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (! $this->indexExists('members', 'members_first_name_last_name_unique')) {
                $table->unique(['first_name', 'last_name']);
            }
        });
    }

    private function indexExists(string $table, string $index): bool
    {
        return collect(Schema::getIndexes($table))
            ->contains(fn (array $existingIndex): bool => ($existingIndex['name'] ?? null) === $index);
    }
};
