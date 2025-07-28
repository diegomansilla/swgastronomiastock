<?php
include 'conectar.php';

$term = isset($_GET['term']) ? trim($_GET['term'])  : '';// Termino de búsqueda

$sql = "SELECT id, nombre, descripcion, codigo_barra, FROM ABM_Motivos WHERE descripcion LiKE ?  or codigo_barra LIKE ?";

$like = "%" . $term . "%";// Prepara el término de búsqueda con comodines
// Prepara la consulta para evitar inyecciones SQL
$stmt = $connection->prepare($sql);
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si se encontraron resultados
while ($fila = $result->fetch_assoc()){
    echo "<tr>
    <td>{$fila['nombre']}</td>
            <td>{$fila['descripcion']}</td>
            <td>{$fila['codigo_barra']}</td>
            <td>
            <a href='ABM_Motivos.php?id={$fila['id']}' class='btn btn-sm btn-warning'>Editar</a>
            <button class='btn btn-sm btn-danger' disabled>Eliminar</button>
            </td>
    </tr>";
}
$stmt->close();
$connection->close();

?>
