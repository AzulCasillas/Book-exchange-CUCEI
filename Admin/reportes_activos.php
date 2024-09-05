<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes Pendientes</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            display: inline-block;
        }
    </style>
</head>
<body>

<?php
    session_start();

    // Incluir el archivo de conexión a la base de datos
    require_once("../funciones/conecta.php");

    // Inicializar la variable del script JavaScript
    $script = "";

    // Obtener los reportes pendientes
    function obtenerReportesPendientes() {
        global $script;
        $con = conecta();

        if ($con->connect_error) {
            die("Conexión fallida: " . $con->connect_error);
        }

        // Consulta para obtener los reportes pendientes
        $sql = "SELECT * FROM reportes WHERE estado = 'pendiente'";
        $result = $con->query($sql);

        // Verificar si se encontraron reportes pendientes
        if ($result->num_rows > 0) {
            // Imprimir la tabla de reportes
            echo "<h2>Reportes Pendientes</h2>";
            echo "<table border='1'>";
            echo "<tr><th>ID Reporte</th><th>Contenido</th><th>Usuario Reportado</th><th>Actualizar Estado</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["idr"] . "</td>";
                echo "<td>" . $row["contenido"] . "</td>";
                echo "<td>" . obtenerNombreUsuario($row["perfil_id"]) . "</td>"; // Obtener el nombre del usuario reportado
                echo "<td>";
                echo "<form method='post' action='actualizar_estado.php'>";
                echo "<input type='hidden' name='id_reporte' value='" . $row['idr'] . "'>";
                echo "<select name='nuevo_estado'>";
                echo "<option value='pendiente'>Pendiente</option>";
                echo "<option value='aceptado'>Aceptado</option>";
                echo "<option value='rechazado'>Rechazado</option>";
                echo "</select>";
                echo "<button type='submit'>Actualizar</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            // No hay reportes pendientes, almacenar el script del alerta en la variable
            $script = "<script>alert('No hay reportes pendientes.'); window.location.href = 'usuarios_lista.php';</script>";
        }

        $con->close();
    }

    // Obtener el nombre de usuario a partir de su ID
    function obtenerNombreUsuario($perfil_id) {
        $con = conecta();

        if ($con->connect_error) {
            die("Conexión fallida: " . $con->connect_error);
        }

        // Consulta para obtener el nombre del usuario
        $sql = "SELECT nombre FROM usuarios WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $perfil_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Obtener el nombre del usuario
        $nombre = "";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nombre = $row["nombre"];
        }

        $stmt->close();
        $con->close();

        return $nombre;
    }

    // Mostrar los reportes pendientes
    obtenerReportesPendientes();
?>

<!-- Imprimir el script JavaScript al final del cuerpo del HTML -->
<?php echo $script; ?>

</body>
</html>
