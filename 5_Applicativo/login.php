

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login - Nexa</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f8fa;
      margin: 0;
      padding: 0;
    }
    .login-box {
      max-width: 400px;
      margin: 60px auto;
      padding: 25px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .login-box h2 {
      text-align: center;
      color: #333;
    }
    .login-box label {
      display: block;
      margin: 10px 0 4px;
      color: #444;
      font-size: 14px;
    }
    .login-box input {
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
      background: #007bff;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s ease;
    }
    .btn-submit:hover {
      background: #0056d2;
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

<div class="login-box">
  <h2>Accedi</h2>

  <form action="login_action.php" method="post">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit" class="btn-submit">Login</button>
  </form>

  <p class="text-center">Non hai un account? <a href="Registrazione.php">Registrati</a></p>
</div>

</body>
</html>
