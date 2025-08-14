<h1 class="visually-hidden">Barra inicio</h1>
<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark " style="width: 289px; background-color: #fd7e14 !important;">
    <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none" href="https://www.bariloche.gov.ar/" target="_blank">
        <img src="<?= URL . '/img/logo_claro.png' ?>" alt="Logo" width="240" height="80" class="pe-none me-2">
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item ">
            <a class="nav-link text-white" href="home" aria-current="page">
                <svg class="bi pe-none me-2" width="16" height="16" aria-hidden="true">
                    <use xlink:href="#home">
                        <symbol id="home" viewBox="0 0 16 16">
                            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"></path>
                        </symbol>
                    </use>
                </svg>
                Inicio
            </a>
        </li>
        <li>
            <a class="nav-link text-white position-relative" 
            data-bs-toggle="collapse" 
            data-bs-target="#submenuABM"
            href="#submenuABM" 
            role="button" 
            aria-expanded="false" 
            aria-controls="submenuABM">
            <svg class="bi pe-none me-2" width="16" height="16" aria-hidden="true">
                <use xlink:href="#table">
                    <symbol id="table" viewBox="0 0 16 16">
                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"></path>
                    </symbol>
                </use>
            </svg>
                Alta, Baja y Modificacion
                <span class="position-absolute end-0 me-3" id="abm-arrow">&#x25BC;</span> <!-- flecha hacia abajo -->
            </a>

            <div class="collapse ps-3" id="submenuABM">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <? if ($_SESSION['usuario_tipo'] == '1') : ?>
                        <li><a href="<?= URL ?>usuario" class="nav-link text-white">Usuarios</a></li>
                    <? endif; ?>
                    <li><a href="<?= URL ?>deudo" class="nav-link text-white">Deudos</a></li>
                    <li><a href="<?= URL ?>difunto" class="nav-link text-white">Difuntos</a></li>
                    <li><a href="<?= URL ?>estadoCivil" class="nav-link text-white">Estados Civiles</a></li>
                    <li><a href="<?= URL ?>parcela" class="nav-link text-white">Parcelas</a></li>
                    <li><a href="<?= URL ?>sexo" class="nav-link text-white">Sexos</a></li>
                    <li><a href="<?= URL ?>tipoParcela" class="nav-link text-white">Tipos de parcela</a></li>
                    <li><a href="<?= URL ?>tipoUsuario" class="nav-link text-white">Tipos de usuario</a></li>
                </ul>
            </div>
        </li>
    </ul>
    <hr>
    <div class="d-flex justify-content-center align-items-center">
        <?php echo ucfirst($_SESSION['usuario_nombre'])." ".ucfirst($_SESSION['usuario_apellido']);?> </strong>
        </a>
    </div>
</div>