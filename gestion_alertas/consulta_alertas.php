<?php
include '..\conectar.php';

// Consulta para tabla principal (modificable)
$sql_alertas = "SELECT 
    mp.id,
    mp.descripcion,
    mp.marca,
    mp.stock_minimo,
    imp.cantidad,
    imp.fecha_lote,
    imp.fecha_vencimiento,
    CASE 
        WHEN imp.fecha_vencimiento < CURDATE() THEN 'VENCIDO'
        WHEN imp.fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 'POR VENCER'
        WHEN imp.cantidad < mp.stock_minimo THEN 'STOCK BAJO'
        WHEN imp.cantidad BETWEEN mp.stock_minimo AND mp.stock_minimo + 5 THEN 'STOCK CERCA DEL MINIMO'
        ELSE 'OK'
    END AS estado
FROM materia_prima mp
LEFT JOIN ingreso_materia_prima imp 
    ON mp.id = imp.id;
";

$result_alertas = $conexion->query($sql_alertas);

// Consulta para modal (solo lectura)
$sql_modal = $sql_alertas; // misma consulta, pero guardada en otro result
$result_modal = $conexion->query($sql_modal);
?>
