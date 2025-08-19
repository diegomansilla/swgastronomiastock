<?php
include("conectar.php");

$id = intval($_GET['id']);

// Primero eliminar las relaciones con materias primas
$conexion->query("DELETE FROM ingredientes_plato WHERE id_plato=$id");

// Luego eliminar el plato
$conexion->query("DELETE FROM platos WHERE id=$id");

header("Location: platos.php?mensaje=Plato eliminado");
exit();
