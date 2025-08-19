<?php
class UbicacionDifuntoController extends Control{

    private UbicacionDifuntoModel $model;
    private DifuntoModel $difuntoModel;
    private ParcelaModel $parcelaModel;

    public function __construct(){
       $this->model = $this->loadModel("UbicacionDifuntoModel"); 
       $this->difuntoModel = $this->loadModel("DifuntoModel");
       $this->parcelaModel = $this->loadModel("ParcelaModel");
    }

    public function index(){
        $ubicaciones = $this->model->getAllUbicaciones();

        $datos = [
            'title' => 'Lista de ubicaciones',
            'urlCrear' => URL . 'ubicacion/create',
            'columnas' => ['ID', 'ID de parcela', 'ID del difunto', 'Fecha de ingreso', 'Fecha de retiro'],
            'columnas_claves' => ['id_ubicacion_difunto', 'id_parcela', 'id_difunto', 'fecha_ingreso', 'fecha_retiro'],
            'data' => $ubicaciones,
            'acciones' => function($fila){
                $id = $fila['id_ubicacion_difunto'];
                $url = URL . 'ubicacion';
                return '
                    <a href="' . $url . '/edit/' . $id . '" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="' . $url . '/delete/' . $id . '" class="btn btn-sm btn-outline-primary">Eliminar</a>
                ';
            },
            'errores' => [],
        ];

        $this->loadView('partials/tablaAbm', $datos);
    }

    public function create(){

        $difuntos = $this->difuntoModel->getAllDifuntos();
        /* $parcelas = $this->parcelaModel->getAllParcelas(); */
        
        $datos = [
            'title' => 'Crear Ubicación',
            'action' => URL . 'ubicacion/save',
            'values' => [],
            'errores' => [],
            'difuntos' => $difuntos,
            /* 'parcelas' => $parcelas, */
        ];
        $this->loadView('ubicaciones/UbicacionDifuntoForm', $datos);
    }

    public function save(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $difunto = $_POST["difunto"] ?? "";
            $parcela = $_POST["parcela"] ?? "";
            $fecha_ingreso = $_POST["fecha_ingreso"] ?? "";
            $fecha_retiro = $_POST["fecha_retiro"] ?? "";
            $errores = [];

            if(empty($difunto)){
                $errores[] = "El difunto es obligatorio";
            }
            if(empty($parcela)){
                $errores[] = "La parcela es obligatoria";
            }
            if(empty($fecha_ingreso)){
                $errores[] = "La fecha de ingreso es obligatoria";
            }

            if(!empty($errores)){
                $difuntos = $this->difuntoModel->getAllDifuntos();
                $parcelas = $this->parcelaModel->getAllParcelas();

                $this->loadView('ubicaciones/UbicacionDifuntoForm',[
                    'title' => 'Crear ubicación',
                    'action' => URL . 'ubicacion/save',
                    'values' => $_POST,
                    'errores' => $errores,
                    'difuntos' => $difuntos,
                    'parcelas' => $parcelas,
                ]);
                return;
            }

            if($this->model->insertUbicacion($parcela, $difunto, $fecha_ingreso, $fecha_retiro)){
                header("Location: " . URL . "ubicacion");
                exit;
            }else{
                die("Error al guardar la ubicación");
            }
        }
    }

    public function edit($id){
        $ubicacion = $this->model->getUbicacionDifunto($id);
        $difuntos = $this->difuntoModel->getAllDifuntos();
        $parcelas = $this->parcelaModel->getAllParcelas();

        if(!$ubicacion){
            die("Ubicación no encontrada");
        }

        $this->loadView('ubicaciones/UbicacionDifuntoForm', [
            'title' => 'Editar ubicación',
            'action' => URL . 'ubicacion/update/' . $id,
            'values' => [
                'parcela' => $ubicacion['id_parcela'],
                'difunto' => $ubicacion['id_difunto'],
                'fecha_ingreso' => $ubicacion['fecha_ingreso'],
                'fecha_retiro' => $ubicacion['fecha_retiro'],
            ],
            'errores' => [],
            'parcelas' => $parcelas,
            'difuntos' => $difuntos,
        ]);
    }

    public function update($id){
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $parcela = $_POST["parcela"] ?? '';
        $difunto = $_POST["difunto"] ?? '';
        $fecha_ingreso = $_POST["fecha_ingreso"] ?? "";
        $fecha_retiro = $_POST["fecha_retiro"] ?? "";
        $errores = [];

        if(empty($difunto)){
            $errores[] = "El difunto es obligatorio";
            }
        if(empty($parcela)){
            $errores[] = "La parcela es obligatoria";
            }
        if(empty($fecha_ingreso)){
            $errores[] = "La fecha de ingreso es obligatoria";
            }
         if(!empty($errores)){

            $ubicacion = [
                'id_ubicacion' => $id,
                'id_parcela' => $parcela,
                'id_difunto' => $difunto,
                'fecha_ingreso' => $fecha_ingreso,
                'fecha_retiro' => $fecha_retiro,

            ];
                $difuntos = $this->difuntoModel->getAllDifuntos();
                $parcelas = $this->parcelaModel->getAllParcelas();

                $this->loadView('ubicaciones/UbicacionDifuntoForm',[
                    'title' => 'Editar ubicación',
                    'action' => URL . 'ubicacion/update/' . $id,
                    'values' => $ubicacion,
                    'errores' => $errores,
                    'difuntos' => $difuntos,
                    'parcelas' => $parcelas,
                ]);
                return;
            }
            if($this->model->updateUbicacion($id, $parcela, $difunto, $fecha_ingreso, $fecha_retiro )){
                header("Location: " . URL . "ubicacion");
                exit;
            }else{
                die("Error al actualizar la ubicación");
            }    

     }   
    }

    public function delete($id){
        if($this->model->deleteUbicacion($id)){
            header("Location: " . URL . "ubicacion");
        }else{
            die("No se pudo eliminar la ubicación");
        }
    }

}

?>