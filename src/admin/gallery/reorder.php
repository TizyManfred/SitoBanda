<?php
/**
 * AJAX endpoint to reorder gallery photos for an album
 * Expects POST: album_id, items: [{id, order}]
 */

require_once dirname(dirname(__DIR__)) . '/includes/auth.php';
require_once dirname(dirname(__DIR__)) . '/includes/database.php';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Metodo non consentito']);
    exit;
}

Auth::requireLogin();

$input = json_decode(file_get_contents('php://input'), true);
$albumId = isset($input['album_id']) ? (int)$input['album_id'] : 0;
$items = isset($input['items']) ? $input['items'] : [];

if (!$albumId || !is_array($items)) {
    http_response_code(400);
    echo json_encode(['error' => 'Dati non validi']);
    exit;
}

$pdo = Database::getInstance();
$pdo->beginTransaction();
try {
    foreach ($items as $item) {
        $id = (int)$item['id'];
        $order = (int)$item['order'];
        $stmt = $pdo->prepare('UPDATE gallery_items SET sort_order = ? WHERE id = ? AND album_id = ?');
        $stmt->execute([$order, $id, $albumId]);
    }
    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Errore durante il riordino.']);
}
