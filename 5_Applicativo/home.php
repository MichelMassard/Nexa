<?php
require_once 'config.php';
require_once 'functions.php';
requireLogin();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Home - Nexa</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f8fa;
      margin: 0;
      padding: 0;
    }
    .home-box {
      max-width: 480px;
      margin: 50px auto;
      padding: 28px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
    }
    .home-box a {
      display: block;
      margin: 16px 0;
      padding: 12px;
      background: #007bff;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    .home-box a:hover {
      background: #0056d2;
    }
  </style>
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="home-box">
  <h2>Benvenuto!</h2>
  <a href="my_connections.php">Contatti / Richieste</a>
  <a href="connect_user.php" style="background: #28a745;">Aggiungi Contatto</a>
</div>

</body>
</html>
