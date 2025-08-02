<?php
include('consulta_alertas.php');
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
            <!--hacemos una seccion con card body-->
            <div class="card-body">
                <h5 class="card-title">Alertas de Stock</h5>
                <p class="card-text">Productos con bajo stock o próximos a vencer:</p>
                <!--tabla principal-->

                <table class="table table-sm table-bordered">
                    <thead>
                        <tr class="table-warning">
                            <th>Ingrediente</th>
                            <th>Stock actual</th>
                            <th>Stock mínimo</th>
                            <th>Próximo vencimiento</th>
                        </tr>
                    </thead>
                    <!--inserción de datos en body de la tabla-->

                    <tbody>
                            <?php foreach ($alertas as $alerta): ?>
                                <tr class="<?= $alerta['stock_actual'] <= $alerta['stock_minimo'] ? 'table-danger' : 'table-warning' ?>">
                                    <td><?= htmlspecialchars($alerta['nombre']) ?></td>
                                    <td><?= number_format($alerta['stock_actual'], 2) ?> kg</td>
                                    <td><?= number_format($alerta['stock_minimo'], 2) ?> kg</td>
                                    <td><?= htmlspecialchars($alerta['proximo_vencimiento']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center">No hay alertas actuales.</td></tr>
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
    <?php foreach ($alertas as $alerta): ?>
        <script>
            alert("¡Atención! <?= addslashes($alerta['nombre']) ?> tiene stock bajo o vencimiento próximo.");
        </script>
    <?php endforeach; ?>
</body>
</html>
