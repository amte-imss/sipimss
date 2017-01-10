<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 		: Jesús Díaz P. & Pablo José
 */
class Login extends CI_Controller {

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access 		: public
     * * @modified 	: 
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->helper(array('form', 'captcha'));
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        //$this->load->library('Bitacora');
        $this->load->model('Login_model', 'lm');
    }

    public function index() {
        $this->config->load('form_validation');
        $error = "";
        $data = array();
        $this->lang->load('interface', 'spanish');
        $string_values = $this->lang->line('interface');
        //$this->lm->pblInsertAdm808(); //inserta un administrador

        if ($this->input->post()) {
            $token_html = $this->input->post('token', true); //Obtenemos token oculto en html y se aplica filtro XSS
            $token_session = $this->session->userdata('token'); //Obtenemos token almacenado en sesión
            $validations = $this->config->item('inicio_sesion'); //Obtener validaciones almacenadas en archivo
            $this->form_validation->set_rules($validations);
            //Carga herramientas de mensajes de texto al usuario 
            $tipo_msg = $this->config->item('alert_msg');

            if (($this->form_validation->run() == true) && ($token_html == $token_session)) { //Aplicamos validaciones a la matrícula, contraseña, captcha; además se verifica que el token obtenido por el formulario sea el mismo que el que se encuentra en sesión
                $matricula = $this->input->post('matricula', true);
                $passwd = $this->input->post('passwd', true);
                //if($this->input->post('btn_login', true) == "Login"){

//                $login_user = $this->lm->set_login_user($matricula, $passwd); ///Verificar contra base de datos
//                pr('id---->' . $login_user->cantidad_reg);
                $resultado = iniciar_sesion($matricula, $passwd);//Valida sesión correcta
                if ($resultado['login']->cantidad_reg == 1) { ///Usuario existe en base de datos
                    if (!$this->checkbrute($matricula)) { //Verificamos que no exista ataque de fuerza bruta
//                            pr('inicia sesión');
                        //pr($check_user);
                        if ($resultado['success']===1) {//Passwor correcto
//                            generar_propiedades_permisos()

                            $this->session->set_userdata($resultado['datos_session']); ///Si es correcto iniciamos sesión
                            $this->session->unset_userdata('token'); //Eliminar token
                            //Ejecuta el log del usuario
//                            $this->config->load('general');


//                            $parametros_log = $this->config->item('parametros_log');
//                            $parametros_log['INICIO_SATISFACTORIO'] = 1;
//                            $parametros_log['USUARIO_CVE'] = $login_user->user_cve;
//                            $resultado = $this->lm->set_log_ususario_doc($parametros_log);
                            //$this->bitacora->bitacora_login_insertar($check_user['data']->usr_matricula); //Registrar inicio de sesión correcto
                            redirect('rol/index');
//                            redirect('dashboard');
                            exit();
                        } else { ///Insertar intento fallido
//                            $this->lm->intento_fallido($matricula);
                            $error = $string_values['login']['er_general'];
                        }
                    } else { //Cuenta bloqueda por el periodo de tiempo especificado en método checkbrute
                        $error = $string_values['login']['er_general'];
                    }
                } else {
                    if ($resultado['login']->cantidad_reg == 0) {
                        //La matrícula es incorrecta (no existe en el sistema)
                        $error = $string_values['login']['er_no_usuario'];
                    } else {
                        //si "$login_user->cantidad_reg" = -1, el usuario existe pero el password es incorrecto 
                        $this->config->load('general');
                        $parametros_log = $this->config->item('parametros_log');
                        $parametros_log['USUARIO_CVE'] = $resultado['login']->user_cve;
                        $parametros_log['INICIO_SATISFACTORIO'] = 0;
                        $resultado = $this->lm->set_log_ususario_doc($parametros_log); //ejecuta procedimiento almacenado de lo
                        $error = $string_values['login']['er_contrasenia_incorrecta'];
                    }
                }
            } else {
                $this->session->unset_userdata('token'); //Eliminar token
            }
            if (isset($error) && !empty($error)) {
                $tipo_msg_string = $tipo_msg['DANGER']['class'];
                $data['error'] = $error;
                $data['tipo_msg'] = $tipo_msg_string;
            }
        }
        $data['string_values'] = $string_values;
        $this->token(); //Crear un token cada vez que se ingresa al formulario de inicio sesión
        //$this->template->setMainContent($this->formulario($data));
        //$this->template->getTemplate();
        echo $this->formulario($data,"login/login.php");
    }

    function seleccionar_rol() {
        $lista_roles = $this->session->userdata('lista_roles');
        $lista_roles_modulos = $this->session->userdata('lista_roles_modulos');
//        $this->session->userdata('rol_seleccionado') = $this->get_array_valor($lista_roles_modulos, 1);
        $rol_seleccionado = get_array_valor($lista_roles_modulos, 3);
        $this->session->set_userdata('rol_seleccionado', $rol_seleccionado);
//        pr($this->session->userdata('rol_seleccionado'));
//        $data['rol_seleccionado'] = $rol_seleccionado;
        $data['lista_roles'] = $lista_roles;
        $view_ = $this->load->view('login/Selection_role_tpl', $data, TRUE);
        $this->template->setMainContent($view_);
        //$this->template->setMainContent($imprime);*/
        $this->template->getTemplate();
    }

    private function generar_propiedades_permisos($roles, $modulos_extra) {
        $existe_mod_extra = isset($modulos_extra) and is_null($modulos_extra) and empty($modulos_extra);
        $array_result = array();
        if (isset($roles) and !is_null($roles) and !empty($roles)) {//Debe existir rol
            if ($existe_mod_extra) {//Si existen roles extra (usuario-módulo)
                $array_result = $this->evaluar_rol_con_modulos($roles, $modulos_extra);
//            pr($this->evaluar_rol($roles));
            } else {//Evalua unicamente la tabla de usuario - rol
                $array_result = $this->evaluar_rol($roles);
            }
        }
        return $array_result;
    }

    private function checkbrute($matricula) {
//        $ahora = time(); ///Tiempo actual

        $lapso_intentos = $this->config->item('tiempo_fuerza_bruta');
        $intentos_default_fuerza_bruta = $this->config->item('intentos_fuerza_bruta');
        $numero_intentos_usuario = $this->lm->set_checkbrute_usuario(intval($matricula), intval($lapso_intentos));
//        $numero_intentos_usuario = 1;
        if ($numero_intentos_usuario > $intentos_default_fuerza_bruta) {
            return true;
        } else {
            return false;
        }
    }

    private function formulario($data = array(),$tpl = "login/formulario",$return=TRUE) {
        $data['captcha'] = create_captcha($this->captcha_config());
        $this->session->set_userdata('captchaWord', $data['captcha']['word']);
        //echo $data['token'] = $this->session->userdata('token'); //Se envia token al formulario
        $form_login = $this->load->view($tpl, $data, $return);
        return $form_login;
    }

    private function token() {
        $token = md5(uniqid(rand(), TRUE));
        $this->session->set_userdata('token', $token);
        return;
    }

    public function cerrar_session() {
        //session_destroy();
        $this->session->sess_destroy();
        redirect('login');
        exit();
    }

    public function cerrar_session_ajax() {
        echo "<script>alert('Sesión finalizada'); document.location.href='" . site_url("login") . "';</script>";
    }

    private function captcha_config() {
        $params = array(
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            'img_width' => 220,
            'img_height' => 50,
            'word_length' => 5,
            'expiration' => 7200,
            'font_size' => array(30, true),
            'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors' => array(
                'background' => array(76, 175, 80),
                'border' => array(165, 214, 167),
                'text' => array(0, 0, 0),
                'grid' => array(232, 245, 233)
            )
        );
        return $params;
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

}
