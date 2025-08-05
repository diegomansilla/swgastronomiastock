<?php
include('consulta_alertas.php');

include('../gestion_alertas/alerta_ventana.php');


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset='utf-8'>
    <title>Gestión de Alertas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Gastronomía</a>
        </div>
    </nav>
    <main class="container my-4">
        <div class="card border-warning">
            <div class="card-body">
                <h5 class="card-title">Alertas de Stock</h5>
                <p class="card-text">Productos con bajo stock o próximos a vencer:</p>

                <table class="table table-sm table-bordered">
                    <thead>
                        <tr class="table-warning">
                            <th>Ingrediente</th>
                            <th>Stock actual</th>
                            <th>Stock mínimo</th>
                            <th>Próximo vencimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($alertas)) : ?>
                            <?php foreach ($alertas as $alerta) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($alerta['nombre']) ?></td>
                                    <td><?= htmlspecialchars($alerta['stock_actual']) ?></td>
                                    <td><?= htmlspecialchars($alerta['stock_minimo']) ?></td>
                                    <td><?= htmlspecialchars($alerta['fecha_vencimiento']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay alertas en este momento.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        &copy; <?= date('Y') ?> Diseño y desarrollo por 3er año de la Tecnicatura Superior en Análisis y Desarrollo de Software en conjunto con la Tecnicatura Superior en Gastronomía.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
