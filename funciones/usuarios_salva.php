<?php
require "conecta.php";
$con = conecta();

$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$passEnc = md5($_POST['pass']); // Asegúrate de obtener la contraseña del formulario
$carrera = $_POST['carrera'];
$correo = $_POST['correo'];
$fecha_in = $_POST['fecha_in'];

// Nuevo campo para verificación predeterminada
$verificado = 0; // No verificado por defecto

if(isset($_FILES['archivo_fotoP'], $_FILES['archivo_fotoC'])) {
    $archivo_temp_fotoP = $_FILES['archivo_fotoP']['tmp_name'];
    $archivo_temp_fotoC = $_FILES['archivo_fotoC']['tmp_name'];

    if(!empty($archivo_temp_fotoP) && !empty($archivo_temp_fotoC)) {
        $ruta_directorio = "../archivos/";

        $nombre_fotoP = $_FILES['archivo_fotoP']['name'];
        $nombre_fotoC = $_FILES['archivo_fotoC']['name'];

        // Genera nombres encriptados únicos para los archivos
        $nombre_encriptadoP = md5(uniqid($nombre, true));
        $nombre_encriptadoC = md5(uniqid($nombre, true));

        // Rutas de destino para los archivos
        $ruta_archivoP = $ruta_directorio . $nombre_encriptadoP;
        $ruta_archivoC = $ruta_directorio . $nombre_encriptadoC;

        // Mueve las imágenes al directorio de destino
        if(move_uploaded_file($archivo_temp_fotoP, $ruta_archivoP) && 
           move_uploaded_file($archivo_temp_fotoC, $ruta_archivoC)) {
            // Inserta los datos en la base de datos, incluyendo el campo verificado
            $sql = "INSERT INTO usuarios (codigo, nombre, pass, carrera, correo, fecha_in, archivo_fotoP, archivo_n, archivo_fotoC, archivo_x, verificado) 
                    VALUES ('$codigo', '$nombre', '$passEnc', '$carrera', '$correo', '$fecha_in', '$nombre_fotoP', '$nombre_encriptadoP', '$nombre_fotoC', '$nombre_encriptadoC', $verificado)";
            $res = $con->query($sql);

            if($res) {
                // Muestra un mensaje de alerta y redirige al usuario después de aceptarlo
                echo "<script>alert('El administrador revisará que los datos sean correctos. Intente iniciar sesión más tarde.')</script>";
                echo "<script>window.location.href = '../index.php';</script>";
                exit();
            } else {
                echo "Error al insertar en la base de datos.";
            }
        } else {
            echo "Error al subir las fotos.";
        }
    } else {
        echo "Por favor, selecciona las dos fotos.";
    }
} else {
    echo "No se han subido las dos fotos.";
}

$con->close();
?>
