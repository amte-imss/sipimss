<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene métodos para registro de participantes en talleres
 * @version 	: 1.0.0
 * @author      : Pablo José
 * */
class Rol extends MY_Controller {

    private $estado_taller;

    /*     * *********Costructor
     * Función inicial que atrae los atributos de libreria captcha_becas, form_validation y form_complete
     */

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('form_complete');
        $this->load->library('seguridad');
        $this->load->library('empleados_siap');
        $this->load->model('Registro_model', 'mod_registro');
        $this->load->config('general');
        $this->config->load('general');
        $this->load->model('Login_model', 'lm');
        //$this->lang->load('interface');
    }

    /*     * *********Registro de participantes
     * Función que determina el tipo de usuario y lo dirige a su página de bienvenida
     * @method: void index()
     * @author: Pablo José J.
     */

    public function index() {
        $data = array();
        if ($this->input->get()) { //Validar que la información se haya enviado por método POST para almacenado
            //Carga herramientpostas de mensajes de texto al usuario 
            $this->lang->load('interface', 'spanish');
            $mensajes = $this->lang->line('interface');
            $tipo_msg = $this->config->item('alert_msg');
            $value_rol_cve = $this->input->get('seleciion_role', TRUE);
            $this->limpiar_datos_temp_variable_sesion();
//            pr($value);
            if (empty($value_rol_cve)) {
                //Mostrar mensaje de advertencia para seleccionar un rol
                $this->session->set_userdata('rol_seleccionado', array());
                $data['error'] = $mensajes['rol']['lbl_selecciona_rol'];
                $data['tipo_msg'] = $tipo_msg['WARNING']['class'];
            } else {
                //Cargar controlador
                $lista_roles_modulos = $this->session->userdata('lista_roles_modulos'); //Módulos de acceso del usuario

                $rol_seleccionado = get_array_valor($lista_roles_modulos, $value_rol_cve);
                if (!empty($rol_seleccionado)) {

                    $nombre_rol = '';
                    foreach ($rol_seleccionado as $value) {//Obtiene nombre del rol
                        $nombre_rol = $value['nombre_rol'];
                        break;
                    }
                    $this->session->set_userdata('rol_seleccionado', $rol_seleccionado);
                    $this->session->set_userdata('rol_seleccionado_cve', intval($value_rol_cve));
                    $this->session->set_userdata('nombre_rol', $nombre_rol);
//                pr($rol_seleccionado);
//                exit();
                    switch ($value_rol_cve) {
                        case 1:
                            redirect('perfil');
                        break;
                        case 2:
                            redirect('validacion_censo_profesores');
//                        redirect('evaluacion_curricular_validar');
//                        redirect('validacion_censo_profesores');
                        break;
                        case 3:
//                        redirect('evaluacion_curricular_validar');
                            redirect('validacion_censo_profesores');
                        break;
                        case 5:
                            redirect('designar_validador');
                        break;
                        case 4:
                            redirect('catalogo');
                        break;
                        case 6:
                        case 7:
                            redirect('dictamen');
                        break;
                        case 14:
//                        redirect('evaluacion_curricular_validar');
                            redirect('validacion_censo_profesores');
                        break;
                        case Enum_rols::Vocal:
                            redirect('evaluacion_docente');
                    }
                    exit();
                }
            }
        }
//        pr($this->session->userdata('rol_seleccionado'));

//        $lista_roles = $this->session->userdata('lista_roles');
//        $data['lista_roles'] = $lista_roles;
//        $main_contet = $this->load->view('login/Selection_role_tpl', $data, true);
//        $this->template->setMainContent($main_contet);
//        $this->template->getTemplate();
        $this->template->getTemplate(FALSE, 'template/sipimss/index.tpl.php');
    }

    private function limpiar_datos_temp_variable_sesion() {
        /* Limpiar información de validación censo
         * Limpiar rol_seleccionado
         * Limpiar rol_seleccionado_cve
         * Limpiar convocatoria_delegacion
         * Limpiar datos_validador
         * Limpiar datosvalidadoactual
         * 
         */
        $variables = array('rol_seleccionado', 'rol_seleccionado_cve', 'convocatoria_delegacion',
            'datos_validador', 'datosvalidadoactual', 'nombre_rol', 'ctr_solicitante', 
            'seccion_validacion_obligatoria', 'is_interseccion');
        foreach ($variables as $value) {
            $this->session->unset_userdata($value);
        }
    }

}
