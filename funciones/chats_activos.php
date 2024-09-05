<?php
session_start();

require_once("conecta.php");
$con = conecta();

// Suponiendo que $idUser contiene el ID del usuario actual
$idUser = $_SESSION['idUser'];
$otroUsuarioID['otro']

$sql = "SELECT * FROM chats WHERE id_creador=$idUser OR id_invitado=$idUser";

$resultado = mysqli_query($con, $sql);

if (!$resultado) {
    echo "Error al ejecutar la consulta: " . mysqli_error($con);
} else {
    // Si la consulta se ejecuta correctamente, mostrar los chats
    echo "<h2>Chats activos:</h2>";
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "ID del chat: " . $row['id_sala'] . "<br>";
        echo "ID del creador: " . $row['id_creador'] . "<br>";
        echo "ID del invitado: " . $row['id_invitado'] . "<br>";
        // Botón para ingresar al chat
        echo "<form action='../sockets.php' method='post'>";
        echo "<input type='hidden' name='id_sala' value='" . $row['id_sala'] . "'>";
        echo "<input type='submit' value='Ingresar al chat'>";
        echo "</form>";
        echo "<br>";
    }
}

mysqli_close($con);
?>
