<?php
session_start();
require "../funciones/conecta.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $con = conecta();

    // Actualizar el estado de verificación del usuario
    $sql = "UPDATE usuarios SET verificado = 1 WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: usuarios_lista.php");
        exit();
    } else {
        echo "Error al verificar el usuario.";
    }

    $stmt->close();
    $con->close();
} else {
    echo "No se ha proporcionado un ID de usuario válido.";
}
?>
