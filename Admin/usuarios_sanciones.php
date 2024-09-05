<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Comentarios</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
</html>

<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("Location: ../index.php");
    exit();
}

require_once("../funciones/conecta.php");
$conexion = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comentario"])) {
    $otroUsuarioID = $_POST["otroUsuarioID"]; // Cambio aquí
    $contenido = $conexion->real_escape_string($_POST["comentario"]);
    $estado = "pendiente";

    $sql = "INSERT INTO reportes (contenido, estado, perfil_id) VALUES ('$contenido', '$estado', '$otroUsuarioID')";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>
                Swal.fire({
                    title: 'Reporte enviado correctamente',
                    text: 'El reporte ha sido enviado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Entendido'
                }).then(function() {
                    window.location.href = '../funciones/pagPrincipal.php';
                });
              </script>";
        exit();
    } else {
        echo "Error al enviar el reporte: " . $conexion->error;
    }

    $conexion->close();
} else {
    echo "Acceso denegado o no se ha enviado el comentario.";
}
?>
