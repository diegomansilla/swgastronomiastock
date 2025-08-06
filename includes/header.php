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
                        <li><a class="dropdown-item" href="materiaprima_lista.php">Ver Ingredientes</a></li>
                        <li><a class="dropdown-item" href="materia_prima.php">Agregar Ingrediente</a></li>
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