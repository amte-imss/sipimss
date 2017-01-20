<?php
/**
 * Description of Dictamen
 *
 * @author D.Pérez
 * @fecha 04-10-2016
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//class Dictamen extends MY_Controller {
class Dictamen extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('empleados_siap');
        $this->load->library('Ventana_modal');
        $this->load->config('general');
        $this->load->library('form_validation');
        $this->load->library('seguridad');
//        $this->load->library('Ventana_modal');

        $this->load->model('Evaluacion_curricular_validar_model', 'ecvm');
        //*****Datos perfil 
        $this->load->model('Catalogos_generales', 'cg');
        $this->load->model('Actividad_docente_model', 'adm');
        $this->load->model('Investigacion_docente_model', 'idm');
        $this->load->model('Becas_comisiones_laborales_model', 'bcl');
        $this->load->model('Material_educativo_model', 'mem');
        $this->load->model('Perfil_model', 'modPerfil');
        $this->load->helper('date');

        //$_SESSION['datosvalidadoactual']['validacion_cve'] = 2;
        //pr($_SESSION);
    }
    
    // Muestra solo el formulario
    public function index(){
        $main_content = $this->load->view('dictamen/dictamenesFormBuscar', '', true);
        $this->template->multiligual = TRUE;
        $this->template->setTitle("Dictamenes");
        $this->template->setCuerpoModal($this->ventana_modal->carga_modal());
        $this->template->setMainContent($main_content);
        $this->template->getTemplate(FALSE, 'template/sipimss/index.tpl.php');
    }
    
    // Obtiene la tabla con los dictaminados 
    public function buscarDictamenes(){
        if ($this->input->is_ajax_request()){
            $this->load->view('dictamen/tablaDictamenes');
        }else{
            // Error 404
        }
    }
    
    // Busca los datos generales de un docente
    public function datosGenerales(){
        $id = $this->input->post('id');
        $this->load->model('Perfil_model', 'modPerfil');
        $empleadoData = $this->modPerfil->getEmpleadoData($id);
        $datosPerfil = array();
        if (count($empleadoData)) {
            foreach ($empleadoData['0'] as $key => $value) {
                $datosPerfil[$key] = $value;
            }
        }
        if ($this->input->is_ajax_request()){
            echo json_encode($datosPerfil);
        }
    }
    
    
    
    public function dictamenFormato(){
        $main_content = $this->load->view('dictamen/formatos/dictamen_formato_online', "" , true);
        $this->template->multiligual = TRUE;
        $this->template->setTitle("Dictamenes");
        $this->template->setCuerpoModal($this->ventana_modal->carga_modal());
        $this->template->setMainContent($main_content);
        $this->template->getTemplate(FALSE, 'template/sipimss/index.tpl.php');
    }
    
    public function disctamenFormato2(){
        $main_content = $this->load->view('dictamen/formatos/dictamen_formato_online', "" , true);
        echo $main_content;
    }
    
    public function dictamen_pdf()
    {
        $this->load->helper(array('dompdf'));
        $html = $this->load->view('dictamen/formatos/dictamen_formato.php',null,true);
//        echo $html;
        $nombre_archivo = "Dictamen_".date("d-m-Y_h-i-s");
        generarPdf($html, $nombre_archivo);
    }
    
}