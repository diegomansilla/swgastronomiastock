<?php
include 'conectar.php'; // Incluye el archivo de conexión a la base de datos

// Consulta para obtener todas las materias primas
// Se seleccionan los campos necesarios de la tabla materia_prima
$sql = "SELECT mp.id, mp.codigo_barra,
        mp.descripcion,
        mp.contenido_neto,
        mp.marca, i.fecha_lote, i.fecha,i.fecha_vencimiento,
        COALESCE(SUM(i.cantidad),0) - COALESCE(SUM(s.cantidad),0) AS cantidad
    FROM materia_prima mp
    LEFT JOIN ingreso_materia_prima i ON mp.id = i.id_materia_prima
    LEFT JOIN salida_materia_prima s ON mp.id = s.id_materia_prima
    GROUP BY mp.id, mp.codigo_barra, mp.descripcion, mp.contenido_neto, mp.marca";

// Ejecuta la consulta y almacena el resultado
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Sistema Gestión de Stock Software - Gastronomía</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php if (isset($_GET['ok']) && $_GET['ok'] == 'editado'): ?>
        <!-- Modal de Éxito -->
        <div class="modal fade" id="modalOk" tabindex="-1" aria-labelledby="modalOkLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-success text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalOkLabel">✅ Éxito. Materia Prima actualizada correctamente</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Materia prima guardada correctamente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modalOk = new bootstrap.Modal(document.getElementById('modalOk'));
                modalOk.show();
            });
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['ok']) && $_GET['ok'] == 'eliminado'): ?>
        <!-- Modal de Éxito -->
        <div class="modal fade" id="modalOk" tabindex="-1" aria-labelledby="modalOkLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-success text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalOkLabel">⚠️ Éxito. Materia Prima eliminada correctamente</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Materia prima eliminada correctamente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modalOk = new bootstrap.Modal(document.getElementById('modalOk'));
                modalOk.show();
            });
        </script>
    <?php endif; ?>

    <?php
    include 'includes/header.php';
    ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container mt-5 mb-5 flex-grow-1">
        <h2 class="mb-4 text-center">Listado de Materias Primas</h2>
        <div class="mb-3">
            <input type="text" class="form-control" id="buscador" placeholder="Buscar por descripción, marca o código" onkeyup="buscarMateriaPrima()">
        </div>
        <div>
            <a href="materia_prima.php" class="btn btn-success">Nueva Materia Prima</a>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Código de Barra</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Fecha Lote</th>
                        <th>Fecha Ingreso</th>
                        <th>Fecha Vencimiento</th>
                        <th>Contenido Neto</th>
                        <th>Marca</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado->num_rows > 0): ?>
                        <?php while ($fila = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= $fila['codigo_barra'] ?></td>
                                <td><?= $fila['descripcion'] ?></td>
                                <td><?= $fila['cantidad'] ?></td>
                                <td><?= $fila['fecha_lote'] ?></td>
                                <td><?= $fila['fecha'] ?></td>
                                <td><?= $fila['fecha_vencimiento'] ?></td>
                                <td><?= htmlspecialchars($fila['contenido_neto']) ?></td>
                                <td><?= htmlspecialchars($fila['marca']) ?></td>
                                <td>
                                    <a href="materia_prima.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="materiaprima_baja.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-danger">Dar de Baja</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No hay materias primas registradas.</td>
                        </tr>
                    <?php endif; ?>
                    <?php $conexion->close(); ?>
                </tbody>
            </table>

        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>

    <script src='js/bootstrap.bundle.min.js'></script>
    <script src="js/particulares.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            buscarMateriaPrima('buscador', 'table tbody');
        });
    </script>
</body>

</html>