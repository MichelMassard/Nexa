<?php
require_once 'config.php';
require_once 'functions.php';
requireLogin();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contatti e Richieste</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <style>
      body {
        font-family: Arial, sans-serif;
        background: #f7f8fa;
        margin: 0;
        padding: 0;
      }
      .content-box {
        max-width: 550px;
        margin: 50px auto;
        padding: 25px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      }
      .content-box h2 {
        text-align: center;
        color: #333;
        margin-bottom: 10px;
      }
      .content-box p.intro {
        text-align: center;
        color: #555;
        margin-bottom: 15px;
      }
      .btn-home {
        display: block;
        text-align: center;
        background: #007bff;
        color: white;
        padding: 10px 0;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        margin-bottom: 20px;
        transition: 0.3s ease;
      }
      .btn-home:hover {
        background: #0056d2;
      }
      .connection-item {
        margin: 12px 0;
        padding: 12px;
        background: #fafafa;
        border: 1px solid #ddd;
        border-radius: 8px;
      }
      .connection-item strong {
        font-size: 16px;
      }
      .connection-status {
        margin-top: 4px;
        font-size: 14px;
        color: #555;
      }
      .btn-action {
        padding: 6px 10px;
        margin-right: 6px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        color: white;
      }
      .btn-accept { background: #28a745; }
      .btn-reject { background: #dc3545; }
      .btn-chat { background: #007bff; }
      .btn-delete { background: #6c757d; }
      .btn-action:hover {
        opacity: 0.85;
      }
      .no-connections {
        text-align: center;
        margin: 18px 0;
        color: #666;
      }
    </style>
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="content-box">
  <h2>I tuoi contatti e richieste</h2>

  <p class="intro">
    Qui puoi vedere le tue connessioni, le richieste inviate e quelle da gestire.
  </p>

  <a href="home.php" class="btn-home">← Torna alla Home</a>

  <?php
  $stmt = $db->prepare(
      'SELECT c.id, u.nickname, c.status, c.user_id, c.connected_user_id 
       FROM connections c
       JOIN users u ON (
            (u.id = c.connected_user_id AND c.user_id = ?) 
         OR (u.id = c.user_id AND c.connected_user_id = ?)
       )
       WHERE c.user_id = ? OR c.connected_user_id = ?
       ORDER BY c.created_at DESC'
  );
  $stmt->execute([
      $_SESSION['userId'],
      $_SESSION['userId'],
      $_SESSION['userId'],
      $_SESSION['userId']
  ]);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <?php if (empty($rows)): ?>
      <p class="no-connections">Non hai contatti o richieste al momento.</p>
  <?php endif; ?>

  <?php foreach ($rows as $r): ?>
    <div class="connection-item">

      <?php
      if ($r['user_id'] == $_SESSION['userId']) {
          $otherNickname = htmlspecialchars($r['nickname']);
          $direction = "Richiesta inviata a";
      } else {
          $otherNickname = htmlspecialchars($r['nickname']);
          $direction = "Richiesta da";
      }
      ?>

      <strong><?= $direction ?> <?= $otherNickname ?></strong>
      <p class="connection-status">Stato: <?= htmlspecialchars($r['status']) ?></p>

      <?php if ($r['status'] === 'pending' && $r['connected_user_id'] == $_SESSION['userId']): ?>
        <form action="manage_connections.php" method="post" style="display:inline">
          <input type="hidden" name="conn_id" value="<?= $r['id'] ?>">
          <button type="submit" name="action" value="accept" class="btn-action btn-accept">Accetta</button>
          <button type="submit" name="action" value="reject" class="btn-action btn-reject">Rifiuta</button>
        </form>

      <?php elseif ($r['status'] === 'pending'): ?>
        <span style="font-size:14px; color:#777;">In attesa di risposta</span>

      <?php elseif ($r['status'] === 'accepted'): ?>
        <a href="chat.php?conn=<?= $r['id'] ?>" class="btn-action btn-chat">Chatta</a>
        <form action="delete_connection.php" method="post" style="display:inline">
          <input type="hidden" name="conn_id" value="<?= $r['id'] ?>">
          <button type="submit" class="btn-action btn-delete">Elimina</button>
        </form>

      <?php endif; ?>

    </div>
  <?php endforeach; ?>

</div>

</body>
</html>
