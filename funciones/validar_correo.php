<?php
require "conecta.php";

$correo = $_POST['correo'];
$con = conecta();
if (!$con) {
    die("Error en la conexión a la base de datos");
}

$sql = "SELECT COUNT(*) as count FROM usuarios WHERE correo = '$correo'";
$result = $con->query($sql);

if ($result && $result->fetch_assoc()['count'] > 0) {
    echo 'si';
} else {
    echo 'no';
}
$con->close();
?>
