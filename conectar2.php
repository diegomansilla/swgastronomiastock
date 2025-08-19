<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base = "bbdd_gestion";

$conexion = mysqli_connect($servidor, $usuario, $password, $base);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
