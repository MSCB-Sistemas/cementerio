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
            <select id="tipo_filtro" class="form-select w-auto" onchange="mostrarFiltroDifuntos()">
                <option value="">Seleccionar...</option>
                <option value="lista_completa">Padrón general de Difuntos</option>
                <option value="filtro_titular_difuntos">Por Orden Alfabético</option>
                <option value="filtro_fecha_difuntos">Por Fecha de Defunción</option>
            </select>
    </div>

        <!-- Filtro por Fecha -->
        <div id="filtro_fecha_difuntos" class="filtro-box mb-4" style="display: none;">
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
        <div id="filtro_titular_difuntos" class="filtro-box mb-4" style="display: none;">
            <form method="GET" class="row g-3">
                <div class="col-md-2">                    
                    <label for="letra_apellido_difunto" class="form-label">Apellido (A-Z)</label>
                    <select name="letra_apellido_difunto" class="form-select">
                        <option value="">Seleccionar...</option>
                        <?php foreach (range('A', 'Z') as $letra): ?>
                            <option value="<?= $letra ?>" <?= (isset($datos['letra_apellido_difunto']) && $datos['letra_apellido_difunto'] === $letra) ? 'selected' : '' ?>><?= $letra ?></option>
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


    <!-- Pestaña para deudores morosos-->
    <div class="tab-pane fade" id="morosos" role="tabpanel">
        <?php if (!empty($datos['deudores_morosos'])): ?>
            <table class="table table-bordered table-striped">
                <thead class="th a">
                    <tr>
                    <th><?= generarOrdenLink('Parcela', 'Parcela', $datos) ?></th>
                    <th><?= generarOrdenLink('DNI', 'DNI', $datos) ?></th>
                    <th><?= generarOrdenLink('Nombre', 'Nombre', $datos) ?></th>
                    <th><?= generarOrdenLink('Apellido', 'Apellido', $datos) ?></th>
                    <th><?= generarOrdenLink('Fecha de vencimiento', 'Fecha vencimiento', $datos) ?></th>
                    <th><?= generarOrdenLink('Monto', 'Total', $datos) ?></th>
                    <th><?= generarOrdenLink('Dias de Mora', 'Dia/s de mora', $datos) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['deudores_morosos'] as $moroso): ?>
                        <tr>
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


    <!-- Pestaña de Parcelas Vendidas -->
    <div class="tab-pane fade" id="vendidas" role="tabpanel">
        <!-- Seleccionar tipo de filtro de búsqueda -->
        <div class="mb-4">
            <label for="tipo_filtro" class="form-label">Seleccionar filtro de búsqueda:</label>
            <select id="tipo_filtro_parcelas" class="form-select w-auto" onchange="mostrarFiltroParcelas()">
                <option value="">Seleccionar...</option>
                <option value="lista_completa_parcelas">Listado de Parcelas</option>
                <option value="filtro_fecha_parcelas">Por Fecha de Venta</option>
                <option value="filtro_parcela_parcelas">Por Datos de Parcela</option>
                <option value="filtro_titular_parcelas">Por Titular</option>
            </select>
    </div>

        <!-- Filtro por Fecha -->
        <div id="filtro_fecha_parcelas" class="filtro-box mb-4">
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

        <!-- Filtro por Datos de Parcela -->
        <div id="filtro_parcela_parcelas" class="filtro-box mb-4" style="display: none;">
            <form method="GET" class="row g-3">
                <div class="col-md-2">
                    <label for="ubicacion" class="form-label">Nº de Ubicación</label>
                    <input type="text" class="form-control" name="ubicacion">
                </div>
                <div class="col-md-2">
                    <label for="tipo_parcela" class="form-label">Tipo</label>
                    <select name="tipo_parcela" class="form-select">
                        <option value="">Seleccionar...</option>
                        <option value="N">Nicho</option>
                        <option value="F">Fosa</option>
                        <option value="P">Panteón</option>
                        <option value="O">Osario</option>
                        <option value="E">Especial</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="seccion" class="form-label">Sección</label>
                    <input type="text" class="form-control" name="seccion">
                </div>
                <div class="col-md-2">
                    <label for="fraccion" class="form-label">Fracción</label>
                    <input type="text" class="form-control" name="fraccion">
                </div>
                <div class="col-md-2">
                    <label for="nivel" class="form-label">Nivel</label>
                    <input type="text" class="form-control" name="nivel">
                </div>
                <div class="col-md-2">
                    <label for="orientacion" class="form-label">Orientación</label>
                    <select name="orientacion" class="form-select">
                        <option value="">Seleccionar...</option>
                        <option value="N">Norte</option>
                        <option value="S">Sur</option>
                        <option value="E">Este</option>
                        <option value="O">Oeste</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="hilera" class="form-label">Hilera</label>
                    <input type="text" class="form-control" name="hilera">
                </div>

                <div class="col-md-2 align-self-end">
                    <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                </div>
            </form>
        </div>

        <!-- Filtro por Titular -->
        <div id="filtro_titular_parcelas" class="filtro-box mb-4" style="display: none;">
            <form method="GET" class="row g-3">
                <div class="col-md-2">        
                    <label for="letra_apellido_deudo" class="form-label">Apellido Titular (A-Z)</label>
                    <select name="letra_apellido_deudo" class="form-select">
                        <option value="">Seleccionar...</option>
                        <?php foreach (range('A', 'Z') as $letra): ?>
                            <option value="<?= $letra ?>" <?= (isset($datos['letra_apellido_deudo']) && $datos['letra_apellido_deudo'] === $letra) ? 'selected' : '' ?>><?= $letra ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                </div>
            </form>
        </div>

        <!-- Mostrar datos -->
        <?php if (!empty($datos['parcelas_vendidas'])): ?>
            <table class="table table-bordered table-striped">
                <thead class="th a">
                    <tr>
                        <th><?= generarOrdenLink('id_parcela', 'Parcela', $datos) ?></th>
                        <th><?= generarOrdenLink('nombre', 'Nombre', $datos) ?></th>
                        <th><?= generarOrdenLink('apellido', 'Apellido', $datos) ?></th>
                        <th><?= generarOrdenLink('dni', 'DNI', $datos) ?></th>    
                        <th><?= generarOrdenLink('monto', 'Monto', $datos) ?></th>                             
                        <th><?= generarOrdenLink('fecha_venta', 'Fecha de Venta', $datos) ?></th>    
                        <th><?= generarOrdenLink('fecha_vencimiento', 'Fecha de Vencimiento', $datos) ?></th>                
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['parcelas_vendidas'] as $venta): ?>
                        <tr>
                            <td><?= htmlspecialchars($venta['id_parcela']) ?></td>
                            <td><?= htmlspecialchars($venta['nombre']) ?></td>
                            <td><?= htmlspecialchars($venta['apellido']) ?></td>
                            <td><?= htmlspecialchars($venta['dni']) ?></td> 
                            <td>$<?= number_format($venta['monto'], 2) ?></td>          
                            <td><?= date('d/m/Y', strtotime($venta['fecha_venta'])) ?></td>  
                            <td><?= date('d/m/Y', strtotime($venta['fecha_vencimiento'])) ?></td>            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-info-circle text-info fa-3x mb-3"></i>
                <p class="text-muted">No hay parcelas vendidas registradas</p>
            </div>
        <?php endif; ?>
    </div>


    <!-- Pestaña de resumen -->
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

    // Función para mostrar el filtro seleccionado
    function mostrarFiltroDifuntos() {
        const seleccion = document.getElementById('tipo_filtro').value;
        const filtros = document.querySelectorAll('.filtro-box');

        filtros.forEach(f => f.style.display = 'none');

        // Si se elige "lista_completa", recarga sin parámetros
    if (seleccion === 'lista_completa') {
        window.location.href = window.location.pathname + '?tab=tablas';
        return;
    }


        if (!seleccion) return; // No mostrar nada si no hay selección

        const filtroSeleccionado = document.getElementById(seleccion);
        if (filtroSeleccionado) {
            filtroSeleccionado.style.display = 'block';
        }
    }

    function mostrarFiltroParcelas() {
    const seleccion = document.getElementById('tipo_filtro_parcelas').value;
    const filtros = document.querySelectorAll('#vendidas .filtro-box');

    filtros.forEach(f => f.style.display = 'none');

    if (seleccion === 'lista_completa_parcelas') {
        window.location.href = window.location.pathname + '?tipo_filtro_parcelas=lista_completa_parcelas&tab=vendidas';
        return;
    }

    if (!seleccion) return;

    const filtroSeleccionado = document.getElementById(seleccion);
    if (filtroSeleccionado) {
        filtroSeleccionado.style.display = 'block';
    }
}

    document.addEventListener('DOMContentLoaded', function () {
    mostrarFiltroDifuntos(); 
    mostrarFiltroParcelas(); 
});

</script>