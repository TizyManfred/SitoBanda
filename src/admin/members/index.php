<?php
/**
 * Admin Members Management
 *
 * Lists and manages all band members for SitoBanda website
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

// Handle member deletion if confirmed
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $memberId = (int)$_GET['id'];
    
    // In a real app, this would delete from the database
    // $db = Database::getInstance();
    // $success = $db->delete('members', 'id = ?', [$memberId]);
    
    // For demo, we'll just pretend it was successful
    $success = true;
    
    if ($success) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Membro eliminato con successo!'
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Errore durante l\'eliminazione del membro.'
        ];
    }
    
    // Redirect to the same page to prevent refresh issues
    header('Location: index.php');
    exit;
}

// Get all members
// In a real app, these would come from the database
$members = [];

// Sample data for demonstration
$sampleMembers = [
    [
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
        'order' => 1
    ],
    [
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
        'order' => 2
    ],
    [
        'id' => 3,
        'first_name' => 'Antonio',
        'last_name' => 'Verdi',
        'instrument' => 'Trombone',
        'role' => 'Prima Parte',
        'bio' => 'Musicista con esperienza ventennale. Insegnante di musica alle scuole medie.',
        'joined_year' => 2008,
        'is_active' => 1,
        'image' => 'antonio-verdi.jpg',
        'email' => 'antonio.verdi@email.com',
        'order' => 3
    ],
    [
        'id' => 4,
        'first_name' => 'Giulia',
        'last_name' => 'Ferrari',
        'instrument' => 'Flauto',
        'role' => 'Prima Parte',
        'bio' => 'Diplomata al conservatorio di Milano. Suona anche il pianoforte.',
        'joined_year' => 2015,
        'is_active' => 1,
        'image' => 'giulia-ferrari.jpg',
        'email' => 'giulia.ferrari@email.com',
        'order' => 4
    ],
    [
        'id' => 5,
        'first_name' => 'Luca',
        'last_name' => 'Esposito',
        'instrument' => 'Percussioni',
        'role' => 'Musicista',
        'bio' => 'Specializzato in percussioni etniche e tradizionali. Insegna nella scuola di musica locale.',
        'joined_year' => 2018,
        'is_active' => 1,
        'image' => 'luca-esposito.jpg',
        'email' => 'luca.esposito@email.com',
        'order' => 5
    ],
    [
        'id' => 6,
        'first_name' => 'Sofia',
        'last_name' => 'Romano',
        'instrument' => 'Saxofono',
        'role' => 'Musicista',
        'bio' => 'Giovane promessa della banda. Ha iniziato a suonare all\'età di 10 anni.',
        'joined_year' => 2020,
        'is_active' => 1,
        'image' => 'sofia-romano.jpg',
        'email' => 'sofia.romano@email.com',
        'order' => 6
    ],
    [
        'id' => 7,
        'first_name' => 'Roberto',
        'last_name' => 'Conti',
        'instrument' => 'Corno',
        'role' => 'Presidente',
        'bio' => 'Presidente dell\'associazione dal 2016. Suona il corno da oltre 30 anni.',
        'joined_year' => 2005,
        'is_active' => 1,
        'image' => 'roberto-conti.jpg',
        'email' => 'roberto.conti@email.com',
        'order' => 0
    ],
    [
        'id' => 8,
        'first_name' => 'Maria',
        'last_name' => 'Gallo',
        'instrument' => 'Oboe',
        'role' => 'Musicista',
        'bio' => 'Diplomata al conservatorio di Trento. Suona anche in orchestra sinfonica.',
        'joined_year' => 2013,
        'is_active' => 0,
        'image' => 'maria-gallo.jpg',
        'email' => 'maria.gallo@email.com',
        'order' => 10
    ]
];

// Sort members by order and active status
usort($sampleMembers, function($a, $b) {
    // Active members first
    if ($a['is_active'] != $b['is_active']) {
        return $b['is_active'] - $a['is_active'];
    }
    
    // Then by order
    return $a['order'] - $b['order'];
});

$members = $sampleMembers;

// Get list of instruments for filter
$instruments = array_unique(array_column($members, 'instrument'));
sort($instruments);

// Get list of roles for filter
$roles = array_unique(array_column($members, 'role'));
sort($roles);

// Apply filters if any
$nameFilter = $_GET['name'] ?? '';
$instrumentFilter = $_GET['instrument'] ?? '';
$roleFilter = $_GET['role'] ?? '';
$activeFilter = isset($_GET['active']) ? (int)$_GET['active'] : null;

// Filter members based on criteria
if (!empty($nameFilter) || !empty($instrumentFilter) || !empty($roleFilter) || $activeFilter !== null) {
    $filtered = [];
    
    foreach ($members as $member) {
        $nameMatch = empty($nameFilter) || 
            stripos($member['first_name'] . ' ' . $member['last_name'], $nameFilter) !== false;
            
        $instrumentMatch = empty($instrumentFilter) || 
            $member['instrument'] === $instrumentFilter;
            
        $roleMatch = empty($roleFilter) || 
            $member['role'] === $roleFilter;
            
        $activeMatch = $activeFilter === null || 
            $member['is_active'] === $activeFilter;
            
        if ($nameMatch && $instrumentMatch && $roleMatch && $activeMatch) {
            $filtered[] = $member;
        }
    }
    
    $members = $filtered;
}

// Calculate stats
$totalMembers = count($sampleMembers);
$activeMembers = count(array_filter($sampleMembers, function($m) {
    return $m['is_active'] == 1;
}));
$inactiveMembers = $totalMembers - $activeMembers;

// Page title
$pageTitle = 'Membri';

// Include header part
include_once '../templates/header.php';
?>

<!-- Main Content -->
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Gestione Membri</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="add.php" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Nuovo Membro
                </a>
                <a href="export.php" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-download"></i> Esporta
                </a>
            </div>
            <a href="../public/chi-siamo.php" target="_blank" class="btn btn-sm btn-outline-info">
                <i class="fas fa-external-link-alt"></i> Visualizza Pagina
            </a>
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
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 stats-card primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $totalMembers; ?></div>
                            <div class="text-muted">Membri Totali</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 stats-card success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $activeMembers; ?></div>
                            <div class="text-muted">Membri Attivi</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 stats-card warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $inactiveMembers; ?></div>
                            <div class="text-muted">Membri Inattivi</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-user-times"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filtri</h5>
        </div>
        <div class="card-body">
            <form method="get" action="index.php" class="row">
                <div class="col-md-3 form-group">
                    <label for="name">Nome o Cognome</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($nameFilter); ?>">
                </div>
                <div class="col-md-3 form-group">
                    <label for="instrument">Strumento</label>
                    <select class="form-control" id="instrument" name="instrument">
                        <option value="">Tutti gli strumenti</option>
                        <?php foreach ($instruments as $instrument): ?>
                        <option value="<?php echo htmlspecialchars($instrument); ?>" <?php echo $instrumentFilter === $instrument ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($instrument); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <label for="role">Ruolo</label>
                    <select class="form-control" id="role" name="role">
                        <option value="">Tutti i ruoli</option>
                        <?php foreach ($roles as $role): ?>
                        <option value="<?php echo htmlspecialchars($role); ?>" <?php echo $roleFilter === $role ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($role); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <label for="active">Stato</label>
                    <select class="form-control" id="active" name="active">
                        <option value="">Tutti</option>
                        <option value="1" <?php echo $activeFilter === 1 ? 'selected' : ''; ?>>Attivi</option>
                        <option value="0" <?php echo $activeFilter === 0 ? 'selected' : ''; ?>>Inattivi</option>
                    </select>
                </div>
                <div class="col-md-2 form-group d-flex align-items-end">
                    <div class="btn-group w-100">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filtra
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Members List -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-users mr-2"></i>
                Membri della Banda
            </h5>
            <span class="badge badge-primary"><?php echo count($members); ?> risultati</span>
        </div>
        <div class="card-body p-0">
            <?php if (empty($members)): ?>
            <div class="alert alert-info m-3">
                Nessun membro trovato con i criteri di ricerca specificati.
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" style="width: 70px">Foto</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Strumento</th>
                            <th scope="col">Ruolo</th>
                            <th scope="col" style="width: 100px">Anno ingresso</th>
                            <th scope="col" style="width: 80px">Stato</th>
                            <th scope="col" style="width: 150px">Azioni</th>
                        </tr>
                    </thead>
                    <tbody id="sortableMembers">
                        <?php foreach ($members as $member): ?>
                        <tr class="<?php echo !$member['is_active'] ? 'table-secondary' : ''; ?>" data-id="<?php echo $member['id']; ?>">
                            <td>
                                <?php if (!empty($member['image'])): ?>
                                <img src="../public/assets/images/members/<?php echo htmlspecialchars($member['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>" 
                                     class="img-fluid rounded-circle member-thumbnail">
                                <?php else: ?>
                                <div class="member-thumbnail-placeholder rounded-circle">
                                    <i class="fas fa-user"></i>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo $member['id']; ?>" class="member-name">
                                    <?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>
                                </a>
                                <?php if ($member['role'] === 'Presidente' || $member['role'] === 'Maestro'): ?>
                                <span class="badge badge-info ml-2"><?php echo htmlspecialchars($member['role']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($member['instrument']); ?></td>
                            <td><?php echo htmlspecialchars($member['role']); ?></td>
                            <td><?php echo $member['joined_year']; ?></td>
                            <td>
                                <?php if ($member['is_active']): ?>
                                <span class="badge badge-success">Attivo</span>
                                <?php else: ?>
                                <span class="badge badge-secondary">Inattivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="edit.php?id=<?php echo $member['id']; ?>" class="btn btn-sm btn-outline-primary" title="Modifica">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-secondary toggle-status-btn" 
                                            data-id="<?php echo $member['id']; ?>" 
                                            data-status="<?php echo $member['is_active']; ?>" 
                                            title="<?php echo $member['is_active'] ? 'Disattiva' : 'Attiva'; ?>">
                                        <i class="fas fa-<?php echo $member['is_active'] ? 'toggle-on' : 'toggle-off'; ?>"></i>
                                    </button>
                                    <a href="?action=delete&id=<?php echo $member['id']; ?>" class="btn btn-sm btn-outline-danger delete-btn" 
                                       data-item-name="il membro '<?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>'" title="Elimina">
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
                <small class="text-muted">Trascina le righe per riordinare i membri</small>
            </div>
            <div>
                <button class="btn btn-sm btn-outline-primary" id="saveOrderBtn" style="display: none;">
                    <i class="fas fa-save"></i> Salva Ordine
                </button>
            </div>
        </div>
    </div>
    
    <!-- Featured Members -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-star mr-2"></i>
                Membri in Evidenza
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php 
                // Get members with leadership roles for featured section
                $featuredMembers = array_filter($members, function($m) {
                    return $m['is_active'] && ($m['role'] === 'Presidente' || $m['role'] === 'Maestro' || $m['role'] === 'Prima Parte');
                });
                
                // Limit to 4
                $featuredMembers = array_slice($featuredMembers, 0, 4);
                
                if (empty($featuredMembers)): 
                ?>
                <div class="col-12">
                    <p class="text-center text-muted">Nessun membro in evidenza.</p>
                </div>
                <?php else: ?>
                <?php foreach ($featuredMembers as $member): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 member-card">
                        <div class="card-header text-center bg-light">
                            <?php if (!empty($member['image'])): ?>
                            <img src="../public/assets/images/members/<?php echo htmlspecialchars($member['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>" 
                                 class="img-fluid rounded-circle member-featured-image">
                            <?php else: ?>
                            <div class="member-featured-placeholder rounded-circle">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">
                                <?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>
                            </h5>
                            <div class="text-primary mb-2"><?php echo htmlspecialchars($member['role']); ?></div>
                            <p class="text-muted mb-0">
                                <i class="fas fa-music mr-1"></i> <?php echo htmlspecialchars($member['instrument']); ?>
                            </p>
                            <p class="text-muted small">
                                <i class="fas fa-calendar-alt mr-1"></i> Dal <?php echo $member['joined_year']; ?>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="edit.php?id=<?php echo $member['id']; ?>" class="btn btn-sm btn-outline-primary btn-block">
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

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    // Initialize sortable for member order
    document.addEventListener('DOMContentLoaded', function() {
        const membersTable = document.getElementById('sortableMembers');
        const saveOrderBtn = document.getElementById('saveOrderBtn');
        
        if (membersTable) {
            const sortable = new Sortable(membersTable, {
                animation: 150,
                handle: 'td',
                ghostClass: 'sortable-ghost',
                onStart: function() {
                    saveOrderBtn.style.display = 'inline-block';
                }
            });
            
            // Handle save order button
            saveOrderBtn.addEventListener('click', function() {
                const newOrder = sortable.toArray();
                
                // In a real app, you would save this via AJAX
                console.log('New order:', newOrder);
                
                // Show success message
                showToast('Ordine membri salvato con successo!', 'success');
                
                // Hide save button
                saveOrderBtn.style.display = 'none';
            });
        }
        
        // Toggle member active status
        document.querySelectorAll('.toggle-status-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const memberId = this.getAttribute('data-id');
                const currentStatus = parseInt(this.getAttribute('data-status'));
                const newStatus = currentStatus === 1 ? 0 : 1;
                const icon = this.querySelector('i');
                
                // In a real app, you would update via AJAX
                // For demo, we'll just update the UI
                this.setAttribute('data-status', newStatus);
                
                if (newStatus === 1) {
                    icon.classList.remove('fa-toggle-off');
                    icon.classList.add('fa-toggle-on');
                    this.setAttribute('title', 'Disattiva');
                    showToast('Membro attivato con successo!', 'success');
                } else {
                    icon.classList.remove('fa-toggle-on');
                    icon.classList.add('fa-toggle-off');
                    this.setAttribute('title', 'Attiva');
                    showToast('Membro disattivato con successo!', 'info');
                }
                
                // Update the table row class
                const row = this.closest('tr');
                if (newStatus === 0) {
                    row.classList.add('table-secondary');
                } else {
                    row.classList.remove('table-secondary');
                }
                
                // Update the status badge
                const statusBadge = row.querySelector('td:nth-child(6) .badge');
                if (newStatus === 1) {
                    statusBadge.classList.remove('badge-secondary');
                    statusBadge.classList.add('badge-success');
                    statusBadge.textContent = 'Attivo';
                } else {
                    statusBadge.classList.remove('badge-success');
                    statusBadge.classList.add('badge-secondary');
                    statusBadge.textContent = 'Inattivo';
                }
            });
        });
    });
</script>

<style>
    .member-thumbnail {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }
    
    .member-thumbnail-placeholder {
        width: 40px;
        height: 40px;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
    
    .member-featured-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin: 10px auto;
        border: 3px solid #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .member-featured-placeholder {
        width: 100px;
        height: 100px;
        margin: 10px auto;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        border: 3px solid #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .sortable-ghost {
        background-color: #f8f9fa;
        opacity: 0.8;
    }
    
    #sortableMembers tr {
        cursor: move;
    }
</style>

<?php
// Include footer
include_once '../templates/footer.php';
?>
