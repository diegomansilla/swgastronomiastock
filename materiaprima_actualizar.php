<?php
include 'conectar.php';//Incluye en archivo de conexion a base de datos

//Consulta si lo que se trae es por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $codigo_barra = $_POST['cod_barra'];
    $descripcion = $_POST['descript'];
    $cantidad = $_POST['cant'];
    $fecha_lote = $_POST['fcha_lote'];
    $fecha_ingreso = $_POST['fcha_ing'];
    $fecha_vencimiento = $_POST['fcha_vto'];
    $contenido_neto = $_POST['cont_neto'];
    $marca = $_POST['marca'];

    // Verifica si todos los campos requeridos están llenos
    // Si alguno de los campos está vacío, redirige a la lista de materias primas
    if (
        !empty($id) &&
        !empty($codigo_barra) &&
        !empty($descripcion) &&
        !empty($cantidad) &&
        !empty($fecha_lote) &&
        !empty($fecha_ingreso) &&
        !empty($fecha_vencimiento) &&
        !empty($contenido_neto) &&
        !empty($marca)
    ){
        $sql = "UPDATE materia_prima SET 
                codigo_barra = ?, 
                descripcion = ?, 
                cantidad = ?, 
                fecha_lote = ?, 
                fecha_ingreso = ?, 
                fecha_vencimiento = ?, 
                contenido_neto = ?, 
                marca = ? 
                WHERE id = ?";

                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ssdsssssi", $codigo_barra, $descripcion, $cantidad, $fecha_lote, 
                $fecha_ingreso, $fecha_vencimiento, $contenido_neto, $marca, $id);// Vincula los parámetros a la consulta preparada

               if ($stmt->execute()) {
                $stmt->close();// Cierra la sentencia preparada
                // Cierra la conexión a la base de datos
                // Redirige a la lista de materias primas con un mensaje de éxito
                $connection->close();
                header("Location: materiaprima_lista.php?ok=editado");
                exit;
            } else {
                $stmt->close();
                $connection->close();// Cierra la conexión a la base de datos
                header("Location: materia_prima.php?error=update&id=$id");// Redirige a la página de edición con un mensaje de error
                exit;
            }
        
        } else {
            header("Location: materiaprima_lista.php?error=campos_vacios&id=$id");// Redirige a la lista de materias primas con un mensaje de error
            exit;
        }
    }
?>