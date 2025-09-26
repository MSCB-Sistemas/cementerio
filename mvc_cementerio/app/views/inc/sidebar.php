<h1 class="visually-hidden">Barra inicio</h1>
<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark " style="width: 289px; background-color: #fd7e14 !important;">
    <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none" href="https://www.bariloche.gov.ar/" target="_blank">
        <img src="<?= rtrim(URL,'/') . '/img/logo_claro.png' ?>" alt="Logo" width="240" height="80" class="pe-none me-2">
    </a>
    <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <?php foreach ($MENU as $item): ?>
                <?php
                    $perms = $item['perms'] ?? [];
                    $visible = empty($perms) || $canAny($perms);
                    if (!$visible) continue;

                    $hasChildren = !empty($item['children'] ?? []);
                    $children = [];
                    if ($hasChildren) {
                      foreach ($item['children'] as $ch) {
                          $chPerms = $ch['perms'] ?? [];
                          if (empty($chPerms) || $canAny($chPerms)) $children[] = $ch;
                      }
                      if (empty($children)) $hasChildren = false;
                    }

                    $itemHref = $item['href'] ?? null;
                    $itemActive = false;
                    if ($itemHref) {
                        $itemPath = trim(parse_url($itemHref, PHP_URL_PATH), '/');
                        if (str_starts_with($activePath, $itemPath)) $itemActive = true;
                    }
                ?>

                <?php if (!$hasChildren): ?>
                  <li class="nav-item">
                    <a class="nav-link text-white <?= $itemActive ? 'active' : '' ?>"
                      href="<?= htmlspecialchars($itemHref ?? '#') ?>">
                      <?= htmlspecialchars($item['label']) ?>
                    </a>
                  </li>
                <?php else: ?>
                  <?php $grpId = 'grp-' . md5($item['label']); ?>
                  <li>
                    <a class="nav-link text-white position-relative"
                      data-bs-toggle="collapse"
                      data-bs-target="#<?= $grpId ?>"
                      href="#<?= $grpId ?>"
                      role="button" aria-expanded="false"
                      aria-controls="<?= $grpId ?>">
                      <?= htmlspecialchars($item['label']) ?>
                      <span class="position-absolute end-0 me-3" id="<?= $grpId ?>-arrow">&#x25BC;</span>
                    </a>

                    <div class="collapse ps-3" id="<?= $grpId ?>">
                      <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <?php foreach ($children as $ch): ?>
                          <li>
                            <a class="nav-link text-white" href="<?= htmlspecialchars($ch['href']) ?>">
                              <?= htmlspecialchars($ch['label']) ?>
                            </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    
    <div class="dropup mt-auto text-center">
        <hr>
        <a class="d-block text-white dropdown-toggle fw-bold fs-6 text-decoration-none" 
        href="#" 
        role="button" 
        data-bs-toggle="dropdown" 
        aria-expanded="false">
            <?= ucfirst($_SESSION['usuario_nombre'])." ".ucfirst($_SESSION['usuario_apellido']); ?>
        </a>
        <ul class="dropdown-menu text-small shadow">
            <li><button class="dropdown-item" id="toggleTheme">Cambiar tema</button></li>
            <li><a class="dropdown-item text-danger" href="<?= URL ?>logout">Cerrar sesión</a></li>
        </ul>
    </div>
</div>