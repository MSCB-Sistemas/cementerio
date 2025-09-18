<?php if (!empty($datos['errores'])): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($datos['errores'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>
<form action="<?= isset($datos['action']) ? $datos['action'] : '' ?>" method="POST" id="trasladoForm">
    <div class="row mb-3">
        <!-- Parcela -->
        <div class="col-md-6 d-flex align-items-end">
            <div class="flex-grow-1">
                <label for="parcela" class="form-label">Parcela</label>
                <select class="form-select" id="parcela" name="id_parcela" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($datos['parcelas'] as $p): ?>
                        <option value="<?= $p['id_parcela'] ?>">
                            <?= htmlspecialchars($p['id_parcela'] . ' - ' . $p['id_tipo_parcela'] . ' - ' . $p['numero_ubicacion'] . ' - ' . $p['hilera'] . '/' . $p['seccion'] . '/' . $p['fraccion'] . '/' . $p['nivel']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#modalParcela">+</button>
        </div>

        <!-- Deudo -->
        <div class="col-md-6 d-flex align-items-end">
            <div class="flex-grow-1">
                <label for="deudo" class="form-label">Deudo</label>
                <select class="form-select" data-live-search="true" id="deudo" name="id_deudo" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($datos['deudos'] as $d): ?>
                        <option value="<?= $d['id_deudo'] ?>">
                            <?= htmlspecialchars($d['dni'] . ' - ' . $d['nombre'] . ' ' . $d['apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#modalDeudo">+</button>
        </div>
    </div>
    <div class="row mb-3">
        <!-- Difunto -->
        <div class="col-md-6 d-flex align-items-end">
            <div class="flex-grow-1">
                <label for="difunto" class="form-label">Difunto</label>
                <select class="form-select" data-live-search="true" id="difunto" name="id_difunto" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($datos['difuntos'] as $di): ?>
                        <option value="<?= $di['id_difunto'] ?>">
                            <?= htmlspecialchars($di['dni'] . ' - ' . $di['nombre'] . ' ' . $di['apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#modalDifunto">+</button>
        </div>

        <!-- Fecha -->
        <div class="col-md-3">
            <label for="fecha_reserva" class="form-label">Fecha traslado</label>
            <input type="date" class="form-control" id="fecha_traslado" name="fecha_traslado" required 
                   value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="col-md-3">
            <label for="fecha_vencimiento" class="form-label">Fecha Vencimiento</label>
            <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
        </div>

        <div class="col-12 mt-2">
            <div class="accordion" id="accordionParcelaInfo"></div>
        </div>
    </div>

    <!-- Observaciones -->
    <div class="row mb-4">
        <div class="col-12">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Escribir..."></textarea>
        </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button type="submit" class="btn btn-success"> <i class="bi bi-save"></i> Guardar</button>
        <a href="<?= URL ?>" class="btn btn-secondary"> <i class="bi bi-x-circle"></i> Cancelar</a>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.getElementById('parcela').addEventListener('change', function() {
    const idParcela = this.value;
    if (!idParcela) {
        document.getElementById('accordionParcelaInfo').innerHTML = '';
        return;
    }

    fetch(`/cementerio/mvc_cementerio/parcela/obtenerInfoParcela/${idParcela}`)
        .then(res => res.json())
        .then(data => {
            console.log(data);
            const accordion = document.getElementById('accordionParcelaInfo')
            accordion.innerHTML = "";

            let pagosHtml = `<div class="accordion-item">
                <h2 class="accordion-header" id="headingPagos">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePagos" aria-expanded="true" aria-controls="collapsePagos">
                        Pagos asociados
                    </button>
                </h2>
                <div id="collapsePagos" class="accordion-collapse collapse show" aria-labelledby="headingPagos" data-bs-parent="#accordionParcelaInfo">
                    <div class="accordion-body">`;

            if (data.pagos.length > 0) {
                pagosHtml += "<ul class='list-group'>";
                data.pagos.forEach(p => {
                    pagosHtml += `<li class="list-group-item">
                        <strong>Fecha pago:</strong> ${p.fecha_pago} | 
                        <strong>Vencimiento:</strong> ${p.fecha_vencimiento} | 
                        <strong>Total:</strong> $${p.total} | 
                        <strong>Deudo:</strong> ${p.Deudo}
                    </li>`;
                });
                pagosHtml += "</ul>";
            } else {
                pagosHtml += "<p>No hay pagos asociados a esta parcela.</p>";
            }

            pagosHtml += `</div></div></div>`;

            let difuntosHtml = `<div class="accordion-item">
                <h2 class="accordion-header" id="headingDifuntos">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDifuntos" aria-expanded="false" aria-controls="collapseDifuntos">
                        Difuntos asociados
                    </button>
                </h2>
                <div id="collapseDifuntos" class="accordion-collapse collapse" aria-labelledby="headingDifuntos" data-bs-parent="#accordionParcelaInfo">
                    <div class="accordion-body">`;

            if (data.difuntos.length > 0) {
                difuntosHtml += "<ul class='list-group'>";
                data.difuntos.forEach(d => {
                    difuntosHtml += `<li class="list-group-item">
                        <strong>DNI:</strong> ${d.dni} | 
                        <strong>Nombre:</strong> ${d.nombre} ${d.apellido} | 
                        <strong>Fecha ubicación:</strong> ${d.fecha_ubicacion}
                    </li>`;
                });
                difuntosHtml += "</ul>";
            } else {
                difuntosHtml += "<em>No hay difuntos registrados en esta parcela.</em>";
            }

            difuntosHtml += `</div></div></div>`;

            accordion.innerHTML = pagosHtml + difuntosHtml;
        })
        .catch(err => {
            console.error(err);
            document.getElementById('accordionParcelaInfo').innerHTML = "<div class='alert alert-danger'>Error al cargar la información de la parcela.</div>";
        });
        
});
</script>
