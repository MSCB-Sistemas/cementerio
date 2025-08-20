<?php
class AsistenciaController extends Control{
    private AsistenciaModel $model;
    private TiposUsuariosModel $tipoUsuariosModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = $this->loadModel("AsistenciaModel");
        $this->tipoUsuariosModel = $this->loadModel("TiposUsuariosModel");
    }

    public function index()
    {
        $asistencias = $this->model->getAllAsistencias();
        $datos = [
            'title' => 'Lista de Asistencias',
            'urlCrear' => URL . 'asistencia/create',    
            'columnas' => ['ID', 'Usuario', 'Fecha', 'Hora Entrada', 'Hora Salida', 'Activo'],
            'columnas_claves' => ['id_asistencia', 'usuario', 'fecha', 'hora_entrada', 'hora_salida', 'activo'],
            'data' => $asistencias,
            'acciones' => function ($fila) {
                $id = $fila['id_asistencia'];
                $url = URL . 'asistencia';
                return '
                    <a href="' . $url . '/edit/' . $id . '" class="btn btn-sm btn-primary">Editar</a>
                    <a href="' . $url . '/delete/' . $id . '" class="btn btn-sm btn-danger">Eliminar</a>
                    <a href="' . $url . '/activate/' . $id . '" class="btn btn-sm btn-success" onclick="return confirm(\'¿Activar esta asistencia?\');">Activar</a>
                ';
            },  
            'errores' => [],
        ];
        $this->loadView('asistencia/registrar', $datos);
    }
}

?>