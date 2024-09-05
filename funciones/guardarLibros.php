<?php
session_start();
if(isset($_SESSION['idUser'])) {
    $usuario_id = $_SESSION['idUser'];
} else {
    // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión o mostrar un mensaje de error
    header("Location: ../index.php");
    exit();
}
require "conecta.php";
$con = conecta();

// Comprobamos si el usuario está autenticado y obtenemos su id

$titulo = $_POST['titulo'];
$edicion = $_POST['edicion'];
$resena = $_POST['resena'];
$status = $_POST['status'];

if(isset($_FILES['foto'])) {
    $archivo_temp_foto = $_FILES['foto']['tmp_name'];

    if(!empty($archivo_temp_foto)) {
        $ruta_directorio = "../libros/";

        $nombre_foto = $_FILES['foto']['name'];

        $nombre_encriptadoF = md5(uniqid($nombre_foto, true));

        $ruta_archivo = $ruta_directorio . $nombre_encriptadoF;

        if(move_uploaded_file($archivo_temp_foto, $ruta_archivo)) {

            $sql = "INSERT INTO libros (usuario_id, titulo, edicion, resena, status, foto, archivo_f) 
                    VALUES ('$usuario_id', '$titulo', '$edicion', '$resena', '$status', '$nombre_foto', '$nombre_encriptadoF')";
            $res = $con->query($sql);

            if($res) {
                header("Location: misLibros.php");
                exit();
            } else {
                echo "Error al insertar en la base de datos.";
            }
        } else {
            echo "Error al subir las fotos.";
        }
    } else {
        echo "Por favor, selecciona las fotos.";
    }
} else {
    echo "No se han subido las fotos.";
}

$con->close();
?>
