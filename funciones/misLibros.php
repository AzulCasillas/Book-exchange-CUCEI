<?php
session_start();

if (!isset($_SESSION['idUser'])) {
    header("Location: index.php");
    exit();
}

require "conecta.php";
$con = conecta();

$idUser = $_SESSION['idUser'];
$sql = "SELECT libros.*, usuarios.nombre AS nombre FROM libros JOIN usuarios ON libros.usuario_id = usuarios.id WHERE usuario_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Libros</title>
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.2), rgba(255,255,255,0.2)), url('imagen8.jpeg');
            background-size: cover;
            color: #333;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin-top: 20px;
            font-size: 2.5em;
            color: white;
        }

        p {
            font-size: 1.2em;
            color: white;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f8f8f8;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        img {
            max-width: 100px;
        }

        form {
            display: inline-block;
        }

        select, button {
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            transition-duration: 0.4s;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #007BB5;
        }

        .back-button {
            background-color: #555555;
        }

        .back-button:hover {
            background-color: #333333;
        }

        .message {
            font-size: 1em;
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Mis Libros</h1>
    <p>Libros de: <?php echo $_SESSION['nombreUser']; ?></p>

    <?php
    if (isset($_SESSION['message'])) {
        echo "<p class='message'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>

    <table>
        <tr>
            <th>Título</th>
            <th>Edición</th>
            <th>Reseña</th>
            <th>Status</th>
            <th>Propietario</th>
            <th>Foto</th>
            <th>Actualizar Status</th>
            <th>Eliminar</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['titulo']; ?></td>
                <td><?php echo $row['edicion']; ?></td>
                <td><?php echo $row['resena']; ?></td>
                <td><?php echo $row['status'] == 1 ? "Disponible" : "Prestado"; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><img src="../libros/<?php echo $row['archivo_f']; ?>" alt="Foto del libro"></td>
                <td>
                    <form method="post" action="actualizarStatus.php">
                        <input type="hidden" name="titulo" value="<?php echo $row['titulo']; ?>">
                        <select name="nuevo_status">
                            <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>>Disponible</option>
                            <option value="2" <?php if ($row['status'] == 2) echo 'selected'; ?>>Prestado</option>
                        </select>
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
                <td>
                    <form method="post" action="eliminar_Libro.php" onsubmit="return confirm('¿Está seguro de que desea eliminar este libro?');">
                        <input type="hidden" name="titulo" value="<?php echo $row['titulo']; ?>">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="pagPrincipal.php" class="back-button">Regresar a la página principal</a>
    <a href="perfil.php" class="button">Regresar al perfil</a>
    <a href="registroLibros.php" class="button">Registrar Libros</a>
</body>
</html>

