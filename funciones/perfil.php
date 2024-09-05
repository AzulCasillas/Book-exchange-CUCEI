<?php
session_start();
$nombre = $_SESSION['nombreUser'];

require_once("conecta.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.4), rgba(255,255,255,0.4)), url('imagen4.jpeg');
            background-size: cover;
            color: #333;
        }
        .profile-picture, .credential-picture {
            max-width: 200px;
            max-height: 200px;
            width: auto;
            height: auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .profile-picture:hover, .credential-picture:hover {
            transform: scale(1.05);
        }
        .info-container {
            border: none;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px 10px 0 0;
            color: #333;
            font-weight: bold;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
        }
        .button {
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <?php
    if (isset($nombre)) {
        $con = conecta();
        $sql = "SELECT * FROM usuarios WHERE nombre = '$nombre'";
        $res = $con->query($sql);

        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $codigo = $row["codigo"];
            $carrera = $row["carrera"];
            $correo = $row["correo"];
            $fecha_in = $row["fecha_in"];
            $archivo = $row["archivo_n"];
            $archivoc = $row["archivo_x"];
    ?>
            <div class="card">
                <div class="card-header text-center">
                    Bienvenido <?php echo $nombre; ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-picture mb-3 mx-auto">
                            <h6>Foto de perfil:</h6>
                                <img src="../archivos/<?php echo $archivo; ?>" alt="Imagen de perfil" class="w-100">
                            </div>
                            <div class="credential-picture mx-auto">
                                <h6>Credencial:</h6>
                                <img src="../archivos/<?php echo $archivoc; ?>" alt="Credencial estudiante" class="w-100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-container p-3 mb-3">
                                <div class="mb-2"><strong>Código de la UDG:</strong> <?php echo $codigo; ?></div>
                                <div class="mb-2"><strong>Nombre completo:</strong> <?php echo $nombre; ?></div>
                                <div class="mb-2"><strong>Carrera:</strong> <?php echo $carrera; ?></div>
                                <div class="mb-2"><strong>Correo:</strong> <?php echo $correo; ?></div>
                                <div><strong>Fecha de ingreso:</strong> <?php echo $fecha_in; ?></div>
                            </div>
                            <div class="text-center">
                                <a href="pagPrincipal.php" class="btn btn-primary mr-2">Regresar a la página principal</a>
                                <a href="misLibros.php" class="btn btn-primary mr-2">Mis Libros</a>
                                <br><br><br>
                                <a href="cerrar_sesion.php" class="btn btn-danger">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        } else {
            echo "<div class='alert alert-info text-center'>No se encontraron registros para el usuario actual.</div>";
        }
        $con->close();
    } else {
        echo "<div class='alert alert-danger text-center'>No se pudo obtener el nombre de usuario de la sesión.</div>";
    }
    ?>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>