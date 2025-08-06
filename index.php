<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Sistema Gestión de Stock Software - Gastronomía</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="d-flex flex-column min-vh-100">

    <?php
    include 'includes/header.php';
    ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container mt-5 mb-5 flex-grow-1">
        <h2 class="mb-4 text-center">Panel Principal</h2>
        <div class="row row-cols-1 row-cols-md-2 g-4">

            <!-- Card Ingredientes -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Ingredientes</h5>
                        <p class="card-text">Ver el listado de ingredientes cargados en stock.</p>
                        <a href="materiaprima_lista.php" class="btn btn-primary">Ver Ingredientes</a>
                    </div>
                </div>
            </div>

            <!-- Card Agregar Ingrediente -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Nuevo Ingrediente</h5>
                        <p class="card-text">Agregar un nuevo ingrediente al sistema.</p>
                        <a href="materia_prima.php" class="btn btn-success">Agregar Ingrediente</a>
                    </div>
                </div>
            </div>

            <!-- Card Platos -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Platos</h5>
                        <p class="card-text">Ver y administrar platos definidos.</p>
                        <a href="platos.php" class="btn btn-primary">Ver Platos</a>
                    </div>
                </div>
            </div>

            <!-- Card Alertas -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Alertas</h5>
                        <p class="card-text">Visualizar productos próximos a vencerse o con stock bajo.</p>
                        <a href="gestion_alertas/alertas.php" class="btn btn-warning">Ver Alertas</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>

    <script src='js/bootstrap.bundle.min.js'></script>
</body>

</html>