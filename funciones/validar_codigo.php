<?php
require_once("conecta.php"); // Asegúrate de tener un archivo para la conexión a la base de datos

$codigo = $_POST['codigo'];
$con = conecta();
if (!$con) {
    die("Error en la conexión a la base de datos");
}

$sql = "SELECT COUNT(*) as count FROM usuarios WHERE codigo = '$codigo'";
$result = $con->query($sql);

if ($result && $result->fetch_assoc()['count'] > 0) {
    echo 'si';
} else {
    echo 'no';
}
$con->close();
?>