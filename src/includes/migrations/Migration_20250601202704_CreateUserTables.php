<?php
/**
 * Migration: CreateUserTables
 * Created at: 2025-06-01 20:27:04
 */

require_once __DIR__ . '/migration.php';

class Migration_20250601202704_CreateUserTables extends Migration
{
    /**
     * Apply the migration
     *
     * @return bool Success or failure
     */
    public function up(): bool
    {
        // Create users table
        $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            first_name VARCHAR(100),
            last_name VARCHAR(100),
            role ENUM('admin', 'editor', 'user') NOT NULL DEFAULT 'user',
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            last_login DATETIME DEFAULT NULL,
            reset_token VARCHAR(100) DEFAULT NULL,
            reset_expires DATETIME DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        // Create user_activity_log table for tracking user actions
        $sqlActivityLog = "CREATE TABLE IF NOT EXISTS user_activity_log (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id INT(10) UNSIGNED NOT NULL,
            action_type VARCHAR(50) NOT NULL,
            description TEXT,
            ip_address VARCHAR(45),
            user_agent TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        // Create user_sessions table for better session management
        $sqlSessions = "CREATE TABLE IF NOT EXISTS user_sessions (
            id VARCHAR(128) NOT NULL,
            user_id INT(10) UNSIGNED,
            ip_address VARCHAR(45),
            user_agent TEXT,
            payload TEXT NOT NULL,
            last_activity INT(10) UNSIGNED NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        // Create an initial admin user (password is hashed version of 'admin123' - change this!)
        $sqlAdminUser = "INSERT INTO users (
            username, 
            email, 
            password, 
            first_name, 
            last_name, 
            role
        ) VALUES (
            'admin', 
            'admin@example.com', 
            '$2y$10$oZdZ9kNpAf/Od7k6w6PwpeaH4wTmNGLKZKY5iyuGf5cztmm8AISCC', 
            'Admin', 
            'User', 
            'admin'
        ) ON DUPLICATE KEY UPDATE 
            username = VALUES(username);";
        
        try {
            // Execute the SQL statements without starting a new transaction
            // (MigrationManager already handles transactions)
            $this->db->exec($sqlUsers);
            $this->db->exec($sqlActivityLog);
            $this->db->exec($sqlSessions);
            
            // Only add the admin user if we're creating a new database
            // This prevents overwriting existing users when migrating
            $checkAdmin = $this->db->query("SELECT COUNT(*) FROM users");
            if ($checkAdmin && $checkAdmin->fetchColumn() == 0) {
                $this->db->exec($sqlAdminUser);
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Migration CreateUserTables failed: " . $e->getMessage());
            throw new Exception("Migration CreateUserTables failed: " . $e->getMessage());
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
        $sql = "SET FOREIGN_KEY_CHECKS=0;
                DROP TABLE IF EXISTS user_sessions;
                DROP TABLE IF EXISTS user_activity_log;
                DROP TABLE IF EXISTS users;
                SET FOREIGN_KEY_CHECKS=1;";
        
        try {
            $this->db->exec($sql);
            return true;
        } catch (Exception $e) {
            error_log("Migration CreateUserTables rollback failed: " . $e->getMessage());
            throw new Exception("Migration CreateUserTables rollback failed: " . $e->getMessage());
        }
    }
}
