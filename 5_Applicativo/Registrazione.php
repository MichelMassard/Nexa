

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Registrazione - Nexa</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f8fa;
      margin: 0;
      padding: 0;
    }
    .register-box {
      max-width: 400px;
      margin: 60px auto;
      padding: 25px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .register-box h2 {
      text-align: center;
      color: #333;
    }
    .register-box label {
      display: block;
      margin: 10px 0 4px;
      color: #444;
      font-size: 14px;
    }
    .register-box input {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    .btn-submit {
      width: 100%;
      padding: 12px;
      margin-top: 18px;
      background: #28a745;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s ease;
    }
    .btn-submit:hover {
      background: #1e7e34;
    }
    .text-center {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }
    .text-center a {
      color: #007bff;
      text-decoration: none;
    }
  </style>
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="register-box">
  <h2>Registrati</h2>

  <form action="register_action.php" method="post">
    <label>Nickname</label>
    <input type="text" name="nickname" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Conferma Password</label>
    <input type="password" name="confirm_password" required>

    <button type="submit" class="btn-submit">Registrati</button>
  </form>

  <p class="text-center">Hai già un account? <a href="login.php">Login</a></p>
</div>

</body>
</html>
