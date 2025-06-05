<?php
/**
 * Base Migration Class
 *
 * Provides the structure and interface for all database migrations
 * Following PSR-12 coding standards
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */

abstract class Migration
{
    /**
     * Migration name for identification
     *
     * @var string
     */
    protected $name;

    /**
     * Migration timestamp (YmdHis format)
     *
     * @var string
     */
    protected $timestamp;

    /**
     * Database connection
     *
     * @var PDO
     */
    protected $db;

    /**
     * Constructor
     *
     * @param PDO $db Database connection
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
        
        // Extract name and timestamp from class name
        // Format: Migration_YYYYMMDDHHMMSS_NameOfMigration
        $className = get_class($this);
        if (preg_match('/^Migration_(\d+)_(.+)$/', $className, $matches)) {
            $this->timestamp = $matches[1];
            $this->name = $matches[2];
        } else {
            throw new Exception("Invalid migration class name format: $className");
        }
    }
    
    /**
     * Get migration name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Get migration timestamp
     *
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }
    
    /**
     * Get migration identifier (timestamp_name)
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->timestamp . '_' . $this->name;
    }
    
    /**
     * Apply the migration (must be implemented by subclasses)
     *
     * @return bool Success or failure
     */
    abstract public function up(): bool;
    
    /**
     * Reverse the migration (must be implemented by subclasses)
     *
     * @return bool Success or failure
     */
    abstract public function down(): bool;
}
