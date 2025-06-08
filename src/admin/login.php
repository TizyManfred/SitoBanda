<?php
/**
 * Admin Login Page
 *
 * Login form for SitoBanda website administration
 * Following PSR-12 coding standards and security best practices
 */

// Define ABSPATH for security
define('ABSPATH', dirname(__DIR__) . '/');

// Include configuration and authentication
require_once ABSPATH . 'includes/config.php';
require_once ABSPATH . 'includes/functions.php';
require_once ABSPATH . 'includes/auth.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, redirect to dashboard
if (Auth::isLoggedIn()) {
    header('Location: index.php');
    exit;
}

// Process login form
$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? sanitize_input($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $rememberMe = isset($_POST['remember_me']);
    
    // Validate input
    if (empty($username) || empty($password)) {
        $loginError = 'Inserisci username e password.';
    } else {
        // Debug: Check if user exists in database
        $debugUser = Database::getRow(
            "SELECT * FROM users WHERE username = ?",
            [$username]
        );
        
        if ($debugUser) {
            error_log("User found: " . print_r($debugUser, true));
        } else {
            error_log("User not found with username: " . $username);
        }
        
        // Attempt login
        if (Auth::login($username, $password)) {
            // Set remember me cookie if requested
            if ($rememberMe) {
                $token = bin2hex(random_bytes(32));
                // Store token in database for this user
                // This is a simplified example - in production, you'd encrypt and store this token safely
                
                // Set cookie for 30 days
                setcookie(
                    'remember_token',
                    $token,
                    time() + (30 * 24 * 60 * 60),
                    '/',
                    '',
                    true, // Secure flag
                    true  // HttpOnly flag
                );
            }
            
            // Redirect to dashboard
            header('Location: index.php');
            exit;
        } else {
            $loginError = 'Username o password non validi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Banda Folk di Castello Tesino</title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo SITE_URL; ?>/assets/images/favicon.ico" type="image/x-icon">
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="assets/adminlte/css/adminlte.min.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="assets/css/custom-admin.css">
    
    <!-- No robots meta tag -->
    <meta name="robots" content="noindex, nofollow">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- Logo -->
        <div class="login-logo">
            <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" alt="Banda Folk di Castello Tesino" class="img-fluid">
            <p><b>Banda Folk</b> Amministrazione</p>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Inserisci le tue credenziali per accedere</p>
                
                <?php if (!empty($loginError)): ?>
                <div class="alert alert-danger">
                    <i class="icon fas fa-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($loginError); ?>
                </div>
                <?php endif; ?>
                
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                        <div class="input-group-append">
                            <button class="input-group-text" type="button" id="togglePassword" tabindex="-1">
                                <span class="fas fa-eye"></span>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember_me" name="remember_me">
                                <label for="remember_me">Ricordami</label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Accedi</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                
                <div class="mt-4 text-center">
                    <a href="<?php echo SITE_URL; ?>/" class="text-center">
                        <i class="fas fa-arrow-left mr-1"></i>Torna al sito
                    </a>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
        <div class="text-center mt-3 text-white small">
            <p>&copy; <?php echo date('Y'); ?> Banda Folk di Castello Tesino. Tutti i diritti riservati.</p>
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/adminlte/js/adminlte.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('span');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
