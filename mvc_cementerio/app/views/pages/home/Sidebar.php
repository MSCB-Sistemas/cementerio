<!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
        <div class="container">
        <a class="navbar-brand" href="#">Sistema Cementerio Municipal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Dropdown ABM Difuntos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="difuntoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ABM Difuntos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="difuntoDropdown">
                        <li><a class="dropdown-item dropdown" href="#">Agregar Difunto</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item dropdown" href="#">Modificar Difunto</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item dropdown" href="#">Eliminar Difunto</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item dropdown" href="#">Padrón General</a></li>
                    </ul>
                </li>

                <!-- Dropdown ABM Deudos -->
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="deudoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                ABM Deudos
                </a>
                <ul class="dropdown-menu" aria-labelledby="deudoDropdown">
                    <li><a class="dropdown-item dropdown" href="#">Agregar Deudo</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item dropdown" href="#">Modificar Deudo</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item dropdown" href="#">Eliminar Deudo</a></li>
                </ul>
                </li>

                 <!-- Dropdown ABM Ubicaciones -->
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="ubicacionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                ABM Ubicaciones
                </a>
                <ul class="dropdown-menu" aria-labelledby="ubicacionDropdown">
                    <li><a class="dropdown-item dropdown" href="#">Registrar Ubicación</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item dropdown" href="#">Modificar Ubicación</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item dropdown" href="#">Eliminar Ubicación</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item dropdown" href="#">Listado de Ubicaciones</a></li>
                </ul>
                </li>

                <!-- Dropdown Pagos -->
                <li class="nav-item dropdown dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pagos
                </a>
                <ul class="dropdown-menu" aria-labelledby="pagoDropdown">
                    <li><a class="dropdown-item dropdown" href="#">Registrar Pago</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item dropdown" href="#">Eliminar Pago</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item dropdown" href="#">Historial Pagos</a></li>
                </ul>
                </li>

                <!-- Dropdown ABM Parcela -->
                 <li class="nav-item dropdown dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="parcelaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                ABM Parcela
                </a>
                <ul class="dropdown-menu" aria-labelledby="parcelaDropdown">
                    <li><a class="dropdown-item dropdown" href="#">Agregar </a></li>
                    <li><a class="dropdown-item dropdown" href="#">Editar </a></li>
                    <li><a class="dropdown-item dropdown" href="#">Eliminar </a></li>
                </ul>
                </li>

            
            </ul>
            <button class="btn btn-checkin">Cerrar sesión</button>
        </div>
        <nav>
            <a href="<?= APP ?>usuario/logout"></a>
        </nav>
        </div>
    </nav>