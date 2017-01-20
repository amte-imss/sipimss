<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona EL DASHBOARD
 * @version 	: 1.0.0
 * @autor 		: Pablo José D.
 */
class Pruebas extends CI_Controller {

    /**
     * Carga de clases para el acceso a base de datos y obtencion de las variables de session
     * @access 		: public
     */
    public function __construct() {
        parent::__construct();
//        $this->load->model('Bitacora_model', 'bitacora');
        $this->load->model('Login_model', 'lm');
//        $this->load->library('enum_privilegios_conf');
//        $this->load->library('enum_estados_empleado');
        $this->config->load('general');
//        $this->input->server();

        $this->load->model('Catalogos_generales', 'cg');
        $this->load->model('Actividad_docente_model', 'adm');
        $this->load->model('Investigacion_docente_model', 'idm');
    }

    public function index() {
        $pr = $this->idm->get_datos_investigacion_docente(2);
        if(!empty($pr[0]['cita_publicada'])){
            $pr[0]['comprobante_cve'] = 0;
            $pr[0]['texto_cita'] = 'text_con_cita';
        }else{
            $pr[0]['texto_cita'] = 'text_sin_cita';
        }
        pr($pr);
        
//        $resul_delete = $this->cg->delete_comprobante($datos_registro['comprobante_cve']);
//        $data = array();
//        $data = carga_catalogos_generales(array('comprobante'), $data, array ('comprobante'=>array('COMPROBANTE_CVE = ' => '81')), FALSE);
//        
//        $data = $this->cg->get_comprobante(81);
//        if (!empty($data)) {
//            $data = $data[0];
//        }
//        pr($data);
    }

    private function generar_propiedades_permisos($roles, $modulos_extra) {
        $existe_mod_extra = isset($modulos_extra) and is_null($modulos_extra) and empty($modulos_extra);
        $array_result = array();
        if (isset($roles) and ! is_null($roles) and ! empty($roles)) {//Debe existir rol
            if ($existe_mod_extra) {//Si existen roles extra (usuario-módulo)
                $array_result = $this->evaluar_rol_con_modulos($roles, $modulos_extra);
//            pr($this->evaluar_rol($roles));
            } else {//Evalua unicamente la tabla de usuario - rol
                $array_result = $this->evaluar_rol($roles);
            }
        }
        return $array_result;
    }

    private function evaluar_rol_con_modulos($roles, $modulos_extra) {
        $roles_modu = $this->evaluar_rol($roles);
        $usuario_modulos = crear_formato_array($modulos_extra, 'cve_modulo', TRUE);
        $array_keys_rol = array_keys($roles_modu); //Obtiene las llaves del arreglo de roles
        //Número de iteracciones según la cantidad de registros de 
        for ($j = 0; $j < count($roles_modu); $j++) {
            $key = $array_keys_rol[$j]; //primera llave 
            $value = $roles_modu[$key]; //valor correspondiente (array de modulos)
            $array_keys_m_ex = array_keys($usuario_modulos); //Obtiene las llaves del arreglo de modulos
            for ($k = 0; $k < count($usuario_modulos); $k++) {
                $keyp = $array_keys_m_ex[$k];
                if (array_key_exists($keyp, $value)) {//Verifica que exista el modulo en el array
                    //Verifica que no tenga acceso, para quitarlo
                    if (!$usuario_modulos[$keyp]['acceso_modulo']) {
                        unset($roles_modu[$key][$keyp]); //Quita valor
                    }
                } else {
                    if ($usuario_modulos[$keyp]['acceso_modulo']) {
                        $roles_modu[$key][$keyp] = $usuario_modulos[$keyp];
                    }
                }
            }
        }

        return $roles_modu;
    }

    private function evaluar_rol($roles) {
        $roles_formato = crear_formato_array($roles, 'cve_rol', FALSE);
        foreach ($roles_formato as $key => $value) {
//            $thiscrear_formato_modulos($value);
            $modulos_formatos = crear_formato_array($value, 'cve_modulo', TRUE);
//            pr($modulos_formatos);
            $roles_formato[$key] = $modulos_formatos;
        }
        return $roles_formato;
    }

    function get_real_ip() {

        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

}
