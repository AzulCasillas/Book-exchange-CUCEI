<?php
session_start();

require "../funciones/conecta.php";
$con = conecta();

if (isset($_GET['perfil_id'])) {
    $perfil_id = $_GET['perfil_id'];
    
    // Verificar si el reporte con el perfil_id tiene estado aceptado
    $sql = "SELECT * FROM reportes WHERE perfil_id = ? AND estado = 'aceptado'";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $perfil_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        // Actualizar los strikes del usuario
        $sql_update = "UPDATE usuarios SET strikes = strikes + 1 WHERE id = ?";
        $stmt_update = $con->prepare($sql_update);
        $stmt_update->bind_param("i", $perfil_id);

        if ($stmt_update->execute()) {
            // Verificar si el usuario tiene ahora 3 strikes
            $sql_check_strikes = "SELECT strikes FROM usuarios WHERE id = ?";
            $stmt_check = $con->prepare($sql_check_strikes);
            $stmt_check->bind_param("i", $perfil_id);
            $stmt_check->execute();
            $stmt_check->bind_result($strikes);
            $stmt_check->fetch();
            $stmt_check->close();

            if ($strikes >= 3) {
                // Actualizar el status y eliminado si strikes es 3 o más
                $sql_update_status = "UPDATE usuarios SET status = 0, eliminado = 1 WHERE id = ?";
                $stmt_status = $con->prepare($sql_update_status);
                $stmt_status->bind_param("i", $perfil_id);
                $stmt_status->execute();
                $stmt_status->close();
            }

            echo "Se ha actualizado el usuario con ID: $perfil_id <br>";
            // Redirigir a la lista de usuarios
            header("Location: usuarios_lista.php");
            exit;
        } else {
            echo "Error al actualizar el usuario con ID: $perfil_id <br>";
            // Puedes agregar detalles adicionales del error con $stmt_update->error
        }

        $stmt_update->close();
    } else {
        echo "No hay reportes aceptados para el perfil_id: $perfil_id <br>";
    }

    $stmt->close();
} else {
    echo "No se ha proporcionado un perfil_id válido.";
}

$con->close();
?>
