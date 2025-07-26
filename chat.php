<?php
// Simulate login (you can replace this with real authentication)
$sender = $_GET['sender'] ?? 'buyer';
$receiver = $sender === 'buyer' ? 'seller' : 'buyer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat - <?= ucfirst($sender) ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        #chat-box { background: #fff; border: 1px solid #ccc; padding: 15px; height: 400px; overflow-y: scroll; margin-bottom: 10px; }
        .message { margin: 10px 0; }
        .sender { font-weight: bold; }
        #chat-form { display: flex; gap: 10px; }
        #message { flex: 1; padding: 8px; }
        button { padding: 8px 12px; background: #28a745; color: #fff; border: none; border-radius: 4px; }
    </style>
</head>
<body>

<h2>Chat (You are: <?= ucfirst($sender) ?>)</h2>

<div id="chat-box"></div>

<form id="chat-form">
    <input type="text" id="message" placeholder="Type your message..." required>
    <button type="submit">Send</button>
</form>

<script>
// Auto-fetch chat every 2 seconds
function fetchChat() {
    fetch('fetch_messages.php?sender=<?= $sender ?>&receiver=<?= $receiver ?>')
        .then(res => res.text())
        .then(data => {
            document.getElementById('chat-box').innerHTML = data;
            document.getElementById('chat-box').scrollTop = 9999;
        });
}
fetchChat();
setInterval(fetchChat, 2000);

// Send message
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const message = document.getElementById('message').value;
    fetch('send_message.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'sender=<?= $sender ?>&receiver=<?= $receiver ?>&message=' + encodeURIComponent(message)
    }).then(() => {
        document.getElementById('message').value = '';
        fetchChat();
    });
});
</script>

</body>
</html>
