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
        <input type="hidden" name="id_tipo_parcela" value="<?= $values['id_tipo_parcela'] ?? '' ?>">
        <div class="mb-3">
            <label for="nombre_parcela" class="form-label">Nombre de tipo de parcela</label>
            <input type="text" class="form-control" id="nombre_parcela" name="nombre_parcela" 
                   value="<?= htmlspecialchars($datos['values']['nombre_parcela'] ?? '') ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= URL ?>/tipoParcela" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
