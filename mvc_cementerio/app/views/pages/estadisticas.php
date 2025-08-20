<?php

// Variables para filtrar y error
$buscar_por = '';
$dni = '';
if (isset($_GET['buscar_por'])) {
    $buscar_por = $_GET['buscar_por'];
}
if (isset($_GET['dni'])) {
    $dni = trim($_GET['dni']);
}
$error = '';
$filtrar = isset($_GET['filtrar']); // Detecta si se envió el formulario con el botón "Filtrar"

// Validación: solo si se presionó "Filtrar" y buscar_por es chofer
if ($filtrar && $buscar_por === 'chofer' && $dni === '') {
    $error = "Debe ingresar un DNI para buscar por chofer.";
    // No mostrar resultados si hay error
    $datos['movimientos'] = [];
}
?>

<style>
    th a {
        color: white;
        text-decoration: none;
        cursor: pointer;
    }
    th a:hover {
        color: #ddd;
    }
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
        list-style: none;
        padding: 0;
    }
    .pagination li {
        margin: 0 0.25rem;
    }
    .pagination a {
        color: white;
        text-decoration: none;
        padding: 0.4rem 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: background 0.3s ease;
    }
    .pagination a:hover {
        background: #444;
    }
    .pagination a.pagina-link {
    color: #333;
    background: white;
    text-decoration: none;
    padding: 0.4rem 0.75rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: background 0.3s ease;
    }

    .pagination a.pagina-link:hover {
        background: #e9ecef;
    }

    .pagination a.pagina-activa {
        background-color: #030c14ff;
        color: white;
        border-color: #061422ff;
        font-weight: bold;
    }

</style>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="tablas-tab" data-bs-toggle="tab" data-bs-target="#tablas" type="button" role="tab">Datos</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab">Resumen</button>
        </li>
    </ul>

    <div class="tab-content mt-4">
        <div class="tab-pane fade show active" id="tablas" role="tabpanel">
            <!-- Formulario de filtros -->
        <form method="GET" class="row g-3 mb-4 justify-content-center">
            <div class="col-auto">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php if(!empty($datos['fecha_inicio'])){echo htmlspecialchars($datos['fecha_inicio']);} ?>">
            </div>

            <div class="col-auto">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php if(!empty($datos['fecha_fin'])){echo htmlspecialchars($datos['fecha_fin']);} ?>">
            </div>

            <!-- <div class="col-auto">
                <label for="buscar_por" class="form-label">Buscar por</label>
                <select name="buscar_por" id="buscar_por" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Seleccionar --</option>
                    <option value="chofer" <?php if(!empty($datos['buscar_por']) && $datos['buscar_por'] === 'chofer'){echo 'selected';}?>>Chofer</option>
                    <option value="tipo" <?php if(!empty($datos['buscar_por']) && $datos['buscar_por'] === 'tipo'){echo 'selected';}?>>Tipo</option>
                </select>
            </div> -->

            <!-- Campo DNI solo visible si buscar_por es chofer -->
            <!-- <div class="col-auto" id="campo_dni" style="display: <?php if(!empty($datos['buscar_por']) && $datos['buscar_por'] === 'chofer'){echo 'block';} else {echo 'none';} ?>;">
                <label for="dni" class="form-label">DNI del Chofer</label>
                <input type="text" class="form-control" name="dni" id="dni" value="<?php if(!empty($datos['dni'])){echo htmlspecialchars($datos['dni']);} ?>">
            </div> -->

            <!-- Campo Tipo visible si buscar_por es chofer o tipo -->
            <!-- <div class="col-auto" id="campo_tipo" style="display: <?php if(!empty($datos['buscar_por']) && in_array($datos['buscar_por'], ['chofer','tipo'])) {echo 'block';} else {echo 'none';} ?>;">
                <label for="tipo" class="form-label">Tipo de Servicio</label>
                <select name="tipo" id="tipo" class="form-select">
                    <option value="">-- Todos --</option>
                    <option value="linea" <?php if (!empty($datos['tipo']) && $datos['tipo']  === 'linea'){echo 'selected';}?>>Línea</option>
                    <option value="charter" <?php if (!empty($datos['tipo']) && $datos['tipo']  === 'charter'){echo 'selected';}?>>Charter</option>
                    <option value="otros" <?php if (!empty($datos['tipo']) && $datos['tipo']  === 'otros'){echo 'selected';}?>>Otros</option>
                </select>
            </div> -->

            <div class="col-auto align-self-end">
                <!-- Boton con name="filtrar" para detectar submit intencional -->
                <button type="submit" name="filtrar" class="btn btn-primary">Filtrar</button>
            </div>
        </form>

    <!-- Mostrar error solo si hay -->
    <?php if ($error): ?>
        <div class="alert alert-warning text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th><?= generarOrdenLink('empresa', 'Empresa', $datos) ?></th>
                <th><?= generarOrdenLink('fecha', 'Fecha', $datos) ?></th>
                <th><?= generarOrdenLink('lugar', 'Lugar', $datos) ?></th>
                <th><?= generarOrdenLink('tipo_movimiento', 'Arribo / Salida', $datos) ?></th>
                <th><?= generarOrdenLink('cantidad', 'Cantidad de Pax', $datos) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($datos['movimientos'])): ?>
                <?php foreach ($datos['movimientos'] as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['empresa']) ?></td>
                        <td><?= htmlspecialchars($m['fecha']) ?></td>
                        <td><?= htmlspecialchars($m['lugar']) ?></td>
                        <td><?= htmlspecialchars($m['tipo_movimiento']) ?></td>
                        <td><?= htmlspecialchars($m['cantidad']) ?></td>
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
                <li>
                    <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"
                        class="pagina-link <?php if((!empty($datos['pagina_actual']) && $i == ($datos['pagina_actual'])) || (empty($datos['pagina_actual']) && $i == 1)){echo 'pagina-activa';}?>">
                            <?= $i ?>
                    </a>

                </li>
            <?php endfor; ?>
        </ul>
    <?php endif; ?>
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
    return "<a href=\"$link\">$etiqueta</a>";
}
?>

    <div class="tab-pane fade" id="resumen" role="tabpanel">
        <!-- Fila de métricas principales -->
        <div>
            <form id="form-filtro-resumen" class="row g-2 mb-3 justify-content-left">
                <div class="col-auto">
                    <label for="fecha_inicio_resumen" class="form-label">Fecha Inicio</label>
                    <input type="date"
                        class="form-control"
                        name="fecha_inicio_resumen"
                        id="fecha_inicio_resumen"
                        value="<?php if(!empty($_GET['fecha_inicio_resumen'])){echo htmlspecialchars($_GET['fecha_inicio_resumen']);} ?>">
                </div>

                <div class="col-auto">
                    <label for="fecha_fin_resumen" class="form-label">Fecha Fin</label>
                    <input type="date"
                        class="form-control"
                        name="fecha_fin_resumen"
                        id="fecha_fin_resumen"
                        value="<?php if(!empty($_GET['fecha_fin_resumen'])){echo htmlspecialchars($_GET['fecha_fin_resumen']);} ?>">
                </div>

                <div class="col-auto align-self-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>
        </div>
        <body> <script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-filtro-resumen');
    const contenedor = document.getElementById('contenedor-resumen');

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

    // AJAX filtrado
    if (form && contenedor) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch('resumen_datos.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(html => {
                contenedor.innerHTML = html;
            })
            .catch(err => {
                contenedor.innerHTML = "<p class='text-danger'>Error al cargar datos</p>";
                console.error(err);
            });
        });
    }
});
</script>