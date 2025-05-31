<?php
/**
 * Admin Member Edit/Add Form
 *
 * Form for adding or editing a band member for SitoBanda website
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
$pageTitle = 'Aggiungi Membro';
$memberId = 0;

// Default empty member data
$member = [
    'id' => 0,
    'first_name' => '',
    'last_name' => '',
    'instrument' => '',
    'role' => '',
    'bio' => '',
    'joined_year' => date('Y'),
    'is_active' => 1,
    'image' => '',
    'email' => '',
    'phone' => '',
    'order' => 99,
    'social_facebook' => '',
    'social_instagram' => '',
    'show_on_site' => 1
];

// Check if editing an existing member
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $memberId = (int)$_GET['id'];
    $formAction = 'edit';
    $pageTitle = 'Modifica Membro';
    
    // In a real app, this would get the member from the database
    // $db = Database::getInstance();
    // $member = $db->fetchOne("SELECT * FROM members WHERE id = ?", [$memberId]);
    
    // For demo, we'll use sample data
    if ($memberId === 1) {
        $member = [
            'id' => 1,
            'first_name' => 'Marco',
            'last_name' => 'Rossi',
            'instrument' => 'Tromba',
            'role' => 'Maestro',
            'bio' => 'Maestro della banda dal 2010. Diplomato al conservatorio di Trento.',
            'joined_year' => 2010,
            'is_active' => 1,
            'image' => 'marco-rossi.jpg',
            'email' => 'marco.rossi@email.com',
            'phone' => '3401234567',
            'order' => 1,
            'social_facebook' => 'https://facebook.com/marcorossi',
            'social_instagram' => 'https://instagram.com/marco.rossi',
            'show_on_site' => 1
        ];
    } elseif ($memberId === 2) {
        $member = [
            'id' => 2,
            'first_name' => 'Laura',
            'last_name' => 'Bianchi',
            'instrument' => 'Clarinetto',
            'role' => 'Prima Parte',
            'bio' => 'Suona il clarinetto dall\'età di 8 anni. Ha partecipato a numerosi concorsi nazionali.',
            'joined_year' => 2012,
            'is_active' => 1,
            'image' => 'laura-bianchi.jpg',
            'email' => 'laura.bianchi@email.com',
            'phone' => '3409876543',
            'order' => 2,
            'social_facebook' => '',
            'social_instagram' => 'https://instagram.com/laura.bianchi',
            'show_on_site' => 1
        ];
    } else {
        // If member not found, redirect to members list
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Membro non trovato!'
        ];
        header('Location: index.php');
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate first name
    if (empty($_POST['first_name'])) {
        $errors['first_name'] = 'Il nome è obbligatorio';
    } else {
        $member['first_name'] = trim($_POST['first_name']);
    }
    
    // Validate last name
    if (empty($_POST['last_name'])) {
        $errors['last_name'] = 'Il cognome è obbligatorio';
    } else {
        $member['last_name'] = trim($_POST['last_name']);
    }
    
    // Validate instrument
    if (empty($_POST['instrument'])) {
        $errors['instrument'] = 'Lo strumento è obbligatorio';
    } else {
        $member['instrument'] = trim($_POST['instrument']);
    }
    
    // Process other fields
    $member['role'] = trim($_POST['role'] ?? '');
    $member['bio'] = trim($_POST['bio'] ?? '');
    $member['joined_year'] = isset($_POST['joined_year']) ? (int)$_POST['joined_year'] : date('Y');
    $member['is_active'] = isset($_POST['is_active']) ? 1 : 0;
    $member['email'] = trim($_POST['email'] ?? '');
    $member['phone'] = trim($_POST['phone'] ?? '');
    $member['order'] = isset($_POST['order']) ? (int)$_POST['order'] : 99;
    $member['social_facebook'] = trim($_POST['social_facebook'] ?? '');
    $member['social_instagram'] = trim($_POST['social_instagram'] ?? '');
    $member['show_on_site'] = isset($_POST['show_on_site']) ? 1 : 0;
    
    // Validate email if provided
    if (!empty($member['email']) && !filter_var($member['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Inserisci un indirizzo email valido';
    }
    
    // Handle file upload for image
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        // In a real app, this would process and save the uploaded image
        // For demo, we'll just pretend it was successful
        $member['image'] = strtolower(str_replace(' ', '-', $member['first_name'] . '-' . $member['last_name'])) . '.jpg';
    }
    
    // Check if the remove image checkbox is checked
    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 1) {
        $member['image'] = '';
    }
    
    // If no errors, save the member
    if (empty($errors)) {
        // In a real app, this would save to the database
        // $db = Database::getInstance();
        
        // For new member
        if ($formAction === 'add') {
            // $member['id'] = $db->insert('members', $member);
            // For demo, we'll just pretend it was successful
            $member['id'] = time();
        } else {
            // $success = $db->update('members', $member, 'id = ?', [$member['id']]);
            // For demo, we'll just pretend it was successful
            $success = true;
        }
        
        // Set success message and redirect
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => ($formAction === 'add') 
                ? 'Membro creato con successo!' 
                : 'Membro aggiornato con successo!'
        ];
        
        // Redirect to members list or the member edit page
        if ($formAction === 'add') {
            header('Location: index.php');
            exit;
        } else {
            $success = true;
        }
    }
}

// Get list of instruments for dropdown
$instruments = [
    'Flauto',
    'Oboe',
    'Clarinetto',
    'Saxofono',
    'Tromba',
    'Corno',
    'Trombone',
    'Basso Tuba',
    'Percussioni',
    'Pianoforte',
    'Fisarmonica',
    'Altro'
];

// Get list of roles for dropdown
$roles = [
    'Musicista',
    'Prima Parte',
    'Maestro',
    'Presidente',
    'Vicepresidente',
    'Segretario',
    'Tesoriere',
    'Consigliere',
    'Direttore Artistico',
    'Direttore Scuola Musica'
];

// Generate years for dropdown
$currentYear = (int)date('Y');
$years = range($currentYear, $currentYear - 70);

// Include header part
include_once '../templates/header.php';
?>

<!-- Main Content -->
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2"><?php echo $pageTitle; ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="index.php" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Torna ai Membri
            </a>
        </div>
    </div>
    
    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Membro aggiornato con successo!
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
    
    <!-- Member Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="post" action="<?php echo $formAction === 'add' ? 'edit.php' : 'edit.php?id=' . $memberId; ?>" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-8">
                        <h5 class="mb-4">Informazioni Personali</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php echo isset($errors['first_name']) ? 'is-invalid' : ''; ?>" 
                                           id="first_name" name="first_name" value="<?php echo htmlspecialchars($member['first_name']); ?>" required>
                                    <?php if (isset($errors['first_name'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['first_name']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Cognome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php echo isset($errors['last_name']) ? 'is-invalid' : ''; ?>" 
                                           id="last_name" name="last_name" value="<?php echo htmlspecialchars($member['last_name']); ?>" required>
                                    <?php if (isset($errors['last_name'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['last_name']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                           id="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>">
                                    <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['email']; ?>
                                    </div>
                                    <?php endif; ?>
                                    <small class="form-text text-muted">
                                        Solo per uso interno, non sarà pubblicato sul sito.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Telefono</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?php echo htmlspecialchars($member['phone']); ?>">
                                    <small class="form-text text-muted">
                                        Solo per uso interno, non sarà pubblicato sul sito.
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="mt-4 mb-3">Informazioni Banda</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instrument">Strumento <span class="text-danger">*</span></label>
                                    <select class="form-control <?php echo isset($errors['instrument']) ? 'is-invalid' : ''; ?>" 
                                            id="instrument" name="instrument" required>
                                        <option value="">-- Seleziona Strumento --</option>
                                        <?php foreach ($instruments as $instrument): ?>
                                        <option value="<?php echo htmlspecialchars($instrument); ?>" <?php echo $member['instrument'] === $instrument ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($instrument); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($errors['instrument'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['instrument']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Ruolo nella Banda</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="">-- Seleziona Ruolo --</option>
                                        <?php foreach ($roles as $role): ?>
                                        <option value="<?php echo htmlspecialchars($role); ?>" <?php echo $member['role'] === $role ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($role); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="joined_year">Anno di Ingresso</label>
                                    <select class="form-control" id="joined_year" name="joined_year">
                                        <?php foreach ($years as $year): ?>
                                        <option value="<?php echo $year; ?>" <?php echo $member['joined_year'] == $year ? 'selected' : ''; ?>>
                                            <?php echo $year; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order">Ordine di Visualizzazione</label>
                                    <input type="number" class="form-control" id="order" name="order" 
                                           value="<?php echo $member['order']; ?>" min="0" max="999">
                                    <small class="form-text text-muted">
                                        Numero più basso = posizione più alta nella lista. I ruoli speciali hanno precedenza.
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="bio">Biografia</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4"><?php echo htmlspecialchars($member['bio']); ?></textarea>
                            <small class="form-text text-muted">
                                Breve biografia o descrizione che apparirà nella pagina "Chi Siamo".
                            </small>
                        </div>
                        
                        <h5 class="mt-4 mb-3">Social Media</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social_facebook">
                                        <i class="fab fa-facebook text-primary"></i> Facebook
                                    </label>
                                    <input type="url" class="form-control" id="social_facebook" name="social_facebook" 
                                           value="<?php echo htmlspecialchars($member['social_facebook']); ?>" 
                                           placeholder="https://facebook.com/username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social_instagram">
                                        <i class="fab fa-instagram text-danger"></i> Instagram
                                    </label>
                                    <input type="url" class="form-control" id="social_instagram" name="social_instagram" 
                                           value="<?php echo htmlspecialchars($member['social_instagram']); ?>" 
                                           placeholder="https://instagram.com/username">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Settings & Media -->
                    <div class="col-md-4">
                        <h5 class="mb-4">Impostazioni & Foto</h5>
                        
                        <div class="card mb-3">
                            <div class="card-header">
                                Stato
                            </div>
                            <div class="card-body">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" <?php echo $member['is_active'] ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="is_active">Membro Attivo</label>
                                </div>
                                <small class="form-text text-muted">
                                    Se disattivato, il membro sarà contrassegnato come inattivo ma rimarrà nel database.
                                </small>
                                
                                <div class="custom-control custom-switch mt-3">
                                    <input type="checkbox" class="custom-control-input" id="show_on_site" name="show_on_site" <?php echo $member['show_on_site'] ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="show_on_site">Mostra sul Sito</label>
                                </div>
                                <small class="form-text text-muted">
                                    Se disattivato, il membro non apparirà nella pagina "Chi Siamo".
                                </small>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-header">
                                Foto Profilo
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <?php if (!empty($member['image'])): ?>
                                    <img src="../public/assets/images/members/<?php echo htmlspecialchars($member['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>" 
                                         class="img-fluid img-thumbnail member-preview mb-2" id="imagePreview">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remove_image" name="remove_image" value="1">
                                        <label class="custom-control-label" for="remove_image">Rimuovi foto</label>
                                    </div>
                                    <?php else: ?>
                                    <div class="member-preview-placeholder mb-2" id="imagePreviewPlaceholder">
                                        <i class="fas fa-user fa-3x"></i>
                                        <p class="small mt-2">Nessuna foto caricata</p>
                                    </div>
                                    <img src="" alt="" class="img-fluid img-thumbnail member-preview mb-2" id="imagePreview" style="display: none;">
                                    <?php endif; ?>
                                </div>
                                
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                                    <label class="custom-file-label" for="image">Scegli foto...</label>
                                </div>
                                <small class="form-text text-muted mt-2">
                                    Formato consigliato: quadrato, min 400x400px. Supporta JPG, PNG.
                                </small>
                            </div>
                        </div>
                        
                        <?php if ($formAction === 'edit'): ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                Informazioni Account
                            </div>
                            <div class="card-body">
                                <p class="mb-1">
                                    <strong>ID:</strong> <?php echo $member['id']; ?>
                                </p>
                                <p class="mb-1">
                                    <strong>Creato il:</strong> <?php echo date('d/m/Y'); ?>
                                </p>
                                <p class="mb-0">
                                    <strong>Ultima modifica:</strong> <?php echo date('d/m/Y H:i'); ?>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="d-flex justify-content-between">
                    <div>
                        <?php if ($formAction === 'edit'): ?>
                        <a href="?action=delete&id=<?php echo $memberId; ?>" class="btn btn-outline-danger delete-btn"
                           data-item-name="il membro '<?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>'" 
                           onclick="return confirm('Sei sicuro di voler eliminare questo membro? Questa azione non può essere annullata.');">
                            <i class="fas fa-trash"></i> Elimina
                        </a>
                        <?php endif; ?>
                    </div>
                    <div>
                        <a href="index.php" class="btn btn-outline-secondary mr-2">Annulla</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> 
                            <?php echo $formAction === 'add' ? 'Crea Membro' : 'Salva Modifiche'; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('imagePreviewPlaceholder');
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            }
            
            reader.readAsDataURL(this.files[0]);
            
            // Update the file input label with the selected filename
            const fileName = this.files[0].name;
            this.nextElementSibling.innerHTML = fileName;
        }
    });
    
    // Remove image checkbox handler
    const removeImageCheckbox = document.getElementById('remove_image');
    if (removeImageCheckbox) {
        removeImageCheckbox.addEventListener('change', function() {
            const preview = document.getElementById('imagePreview');
            
            if (this.checked) {
                preview.style.opacity = '0.3';
            } else {
                preview.style.opacity = '1';
            }
        });
    }
    
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

<style>
    .member-preview {
        max-width: 150px;
        max-height: 150px;
        width: auto;
        height: auto;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .member-preview-placeholder {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        background-color: #e9ecef;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
</style>

<?php
// Include footer
include_once '../templates/footer.php';
?>
