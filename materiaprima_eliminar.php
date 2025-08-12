<?php
include 'conectar2.php';

// Verifica si se ha pasado un ID válido por GET
// Si el ID es numérico, se procede a eliminar el registro
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];// ID del registro a eliminar

    $sql = "DELETE FROM materia_prima WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);// Vincula el parámetro ID a la consulta preparada

    // Ejecuta la consulta preparada
    // Si la ejecución es exitosa, cierra la sentencia y la conexión, y redirige a la lista de materias primas con un mensaje de éxito
    // Si falla, cierra la sentencia y la conexión, y redirige a la lista de materias primas con un mensaje de error
    // Si no se pasa un ID válido, redirige a la lista de materias primas
    if ($stmt->execute()) {
        $stmt->close();
        $conexion->close();
        header("Location: materiaprima_lista.php?ok=eliminado");
        exit;
    }else{
        $stmt->close();
        $conexion->close();
        header("Location: materiaprima_lista.php?error=delete");
        exit;
    }
}else {
    header("Location: materiaprima_lista.php?error=param");
}
?>
