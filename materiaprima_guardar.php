<?php
include 'conectar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_barra     = $_POST['cod_barra'];
    $descript      = $_POST['descript'];
    $cont_neto     = $_POST['cont_neto'];
    $unidad_medida = $_POST['unidad_medida'];
    $marca         = $_POST['marca'];
    $stock_minimo  = $_POST['stock_minimo'];
    $stock_maximo  = $_POST['stock_maximo'];

    // Validación
    if (
        !empty($cod_barra) &&
        !empty($descript) &&
        !empty($cont_neto) &&
        !empty($unidad_medida) &&
        !empty($marca)
    ) {
        $sql_check = "SELECT id FROM materia_prima WHERE codigo_barra = ? AND id <> ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("s", $cod_barra);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            header("Location: materia_prima.php?error=codigorepetido");
            exit;
        }

        $sql_mp = "INSERT INTO materia_prima
                   (codigo_barra, descripcion, contenido_neto, id_unidad_medida, marca, stock_minimo, stock_maximo, estado)
                   VALUES (?,?,?,?,?,?,?,1)";
        $stmt1 = $conexion->prepare($sql_mp);
        $stmt1->bind_param("ssdisii", $cod_barra, $descript, $cont_neto, $unidad_medida, $marca, $stock_minimo, $stock_maximo);

        if ($stmt1->execute()) {
            $stmt1->close();
            $conexion->close();
            header("Location: materiaprima_lista.php?ok=1");
            exit;
        } else {
            if (isset($stmt1)) $stmt1->close();
            $conexion->close();
            header("Location: materia_prima.php?error=ingreso");
            exit;
        }
    } else {
        $conexion->close();
        header("Location: materia_prima.php?error=campos_vacios");
        exit;
    }
} else {
    header("Location: materia_prima.php");
    exit;
}
