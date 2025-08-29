<?php
  // Sesión: abrir una sola vez y bien temprano
  if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', 1);
    session_start();
  }

  require_once 'config/config.php';
  require_once __DIR__ . '/../app/config/errores.php';
  require_once __DIR__ . '/helpers/authHelper.php';
  require_once __DIR__ . '/../app/lib/Control.php';

  // Autoload multipath/
  spl_autoload_register(function ($class) {
    $paths = [
      __DIR__ . '/lib/' . $class . '.php',
      __DIR__ . '/models/' . $class . '.php',
      __DIR__ . '/controllers/' . $class . '.php',
    ];
    foreach ($paths as $file) {
      if (file_exists($file)) {
        require_once $file;
        return;
      }
    }
  });
?>