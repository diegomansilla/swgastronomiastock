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

    // Obtener total ingresado
    $sql_ingreso = "SELECT COALESCE(SUM(cantidad),0) AS total_ingresado 
                    FROM ingreso_materia_prima 
                    WHERE id_materia_prima = ?";
    $stmt = $conexion->prepare($sql_ingreso);
    $stmt->bind_param("i", $id_materia);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_ingresado = floatval($result->fetch_assoc()['total_ingresado']);
    $stmt->close();

    // Obtener total dado de baja
    $sql_salida = "SELECT COALESCE(SUM(cantidad),0) AS total_baja 
                   FROM salida_materia_prima 
                   WHERE id_materia_prima = ?";
    $stmt = $conexion->prepare($sql_salida);
    $stmt->bind_param("i", $id_materia);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_baja = floatval($result->fetch_assoc()['total_baja']);
    $stmt->close();

    // Calcular stock actual
    $cantidad_actual = $total_ingresado - $total_baja;

    // Validar stock suficiente
    if ($cantidad_baja > $cantidad_actual) {
        header("Location: materiaprima_lista.php?error=stock_insuficiente");
        exit;
    }

    // Registrar baja
    $sql_salida = "INSERT INTO salida_materia_prima 
                   (id_materia_prima, cantidad, id_motivo, fecha) 
                   VALUES (?, ?, ?, NOW())";
    $stmt = $conexion->prepare($sql_salida);
    $stmt->bind_param("idi", $id_materia, $cantidad_baja, $id_motivo);
    $stmt->execute();
    $stmt->close();

    $conexion->close();

    header("Location: materiaprima_lista.php?ok=baja_registrada");
    exit;
} else {
    header("Location: materiaprima_lista.php?error=metodo_invalido");
    exit;
}
