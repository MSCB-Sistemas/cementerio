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
        <input type="hidden" name="id_tipo_usuario" value="<?= $values['id_tipo_usuario'] ?? '' ?>">
        <div class="mb-3">
            <label for="descripcion" class="form-label">Nombre de tipo de usuario</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" 
                   value="<?= htmlspecialchars($datos['values']['descripcion'] ?? '') ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= URL ?>tipoUsuario" class="btn btn-secondary">Cancelar</a>
    </form>
</div>