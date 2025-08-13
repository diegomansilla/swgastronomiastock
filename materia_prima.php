<?php
include 'conectar2.php';

$edicion = false;

// Datos por defecto
$datos = [
    'codigo_barra' => '',
    'descripcion' => '',
    'contenido_neto' => '',
    'marca' => '',
    'stok_minimo' => '',
    'stok_maximo' => '',
    'fecha' => '',
    'fecha_lote' => '',
    'fecha_vencimiento' => ''
];

// Si es edición, obtener datos
if (isset($_GET['id'])) {
    $edicion = true;
    $id = $_GET['id'];

    $sql = "SELECT id, codigo_barra, descripcion, contenido_neto, marca, stok_minimo, stok_maximo, fecha, fecha_lote, fecha_vencimiento 
            FROM materia_prima WHERE id = ?";
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
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Materia prima guardada correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ❌ Hubo un error al guardar la materia prima.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
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
                        value="<?= htmlspecialchars($datos['contenido_neto']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca"
                        value="<?= htmlspecialchars($datos['marca']) ?>" required>
                </div>
                <!-- Campos agregados -->
                <div class="col-sm-6">
                    <label for="stok_minimo" class="form-label">Stock Mínimo</label>
                    <input type="number" class="form-control" id="stok_minimo" name="stok_minimo"
                        value="<?= htmlspecialchars($datos['stok_minimo']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="stok_maximo" class="form-label">Stock Máximo</label>
                    <input type="number" class="form-control" id="stok_maximo" name="stok_maximo"
                        value="<?= htmlspecialchars($datos['stok_maximo']) ?>" required>
                </div>
                <!-- NUEVOS CAMPOS DE FECHAS -->
                <div class="col-sm-6">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha"
                        value="<?= htmlspecialchars($datos['fecha']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="fecha_lote" class="form-label">Fecha de Lote</label>
                    <input type="date" class="form-control" id="fecha_lote" name="fecha_lote"
                        value="<?= htmlspecialchars($datos['fecha_lote']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento"
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