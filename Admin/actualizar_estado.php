<?php
session_start();
// Incluir el archivo de conexión a la base de datos
require_once("../funciones/conecta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibieron los datos del formulario
    if (isset($_POST['id_reporte'], $_POST['nuevo_estado'])) {
        $id_reporte = $_POST['id_reporte'];
        $nuevo_estado = $_POST['nuevo_estado'];

        // Actualizar el estado del reporte en la base de datos
        $con = conecta();
        if ($con->connect_error) {
            die("Conexión fallida: " . $con->connect_error);
        }

        // Preparar y ejecutar la consulta de actualización
        $sql = "UPDATE reportes SET estado = ? WHERE idr = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $nuevo_estado, $id_reporte);
        if ($stmt->execute()) {
            // Obtener el perfil_id del reporte actualizado
            $sql_perfil = "SELECT perfil_id FROM reportes WHERE idr = ?";
            $stmt_perfil = $con->prepare($sql_perfil);
            $stmt_perfil->bind_param("i", $id_reporte);
            $stmt_perfil->execute();
            $stmt_perfil->bind_result($perfil_id);
            $stmt_perfil->fetch();
            $stmt_perfil->close();

            // Redirigir a strikes.php pasando el perfil_id
            header("Location: strikes.php?perfil_id=$perfil_id");
            exit;
        } else {
            echo "Error al actualizar el estado del reporte.";
        }

        $stmt->close();
        $con->close();
    } else {
        echo "Falta información necesaria para actualizar el estado del reporte.";
    }
} else {
    // Redirigir si se intenta acceder al archivo directamente sin enviar datos desde el formulario
    header("Location: reportes_activos.php");
    exit;
}
?>
