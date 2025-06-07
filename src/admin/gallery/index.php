<?php
/**
 * Gallery Albums Management
 *
 * Admin interface for managing gallery albums
 * Following PSR-12 coding standards and security best practices
 *
 * @version 1.1.0
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

// Fetch albums with image count
$stmt = $pdo->prepare("SELECT a.*, (SELECT COUNT(*) FROM gallery_items i WHERE i.album_id = a.id) AS image_count FROM gallery_albums a ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total albums count for pagination
$totalStmt = $pdo->query("SELECT COUNT(*) FROM gallery_albums");
$totalAlbums = $totalStmt->fetchColumn();
$totalPages = ceil($totalAlbums / $perPage);

// Handle album delete request
if (isset($_POST['delete_album']) && isset($_POST['album_id'])) {
    $albumId = filter_input(INPUT_POST, 'album_id', FILTER_VALIDATE_INT);

    if ($albumId) {
        // Begin transaction
        $pdo->beginTransaction();

        try {
            // Get album info for logging
            $stmt = $pdo->prepare("SELECT title FROM gallery_albums WHERE id = ?");
            $stmt->execute([$albumId]);
            $album = $stmt->fetch(PDO::FETCH_ASSOC);

            // Delete album (gallery_items will be deleted by foreign key constraint)
            $stmt = $pdo->prepare("DELETE FROM gallery_albums WHERE id = ?");
            $result = $stmt->execute([$albumId]);

            if ($result) {
                // Log the activity
                Auth::logActivity(
                    $_SESSION['user_id'],
                    'gallery_album_delete',
                    "Album eliminato: " . ($album['title'] ?? "ID: $albumId")
                );

                // Commit transaction
                $pdo->commit();

                // Set success message
                $_SESSION['success_message'] = "Album eliminato con successo.";
            } else {
                // Rollback transaction
                $pdo->rollBack();

                // Set error message
                $_SESSION['error_message'] = "Errore durante l'eliminazione dell'album.";
            }
        } catch (Exception $e) {
            // Rollback transaction
            $pdo->rollBack();

            // Log error
            error_log("Gallery album delete error: " . $e->getMessage());

            // Set error message
            $_SESSION['error_message'] = "Errore durante l'eliminazione dell'album.";
        }
    }

    // Redirect to prevent form resubmission
    header('Location: index.php');
    exit;
}

// Page title
$pageTitle = 'Gestione Galleria';

// Include new template structure
include_once ABSPATH . 'admin/templates/head_adminlte.php';
include_once ABSPATH . 'admin/templates/header_adminlte.php';
?>

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
                        <li class="breadcrumb-item"><a href="<?= SITE_URL ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Galleria</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="edit.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Crea Nuovo Album
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (!empty($albums)): ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Titolo</th>
                                    <th>Immagini</th>
                                    <th>Anno</th>
                                    <th>Stato</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($albums as $album): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($album['title']) ?></td>
                                        <td><span class="badge badge-info"><?= (int) $album['image_count'] ?></span></td>
                                        <td><?= $album['year'] ?></td>
                                        <td>
                                            <span
                                                class="badge <?= $album['is_published'] ? 'badge-success' : 'badge-secondary' ?>">
                                                <?= $album['is_published'] ? 'Pubblicato' : 'Bozza' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="edit.php?id=<?= $album['id'] ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger delete-album" data-id="<?= $album['id'] ?>"
                                                data-title="<?= htmlspecialchars($album['title']) ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Nessun album presente. Crea il tuo primo album!
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
    
    <!-- Delete Album Form (hidden) -->
    <form id="deleteAlbumForm" method="post" style="display: none;">
        <input type="hidden" name="delete_album" value="1">
        <input type="hidden" name="album_id" id="deleteAlbumId">
    </form>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete album button click
        const deleteButtons = document.querySelectorAll('.delete-album');
        const deleteForm = document.getElementById('deleteAlbumForm');
        const deleteAlbumId = document.getElementById('deleteAlbumId');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const albumId = this.getAttribute('data-id');
                const albumTitle = this.getAttribute('data-title');
                
                // Show confirmation dialog
                Swal.fire({
                    title: 'Conferma eliminazione',
                    text: `Sei sicuro di voler eliminare l'album "${albumTitle}"? Questa azione non può essere annullata.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sì, elimina',
                    cancelButtonText: 'Annulla',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Set the album ID and submit the form
                        deleteAlbumId.value = albumId;
                        deleteForm.submit();
                    }
                });
            });
        });
    });
    </script>

    <?php include_once ABSPATH . 'admin/templates/body_end_adminlte.php'; ?>

</div>