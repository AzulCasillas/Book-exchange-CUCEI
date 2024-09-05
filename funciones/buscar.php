<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.1), rgba(255,255,255,0.1)), url('imagen9.jpg');
            background-size: cover;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        .container {
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 5px;
            margin-right: auto;
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .book {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .book p {
            margin: 5px 0;
        }
        .book p.title {
            font-weight: bold;
        }
        .book p.user {
            color: #888;
        }
        .user-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }
        .user-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php
require_once("conecta.php");
$con = conecta();

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

if (isset($_GET['titulo'])) {
    $titulo = $_GET['titulo'];

    // Modificación en la consulta SQL para filtrar los libros de usuarios con status en 1
    $sql = "SELECT libros.titulo, libros.usuario_id, usuarios.nombre, libros.edicion, libros.resena, libros.status 
            FROM libros 
            JOIN usuarios ON libros.usuario_id = usuarios.id 
            WHERE libros.titulo LIKE '%$titulo%' AND usuarios.status = 1";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Resultados de la búsqueda:</h2>";
        echo '<a href="pagPrincipal.php" class="back-button">Regresar a la página principal</a>';
        while ($row = $result->fetch_assoc()) {
            echo "<div class='book'>";
            echo "<p class='title'>Título: " . $row["titulo"] . "</p>";
            echo "<p class='user'>Usuario quien lo tiene: " . $row["nombre"] . "</p>";
            echo "<p class='user'>Edición del libro: " . $row["edicion"] . "</p>";
            echo "<p class='user'>Reseña del libro: " . $row["resena"] . "</p>";

            $status = $row["status"] == 1 ? "Disponible" : "Prestado";
            echo "<p class='user'>Status del libro: " . $status . "</p>";
            echo "<a href='perfilUsuarioBusqueda.php?id=" . $row["usuario_id"] . "' class='user-button'>Perfil del Usuario</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No se encontraron resultados.</p>";
    }
} else {
    echo "<p>Por favor, ingresa un término de búsqueda.</p>";
}

$con->close();
?>

    </div>
</body>
</html>
