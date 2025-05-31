<?php
/**
 * Admin Dashboard
 *
 * Main admin dashboard for SitoBanda website
 * Following PSR-12 coding standards and security best practices
 */

// Define ABSPATH for security
define('ABSPATH', dirname(__DIR__) . '/');

// Include configuration and authentication
require_once ABSPATH . 'includes/config.php';
require_once ABSPATH . 'includes/functions.php';
require_once ABSPATH . 'includes/auth.php';
require_once ABSPATH . 'includes/database.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not authenticated
Auth::requireLogin();

// Get current user
$currentUser = Auth::getCurrentUser();

// Get dashboard stats - In a real app, these would come from database
$stats = [
    'events' => [
        'count' => 12,
        'label' => 'Eventi',
        'icon' => 'calendar-alt',
        'color' => 'primary',
        'change' => '+2 questa settimana'
    ],
    'members' => [
        'count' => 25,
        'label' => 'Membri',
        'icon' => 'users',
        'color' => 'success',
        'change' => 'Nessuna variazione'
    ],
    'gallery' => [
        'count' => 84,
        'label' => 'Foto',
        'icon' => 'images',
        'color' => 'warning',
        'change' => '+5 questo mese'
    ],
    'messages' => [
        'count' => 3,
        'label' => 'Messaggi',
        'icon' => 'envelope',
        'color' => 'danger',
        'change' => '2 non letti'
    ]
];

// Get recent activities - In a real app, this would come from database
$recentActivities = [
    [
        'user' => 'Admin',
        'action' => 'ha aggiunto un nuovo evento',
        'item' => 'Concerto d\'Estate 2024',
        'time' => '2 ore fa',
        'icon' => 'calendar-plus'
    ],
    [
        'user' => 'Admin',
        'action' => 'ha caricato nuove foto',
        'item' => 'Galleria "Sfilata San Ippolito"',
        'time' => '1 giorno fa',
        'icon' => 'upload'
    ],
    [
        'user' => 'Admin',
        'action' => 'ha aggiornato le informazioni',
        'item' => 'Pagina Chi Siamo',
        'time' => '3 giorni fa',
        'icon' => 'edit'
    ],
    [
        'user' => 'Maria',
        'action' => 'ha inviato un messaggio',
        'item' => 'Richiesta Informazioni',
        'time' => '1 settimana fa',
        'icon' => 'envelope'
    ],
    [
        'user' => 'Admin',
        'action' => 'ha aggiunto un nuovo membro',
        'item' => 'Marco Rossi - Tromba',
        'time' => '2 settimane fa',
        'icon' => 'user-plus'
    ]
];

// Get upcoming events - In a real app, this would come from database
$upcomingEvents = get_upcoming_events(5);

// Page title
$pageTitle = 'Dashboard';

// Include header part
include_once 'templates/header.php';
?>

<!-- Main Content -->
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="events/add.php" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-plus"></i> Nuovo Evento
                </a>
                <a href="gallery/upload.php" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-upload"></i> Carica Foto
                </a>
            </div>
        </div>
    </div>
    
    <!-- Welcome Alert -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg mr-3"></i>
            <div>
                <strong>Benvenuto, <?php echo htmlspecialchars($currentUser['first_name'] ?? $currentUser['username']); ?>!</strong>
                <p class="mb-0">Questa è la dashboard amministrativa del sito della Banda Folk di Castello Tesino. Da qui puoi gestire tutti i contenuti del sito.</p>
            </div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <?php foreach ($stats as $key => $stat): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 stats-card <?php echo $stat['color']; ?>">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $stat['count']; ?></div>
                            <div class="text-muted"><?php echo $stat['label']; ?></div>
                            <small class="text-muted"><?php echo $stat['change']; ?></small>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-<?php echo $stat['icon']; ?>"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?php echo $key; ?>/index.php" class="text-<?php echo $stat['color']; ?> small">
                        Visualizza dettagli <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <!-- Upcoming Events -->
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Prossimi Eventi
                    </h5>
                    <a href="events/index.php" class="btn btn-sm btn-outline-primary">
                        Tutti gli eventi
                    </a>
                </div>
                <div class="card-body">
                    <?php if (empty($upcomingEvents)): ?>
                    <p class="text-center text-muted py-3">Nessun evento in programma</p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 100px">Data</th>
                                    <th>Evento</th>
                                    <th>Luogo</th>
                                    <th style="width: 100px">Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($upcomingEvents as $event): ?>
                                <tr>
                                    <td>
                                        <span class="badge badge-pill badge-primary">
                                            <?php echo htmlspecialchars($event['day'] . ' ' . $event['month']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                                    <td>
                                        <div class="btn-group table-action-buttons">
                                            <a href="events/edit.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Modifica">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="events/delete.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-outline-danger" title="Elimina" onclick="return confirm('Sei sicuro di voler eliminare questo evento?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history mr-2"></i>
                        Attività Recenti
                    </h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($recentActivities as $activity): ?>
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="activity-icon mr-3">
                                    <i class="fas fa-<?php echo $activity['icon']; ?>"></i>
                                </div>
                                <div>
                                    <p class="mb-1">
                                        <strong><?php echo htmlspecialchars($activity['user']); ?></strong>
                                        <?php echo htmlspecialchars($activity['action']); ?>:
                                        <span class="text-primary"><?php echo htmlspecialchars($activity['item']); ?></span>
                                    </p>
                                    <small class="text-muted">
                                        <i class="far fa-clock mr-1"></i>
                                        <?php echo htmlspecialchars($activity['time']); ?>
                                    </small>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="activities/index.php" class="btn btn-sm btn-outline-secondary">
                        Visualizza tutte le attività
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Quick Links -->
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-link mr-2"></i>
                        Accesso Rapido
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4 mb-4">
                            <a href="members/index.php" class="d-block quick-link p-3">
                                <div class="quick-link-icon mb-2">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                                <span>Membri</span>
                            </a>
                        </div>
                        <div class="col-4 mb-4">
                            <a href="gallery/index.php" class="d-block quick-link p-3">
                                <div class="quick-link-icon mb-2">
                                    <i class="fas fa-images fa-2x"></i>
                                </div>
                                <span>Galleria</span>
                            </a>
                        </div>
                        <div class="col-4 mb-4">
                            <a href="messages/index.php" class="d-block quick-link p-3">
                                <div class="quick-link-icon mb-2">
                                    <i class="fas fa-envelope fa-2x"></i>
                                </div>
                                <span>Messaggi</span>
                            </a>
                        </div>
                        <div class="col-4 mb-4">
                            <a href="pages/index.php" class="d-block quick-link p-3">
                                <div class="quick-link-icon mb-2">
                                    <i class="fas fa-file-alt fa-2x"></i>
                                </div>
                                <span>Pagine</span>
                            </a>
                        </div>
                        <div class="col-4 mb-4">
                            <a href="settings/index.php" class="d-block quick-link p-3">
                                <div class="quick-link-icon mb-2">
                                    <i class="fas fa-cogs fa-2x"></i>
                                </div>
                                <span>Impostazioni</span>
                            </a>
                        </div>
                        <div class="col-4 mb-4">
                            <a href="backup/index.php" class="d-block quick-link p-3">
                                <div class="quick-link-icon mb-2">
                                    <i class="fas fa-database fa-2x"></i>
                                </div>
                                <span>Backup</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- To Do List -->
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-tasks mr-2"></i>
                        Promemoria
                    </h5>
                    <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#addTaskModal">
                        <i class="fas fa-plus"></i> Nuovo
                    </button>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="task1">
                                <label class="custom-control-label" for="task1">
                                    Aggiornare la lista degli eventi estivi
                                </label>
                                <small class="d-block text-muted mt-1">Scadenza: 15/06/2024</small>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="task2" checked>
                                <label class="custom-control-label" for="task2">
                                    <s>Caricare le foto del concerto di Natale</s>
                                </label>
                                <small class="d-block text-muted mt-1">Completato: 10/01/2024</small>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="task3">
                                <label class="custom-control-label" for="task3">
                                    Aggiornare la lista dei membri
                                </label>
                                <small class="d-block text-muted mt-1">Scadenza: 30/06/2024</small>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="task4">
                                <label class="custom-control-label" for="task4">
                                    Controllare i messaggi dei contatti
                                </label>
                                <small class="d-block text-danger mt-1">Urgente: 3 messaggi non letti</small>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="tasks/index.php" class="btn btn-sm btn-outline-secondary">
                        Gestisci tutti i promemoria
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Aggiungi Promemoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="taskForm">
                    <div class="form-group">
                        <label for="taskTitle">Titolo</label>
                        <input type="text" class="form-control" id="taskTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="taskDescription">Descrizione (opzionale)</label>
                        <textarea class="form-control" id="taskDescription" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="taskDueDate">Data di scadenza</label>
                        <input type="date" class="form-control" id="taskDueDate">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="taskPriority">
                            <label class="custom-control-label" for="taskPriority">Contrassegna come urgente</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-primary">Salva</button>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
include_once 'templates/footer.php';
?>
