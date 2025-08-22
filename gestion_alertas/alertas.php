<?php
include('consulta_alertas.php'); 
include("C:\xampp\htdocs\gastronomia\swgastronomiastock\includes\header.php
")?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
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
                            <th>Prioridad</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="alert-body">
                        <?php if (!empty($alertas) && is_array($alertas)) : ?>
                        <?php foreach ($alertas as $alerta) : ?>
                        <?php
            $today = new DateTime();
            $prio = '';
            $prioText = '';
            $prioClass = '';

            // Verificar si hay fecha de vencimiento válida
            if (!empty($alerta['fecha_venc_raw']) && $alerta['fecha_venc_raw'] !== '0000-00-00') {
                $venc = DateTime::createFromFormat('Y-m-d', $alerta['fecha_venc_raw']);
                if ($venc && $venc instanceof DateTime) {
                    $diff = (int)$today->diff($venc)->format('%r%a');
                    
                    // Prioridad ALTA: Sin stock o vencido
                    if ($alerta['stock_actual'] <= 0 || $diff < 0) {
                        $prio = 'prio-high';
                        $prioText = 'CRÍTICA';
                        $prioClass = 'bg-danger text-white';
                    }
                    // Prioridad MEDIA: Vence en 3 días o menos, o stock bajo crítico
                    elseif ($diff <= 3 || $alerta['stock_actual'] <= intval($alerta['stock_minimo'] / 2)) {
                        $prio = 'prio-medium';
                        $prioText = 'MEDIA';
                        $prioClass = 'bg-warning text-dark';
                    }
                    // Prioridad BAJA: Otros casos
                    else {
                        $prio = 'prio-low';
                        $prioText = 'BAJA';
                        $prioClass = 'bg-success text-white';
                    }
                } else {
                    $prio = 'prio-high';
                    $prioText = 'CRÍTICA';
                    $prioClass = 'bg-danger text-white';
                }
            } else {
                // Sin fecha de vencimiento, solo evaluar stock
                if ($alerta['stock_actual'] <= 0) {
                    $prio = 'prio-high';
                    $prioText = 'CRÍTICA';
                    $prioClass = 'bg-danger text-white';
                } elseif ($alerta['stock_actual'] <= intval($alerta['stock_minimo'] / 2)) {
                    $prio = 'prio-medium';
                    $prioText = 'MEDIA';
                    $prioClass = 'bg-warning text-dark';
                } else {
                    $prio = 'prio-low';
                    $prioText = 'BAJA';
                    $prioClass = 'bg-success text-white';
                }
            }
            ?>
                        <tr class="alert-row <?php echo htmlspecialchars($prio); ?>"
                            data-id="<?php echo htmlspecialchars($alerta['id']); ?>">
                            <td><?php echo htmlspecialchars($alerta['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($alerta['stock_actual']); ?></td>
                            <td><?php echo htmlspecialchars($alerta['stock_minimo']); ?></td>
                            <td><?php echo htmlspecialchars($alerta['fecha_vencimiento'] ?: 'Sin fecha'); ?></td>
                            <td>
                                <span class="badge badge-priority <?php echo $prioClass; ?>">
                                    <?php echo $prioText; ?>
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <input type="checkbox" class="complete-checkbox" 
                                       title="Marcar como atendida">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center text-success">
                                <i class="fas fa-check-circle"></i> No hay alertas en este momento.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <?php if (!empty($alertas)) : ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <small class="text-muted">
                            <strong>Leyenda de colores:</strong>
                            <span class="badge bg-danger text-white ms-2">CRÍTICA</span> Sin stock o vencido
                            <span class="badge bg-warning text-dark ms-2">MEDIA</span> Vence ≤ 3 días o stock crítico
                            <span class="badge bg-success text-white ms-2">BAJA</span> Stock bajo o vence pronto
                        </small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        &copy; <?= date('Y') ?> Diseño y desarrollo por 3er año...
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar toast con alerta más urgente (primera de la lista)
        const firstRow = document.querySelector('#alert-body tr.alert-row');
        if (firstRow && !firstRow.querySelector('td[colspan]')) {
            const cells = firstRow.children;
            const nombre = cells[0].innerText;
            const stock = cells[1].innerText;
            const minimo = cells[2].innerText;
            const vence = cells[3].innerText;
            const prioridad = cells[4].innerText;
            
            // Crear toast
            const toastHtml = `
        <div id="liveToast" class="toast show bg-warning text-dark position-fixed bottom-0 end-0 p-3" 
             role="alert" style="z-index: 9999">
          <div class="toast-header bg-dark text-white">
            <strong class="me-auto">⚠ Alerta de Stock - ${prioridad}</strong>
            <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast"></button>
          </div>
          <div class="toast-body">
            <strong>${nombre}</strong><br>
            Stock actual: ${stock}<br>
            Stock mínimo: ${minimo}<br>
            Vence: ${vence}
          </div>
        </div>`;
            document.body.insertAdjacentHTML('beforeend', toastHtml);
            const toastEl = document.getElementById('liveToast');
            new bootstrap.Toast(toastEl, {delay: 10000}).show();
        }

        // Gestión de checkboxes con localStorage
        const rows = document.querySelectorAll('tr.alert-row');
        rows.forEach(row => {
            const id = row.getAttribute('data-id');
            if (id) {
                const cb = row.querySelector('.complete-checkbox');
                const done = localStorage.getItem(`alert_done_${id}`) === '1';
                
                if (done) {
                    cb.checked = true;
                    row.classList.add('alert-completed');
                }
                
                cb.addEventListener('change', () => {
                    if (cb.checked) {
                        localStorage.setItem(`alert_done_${id}`, '1');
                        row.classList.add('alert-completed');
                    } else {
                        localStorage.removeItem(`alert_done_${id}`);
                        row.classList.remove('alert-completed');
                    }
                });
            }
        });
    });
    </script>
    <?php
    include 'C:\xampp\htdocs\gastronomia\swgastronomiastock\includes\footer.php';
    ?>
</body>

</html>