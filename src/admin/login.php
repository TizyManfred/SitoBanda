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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin - Banda Folk di Castello Tesino</title>
    
    <!-- Favicon -->
    <link rel="icon" href="../public/assets/images/favicon.ico" type="image/x-icon">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    
    <!-- No robots meta tag -->
    <meta name="robots" content="noindex, nofollow">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">
                            <i class="fas fa-lock mr-2"></i>
                            Accesso Area Amministrativa
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <img src="../public/assets/images/logo.png" alt="Banda Folk di Castello Tesino" class="img-fluid mb-3" style="max-height: 80px;">
                            <h5>Banda Folk di Castello Tesino</h5>
                            <p class="text-muted">Inserisci le tue credenziali per accedere</p>
                        </div>
                        
                        <?php if (!empty($loginError)): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($loginError); ?>
                        </div>
                        <?php endif; ?>
                        
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="form-group">
                                <label for="username">
                                    <i class="fas fa-user text-muted mr-2"></i>Username
                                </label>
                                <input type="text" class="form-control" id="username" name="username" required autofocus>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">
                                    <i class="fas fa-key text-muted mr-2"></i>Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember_me" name="remember_me">
                                    <label class="custom-control-label" for="remember_me">Ricordami</label>
                                </div>
                            </div>
                            
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Accedi
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-light py-3 text-center">
                        <a href="../public/index.php" class="text-muted">
                            <i class="fas fa-arrow-left mr-1"></i>Torna al sito
                        </a>
                    </div>
                </div>
                <div class="text-center mt-3 text-muted small">
                    <p>&copy; <?php echo date('Y'); ?> Banda Folk di Castello Tesino. Tutti i diritti riservati.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
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
