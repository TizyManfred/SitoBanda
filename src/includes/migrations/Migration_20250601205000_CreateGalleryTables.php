<?php
/**
 * Migration: CreateGalleryTables
 * Created at: 2025-06-01 20:50:00
 */

require_once __DIR__ . '/migration.php';

class Migration_20250601205000_CreateGalleryTables extends Migration
{
    /**
     * Apply the migration
     *
     * @return bool Success or failure
     */
    public function up(): bool
    {
        // Create gallery_albums table
        $sqlAlbums = "CREATE TABLE IF NOT EXISTS gallery_albums (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            description TEXT,
            cover_image VARCHAR(255),
            year INT(4) UNSIGNED NOT NULL,
            is_published TINYINT(1) NOT NULL DEFAULT 0,
            view_count INT(10) UNSIGNED NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        // Create gallery_items (photos) table
        $sqlItems = "CREATE TABLE IF NOT EXISTS gallery_items (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            album_id INT(10) UNSIGNED NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            alt_text VARCHAR(255),
            filename VARCHAR(255) NOT NULL,
            sort_order INT(10) UNSIGNED NOT NULL DEFAULT 0,
            is_published TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (album_id) REFERENCES gallery_albums(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        try {
            // Execute the SQL statements
            $this->db->exec($sqlAlbums);
            $this->db->exec($sqlItems);
            return true;
        } catch (Exception $e) {
            error_log("Migration CreateGalleryTables failed: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Reverse the migration
     *
     * @return bool Success or failure
     */
    public function down(): bool
    {
        // Drop tables in reverse order to respect foreign key constraints
        $sql = "DROP TABLE IF EXISTS gallery_items;
                DROP TABLE IF EXISTS gallery_albums;";
        
        try {
            $this->db->exec($sql);
            return true;
        } catch (Exception $e) {
            error_log("Migration CreateGalleryTables rollback failed: " . $e->getMessage());
            return false;
        }
    }
}
