<?php
include_once('../conectar.php');

$query = "
    SELECT 
        mp.descripcion AS nombre,
        COALESCE(SUM(imp.cantidad), 0) AS stock_actual,
        mp.stock_minimo,
        MIN(imp.fecha_vencimiento) AS fecha_vencimiento
    FROM 
        materia_prima mp
    LEFT JOIN ingreso_materia_prima imp ON mp.id = imp.id_materia_prima
    GROUP BY mp.id, mp.descripcion, mp.stock_minimo
    HAVING stock_actual <= mp.stock_minimo
        OR fecha_vencimiento <= CURDATE() + INTERVAL 7 DAY
    ORDER BY fecha_vencimiento ASC
    LIMIT 1
";

$resultado = mysqli_query($conexion, $query);

if ($resultado && $row = mysqli_fetch_assoc($resultado)) {
    ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="liveToast" class="toast show bg-warning text-dark" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-dark text-white">
                <strong class="me-auto">⚠ Alerta de Stock</strong>
                <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <strong><?= $row['nombre'] ?></strong><br>
                Stock actual: <?= $row['stock_actual'] ?><br>
                Stock mínimo: <?= $row['stock_minimo'] ?><br>
                Vence: <?= $row['fecha_vencimiento'] ?>
            </div>
        </div>
    </div>
    <script>
        const toastEl = document.getElementById('liveToast');
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    </script>
<?php
}
?>