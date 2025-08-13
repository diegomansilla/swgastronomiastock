<?php
include 'conectar2.php'; // Incluye el archivo de conexión a la base de datos

// Consulta para obtener todas las materias primas
// Se seleccionan los campos necesarios de la tabla materia_prima
$sql = "select mp.id, mp.codigo_barra, mp.descripcion, mp.contenido_neto, mp.marca,
        IFNULL(SUM(imp.cantidad), 0) AS cantidad, MAX(imp.fecha_lote) AS fecha_lote,
        MAX(imp.fecha) AS fecha_ingreso, MAX(imp.fecha_vencimiento) AS fecha_vencimiento
        FROM materia_prima mp
        LEFT JOIN ingreso_materia_prima imp ON mp.id = imp.id_materia_prima
        GROUP BY mp.id, mp.codigo_barra, mp.descripcion, mp.contenido_neto, mp.marca
        ORDER BY mp.descripcion ASC";

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
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Materia prima actualizada correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['ok']) && $_GET['ok'] == 'eliminado'): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            ⚠️ Materia prima eliminada correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
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
                                <td><?= $fila['fecha_ingreso'] ?></td>
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