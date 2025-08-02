<?php 
include("conectar.php");



$limite_dias = 7;

$query = "
    SELECT 
        mp.descripcion AS nombre,
        COALESCE(SUM(imp.cantidad), 0) - COALESCE(SUM(smp_cant.cantidad), 0) AS stock_actual,
        mp.stock_minimo,
        MIN(imp.fecha_vencimiento) AS proximo_vencimiento
    FROM materia_prima mp
    LEFT JOIN ingreso_materia_prima imp ON mp.id = imp.id_materia_prima
    LEFT JOIN (
        SELECT id_materia_prima, COUNT(*) as cantidad 
        FROM salida_materia_prima 
        GROUP BY id_materia_prima
    ) smp_cant ON mp.id = smp_cant.id_materia_prima
    GROUP BY mp.id
    HAVING stock_actual <= stock_minimo OR proximo_vencimiento <= DATE_ADD(CURDATE(), INTERVAL $limite_dias DAY)
";

$result = mysqli_query($conexion, $query);
$alertas = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $alertas[] = $row;
    }
}
?>
