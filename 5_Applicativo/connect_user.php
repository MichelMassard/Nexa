<?php
require_once 'config.php';
require_once 'functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetNickname = getPost('nickname');

    if ($targetNickname === '') {
        $error = "Inserisci un nickname.";
    } else {
        $stmt = $db->prepare('SELECT id FROM users WHERE nickname = ? AND id != ?');
        $stmt->execute([$targetNickname, $_SESSION['userId']]);
        $target = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$target) {
            $error = "Utente non trovato o nickname non valido.";
        } else {
            $stmt = $db->prepare(
                'SELECT id FROM connections 
                 WHERE (user_id = ? AND connected_user_id = ?) 
                 OR (user_id = ? AND connected_user_id = ?)'
            );
            $stmt->execute([
                $_SESSION['userId'], $target['id'],
                $target['id'], $_SESSION['userId']
            ]);
            if ($stmt->fetch()) {
                $error = "Richiesta già inviata o utente già connesso.";
            } else {
                $stmt = $db->prepare(
                    'INSERT INTO connections (user_id, connected_user_id, status) 
                     VALUES (?, ?, "pending")'
                );
                $stmt->execute([$_SESSION['userId'], $target['id']]);
                $success = "Richiesta inviata con successo!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Aggiungi Contatto</title>
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
      margin: 60px auto;
      padding: 25px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
    }
    .center-box h2 {
      color: #333;
      margin-bottom: 10px;
    }
    .center-box p.intro {
      color: #555;
      margin-bottom: 15px;
      text-align: center;
    }
    .btn-home {
      display: block;
      text-align: center;
      background: #6c757d;
      color: white;
      padding: 10px 0;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      margin: 0 auto 20px auto;
      width: 85%;
      transition: 0.3s ease;
    }
    .btn-home:hover {
      background: #545b62;
    }
    .center-box label {
      display: block;
      text-align: left;
      margin-top: 12px;
      margin-bottom: 4px;
      color: #444;
      font-size: 14px;
    }
    .center-box input {
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
    .alert {
      color: #b02a37;
      font-size: 14px;
      margin-top: 15px;
    }
    .success {
      color: #1e7e34;
      font-size: 14px;
      margin-top: 15px;
    }
  </style>
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="center-box">
  <h2>Aggiungi un contatto</h2>

  <p class="intro">Inserisci il nickname dell’utente da aggiungere.</p>

  <a href="home.php" class="btn-home">← Torna alla Home</a>

  <?php if (!empty($error)): ?>
    <p class="alert"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <?php if (!empty($success)): ?>
    <p class="success"><?= htmlspecialchars($success) ?></p>
  <?php endif; ?>

  <form action="connect_user.php" method="post">
    <label>Nickname utente</label>
    <input type="text" name="nickname" required placeholder="Inserisci nickname">
    <button type="submit" class="btn-submit">Invia richiesta</button>
  </form>
</div>

</body>
</html>
