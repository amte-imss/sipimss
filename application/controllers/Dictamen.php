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
        $this->load->model('Perfil_model', 'modPerfil');
        $this->load->helper('date');
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
            $campoBuscar = "";
            $parametro = "";
            $nombre = $this->input->post('nombreDocente');
            $matricula = $this->input->post('matriculaDocente');
            if( !empty($nombre) ){
                $campoBuscar = "empleado.EMP_NOMBRE";
                $parametro = $nombre;
            }
            if( !empty($matricula) ){
                $campoBuscar = "empleado.emp_matricula";
                $parametro = $matricula;
            }
            // La busqueda de resultados puede ser por nombre o matrucula (excluyente).
            $this->load->model('Dictamen_model', 'dm');
            $data['tableResultset'] = $this->dm->tablaDictamen($this->session->userdata('idempleado'), $campoBuscar, $parametro);
            $this->load->view('dictamen/tablaDictamenes', $data);
        }else{
            // Error 404
        }
    }
    
    // Busca los datos generales de un docente
    public function datosGenerales(){
        $id = $this->input->post('id');
        $empleadoData = $this->modPerfil->getEmpleadoData($id, 'EM.EMP_MATRICULA');
        $datosPerfil = array();
        if (count($empleadoData)) {
            foreach ($empleadoData['0'] as $key => $value) {
                $datosPerfil[$key] = $value;
            }
        }
        if ($this->input->is_ajax_request()){
            echo json_encode($datosPerfil);
        }else{
            return $datosPerfil;
        }
    }
    
    // Imprime el formato del dictamen con los puntos obtenidos, para dictaminar y agregar observaciones.
    public function dictamenFormato(){
        $cat_dictamenes = $this->cg->get_cat_dictamen_result();
        $data['empleadoCve'] = $this->input->post('hddempleadoCve');
        $data['solicEvalCve'] = $this->input->post('hddSolicCve');
        $empleadoData = $this->modPerfil->getEmpleadoData($data['empleadoCve'] , 'EM.EMPLEADO_CVE');
        $data['catalogo'] = $cat_dictamenes;
        $data['empleado'] = $empleadoData[0];
        $main_content = $this->load->view('dictamen/formatos/dictamen_formato_online', $data , true);
        $this->template->multiligual = TRUE;
        $this->template->setTitle("Dictamenes");
        $this->template->setCuerpoModal($this->ventana_modal->carga_modal());
        $this->template->setMainContent($main_content);
        $this->template->getTemplate(FALSE, 'template/sipimss/index.tpl.php');
    }
    
    // Genera pdf con el dictamen de docente.
    public function dictamen_pdf()
    {
        $this->load->helper(array('dompdf'));
        $html = $this->load->view('dictamen/formatos/dictamen_formato.php',null,true);
        $nombre_archivo = "Dictamen_".date("d-m-Y_h-i-s");
        generarPdf($html, $nombre_archivo);
    }
    
    // Se guardan los datos del dictaminado.
//    guardaDictamen($solicEvalCve, $dictamenCve, $estadoCve, $empleadoCve, $mensaje )
    public function dictamina(){
        $this->load->model('Dictamen_model', 'dm');
        $solicCve = $this->input->post('hddSolicCve');
        $empleadoCve = $this->input->post('hddempleadoCve');
        $estadoCve = "3"; // <- estado  aprobado 
        $observaciones = $this->input->post('txtObservaciones');
        $dictamenCatCve = $this->input->post('slcCatDictamen');
        $this->dm->guardaDictamen($solicCve, $dictamenCatCve, $estadoCve, $empleadoCve, $observaciones );
        $this->index();
    }
    
    // Se guarda el motivo de la correción de los datos.
    public function correcion(){
        $this->load->model('Dictamen_model', 'dm');
        $solicCve = $this->input->post('hddSolicCveCorrecion');
        $empleadoCve = $this->input->post('hddempleadoCveCorrecion');
        $estadoCve = "4";

        $observaciones = $this->input->post('txtMotivosCorrecion');
        $motivo = $this->input->post('txtMotivosCorrecion');
        $this->dm->correcionDictamen($solicCve,  $estadoCve, $empleadoCve, $observaciones );
        $this->index();
    }
    
}