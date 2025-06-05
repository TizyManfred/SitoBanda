<?php
/**
 * Migration: TestTransaction
 * Created at: 2025-06-02 09:57:00
 */

require_once __DIR__ . '/migration.php';

class Migration_20250602095700_TestTransaction extends Migration
{
    /**
     * Apply the migration
     *
     * @return bool Success or failure
     */
    public function up(): bool
    {
        // Simple test table without nested transactions
        $sql = "CREATE TABLE IF NOT EXISTS test_transactions (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        try {
            // Execute SQL without transaction management (let migration manager handle it)
            $this->db->exec($sql);
            return true;
        } catch (Exception $e) {
            error_log("Migration TestTransaction failed: " . $e->getMessage());
            // Just report the error, don't manage transactions here
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
        $sql = "DROP TABLE IF EXISTS test_transactions;";
        
        try {
            $this->db->exec($sql);
            return true;
        } catch (Exception $e) {
            error_log("Migration TestTransaction rollback failed: " . $e->getMessage());
            return false;
        }
    }
}
