<div class="container mt-5">
    <h2><?= $datos['title'] ?></h2>
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
            <label for="tipo_parcela" class="form-label">Tipo de parcela</label>
            <div class="input-group">
                <select class="form-select" id="tipo_parcela" name="tipo_parcela" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($datos['tipos_parcelas'] as $n): ?>
                        <option value="<?= $n['id_tipo_parcela'] ?>"
                            <?= ($datos['values']['id_tipo_parcela'] ?? '') == $n['id_tipo_parcela'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($n['nombre_parcela']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="deudo" class="form-label">Deudo</label>
            <div class="input-group">
                <select class="form-select" id="deudo" name="deudo" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($datos['deudos'] as $n): ?>
                        <option value="<?= $n['id_deudo'] ?>"
                            <?= ($datos['values']['id_deudo'] ?? '') == $n['id_deudo'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($n['nombre']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="numero_ubicacion" class="form-label">Numero ubicacion</label>
            <input type="text" class="form-control" id="numero_ubicacion" name="numero_ubicacion" 
                   value="<?= htmlspecialchars($datos['values']['numero_ubicacion'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="hilera" class="form-label">Hilera</label>
            <input type="text" class="form-control" id="hilera" name="hilera" 
                   value="<?= htmlspecialchars($datos['values']['hilera'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="seccion" class="form-label">Seccion</label>
            <input type="text" class="form-control" id="seccion" name="seccion" 
                   value="<?= htmlspecialchars($datos['values']['seccion'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="fraccion" class="form-label">Fraccion</label>
            <input type="text" class="form-control" id="fraccion" name="fraccion" 
                   value="<?= htmlspecialchars($datos['values']['fraccion'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="nivel" class="form-label">Nivel</label>
            <input type="text" class="form-control" id="nivel" name="nivel" 
                   value="<?= htmlspecialchars($datos['values']['nivel'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="orientacion" class="form-label">Orientacion</label>
            <div class="input-group">
                <select class="form-select" id="orientacion" name="orientacion" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($datos['orientaciones'] as $n): ?>
                        <option value="<?= $n['id_orientacion'] ?>"
                            <?= ($datos['values']['id_orientacion'] ?? '') == $n['id_orientacion'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($n['descripcion']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= URL ?>/parcela" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
