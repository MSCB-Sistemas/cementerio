<?php #require_once APP . '/config/config.php'; ?>

<!DOCTYPE html>
<html lang="es">
<!-- Header -->
    <?php require_once APP . '/views/pages/home/Header.php'; ?>
<body>
    <!-- Logo -->
    <div class="text-left my-1">
        <img src="<?= URL ?>/public/img/logo_2.png" alt="Logo municipalidad SCB" width="80" height="80">
    </div>

    <!-- Sidebar -->
    <?php require_once APP . '/views/inc/Sidebar.php'; 
    ?>
       

    <!-- Contenido principal -->
    <main class="container my-5">
        <h1 class="text-center">Bienvenido a tu página web</h1>
        <p class="text-center">Aquí contenido con Bootstrap.</p>
    </main>
    
</body>
<!-- Footer -->
    <?php require_once APP . '/views/pages/home/Footer.php'; ?>
</html>

