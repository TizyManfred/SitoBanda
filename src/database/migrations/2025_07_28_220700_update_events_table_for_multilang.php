<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, get all existing events to migrate data
        $events = DB::table('events')->get();
        
        Schema::table('events', function (Blueprint $table) {
            // Add new JSON columns for translations (only translatable fields)
            $table->json('title_json')->after('title')->nullable();
            $table->json('description_json')->after('description')->nullable();
            $table->json('short_description_json')->after('short_description')->nullable();
            $table->json('slug_json')->after('slug')->nullable();
        });

        // Migrate existing data to JSON format with proper null handling
        foreach ($events as $event) {
            $title = $event->title ?? '';
            $description = $event->description ?? null;
            $shortDescription = $event->short_description ?? null;
            $slug = $event->slug ?? '';

            DB::table('events')
                ->where('id', $event->id)
                ->update([
                    'title_json' => json_encode([
                        'it' => $title,
                        'en' => $title
                    ], JSON_UNESCAPED_UNICODE),
                    'description_json' => json_encode([
                        'it' => $description,
                        'en' => $description
                    ], JSON_UNESCAPED_UNICODE),
                    'short_description_json' => json_encode([
                        'it' => $shortDescription,
                        'en' => $shortDescription
                    ], JSON_UNESCAPED_UNICODE),
                    'slug_json' => json_encode([
                        'it' => $slug,
                        'en' => $slug
                    ], JSON_UNESCAPED_UNICODE)
                ]);
        }

        // Drop old columns and rename JSON columns
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'description',
                'short_description',
                'slug'
            ]);
            
            $table->renameColumn('title_json', 'title');
            $table->renameColumn('description_json', 'description');
            $table->renameColumn('short_description_json', 'short_description');
            $table->renameColumn('slug_json', 'slug');
        });

        // Update FULLTEXT index for MySQL to work with JSON columns
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE events DROP INDEX ft_search');
            // Note: MySQL doesn't support FULLTEXT on JSON columns, 
            // we'll use generated columns or search in application layer
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, get all existing events to migrate data back
        $events = DB::table('events')->get();
        
        Schema::table('events', function (Blueprint $table) {
            // Add back the original columns (only translatable fields)
            $table->string('title_string')->after('title')->nullable();
            $table->text('description_string')->after('description')->nullable();
            $table->string('short_description_string')->after('short_description')->nullable();
            $table->string('slug_string')->after('slug')->nullable();
        });

        // Migrate data back to string format (using Italian as default)
        foreach ($events as $event) {
            $titleData = json_decode($event->title, true) ?? [];
            $descriptionData = json_decode($event->description, true) ?? [];
            $shortDescriptionData = json_decode($event->short_description, true) ?? [];
            $slugData = json_decode($event->slug, true) ?? [];

            DB::table('events')
                ->where('id', $event->id)
                ->update([
                    'title_string' => $titleData['it'] ?? $titleData['en'] ?? '',
                    'description_string' => $descriptionData['it'] ?? $descriptionData['en'] ?? null,
                    'short_description_string' => $shortDescriptionData['it'] ?? $shortDescriptionData['en'] ?? null,
                    'slug_string' => $slugData['it'] ?? $slugData['en'] ?? ''
                ]);
        }

        // Drop JSON columns and rename string columns back
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'description',
                'short_description',
                'slug'
            ]);
            
            $table->renameColumn('title_string', 'title');
            $table->renameColumn('description_string', 'description');
            $table->renameColumn('short_description_string', 'short_description');
            $table->renameColumn('slug_string', 'slug');
        });

        // Recreate FULLTEXT index for MySQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE events ADD FULLTEXT ft_search(title, description, location)');
        }
    }
};
