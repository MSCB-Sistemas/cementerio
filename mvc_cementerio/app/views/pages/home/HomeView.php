<html>"Pagina principal"</html>
<body>
    <h1>Bienvenido a la página principal</h1>
</body>
<?php if (!empty($usuario)): ?>
    <p>Hola, <?= htmlspecialchars($usuario['email']) ?> 👋</p>
<?php endif; ?>

<nav>
    <a href="<?= APP ?>usuario/logout">Cerrar sesión</a>
</nav>
