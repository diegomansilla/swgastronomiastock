<?php
include 'conectar.php';

$term = isset($_GET['term']) ? trim($_GET['term'])  : '';// Termino de búsqueda

$sql = "SELECT id, codigo_barra, descripcion, cantidad, fecha_lote, fecha_ingreso, fecha_vencimiento, 
contenido_neto, marca FROM materia_prima WHERE descripcion LiKE ? or marca LIKE ? or codigo_barra LIKE ?";

$like = "%" . $term . "%";// Prepara el término de búsqueda con comodines
// Prepara la consulta para evitar inyecciones SQL
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si se encontraron resultados
while ($fila = $result->fetch_assoc()){
    echo "<tr>
    <td>{$fila['codigo_barra']}</td>
            <td>{$fila['descripcion']}</td>
            <td>{$fila['cantidad']}</td>
            <td>{$fila['fecha_lote']}</td>
            <td>{$fila['fecha_ingreso']}</td>
            <td>{$fila['fecha_vencimiento']}</td>
            <td>{$fila['contenido_neto']}</td>
            <td>{$fila['marca']}</td>
            <td>
            <a href='materia_prima.php?id={$fila['id']}' class='btn btn-sm btn-warning'>Editar</a>
            <button class='btn btn-sm btn-danger' disabled>Eliminar</button>
            </td>
    </tr>";
}
$stmt->close();
$conexion->close();

?>
