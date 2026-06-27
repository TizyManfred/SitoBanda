<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique();
            $table->string('label');
            $table->string('route_name')->nullable();
            $table->string('view_name')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('header_image_path')->nullable();
            $table->string('fallback_header_image_path');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['page_key', 'is_active']);
        });

        DB::table('static_pages')->insert([
            ['page_key' => 'home_hero_1', 'label' => 'Homepage - slide 1', 'route_name' => 'home', 'view_name' => 'home', 'fallback_header_image_path' => 'images/FotoSanIppolito1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'home_hero_2', 'label' => 'Homepage - slide 2', 'route_name' => 'home', 'view_name' => 'home', 'fallback_header_image_path' => 'images/FotoShanghai1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'home_hero_3', 'label' => 'Homepage - slide 3', 'route_name' => 'home', 'view_name' => 'home', 'fallback_header_image_path' => 'images/FotoRoma1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'chi_siamo', 'label' => 'Chi siamo', 'route_name' => 'chi-siamo', 'view_name' => 'pages.chi-siamo', 'fallback_header_image_path' => 'images/FotoSanIppolito1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'storia', 'label' => 'Storia', 'route_name' => 'storia', 'view_name' => 'pages.storia', 'fallback_header_image_path' => 'images/FotoStoria1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'organico', 'label' => 'Organico', 'route_name' => 'organico', 'view_name' => 'pages.organico', 'fallback_header_image_path' => 'images/FotoOrganico1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'maestro', 'label' => 'Maestro', 'route_name' => 'maestro', 'view_name' => 'pages.maestro', 'fallback_header_image_path' => 'images/FotoSanIppolito1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'repertorio', 'label' => 'Repertorio', 'route_name' => 'repertorio', 'view_name' => 'pages.repertorio', 'fallback_header_image_path' => 'images/FotoRepertorio1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'abito_tradizionale', 'label' => 'Abito tradizionale', 'route_name' => 'abito-tradizionale', 'view_name' => 'pages.abito-tradizionale', 'fallback_header_image_path' => 'images/FotoAbito1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'italia_gira_banda', 'label' => 'Italia gira banda', 'route_name' => 'italia-gira-banda', 'view_name' => 'pages.italia-gira-banda', 'fallback_header_image_path' => 'images/FotoRoma1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'corsi_di_musica', 'label' => 'Corsi di musica', 'route_name' => 'corsi-di-musica', 'view_name' => 'pages.corsi-di-musica', 'fallback_header_image_path' => 'images/FotoShanghai1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'events_index', 'label' => 'Eventi', 'route_name' => 'eventi', 'view_name' => 'events.index', 'fallback_header_image_path' => 'images/FotoSanIppolito1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'gallery_index', 'label' => 'Galleria', 'route_name' => 'galleria', 'view_name' => 'gallery.index', 'fallback_header_image_path' => 'images/FotoGalleria1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'contact', 'label' => 'Contatti', 'route_name' => 'contatti', 'view_name' => 'contact.index', 'fallback_header_image_path' => 'images/FotoSanIppolito1.webp', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('static_pages');
    }
};
