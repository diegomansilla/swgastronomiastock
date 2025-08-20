<?php
include 'conectar.php';

// Verifica si lo que se trae es por POST
// Si es así, se procede a guardar los datos en la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_barra = $_POST['cod_barra'];
    $descript = $_POST['descript'];
    $fcha_lote = $_POST['fcha_lote'];
    $fcha_ing = $_POST['fcha_ing'];
    $fcha_vto = $_POST['fcha_vto'];
    $cont_neto = $_POST['cont_neto'];
    $cantidad = $_POST['cantidad'];
    $marca = $_POST['marca'];
    $stock_minimo = 1.0;
    $stock_maximo = 1.0;

    // Verifica si todos los campos requeridos están llenos
    // Si alguno de los campos está vacío, redirige a la página de materia prima
    if (
        !empty($cod_barra) &&
        !empty($descript) &&
        !empty($fcha_lote) &&
        !empty($fcha_ing) &&
        !empty($fcha_vto) &&
        !empty($cont_neto) &&
        !empty($cantidad) &&
        !empty($marca)
    ) {
        // Insertar en Materia Prima
        $sql_mp = "INSERT INTO materia_prima
        (codigo_barra, descripcion, contenido_neto, marca, stock_minimo, stock_maximo)
        VALUES (?,?,?,?,?,?)";
        $stmt1 = $conexion->prepare($sql_mp);
        $stmt1->bind_param("ssssii", $cod_barra, $descript, $cont_neto, $marca, $stock_minimo, $stock_maximo);
        if ($stmt1->execute()) {
            $id_materia_prima = $conexion->insert_id; // Obtener el ID para usar en la otra tabla

            //Insertar en Ingreso Materia Prima
            $sql_ing = "INSERT INTO ingreso_materia_prima
            (id_materia_prima, fecha, cantidad, fecha_lote, fecha_vencimiento)
            VALUES (?,?,?,?,?)";

            $stmt2 = $conexion->prepare($sql_ing);
            $stmt2->bind_param("isdss", $id_materia_prima, $fcha_ing, $cantidad, $fcha_lote, $fcha_vto);

            if ($stmt2->execute()){
                //Si esta todo OK
                $stmt2->close();
                $stmt1->close();
                $conexion->close();
                header("Location: materiaprima_lista.php?ok=1");
                exit;
            }else{
                //Error en ingreso
                $stmt2->close();
                $stmt1->close();
                $conexion->close();
                header("Location: materia_prima.php?error=ingreso");
                exit;
            }
        } else {
            // Error al guardar materia_prima
            $stmt1->close();
            $conexion->close();
            header("Location: materia_prima.php?error=materia");
            exit;
        }

    } else {
        header("Location: materia_prima.php?error=campos_vacios");
        exit;
    }
}

