<?php
include_once('../conectar2.php');

$alertas = [];

$query = "
SELECT 
    mp.id,
    mp.descripcion AS nombre,
    COALESCE(SUM(imp.cantidad), 0) AS stock_actual,
    mp.stock_minimo,
    DATE_FORMAT(
        MIN(CASE WHEN imp.fecha_vencimiento != '0000-00-00' THEN imp.fecha_vencimiento END), 
        '%d/%m/%Y'
    ) AS fecha_vencimiento,
    MIN(CASE WHEN imp.fecha_vencimiento != '0000-00-00' THEN imp.fecha_vencimiento END) AS fecha_venc_raw
FROM 
    materia_prima mp
LEFT JOIN 
    ingreso_materia_prima imp ON mp.id = imp.id_materia_prima
GROUP BY 
    mp.id, mp.descripcion, mp.stock_minimo
HAVING 
    COALESCE(SUM(imp.cantidad), 0) <= mp.stock_minimo
    OR 
    MIN(CASE WHEN imp.fecha_vencimiento != '0000-00-00' THEN imp.fecha_vencimiento END) <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
ORDER BY 
    CASE 
        WHEN COALESCE(SUM(imp.cantidad), 0) <= 0 OR MIN(CASE WHEN imp.fecha_vencimiento != '0000-00-00' THEN imp.fecha_vencimiento END) < CURDATE() THEN 1
        WHEN DATEDIFF(MIN(CASE WHEN imp.fecha_vencimiento != '0000-00-00' THEN imp.fecha_vencimiento END), CURDATE()) <= 3 OR COALESCE(SUM(imp.cantidad), 0) <= (mp.stock_minimo / 2) THEN 2
        ELSE 3
    END,
    MIN(CASE WHEN imp.fecha_vencimiento != '0000-00-00' THEN imp.fecha_vencimiento END) ASC
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