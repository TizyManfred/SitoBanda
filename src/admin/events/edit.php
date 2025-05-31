<?php
/**
 * Admin Event Edit/Add Form
 *
 * Form for adding or editing an event for SitoBanda website
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

// Initialize variables
$errors = [];
$success = false;
$formAction = 'add';
$pageTitle = 'Aggiungi Evento';
$eventId = 0;

// Default empty event data
$event = [
    'id' => 0,
    'title' => '',
    'date' => date('Y-m-d'),
    'time' => '20:00',
    'location' => '',
    'description' => '',
    'category_id' => 0,
    'is_public' => 1,
    'custom_url' => '',
    'featured_image' => '',
    'meta_description' => ''
];

// Check if editing an existing event
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $eventId = (int)$_GET['id'];
    $formAction = 'edit';
    $pageTitle = 'Modifica Evento';
    
    // In a real app, this would get the event from the database
    // $db = Database::getInstance();
    // $event = $db->fetchOne("SELECT * FROM events WHERE id = ?", [$eventId]);
    
    // For demo, we'll use sample data
    if ($eventId === 1) {
        $event = [
            'id' => 1,
            'title' => 'Concerto di Primavera',
            'date' => '2024-06-01',
            'time' => '20:30',
            'location' => 'Piazza Maggiore, Castello Tesino',
            'description' => 'Concerto annuale di primavera con repertorio classico e moderno.',
            'category_id' => 1,
            'is_public' => 1,
            'custom_url' => 'concerto-primavera-2024',
            'featured_image' => 'concerto-primavera.jpg',
            'meta_description' => 'Il tradizionale concerto di primavera della Banda Folk di Castello Tesino con un repertorio di musiche classiche e moderne.'
        ];
    } elseif ($eventId === 2) {
        $event = [
            'id' => 2,
            'title' => 'Processione San Giovanni',
            'date' => '2024-06-24',
            'time' => '10:00',
            'location' => 'Chiesa Parrocchiale, Castello Tesino',
            'description' => 'Processione religiosa per la festa di San Giovanni.',
            'category_id' => 2,
            'is_public' => 1,
            'custom_url' => 'processione-san-giovanni-2024',
            'featured_image' => 'processione.jpg',
            'meta_description' => 'La Banda Folk di Castello Tesino accompagna la processione religiosa per la festa di San Giovanni.'
        ];
    } else {
        // If event not found, redirect to events list
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Evento non trovato!'
        ];
        header('Location: index.php');
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate title
    if (empty($_POST['title'])) {
        $errors['title'] = 'Il titolo è obbligatorio';
    } else {
        $event['title'] = trim($_POST['title']);
    }
    
    // Validate date
    if (empty($_POST['date'])) {
        $errors['date'] = 'La data è obbligatoria';
    } else {
        $event['date'] = $_POST['date'];
    }
    
    // Validate time
    if (empty($_POST['time'])) {
        $errors['time'] = 'L\'ora è obbligatoria';
    } else {
        $event['time'] = $_POST['time'];
    }
    
    // Validate location
    if (empty($_POST['location'])) {
        $errors['location'] = 'Il luogo è obbligatorio';
    } else {
        $event['location'] = trim($_POST['location']);
    }
    
    // Process other fields
    $event['description'] = trim($_POST['description'] ?? '');
    $event['category_id'] = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
    $event['is_public'] = isset($_POST['is_public']) ? 1 : 0;
    $event['custom_url'] = trim($_POST['custom_url'] ?? '');
    $event['meta_description'] = trim($_POST['meta_description'] ?? '');
    
    // Handle file upload for featured image
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['size'] > 0) {
        // In a real app, this would process and save the uploaded image
        // For demo, we'll just pretend it was successful
        $event['featured_image'] = 'new-image-' . time() . '.jpg';
    }
    
    // If no errors, save the event
    if (empty($errors)) {
        // In a real app, this would save to the database
        // $db = Database::getInstance();
        
        // For new event
        if ($formAction === 'add') {
            // $event['id'] = $db->insert('events', $event);
            // For demo, we'll just pretend it was successful
            $event['id'] = time();
        } else {
            // $success = $db->update('events', $event, 'id = ?', [$event['id']]);
            // For demo, we'll just pretend it was successful
            $success = true;
        }
        
        // Set success message and redirect
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => ($formAction === 'add') 
                ? 'Evento creato con successo!' 
                : 'Evento aggiornato con successo!'
        ];
        
        // Redirect to events list or the event edit page
        if ($formAction === 'add') {
            header('Location: index.php');
            exit;
        } else {
            $success = true;
        }
    }
}

// Get categories for dropdown
// In a real app, this would come from the database
$categories = [
    ['id' => 1, 'name' => 'Concerto'],
    ['id' => 2, 'name' => 'Processione'],
    ['id' => 3, 'name' => 'Sfilata'],
    ['id' => 4, 'name' => 'Evento Speciale'],
    ['id' => 5, 'name' => 'Altro']
];

// Include header part
include_once '../templates/header.php';
?>

<!-- Main Content -->
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2"><?php echo $pageTitle; ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="index.php" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Torna agli Eventi
            </a>
        </div>
    </div>
    
    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Evento aggiornato con successo!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Errore!</strong> Correggi gli errori nel form.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
    
    <!-- Event Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="post" action="<?php echo $formAction === 'add' ? 'edit.php' : 'edit.php?id=' . $eventId; ?>" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-8">
                        <h5 class="mb-4">Informazioni Base</h5>
                        
                        <div class="form-group">
                            <label for="title">Titolo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php echo isset($errors['title']) ? 'is-invalid' : ''; ?>" 
                                   id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                            <?php if (isset($errors['title'])): ?>
                            <div class="invalid-feedback">
                                <?php echo $errors['title']; ?>
                            </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">
                                Il titolo dell'evento come apparirà sul sito.
                            </small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Data <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control <?php echo isset($errors['date']) ? 'is-invalid' : ''; ?>" 
                                           id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>" required>
                                    <?php if (isset($errors['date'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['date']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time">Ora <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control <?php echo isset($errors['time']) ? 'is-invalid' : ''; ?>" 
                                           id="time" name="time" value="<?php echo htmlspecialchars($event['time']); ?>" required>
                                    <?php if (isset($errors['time'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['time']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="location">Luogo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php echo isset($errors['location']) ? 'is-invalid' : ''; ?>" 
                                   id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
                            <?php if (isset($errors['location'])): ?>
                            <div class="invalid-feedback">
                                <?php echo $errors['location']; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Descrizione</label>
                            <textarea class="form-control" id="description" name="description" rows="6"><?php echo htmlspecialchars($event['description']); ?></textarea>
                            <small class="form-text text-muted">
                                Descrizione dettagliata dell'evento. Supporta formattazione HTML di base.
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_id">Categoria</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="0">-- Seleziona Categoria --</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo $event['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Settings & Media -->
                    <div class="col-md-4">
                        <h5 class="mb-4">Impostazioni & Media</h5>
                        
                        <div class="card mb-3">
                            <div class="card-header">
                                Stato Pubblicazione
                            </div>
                            <div class="card-body">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_public" name="is_public" <?php echo $event['is_public'] ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="is_public">Pubblica sul sito</label>
                                </div>
                                <small class="form-text text-muted mt-2">
                                    Se non selezionato, l'evento sarà salvato come bozza e non sarà visibile sul sito.
                                </small>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-header">
                                Immagine in Evidenza
                            </div>
                            <div class="card-body">
                                <?php if (!empty($event['featured_image'])): ?>
                                <div class="mb-3">
                                    <img src="../public/assets/images/events/<?php echo htmlspecialchars($event['featured_image']); ?>" 
                                         alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                         class="img-fluid img-thumbnail mb-2">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remove_image" name="remove_image">
                                        <label class="custom-control-label" for="remove_image">Rimuovi immagine</label>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="featured_image" name="featured_image" accept="image/*">
                                    <label class="custom-file-label" for="featured_image">Scegli immagine...</label>
                                </div>
                                <small class="form-text text-muted mt-2">
                                    Formato consigliato: 1200x630px, max 2MB. Supporta JPG, PNG, WebP.
                                </small>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-header">
                                SEO & URL
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="custom_url">URL Personalizzato</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">/concerti/</span>
                                        </div>
                                        <input type="text" class="form-control" id="custom_url" name="custom_url" 
                                               value="<?php echo htmlspecialchars($event['custom_url']); ?>" 
                                               placeholder="nome-evento">
                                    </div>
                                    <small class="form-text text-muted">
                                        Lascia vuoto per generare automaticamente.
                                    </small>
                                </div>
                                
                                <div class="form-group mb-0">
                                    <label for="meta_description">Meta Descrizione</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?php echo htmlspecialchars($event['meta_description']); ?></textarea>
                                    <small class="form-text text-muted">
                                        Breve descrizione (max 160 caratteri) usata nei risultati di ricerca.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="d-flex justify-content-between">
                    <div>
                        <?php if ($formAction === 'edit'): ?>
                        <a href="?action=delete&id=<?php echo $eventId; ?>" class="btn btn-outline-danger delete-btn"
                           data-item-name="l'evento '<?php echo htmlspecialchars($event['title']); ?>'" 
                           onclick="return confirm('Sei sicuro di voler eliminare questo evento?');">
                            <i class="fas fa-trash"></i> Elimina
                        </a>
                        <?php endif; ?>
                    </div>
                    <div>
                        <a href="index.php" class="btn btn-outline-secondary mr-2">Annulla</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> 
                            <?php echo $formAction === 'add' ? 'Crea Evento' : 'Salva Modifiche'; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // URL slug generator
    document.getElementById('title').addEventListener('blur', function() {
        const customUrlField = document.getElementById('custom_url');
        
        // Only generate slug if custom URL is empty
        if (customUrlField.value === '') {
            const title = this.value;
            const slug = title
                .toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special chars
                .replace(/\s+/g, '-')     // Replace spaces with dashes
                .replace(/-+/g, '-')      // Replace multiple dashes with single dash
                .trim();
                
            customUrlField.value = slug;
        }
    });
    
    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<?php
// Include footer
include_once '../templates/footer.php';
?>
