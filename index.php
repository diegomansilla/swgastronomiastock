
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
                        <a class="nav-link" href="gestion_alertas/alertas.php">Alertas</a>
                    </li>
                </ul>

                <!-- Se puede agregar mas botones como "Login" o "Cerrar sesión" -->
            </div>
        </div>
    </nav>

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
                        <a href="ingredientes.php" class="btn btn-primary">Ver Ingredientes</a>
                    </div>
                </div>
            </div>

            <!-- Card Agregar Ingrediente -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Nuevo Ingrediente</h5>
                        <p class="card-text">Agregar un nuevo ingrediente al sistema.</p>
                        <a href="nuevo_ingrediente.php" class="btn btn-success">Agregar Ingrediente</a>
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


    <!-- FOOTER -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        &copy;
        <?php echo date('Y'); ?> Diseño y desarrollo por 3er año de la Tecnicatura Superior en Análisis y Desarrollo de Software en conjunto con la Tecnicatura Superior en Gastronomía.
    </footer>

    <script src='js/bootstrap.bundle.min.js'></script>
</body>

</html>