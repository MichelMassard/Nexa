<?php

session_start();

$dbHost = 'localhost';   
$dbName = 'chat_p2p';
$dbUser = 'root';        
$dbPass = '';            

try {
    $db = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
                  $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore DB: " . $e->getMessage());
}
