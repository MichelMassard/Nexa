<?php
require_once 'config.php';
require_once 'functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connId = intval($_POST['conn_id'] ?? 0);
    if ($connId > 0) {
        $stmt = $db->prepare('DELETE FROM connections WHERE id = ? AND (user_id = ? OR connected_user_id = ?)');
        $stmt->execute([$connId, $_SESSION['userId'], $_SESSION['userId']]);
    }
}

redirect('my_connections.php');
