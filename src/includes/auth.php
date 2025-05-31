<?php
/**
 * Authentication System
 *
 * Handles admin authentication and session management
 * Following PSR-12 coding standards and security best practices
 */

// Define ABSPATH for security if not already defined
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__DIR__) . '/');
}

// Include necessary files
require_once ABSPATH . 'includes/config.php';
require_once ABSPATH . 'includes/database.php';
require_once ABSPATH . 'includes/functions.php';

/**
 * Class Auth - Handles user authentication
 */
class Auth
{
    /**
     * Attempt to authenticate a user
     *
     * @param string $username The username
     * @param string $password The password
     * @return bool True if authentication successful, false otherwise
     */
    public static function login(string $username, string $password): bool
    {
        // Sanitize inputs
        $username = sanitize_input($username);
        
        // Get user from database
        $user = Database::getRow(
            "SELECT * FROM users WHERE username = ? AND active = 1 LIMIT 1",
            [$username]
        );
        
        // Check if user exists and verify password
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['auth'] = true;
            
            // Regenerate session ID for security
            session_regenerate_id(true);
            
            // Update last login time
            Database::query(
                "UPDATE users SET last_login = NOW() WHERE id = ?",
                [$user['id']]
            );
            
            // Log successful login
            self::logActivity($user['id'], 'login', 'Login successful');
            
            return true;
        }
        
        // Log failed login attempt
        if ($user) {
            self::logActivity($user['id'], 'login_failed', 'Failed login attempt');
        } else {
            self::logActivity(0, 'login_failed', "Failed login attempt for username: $username");
        }
        
        return false;
    }
    
    /**
     * Log out the current user
     *
     * @return void
     */
    public static function logout(): void
    {
        // Log the logout if a user is logged in
        if (isset($_SESSION['user_id'])) {
            self::logActivity($_SESSION['user_id'], 'logout', 'User logged out');
        }
        
        // Unset all session variables
        $_SESSION = [];
        
        // If a session cookie is used, destroy it
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        // Destroy the session
        session_destroy();
    }
    
    /**
     * Check if a user is logged in
     *
     * @return bool True if user is logged in, false otherwise
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
    }
    
    /**
     * Check if the current user has a specific role
     *
     * @param string $role The role to check
     * @return bool True if user has the role, false otherwise
     */
    public static function hasRole(string $role): bool
    {
        return self::isLoggedIn() && $_SESSION['role'] === $role;
    }
    
    /**
     * Check if the current user is an admin
     *
     * @return bool True if user is an admin, false otherwise
     */
    public static function isAdmin(): bool
    {
        return self::hasRole('admin');
    }
    
    /**
     * Get current user information
     *
     * @return array|null User data or null if not logged in
     */
    public static function getCurrentUser(): ?array
    {
        if (!self::isLoggedIn()) {
            return null;
        }
        
        return Database::getRow(
            "SELECT id, username, email, role, first_name, last_name, created_at, last_login 
             FROM users WHERE id = ? LIMIT 1",
            [$_SESSION['user_id']]
        );
    }
    
    /**
     * Log user activity
     *
     * @param int $userId The user ID (0 for guest/unknown)
     * @param string $action The action performed
     * @param string $details Additional details about the action
     * @return bool True if logging was successful, false otherwise
     */
    public static function logActivity(int $userId, string $action, string $details = ''): bool
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        return (bool)Database::query(
            "INSERT INTO activity_logs (user_id, action, details, ip_address, user_agent) 
             VALUES (?, ?, ?, ?, ?)",
            [$userId, $action, $details, $ip, $userAgent]
        );
    }
    
    /**
     * Redirect if user is not logged in
     *
     * @param string $redirectTo URL to redirect to if not logged in
     * @return void
     */
    public static function requireLogin(string $redirectTo = '/admin/login.php'): void
    {
        if (!self::isLoggedIn()) {
            header("Location: $redirectTo");
            exit;
        }
    }
    
    /**
     * Redirect if user does not have admin role
     *
     * @param string $redirectTo URL to redirect to if not admin
     * @return void
     */
    public static function requireAdmin(string $redirectTo = '/admin/login.php'): void
    {
        if (!self::isAdmin()) {
            header("Location: $redirectTo");
            exit;
        }
    }
}
