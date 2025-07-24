<?php
include 'conectar.php';// Incluye el archivo de conexión a la base de datos

// Consulta para obtener todas las materias primas
// Se seleccionan los campos necesarios de la tabla materia_prima
$sql = "select id, codigo_barra, descripcion, cantidad, fecha_lote, fecha_ingreso, fecha_vencimiento, 
contenido_neto, marca from materia_prima";

// Ejecuta la consulta y almacena el resultado
$resultado = $connection->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Sistema Gestión de Stock Software - Gastronomía</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
</head>

<body class="d-flex flex-column min-vh-100">

<?php if (isset($_GET['ok']) && $_GET['ok'] == 'editado'): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    ✅ Materia prima actualizada correctamente.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php if (isset($_GET['ok']) && $_GET['ok'] == 'eliminado'): ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    ⚠️ Materia prima eliminada correctamente.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Gastronomía</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">
                    <!-- Sección: Stock -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="stockDropdown" role="button" data-bs-toggle="dropdown">
                            Stock
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="ingredientes.php">Ver Ingredientes</a></li>
                            <li><a class="dropdown-item" href="nuevo_ingrediente.php">Agregar Ingrediente</a></li>
                        </ul>
                    </li>

                    <!-- Sección: Platos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="platosDropdown" role="button" data-bs-toggle="dropdown">
                            Platos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="platos.php">Ver Platos</a></li>
                            <li><a class="dropdown-item" href="nuevo_plato.php">Crear Plato</a></li>
                        </ul>
                    </li>

                    <!-- Sección: Alertas -->
                    <li class="nav-item">
                        <a class="nav-link" href="alertas.php">Alertas</a>
                    </li>
                </ul>

                <!-- Se puede agregar mas botones como "Login" o "Cerrar sesión" -->
            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container mt-5 mb-5 flex-grow-1">
        <h2 class="mb-4 text-center">Listado de Materias Primas</h2>
        <div class="mb-3">
            <input type="text" class="form-control" id="buscador" placeholder="Buscar por descripción, marca o código" onkeyup="buscarMateriaPrima()">
        </div>
        <div>
            <a href="materia_prima.php" class="btn btn-success">Nueva Materia Prima</a>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Código de Barra</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Fecha Lote</th>
                        <th>Fecha Ingreso</th>
                        <th>Fecha Vencimiento</th>
                        <th>Contenido Neto</th>
                        <th>Marca</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado->num_rows > 0): ?>
                        <?php while ($fila = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= $fila['codigo_barra'] ?></td>
                                <td><?= $fila['descripcion'] ?></td>
                                <td><?= $fila['cantidad'] ?></td>
                                <td><?= $fila['fecha_lote'] ?></td>
                                <td><?= $fila['fecha_ingreso'] ?></td>
                                <td><?= $fila['fecha_vencimiento'] ?></td>
                                <td><?= $fila['contenido_neto'] ?></td>
                                <td><?= $fila['marca'] ?></td>
                                <td>
                                    <a href="materia_prima.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="materiaprima_eliminar.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este registro?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No hay materias primas registradas.</td>
                        </tr>
                    <?php endif; ?>
                    <?php $connection->close(); ?>
                </tbody>
            </table>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        &copy;
        <?php echo date('Y'); ?> Diseño y desarrollo por 3er año de la Tecnicatura Superior en Análisis y Desarrollo de Software en conjunto con la Tecnicatura Superior en Gastronomía.
    </footer>

    <script src='js/bootstrap.bundle.min.js'></script>
    <script src="js/particulares.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        buscarMateriaPrima('buscador', 'table tbody');
        });
    </script>
</body>

</html>
