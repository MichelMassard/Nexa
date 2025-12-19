<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Benvenuto - Nexa</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f8fa;
      margin: 0;
      padding: 0;
    }
    .center-box {
      max-width: 450px;
      margin: 50px auto;
      text-align: center;
      padding: 30px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .center-box h2 {
      color: #333;
    }
    .btn {
      display: block;
      width: 100%;
      padding: 12px;
      margin: 12px 0;
      border-radius: 8px;
      text-decoration: none;
      font-size: 15px;
      font-weight: bold;
      color: white;
      transition: 0.3s ease;
    }
    .btn-login { background: #007bff; }
    .btn-login:hover { background: #0056d2; }
    .btn-register { background: #28a745; }
    .btn-register:hover { background: #1e7e34; }
  </style>
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="center-box">
  <h2>Benvenuto su Nexa!</h2>
  <p>Entra subito o crea un nuovo account per iniziare a chattare.</p>

  <?php if (isset($_SESSION['userId'])): ?>
    <a href="home.php" class="btn btn-login">Vai alla Home</a>
  <?php else: ?>
    <a href="login.php" class="btn btn-login">Accedi</a>
    <a href="Registrazione.php" class="btn btn-register">Registrati</a>
  <?php endif; ?>
</div>

</body>
</html>
