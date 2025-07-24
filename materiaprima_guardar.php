<?php
include 'conectar.php';

// Verifica si lo que se trae es por POST
// Si es así, se procede a guardar los datos en la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_barra = $_POST['cod_barra'];
    $descript = $_POST['descript'];
    $cant = $_POST['cant'];
    $fcha_lote = $_POST['fcha_lote'];
    $fcha_ing = $_POST['fcha_ing'];
    $fcha_vto = $_POST['fcha_vto'];
    $cont_neto = $_POST['cont_neto'];
    $marca = $_POST['marca'];

    // Verifica si todos los campos requeridos están llenos
    // Si alguno de los campos está vacío, redirige a la página de materia prima
    if (
        !empty($cod_barra) &&
        !empty($descript) &&
        !empty($cant) &&
        !empty($fcha_lote) &&
        !empty($fcha_ing) &&
        !empty($fcha_vto) &&
        !empty($cont_neto) &&
        !empty($marca)
    ) {
        // guardar en la base
    } else {
        header("Location: materia_prima.php?error=campos_vacios");
        exit;
    }

    // Preparar la consulta SQL
    $stmt = $connection->prepare("INSERT INTO materia_prima (codigo_barra, descripcion, cantidad, 
    fecha_lote, fecha_ingreso, fecha_vencimiento, contenido_neto, marca) 
            VALUES ('$cod_barra', '$descript', '$cant', '$fcha_lote', '$fcha_ing', '$fcha_vto', 
            '$cont_neto', '$marca')");

    // Vincular los parámetros a la consulta preparada
    // En este caso, no es necesario vincular parámetros ya que se están utilizando variables directamente
    if ($stmt->execute()) {
        header("Location: materia_prima.php?ok=1");
        exit;
    } else {
        header("Location: materia_prima.php?error=1");
        exit;
    }

    $stmt->close();
    $connection->close();
}

