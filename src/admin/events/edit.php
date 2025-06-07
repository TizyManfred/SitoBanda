<?php
/**
 * Event Editor
 *
 * Create or edit an event
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

// Initialize variables
$eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$event = [
    'title' => '',
    'slug' => '',
    'description' => '',
    'short_description' => '',
    'location' => '',
    'address' => '',
    'start_datetime' => date('Y-m-d'),
    'end_datetime' => '',
    'gallery_id' => null,
    'image_path' => '',
    'is_featured' => 0,
    'is_public' => 1,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
];

// Get galleries for the dropdown
$galleries = [];
try {
    // First try with 'name' column
    $stmt = $pdo->query("SHOW COLUMNS FROM gallery_albums LIKE 'name'");
    $nameColumnExists = $stmt->rowCount() > 0;
    
    if ($nameColumnExists) {
        $stmt = $pdo->query("SELECT id, name as title FROM gallery_albums ORDER BY name");
    } else {
        // Fall back to 'title' column
        $stmt = $pdo->query("SELECT id, title FROM gallery_albums ORDER BY title");
    }
    
    $galleries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Fetched " . count($galleries) . " galleries");
} catch (PDOException $e) {
    error_log("Error fetching galleries: " . $e->getMessage());
    // Try to get table structure for debugging
    try {
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        error_log("Available tables: " . implode(', ', $tables));
        if (in_array('gallery_albums', $tables)) {
            $columns = $pdo->query("SHOW COLUMNS FROM gallery_albums")->fetchAll(PDO::FETCH_COLUMN);
            error_log("Columns in gallery_albums: " . implode(', ', $columns));
        }
    } catch (Exception $debugE) {
        error_log("Debug error: " . $debugE->getMessage());
    }
}
$errors = [];
$isEdit = false;

// If editing, fetch the event data
if ($eventId) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$eventId]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($event) {
        $isEdit = true;
        // Format date for HTML input
        $event['start_datetime'] = date('Y-m-d', strtotime($event['start_datetime']));
        if ($event['end_datetime']) {
            $event['end_datetime'] = date('Y-m-d', strtotime($event['end_datetime']));
        }
    } else {
        $_SESSION['error_message'] = 'Evento non trovato.';
        header('Location: index.php');
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $event['title'] = trim($_POST['title'] ?? '');
    $event['slug'] = createSlug($event['title']);
    $event['description'] = trim($_POST['description'] ?? '');
    $event['short_description'] = trim($_POST['short_description'] ?? '');
    $event['location'] = trim($_POST['location'] ?? '');
    $event['address'] = trim($_POST['address'] ?? '');
    $event['start_datetime'] = trim($_POST['start_datetime'] ?? '');
    $event['end_datetime'] = !empty($_POST['end_datetime']) ? trim($_POST['end_datetime']) : null;
    $event['gallery_id'] = !empty($_POST['gallery_id']) ? (int)$_POST['gallery_id'] : null;
    $event['is_featured'] = isset($_POST['is_featured']) ? 1 : 0;
    $event['is_public'] = isset($_POST['is_public']) ? 1 : 0;
    
    // Handle file upload
    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = ABSPATH . 'uploads/events/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('event_') . '.' . $fileExtension;
        $targetPath = $uploadDir . $fileName;
        
        // Check if file is an image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = mime_content_type($_FILES['event_image']['tmp_name']);
        
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Formato file non supportato. Sono supportati solo file JPG, PNG, GIF e WebP.';
        } elseif (move_uploaded_file($_FILES['event_image']['tmp_name'], $targetPath)) {
            // Delete old image if it exists
            if (!empty($event['image_path']) && file_exists(ABSPATH . $event['image_path'])) {
                unlink(ABSPATH . $event['image_path']);
            }
            $event['image_path'] = 'uploads/events/' . $fileName;
        } else {
            $errors[] = 'Si è verificato un errore durante il caricamento del file.';
        }
    }
    
    // Validate required fields
    if (empty($event['title'])) {
        $errors[] = 'Il titolo è obbligatorio.';
    }
    
    if (empty($event['start_datetime'])) {
        $errors[] = 'La data e ora di inizio sono obbligatorie.';
    }
    
    if (empty($event['location'])) {
        $errors[] = 'Il luogo è obbligatorio.';
    }
    
    // If no errors, save the event
    if (empty($errors)) {
        try {
            $pdo->beginTransaction();
            
            if ($isEdit) {
                // Update existing event
                $stmt = $pdo->prepare("UPDATE events SET title = ?, slug = ?, description = ?, short_description = ?, location = ?, address = ?, start_datetime = ?, end_datetime = ?, gallery_id = ?, image_path = ?, is_featured = ?, is_public = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([
                    $event['title'],
                    $event['slug'],
                    $event['description'],
                    $event['short_description'],
                    $event['location'],
                    $event['address'],
                    $event['start_datetime'],
                    $event['end_datetime'],
                    $event['gallery_id'],
                    $event['image_path'],
                    $event['is_featured'],
                    $event['is_public'],
                    $eventId
                ]);
            } else {
                // Insert new event
                $stmt = $pdo->prepare("INSERT INTO events (title, slug, description, short_description, location, address, start_datetime, end_datetime, gallery_id, image_path, is_featured, is_public, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $event['title'],
                    $event['slug'],
                    $event['description'],
                    $event['short_description'],
                    $event['location'],
                    $event['address'],
                    $event['start_datetime'],
                    $event['end_datetime'],
                    $event['gallery_id'],
                    $event['image_path'],
                    $event['is_featured'],
                    $event['is_public'],
                    $event['created_at'],
                    $event['updated_at']
                ]);
            }
            
            // If new event, get the ID
            if (!$isEdit) {
                $eventId = $pdo->lastInsertId();
            }
            
            $pdo->commit();
            
            // Set success message
            $_SESSION['success_message'] = $isEdit ? 
                'Evento aggiornato con successo!' : 
                'Evento creato con successo!';
            
            // Handle save and continue
            if (isset($_POST['save_continue'])) {
                header('Location: edit.php?id=' . $eventId);
                exit;
            } else {
                header('Location: index.php');
                exit;
            }
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = 'Errore durante il salvataggio: ' . $e->getMessage();
        }
    }
}

/**
 * Create a URL-friendly slug from a string
 */
function createSlug($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    $text = preg_replace('~-+~', '-', $text);
    return $text ?: 'event';
}

// Page title
$pageTitle = 'Gestione Eventi';

// Include new template structure
ini_set('upload_max_filesize', '5M');
ini_set('post_max_size', '6M');
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
                    <h1 class="m-0"><?= $isEdit ? 'Modifica Evento' : 'Nuovo Evento' ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/admin/">Home</a></li>
                        <li class="breadcrumb-item"><a href="index.php">Eventi</a></li>
                        <li class="breadcrumb-item active"><?= $isEdit ? 'Modifica' : 'Nuovo' ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Errori:</h5>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card card-primary">
                <form method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Main Content -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Dettagli Evento</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title">Titolo *</label>
                                            <input type="text" class="form-control" id="title" name="title" 
                                                   value="<?= htmlspecialchars($event['title']) ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="short_description">Breve Descrizione</label>
                                            <textarea class="form-control" id="short_description" name="short_description" 
                                                      rows="2" maxlength="255"><?= htmlspecialchars($event['short_description']) ?></textarea>
                                            <small class="text-muted">Massimo 255 caratteri</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Descrizione Completa</label>
                                            <textarea class="form-control" id="description" name="description" 
                                                      rows="5"><?= htmlspecialchars($event['description']) ?></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="start_datetime">Data e Ora Inizio *</label>
                                                    <input type="date" class="form-control" id="start_datetime" 
                                                           name="start_datetime" value="<?= htmlspecialchars($event['start_datetime']) ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_datetime">Data e Ora Fine (opzionale)</label>
                                                    <input type="date" class="form-control" id="end_datetime" 
                                                           name="end_datetime" value="<?= htmlspecialchars($event['end_datetime']) ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="location">Luogo *</label>
                                            <input type="text" class="form-control" id="location" name="location" 
                                                   value="<?= htmlspecialchars($event['location']) ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Indirizzo Completo</label>
                                            <textarea class="form-control" id="address" name="address" 
                                                      rows="2"><?= htmlspecialchars($event['address']) ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="gallery_id">Galleria Collegata</label>
                                            <select class="form-control" id="gallery_id" name="gallery_id">
                                                <option value="">Nessuna galleria</option>
                                                <?php foreach ($galleries as $gallery): ?>
                                                    <option value="<?= $gallery['id'] ?>" <?= ($event['gallery_id'] ?? null) == $gallery['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($gallery['title'] ?? 'Untitled Gallery') ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="event_image">Immagine dell'evento</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="event_image" name="event_image" accept="image/*">
                                                <label class="custom-file-label" for="event_image">Scegli file</label>
                                            </div>
                                            <?php if (!empty($event['image_path'])): ?>
                                                <div class="mt-2">
                                                    <img src="<?= SITE_URL . '/' . $event['image_path'] ?>" alt="Immagine evento" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                                                    <div class="form-check mt-2">
                                                        <input type="checkbox" class="form-check-input" id="remove_image" name="remove_image" value="1">
                                                        <label class="form-check-label" for="remove_image">Rimuovi immagine</label>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <small class="form-text text-muted">Formati supportati: JPG, PNG, GIF, WebP. Dimensione massima: 5MB</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Publish Box -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Pubblicazione</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_public" 
                                                       name="is_public" value="1" <?= $event['is_public'] ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="is_public">Pubblicato</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_featured" 
                                                       name="is_featured" value="1" <?= $event['is_featured'] ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="is_featured">In Evidenza</label>
                                            </div>
                                        </div>

                                        <hr>

                                        <?php if ($isEdit): ?>
                                            <div class="form-group">
                                                <label>Creato il:</label>
                                                <p><?= date('d/m/Y H:i', strtotime($event['created_at'])) ?></p>
                                            </div>

                                            <div class="form-group">
                                                <label>Ultimo aggiornamento:</label>
                                                <p><?= date('d/m/Y H:i', strtotime($event['updated_at'])) ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="save" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Salva
                                        </button>
                                        <button type="submit" name="save_continue" class="btn btn-info">
                                            <i class="fas fa-save"></i> Salva e continua
                                        </button>
                                        <a href="index.php" class="btn btn-default">Annulla</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Generate slug from title
        document.getElementById('title').addEventListener('blur', function() {
            if (!document.getElementById('slug').value) {
                generateSlug();
            }
        });

        function generateSlug() {
            const title = document.getElementById('title').value;
            if (title) {
                // Simple slug generation - replace with your preferred method
                const slug = title.toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special chars
                    .replace(/\s+/g, '-')      // Replace spaces with -
                    .replace(/--+/g, '-')      // Replace multiple - with single -
                    .trim();
                document.getElementById('slug').value = slug;
            }
        }

        // Update file input label with selected filename
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Scegli file';
            const label = e.target.nextElementSibling;
            label.textContent = fileName;
            
            // Show image preview if it's an image
            if (e.target.files[0] && e.target.files[0].type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    let preview = e.target.closest('.form-group').querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.className = 'mt-2 image-preview';
                        e.target.closest('.form-group').appendChild(preview);
                    }
                    preview.innerHTML = `
                        <img src="${event.target.result}" alt="Anteprima" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                    `;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
        
        // Handle remove image checkbox
        const removeImageCheckbox = document.getElementById('remove_image');
        if (removeImageCheckbox) {
            removeImageCheckbox.addEventListener('change', function() {
                const imagePreview = this.closest('.mt-2').querySelector('img');
                if (imagePreview) {
                    imagePreview.style.opacity = this.checked ? 0.5 : 1;
                }
            });
        }
    </script>
    
    <!-- Include the admin footer -->
    <?php include_once ABSPATH . 'admin/templates/body_end_adminlte.php'; ?>
</div>
