<?php
include("conectar2.php");

// Aquí deberías obtener el ID de usuario real de sesión o fijo para pruebas
$id_usuario = 1; // Cambia esto según tu lógica

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $conexion->real_escape_string($_POST["nombre"]);
    $precio = floatval($_POST["precio"]);
    $disponible = intval($_POST["disponible"]);
    $materia_prima = $_POST["materia_prima"] ?? [];

    // Insertar plato
    $conexion->query("INSERT INTO platos (nombre, precio, disponible, id_usuario) 
                      VALUES ('$nombre', $precio, $disponible, '$id_usuario')");

    if ($conexion->error) {
        die("Error al insertar plato: " . $conexion->error);
    }

    $plato_id = $conexion->insert_id;

    // Insertar materias primas seleccionadas
    foreach ($materia_prima as $id_mp => $data) {
        if (isset($data["check"]) && $data["check"] == "1" && !empty($data["cantidad"])) {
            $cantidad = $conexion->real_escape_string($data["cantidad"]);
            $conexion->query("INSERT INTO plato_materia_prima (plato_id, materia_prima_id, cantidad) 
                              VALUES ($plato_id, $id_mp, '$cantidad')");
        }
    }

    header("Location: platos.php?mensaje=Plato agregado");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Plato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg- text-black text-center">
            <h2 class="mb-0">🧑‍🍳 Agregar Nuevo Plato</h2>
        </div>
        <div class="card-body">
            <form action="agregar.php" method="POST">
                <div class="mb-3">
                    <label for="nombrePlato" class="form-label">Nombre del plato</label>
                    <input type="text" name="nombre" id="nombrePlato" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="precioPlato" class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" id="precioPlato" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="disponibilidadPlato" class="form-label">Disponibilidad</label>
                    <select name="disponible" id="disponibilidadPlato" class="form-select">
                        <option value="1">✅ Disponible</option>
                        <option value="0">❌ No disponible</option>
                    </select>
                </div>

                <hr>
                <h4 class="mt-4 mb-3">📝 Seleccione los ingredientes</h4>

                <?php
                $res = $conexion->query("SELECT id, descripcion, contenido_neto, 'unidad_medida', marca FROM materia_prima");
                while ($mp = $res->fetch_assoc()) {
                    $texto = $mp['descripcion'] . " (" . $mp['contenido_neto'] . " " . $mp['unidad_medida'] . ") - " . $mp['marca'];
                    echo '<div class="form-check mb-2">';
                    echo '<input class="form-check-input" type="checkbox" name="materia_prima['.$mp['id'].'][check]" value="1" id="mp'.$mp['id'].'">';
                    echo '<label class="form-check-label" for="mp'.$mp['id'].'">'.$texto.'</label>';
                    echo '<input type="text" name="materia_prima['.$mp['id'].'][cantidad]" placeholder="Cantidad" class="form-control mt-1" style="max-width:200px;">';
                    echo '</div>';
                }
                ?>

                <button type="submit" class="btn btn-success mt-3">Guardar plato</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
