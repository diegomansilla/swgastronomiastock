<?php
include 'conectar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $descript = $_POST['descript'];

    if (!empty($id) && !empty($descript)) {
        
        // Preparar la consulta SQL con placeholders
        $stmt = $connection->prepare("INSERT INTO ABM_Motivos (id, descripcion) VALUES (?, ?)");
        $stmt->bind_param("is", $id, $descript);

        if ($stmt->execute()) {
            header("Location: ABM_Motivos.php?ok=1");
            exit;
        } else {
            header("Location: ABM_Motivos.php?error=1");
            exit;
        }

        $stmt->close();
        $connection->close();
    } else {
        header("Location: ABM_Motivos.php?error=campos_vacios");
        exit;
    }
}
?>

