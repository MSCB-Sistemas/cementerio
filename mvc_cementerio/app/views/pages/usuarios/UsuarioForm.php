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
        <input type="hidden" name="id" value="<?= $values['id_deudo'] ?? '' ?>">
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" 
                   value="<?= htmlspecialchars($datos['values']['usuario'] ?? '') ?>" required>
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
            <label for="cargo" class="form-label">Cargo</label>
            <input type="text" class="form-control" id="cargo" name="cargo" 
                   value="<?= htmlspecialchars($datos['values']['cargo'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="sector" class="form-label">Sector</label>
            <input type="text" class="form-control" id="sector" name="sector" 
                   value="<?= htmlspecialchars($datos['values']['sector'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" 
                   value="<?= htmlspecialchars($datos['values']['tipo'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="activo" class="form-label">Activo</label>
            <input type="text" class="form-control" id="activo" name="activo" 
                   value="<?= htmlspecialchars($datos['values']['activo'] ?? '') ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= URL ?>/deudo" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
