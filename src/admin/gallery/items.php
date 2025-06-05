<?php

// Define ABSPATH for security
define('ABSPATH', dirname(dirname(__DIR__)) . '/');

require_once ABSPATH . 'includes/auth.php';
require_once ABSPATH . 'includes/database.php';

if (!isset($_GET['album_id'])) {
    header("Location: index.php");
    exit;
}

$albumId = (int)$_GET['album_id'];

// Fetch album details
$albumStmt = $pdo->prepare("SELECT * FROM gallery_albums WHERE id = ?");
$albumStmt->execute([$albumId]);
$album = $albumStmt->fetch(PDO::FETCH_ASSOC);

if (!$album) {
    header("Location: index.php");
    exit;
}

// Fetch items for this album
$itemsStmt = $pdo->prepare("SELECT * FROM gallery_items WHERE album_id = ? ORDER BY sort_order");
$itemsStmt->execute([$albumId]);
$items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elementi Album: <?= htmlspecialchars($album['title']) ?></title>
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Elementi Album: <?= htmlspecialchars($album['title']) ?></h1>
        
        <div class="toolbar">
            <a href="create-item.php?album_id=<?= $albumId ?>" class="btn btn-primary">
                Aggiungi Nuovo Elemento
            </a>
            <a href="index.php" class="btn btn-secondary">Torna agli Album</a>
        </div>
        
        <?php if (!empty($items)): ?>
            <div class="gallery-items" id="sortable-items">
                <?php foreach ($items as $item): ?>
                    <div class="gallery-item" data-id="<?= $item['id'] ?>">
                        <img src="<?= SITE_URL ?>/uploads/gallery/<?= $item['filename'] ?>" 
                             alt="<?= htmlspecialchars($item['alt_text'] ?? '') ?>">
                        <div class="item-details">
                            <h3><?= htmlspecialchars($item['title']) ?></h3>
                            <p><?= htmlspecialchars(mb_substr($item['description'] ?? '', 0, 100)) ?>...</p>
                        </div>
                        <div class="item-actions">
                            <a href="edit-item.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-edit">Modifica</a>
                            <button class="btn btn-sm btn-delete" 
                                    data-id="<?= $item['id'] ?>" 
                                    data-title="<?= htmlspecialchars($item['title']) ?>">
                                Elimina
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nessun elemento trovato in questo album.</p>
        <?php endif; ?>
    </div>
    
    <script src="<?= SITE_URL ?>/assets/js/gallery-admin.js"></script>
    <script>
        // Make items sortable
        new Sortable(document.getElementById('sortable-items'), {
            animation: 150,
            onEnd: function(evt) {
                const itemIds = Array.from(evt.from.children).map(
                    (el, index) => ({id: el.dataset.id, order: index + 1})
                );
                
                // Send update to server
                fetch('update-order.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({items: itemIds})
                });
            }
        });
    </script>
</body>
</html>
