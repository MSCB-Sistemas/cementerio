<div>
    <h2><?= $datos['title'] ?></h2>
    <?php if (!empty($datos['errores'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($datos['errores'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= $datos['action'] ?>" method="POST">
        <div>
            <label for="dni" class="form-label">DNI:</label>
            <input type="text" class="form-control" id="dni" name="dni" value="<?= htmlspecialchars($datos['deudo']->getDni() ?? '') ?>" required>
        </div>
    </form>
</div>