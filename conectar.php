<?php
$servidor = "localhost";
$usuario = "alesio";
$password = "hero2017";
$base = "bbdd_gestion1";

$conexion = mysqli_connect($servidor, $usuario, $password, $base);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
