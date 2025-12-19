<?php
require_once 'config.php';
require_once 'functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connId = intval($_POST['conn_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    
    if ($connId > 0 && in_array($action, ['accept','reject'])) {        
        $stmt = $db->prepare(
            'SELECT id FROM connections 
             WHERE id = ? 
             AND connected_user_id = ? 
             AND status = "pending"'
        );
        $stmt->execute([$connId, $_SESSION['userId']]);
        
        if ($stmt->fetch()) {
            $stmt = $db->prepare('UPDATE connections SET status = ? WHERE id = ?');
            $stmt->execute([$action == 'accept' ? 'accepted' : 'rejected', $connId]);
        }
    }
}

redirect('my_connections.php');