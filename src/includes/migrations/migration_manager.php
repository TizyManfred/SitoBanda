<?php
/**
 * Migration Manager
 *
 * Manages database migrations: tracking, applying, and reverting
 * Following PSR-12 coding standards and security best practices
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */

require_once __DIR__ . '/migration.php';

class MigrationManager
{
    /**
     * Database connection
     *
     * @var PDO
     */
    private $db;
    
    /**
     * Directory containing migration files
     *
     * @var string
     */
    private $migrationsDir;
    
    /**
     * Migration table name
     *
     * @var string
     */
    private $migrationTable = 'migrations';
    
    /**
     * Constructor
     *
     * @param PDO    $db            Database connection
     * @param string $migrationsDir Directory containing migration files
     */
    public function __construct(PDO $db, string $migrationsDir)
    {
        $this->db = $db;
        $this->migrationsDir = rtrim($migrationsDir, '/\\') . DIRECTORY_SEPARATOR;
        
        // Ensure the migrations table exists
        $this->initMigrationsTable();
    }
    
    /**
     * Create migrations table if it doesn't exist
     *
     * @return void
     */
    private function initMigrationsTable(): void
    {
        $query = "CREATE TABLE IF NOT EXISTS {$this->migrationTable} (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            migration VARCHAR(255) NOT NULL,
            batch INT(10) UNSIGNED NOT NULL,
            applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        $this->db->exec($query);
    }
    
    /**
     * Get all available migrations from the migrations directory
     *
     * @return array List of available migration class names
     */
    public function getAvailableMigrations(): array
    {
        $migrations = [];
        
        foreach (glob($this->migrationsDir . '*.php') as $file) {
            // Skip base files
            if (basename($file) === 'migration.php' || basename($file) === 'migration_manager.php') {
                continue;
            }
            
            // Include the file
            require_once $file;
            
            // Extract class name from filename (Migration_TIMESTAMP_NAME.php)
            $className = pathinfo($file, PATHINFO_FILENAME);
            if (class_exists($className)) {
                $migrations[] = $className;
            }
        }
        
        // Sort migrations by timestamp
        usort($migrations, function ($a, $b) {
            preg_match('/^Migration_(\d+)_/', $a, $matchesA);
            preg_match('/^Migration_(\d+)_/', $b, $matchesB);
            
            $timestampA = $matchesA[1] ?? 0;
            $timestampB = $matchesB[1] ?? 0;
            
            return $timestampA <=> $timestampB;
        });
        
        return $migrations;
    }
    
    /**
     * Get all migrations that have been applied
     *
     * @return array List of applied migrations
     */
    public function getAppliedMigrations(): array
    {
        $stmt = $this->db->query("SELECT migration FROM {$this->migrationTable} ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     * Get migrations that haven't been applied yet
     *
     * @return array List of pending migration class names
     */
    public function getPendingMigrations(): array
    {
        $available = $this->getAvailableMigrations();
        $applied = $this->getAppliedMigrations();
        
        return array_diff($available, $applied);
    }
    
    /**
     * Apply pending migrations
     *
     * @param bool $pretend If true, only show what would be done without actually executing
     * @return array Result information for each migration
     */
    public function migrate(bool $pretend = false): array
    {
        $pending = $this->getPendingMigrations();
        $batch = $this->getNextBatchNumber();
        $results = [];
        
        if (empty($pending)) {
            return ['message' => 'No pending migrations.'];
        }
        
        $this->db->beginTransaction();
        
        try {
            foreach ($pending as $migrationClass) {
                $migration = new $migrationClass($this->db);
                
                if (!$pretend) {
                    // Apply the migration
                    $success = $migration->up();
                    
                    if ($success) {
                        // Record successful migration
                        $stmt = $this->db->prepare(
                            "INSERT INTO {$this->migrationTable} (migration, batch) VALUES (?, ?)"
                        );
                        $stmt->execute([$migrationClass, $batch]);
                    } else {
                        throw new Exception("Migration {$migrationClass} failed.");
                    }
                }
                
                $results[] = [
                    'migration' => $migrationClass,
                    'action' => 'migrate',
                    'status' => $pretend ? 'would run' : 'completed'
                ];
            }
            
            if (!$pretend) {
                $this->db->commit();
            }
            
            return $results;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    /**
     * Rollback the latest batch of migrations
     *
     * @param int  $steps   Number of batches to rollback (default: 1)
     * @param bool $pretend If true, only show what would be done without actually executing
     * @return array Result information for each migration
     */
    public function rollback(int $steps = 1, bool $pretend = false): array
    {
        $results = [];
        
        // Get the latest batch number(s) to rollback
        $stmt = $this->db->query(
            "SELECT DISTINCT batch FROM {$this->migrationTable} ORDER BY batch DESC LIMIT {$steps}"
        );
        $batches = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (empty($batches)) {
            return ['message' => 'Nothing to rollback.'];
        }
        
        // Get all migrations from these batches
        $placeholders = rtrim(str_repeat('?,', count($batches)), ',');
        $stmt = $this->db->prepare(
            "SELECT migration FROM {$this->migrationTable} 
             WHERE batch IN ({$placeholders})
             ORDER BY id DESC"
        );
        $stmt->execute($batches);
        $migrations = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (empty($migrations)) {
            return ['message' => 'No migrations to rollback.'];
        }
        
        $this->db->beginTransaction();
        
        try {
            foreach ($migrations as $migrationClass) {
                // Check if class exists
                if (!class_exists($migrationClass)) {
                    require_once $this->migrationsDir . $migrationClass . '.php';
                }
                
                $migration = new $migrationClass($this->db);
                
                if (!$pretend) {
                    // Revert the migration
                    $success = $migration->down();
                    
                    if ($success) {
                        // Remove migration record
                        $stmt = $this->db->prepare(
                            "DELETE FROM {$this->migrationTable} WHERE migration = ?"
                        );
                        $stmt->execute([$migrationClass]);
                    } else {
                        throw new Exception("Rollback of {$migrationClass} failed.");
                    }
                }
                
                $results[] = [
                    'migration' => $migrationClass,
                    'action' => 'rollback',
                    'status' => $pretend ? 'would run' : 'completed'
                ];
            }
            
            if (!$pretend) {
                $this->db->commit();
            }
            
            return $results;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    /**
     * Reset all migrations (rollback everything)
     *
     * @param bool $pretend If true, only show what would be done without actually executing
     * @return array Result information for each migration
     */
    public function reset(bool $pretend = false): array
    {
        $stmt = $this->db->query(
            "SELECT COUNT(DISTINCT batch) FROM {$this->migrationTable}"
        );
        $batchCount = (int)$stmt->fetchColumn();
        
        if ($batchCount === 0) {
            return ['message' => 'Nothing to reset.'];
        }
        
        return $this->rollback($batchCount, $pretend);
    }
    
    /**
     * Get the next batch number
     *
     * @return int Next batch number
     */
    private function getNextBatchNumber(): int
    {
        $stmt = $this->db->query(
            "SELECT MAX(batch) FROM {$this->migrationTable}"
        );
        $maxBatch = $stmt->fetchColumn();
        
        return $maxBatch ? $maxBatch + 1 : 1;
    }
    
    /**
     * Create a new migration file
     *
     * @param string $name Name of the migration
     * @return string Path to the created migration file
     */
    public function createMigration(string $name): string
    {
        // Format the name as StudlyCase
        $name = str_replace(' ', '_', ucwords(str_replace(['_', '-'], ' ', $name)));
        
        // Generate timestamp
        $timestamp = date('YmdHis');
        
        // Create class name
        $className = "Migration_{$timestamp}_{$name}";
        
        // Create file path
        $filePath = $this->migrationsDir . $className . '.php';
        
        // Migration file template
        $content = "<?php
/**
 * Migration: {$name}
 * Created at: " . date('Y-m-d H:i:s') . "
 */

require_once __DIR__ . '/migration.php';

class {$className} extends Migration
{
    /**
     * Apply the migration
     *
     * @return bool Success or failure
     */
    public function up(): bool
    {
        \$sql = \"\";
        
        try {
            \$this->db->exec(\$sql);
            return true;
        } catch (Exception \$e) {
            error_log(\"Migration {$className} failed: \" . \$e->getMessage());
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
        \$sql = \"\";
        
        try {
            \$this->db->exec(\$sql);
            return true;
        } catch (Exception \$e) {
            error_log(\"Migration {$className} rollback failed: \" . \$e->getMessage());
            return false;
        }
    }
}
";
        
        // Write the file
        file_put_contents($filePath, $content);
        
        return $filePath;
    }
}
