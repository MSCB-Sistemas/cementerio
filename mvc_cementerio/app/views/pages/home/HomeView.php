<?php #require_once APP . '/config/config.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Cementerio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/styles.css">
    <!-- Favicon -->
    <link rel="icon" href="<?= URL ?>/public/img/favicon-16x16.png" type="image/x-icon">
</head>
<body>
    <!-- Logo -->
    <div class="text-left my-1">
        <img src="<?= URL ?>/public/img/logo_2.png" alt="Logo municipalidad SCB" width="80" height="80">
    </div>

    <!-- Sidebar -->
    <?php require_once APP . '/views/pages/home/Sidebar.php'; ?>
       

    <!-- Contenido principal -->
    <main class="container my-5">
        <h1 class="text-center">Bienvenido a tu página web</h1>
        <p class="text-center">Aquí contenido con Bootstrap.</p>
    </main>
    
</body>
<!-- Footer -->
    <?php require_once APP . '/views/pages/home/Footer.php'; ?>
</html>
