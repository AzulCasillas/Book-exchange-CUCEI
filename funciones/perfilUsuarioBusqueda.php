<?php
require_once("conecta.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.3), rgba(255,255,255,0.3)), url('imagen12.jpg'); /* Agregar gradiente transparente */
            background-size: cover; /* Para asegurarse de que la imagen de fondo cubra todo el cuerpo */
            background-repeat: no-repeat; /* Evita la repetición de la imagen de fondo */
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            box-sizing: border-box;
        }

        .header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            text-align: center;
            font-size: 24px;
        }

        .profile-info {
            padding: 20px;
            text-align: left;
        }

        .profile-info div {
            margin-bottom: 15px;
        }

        .profile-info div label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .profile-info div span {
            color: #666;
            display: block;
        }

        .profile-picture {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #007bff;
            object-fit: cover;
        }

        .back-button,
        .report-button {
            margin-top: 10px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">Perfil de Usuario</div>
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
            $otroUsuarioID = $row["id"];

            // Aquí comienza la parte de HTML para mostrar el perfil del usuario
            echo "<div class='profile-info'>";
            echo "<div class='profile-picture'><img src='../archivos/$archivo' alt='Imagen de perfil'></div>";
            echo "<div><label>Código de la UDG:</label> <span>$codigo</span></div>";
            echo "<div><label>Nombre completo:</label> <span>$nombre</span></div>";
            echo "<div><label>Carrera:</label> <span>$carrera</span></div>";
            echo "<div><label>Correo:</label> <span>$correo</span></div>";
            echo "<div><label>Fecha de ingreso:</label> <span>$fecha_in</span></div>";
            echo "</div>";
        } else {
            echo "<div class='profile-info' style='text-align: center; padding: 20px;'>";
            echo "No se encontraron registros para el usuario.";
            echo "</div>";
        }

        $con->close();
    } else {
        echo "<div class='profile-info' style='text-align: center; padding: 20px;'>";
        echo "No se proporcionó ningún ID de usuario.";
        echo "</div>";
    }
    ?>
    <form method="POST" action="../sockets.php">
        <input type="hidden" value="<?php echo $otroUsuarioID; ?>" name="otroUsuarioID">
        <button type="submit" class="btn btn-primary back-button">Iniciar chat</button>
    </form>
    <a href="../Admin/reportes.php?id=<?php echo $usuario_id; ?>" class="btn btn-danger report-button">Reportar</a>
    <a href="pagPrincipal.php" class="btn btn-primary back-button">Volver a la pagina principal</a>
</div>

</body>
</html>

