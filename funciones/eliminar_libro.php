<?php
session_start();

if (!isset($_SESSION['idUser'])) {
    header("Location: index.php");
    exit();
}

require "conecta.php";
$con = conecta();

if (isset($_POST['titulo'])) {
    $titulo = $_POST['titulo'];
    
    // Asegurarse de que el libro pertenece al usuario
    $idUser = $_SESSION['idUser'];
    $sql = "DELETE FROM libros WHERE titulo = ? AND usuario_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $titulo, $idUser);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Libro eliminado correctamente.";
    } else {
        $_SESSION['message'] = "Error al eliminar el libro o el libro no pertenece a usted.";
    }

    $stmt->close();
}

$con->close();
header("Location: misLibros.php");
exit();
?>
