<?php
session_start();

require_once("funciones/conecta.php");

function validarUsuario($nombre, $contraseña) {
    $con = conecta();

    if ($con->connect_error) {
        die("Conexión fallida: " . $con->connect_error);
    }

    $sql = "SELECT * FROM usuarios WHERE nombre = ? AND pass = ? AND verificado = 1"; // Agregar verificación de usuario
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $nombre, $contraseña);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;

    if ($result->num_rows > 0) {
        echo "success";
    } else {
        echo "Nombre de usuario, contraseña incorrectos o usuario no validado por el administrador";
    }

    if($num == 1){
        $row = $result->fetch_array();
        $id = $row["id"];
        $nombre = $row["nombre"];
        $correo = $row["correo"];

        $_SESSION['idUser'] = $id;
        $_SESSION['nombreUser'] = $nombre;
        $_SESSION['correoUser'] = $correo;
    }

    $stmt->close();
    $con->close();
}

$nombre = $_POST['nombre'];
$contraseña = md5($_POST['contraseña']);

validarUsuario($nombre, $contraseña);
?>
