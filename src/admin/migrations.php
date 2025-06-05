<?php
/**
 * Database Migrations CLI Tool
 *
 * Command-line interface for managing database migrations
 * Following PSR-12 coding standards and security best practices
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */

// Define ABSPATH for security
define('ABSPATH', dirname(__DIR__) . '/');

// Include configuration and authentication
require_once ABSPATH . 'includes/config.php';
require_once ABSPATH . 'includes/functions.php';
require_once ABSPATH . 'includes/auth.php';
require_once ABSPATH . 'includes/database.php';
require_once ABSPATH . 'includes/migrations/migration_manager.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if script is being run from CLI
$isCli = (php_sapi_name() === 'cli');

// If not CLI, require admin login
if (!$isCli) {
    Auth::requireLogin();
}

// Get current user
$currentUser = Auth::getCurrentUser();


// Initialize Migration Manager
$migrationsDir = ABSPATH . 'includes/migrations/';
$migrationManager = new MigrationManager(Database::getInstance(), $migrationsDir);

// Helper function to display results
function displayResults($results, $isCli)
{
    if (isset($results['message'])) {
        echo $isCli ? $results['message'] . PHP_EOL : "<p>{$results['message']}</p>";
        return;
    }
    
    if (empty($results)) {
        echo $isCli ? "No actions performed." . PHP_EOL : "<p>Nessuna azione eseguita.</p>";
        return;
    }
    
    if ($isCli) {
        foreach ($results as $result) {
            echo "{$result['action']} {$result['migration']}: {$result['status']}" . PHP_EOL;
        }
    } else {
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Migrazione</th><th>Azione</th><th>Stato</th></tr></thead>";
        echo "<tbody>";
        foreach ($results as $result) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($result['migration']) . "</td>";
            echo "<td>" . htmlspecialchars($result['action']) . "</td>";
            echo "<td>" . htmlspecialchars($result['status']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    }
}

// Process command line arguments if running from CLI
if ($isCli) {
    // Get command line arguments
    $command = $argv[1] ?? 'help';
    
    // Execute command
    try {
        switch ($command) {
            case 'migrate':
                echo "Running migrations..." . PHP_EOL;
                $results = $migrationManager->migrate();
                displayResults($results, true);
                break;
                
            case 'rollback':
                $steps = isset($argv[2]) ? (int)$argv[2] : 1;
                echo "Rolling back {$steps} batch(es)..." . PHP_EOL;
                $results = $migrationManager->rollback($steps);
                displayResults($results, true);
                break;
                
            case 'reset':
                echo "Resetting all migrations..." . PHP_EOL;
                $results = $migrationManager->reset();
                displayResults($results, true);
                break;
                
            case 'status':
                echo "Migration Status:" . PHP_EOL;
                echo "Applied Migrations:" . PHP_EOL;
                foreach ($migrationManager->getAppliedMigrations() as $migration) {
                    echo "- {$migration}" . PHP_EOL;
                }
                
                echo PHP_EOL . "Pending Migrations:" . PHP_EOL;
                $pending = $migrationManager->getPendingMigrations();
                if (empty($pending)) {
                    echo "- None" . PHP_EOL;
                } else {
                    foreach ($pending as $migration) {
                        echo "- {$migration}" . PHP_EOL;
                    }
                }
                break;
                
            case 'create':
                if (!isset($argv[2])) {
                    echo "Error: Migration name is required." . PHP_EOL;
                    echo "Usage: php migrations.php create <migration_name>" . PHP_EOL;
                    exit(1);
                }
                
                $name = $argv[2];
                $file = $migrationManager->createMigration($name);
                echo "Migration created: " . basename($file) . PHP_EOL;
                break;
                
            case 'help':
                echo "SitoBanda Migrations Tool" . PHP_EOL;
                echo "======================" . PHP_EOL;
                echo "Usage: php migrations.php <command> [options]" . PHP_EOL . PHP_EOL;
                echo "Available commands:" . PHP_EOL;
                echo "  migrate           Run all pending migrations" . PHP_EOL;
                echo "  rollback [steps]  Rollback the last batch or specified number of batches" . PHP_EOL;
                echo "  reset             Rollback all migrations" . PHP_EOL;
                echo "  status            Show migration status" . PHP_EOL;
                echo "  create <n>     Create a new migration" . PHP_EOL;
                echo "  help              Display this help message" . PHP_EOL;
                break;
                
            default:
                echo "Error: Unknown command '{$command}'." . PHP_EOL;
                echo "Run 'php migrations.php help' for usage information." . PHP_EOL;
                exit(1);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
        exit(1);
    }
    
    exit(0);
}

// Web interface handling
$pageTitle = 'Gestione Migrazioni Database';
$action = $_GET['action'] ?? 'status';
$message = '';
$results = [];

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        switch ($_POST['action']) {
            case 'migrate':
                $results = $migrationManager->migrate();
                $message = 'Migrazione completata con successo.';
                break;
                
            case 'rollback':
                $steps = isset($_POST['steps']) ? (int)$_POST['steps'] : 1;
                $results = $migrationManager->rollback($steps);
                $message = 'Rollback completato con successo.';
                break;
                
            case 'reset':
                // Add confirmation check
                if (!isset($_POST['confirm']) || $_POST['confirm'] !== 'yes') {
                    $message = 'Per favore conferma il reset delle migrazioni.';
                } else {
                    $results = $migrationManager->reset();
                    $message = 'Reset delle migrazioni completato con successo.';
                }
                break;
                
            case 'create':
                if (empty($_POST['name'])) {
                    $message = 'Il nome della migrazione è obbligatorio.';
                } else {
                    $file = $migrationManager->createMigration($_POST['name']);
                    $message = 'Migrazione creata: ' . basename($file);
                }
                break;
        }
        
        // Log activity if successful
        if (!empty($results) || strpos($message, 'completato con successo') !== false) {
            Auth::logActivity(
                $_SESSION['user_id'] ?? 0,
                'ha gestito le migrazioni del database',
                isset($_POST['action']) ? 'Azione: ' . $_POST['action'] : ''
            );
        }
    } catch (Exception $e) {
        $message = 'Errore: ' . $e->getMessage();
    }
}

// Include the standard header template
include_once ABSPATH . 'admin/templates/head_adminlte.php';
include_once ABSPATH . 'admin/templates/header_adminlte.php';
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gestione Migrazioni Database</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <?php if (!empty($message)): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="list-group">
                        <a href="?action=status" class="list-group-item list-group-item-action <?php echo $action === 'status' ? 'active' : ''; ?>">
                            <i class="fas fa-info-circle mr-2"></i> Stato Migrazioni
                        </a>
                        <a href="?action=migrate" class="list-group-item list-group-item-action <?php echo $action === 'migrate' ? 'active' : ''; ?>">
                            <i class="fas fa-arrow-circle-up mr-2"></i> Esegui Migrazioni
                        </a>
                        <a href="?action=rollback" class="list-group-item list-group-item-action <?php echo $action === 'rollback' ? 'active' : ''; ?>">
                            <i class="fas fa-arrow-circle-down mr-2"></i> Rollback
                        </a>
                        <a href="?action=reset" class="list-group-item list-group-item-action <?php echo $action === 'reset' ? 'active' : ''; ?>">
                            <i class="fas fa-undo mr-2"></i> Reset
                        </a>
                        <a href="?action=create" class="list-group-item list-group-item-action <?php echo $action === 'create' ? 'active' : ''; ?>">
                            <i class="fas fa-plus-circle mr-2"></i> Crea Migrazione
                        </a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <?php if ($action === 'status'): ?>
                                <i class="fas fa-info-circle mr-1"></i> Stato Migrazioni
                            <?php elseif ($action === 'migrate'): ?>
                                <i class="fas fa-arrow-circle-up mr-1"></i> Esegui Migrazioni
                            <?php elseif ($action === 'rollback'): ?>
                                <i class="fas fa-arrow-circle-down mr-1"></i> Rollback
                            <?php elseif ($action === 'reset'): ?>
                                <i class="fas fa-undo mr-1"></i> Reset
                            <?php elseif ($action === 'create'): ?>
                                <i class="fas fa-plus-circle mr-1"></i> Crea Migrazione
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <?php if ($action === 'status'): ?>
                                <h5 class="mb-3">Migrazioni Applicate</h5>
                                <?php 
                                $applied = $migrationManager->getAppliedMigrations();
                                if (empty($applied)): 
                                ?>
                                    <p class="text-muted">Nessuna migrazione applicata.</p>
                                <?php else: ?>
                                    <ul class="list-group mb-4">
                                        <?php foreach ($applied as $migration): ?>
                                            <li class="list-group-item">
                                                <i class="fas fa-check-circle text-success mr-2" aria-hidden="true"></i>
                                                <span><?php echo htmlspecialchars($migration); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <h5 class="mb-3">Migrazioni in Attesa</h5>
                                <?php 
                                $pending = $migrationManager->getPendingMigrations();
                                if (empty($pending)): 
                                ?>
                                    <p class="text-muted">Nessuna migrazione in attesa.</p>
                                <?php else: ?>
                                    <ul class="list-group">
                                        <?php foreach ($pending as $migration): ?>
                                            <li class="list-group-item">
                                                <i class="fas fa-clock text-warning mr-2" aria-hidden="true"></i>
                                                <span><?php echo htmlspecialchars($migration); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            <?php elseif ($action === 'migrate'): ?>
                                <p>Esegui tutte le migrazioni in attesa.</p>
                                <form method="post" action="?action=migrate">
                                    <input type="hidden" name="action" value="migrate">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-arrow-circle-up mr-1"></i> Esegui Migrazioni
                                    </button>
                                </form>
                                <?php if (!empty($results)): ?>
                                    <div class="mt-4">
                                        <h5>Risultati</h5>
                                        <?php displayResults($results, false); ?>
                                    </div>
                                <?php endif; ?>
                            <?php elseif ($action === 'rollback'): ?>
                                <p>Esegui il rollback dell'ultimo batch di migrazioni o del numero specificato di batch.</p>
                                <form method="post" action="?action=rollback">
                                    <input type="hidden" name="action" value="rollback">
                                    <div class="form-group">
                                        <label for="steps">Numero di batch</label>
                                        <input type="number" class="form-control" id="steps" name="steps" value="1" min="1" max="10">
                                        <small class="form-text text-muted">Specificare il numero di batch di cui eseguire il rollback.</small>
                                    </div>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-arrow-circle-down mr-1"></i> Esegui Rollback
                                    </button>
                                </form>
                                <?php if (!empty($results)): ?>
                                    <div class="mt-4">
                                        <h5>Risultati</h5>
                                        <?php displayResults($results, false); ?>
                                    </div>
                                <?php endif; ?>
                            <?php elseif ($action === 'reset'): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle mr-1" aria-hidden="true"></i>
                                    <strong>Attenzione:</strong> Questa operazione ripristinerà tutte le migrazioni e cancellerà tutti i dati associati.
                                </div>
                                <form method="post" action="?action=reset">
                                    <input type="hidden" name="action" value="reset">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="confirm" name="confirm" value="yes">
                                            <label class="custom-control-label" for="confirm">
                                                Sono consapevole che questa operazione è irreversibile e potrebbe causare la perdita di dati.
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-undo mr-1"></i> Reset Completo
                                    </button>
                                </form>
                                <?php if (!empty($results)): ?>
                                    <div class="mt-4">
                                        <h5>Risultati</h5>
                                        <?php displayResults($results, false); ?>
                                    </div>
                                <?php endif; ?>
                            <?php elseif ($action === 'create'): ?>
                                <p>Crea una nuova migrazione del database.</p>
                                <form method="post" action="?action=create">
                                    <input type="hidden" name="action" value="create">
                                    <div class="form-group">
                                        <label for="name">Nome Migrazione</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="create_users_table" required>
                                        <small class="form-text text-muted">Utilizzare la convenzione di denominazione snake_case.</small>
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus-circle mr-1"></i> Crea Migrazione
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /.container-fluid -->
    </div> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            alert.classList.remove('show');
        });
    }, 5000);
});
</script>


<?php include_once __DIR__ . '/templates/body_end_adminlte.php'; ?>