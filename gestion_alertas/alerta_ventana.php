<?php if (!empty($alertas) && is_array($alertas)) {     
    // Obtener la alerta más crítica (primera de la lista ordenada)
    $alerta_critica = $alertas[0];
    
    // Calcular prioridad para el color del toast
    $today = new DateTime();
    $toastClass = 'bg-warning text-dark';
    $prioText = 'BAJA';
    
    if (!empty($alerta_critica['fecha_venc_raw']) && $alerta_critica['fecha_venc_raw'] !== '0000-00-00') {
        $venc = DateTime::createFromFormat('Y-m-d', $alerta_critica['fecha_venc_raw']);
        if ($venc && $venc instanceof DateTime) {
            $diff = (int)$today->diff($venc)->format('%r%a');
            
            if ($alerta_critica['stock_actual'] <= 0 || $diff < 0) {
                $toastClass = 'bg-danger text-white';
                $prioText = 'CRÍTICA';
            } elseif ($diff <= 3 || $alerta_critica['stock_actual'] <= intval($alerta_critica['stock_minimo'] / 2)) {
                $toastClass = 'bg-warning text-dark';
                $prioText = 'MEDIA';
            }
        } else {
            $toastClass = 'bg-danger text-white';
            $prioText = 'CRÍTICA';
        }
    } else {
        if ($alerta_critica['stock_actual'] <= 0) {
            $toastClass = 'bg-danger text-white';
            $prioText = 'CRÍTICA';
        } elseif ($alerta_critica['stock_actual'] <= intval($alerta_critica['stock_minimo'] / 2)) {
            $toastClass = 'bg-warning text-dark';
            $prioText = 'MEDIA';
        }
    }
    ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="liveToast" class="toast show <?= $toastClass ?>" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-dark text-white">
                <strong class="me-auto">⚠ Alerta de Stock - <?= $prioText ?></strong>
                <small><?= count($alertas) ?> alerta<?= count($alertas) > 1 ? 's' : '' ?></small>
                <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <strong><?= htmlspecialchars($alerta_critica['nombre']) ?></strong><br>
                Stock actual: <span class="<?= $alerta_critica['stock_actual'] <= 0 ? 'text-danger fw-bold' : '' ?>">
                    <?= htmlspecialchars($alerta_critica['stock_actual']) ?>
                </span><br>
                Stock mínimo: <?= htmlspecialchars($alerta_critica['stock_minimo']) ?><br>
                Vence: <?= htmlspecialchars($alerta_critica['fecha_vencimiento'] ?: 'Sin fecha') ?>
                
                <?php if (count($alertas) > 1) : ?>
                <hr class="my-2">
                <small class="text-muted">
                    <a href="alertas.php" class="text-decoration-none">
                        Ver todas las alertas (<?= count($alertas) ?>)
                    </a>
                </small>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
        // Mostrar toast automáticamente
        document.addEventListener('DOMContentLoaded', function() {
            const toastEl = document.getElementById('liveToast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 10000, // 10 segundos
                    autohide: true
                });
                toast.show();
            }
        });
    </script>
<?php } ?>