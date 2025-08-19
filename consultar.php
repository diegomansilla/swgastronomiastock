<?php
include("conectar.php");

$id_plato = intval($_GET['id']); // ID recibido por GET

// Obtener datos del plato
$sqlPlato = "SELECT nombre, precio, disponible FROM platos WHERE id = $id_plato";
$resPlato = $conexion->query($sqlPlato);
$plato = $resPlato->fetch_assoc();

// Obtener ingredientes del plato
$sqlIngredientes = "
     SELECT mp.descripcion, mp.contenido_neto, mp.marca, ip.cantidad
    FROM ingredientes_plato ip
    INNER JOIN materia_prima mp ON ip.id_materia_prima = mp.id
    WHERE ip.id_plato = $id_plato
";
$ingredientes = $conexion->query($sqlIngredientes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Plato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container mt-5">
    <div class="card shadow-sm">
     <div class="card-header bg-success text-white text-center ">
            <h2 class="mb-0">🧑‍🍳 Detalle del Plato</h2>
        </div>

    <?php if ($plato): ?>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($plato['nombre']) ?></p>
        <p><strong>Precio:</strong> $<?= number_format($plato['precio'], 2) ?></p>
        <p><strong>Disponible:</strong> <?= $plato['disponible'] ? 'Sí' : 'No' ?></p>
    <?php else: ?>
        <div class="alert alert-danger">No se encontró el plato.</div>
    <?php endif; ?>

    <h4>Ingredientes:</h4>
   <ul class="list-group">
    <?php while ($row = $ingredientes->fetch_assoc()): ?>
        <li class="list-group-item">
            <?= htmlspecialchars($row['descripcion']) ?>
            (<?= $row['contenido_neto'] ?>) -
            <?= htmlspecialchars($row['marca']) ?> |
            Cantidad: <?= htmlspecialchars($row['cantidad']) ?>
        </li>
    <?php endwhile; ?>
</ul>
<div class="row">
    <div class="col-sm-4">
        <a href="platos.php" class="btn btn-success mt-3">Volver</a>
</div>
</body>
</html>
