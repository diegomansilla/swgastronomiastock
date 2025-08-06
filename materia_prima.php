<?php
include 'conectar.php';

$edicion = false; // Variable para determinar si es una edición o un nuevo registro

// Datos por defecto para el formulario
// Si es una edición, se llenarán con los datos de la base de datos
$datos = [
    'codigo_barra' => '',
    'descripcion' => '',
    'contenido_neto' => '',
    'marca' => ''
];

// Si se está editando, se obtienen los datos de la base de datos
if (isset($_GET['id'])) {
    $edicion = true; // Se está editando un registro
    $id = $_GET['id']; // ID del registro a editar

    $sql = "SELECT id, codigo_barra, descripcion, contenido_neto, marca FROM materia_prima WHERE id = ?";
    $stmt = $connection->prepare($sql); // Preparar la consulta
    $stmt->bind_param("i", $id); // Vincular el parámetro ID
    $stmt->execute(); // Ejecutar la consulta
    $resultado = $stmt->get_result(); // Obtener el resultado

    // Verificar si se encontraron resultados
    // Si hay resultados, se llenan los datos del formulario con los datos de la base de datos
    // Si no hay resultados, redirigir a la lista de materias primas con un error
    if ($resultado->num_rows > 0) {
        $datos = $resultado->fetch_assoc(); // Obtener los datos del registro
    } else {
        header("Location:materiaprima_lista.php?error=notfound"); // Redirigir a la lista de materias primas con un error
        exit;
    }
    $stmt->close();
}
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

    <?php
    include 'includes/header.php';
    ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container mt-5 mb-5 flex-grow-1">

        <!--Alert con registro guardado o con errores-->
        <?php if (isset($_GET['ok'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ Materia prima guardada correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ❌ Hubo un error al guardar la materia prima.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <h2 class="mb-4 text-center">Materia Prima</h2>
        <form action="<?= $edicion ? 'materiaprima_actualizar.php' : 'materiaprima_guardar.php' ?>" method="POST">
            <?php if ($edicion): ?>
                <input type="hidden" name="id" value="<?= $datos['id'] ?>">
            <?php endif; ?>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col-sm-6">
                    <label for="cod_barra" class="form-label">Código de Barra</label>
                    <input type="text" class="form-control" id="cod_barra" name="cod_barra" placeholder="Ingrese el código de barra" value="<?= htmlspecialchars($datos['codigo_barra']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="descript" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="descript" name="descript" placeholder="Ingrese la descripción" value="<?= htmlspecialchars($datos['descripcion']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="cont_neto" class="form-label">Contenido Neto</label>
                    <input type="text" class="form-control" id="cont_neto" name="cont_neto" placeholder="Ingrese el contenido neto" value="<?= htmlspecialchars($datos['contenido_neto']) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca" value="<?= htmlspecialchars($datos['marca']) ?>" required>
                </div>
                <div>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
                <div>
                    <a href="materiaprima_lista.php" class="btn btn-danger" type="submit">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

    <?php
    include 'includes/footer.php';
    ?>

    <script src='js/bootstrap.bundle.min.js'></script>
</body>

</html>