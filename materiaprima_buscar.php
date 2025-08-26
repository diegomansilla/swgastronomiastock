<?php
include 'conectar.php';

// se aplica trim() para eliminar espacios al inicio o final del término de búsqueda
$term = isset($_GET['term']) ? trim($_GET['term'])  : ''; 

 // ahora el LEFT JOIN toma solo el último ingreso de cada materia prima
$sql = "SELECT mp.id, mp.codigo_barra, mp.descripcion, mp.contenido_neto, mp.marca, 
       mp.stock_minimo, mp.stock_maximo,
       imp.fecha, imp.cantidad, imp.fecha_lote, imp.fecha_vencimiento
       FROM materia_prima mp
       LEFT JOIN ingreso_materia_prima imp 
                  ON imp.id = (
                SELECT i.id 
                FROM ingreso_materia_prima i 
                WHERE i.id_materia_prima = mp.id 
                ORDER BY i.fecha DESC 
                LIMIT 1 
            )
        WHERE mp.descripcion LIKE ? OR mp.marca LIKE ? OR mp.codigo_barra LIKE ?
        ORDER BY mp.descripcion";
        //mantiene la búsqueda dinámica por descripción, marca o código

$like = "%" . $term . "%"; // Prepara el término de búsqueda con comodines
// Prepara la consulta para evitar inyecciones SQL
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

// Si hay resultados, los muestra
if ($result->num_rows > 0) {
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
                    <a href='materia_prima.php?id={$fila['id']}' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i>Editar</a>
                    <a href='materiaprima_baja.php?id={$fila['id']}' class='btn btn-sm btn-danger' onclick='return confirm('¿Seguro que desea dar de baja esta materia prima?');'><i class='bi bi-trash'></i>Baja</a>
                </td>
              </tr>";
    }
    // si no hay coincidencias, muestra mensaje "No hay resultados"
} else {
    echo "<tr><td colspan='9' class='text-center'>No hay resultados.</td></tr>";
}

$stmt->close();
$conexion->close();
?>