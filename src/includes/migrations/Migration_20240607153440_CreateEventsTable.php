<?php
/**
 * Migration: CreateEventsTable
 * Created at: 2024-06-07 15:34:40
 */

require_once __DIR__ . '/migration.php';

class Migration_20240607153440_CreateEventsTable extends Migration
{
    /**
     * Apply the migration
     *
     * @return bool Success or failure
     */
    public function up(): bool
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `events` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) NOT NULL COMMENT 'Event title/name',
            `slug` VARCHAR(255) NOT NULL COMMENT 'URL-friendly event name',
            `description` TEXT NULL COMMENT 'Detailed event description',
            `short_description` VARCHAR(255) NULL COMMENT 'Short description for listings',
            `location` VARCHAR(255) NOT NULL COMMENT 'Event location',
            `address` TEXT NULL COMMENT 'Full address of the event',
            `start_datetime` DATETIME NOT NULL COMMENT 'Event start date and time',
            `end_datetime` DATETIME NULL COMMENT 'Event end date and time (optional)',
            `image_url` VARCHAR(512) NULL COMMENT 'URL to event image',
            `ticket_url` VARCHAR(512) NULL COMMENT 'URL to purchase tickets',
            `is_featured` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Whether to feature this event',
            `is_public` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Whether the event is visible to public',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `idx_slug` (`slug`),
            INDEX `idx_start_datetime` (`start_datetime`),
            INDEX `idx_is_public` (`is_public`),
            FULLTEXT `ft_search` (`title`, `description`, `location`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores band events and performances';
        ";

        try {
            $this->db->exec($sql);
            error_log("Events table created successfully");
            return true;
        } catch (PDOException $e) {
            error_log("Error creating events table: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Revert the migration
     *
     * @return bool Success or failure
     */
    public function down(): bool
    {
        $sql = "DROP TABLE IF EXISTS `events`;";
        
        try {
            $this->db->exec($sql);
            error_log("Dropped events table");
            return true;
        } catch (PDOException $e) {
            error_log("Error dropping events table: " . $e->getMessage());
            return false;
        }
    }
}
