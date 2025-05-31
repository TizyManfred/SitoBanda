<?php
/**
 * Admin Events Management
 *
 * Lists and manages all events for SitoBanda website
 * Following PSR-12 coding standards and security best practices
 */

// Define ABSPATH for security
define('ABSPATH', dirname(dirname(__DIR__)) . '/');

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

// Handle event deletion if confirmed
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $eventId = (int)$_GET['id'];
    
    // In a real app, this would delete from the database
    // $db = Database::getInstance();
    // $success = $db->delete('events', 'id = ?', [$eventId]);
    
    // For demo, we'll just pretend it was successful
    $success = true;
    
    if ($success) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Evento eliminato con successo!'
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Errore durante l\'eliminazione dell\'evento.'
        ];
    }
    
    // Redirect to the same page to prevent refresh issues
    header('Location: index.php');
    exit;
}

// Get current year for filter
$currentYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

// Get all available years for the filter dropdown
// In a real app, this would come from the database
$availableYears = range(date('Y') + 1, date('Y') - 5);

// Get events for the selected year
// In a real app, these would come from the database
$events = [];

// Sample data for demonstration
$sampleEvents = [
    [
        'id' => 1,
        'title' => 'Concerto di Primavera',
        'date' => '2024-06-01 20:30:00',
        'location' => 'Piazza Maggiore, Castello Tesino',
        'description' => 'Concerto annuale di primavera con repertorio classico e moderno.',
        'is_public' => 1,
        'status' => 'upcoming'
    ],
    [
        'id' => 2,
        'title' => 'Processione San Giovanni',
        'date' => '2024-06-24 10:00:00',
        'location' => 'Chiesa Parrocchiale, Castello Tesino',
        'description' => 'Processione religiosa per la festa di San Giovanni.',
        'is_public' => 1,
        'status' => 'upcoming'
    ],
    [
        'id' => 3,
        'title' => 'Concerto d\'Estate',
        'date' => '2024-07-15 21:00:00',
        'location' => 'Parco Comunale, Castello Tesino',
        'description' => 'Concerto estivo con repertorio leggero e colonne sonore.',
        'is_public' => 1,
        'status' => 'upcoming'
    ],
    [
        'id' => 4,
        'title' => 'Sfilata Festa Patronale',
        'date' => '2024-08-10 17:00:00',
        'location' => 'Centro Storico, Castello Tesino',
        'description' => 'Sfilata per la festa patronale con repertorio tradizionale.',
        'is_public' => 1,
        'status' => 'upcoming'
    ],
    [
        'id' => 5,
        'title' => 'Concerto di Natale',
        'date' => '2024-12-23 20:30:00',
        'location' => 'Teatro Comunale, Castello Tesino',
        'description' => 'Tradizionale concerto natalizio con canti della tradizione.',
        'is_public' => 1,
        'status' => 'upcoming'
    ],
    [
        'id' => 6,
        'title' => 'Concerto di Capodanno',
        'date' => '2025-01-01 17:00:00',
        'location' => 'Piazza Maggiore, Castello Tesino',
        'description' => 'Concerto di inizio anno.',
        'is_public' => 0, // Not yet published
        'status' => 'draft'
    ]
];

// Filter events for the current year
foreach ($sampleEvents as $event) {
    $eventYear = date('Y', strtotime($event['date']));
    if ($eventYear == $currentYear) {
        $events[] = $event;
    }
}

// Calculate stats
$totalEvents = count($events);
$upcomingEvents = count(array_filter($events, function($e) {
    return strtotime($e['date']) > time();
}));
$pastEvents = count(array_filter($events, function($e) {
    return strtotime($e['date']) <= time();
}));
$draftEvents = count(array_filter($events, function($e) {
    return $e['status'] === 'draft';
}));

// Page title
$pageTitle = 'Eventi';

// Include header part
include_once '../templates/header.php';
?>

<!-- Main Content -->
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Gestione Eventi</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="add.php" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Nuovo Evento
                </a>
                <a href="categories.php" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-tags"></i> Categorie
                </a>
                <a href="export.php" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-download"></i> Esporta
                </a>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="yearDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Anno: <?php echo $currentYear; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="yearDropdown">
                    <?php foreach ($availableYears as $year): ?>
                    <a class="dropdown-item <?php echo $year === $currentYear ? 'active' : ''; ?>" href="?year=<?php echo $year; ?>">
                        <?php echo $year; ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if (isset($_SESSION['flash_message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['flash_message']['type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['flash_message']['message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php 
        // Clear the flash message
        unset($_SESSION['flash_message']);
    endif; 
    ?>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 stats-card primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $totalEvents; ?></div>
                            <div class="text-muted">Eventi Totali</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 stats-card success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $upcomingEvents; ?></div>
                            <div class="text-muted">Eventi Futuri</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 stats-card warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $pastEvents; ?></div>
                            <div class="text-muted">Eventi Passati</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 stats-card info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $draftEvents; ?></div>
                            <div class="text-muted">Bozze</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Events List -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt mr-2"></i>
                Eventi <?php echo $currentYear; ?>
            </h5>
            <div class="input-group input-group-sm w-auto">
                <input type="text" class="form-control" id="eventSearch" placeholder="Cerca evento...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if (empty($events)): ?>
            <div class="alert alert-info m-3">
                Nessun evento trovato per l'anno <?php echo $currentYear; ?>.
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" style="width: 80px">ID</th>
                            <th scope="col" style="width: 140px">Data</th>
                            <th scope="col">Titolo</th>
                            <th scope="col">Luogo</th>
                            <th scope="col" style="width: 100px">Stato</th>
                            <th scope="col" style="width: 140px">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): 
                            $eventDate = new DateTime($event['date']);
                            $isPast = $eventDate < new DateTime();
                            $statusClass = '';
                            $statusText = '';
                            
                            if ($event['status'] === 'draft') {
                                $statusClass = 'badge-secondary';
                                $statusText = 'Bozza';
                            } elseif ($isPast) {
                                $statusClass = 'badge-dark';
                                $statusText = 'Passato';
                            } else {
                                $statusClass = 'badge-success';
                                $statusText = 'Prossimo';
                            }
                        ?>
                        <tr class="<?php echo !$event['is_public'] ? 'table-warning' : ''; ?>">
                            <td><?php echo $event['id']; ?></td>
                            <td>
                                <span class="d-block"><?php echo $eventDate->format('d/m/Y'); ?></span>
                                <small class="text-muted"><?php echo $eventDate->format('H:i'); ?></small>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo $event['id']; ?>" class="event-title">
                                    <?php echo htmlspecialchars($event['title']); ?>
                                </a>
                                <?php if (!$event['is_public']): ?>
                                <span class="badge badge-warning ml-2">Non Pubblicato</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($event['location']); ?></td>
                            <td>
                                <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="edit.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-outline-primary" title="Modifica">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="../public/concerti.php?id=<?php echo $event['id']; ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Visualizza sul sito">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="?action=delete&id=<?php echo $event['id']; ?>" class="btn btn-sm btn-outline-danger delete-btn" 
                                       data-item-name="l'evento '<?php echo htmlspecialchars($event['title']); ?>'" title="Elimina">
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
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Mostra <?php echo count($events); ?> eventi di <?php echo $totalEvents; ?> totali</small>
            </div>
            <div>
                <a href="calendar.php" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-calendar"></i> Vista Calendario
                </a>
            </div>
        </div>
    </div>
    
    <!-- Upcoming Events Calendar -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-calendar-day mr-2"></i>
                Prossimi Eventi
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php 
                $upcomingEventsArray = array_filter($events, function($e) {
                    return strtotime($e['date']) > time() && $e['is_public'] == 1;
                });
                
                if (empty($upcomingEventsArray)): 
                ?>
                <div class="col-12">
                    <p class="text-center text-muted">Nessun evento programmato.</p>
                </div>
                <?php else: ?>
                <?php 
                $counter = 0;
                foreach ($upcomingEventsArray as $event): 
                    if ($counter >= 3) break; // Limit to 3 events
                    $counter++;
                    $eventDate = new DateTime($event['date']);
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 event-card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="event-date">
                                    <span class="event-day"><?php echo $eventDate->format('d'); ?></span>
                                    <span class="event-month"><?php echo $eventDate->format('M'); ?></span>
                                </div>
                                <div class="event-time">
                                    <i class="far fa-clock"></i> <?php echo $eventDate->format('H:i'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt text-muted mr-1"></i> 
                                <?php echo htmlspecialchars($event['location']); ?>
                            </p>
                            <p class="card-text event-description">
                                <?php echo mb_substr(htmlspecialchars($event['description']), 0, 100); ?>
                                <?php if (strlen($event['description']) > 100): ?>...<?php endif; ?>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="edit.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Modifica
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Event search functionality
    document.getElementById('eventSearch').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const title = row.querySelector('.event-title').textContent.toLowerCase();
            const location = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            
            if (title.includes(searchText) || location.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<?php
// Include footer
include_once '../templates/footer.php';
?>
