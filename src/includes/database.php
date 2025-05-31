<?php
/**
 * Database Connection
 *
 * PDO connection with prepared statements for the SitoBanda website
 * Following PSR-12 coding standards
 */

// Define ABSPATH for security if not already defined
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__DIR__) . '/');
}

// Include configuration
require_once ABSPATH . 'includes/config.php';

/**
 * Class Database - Singleton pattern for database connection
 */
class Database
{
    /**
     * @var PDO|null The database connection instance
     */
    private static ?PDO $instance = null;

    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct()
    {
        // This is private to prevent direct creation of object
    }

    /**
     * Prevent cloning of the instance
     */
    private function __clone()
    {
        // This is private to prevent cloning
    }

    /**
     * Get database connection instance
     *
     * @return PDO A PDO instance representing a connection to the database
     * @throws PDOException If connection fails
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                // Set DSN
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
                
                // Set PDO options
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ];
                
                // Create PDO instance
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
                
                // Check connection
                self::$instance->query('SELECT 1');
                
            } catch (PDOException $e) {
                // Log error
                error_log('Database Connection Error: ' . $e->getMessage());
                
                // In development mode, show the error; in production, show generic message
                if (ENVIRONMENT === 'development') {
                    throw new PDOException($e->getMessage(), (int)$e->getCode());
                } else {
                    // Production - show generic error
                    die('Si è verificato un errore di connessione al database. Riprova più tardi.');
                }
            }
        }
        
        return self::$instance;
    }

    /**
     * Execute a query with prepared statements
     *
     * @param string $query The SQL query to execute
     * @param array $params The parameters to bind to the query
     * @return PDOStatement|false The PDOStatement object or false on failure
     */
    public static function query(string $query, array $params = [])
    {
        try {
            $stmt = self::getInstance()->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Log error
            error_log('Database Query Error: ' . $e->getMessage() . ' - Query: ' . $query);
            
            // In development mode, show the error; in production, show generic message
            if (ENVIRONMENT === 'development') {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            } else {
                return false;
            }
        }
    }

    /**
     * Get a single row from a query
     *
     * @param string $query The SQL query to execute
     * @param array $params The parameters to bind to the query
     * @return array|false The first row from the result or false if no rows
     */
    public static function getRow(string $query, array $params = [])
    {
        $stmt = self::query($query, $params);
        
        if ($stmt) {
            return $stmt->fetch();
        }
        
        return false;
    }

    /**
     * Get all rows from a query
     *
     * @param string $query The SQL query to execute
     * @param array $params The parameters to bind to the query
     * @return array The result set as an array of associative arrays
     */
    public static function getRows(string $query, array $params = []): array
    {
        $stmt = self::query($query, $params);
        
        if ($stmt) {
            return $stmt->fetchAll();
        }
        
        return [];
    }

    /**
     * Get the ID of the last inserted row
     *
     * @return string The last insert ID as a string
     */
    public static function lastInsertId(): string
    {
        return self::getInstance()->lastInsertId();
    }
    
    /**
     * Begin a transaction
     *
     * @return bool True on success or false on failure
     */
    public static function beginTransaction(): bool
    {
        return self::getInstance()->beginTransaction();
    }
    
    /**
     * Commit a transaction
     *
     * @return bool True on success or false on failure
     */
    public static function commit(): bool
    {
        return self::getInstance()->commit();
    }
    
    /**
     * Roll back a transaction
     *
     * @return bool True on success or false on failure
     */
    public static function rollBack(): bool
    {
        return self::getInstance()->rollBack();
    }
}
