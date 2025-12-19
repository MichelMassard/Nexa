<?php
require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('Registrazione.php');
}

$nickname = getPost('nickname');
$email    = getPost('email');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

if ($nickname === '' || $email === '' || $password === '' || $confirm === '') {
    echo "Tutti i campi sono obbligatori.";
    exit;
}

if ($password !== $confirm) {
    echo "Le password non coincidono.";
    exit;
}

$stmt = $db->prepare('SELECT id FROM users WHERE email = ? OR nickname = ?');
$stmt->execute([$email, $nickname]);
if ($stmt->fetch()) {
    echo "Email o nickname già in uso.";
    exit;
}

$salt = bin2hex(random_bytes(16));
$hash = password_hash($password . $salt, PASSWORD_BCRYPT);

$stmt = $db->prepare(
    'INSERT INTO users (nickname, email, password_hash, salt) VALUES (?, ?, ?, ?)'
);
$stmt->execute([$nickname, $email, $hash, $salt]);

redirect('login.php');
