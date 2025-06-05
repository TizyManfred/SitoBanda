<?php

// Define ABSPATH for security
define('ABSPATH', dirname(dirname(__DIR__)) . '/');

require_once ABSPATH . 'includes/auth.php';
require_once ABSPATH . 'includes/database.php';

// Redirect to login if not authenticated
Auth::requireLogin();

// Initialize database connection
$pdo = Database::getInstance();

$errors = [];
$album = [
    'title' => '',
    'slug' => '',
    'description' => '',
    'year' => date('Y'),
    'is_published' => 0
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $album['title'] = trim($_POST['title']);
    $album['slug'] = trim($_POST['slug']);
    $album['description'] = trim($_POST['description']);
    $album['year'] = (int)$_POST['year'];
    $album['is_published'] = isset($_POST['is_published']) ? 1 : 0;

    // Validate required fields
    if (empty($album['title'])) {
        $errors['title'] = "Il titolo è obbligatorio";
    }

    if (empty($album['slug'])) {
        $errors['slug'] = "Lo slug è obbligatorio";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO gallery_albums 
                (title, slug, description, year, is_published) 
                VALUES (?, ?, ?, ?, ?)");
            
            $stmt->execute([
                $album['title'],
                $album['slug'],
                $album['description'],
                $album['year'],
                $album['is_published']
            ]);
            
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Errore durante la creazione: " . $e->getMessage();
        }
    }
}

// Page title
$pageTitle = 'Crea Nuovo Album';

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
                    <form method="POST" id="album-form">
                        <div class="form-group">
                            <label for="title">Titolo*</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                value="<?= htmlspecialchars($album['title']) ?>" 
                                required>
                        </div>
                        
                        <div class="form-group">
                            <label for="slug">Slug*</label>
                            <input type="text" class="form-control" id="slug" name="slug" 
                                value="<?= htmlspecialchars($album['slug']) ?>" 
                                required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Descrizione</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?= 
                                htmlspecialchars($album['description']) ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="year">Anno</label>
                            <input type="number" class="form-control" id="year" name="year" 
                                value="<?= $album['year'] ?>" min="1900" max="<?= date('Y') + 1 ?>">
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1"
                                    <?= $album['is_published'] ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="is_published">Pubblicato</label>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Salva</button>
                            <a href="index.php" class="btn btn-secondary">Annulla</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include_once ABSPATH . 'admin/templates/body_end_adminlte.php'; ?>
</div>

