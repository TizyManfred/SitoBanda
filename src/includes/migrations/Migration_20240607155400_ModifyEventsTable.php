<?php
/**
 * Migration: ModifyEventsTable
 * Created at: 2024-06-07 15:54:00
 * 
 * This migration modifies the events table to:
 * - Remove ticket_url and image_url columns
 * - Convert start_datetime and end_datetime to DATE type
 * - Add gallery_id foreign key to gallery_albums
 * - Add image_path for uploaded event image
 */

require_once __DIR__ . '/migration.php';

class Migration_20240607155400_ModifyEventsTable extends Migration
{
    /**
     * Apply the migration
     *
     * @return bool Success or failure
     */
    public function up(): bool
    {
        try {
            // Check if columns exist before trying to drop them
            $stmt = $this->db->query("SHOW COLUMNS FROM `events` LIKE 'ticket_url'");
            if ($stmt->rowCount() > 0) {
                $this->db->exec("ALTER TABLE `events` DROP COLUMN `ticket_url`");
            }
            
            $stmt = $this->db->query("SHOW COLUMNS FROM `events` LIKE 'image_url'");
            if ($stmt->rowCount() > 0) {
                $this->db->exec("ALTER TABLE `events` DROP COLUMN `image_url`");
            }
            
            // First, check if gallery_albums table exists and has an id column
            $tableExists = false;
            try {
                $stmt = $this->db->query("SHOW TABLES LIKE 'gallery_albums'");
                $tableExists = $stmt->rowCount() > 0;
                
                if ($tableExists) {
                    // Check if gallery_albums has an id column
                    $stmt = $this->db->query("SHOW COLUMNS FROM `gallery_albums` LIKE 'id'");
                    $tableExists = $tableExists && ($stmt->rowCount() > 0);
                }
            } catch (PDOException $e) {
                $tableExists = false;
            }
            
            // Add gallery_id column
            $this->db->exec("ALTER TABLE `events` 
                ADD COLUMN `gallery_id` INT UNSIGNED NULL DEFAULT NULL AFTER `end_datetime`");
                
            // Only add foreign key constraint if gallery_albums table exists with id column
            if ($tableExists) {
                // First, drop existing foreign key if it exists
                try {
                    $this->db->exec("ALTER TABLE `events` DROP FOREIGN KEY IF EXISTS `fk_events_gallery`");
                    
                    // Then add the new foreign key
                    $this->db->exec("ALTER TABLE `events`
                        ADD CONSTRAINT `fk_events_gallery` 
                        FOREIGN KEY (`gallery_id`) 
                        REFERENCES `gallery_albums`(`id`) 
                        ON DELETE SET NULL 
                        ON UPDATE CASCADE");
                } catch (PDOException $e) {
                    // Log the error but don't fail the migration
                    error_log("Warning: Could not add foreign key constraint: " . $e->getMessage());
                }
            }
            
            // Add image_path column for uploaded event image
            $this->db->exec("ALTER TABLE `events` 
                ADD COLUMN `image_path` VARCHAR(255) NULL DEFAULT NULL 
                COMMENT 'Path to uploaded event image' AFTER `gallery_id`");
            
            // Change start_datetime and end_datetime to DATE type
            $this->db->exec("ALTER TABLE `events` 
                MODIFY COLUMN `start_datetime` DATE NOT NULL COMMENT 'Event start date',
                MODIFY COLUMN `end_datetime` DATE NULL DEFAULT NULL COMMENT 'Event end date (optional)'");
            
            return true;
        } catch (Exception $e) {
            error_log("Migration failed: " . $e->getMessage());
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
        try {
            
            // Revert column types back to DATETIME
            $this->db->exec("ALTER TABLE `events` 
                MODIFY COLUMN `start_datetime` DATETIME NOT NULL COMMENT 'Event start date and time',
                MODIFY COLUMN `end_datetime` DATETIME NULL DEFAULT NULL COMMENT 'Event end date and time (optional)'");
            
            // Remove the foreign key constraint first
            $this->db->exec("ALTER TABLE `events` DROP FOREIGN KEY IF EXISTS `fk_events_gallery`");
            
            // Drop the added columns if they exist
            $stmt = $this->db->query("SHOW COLUMNS FROM `events` LIKE 'gallery_id'");
            if ($stmt->rowCount() > 0) {
                // First drop the foreign key constraint if it exists
                try {
                    $this->db->exec("ALTER TABLE `events` DROP FOREIGN KEY IF EXISTS `fk_events_gallery`");
                } catch (PDOException $e) {
                    // Ignore if foreign key doesn't exist
                }
                $this->db->exec("ALTER TABLE `events` DROP COLUMN `gallery_id`");
            }
            
            $stmt = $this->db->query("SHOW COLUMNS FROM `events` LIKE 'image_path'");
            if ($stmt->rowCount() > 0) {
                $this->db->exec("ALTER TABLE `events` DROP COLUMN `image_path`");
            }
            
            // Add back the original columns
            $this->db->exec("ALTER TABLE `events` 
                ADD COLUMN `ticket_url` VARCHAR(512) NULL DEFAULT NULL COMMENT 'URL to purchase tickets' AFTER `end_datetime`,
                ADD COLUMN `image_url` VARCHAR(512) NULL DEFAULT NULL COMMENT 'URL to event image' AFTER `ticket_url`");
            
            return true;
            
        } catch (Exception $e) {
            error_log("Migration rollback failed: " . $e->getMessage());
            return false;
        }
    }
}
