<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .container {
            width: 80%;
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            text-align: center;
            font-size: 20px;
        }
        .profile-info {
            padding: 15px;
            text-align: center;
        }
        .profile-info div {
            margin-bottom: 10px;
        }
        .profile-info div label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 3px;
        }
        .profile-info div span {
            color: #666;
        }
        .back-button {
            display: block;
            margin: 15px auto;
            width: fit-content;
            background-color: #007bff;
            color: #fff;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .profile-picture {
            margin-bottom: 15px;
        }
        .profile-picture img {
            width: 120px;
            height: auto;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<?php
require_once("conecta.php");

if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    $con = conecta();

    $sql = "SELECT * FROM usuarios WHERE id = $usuario_id";
    $res = $con->query($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $nombre = $row["nombre"];
        $codigo = $row["codigo"];
        $carrera = $row["carrera"];
        $correo = $row["correo"];
        $fecha_in = $row["fecha_in"];
        $archivo = $row["archivo_n"];
        $archivoc = $row["archivo_x"];

        // Aquí comienza la parte de HTML para mostrar el perfil del usuario
        echo "<div class='container'>";
        echo "<div class='header'>Perfil de Usuario</div>";
        echo "<div class='profile-info'>";
        echo "<div class='profile-picture'><img src='../archivos/$archivo' alt='Imagen de perfil'></div>";
        echo "<div class='profile-picture'><img src='../archivos/$archivoc' alt='Credencial estudiante'></div>";
        echo "<div><label>Código de la UDG:</label> <span>$codigo</span></div>";
        echo "<div><label>Nombre completo:</label> <span>$nombre</span></div>";
        echo "<div><label>Carrera:</label> <span>$carrera</span></div>";
        echo "<div><label>Correo:</label> <span>$correo</span></div>";
        echo "<div><label>Fecha de ingreso:</label> <span>$fecha_in</span></div>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div class='container'>";
        echo "<div class='header'>Perfil de Usuario</div>";
        echo "<div class='profile-info' style='text-align: center; padding: 20px;'>";
        echo "No se encontraron registros para el usuario.";
        echo "</div>";
        echo "</div>";
    }

    $con->close();
} else {
    echo "<div class='container'>";
    echo "<div class='header'>Perfil de Usuario</div>";
    echo "<div class='profile-info' style='text-align: center; padding: 20px;'>";
    echo "No se proporcionó ningún ID de usuario.";
    echo "</div>";
    echo "</div>";
}
?>

<a href="../Admin/usuarios_lista.php" class="back-button">Regresar a la tabla de usuarios</a>

</body>
</html>
