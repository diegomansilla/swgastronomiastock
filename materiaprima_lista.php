<?php
include 'conectar.php'; // Incluye el archivo de conexión a la base de datos

// Consulta para obtener todas las materias primas con stock
// Se seleccionan los campos necesarios de la tabla materia_prima
$sqlcst = "SELECT mp.id, mp.codigo_barra, mp.descripcion,
        mp.contenido_neto, um.nombre AS unidad_medida,
        mp.marca, mp.stock_minimo, mp.stock_maximo
    FROM materia_prima mp
    LEFT JOIN unidad_medida um ON mp.id_unidad_medida = um.id
    WHERE mp.estado = 1
    GROUP BY mp.id, mp.codigo_barra, mp.descripcion, mp.contenido_neto, unidad_medida";

// Consulta para obtener todas las materias primas sin stock
// Se seleccionan los campos necesarios de la tabla materia_prima
$sqlsst = "SELECT mp.id, mp.codigo_barra, mp.descripcion,
        mp.contenido_neto, um.nombre AS unidad_medida,
        mp.marca, mp.stock_minimo, mp.stock_maximo
    FROM materia_prima mp
    LEFT JOIN unidad_medida um ON mp.id_unidad_medida = um.id
    WHERE mp.estado = 0
    GROUP BY mp.id, mp.codigo_barra, mp.descripcion, mp.contenido_neto, unidad_medida";

// Ejecuta las consultas y almacena el resultado con o sin stock
$resultadocst = $conexion->query($sqlcst);
$resultadosst = $conexion->query($sqlsst);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Sistema Gestión de Stock Software - Gastronomía</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
            <a href="materia_prima.php" class="btn btn-success"><i class="bi bi-plus"></i>Agregar</a>
        </div>
        <h2 class="mb-4 text-center">En Stock</h2>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Código de Barra</th>
                        <th>Descripción</th>
                        <th>Contenido Neto</th>
                        <th>Unidad de Medida</th>
                        <th>Marca</th>
                        <th>Stock Mínimo</th>
                        <th>Stock Máximo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultadocst->num_rows > 0): ?>
                        <?php while ($fila = $resultadocst->fetch_assoc()): ?>
                            <tr>
                                <td><?= $fila['codigo_barra'] ?></td>
                                <td><?= $fila['descripcion'] ?></td>
                                <td><?= htmlspecialchars($fila['contenido_neto']) ?></td>
                                <td><?= htmlspecialchars($fila['unidad_medida']) ?></td>
                                <td><?= htmlspecialchars($fila['marca']) ?></td>
                                <td><?= htmlspecialchars($fila['stock_minimo']) ?></td>
                                <td><?= htmlspecialchars($fila['stock_maximo']) ?></td>
                                <td>
                                    <a href="materia_prima.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i>Editar</a>
                                    <a href="materiaprima_baja.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea dar de baja esta materia prima?');"><i class="bi bi-trash"></i>Baja</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No hay materias primas registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
        <h2 class="mb-4 text-center">Sin Stock</h2>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Código de Barra</th>
                        <th>Descripción</th>
                        <th>Contenido Neto</th>
                        <th>Unidad de Medida</th>
                        <th>Marca</th>
                        <th>Stock Mínimo</th>
                        <th>Stock Máximo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultadosst->num_rows > 0): ?>
                        <?php while ($fila = $resultadosst->fetch_assoc()): ?>
                            <tr>
                                <td><?= $fila['codigo_barra'] ?></td>
                                <td><?= $fila['descripcion'] ?></td>
                                <td><?= htmlspecialchars($fila['contenido_neto']) ?></td>
                                <td><?= htmlspecialchars($fila['unidad_medida']) ?></td>
                                <td><?= htmlspecialchars($fila['marca']) ?></td>
                                <td><?= htmlspecialchars($fila['stock_minimo']) ?></td>
                                <td><?= htmlspecialchars($fila['stock_maximo']) ?></td>
                                <td>
                                    <a href="materiaprima_alta.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('¿Seguro que desea dar de alta esta materia prima?');"><i class="bi bi-plus-circle"></i>Alta</a>
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