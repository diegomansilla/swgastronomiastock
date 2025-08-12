<?php include("conectar2.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú de Gastronomía</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>
<body class="container mt-4">

    <h1 class="mb-4">Listado de Platos</h1>


    <table id="tablaPlatos" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Disponible</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $resultado = $conexion->query("SELECT * FROM platos");

            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila['id'];
                echo "<tr>";
                echo "<td>" . htmlspecialchars($fila['id']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                echo "<td>$" . number_format($fila['precio'], 2) . "</td>";
                echo "<td>" . ($fila['disponible'] ? "Sí" : "No") . "</td>";
                echo "<td>
                        <a href='consultar.php?id=$id' class='btn btn-info btn-sm me-1'>Ver</a>
                        <a href='editar.php?id=$id' class='btn btn-warning btn-sm me-1'>Editar</a>
                        <a href='eliminar.php?id=$id' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Seguro que deseas eliminar este plato?\")'>Eliminar</a>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="agregar.php" class="btn btn-success mb-3">Agregar nuevo plato</a>
    <script src='script.js'></script>
</body>
</html>
