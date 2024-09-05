<?php
session_start();
$nombre = $_SESSION['nombreUser'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de libros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #2133f3;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
    <div class="container">
    <h2 style="text-align: center;">Registro de nuevos libros</h2>
        <form method="post" action="guardarLibros.php" enctype="multipart/form-data">
            <input type="text" name="titulo" placeholder="Titulo del libro" required><br>
            <input type="text" name="edicion" placeholder="Edicion del libro" required><br>
            <input type="text" name="resena" placeholder="Reseña del libro" required><br>
            <h3>Status del libro</h3>
            <select id="status" name="status">
                <option value="0">Selecciona</option>
                <option value="1">Disponible</option>
                <option value="2">Prestado</option>
            </select>
            <br>
            <br>
            <input type="file" id="foto" name="foto"><br><br>
            <input type="submit" value="Guardar" />
        </form>
    </div>
</body>
</html>
