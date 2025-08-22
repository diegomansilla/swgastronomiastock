<?php
include("conectar.php");

$id = intval($_GET['id']);

// Primero eliminar las relaciones con materias primas
$conexion->query("DELETE FROM plato_materia_prima WHERE plato_id=$id");

// Luego eliminar el plato
$conexion->query("DELETE FROM platos WHERE id=$id");

header("Location: platos.php?mensaje=Plato eliminado");
exit();
