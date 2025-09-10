<?php
class UsuarioController extends Control{
    private UsuarioModel $model;
    private TiposUsuariosModel $tipoUsuariosModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = $this->loadModel("UsuarioModel");
        $this->tipoUsuariosModel = $this->loadModel("TiposUsuariosModel");
    }

    public function index()
    {
        #$this->requirePermissionInController('ver_usuario');

        $usuarios = $this->model->getAllUsuarios();

        $datos = [
            'title'           => 'Lista de Usuarios',
            'urlCrear'        => URL . 'usuario/create',
            'columnas'        => ['ID', 'Usuario', 'Nombre', 'Apellido', 'Cargo', 'Sector', 'Telefono', 'Email', 'Rol', 'Activo'],
            'columnas_claves' => ['id_usuario', 'usuario', 'nombre', 'apellido', 'cargo', 'sector', 'telefono', 'email', 'descripcion', 'activo'],
            'data'            => $usuarios,
             // ★ Se respeta el uso del callback para acciones, pero se chequean los permisos
            'acciones' => function (array $fila) use ($puedeEditar, $puedeEliminar) 
            {
                $id = $fila['id_usuario'];
                $url = rtrim(URL,'/') . '/usuario';

                $html = '';
                if ($puedeEditar) 
                    {
                        $html .= '<a href="'.$url.'/edit/'.$id.'" class="btn btn-sm btn-primary">Editar</a> ';
                        // (Opcional) Activar vía POST: usar un form pequeñito en lugar de link GET
                        $html .= '<form action="'.$url.'/activate/'.$id.'" method="post" style="display:inline">'
                            .  '<input type="hidden" name="csrf" value="'.htmlspecialchars(csrf_token()).'">'
                            .  '<button class="btn btn-sm btn-success" onclick="return confirm(\'¿Activar este usuario?\');">Activar</button>'
                            .  '</form> ';
                    }
                if ($puedeEliminar) {
                    // ★ DELETE por POST + CSRF (no por GET)
                    $html .= '<form action="'.$url.'/delete/'.$id.'" method="post" style="display:inline" onsubmit="return confirm(\'¿Eliminar este usuario?\');">'
                          .  '<input type="hidden" name="csrf" value="'.htmlspecialchars(csrf_token()).'">'
                          .  '<button class="btn btn-sm btn-danger">Eliminar</button>'
                          .  '</form>';
                }
                return $html;
            },
            'puedeCrear'      => $puedeCrear,   // por si tu partial muestra el botón “Nuevo”
            'errores'         => [],
                /*return '
                    <a href="' . $url . '/edit/' . $id . '" class="btn btn-sm btn-primary">Editar</a>
                    <a href="' . $url . '/delete/' . $id . '" class="btn btn-sm btn-danger">Eliminar</a>
                    <a href="' . $url . '/activate/' . $id . '" class="btn btn-sm btn-success" onclick="return confirm(\'¿Activar este usuario?\');">Activar</a>
                    <a href="' . $url . '/changePass/' . $id . '" class="btn btn-sm btn-warning">Cambiar clave</a>
                ';
            },
            'errores' => [],
            */
        ];

        $this->loadView('partials/tablaAbm', $datos);
    }

    public function create()
    {
        // ★ permiso explícito
        #$this->requirePermissionInController('crear_usuario');

        $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();
        $datos = [
            'title'   => 'Crear usuario',
            'action'  => rtrim(URL,'/') . '/usuario/save',
            'values'  => [],
            'errores' => [],
            'tipos'   => $tipos,
            'update'  => false,
            'csrf'    => csrf_token(),
        ];

        $this->loadView('usuarios/UsuarioForm', $datos);
    }

    public function save()
    {
        // ★ permiso explícito
        #$this->requirePermissionInController('crear_usuario');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { $this->redirect('usuario'); }
        // método POST + CSRF
        if (!csrf_check($_POST['csrf'] ?? '')) { http_response_code(419); exit('CSRF'); }

        $usuario     = trim($_POST["usuario"]  ?? '');
        $nombre      = trim($_POST["nombre"]   ?? '');
        $apellido    = trim($_POST["apellido"] ?? '');
        $cargo       = trim($_POST["cargo"]    ?? '');
        $sector      = trim($_POST["sector"]   ?? '');
        $telefono    = trim($_POST["telefono"] ?? '');
        $email       = trim($_POST["email"]    ?? '');
        $contrasenia = trim($_POST["password"] ?? '');
        $tipoUsuario = $_POST["tipo_usuario"]  ?? '';
        
        $errores     = [];

        if (empty($usuario))        $errores[] = "El usuario es obligatorio.";
        if (empty($nombre))         $errores[] = "El nombre es obligatorio.";
        if (empty($apellido))       $errores[] = "El apellido es obligatorio.";
        if (empty($contrasenia))    $errores[] = "El nombre es obligatorio.";
        if (empty($tipoUsuario))    $errores[] = "Debe seleccionar un tipo de usuario.";
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Email inválido.";

        if (!empty($errores)) {
            $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();
            $this->loadView('usuarios/UsuarioForm', [
                'title'   => 'Crear nuevo usuario',
                'action'  => rtrim(URL,'/') . 'usuario/save',
                'values'  => $_POST,
                'errores' => $errores,
                'tipos'   => $tipos,
                'update' => false,
                'csrf'    => csrf_token(),
            ]);
            return;
        }

        $idNuevo = $this->model->insertUsuario($usuario, $nombre, $apellido, $cargo, $sector, $telefono, $email, $contrasenia, $tipoUsuario);
        if ($idNuevo > 0) {
            $_SESSION['flash_ok'] = 'Usuario creado.';
            $this->redirect('usuario');
        } 

        $_SESSION['flash_error'] = 'Error al guardar el usuario.';
        $this->redirect('usuario');
    }

    public function edit($id)
    {
        // ★ permiso
        #$this->requirePermissionInController('editar_usuario');
        
        $usuario = $this->model->getUsuarioId((int)$id);
        if (!$usuario) { 
            $_SESSION['flash_error'] = "Usuario no encontrado."; 
            $this->redirect('usuario'); 
        }
        
        $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();

        $this->loadView("usuarios/UsuarioForm", [
            'title' => "Editar usuario",
            'action' => rtrim(URL,'/') . 'usuario/update/' . (int)$id,
            'values' => [
                'usuario'         => $usuario['usuario'],
                'nombre'          => $usuario['nombre'],
                'apellido'        => $usuario['apellido'],
                'cargo'           => $usuario['cargo'],
                'sector'          => $usuario['sector'],
                'telefono'        => $usuario['telefono'],
                'email'           => $usuario['email'],
                'id_tipo_usuario' => $usuario['id_tipo_usuario'],
            ],
            'errores' => [],
            'tipos' => $tipos,
            'update' => true,
            'csrf'    => csrf_token(),
        ]);
    }

    public function update($id)
    {
        // ★ permiso + POST + CSRF
        #$this->requirePermission('editar_usuario');

        if ($_SERVER["REQUEST_METHOD"] !== "POST") { $this->redirect('usuario'); }
        if (!csrf_check($_POST['csrf'] ?? '')) 
        { 
            http_response_code(419); 
            exit('CSRF'); 
        }

        $usuario     = trim($_POST["usuario"] ?? '');
        $nombre      = trim($_POST["nombre"] ?? '');
        $apellido    = trim($_POST["apellido"] ?? '');
        $cargo       = trim($_POST["cargo"] ?? '');
        $telefono    = trim($_POST["telefono"] ?? '');
        $email       = trim($_POST["email"] ?? '');
        $sector      = trim($_POST["sector"] ?? '');
        $tipoUsuario = $_POST["tipo_usuario"] ?? '';

        $errores = [];
            if (empty($usuario))        $errores[] = "El usuario es obligatorio.";
        if (empty($nombre))         $errores[] = "El nombre es obligatorio.";
        if (empty($apellido))       $errores[] = "El apellido es obligatorio.";
        if (empty($contrasenia))    $errores[] = "El nombre es obligatorio.";
        if (empty($tipoUsuario))    $errores[] = "Debe seleccionar un tipo de usuario.";
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Email inválido.";

        if (!empty($errores)) 
        {
            $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();
            $usuario = [
                'title'   => 'Editar usuario',
                'action'  => rtrim(URL,'/') . '/usuario/update/' . (int)$id,
                'values'  => [
                    'usuario'          => $usuario,
                    'nombre'           => $nombre,
                    'apellido'         => $apellido,
                    'cargo'            => $cargo,
                    'telefono'         => $telefono,
                    'email'            => $email,
                    'sector'           => $sector,
                    'id_tipo_usuario'  => $tipoUsuario,
                ],
            ];

            $this->loadView('usuarios/UsuarioForm', $usuario, [
                'errores' => $errores,
                'tipos'   => $tipos,
                'update'  => true,
                'csrf'    => csrf_token(),
            ]);
            return;
        }

        if ($this->model->updateUsuario((int)$id, $usuario, $nombre, $apellido, $cargo, $sector, $telefono, $email, $tipoUsuario)) {
            $_SESSION['flash_ok'] = 'Usuario actualizado.';
            $this->redirect('usuario');
        } else {
            $_SESSION['flash_error'] = 'Error al actualizar el usuario.';
            $this->redirect('usuario');
        }
    }

    public function delete($id)
    {
        #$this->requirePermissionInController('eliminar_usuario');

        if ($this->model->deleteUsuario($id)) {
            header("Location: " . URL . "usuario");
            exit;
        } else {
            die("No se pudo eliminar al usuario.");
        }
    }

    public function activate($id)
    {
        #$this->requirePermissionInController('editar_usuario');

        if ($this->model->activateUsuario($id)) {
            header("Location: " . URL . "usuario");
            exit;
        } else {
            die("No se pudo activar al usuario");
        }
    }

    public function changePass($id)
    {
        $this->loadView('usuarios/UsuarioFormPass', [
            'title' => 'Cambiar clave',
            'action' => URL . 'usuario/savePass/' . $id,
            'errores' => []
        ]);
    }

    public function savePass($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = trim($_POST["password"]);

            $errores = [];
            if (empty($password)) $errores[] = "El campo nueva contrasenia es obligatorio.";

            if (!empty($errores)) {
                $this->loadView("usuarios/UsuarioFormPass", [
                    'title' => 'Cambiar clave',
                    'action' => URL . 'usuario/savePass/' . $id,
                    'errores' => $errores
                ]);
                return;
            }

            $password = password_hash($password, PASSWORD_DEFAULT);
            if ($this->model->updatePassword($id, $password)) {
                header('Location: ' . URL . 'usuario');
                exit;
            } else {
                die("Error al cambiar la clave");
            }
        }
    }
}
?>
 