<?php
session_start();

$idUser = $_SESSION['idUser'];
$nombre = $_SESSION['nombreUser'];
$otroUsuarioID = $_POST["otroUsuarioID"];

require_once("funciones/conecta.php");

$con = conecta();

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

$sql = "SELECT * FROM chats WHERE (id_creador = ? OR id_creador = ?) AND (id_invitado = ? OR id_invitado = ?)"; // Agregar verificación de usuario
$stmt = $con->prepare($sql);
$stmt->bind_param("iiii", $idUser, $otroUsuarioID, $idUser, $otroUsuarioID);
$stmt->execute();
$result = $stmt->get_result();
$num = $result->num_rows;
$row = $result->fetch_assoc();

if ($num == 0) {
    $sql = "INSERT INTO chats (id_sala, id_creador, id_invitado) VALUES ('default', ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $idUser, $otroUsuarioID);
    $res = $stmt->execute();

    if ($res) {
        $sql = "SELECT * FROM chats WHERE (id_creador = ? OR id_creador = ?) AND (id_invitado = ? OR id_invitado = ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iiii", $idUser, $otroUsuarioID, $idUser, $otroUsuarioID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $room = $row['id_sala'];
    } else {
        echo "Error al iniciar chat.";
    }
} else {
    $room = $row['id_sala'];
}

$sql = "SELECT id_remitente, id_destinatario, mensaje FROM mensajes WHERE id_sala = ? ORDER BY id_mensaje ASC";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $room);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Socket.IO Test</title>
    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>

    <style>
        /* Estilo del chat */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.chat-container {
    max-width: 600px;
    margin: 20px auto;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.chat-header {
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    text-align: center;
}

.chat-history {
    padding: 10px;
    overflow-y: scroll;
    max-height: 400px;
}

.message {
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 8px;
}

.message-user-is-sender {
    background-color: #007bff;
    color: #fff;
    align-self: flex-end;
}

.message-user-is-addresse {
    background-color: #f0f0f0;
    color: #333;
    align-self: flex-start;
}

.message-text {
    word-wrap: break-word;
    max-width: 80%;
}

.input-container {
    display: flex;
    padding: 10px;
}

.input-container input[type="text"] {
    flex: 1;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.input-container button {
    padding: 8px 16px;
    margin-left: 10px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
}

    </style>

</head>
<body>
    <h1>Socket.IO Test</h1>

    <div id="chat-history" class="chat-history">
        <script>let previous_sender = null; </script>
        <?php while ($message = $result->fetch_assoc()): ?>
            <?php if ($message['id_remitente'] == $idUser): ?>
                <div class="message message-user-is-sender">
                    <span class="message-text"><?php echo $message['mensaje']; ?></span>
                </div>
            <?php else: ?>
                <div class="message message-user-is-addresse">
                    <span class="message-text"><?php echo $message['mensaje']; ?></span>
                </div>
            <?php endif; ?>
            <script>previous_sender =<?php $message['id_remitente']; ?></script>
        <?php endwhile; ?>
    </div>

    <input type="text" id="message" placeholder="Type a message..." />
    <button onclick="sendMessage()">Send</button>
    <ul id="messages"></ul>

    <script>
        var socket = io('http://localhost:5000/socket'); // Connect to the PHP Socket.IO server
        const chatHistory = document.getElementById('chat-history');

        socket.on('connect', function () {
            console.log('Connected to the server', "<?php echo $room; ?>");
            socket.emit('joinChatRoom', { creator: "<?php echo $idUser; ?>", guest: "<?php echo $otroUsuarioID; ?>", room: "<?php echo $room; ?>" })
        });

        socket.on('chat', (data) => {
        const div = document.createElement('div')
        const messageSpan = document.createElement('SPAN');
        messageSpan.setAttribute("class", "message-text")
        if ( previous_sender == data.sender) {
          if ( data.sender == "<?php echo $idUser; ?>") {
            div.setAttribute("class", "message message-user-is-sender")
          }
          else {
            div.setAttribute("class", "message message-user-is-addresse")
          }
          messageSpan.appendChild(document.createTextNode(data.message))
          div.appendChild(messageSpan)
        }
        else {
          if (data.sender == "<?php echo $idUser; ?>") {
            div.setAttribute("class", "message message-user-is-sender")
          }
          else {
            div.setAttribute("class", "message message-user-is-addresse")
          }
          messageSpan.appendChild(document.createTextNode(data.message))
          div.appendChild(messageSpan)
        }
        chatHistory.appendChild(div)
      });

        socket.on('disconnect', function () {
            console.log('Disconnected from the server');
        });

        function sendMessage() {
            let messageValue = document.getElementById('message').value
            data = { sender: "<?php echo $idUser; ?>", addresse: "<?php echo $otroUsuarioID; ?>", message: messageValue, room: "<?php echo $room; ?>" }
            socket.emit('chat', data);
            document.getElementById('message').value = ''
        }
    </script>
</body>
</html>
