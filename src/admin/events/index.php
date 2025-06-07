<?php
/**
 * Events Management
 *
 * Admin interface for managing events
 * Following PSR-12 coding standards and security best practices
 *
 * @version 1.0.0
 * @author SitoBanda Team
 */

// Define ABSPATH for security
define('ABSPATH', dirname(dirname(__DIR__)) . '/');

// Include configuration and authentication
require_once ABSPATH . 'includes/auth.php';
require_once ABSPATH . 'includes/database.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not authenticated
Auth::requireLogin();

// Initialize database connection
$pdo = Database::getInstance();

// Pagination settings
$perPage = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// First, check if the gallery_albums table has the expected structure
try {
    // Try to get the gallery names with a separate query
    $query = "
        SELECT e.id, e.title, e.start_datetime, e.end_datetime, e.location, 
               e.is_featured, e.is_public, e.image_path, e.gallery_id,
               g.title as gallery_name 
        FROM events e
        LEFT JOIN gallery_albums g ON e.gallery_id = g.id
        ORDER BY e.start_datetime DESC 
        LIMIT :limit OFFSET :offset
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // If the join fails, fall back to just getting the events
    error_log("Error fetching events with galleries: " . $e->getMessage());
    
    $query = "
        SELECT * FROM events 
        ORDER BY start_datetime DESC 
        LIMIT :limit OFFSET :offset
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Add empty gallery_name to each event
    foreach ($events as &$event) {
        $event['gallery_name'] = '';
    }
    unset($event);
}

// Format dates
foreach ($events as &$event) {
    $event['formatted_date'] = date('d/m/Y', strtotime($event['start_datetime']));
    if ($event['end_datetime'] && $event['end_datetime'] !== $event['start_datetime']) {
        $event['formatted_date'] .= ' - ' . date('d/m/Y', strtotime($event['end_datetime']));
    }
}
unset($event); // Break the reference

// Total events count for pagination
$totalStmt = $pdo->query("SELECT COUNT(*) FROM events");
$totalEvents = $totalStmt->fetchColumn();
$totalPages = ceil($totalEvents / $perPage);

// Handle event delete request
if (isset($_POST['delete_event']) && isset($_POST['event_id'])) {
    $eventId = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);

    if ($eventId) {
        try {
            $pdo->beginTransaction();
            
            // Delete the event
            $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
            $stmt->execute([$eventId]);
            
            $pdo->commit();
            $_SESSION['success_message'] = 'Evento eliminato con successo.';
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION['error_message'] = 'Errore durante l\'eliminazione dell\'evento: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error_message'] = 'ID evento non valido.';
    }
}

// Page title
$pageTitle = 'Gestione Eventi';

// Include new template structure
include_once ABSPATH . 'admin/templates/head_adminlte.php';
include_once ABSPATH . 'admin/templates/header_adminlte.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $pageTitle ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/admin/">Home</a></li>
                        <li class="breadcrumb-item active">Eventi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= htmlspecialchars($_SESSION['success_message']) ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= htmlspecialchars($_SESSION['error_message']) ?>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Elenco Eventi</h3>
                    <div class="card-tools">
                        <a href="edit.php" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Nuovo Evento
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($events)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Data</th>
                                        <th>Evento</th>
                                        <th>Luogo</th>
                                        <th>Galleria</th>
                                        <th>Stato</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $event): ?>
                                        <tr>
                                            <td><?= $event['id'] ?></td>
                                            <td><?= $event['formatted_date'] ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($event['image_path'])): ?>
                                                        <img src="<?= SITE_URL . '/' . $event['image_path'] ?>" alt="" class="img-thumbnail mr-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                    <?php endif; ?>
                                                    <div>
                                                        <?= htmlspecialchars($event['title']) ?>
                                                        <?php if ($event['is_featured']): ?>
                                                            <span class="badge bg-warning ml-1">In evidenza</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($event['location']) ?></td>
                                            <td>
                                                <?php if ($event['gallery_id']): ?>
                                                    <a href="<?= SITE_URL ?>/admin/gallery/edit.php?id=<?= $event['gallery_id'] ?>">
                                                        <?= htmlspecialchars($event['gallery_name'] ?? 'Galleria #' . $event['gallery_id']) ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Nessuna</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (strtotime($event['start_datetime']) > time()): ?>
                                                    <span class="badge bg-info">Prossimamente</span>
                                                <?php elseif (!empty($event['end_datetime']) && strtotime($event['end_datetime']) < time()): ?>
                                                    <span class="badge bg-secondary">Terminato</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">In corso</span>
                                                <?php endif; ?>
                                                <?php if (!$event['is_public']): ?>
                                                    <span class="badge bg-dark ml-1">Bozza</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="edit.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-primary" title="Modifica">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger delete-event" 
                                                        data-id="<?= $event['id'] ?>" 
                                                        data-title="<?= htmlspecialchars($event['title']) ?>"
                                                        title="Elimina">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="p-3">
                            <p class="mb-0">Nessun evento trovato. <a href="edit.php">Crea il tuo primo evento</a>.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($totalPages > 1): ?>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>">&laquo;</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>">&raquo;</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Delete Event Modal -->
    <div class="modal fade" id="deleteEventModal" tabindex="-1" role="dialog" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteEventModalLabel">Conferma eliminazione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Sei sicuro di voler eliminare l'evento <strong id="eventTitle"></strong>?</p>
                    <p class="text-danger">Questa azione non può essere annullata.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                    <form id="deleteEventForm" method="post" style="display: inline;">
                        <input type="hidden" name="delete_event" value="1">
                        <input type="hidden" name="event_id" id="deleteEventId" value="">
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
    // Delete event confirmation
    $(document).ready(function() {
        $('.delete-event').on('click', function(e) {
            e.preventDefault();
            var eventId = $(this).data('id');
            var eventTitle = $(this).data('title');
            
            $('#eventTitle').text('"' + eventTitle + '"');
            $('#deleteEventId').val(eventId);
            $('#deleteEventModal').modal('show');
        });
    });
    </script>

    <?php
    // Include footer template
    include_once ABSPATH . 'admin/templates/body_end_adminlte.php';
    ?>
</div>