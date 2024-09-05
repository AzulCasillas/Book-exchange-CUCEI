<?php
session_start();
require "../funciones/conecta.php";
$con = conecta();
$sql = "SELECT * FROM usuarios WHERE eliminado = 0 ORDER BY verificado ASC"; // Ordena por verificado de manera ascendente
$res = $con->query($sql);
$num = $res->num_rows;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .tabla {
            width: 80%;
            margin: 0 auto; /* Centra la tabla horizontalmente */
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        .tabla th, .tabla td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        .tabla th {
            background-color: #f2f2f2;
        }

        .verificar-button {
            background-color: #2133f3;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
        }

        .verificar-button:hover {
            background-color: #1a287a;
        }

        .reportes-button {
            background-color: #2133f3;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
        }

        .reportes-button:hover {
            background-color: #1a287a;
        }

        .cerrarsesion-button {
            background-color: #2133f3;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
        }

        .cerrarsesion-button:hover {
            background-color: #1a287a;
        }
    </style>
</head>
<body>
    <h2>Listado de usuarios (<?php echo $num; ?>)</h2>
    <div class="columna"><a class="reportes-button" href="reportes_activos.php">Reportes Activos</a></div>
    <br>
    <a href="../funciones/cerrar_sesion.php" class="cerrarsesion-button">Cerrar sesión</a>
    <table class="tabla">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Correo</th>
            <th>Foto de perfil</th>
            <th>Foto de usuario</th>
            <th>Verificado</th>
            <th>Ver detalle</th>
            <th>Strikes</th>
            <th>Verificar</th>
        </tr>
        <?php while ($row = $res->fetch_array()) { ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["nombre"]; ?></td>
                <td><?php echo $row["codigo"]; ?></td>
                <td><?php echo $row["correo"]; ?></td>
                <td><img src="../archivos/<?php echo $row["archivo_n"]; ?>" alt="Foto de perfil" style="max-width: 100px; max-height: 100px;"></td>
                <td><img src="../archivos/<?php echo $row["archivo_x"]; ?>" alt="Foto de usuario" style="max-width: 100px; max-height: 100px;"></td>
                <td><?php echo $row["verificado"] == 1 ? "Validado" : "Pendiente de validar"; ?></td>
                <td><a href="../funciones/perfil_administrador.php?id=<?php echo $row["id"]; ?>">Ver perfil</a></td>
                <td><?php echo $row["strikes"]; ?></td>
                <td><a href="verificar_usuario.php?id=<?php echo $row["id"]; ?>" class="verificar-button">Verificar</a></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
