<?php
require_once 'config.php';
require_once 'functions.php';
requireLogin();

$connId = intval($_GET['conn'] ?? 0);
if ($connId <= 0) {
    redirect('my_connections.php');
}

$stmt = $db->prepare(
    'SELECT * FROM connections WHERE id = ? 
     AND (user_id = ? OR connected_user_id = ?)
     AND status = "accepted"'
);
$stmt->execute([$connId, $_SESSION['userId'], $_SESSION['userId']]);
$connection = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$connection) {
    echo "Connessione non valida.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chat</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <style>
      body {
        font-family: Arial, sans-serif;
        background: #f7f8fa;
        margin: 0;
        padding: 0;
      }
      .chat-box {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      }
      #messages {
        border: 1px solid #ddd;
        height: 300px;
        padding: 10px;
        overflow-y: auto;
        background: #fafafa;
        border-radius: 6px;
      }
      .message {
        margin-bottom: 10px;
        padding: 8px 12px;
        border-radius: 8px;
        max-width: 75%;
        word-wrap: break-word;
      }
      .message.me {
        background: #dcf8c6;
        float: left;
      }
      .message.other {
        background: #ececec;
        float: right;
      }
      .sender {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 4px;
      }
      .clear {
        clear: both;
      }
      form {
        margin-top: 15px;
      }
      textarea {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
      }
      .btn-send {
        display: block;
        width: 100%;
        padding: 10px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 15px;
        margin-top: 10px;
      }
      .btn-send:hover {
        background: #0056d2;
      }
      .btn-home {
        display:block;
        text-align:center;
        background:#6c757d;
        color:white;
        padding:8px 0;
        border-radius:8px;
        text-decoration:none;
        font-weight:bold;
        margin-bottom:15px;
      }
      .btn-home:hover {
        background:#545b62;
      }
    </style>
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="chat-box">
  <h2 style="text-align:center; color:#333;">Chat</h2>


  <a href="home.php" class="btn-home">← Torna alla Home</a>


  <div id="messages"></div>

  <form action="send_message.php" method="post">
    <input type="hidden" name="conn_id" value="<?= $connId ?>">
    <textarea name="msg" rows="3" required placeholder="Scrivi un messaggio..."></textarea>
    <button type="submit">Invia</button>
  </form>
</div>

<script>
const connId = <?= $connId ?>;
const userId = <?= $_SESSION['userId'] ?>;
const messagesDiv = document.getElementById('messages');
const msgForm = document.getElementById('msgForm');

function cleanHtml(str) {
    return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
}

function renderMessages(data) {
    messagesDiv.innerHTML = "";
    data.forEach(m => {
        const div = document.createElement("div");
        div.classList.add("message", (m.sender_id == userId ? "me" : "other"));

        const who = m.sender_id == userId ? "Tu" : "Altro";
        const text = cleanHtml(m.message_text).replace(/\n/g, "<br>");

        div.innerHTML = `<div class="sender">${who}:</div>${text}`;
        messagesDiv.appendChild(div);

        const clear = document.createElement("div");
        clear.style.clear = "both";
        messagesDiv.appendChild(clear);
    });
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

function loadMessages() {
    fetch("get_messages.php?conn=" + connId)
        .then(res => res.json())
        .then(data => {
            if (Array.isArray(data)) {
                renderMessages(data);
            }
        })
        .catch(err => {
            console.error("Errore caricamento messaggi:", err);
        });
}


loadMessages();
setInterval(loadMessages, 3000);


msgForm.addEventListener("submit", function(e) {
    e.preventDefault();
    const fd = new FormData(msgForm);
    fetch("send_message.php", { method: "POST", body: fd })
    .then(res => res.text())
    .then(() => {
        msgForm.msg.value = "";
        loadMessages();
    })
    .catch(err => console.error("Errore invio:", err));
});
</script>


</body>
</html>
