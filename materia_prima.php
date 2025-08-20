<?php
include 'conectar.php';

$edicion = false;

// Datos por defecto
$datos = [
    'codigo_barra' => '',
    'descripcion' => '',
    'contenido_neto' => '',
    'cantidad' => '',
    'marca' => '',
    'stock_minimo' => '',
    'stock_maximo' => '',
    'fecha' => '',
    'fecha_lote' => '',
    'fecha_vencimiento' => ''
];

// Si es edición, obtener datos
if (isset($_GET['id'])) {
    $edicion = true;
    $id = $_GET['id'];

    $sql = "SELECT mp.id, mp.codigo_barra, mp.descripcion, mp.contenido_neto, mp.marca, 
       mp.stock_minimo, mp.stock_maximo,
       imp.fecha, imp.cantidad, imp.fecha_lote, imp.fecha_vencimiento
       FROM materia_prima mp
       LEFT JOIN ingreso_materia_prima imp 
       ON imp.id_materia_prima = mp.id
       WHERE mp.id = ?
       ORDER BY imp.fecha DESC
       LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $datos = $resultado->fetch_assoc();
    } else {
        header("Location: materiaprima_lista.php?error=notfound");
        exit;
    }
    $stmt->close();
}
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

    <?php include 'includes/header.php'; ?>

    <div class="container mt-5 mb-5 flex-grow-1">

        <?php if (isset($_GET['ok'])): ?>
            <!-- Modal de Éxito -->
            <div class="modal fade" id="modalOk" tabindex="-1" aria-labelledby="modalOkLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-success text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalOkLabel">✅ Éxito. Materia prima guardada</h5>
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
                    if (window.history.replaceState) {
                        const url = new URL(window.location);
                        url.searchParams.delete('ok');
                        window.history.replaceState({}, document.title, url.pathname);
                    }
                });
            </script>

        <?php elseif (isset($_GET['error'])): ?>
            <!-- Modal de Error -->
            <div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="modalErrorLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-danger text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalErrorLabel">❌ Error</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Hubo un error al guardar la materia prima.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var modalError = new bootstrap.Modal(document.getElementById('modalError'));
                    modalError.show();
                    if (window.history.replaceState) {
                        const url = new URL(window.location);
                        url.searchParams.delete('error');
                        window.history.replaceState({}, document.title, url.pathname);
                    }
                });
            </script>
        <?php endif; ?>

        <h2 class="mb-4 text-center">Materia Prima</h2>
        <form action="<?= $edicion ? 'materiaprima_actualizar.php' : 'materiaprima_guardar.php' ?>" method="POST">
            <?php if ($edicion): ?>
                <input type="hidden" name="id" value="<?= $datos['id'] ?>">
            <?php endif; ?>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col-sm-6">
                    <label for="cod_barra" class="form-label">Código de Barra</label>
                    <input type="text" class="form-control" id="cod_barra" name="cod_barra"
                        value="<?= htmlspecialchars($datos['codigo_barra']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="descript" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="descript" name="descript"
                        value="<?= htmlspecialchars($datos['descripcion']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="cont_neto" class="form-label">Contenido Neto</label>
                    <input type="text" class="form-control" id="cont_neto" name="cont_neto"
                        value="<?= htmlspecialchars($datos['contenido_neto']) ?>" placeholder="Contenido Neto de la materia prima en su unidad de medida" required>
                </div>
                <div class="col-sm-6">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad"
                        value="<?= htmlspecialchars($datos['cantidad']) ?>" placeholder="Cantidad de la materia prima" required>
                </div>
                <div class="col-sm-6">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca"
                        value="<?= htmlspecialchars($datos['marca']) ?>" placeholder="Marca" required>
                </div>
                <!-- Campos agregados -->
                <div class="col-sm-6">
                    <label for="stock_minimo" class="form-label">Stock Mínimo</label>
                    <input type="number" class="form-control" id="stock_minimo" name="stock_minimo"
                        value="<?= htmlspecialchars($datos['stock_minimo']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="stock_maximo" class="form-label">Stock Máximo</label>
                    <input type="number" class="form-control" id="stock_maximo" name="stock_maximo"
                        value="<?= htmlspecialchars($datos['stock_maximo']) ?>" required>
                </div>
                <!-- NUEVOS CAMPOS DE FECHAS -->
                <div class="col-sm-6">
                    <label for="fecha" class="form-label">Fecha de Ingreso</label>
                    <input type="date" class="form-control" id="fcha_ing" name="fcha_ing"
                        value="<?= htmlspecialchars($datos['fecha']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="fecha_lote" class="form-label">Fecha de Lote</label>
                    <input type="date" class="form-control" id="fcha_lote" name="fcha_lote"
                        value="<?= htmlspecialchars($datos['fecha_lote']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                    <input type="date" class="form-control" id="fcha_vto" name="fcha_vto"
                        value="<?= htmlspecialchars($datos['fecha_vencimiento']) ?>" required>

                </div>

            </div>
            <br>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col-sm-6">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a href="materiaprima_lista.php" class="btn btn-danger">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src='js/bootstrap.bundle.min.js'></script>
</body>

</html>