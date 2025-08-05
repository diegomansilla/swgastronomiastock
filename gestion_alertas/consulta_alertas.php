<?php
include_once('../conectar.php');

$alertas = [];

$query = "
    SELECT 
        mp.descripcion AS nombre,
        COALESCE(SUM(imp.cantidad), 0) AS stock_actual,
        mp.stock_minimo,
        MIN(imp.fecha_vencimiento) AS fecha_vencimiento
    FROM 
        materia_prima mp
    LEFT JOIN 
        ingreso_materia_prima imp ON mp.id = imp.id_materia_prima
    GROUP BY 
        mp.id, mp.descripcion, mp.stock_minimo
    HAVING 
        stock_actual <= mp.stock_minimo
        OR 
        fecha_vencimiento <= CURDATE() + INTERVAL 7 DAY
";

$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $alertas[] = $fila;
    }
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>
