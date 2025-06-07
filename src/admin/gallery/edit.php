<?php

// Define ABSPATH for security
define('ABSPATH', dirname(dirname(__DIR__)) . '/');

require_once ABSPATH . 'includes/auth.php';
require_once ABSPATH . 'includes/database.php';

// Redirect to login if not authenticated
Auth::requireLogin();

// Initialize database connection
$pdo = Database::getInstance();

$albumId = isset($_GET['id']) ? (int) $_GET['id'] : null;
$errors = [];
$album = [];

// Fetch album data if ID is provided, otherwise prepare for new album creation
if ($albumId) {
    $stmt = $pdo->prepare("SELECT * FROM gallery_albums WHERE id = ?");
    $stmt->execute([$albumId]);
    $album = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$album) {
        // Album not found, redirect to index or handle error
        $_SESSION['error_message'] = 'Album non trovato.';
        header("Location: index.php");
        exit;
    }
} else {
    // Initialize default values for a new album
    $album = [
        'title' => '',
        'slug' => '',
        'description' => '',
        'year' => date('Y'), // Default to current year
        'is_published' => 0,
        'id' => null // Explicitly set ID to null for new albums
    ];
}

// Page title
$pageTitle = $albumId ? 'Modifica Album' : 'Crea Nuovo Album';

// --- Handle unified form submit (album + existing + new images) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Auto-generate slug
    function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u','-', $text);
        $text = iconv('utf-8','us-ascii//TRANSLIT',$text);
        $text = preg_replace('~[^-\w]+~','',$text);
        $text = trim($text,'-');
        $text = preg_replace('~-+~','-',$text);
        return strtolower($text) ?: 'n-a';
    }
    // Sanitize album data
    $album['title'] = trim($_POST['title']);
    $album['slug'] = slugify($album['title']);
    $album['description'] = trim($_POST['description']);
    $album['year'] = (int) $_POST['year'];
    $album['is_published'] = isset($_POST['is_published']) ? 1 : 0;
    // Validate
    if (empty($album['title'])) {
        $errors['title'] = 'Il titolo è obbligatorio';
    }
    if (empty($errors)) {
        $pdo->beginTransaction();
        try {
            // Album insert/update
            if ($albumId) {
                // First update album without cover image
                $stmt = $pdo->prepare('UPDATE gallery_albums SET title=?, slug=?, description=?, year=?, is_published=? WHERE id=?');
                $stmt->execute([$album['title'], $album['slug'], $album['description'], $album['year'], $album['is_published'], $albumId]);
            } else {
                // Create new album without cover image first
                $stmt = $pdo->prepare('INSERT INTO gallery_albums (title,slug,description,year,is_published,created_at) VALUES (?, ?, ?, ?, ?, NOW())');
                $stmt->execute([$album['title'],$album['slug'],$album['description'],$album['year'],$album['is_published']]);
                $albumId = $pdo->lastInsertId();
            }
            
            // Handle existing images
            $existingImages = $_POST['existing_images'] ?? [];
            $orders = $_POST['order'] ?? [];
            
            // First, get all current images to track deletions
            $stmt = $pdo->prepare('SELECT id, filename FROM gallery_items WHERE album_id = ?');
            $stmt->execute([$albumId]);
            $currentImages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $currentImageIds = array_column($currentImages, 'id');
            
            // Get submitted image IDs from the form
            $submittedIds = [];
            if (is_array($existingImages)) {
                $submittedIds = array_map('intval', array_filter(array_keys($existingImages), 'is_numeric'));
            }
            
            // Find images to delete (those not in the submitted list)
            $toDelete = array_diff($currentImageIds, $submittedIds);
            
            // Delete unsubmitted images and their files
            if ($toDelete) {
                // First, get filenames of images to delete
                $placeholders = implode(',', array_fill(0, count($toDelete), '?'));
                $stmt = $pdo->prepare("SELECT filename FROM gallery_items WHERE id IN($placeholders)");
                $stmt->execute(array_values($toDelete));
                $filesToDelete = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                // Delete from database
                $del = $pdo->prepare("DELETE FROM gallery_items WHERE id IN($placeholders)");
                $del->execute(array_values($toDelete));
                
                // Delete files from server
                foreach ($filesToDelete as $filename) {
                    $filePath = ABSPATH . 'uploads/album/' . $albumId . '/' . $filename;
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
            }
            // Update existing images
            if (is_array($existingImages)) {
                foreach ($existingImages as $id => $imageData) {
                    if (!is_numeric($id)) continue; // Skip non-numeric keys
                    
                    $id = (int)$id;
                    $title = isset($imageData['title']) ? htmlspecialchars(trim($imageData['title']), ENT_QUOTES) : '';
                    $description = isset($imageData['description']) ? htmlspecialchars(trim($imageData['description']), ENT_QUOTES) : '';
                    $isPublished = isset($imageData['is_published']) ? 1 : 0;
                    $order = isset($orders[$id]) ? (int)$orders[$id] : 0;
                    
                    // Use title as alt_text if alt_text is not provided
                    $altText = $title;
                    
                    $stmt = $pdo->prepare('UPDATE gallery_items SET title = ?, description = ?, alt_text = ?, is_published = ?, sort_order = ? WHERE id = ?');
                    $stmt->execute([$title, $description, $altText, $isPublished, $order, $id]);
                }
            }
            // New uploads
            // Handle new file uploads
            if (!empty($_FILES['images'])) {
                $newImagesMetadata = $_POST['new_images'] ?? [];
                $uploadDir = ABSPATH . 'uploads/album/' . $albumId . '/';
                
                // Create upload directory if it doesn't exist
                if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                    $errors[] = "Impossibile creare la cartella di upload: " . htmlspecialchars($uploadDir);
                    $pdo->rollBack();
                    $_SESSION['error_message'] = 'Errore durante il caricamento delle immagini';
                    header('Location: edit.php?id=' . $albumId);
                    exit();
                }
                
                // Process each uploaded file
                $uploadedFiles = $_FILES['images'];
                $fileCount = count($uploadedFiles['name']);
                
                for ($i = 0; $i < $fileCount; $i++) {
                    // Skip if no file was uploaded or there was an error
                    if ($uploadedFiles['error'][$i] !== UPLOAD_ERR_OK) {
                        if ($uploadedFiles['error'][$i] !== UPLOAD_ERR_NO_FILE) {
                            $errors[] = "Errore caricamento file (" . $uploadedFiles['error'][$i] . "): " . 
                                       htmlspecialchars($uploadedFiles['name'][$i] ?? "Nome file sconosciuto");
                        }
                        continue;
                    }
                    
                    $tmpName = $uploadedFiles['tmp_name'][$i];
                    $originalName = $uploadedFiles['name'][$i];
                    
                    // Validate file extension
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                    
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        $errors[] = "Tipo file non permesso per: " . htmlspecialchars($originalName);
                        continue;
                    }
                    
                    // Generate a safe filename
                    $safeFilename = uniqid('img_', true) . "." . $fileExtension;
                    $targetPath = $uploadDir . $safeFilename;
                    
                    // Move the uploaded file
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        // Get metadata for this file
                        $currentMeta = $newImagesMetadata[$i] ?? [];
                        
                        // Sanitize and prepare data
                        $newTitle = htmlspecialchars(trim($currentMeta['title'] ?? pathinfo($originalName, PATHINFO_FILENAME)), ENT_QUOTES);
                        $newAltText = htmlspecialchars(trim($currentMeta['alt_text'] ?? $newTitle), ENT_QUOTES);
                        $newDesc = htmlspecialchars(trim($currentMeta['description'] ?? ''), ENT_QUOTES);
                        $newPublished = (isset($currentMeta['is_published']) && ($currentMeta['is_published'] === '1' || $currentMeta['is_published'] === true)) ? 1 : 0;
                        $newOrder = isset($currentMeta['order']) && is_numeric($currentMeta['order']) ? (int)$currentMeta['order'] : ($i + 1000);
                        
                        // Insert into database
                        $stmt = $pdo->prepare('INSERT INTO gallery_items (album_id, filename, title, alt_text, description, is_published, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)');
                        if (!$stmt->execute([$albumId, $safeFilename, $newTitle, $newAltText, $newDesc, $newPublished, $newOrder])) {
                            $errors[] = "Errore database salvando l'immagine: " . htmlspecialchars($originalName);
                            // Try to remove the uploaded file if database insert failed
                            @unlink($targetPath);
                        }
                    } else {
                        $errors[] = "Impossibile spostare il file caricato: " . htmlspecialchars($originalName);
                    }
                }
            }
            
            // Now handle cover image after all other operations are complete
            $stmt = $pdo->prepare('SELECT filename FROM gallery_items WHERE album_id = ? AND is_published = 1 ORDER BY sort_order ASC, created_at ASC LIMIT 1');
            $stmt->execute([$albumId]);
            $firstImage = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($firstImage) {
                // Set the first published image as cover
                $stmt = $pdo->prepare('UPDATE gallery_albums SET cover_image = ? WHERE id = ?');
                $stmt->execute([$firstImage['filename'], $albumId]);
            } elseif (empty($firstImage) && !empty($_FILES['images']['name'][0])) {
                // For new albums with uploaded files, use the first uploaded file as cover
                $firstUploadedFile = $_FILES['images']['name'][0];
                $fileExtension = strtolower(pathinfo($firstUploadedFile, PATHINFO_EXTENSION));
                $safeFilename = uniqid('img_', true) . "." . $fileExtension;
                
                $stmt = $pdo->prepare('UPDATE gallery_albums SET cover_image = ? WHERE id = ?');
                $stmt->execute([$safeFilename, $albumId]);
            } else {
                // No published images, clear the cover image
                $stmt = $pdo->prepare('UPDATE gallery_albums SET cover_image = NULL WHERE id = ?');
                $stmt->execute([$albumId]);
            }

            $pdo->commit();
            $_SESSION['success_message']='Modifiche salvate.';
        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION['error_message']='Errore: '.$e->getMessage();
        }
        if (isset($_POST['continue_editing']) && $_POST['continue_editing'] === '1') {
            header('Location: edit.php?id='.$albumId);
        } else {
            header('Location: index.php');
        }
        exit;
    }
}

// Include new template structure
include_once ABSPATH . 'admin/templates/head_adminlte.php';
include_once ABSPATH . 'admin/templates/header_adminlte.php';

$additionalScripts = [
    'assets/js/gallery-edit.js'
];

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $pageTitle ?></h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card card-primary">
                <div class="card-body">
                    <form method="POST" id="album-form" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $album['id'] ?>">

                        <div class="form-floating mb-3 compact-input">
                            <label for="title">Titolo*</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="<?= htmlspecialchars($album['title']) ?>" placeholder="Titolo" required>
                        </div>

                        <div class="form-floating mb-3 compact-input">
                            <label for="description">Descrizione</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Descrizione"
                                style="height: 90px; min-height: 60px;"><?=
                                    htmlspecialchars($album['description']) ?></textarea>
                        </div>

                        <div class="form-floating mb-3 compact-input">
                            <label for="year">Anno</label>
                            <input type="number" class="form-control" id="year" name="year"
                                value="<?= $album['year'] ?>" min="1900" max="<?= date('Y') + 1 ?>" placeholder="Anno">
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_published"
                                    name="is_published" value="1" <?= $album['is_published'] ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="is_published">Pubblicato</label>
                            </div>
                        </div>

                        <!-- Metadata inputs above; images section follows -->
                        <!-- Removed per-item save; unified save below -->
                        <!-- form persists through images -->

                        <!-- Unified Image Upload & Management -->
                        <div class="card mt-4">
                            <div class="card-header w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="h6 font-weight-bold mb-0">Immagini dell'album</h3>
                                    <!-- Aggiungi immagini button (JS triggers file inputs into album-form) -->
                                    <button type="button" id="js-add-more" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-plus"></i> Aggiungi immagini
                                    </button>
                                    <!-- Hidden file input that will be controlled by JavaScript -->
                                    <input type="file" name="images[]" id="images" class="d-none"
                                        accept="image/jpeg,image/png,image/webp" multiple aria-label="Carica immagini">
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Manage existing images -->
                                <div id="sortable-photos" class="gallery-preview__grid row" aria-label="Immagini album"
                                    tabindex="0">
                                    <?php
                                    // Fetch all images for this album, ordered by sort_order then created_at
                                    $stmt = $pdo->prepare('SELECT * FROM gallery_items WHERE album_id = ? ORDER BY sort_order ASC, created_at DESC');
                                    $stmt->execute([$albumId]);
                                    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if ($photos): ?>
                                        <?php foreach ($photos as $idx => $photo): ?>
                                            <div class="gallery-preview__item col-12 col-sm-6 col-md-4 col-lg-3 mb-3"
                                                data-id="<?= $photo['id'] ?>">
                                                <div class="gallery-preview__thumb card h-100 d-flex flex-column position-relative">
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 gallery-preview__remove"
                                                        aria-label="Rimuovi immagine" onclick="removeImage(<?= $photo['id'] ?>)"><i
                                                            class="fas fa-times"></i></button>
                                                    <img src="<?= SITE_URL ?>/album/<?= $albumId ?>/<?= htmlspecialchars($photo['filename']) ?>"
                                                        alt="<?= htmlspecialchars($photo['alt_text'] ?? $photo['filename']) ?>"
                                                        class="gallery-preview__img w-100" loading="lazy" height="180"
                                                        style="object-fit: cover;">
                                                    <div class="gallery-preview__caption card-body p-2">
                                                        <span class="gallery-preview__filename d-block fw-bold small"
                                                            title="<?= htmlspecialchars($photo['filename']) ?>">
                                                            <?= htmlspecialchars($photo['filename']) ?>
                                                        </span>
                                                        <div class="form-floating mb-2 compact-input">
                                                            <input type="text" class="form-control" name="title[<?= $photo['id'] ?>]"
                                                                id="title_<?= $photo['id'] ?>"
                                                                value="<?= htmlspecialchars($photo['title']) ?>" maxlength="255"
                                                                autocomplete="off" placeholder="Titolo" aria-label="Titolo immagine">
                                                            <label for="title_<?= $photo['id'] ?>">Titolo</label>
                                                        </div>
                                                        <div class="form-floating mb-2 compact-input">
                                                            <textarea class="form-control" name="description[<?= $photo['id'] ?>]"
                                                                id="description_<?= $photo['id'] ?>" maxlength="1000"
                                                                placeholder="Descrizione" style="height: 60px; min-height: 40px;"
                                                                aria-label="Descrizione immagine"><?= htmlspecialchars($photo['description']) ?></textarea>
                                                            <label for="description_<?= $photo['id'] ?>">Descrizione</label>
                                                        </div>
                                                        <div class="form-floating mb-2 compact-input">
                                                            <input type="text" class="form-control" name="alt_text[<?= $photo['id'] ?>]"
                                                                id="alt_text_<?= $photo['id'] ?>"
                                                                value="<?= htmlspecialchars($photo['alt_text']) ?>" maxlength="255"
                                                                autocomplete="off" placeholder="Testo alternativo"
                                                                aria-label="Testo alternativo immagine">
                                                            <label for="alt_text_<?= $photo['id'] ?>">Testo alternativo (alt)</label>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="is_published[<?= $photo['id'] ?>]"
                                                                    id="is_published_<?= $photo['id'] ?>" value="1"
                                                                    <?= $photo['is_published'] ? 'checked' : '' ?>
                                                                    aria-label="Pubblica immagine">
                                                                <label class="form-check-label"
                                                                    for="is_published_<?= $photo['id'] ?>">Pubblica</label>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="order[<?= $photo['id'] ?>]" value="<?= $idx + 1 ?>"
                                                            class="js-order-field">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div id="sortable-photos-empty" class="alert alert-secondary">Nessuna immagine presente in questo album.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Existing images rendered above; unified upload/edit via album-form -->
                    <!-- Unified Save Actions -->
                    <div class="form-actions mt-3 p-3 d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Confermi eliminazione album?')) window.location='delete.php?id=<?= $albumId ?>';">
                                <i class="fas fa-trash"></i> Elimina album
                            </button>
                        </div>
                        <div>
                            <input type="hidden" name="continue_editing" id="continue_editing" value="0">
                            <button type="submit" class="btn btn-outline-primary me-2" onclick="document.getElementById('continue_editing').value='1';">
                                <i class="fas fa-save"></i> Salva e continua a modificare
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Salva e torna all'elenco
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include_once ABSPATH . 'admin/templates/body_end_adminlte.php'; ?>
</div>

