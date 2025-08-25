<?php
include 'conectar.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "UPDATE materia_prima SET estado = 1 WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conexion->close();
        header("Location: materiaprima_lista.php?ok=baja");
        exit;
    } else {
        $stmt->close();
        $conexion->close();
        header("Location: materiaprima_lista.php?error=baja");
        exit;
    }
} else {
    header("Location: materiaprima_lista.php?error=id");
    exit;
}
?>
