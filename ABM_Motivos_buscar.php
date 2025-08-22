<?php
include '../conectar.php';

$term = isset($_GET['term']) ? trim($_GET['term']) : ''; // Término de búsqueda

if (!empty($term)) {
    $sql = "SELECT id, descripcion FROM ABM_Motivos WHERE descripcion LIKE ?";
    $like = "%" . $term . "%";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se encontraron resultados
    while ($fila = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['descripcion']}</td>
                <td>
                    <a href='ABM_Motivos.php?id={$fila['id']}' class='btn btn-sm btn-warning'>Editar</a>
                    <button class='btn btn-sm btn-danger' disabled>Eliminar</button>
                </td>
        </tr>";
    }

    $stmt->close();
}
$connection->close();
?>
