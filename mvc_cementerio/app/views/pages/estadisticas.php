<?php

// Variables para filtrar y error
$error = '';
$filtrar = isset($_GET['filtrar']); // Detecta si se envió el formulario con el botón "Filtrar"

?>
    <link rel="stylesheet" href="<?= URL . '/public/css/estadisticas.css' ?>">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="tablas-tab" data-bs-toggle="tab" data-bs-target="#tablas" type="button" role="tab">Padron difuntos</button>
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
        <thead class="table-dark text-black">
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

<script>
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