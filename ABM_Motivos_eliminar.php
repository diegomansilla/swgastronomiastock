<?php
include 'conectar.php';

// Verifica si se ha pasado un ID válido por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id']; // Forzamos a entero

    $sql = "DELETE FROM ABM_Motivos WHERE id = ?";
    $stmt = $connection->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: ABM_Motivos_lista.php?ok=eliminado");
        } else {
            header("Location: ABM_Motivos_lista.php?error=delete");
        }

        $stmt->close();
    } else {
        header("Location: ABM_Motivos_lista.php?error=stmt");
    }

    $connection->close();
    exit;
} else {
    header("Location: ABM_Motivos_lista.php?error=param");
    exit;
}
?>
