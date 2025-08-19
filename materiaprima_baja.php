<?php
include 'conectar.php.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica que se haya recibido un ID válido
if ($id <= 0) {
    header("Location: materiaprima_lista.php?error=param");
    exit;
}

// Obtener datos de la materia prima
$sql = "SELECT * FROM materia_prima WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$materia = $resultado->fetch_assoc();
$stmt->close();

// Verifica si existe la materia prima
if (!$materia) {
    header("Location: materiaprima_lista.php?error=notfound");
    exit;
}

// Obtener los motivos
$motivos_sql = "SELECT id, descripcion FROM motivos";
$motivos_result = $conexion->query($motivos_sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dar de Baja Materia Prima</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<?php
include 'includes/header.php';
?>

<body class="d-flex flex-column min-vh-100">

    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Dar de Baja Materia Prima</h2>

        <form action="materiaprima_baja_guardar.php" method="POST">
            <input type="hidden" name="id_materia_prima" value="<?= $materia['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($materia['descripcion']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Marca</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($materia['marca']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Cantidad a dar de baja</label>
                <input type="number" class="form-control" name="cantidad_baja" required min="1" step="0.1">
            </div>

            <div class="mb-3">
                <label class="form-label">Motivo de baja</label>
                <select name="id_motivo" class="form-select" required>
                    <option value="">Seleccione un motivo</option>
                    <?php while ($motivo = $motivos_result->fetch_assoc()): ?>
                        <option value="<?= $motivo['id'] ?>"><?= htmlspecialchars($motivo['descripcion']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-danger">Confirmar baja</button>
            <a href="materiaprima_lista.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <?php
    include 'includes/footer.php';
    ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>