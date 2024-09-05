<?php
session_start();

// Verificar si el usuario está autenticado
if(!isset($_SESSION['idUser'])) {
    header("Location: ../index.php");
    exit();
}

// Verificar si se recibieron los datos del formulario
if(isset($_POST['titulo']) && isset($_POST['nuevo_status'])) {
    // Conectarse a la base de datos
    require "conecta.php";
    $con = conecta();

    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $nuevo_status = $_POST['nuevo_status'];

    // Actualizar el estado del libro en la base de datos
    $sql = "UPDATE libros SET status = ? WHERE titulo = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("is", $nuevo_status, $titulo);
    $stmt->execute();

    // Cerrar la consulta preparada
    $stmt->close();

    // Cerrar la conexión a la base de datos
    $con->close();

    // Redirigir de vuelta a misLibros.php después de la actualización
    header("Location: misLibros.php");
    exit();
} else {
    // Si no se recibieron los datos del formulario, redirigir a una página de error o mostrar un mensaje de error
    echo "error";
    exit();
}
?>
