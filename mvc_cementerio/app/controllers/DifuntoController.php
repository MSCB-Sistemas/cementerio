<?php
class DifuntoController extends Control
{
    private DifuntoModel $model;
    private DeudoModel $deudoModel;
    private NacionalidadesModel $nacionalidadesModel;
    private SexoModel $sexoModel;
    private EstadoCivilModel $estadoCivilModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = $this->loadModel("DifuntoModel");
        $this->deudoModel = $this->loadModel("DeudoModel");
        $this->nacionalidadesModel = $this->loadModel("NacionalidadesModel");
        $this->sexoModel = $this->loadModel("SexoModel");
        $this->estadoCivilModel = $this->loadModel("EstadoCivilModel");
    }

    public function index()
    {
        $difuntos = $this->model->getAllDifuntos();

        $datos = [
            'title' => 'Lista de difuntos',
            'urlCrear' => URL . 'difunto/create',
            'columnas' => ['ID', 'Deudo', 'Nombre', 'Apellido', 'DNI', 'Edad', 'Fecha defuncion', 'Genero', 'Nacionalidad', 'Estado civil', 'Domicilio', 'Localidad', 'Codigo postal'],
            'columnas_claves' => ['id_difunto', 'nombre_deudo', 'nombre', 'apellido', 'dni', 'edad', 'fecha_fallecimiento', 'sexo', 'nacionalidad', 'estado_civil', 'domicilio', 'localidad', 'codigo_postal'],
            'data' => $difuntos,
            'acciones' => function ($fila) {
                $id = $fila['id_difunto'];
                $url = URL . 'difunto';
                return '
                    <a href="' . $url . '/edit/' . $id . '" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="' . $url . '/delete/' . $id . '" class="btn btn-sm btn-outline-primary">Eliminar</a>
                ';
            },
            'errores' => [],
        ];

        $this->loadView('partials/tablaAbm', $datos);
    }

    public function create()
    {
        $deudos = $this->deudoModel->getAllDeudos();
        $nacionalidades = $this->nacionalidadesModel->getAllNacionalidades();
        $sexos = $this->sexoModel->getAllSexos();
        $estadosCiviles = $this->estadoCivilModel->getAllestadosCiviles();

        $datos = [
            'title' => 'Crear difunto',
            'action' => URL . 'difunto/save',
            'values' => [],
            'errores' => [],
            'deudos' => $deudos,
            'nacionalidades' => $nacionalidades,
            'sexos' => $sexos,
            'estados_civiles' => $estadosCiviles
        ];

        $this->loadView('difuntos/DifuntoForm', $datos);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $deudo = $_POST["deudo"] ?? '';
            $nombre = trim($_POST["nombre"] ?? '');
            $apellido = trim($_POST["apellido"] ?? '');
            $dni = trim($_POST["dni"] ?? '');
            $edad = trim($_POST["edad"] ?? '');
            $fechaFallecimiento = trim($_POST["fecha_fallecimiento"] ?? '');
            $sexo = $_POST["sexo"] ?? '';
            $nacionalidad = $_POST["nacionalidad"] ?? '';
            $estadoCivil = $_POST["estado_civil"] ?? '';
            $domicilio = trim($_POST["domicilio"] ?? '');
            $localidad = trim($_POST["localidad"] ?? '');
            $codigoPostal = trim($_POST["codigo_postal"] ?? '');
            $errores = [];

            if (empty($deudo))
                $errores[] = "El deudo es obligatorio";
            if (empty($dni))
                $errores[] = "El dni es obligatorio";
            if (empty($fechaFallecimiento))
                $errores[] = "La fecha de fallecimiento es obligatoria";
            if (empty($domicilio))
                $errores[] = "El domicilio es obligatorio";
            if (empty($localidad))
                $errores[] = "La localidad es obligatorio";

            if (!empty($errores)) {
                $deudos = $this->deudoModel->getAllDeudos();
                $nacionalidades = $this->nacionalidadesModel->getAllNacionalidades();
                $sexos = $this->sexoModel->getAllSexos();
                $estadosCiviles = $this->estadoCivilModel->getAllestadosCiviles();

                $this->loadView('difuntos/DifuntoForm', [
                    'title' => 'Crear difunto',
                    'action' => URL . 'difunto/save',
                    'values' => $_POST,
                    'errores' => $errores,
                    'deudos' => $deudos,
                    'nacionalidades' => $nacionalidades,
                    'sexos' => $sexos,
                    'estados_civiles' => $estadosCiviles,
                ]);
                return;
            }

            if ($this->model->insertDifunto($deudo, $nombre, $apellido, $dni, $edad, $fechaFallecimiento, $sexo, $nacionalidad, $estadoCivil, $domicilio, $localidad, $codigoPostal)) {
                header("Location: " . URL . "difunto");
                exit;
            } else {
                die("Error al guardar el difunto");
            }
        }
    }

    public function edit($id)
    {
        $difunto = $this->model->getDifunto($id);
        $deudos = $this->deudoModel->getAllDeudos();
        $nacionalidades = $this->nacionalidadesModel->getAllNacionalidades();
        $sexos = $this->sexoModel->getAllSexos();
        $estadosCiviles = $this->estadoCivilModel->getAllestadosCiviles();

        if (!$difunto) {
            die("Difunto no encontrado");
        }

        $this->loadView('difuntos/DifuntoForm', [
            'title' => 'Editar difunto',
            'action' => URL . 'difunto/update/' . $id,
            'values' => [
                'deudo' => $difunto['id_deudo'],
                'nombre' => $difunto['nombre'],
                'apellido' => $difunto['apellido'],
                'dni' => $difunto['dni'],
                'edad' => $difunto['edad'],
                'fecha_fallecimiento' => $difunto['fecha_fallecimiento'],
                'sexo' => $difunto['id_sexo'],
                'nacionalidad' => $difunto['id_nacionalidad'],
                'estado_civil' => $difunto['id_estado_civil'],
                'domicilio' => $difunto['domicilio'],
                'localidad' => $difunto['localidad'],
                'codigo_postal' => $difunto['codigo_postal'],
            ],
            'errores' => [],
            'deudos' => $deudos,
            'nacionalidades' => $nacionalidades,
            'sexos' => $sexos,
            'estados_civiles' => $estadosCiviles,
        ]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $deudo = $_POST["deudo"] ?? '';
            $nombre = trim($_POST["nombre"] ?? '');
            $apellido = trim($_POST["apellido"] ?? '');
            $dni = trim($_POST["dni"] ?? '');
            $edad = trim($_POST["edad"] ?? '');
            $fechaFallecimiento = trim($_POST["fecha_fallecimiento"] ?? '');
            $sexo = $_POST["sexo"] ?? '';
            $nacionalidad = $_POST["nacionalidad"] ?? '';
            $estadoCivil = $_POST["estado_civil"] ?? '';
            $domicilio = trim($_POST["domicilio"] ?? '');
            $localidad = trim($_POST["localidad"] ?? '');
            $codigoPostal = trim($_POST["codigo_postal"] ?? '');

            if (empty($deudo))
                $errores[] = "El deudo es obligatorio";
            if (empty($dni))
                $errores[] = "El dni es obligatorio";
            if (empty($fechaFallecimiento))
                $errores[] = "La fecha de fallecimiento es obligatoria";
            if (empty($domicilio))
                $errores[] = "El domicilio es obligatorio";
            if (empty($localidad))
                $errores[] = "La localidad es obligatorio";

            if (!empty($errores)) {
                $difunto = [
                    'id_difunto' => $id,
                    'id_deudo' => $deudo,
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'dni' => $dni,
                    'edad' => $edad,
                    'fecha_fallecimiento' => $fechaFallecimiento,
                    'id_sexo' => $sexo,
                    'id_nacionalidad' => $nacionalidad,
                    'id_estado_civil' => $estadoCivil,
                    'domicilio' => $domicilio,
                    'localidad' => $localidad,
                    'codigo_postal' => $codigoPostal
                ];

                $deudos = $this->deudoModel->getAllDeudos();
                $nacionalidades = $this->nacionalidadesModel->getAllNacionalidades();
                $sexos = $this->sexoModel->getAllSexos();
                $estadosCiviles = $this->estadoCivilModel->getAllestadosCiviles();

                $this->loadView('difuntos/DifuntoForm', [
                    'title' => 'Editar difunto',
                    'action' => URL . 'difunto/update/' . $id,
                    'values' => $difunto,
                    'errores' => $errores,
                    'deudos' => $deudos,
                    'nacionalidades' => $nacionalidades,
                    'sexos' => $sexos,
                    'estados_civiles' => $estadosCiviles,
                ]);
                return;
            }

            if ($this->model->updateDifunto($id, $deudo, $nombre, $apellido, $dni, $edad, $fechaFallecimiento, $sexo, $nacionalidad, $estadoCivil, $domicilio, $localidad, $codigoPostal)) {
                header("Location: " . URL . "difunto");
                exit;
            } else {
                die("Error al actualizar el difunto");
            }
        }
    }

    public function delete($id)
    {
        if ($this->model->deleteDifunto($id)) {
            header("Location: " . URL . "difunto");
            exit;
        } else {
            die("No se pudo eliminar al difunto");
        }
    }
}
?>