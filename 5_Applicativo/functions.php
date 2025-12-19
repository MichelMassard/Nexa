<?php


function redirect($url) {
    header("Location: $url");
    exit;
}

function getPost($key) {
    return trim($_POST[$key] ?? '');
}

function requireLogin() {
    if (!isset($_SESSION['userId'])) {
        redirect('login.php');
    }
}
