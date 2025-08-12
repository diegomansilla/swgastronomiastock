<?php
include("conectar2.php");
$plato
$id_plato = intval($_GET['id']); // ID recibido por GET

$sql = " SELECT mp.descripcion, mp.contenido_neto, mp.marca, ip.cantidad
FROM ingredientes_plato ip
INNER JOIN materia_prima mp 
    ON ip.id_materia_prima = mp.id
WHERE ip.id_plato = $id_plato
";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Plato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Detalle del plato</h1>
    <p><strong>Nombre:</strong> <?= htmlspecialchars($plato['nombre']) ?></p>
    <p><strong>Precio:</strong> $<?= number_format($plato['precio'], 2) ?></p>
    <p><strong>Disponible:</strong> <?= $plato['disponible'] ? 'Sí' : 'No' ?></p>

    <h4>Ingredientes:</h4>
    <ul class="list-group">
        <?php while ($row = $ingredientes->fetch_assoc()): ?>
            <li class="list-group-item">
                <?= htmlspecialchars($row['descripcion']) ?> (<?= $row['contenido_neto'] . " " . $row['unidad_medida'] ?>) - <?= htmlspecialchars($row['marca']) ?> | Cantidad: <?= htmlspecialchars($row['cantidad']) ?>
            </li>
        <?php endwhile; ?>
    </ul>

    <a href="platos.php" class="btn btn-secondary mt-3">Volver</a>
</body>
</html>
