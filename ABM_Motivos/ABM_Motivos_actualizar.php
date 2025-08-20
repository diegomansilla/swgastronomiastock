<?php
include 'conectar.php';//Incluye en archivo de conexion a base de datos

//Consulta si lo que se trae es por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $codigo_barra = $_POST['codigo_barra'];
    
    // Verifica si todos los campos requeridos están llenos
    // Si alguno de los campos está vacío, redirige a la lista de materias primas
    if (
        !empty($id) &&
        !empty($nombre) &&
        !empty($descripcion) &&
        !empty($codigo_barra) &&
        
    ){
        $sql = "UPDATE ABM_Motivos SET 
                nombre = ?, 
                descripcion = ?, 
                codigo_barra = ?, 
                WHERE id = ?";

                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ssdsssssi", $nombre, $descripcion, $codigo_barra, $id);// Vincula los parámetros a la consulta preparada

               if ($stmt->execute()) {
                $stmt->close();// Cierra la sentencia preparada
                // Cierra la conexión a la base de datos
                // Redirige a la lista de materias primas con un mensaje de éxito
                $connection->close();
                header("Location: ABM_Motivos_lista.php?ok=editado");
                exit;
            } else {
                $stmt->close();
                $connection->close();// Cierra la conexión a la base de datos
                header("Location: ABM_Motivos.php?error=update&id=$id");// Redirige a la página de edición con un mensaje de error
                exit;
            }
        
        } else {
            header("Location: ABM_Motivos_lista.php?error=campos_vacios&id=$id");// Redirige a la lista de materias primas con un mensaje de error
            exit;
        }
    }
?>
