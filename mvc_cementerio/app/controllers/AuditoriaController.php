<?php
class AuditoriaController extends Control{
    private AuditoriaModel $model;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = $this->loadModel("AuditoriaModel");
    }

    public function index(): void
    {
        $auditorias = $this->model->getAllAuditorias();
        
        $datos = [
            'title' => 'Listado de auditorias registradas',
            'columnas' => ['ID', 'ID_Usuario', 'Creado_En', 'Querys', 'Controlador', 'Acción'],
            'columnas_claves' => ['id_auditoria', 'id_usuario', 'creado_en', 'query_sql', 'controller', 'accion'],
            'acciones' => function ($fila) {
                $id = $fila['id_auditoria'];    
                $url = URL . 'auditoria';
                return '
                <a href="' . $url . '/reporte/' . $id . '" class="btn btn-sm btn-outline-primary">Ver Reporte</a>
                <a href="' . $url . '/detalle/' . $id . '" class="btn btn-sm btn-outline-secondary">Detalles</a>
                ';
            },
            'auditorias' => $auditorias
        ];
    }

    /**
     * Registrar una auditoria. 
     * @return Devuelve su status e Id insertado.
     */
    public function registrarAuditoria($id_auditoria, $id_usuario, $query_sql, $controller, $action): array
    {
        $id_auditoria = $this->model->insertAuditoria($id_auditoria, $id_usuario, $query_sql, $controller, $action);
        if($id_auditoria){
            return [
                'status' => 'success',
                'id_auditoria' => $id_auditoria,
                'message' => 'Auditoria registrada correctamente',
            ];
        }else {
            return [
                'status' => 'error',
                'message' => 'Error al registrar la auditoria',
            ];
        }
    }
}

?>