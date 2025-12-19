<?php
require_once 'config.php';
require_once 'functions.php';
requireLogin();

header('Content-Type: application/json');

$connId = intval($_GET['conn'] ?? 0);
if ($connId <= 0) {
    echo json_encode([]);
    exit;
}


$stmt = $db->prepare(
    'SELECT id FROM connections 
     WHERE id = ? 
       AND (user_id = ? OR connected_user_id = ?)
       AND status = "accepted"'
);
$stmt->execute([$connId, $_SESSION['userId'], $_SESSION['userId']]);
if (!$stmt->fetch()) {
    echo json_encode([]);
    exit;
}

$stmt = $db->prepare(
    'SELECT sender_id, message_text, created_at 
     FROM messages 
     WHERE connection_id = ?
     ORDER BY created_at ASC'
);
$stmt->execute([$connId]);
$msgs = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($msgs);
