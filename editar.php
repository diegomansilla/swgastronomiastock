<?php
include("conectar.php");

$id = intval($_GET['id']);

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $conexion->real_escape_string($_POST["nombre"]);
    $precio = floatval($_POST["precio"]);
    $disponible = intval($_POST["disponible"]);
    $materia_prima = $_POST["materia_prima"] ?? [];

    // Actualizar plato
    $conexion->query("UPDATE platos SET nombre='$nombre', precio=$precio, disponible=$disponible WHERE id=$id");

    // Eliminar ingredientes previos
    $conexion->query("DELETE FROM ingredientes_plato WHERE id_plato=$id");

    // Insertar nuevos ingredientes
    foreach ($materia_prima as $id_mp => $data) {
        if (isset($data["check"]) && $data["check"] == "1" && !empty($data["cantidad"])) {
            $cantidad = $conexion->real_escape_string($data["cantidad"]);
            $conexion->query("INSERT INTO ingredientes_plato (id_plato, id_materia_prima, cantidad) VALUES ($id, $id_mp, '$cantidad')");
        }
    }

    header("Location: platos.php?mensaje=Plato actualizado");
    exit();
}

// Cargar datos actuales
$plato = $conexion->query("SELECT * FROM platos WHERE id=$id")->fetch_assoc();

// Cargar ingredientes actuales
$ingredientesActuales = [];
$resIng = $conexion->query("SELECT * FROM ingredientes_plato WHERE id_plato=$id");
while ($row = $resIng->fetch_assoc()) {
    $ingredientesActuales[$row['id_materia_prima']] = $row['cantidad'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Plato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container mt-5">
    <div class="card shadow-sm">
     <div class="card-header bg-success text-white text-center ">
            <h2 class="mb-0">🧑‍🍳 Editar Plato</h2>
        </div>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($plato['nombre']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($plato['precio']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Disponibilidad</label>
            <select name="disponible" class="form-select">
                <option value="1" <?= $plato['disponible'] ? 'selected' : '' ?>>Disponible</option>
                <option value="0" <?= !$plato['disponible'] ? 'selected' : '' ?>>No disponible</option>
            </select>
        </div>

        <h4>Ingredientes:</h4>
        <?php
        $res = $conexion->query("SELECT id, descripcion, contenido_neto, marca FROM materia_prima");
        while ($mp = $res->fetch_assoc()) {
            $checked = isset($ingredientesActuales[$mp['id']]) ? 'checked' : '';
            $cantidad = $ingredientesActuales[$mp['id']] ?? '';
            echo '<div class="form-check mb-2">';
            echo '<input class="form-check-input" type="checkbox" name="materia_prima['.$mp['id'].'][check]" value="1" id="mp'.$mp['id'].'" '.$checked.'>';
            echo '<label class="form-check-label" for="mp'.$mp['id'].'">'.$mp['descripcion'].' ('.$mp['contenido_neto'].') - '.$mp['marca'].'</label>';
            echo '<input type="text" name="materia_prima['.$mp['id'].'][cantidad]" value="'.$cantidad.'" placeholder="Cantidad" class="form-control mt-1" style="max-width:200px;">';
            echo '</div>';
        }
        ?>

        <button type="submit" class="btn btn-success mt-3">Guardar cambios</button>
        <a href="platos.php" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</body>
</html>
