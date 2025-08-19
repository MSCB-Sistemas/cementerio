<div class="container mt-5">
    <h2><?= $datos['title']  ?></h2>
    <?php if (!empty($datos['errores'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($datos['errores'] as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= $datos['action'] ?>" method="POST">
        <div class="mb-3">
            <label for="parcela">Parcela</label>
            <div class="input-group">
            <select class="form-select" id="parcela" name="parcela" required>
                <option value="">Seleccione...</option>
                    <?php foreach ($datos['parcelas'] as $n): ?>
                        <option value="<?= $n['id_parcela'] ?>"
                            <?= ($datos['values']['id_parcela'] ?? '') == $n['id_parcela'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($n['id_parcela']) ?>
                        </option>
                    <?php endforeach ?>
            </select>
            </div>
            <div class="mb-3">
            <label for="difunto">Difunto</label>
            <div class="input-group">
            <select class="form-select" id="difunto" name="difunto" required>
                <option value="">Seleccione...</option>
                    <?php foreach ($datos['difuntos'] as $n): ?>
                        <option value="<?= $n['id_difunto'] ?>"
                            <?= ($datos['values']['id_difunto'] ?? '') == $n['id_difunto'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($n['nombre'] . ' ' . $n['apellido']) ?>
                        </option>
                    <?php endforeach ?>
            </select>
            </div>
            <div class="mb-3">
            <label for="fecha_ingreso" class="form-label">Fecha ingreso</label>
            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" 
                   value="<?= htmlspecialchars($datos['values']['fecha_ingreso'] ?? '') ?>">
            </div>
            <div class="mb-3">
            <label for="fecha_retiro" class="form-label">Fecha retiro</label>
            <input type="date" class="form-control" id="fecha_retiro" name="fecha_retiro" 
                   value="<?= htmlspecialchars($datos['values']['fecha_retiro'] ?? '') ?>">
        </div>
        </div>
        <div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="<?= URL ?>ubicacion" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>