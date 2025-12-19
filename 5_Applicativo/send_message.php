<?php
require_once 'config.php';
require_once 'functions.php';
requireLogin();


$connId = intval($_POST['conn_id'] ?? 0);
$msg    = trim($_POST['msg'] ?? '');

if ($connId <= 0 || $msg === '') {
    header("Location: chat.php?conn=" . $connId);
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
    header("Location: chat.php?conn=" . $connId);
    exit;
}


$stmt = $db->prepare(
    'INSERT INTO messages (connection_id, sender_id, message_text, message_type) 
     VALUES (?, ?, ?, "text")'
);
$stmt->execute([$connId, $_SESSION['userId'], $msg]);

header("Location: chat.php?conn=" . $connId);
exit;
