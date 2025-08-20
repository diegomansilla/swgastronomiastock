<?php
include 'conectar.php';

$term = isset($_GET['term']) ? trim($_GET['term'])  : ''; // Termino de búsqueda

$sql = "SELECT mp.id, mp.codigo_barra, mp.descripcion, mp.contenido_neto, mp.marca, 
       mp.stock_minimo, mp.stock_maximo,
       imp.fecha, imp.cantidad, imp.fecha_lote, imp.fecha_vencimiento
       FROM materia_prima mp
       LEFT JOIN ingreso_materia_prima imp 
       ON imp.id_materia_prima = mp.id
       WHERE mp.descripcion LIKE ? or mp.marca LIKE ? or mp.codigo_barra LIKE ?
       ORDER BY imp.fecha DESC
       LIMIT 1";

$like = "%" . $term . "%"; // Prepara el término de búsqueda con comodines
// Prepara la consulta para evitar inyecciones SQL
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si se encontraron resultados
while ($fila = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$fila['codigo_barra']}</td>
            <td>{$fila['descripcion']}</td>
            <td>{$fila['cantidad']}</td>
            <td>{$fila['fecha_lote']}</td>
            <td>{$fila['fecha']}</td>
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
