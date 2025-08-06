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
                   value="<?= htmlspecialchars($datos['values']['dni'] ?? '') ?>" required>
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
            <label for="telefono" class="form-label">Telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" 
                   value="<?= htmlspecialchars($datos['values']['telefono'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" 
                   value="<?= htmlspecialchars($datos['values']['email'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="domicilio" class="form-label">Domicilio</label>
            <input type="text" class="form-control" id="domicilio" name="domicilio" 
                   value="<?= htmlspecialchars($datos['values']['domicilio'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="localidad" class="form-label">Localidad</label>
            <input type="text" class="form-control" id="localidad" name="localidad" 
                   value="<?= htmlspecialchars($datos['values']['localidad'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="codigo_postal" class="form-label">Codigo Postal</label>
            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" 
                   value="<?= htmlspecialchars($datos['values']['codigo_postal'] ?? '') ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= URL ?>/deudo" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
