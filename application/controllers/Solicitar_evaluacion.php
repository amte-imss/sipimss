<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 		: Mr. Guag
 * fecha: 29/08/2016
 */
class Solicitar_evaluacion extends MY_Controller {
    private $cfg_actividad;

    function __construct(){
        parent::__construct();
        $this->lang->load('interface_administracion');
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->library('seguridad');
        $this->load->model('Usuario_model','usuario');
        $this->load->config("general");
    }
    
    function index(){
      $this->load->model("Solicitud_model","sol");
      $solicitudes["solicitudes"] = $this->sol->list_solicitudes($this->session->idempleado);
      $main_content = $this->load->view('solicitar_evaluacion/index.tpl.php',$solicitudes, true);
        //$this->template->setCuerpoModal($this->ventana_modal->carga_modal());
      $this->template->multiligual = TRUE;
      $this->template->setTitle("SECD");
      
      $this->template->setMainContent($main_content);
      $this->template->getTemplate(FALSE,'template/sipimss/index.tpl.php');
    }

    function solicitar(){
        $conditions[Enum_sec::S_FOR_PERSONAL_CONTINUA_SALUD] = array();
        $conditions[Enum_sec::S_FORMACION_PROFESIONAL] = array();
        $conditions[Enum_sec::S_EDUCACION_DISTANCIA] = array();
        $conditions[Enum_sec::S_ESP_MEDICA] = array();
        $conditions[Enum_sec::S_ACTIVIDAD_DOCENTE] = array();
        $conditions[Enum_sec::S_BECAS_LABORALES] = array();
        $conditions[Enum_sec::S_COMISIONES_LABORALES] =  array();
        $conditions[Enum_sec::S_COMISIONES_ACADEMICAS] = array();
        $conditions[Enum_sec::S_ACT_INV_EDU] = array();
        $conditions[Enum_sec::S_DIRECCION_TESIS] = array();
        $conditions[Enum_sec::S_MATERIA_EDUCATIVO] = array();
            
        $this->load->model("Expediente_model","exp");
        $data = $this->exp->getECV($this->session->idempleado);
        //pr($data);

        $main_content = $this->load->view('solicitar_evaluacion/solicitar.tpl.php',$data, true);
        //$this->template->setCuerpoModal($this->ventana_modal->carga_modal());
        $this->template->multiligual = TRUE;
        $this->template->setTitle("SECD");
        $this->template->setMainTitle($data["string_value"]["lbl_secd_titulo"]);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate(FALSE,'template/sipimss/index.tpl.php');
    }
    
    function request(){
        $data_post = $this->input->post();
        //$data_post = array(2,3,4,5);
        $this->load->model("Solicitud_model","sol");
        $save = $this->sol->add_solicitud($this->session->idempleado,$data_post);


        $response['message'] = "Hello world".$save;
        $response['result'] = "true";
        $response["content"] = $data_post;
        echo json_encode($response);
        return 0;
    }

    /*
Mejora de menus... LEAS
    private function obtener_secciones_evaluacion($string_text = array(), $name_controlador = 'controlador_validacion') {
       $secciones = $this->config->item('secciones');
       $result_array = array();
       foreach ($secciones as $value) {
           $prop = $this->config->item('secciones_cont_val_solicitud_eval')[$value['acronimo']];
           if ($prop['isActivo']) {
               $controlador['ruta'] = $prop['seccion'];
               $controlador['ruta_padre'] = $prop[$name_controlador];
//                pr('lbl_'.$value['acronimo'].'_titulo');
               $controlador['nombre_modulo'] = $string_text['lbl_'.$value['acronimo'].'_titulo'];
               $result_array[] = $controlador;
           }
       }
//        pr($result_array);
       return $result_array;
   }*/
}