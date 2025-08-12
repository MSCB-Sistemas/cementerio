<body class="bg-light text-dark d-flex justify-content-center align-items-center">
    <main class="w-100" style="max-width: 800px;">
        <div class="card shadow-lg border-0" style="width: 100%; max-width: 500px;">
            <div class="card-header bg-primary text-white text-center py-4">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="<?= URL ?>/public/img/EscudoBariloche.png" alt="Escudo Bariloche" 
                        style="width: 80px; height: 80px; object-fit: contain;">
                    <div class="ms-3 text-start">
                        <h1 class="h2 fw-bold mb-0">Cementerio Municipal</h1>
                        <h2 class="h5 fw-normal mb-0">San Carlos de Bariloche</h2>
                    </div>
                </div>
            </div>

            <form id="loginForm" method="POST" action="<?= URL ?>home" class="rounded-4 shadow p-4 bg-light text-dark needs-validation" novalidate>
                <div class="mb-4">
                    <div class="form-floating">
                        <input type="text" name="usuario" class="form-control border-primary" id="floatingInput" 
                                placeholder="Usuario" required>
                        <label for="floatingInput">Usuario</label>
                        <div class="invalid-feedback">
                            Por favor ingrese su usuario
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="form-floating">
                        <input type="password" name="contrasenia" class="form-control border-primary" 
                                id="floatingPassword" placeholder="Contraseña" required>
                        <label for="floatingPassword">Contraseña</label>
                        <div class="invalid-feedback">
                            Por favor ingrese su contraseña
                        </div>
                    </div>
                </div>
                
                <div class="mb-4 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Recuerdame
                    </label>
                </div>
                
                <div class="d-grid gap-3">
                    <button class="btn btn-primary btn-lg py-2" type="submit">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                    </button>
                </div>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger mt-4 mb-0">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </main>