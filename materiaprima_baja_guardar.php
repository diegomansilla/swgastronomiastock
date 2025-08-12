<?php
include 'conectar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_materia = isset($_POST['id_materia_prima']) ? intval($_POST['id_materia_prima']) : 0;
    $id_motivo = isset($_POST['id_motivo']) ? intval($_POST['id_motivo']) : 0;
    $cantidad_baja = isset($_POST['cantidad_baja']) ? floatval($_POST['cantidad_baja']) : 0;

    // Validaciones básicas
    if ($id_materia <= 0 || $id_motivo <= 0 || $cantidad_baja <= 0) {
        header("Location: materiaprima_lista.php?error=datos_invalidos");
        exit;
    }

    // Obtener cantidad actual
    $sql = "SELECT SUM(cantidad) AS Total FROM ingreso_materia_prima WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id_materia);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $materia = $resultado->fetch_assoc();
    $stmt->close();

    if (!$materia) {
        header("Location: materiaprima_lista.php?error=materia_no_encontrada");
        exit;
    }

    $cantidad_actual = floatval($materia['cantidad']);

    if ($cantidad_baja > $cantidad_actual) {
        header("Location: materiaprima_lista.php?error=stock_insuficiente");
        exit;
    }

    // Registrar baja en salida_materia_prima
    $sql_salida = "INSERT INTO salida_materia_prima (id_materia_prima, cantidad, id_motivo, fecha_salida) VALUES (?, ?, ?, NOW())";
    $stmt_salida = $conexion->prepare($sql_salida);
    $stmt_salida->bind_param("idi", $id_materia, $cantidad_baja, $id_motivo);
    $stmt_salida->execute();
    $stmt_salida->close();

    // Actualizar cantidad en materia_prima
    $nueva_cantidad = $cantidad_actual - $cantidad_baja;
    $sql_update = "UPDATE materia_prima SET cantidad = ? WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("di", $nueva_cantidad, $id_materia);
    $stmt_update->execute();
    $stmt_update->close();

    $conexion->close();

    header("Location: materiaprima_lista.php?ok=baja_registrada");
    exit;
} else {
    header("Location: materiaprima_lista.php?error=metodo_invalido");
    exit;
}
