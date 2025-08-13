
<!doctype html>
<html lang="es" data-bs-theme="auto">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons (opcional, para los íconos del menú) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* Estilos suaves para el sidebar */
    .sidebar {
      width: 280px;
      min-height: 100vh;
    }
    .btn-toggle {
      padding: .25rem .5rem;
      font-weight: 600;
      background-color: transparent;
    }
    .btn-toggle::after {
      content: "";
      width: .9em;
      height: .9em;
      margin-left: .25rem;
      display: inline-block;
      vertical-align: .255em;
      border-right: .12em solid currentColor;
      border-bottom: .12em solid currentColor;
      transform: rotate(-45deg);
      transition: transform .2s;
    }
    .btn-toggle[aria-expanded="true"]::after {
      transform: rotate(45deg);
    }
    .btn-toggle-nav a {
      padding: .25rem .5rem;
      margin: .2rem 0 .2rem 1.25rem;
      display: inline-flex;
      border-radius: .25rem;
    }
    .btn-toggle-nav a:hover,
    .btn-toggle-nav a.active {
      background-color: rgba(0,0,0,.05);
      text-decoration: none;
    }
  </style>
</head>
<body>

<main class="d-flex">
  <!-- SIDEBAR -->
  <aside class="sidebar d-flex flex-column flex-shrink-0 bg-light border-end p-3">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <i class="bi bi-bootstrap-fill me-2 fs-4"></i>
      <span class="fs-5 fw-semibold">Sistema Cementerio Municipal</span>
    </a>
    <hr>

    <ul class="list-unstyled ps-0 nav flex-column">

      <!-- Difunto-->
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0"
                data-bs-toggle="collapse" data-bs-target="#difunto-collapse" aria-expanded="false">
          <i class="bi bi-house-door me-2"></i> ABM Difuntos
        </button>
        <div class="collapse" id="difunto-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Registrar Difunto</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Modificar Difunto</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Eliminar Difunto</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Padrón General</a></li>
          </ul>
        </div>
      </li>

      <!-- Deudo -->
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                data-bs-toggle="collapse" data-bs-target="#deudo-collapse" aria-expanded="false">
          <i class="bi bi-speedometer2 me-2"></i> ABM Deudo
        </button>
        <div class="collapse" id="deudo-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Registrar Deudo</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Modificar Deudo</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Eliminar Deudo</a></li>
          </ul>
        </div>
      </li>

      <!-- Ubicaciones -->
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                data-bs-toggle="collapse" data-bs-target="#ubicacion-collapse" aria-expanded="false">
          <i class="bi bi-bag-check me-2"></i> Ubicaciones
        </button>
        <div class="collapse" id="ubicacion-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Registrar Ubicación</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Modificar Ubicación</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Eliminar Ubicación</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Listado de Ubicaciones</a></li>
          </ul>
        </div>
      </li>

      <li class="border-top my-3"></li>

      <!-- Pagos -->
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                data-bs-toggle="collapse" data-bs-target="#pago-collapse" aria-expanded="false">
          <i class="bi bi-person-circle me-2"></i> Pagos
        </button>
        <div class="collapse" id="pago-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Registrar Pago</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Eliminar Pago</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Historial de Pagos</a></li>
          </ul>
        </div>
      </li>

      
      <!-- Parcelas -->
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                data-bs-toggle="collapse" data-bs-target="#parcela-collapse" aria-expanded="false">
          <i class="bi bi-bag-check me-2"></i> Parcelas
        </button>
        <div class="collapse" id="parcela-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Agregar Parcela</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Modificar Parcela</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Eliminar Parcela</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Historial de Parcelas Vendidas</a></li>
          </ul>
        </div>
      </li>
    </ul>

    

        <div class="mt-auto">
  <!-- Registrar usuario: usar <a> en lugar de <button href> -->
  <a href="<?= URL ?>login" class="btn btn-primary w-100 mb-2" id="btnRegistrar">
    Registrar usuario
  </a>

  <!-- Cerrar sesión por POST (y cerrando el form) -->
  <form action="<?= URL ?>usuario/logout" method="POST" class="d-grid">
    <!-- Si tenés CSRF: <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf'] ?? '') ?>"> -->
    <button type="submit" class="btn btn-danger w-100">Cerrar sesión</button>
  </form>
</div>

      </div>
  </aside>
  
</main>

<!-- Bootstrap JS (necesario para collapse) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



        