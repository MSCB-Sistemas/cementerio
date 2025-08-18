<?php 
$base = '/cementerio/mvc_cementerio';
require_once APP . '/views/pages/login/Header.php' ?>

<body id="body" class="bg-light text-dark d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <main class="w-100" style="max-width: 600px;">
        <form id="loginForm" class="rounded-4 shadow p-4 bg-light text-dark" method="POST" action="<?php echo URL; ?>home">
            <div class="d-flex align-items-center justify-content-center mb-4">
                <h1 class="h2 fw-bold text-black m-0 text-center">Cementerio Municipal<br> San Carlos de Bariloche</h1>
                <img src="/cementerio/mvc_cementerio/public/img/EscudoBariloche.png" alt="Logo" style="width: 80px; height: 80px; object-fit: contain; margin-left: 20px;">
             </div>


            <div class="form-floating mb-3">
                <input type="text" name="usuario" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Usuario</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="contrasenia" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Contraseña</label>
            </div>
            <div class="form-check text-start mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Recordar datos de inicio de sesión</label>
            </div>
            <div>
                <button class="btn btn-success w-100 py-2" type="submit">Iniciar sesión</button>
            </div><br>
            <div>
                <div class="text-center mb-3">
                <a href="<?= URL ?>usuario/create" class="btn btn-link">Registrar Nuevo Usuario</a>
            </div>

            <div></div>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
            </div>
        </form>
    </main>

<?php require_once APP . '/views/pages/login/Footer.php' ?>