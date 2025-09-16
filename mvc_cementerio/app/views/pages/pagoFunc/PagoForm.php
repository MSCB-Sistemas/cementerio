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
        <div class="col-12 mt-2">
            <div id="infoParcela"></div>
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
        <div class="col-12 mt-2">
            <div id="infoDifunto"></div>
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
    </div>

    <!-- Observaciones -->
    <div class="row mb-4">
        <div class="col-12">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Agregue observaciones relevantes sobre el pago"></textarea>
        </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button type="submit" class="btn btn-success"> <i class="bi bi-save"></i> Guardar</button>
        <a href="<?= URL ?>" class="btn btn-secondary"> <i class="bi bi-x-circle"></i> Cancelar</a>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $("#parcela").change(function () {
        let id = $(this).val();
        if (id) {
            $.getJSON("<?= URL ?>/ajax/info_parcela.php", {id: id}, function (data) {
                if (data.error) {
                    $("#infoParcela").html("<div class='alert alert-danger'>" + data.error + "</div>");
                } else {
                    $("#infoParcela").html(
                        "<div class='card card-body mt-2'>" +
                        "<strong>Tipo:</strong> " + data.id_tipo_parcela + "<br>" +
                        "<strong>Ubicación:</strong> " + data.numero_ubicacion + " / " + data.hilera + " / " + data.seccion + " / " + data.fraccion + " / " + data.nivel +
                        "</div>"
                    );
                }
            });
        } else {
            $("#infoParcela").html("");
        }
    });

    $("#difunto").change(function () {
        let id = $(this).val();
        if (id) {
            $.getJSON("<?= URL ?>/ajax/info_difunto.php", {id: id}, function (data) {
                if (data.error) {
                    $("#infoDifunto").html("<div class='alert alert-danger'>" + data.error + "</div>");
                } else {
                    $("#infoDifunto").html(
                        "<div class='card card-body mt-2'>" +
                        "<strong>DNI:</strong> " + data.dni + "<br>" +
                        "<strong>Nombre:</strong> " + data.nombre + " " + data.apellido + "<br>" +
                        "<strong>Fecha fallecimiento:</strong> " + data.fecha_fallecimiento +
                        "</div>"
                    );
                }
            });
        } else {
            $("#infoDifunto").html("");
        }
    });
});
</script>
