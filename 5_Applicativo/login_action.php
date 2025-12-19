<?php
require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('login.php');
}

$email = getPost('email');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    echo "Email o password mancanti.";
    exit;
}

$stmt = $db->prepare('SELECT id, password_hash, salt FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password . $user['salt'], $user['password_hash'])) {
    echo "Credenziali errate.";
    exit;
}

$_SESSION['userId'] = $user['id'];
redirect('home.php');
