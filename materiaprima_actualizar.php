<?php
include 'conectar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $codigo_barra = $_POST['cod_barra'];
    $descripcion = $_POST['descript'];
    $contenido_neto = $_POST['cont_neto'];
    $unidad_medida = $_POST['unidad_medida'];
    $marca = $_POST['marca'];
    $stock_minimo = $_POST['stock_minimo'];
    $stock_maximo = $_POST['stock_maximo'];

    if (
        !empty($id) &&
        !empty($codigo_barra) &&
        !empty($descripcion) &&
        isset($contenido_neto) &&
        !empty($unidad_medida) &&
        !empty($marca) &&
        isset($stock_minimo) &&
        isset($stock_maximo)
    ) {
        $sql = "UPDATE materia_prima SET 
                    codigo_barra = ?, 
                    descripcion = ?, 
                    contenido_neto = ?,
                    id_unidad_medida = ?,
                    marca = ?,
                    stock_minimo = ?,
                    stock_maximo = ?
                WHERE id = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssdisdii", $codigo_barra, $descripcion, $contenido_neto, $unidad_medida, $marca, 
        $stock_minimo, $stock_maximo, $id);

        if ($stmt->execute()) {
            $stmt->close();
            $conexion->close();
            header("Location: materiaprima_lista.php?ok=editado");
            exit;
        } else {
            $stmt->close();
            $conexion->close();
            header("Location: materia_prima.php?error=update&id=$id");
            exit;
        }
    } else {
        header("Location: materiaprima_lista.php?error=campos_vacios&id=$id");
        exit;
    }
}
?>
