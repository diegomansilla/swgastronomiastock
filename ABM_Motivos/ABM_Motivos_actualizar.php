<?php
include 'conectar.php'; // Incluye archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;

    if (!empty($id) && !empty($descripcion)) {
        $sql = "UPDATE ABM_Motivos SET descripcion = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $descripcion, $id); // Vincula parámetros

            if ($stmt->execute()) {
                $stmt->close();
                $connection->close();
                header("Location: ABM_Motivos_lista.php?ok=editado");
                exit;
            } else {
                $stmt->close();
                $connection->close();
                header("Location: ABM_Motivos.php?error=update&id=$id");
                exit;
            }
        } else {
            header("Location: ABM_Motivos.php?error=stmt&id=$id");
            exit;
        }
    } else {
        header("Location: ABM_Motivos_lista.php?error=campos_vacios&id=$id");
        exit;
    }
}
?>
