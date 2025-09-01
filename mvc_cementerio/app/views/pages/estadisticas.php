<?php
$error = '';
$buscar = isset($_GET['buscar']);
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
            <button class="nav-link" id="traslados-tab" data-bs-toggle="tab" data-bs-target="#traslados" type="button" role="tab">Traslados de difuntos</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="vendidas-tab" data-bs-toggle="tab" data-bs-target="#vendidas" type="button" role="tab">Parcelas Vendidas</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab">Resumen</button>
        </li>
    </ul>

<div class="tab-content mt-4">
    <!-- Pestaña para Padron de Difuntos -->
    <div class="tab-pane fade show active" id="tablas" role="tabpanel">
         <!-- Seleccionar tipo de filtro de búsqueda -->
        <div class="mb-4">
            <label for="tipo_filtro" class="form-label">Seleccionar filtro de búsqueda:</label>
            <select id="tipo_filtro" class="form-select w-auto" onchange="mostrarFiltro()">
                <option value="">Seleccionar...</option>
                <option value="lista_completa">Padrón general de Difuntos</option>
                <option value="filtro_titular">Por Orden Alfabético</option>
                <option value="filtro_fecha">Por Fecha de Defunción</option>
            </select>
    </div>

        <!-- Filtro por Fecha -->
        <div id="filtro_fecha" class="filtro-box mb-4">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="fecha_inicio" class="form-label">Desde</label>
                    <input type="date" class="form-control" name="fecha_inicio" value="<?= htmlspecialchars($_GET['fecha_inicio'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="fecha_fin" class="form-label">Hasta</label>
                    <input type="date" class="form-control" name="fecha_fin" value="<?= htmlspecialchars($_GET['fecha_fin'] ?? '') ?>">
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                </div>
            </form>
        </div>

        <!-- Filtro por Apellido de Difunto -->
        <div id="filtro_titular" class="filtro-box mb-4" style="display: none;">
            <form method="GET" class="row g-3">
                <div class="col-md-2">
                    <label for="letra_apellido" class="form-label">Apellido(A-Z)</label>
                    <select name="letra_apellido" class="form-select">
                        <option value="">Seleccionar...</option>
                        <?php foreach (range('A', 'Z') as $letra): ?>
                            <option value="<?= $letra ?>" <?= (isset($datos['letra_apellido']) && $datos['letra_apellido'] === $letra) ? 'selected' : '' ?>><?= $letra ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                </div>
            </form>
        </div>

        <!-- Mostrar datos -->
        <?php if (!empty($datos['datos_difuntos'])): ?>
            <table class="table table-bordered table-striped">
                <thead class="th a">
                    <tr>
                        <th><?= generarOrdenLink('fecha_defuncion', 'Fecha de Defunción', $datos) ?></th>
                        <th><?= generarOrdenLink('nombre', 'Nombre', $datos) ?></th>
                        <th><?= generarOrdenLink('apellido', 'Apellido', $datos) ?></th>
                        <th><?= generarOrdenLink('edad', 'Edad', $datos) ?></th>
                        <th><?= generarOrdenLink('dni', 'Dni', $datos) ?></th>
                        <th><?= generarOrdenLink('deudo', 'Deudo', $datos) ?></th> 
                        <th><?= generarOrdenLink('estado_civil', 'Estado Civil', $datos) ?></th>
                        <th><?= generarOrdenLink('nacionalidad', 'Nacionalidad', $datos) ?></th>  
                        <th><?= generarOrdenLink('sexo', 'Sexo', $datos) ?></th>
                        <th><?= generarOrdenLink('domicilio', 'Domicilio', $datos) ?></th>
                        <th><?= generarOrdenLink('localidad', 'Localidad', $datos) ?></th>
                        <th><?= generarOrdenLink('codigo_postal', 'Código Postal', $datos) ?></th>              
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['datos_difuntos'] as $dif): ?>
                        <tr>
                            <td><?= htmlspecialchars($dif['fecha_defuncion']) ?></td>
                            <td><?= htmlspecialchars($dif['nombre']) ?></td>
                            <td><?= htmlspecialchars($dif['apellido']) ?></td>
                            <td><?= htmlspecialchars($dif['edad']) ?></td>
                            <td><?= htmlspecialchars($dif['dni']) ?></td>
                            <td><?= htmlspecialchars($dif['deudo']) ?></td>
                            <td><?= htmlspecialchars($dif['estado_civil']) ?></td>
                            <td><?= htmlspecialchars($dif['nacionalidad'] ?? '') ?></td>
                            <td><?= htmlspecialchars($dif['sexo'] ?? '') ?></td>
                            <td><?= htmlspecialchars($dif['domicilio']) ?></td>
                            <td><?= htmlspecialchars($dif['localidad']) ?></td>
                            <td><?= htmlspecialchars($dif['codigo_postal']) ?></td>            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-info-circle text-info fa-3x mb-3"></i>
                <p class="text-muted">No hay datos registrados</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pestania para deudores morosos-->
    <div class="tab-pane fade" id="morosos" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary active" id="ver-activos">
                    <i class="fas fa-toggle-on me-1"></i> Pagos vencidos
                </button>
                <button type="button" class="btn btn-outline-secondary" id="ver-inactivos">
                    <i class="fas fa-toggle-off me-1"></i> Pagos saldados
                </button>
            </div>
        </div>

        <?php if (!empty($datos['deudores_morosos'])): ?>
            <table class="table table-bordered table-striped" id="tabla-morosos">
                <thead class="th a">
                    <tr>
                        <th><?= generarOrdenLink('Parcela', 'Parcela', $datos) ?></th>
                        <th><?= generarOrdenLink('DNI', 'DNI', $datos) ?></th>
                        <th><?= generarOrdenLink('Nombre', 'Nombre', $datos) ?></th>
                        <th><?= generarOrdenLink('Apellido', 'Apellido', $datos) ?></th>
                        <th><?= generarOrdenLink('Fecha de vencimiento', 'Fecha vencimiento', $datos) ?></th>
                        <th><?= generarOrdenLink('Monto', 'Total', $datos) ?></th>
                        <th><?= generarOrdenLink('Dias de Mora', 'Dia/s de mora', $datos) ?></th>
                        <th><?= generarOrdenLink('Acciones', 'Acciones', $datos)?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['deudores_morosos'] as $index => $moroso):
                        $estado = 'activo'; 
                    ?>
                        <tr class="fila-moroso" data-estado="<?= $estado ?>">
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
     
    <!-- Pestania de traslados -->
     <div class="tab-pane fade" id="traslados" role="tabpanel">
        <?php if (!empty($datos['difuntos_trasladados'])): ?>
            <table class="table table-bordered table-striped">
                <thead class="th a">
                    <tr>
                    <th><?= generarOrdenLink('nombre', 'Nombre', $datos) ?></th>
                    <th><?= generarOrdenLink('apellido', 'Apellido', $datos) ?></th>
                    <th><?= generarOrdenLink('dni', 'DNI', $datos) ?></th>
                    <th><?= generarOrdenLink('fecha_fallecimiento', 'Fecha de defunción', $datos) ?></th>
                    <th><?= generarOrdenLink('fecha_retiro', 'Fecha de traslado', $datos) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['difuntos_trasladados'] as $difunto_trasladado): ?>
                        <tr>
                        <td><?= htmlspecialchars($difunto_trasladado['nombre']) ?></td>
                            <td><?= htmlspecialchars($difunto_trasladado['apellido']) ?></td>
                            <td><?= htmlspecialchars($difunto_trasladado['dni']) ?></td>
                            <td><?= htmlspecialchars($difunto_trasladado['fecha_fallecimiento']) ?></td>
                            <td><?= htmlspecialchars($difunto_trasladado['fecha_retiro']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                <p class="text-muted">No hay difuntos trasladados</p>
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

    $flecha = '';
    if ($columna_actual === $columna) {
        $flecha = strtoupper($direccion_actual) === 'ASC' ? ' ▲' : ' ▼';
    }

    return "<a href=\"$link\" style=\"color: white; text-decoration: none;\">$etiqueta$flecha</a>";
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

    // Función para mostrar el filtro seleccionado
    function mostrarFiltro() {
        const seleccion = document.getElementById('tipo_filtro').value;
        const filtros = document.querySelectorAll('.filtro-box');

        filtros.forEach(f => f.style.display = 'none');

        // Si se elige "lista_completa", recarga sin parámetros
    if (seleccion === 'lista_completa') {
        window.location.href = window.location.pathname + '?tab=vendidas';
        return;
    }

        if (!seleccion) return; // No mostrar nada si no hay selección

        const filtroSeleccionado = document.getElementById(seleccion);
        if (filtroSeleccionado) {
            filtroSeleccionado.style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        mostrarFiltro();
    });

</script>