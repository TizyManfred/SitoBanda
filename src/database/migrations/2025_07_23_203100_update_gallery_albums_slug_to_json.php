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
        // First, get all existing slugs
        $albums = DB::table('gallery_albums')->get();
        
        // Change the column type to JSON
        Schema::table('gallery_albums', function (Blueprint $table) {
            $table->json('slug_json')->nullable()->after('slug');
        });
        
        // Migrate existing slugs to JSON format
        foreach ($albums as $album) {
            DB::table('gallery_albums')
                ->where('id', $album->id)
                ->update([
                    'slug_json' => json_encode([
                        'it' => $album->slug,
                        'en' => Str::slug($album->title) // This will be updated later with proper translations
                    ])
                ]);
        }
        
        // Drop the old slug column and rename the new one
        Schema::table('gallery_albums', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->renameColumn('slug_json', 'slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, create a string column for the rollback
        Schema::table('gallery_albums', function (Blueprint $table) {
            $table->string('slug_string')->after('slug');
        });
        
        // Get all albums and update the slug_string with the Italian slug
        $albums = DB::table('gallery_albums')->get();
        
        foreach ($albums as $album) {
            $slugData = json_decode($album->slug, true);
            $slug = $slugData['it'] ?? Str::slug($album->title);
            
            DB::table('gallery_albums')
                ->where('id', $album->id)
                ->update(['slug_string' => $slug]);
        }
        
        // Drop the JSON column and rename the string one
        Schema::table('gallery_albums', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->renameColumn('slug_string', 'slug');
        });
    }
};
