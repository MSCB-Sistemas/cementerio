<?php

$error = '';
$filtrar = isset($_GET['filtrar']);

?>
    <link rel="stylesheet" href="<?= URL . '/public/css/estadisticas.css' ?>">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="tablas-tab" data-bs-toggle="tab" data-bs-target="#tablas" type="button" role="tab">Padron difuntos</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="morosos-tab" data-bs-toggle="tab" data-bs-target="#morosos" type="button" role="tab">Deudores Morosos
                <?php if (!empty($datos['total_morosos']) && $datos['total_morosos'] > 0): ?>
                    <span class="badge bg-danger ms-1"><?= $datos['total_morosos'] ?></span>
                <?php endif?>
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab">Resumen</button>
        </li>
    </ul>

<div class="tab-content mt-4">
    <!-- Pestania Padron difuntos -->
    <div class="tab-pane fade show active" id="tablas" role="tabpanel">
        <form method="GET" class="row g-3 mb-4">
            <div class="col-auto">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo !empty($datos['fecha_inicio']) ? htmlspecialchars($datos['fecha_inicio']) : '' ?>">
            </div>

            <div class="col-auto">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo !empty($datos['fecha_fin']) ? htmlspecialchars($datos['fecha_fin']) : '' ?>">
            </div>

            <div class="col-auto align-self-end">
                <button type="submit" name="filtrar" class="btn btn-primary">Filtrar</button>
            </div>
        </form>

        <!-- Mostrar error solo si hay -->
        <?php if ($error): ?>
            <div class="alert alert-warning text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="th a">
                <tr>
                    <th><?= generarOrdenLink('fecha_fallecimiento', 'Fecha Fallecimiento', $datos) ?></th>
                    <th><?= generarOrdenLink('nombre', 'Nombre', $datos) ?></th>
                    <th><?= generarOrdenLink('apellido', 'Apellido', $datos) ?></th>
                    <th><?= generarOrdenLink('dni', 'DNI', $datos) ?></th>
                    <th><?= generarOrdenLink('descripcion', 'Sexo', $datos) ?></th>
                    <th><?= generarOrdenLink('domicilio', 'Domicilio', $datos) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($datos['movimientos'])): ?>
                    <?php foreach ($datos['movimientos'] as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['fecha_fallecimiento']) ?></td>
                            <td><?= htmlspecialchars($m['nombre']) ?></td>
                            <td><?= htmlspecialchars($m['apellido']) ?></td>
                            <td><?= htmlspecialchars($m['dni']) ?></td>
                            <td><?= htmlspecialchars($m['descripcion']) ?></td>
                            <td><?= htmlspecialchars($m['domicilio']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No se encontraron resultados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if (!empty($datos['total_paginas']) && ($datos['total_paginas']) > 1): ?>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $datos['total_paginas']; $i++): ?>
                    <li class="page-item <?= ($i == $datos['pagina_actual']) ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Pestania para deudores morosos-->
    <div class="tab-pane fade" id="morosos" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary active" id="ver-activos">
                    <i class="fas fa-toggle-on me-1"></i> Ver activos
                </button>
                <button type="button" class="btn btn-outline-secondary" id="ver_inactivos">
                    <i class="fas fa-toggle-off me-1"></i> Ver inactivos
                </button>
            </div>
        </div>

        <?php if (!empty($datos['deudores_morosos'])): ?>
            <table class="table table-bordered table-striped" id="tabla-morosos">
                <thead class="th a">
                    <tr>
                        <th>Estado</th>
                        <th><?= generarOrdenLink('Parcela', 'Parcela', $datos) ?></th>
                        <th><?= generarOrdenLink('DNI', 'DNI', $datos) ?></th>
                        <th><?= generarOrdenLink('Nombre', 'Nombre', $datos) ?></th>
                        <th><?= generarOrdenLink('Apellido', 'Apellido', $datos) ?></th>
                        <th><?= generarOrdenLink('Fecha de vencimiento', 'Fecha vencimiento', $datos) ?></th>
                        <th><?= generarOrdenLink('Monto', 'Total', $datos) ?></th>
                        <th><?= generarOrdenLink('Dias de Mora', 'Dia/s de mora', $datos) ?></th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['deudores_morosos'] as $index => $moroso):
                        $estado = 'activo'; 
                    ?>
                        <tr class="fila-moroso" data-estado="<?= $estado ?>">
                            <td class="text-center">
                                <span class="badge estado-badge bg-success">Activo</span>
                            </td>
                            <td><?= htmlspecialchars($moroso['id_parcela']) ?></td>
                            <td><?= htmlspecialchars($moroso['dni']) ?></td>
                            <td><?= htmlspecialchars($moroso['nombre']) ?></td>
                            <td><?= htmlspecialchars($moroso['apellido']) ?></td>
                            <td class="text-danger fw-bold">
                                <?= date('d/m/Y', strtotime($moroso['fecha_vencimiento'])) ?>
                            </td>
                            <td>$<?= number_format($moroso['total'], 2) ?></td>
                            <td><?php $dias_mora = floor((time() - strtotime($moroso['fecha_vencimiento'])) / (60 * 60 * 24));
                                echo '<span class="badge bg-danger">' . $dias_mora . ' dia/s</span>'; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-toggle-estado <?= $estado == 'activo' ? 'btn-warning' : 'btn-success' ?>" 
                                        data-id="<?= $index ?>"
                                        data-estado-actual="<?= $estado ?>">
                                    <i class="fas fa-toggle-off"></i> Desactivar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                <p class="text-muted">No hay deudores morosos</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pestania de resumen -->
    <div class="tab-pane fade" id="resumen" role="tabpanel">
        <div class="alert alert-info">
            Contenido de resumen --pendiente--
        </div>
    </div>
</div>

<?php
// Función para generar links con ordenamiento (orden asc/desc)
function generarOrdenLink($columna, $etiqueta, $datos) {
    $direccion_actual = 'asc';
    if (!empty($datos['sort_dir'])) {
        $direccion_actual = strtolower($datos['sort_dir']);
    }

    $columna_actual = '';
    if (!empty($datos['sort_col'])) {
        $columna_actual = strtolower($datos['sort_col']);
    }

    // Cambia la dirección si la columna es la misma, sino por defecto asc
    $direccion_siguiente = 'asc';
    if ($columna_actual === $columna && $direccion_actual === 'asc') {
        $direccion_siguiente = 'desc';
    }

    $query_params = $_GET;
    $query_params['sort_col'] = $columna;
    $query_params['sort_dir'] = $direccion_siguiente;

    $link = '?' . http_build_query($query_params);

    return "<a href=\"$link\" style=\"color: white; text-decoration: none;\">$etiqueta</a>";
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Restaurar el tab activo guardado
    const lastTab = localStorage.getItem('activeTab');
    if (lastTab) {
        const tabElement = document.querySelector(`[data-bs-target="${lastTab}"]`);
        if (tabElement) {
            new bootstrap.Tab(tabElement).show();
        }
    }

    // Escuchar cambio de pestaña y guardarlo
    const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');
    tabLinks.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            const activeTab = e.target.getAttribute('data-bs-target');
            localStorage.setItem('activeTab', activeTab);
        });
    });
});

const botonesEstado = document.querySelectorAll('.btn-toggle-estado');
botonesEstado.forEach(boton => {
    boton.addEventListener('click', function() {
        const idDeuda = this.getAttribute('data-id');
        const estadoActual = this.getAttribute('data-estado-actual');
        const nuevoEstado = estadoActual === 'activo' ? 'inactivo' : 'activo';

        // Aca va un ajax.
        console.log('Cambiando estado de deuda ${idDeuda} de ${estadoActual} a ${nuevoEstado}');

        setTimeout(() => {
            this.setAttribute('data-estado-actual', nuevoEstado);

            const fila = this.closest('.fila-moroso');

            if (nuevoEstado === 'activo') {
                this.classList.remove('btn-success');
                this.classList.add('btn-warning');
                this.innerHTML = '<i class="fas fa-toggle-off"></i> Desactivar';

                const badge = fila.querySelector('.estado-badge');
                badge.classList.remove('bg-secondary');
                badge.classList.add('bg-success');
                badge.textContent = 'Activo';

                fila.setAttribute('data-estado', 'activo');

                if (document.getElementById('ver-activos').classList.contains('active')) {
                    fila.style.display = '';
                }

            } else {
                this.classList.remove('btn-warning');
                this.classList.add('btn-success');
                this.innerHTML = '<i class="fas fa-toggle-off"></i> Activar';

                const badge = fila.querySelector('.estado-badge');
                badge.classList.remove('bg-success');
                badge.classList.add('bg-secondary');
                badge.textContent = 'Inactivo';

                fila.setAttribute('data-estado', 'inactivo');

                if (document.getElementById('ver-activos').classList.contains('active')) {
                    fila.style.display = 'none';
                }
            }

            alert("Deuda ${nuevoEstado === 'activo' ? 'activada' : 'desactivada'} correctamente");
        }, 300);
    });
});

document.getElementById('ver-activos').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('ver-inactivos').classList.remove('active');

    document.querySelectorAll('.fila-moroso').forEach(fila => {
        if (fila.getAttribute('data-estado') === 'activo') {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
});

document.getElementById('ver-inactivos').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('ver-activos').classList.remove('active');
    
    document.querySelectorAll('.fila-moroso').forEach(fila => {
        if (fila.getAttribute('data-estado') === 'inactivo') {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
});
</script>