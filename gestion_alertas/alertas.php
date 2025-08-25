<?php
include("../includes/header.php");
include("consulta_alertas.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Alertas</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.7/dist/morph/bootstrap.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="container mt-5 mb-5 flex-grow-1">
    <h2>Alertas vigentes <i class="bi bi-exclamation-triangle-fill"></i></h2>

    <!-- Botón Modal -->
    <div class="mb-3 d-flex justify-content-start">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalHistorial">
            Historial <i class="bi bi-clock-history"></i>
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalHistorial" tabindex="-1" aria-labelledby="modalHistorialLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHistorialLabel">Historial de Alertas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <table id="tablaModal" class="table table-striped">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Descripción</td>
                                <td>Marca</td>
                                <td>Stock Minimo</td>
                                <td>Cantidad</td>
                                <td>Fecha del lote</td>
                                <td>Fecha de vencimiento</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($result_modal && $result_modal->num_rows > 0): ?>
                            <?php while ($row = $result_modal->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['descripcion']; ?></td>
                                <td><?php echo $row['marca']; ?></td>
                                <td><?php echo $row['stock_minimo']; ?></td>
                                <td><?php echo $row['cantidad']; ?></td>
                                <td><?php echo $row['fecha_lote']; ?></td>
                                <td><?php echo $row['fecha_vencimiento']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No hay datos disponibles</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

    <!-- Tabla principal (modificable) -->
    <table id="tablaAlertas" class="table table-striped">
        <thead>
            <tr>
                <td>ID</td>
                <td>Descripción</td>
                <td>Marca</td>
                <td>Stock Minimo</td>
                <td>Cantidad</td>
                <td>Fecha del lote</td>
                <td>Fecha de vencimiento</td>
            </tr>
        </thead>
        <tbody>
        <?php if ($result_alertas && $result_alertas->num_rows > 0): ?>
            <?php while ($row = $result_alertas->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['descripcion']; ?></td>
                <td><?php echo $row['marca']; ?></td>
                <td><?php echo $row['stock_minimo']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td><?php echo $row['fecha_lote']; ?></td>
                <td><?php echo $row['fecha_vencimiento']; ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No hay datos disponibles</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    // Tabla principal editable
    $('#tablaAlertas').DataTable();

    // Modal solo lectura
    $('#tablaModal').DataTable({
        searching: false,
        ordering: false,
        paging: false,
        info: false
    });
});
</script>

<?php
include '../includes/footer.php';
?>
</body>
</html>
