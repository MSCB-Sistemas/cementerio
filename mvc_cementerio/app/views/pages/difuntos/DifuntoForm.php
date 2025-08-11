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
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" 
                   value="<?= htmlspecialchars($datos['values']['nombre'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" 
                   value="<?= htmlspecialchars($datos['values']['apellido'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" 
                   value="<?= htmlspecialchars($datos['values']['dni'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="edad" class="form-label">Edad</label>
            <input type="text" class="form-control" id="cargo" name="edad" 
                   value="<?= htmlspecialchars($datos['values']['edad'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="fecha_fallecimiento" class="form-label">Fecha fallecimiento</label>
            <input type="date" class="form-control" id="fecha_fallecimiento" name="fecha_fallecimiento" 
                   value="<?= htmlspecialchars($datos['values']['fecha_fallecimiento'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="sexo" class="form-label">Genero</label>
            <div class="input-group">
                <select class="form-select" id="sexo" name="sexo" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($datos['sexos'] as $n): ?>
                        <option value="<?= $n['id_sexo'] ?>"
                            <?= ($datos['values']['id_sexo'] ?? '') == $n['id_sexo'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($n['descripcion']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="nacionalidad" class="form-label">Nacionalidad</label>
            <div class="input-group">
                <select class="form-select" id="nacionalidad" name="nacionalidad" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($datos['nacionalidades'] as $n): ?>
                        <option value="<?= $n['id_nacionalidad'] ?>"
                            <?= ($datos['values']['id_nacionalidad'] ?? '') == $n['id_nacionalidad'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($n['nacionalidad']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="estado_civil" class="form-label">Estado civil</label>
            <div class="input-group">
                <select class="form-select" id="estado_civil" name="estado_civil" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($datos['estados_civiles'] as $n): ?>
                        <option value="<?= $n['id_estado_civil'] ?>"
                            <?= ($datos['values']['id_estado_civil'] ?? '') == $n['id_estado_civil'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($n['descripcion']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="domicilio" class="form-label">Domicilio</label>
            <input type="text" class="form-control" id="domicilio" name="domicilio" 
                   value="<?= htmlspecialchars($datos['values']['domicilio'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="localidad" class="form-label">Localidad</label>
            <input type="text" class="form-control" id="localidad" name="localidad" 
                   value="<?= htmlspecialchars($datos['values']['localidad'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="codigo_postal" class="form-label">Codigo postal</label>
            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" 
                   value="<?= htmlspecialchars($datos['values']['codigo_postal'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= URL ?>/difunto" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
