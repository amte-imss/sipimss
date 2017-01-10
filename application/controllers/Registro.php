<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene métodos para registro de participantes en talleres
 * @version 	: 1.0.0
 * @author      : Pablo José
 * */
class Registro extends MY_Controller {

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

        $datos_registro = array();
        $this->lang->load('interface', 'spanish');
        $string_values = $this->lang->line('interface');
        $tipo_msg = $this->config->item('alert_msg');
        if ($this->input->post()) { //Validar que la información se haya enviado por método POST para almacenado
            // obtenemos los datos del sistema de personal (SIAP)
            $this->config->load('form_validation'); //Cargar archivo con validaciones
            $validations = $this->config->item('form_registro_docente'); //Obtener validaciones de archivo
            $this->form_validation->set_rules($validations);
            //Se ejecuta la validación de datos
            if ($this->form_validation->run()) { 
                //cargamos el array post en una variable
                $datos_registro = $this->input->post(null, true);                      
                //Verifica que no exista el usuario localmente
                $verifica_existe_user_local = $this->mod_registro->get_existe_usuario(
                    trim($datos_registro['reg_matricula'])
                ); 
                //Si el usuario no exixte localmente, lo debe guardar
                if ($verifica_existe_user_local == 0) {
                    //Valida contraseña
                    if ($datos_registro['reg_contrasenia'] === $datos_registro['reg_confirma_contrasenia']) {
                        // obtenemos los datos del sistema de personal (SIAP)
                        $datos_siap = $this->empleados_siap->buscar_usuario_siap(
                            array("reg_delegacion" => $datos_registro['reg_delegacion'], 
                                  "asp_matricula" => $datos_registro['reg_matricula'])
                        );
                        //si siap esta Vacio
                        if($datos_siap === FALSE){
                            $datos_registro['error'] = str_replace(
                                    '[field]', 
                                    $datos_registro['reg_matricula'], 
                                    $string_values['registro']['phl_la_matricula_no_existe']
                                ); //Remplaza
                            $datos_registro['tipo_msg'] = $tipo_msg['DANGER']['class'];
                        }elseif(is_array($datos_siap) && !empty($datos_siap)) {
                            //Si el usuario que que se quiere registrar no existe en el "SIAP" no se puede registrar
                            //pr($datos_siap);
                            if ($datos_siap['status'] == 1) { //si el status del empleado esta activo (1)
                                $datos_usuario = array();
                                $datos_usuario['USU_MATRICULA'] = $datos_registro['reg_matricula'];
                                // $datos_usuario['DELEGACION_CVE'] = $datos_registro['reg_delegacion'];
                                $datos_usuario['USU_CORREO'] = $datos_registro['reg_correo'];
                                $datos_usuario['USU_CONTRASENIA'] = contrasenia_formato($datos_registro['reg_matricula'], $datos_registro['reg_confirma_contrasenia']); //
                                $datos_usuario['USU_NOMBRE'] = $datos_siap['nombre'];
                                $datos_usuario['USU_PATERNO'] = $datos_siap['paterno'];
                                $datos_usuario['USU_MATERNO'] = $datos_siap['materno'];
                                // $datos_usuario['USU_GENERO'] = $datos_siap['sexo'];
                                // $datos_usuario['USU_CURP'] = $datos_siap['curp'];
                                // $datos_usuario['USU_ANTIGUEDAD'] = $datos_siap['antiguedad'];
                                // $datos_usuario['EDO_LABORAL_CVE'] = $datos_siap['status'];
                                // $datos_usuario['ADSCRIPCION_CVE'] = $datos_siap['adscripcion'];
                                $res_cat = $this->mod_registro->get_categoria($datos_siap['emp_keypue']);
                                $id_cat = (empty($res_cat)) ? 0 : $res_cat[0]['id_cat'];
                                // $datos_usuario['CATEGORIA_CVE'] = $id_cat;
                                // $datos_usuario['ESTADO_USUARIO_CVE'] = 1;
                                // $datos_usuario['USU_FCH_REGISTRO'] = $datos_siap['fecha_ingreso'];
                                $result_id_user = $this->mod_registro->insert_registro_usuario($datos_usuario); //Retorna id usuario
                                if ($result_id_user > -1) {//si el id del usuario es mayor que -1, entonces se inserto correctamente el registro
                                    $verifica_existe_empleado_local = $this->mod_registro->get_existe_empleado($datos_registro['reg_matricula']); //Verifica que no exista el empleado
                                    if ($verifica_existe_empleado_local === -1) {//Si no existe el empleado registrado, lo registra
                                        //Guardar también empleado    
                                        $datos_empleados = array();
                                        $datos_empleados['EMP_NOMBRE'] =  $datos_siap['nombre'];
                                        $datos_empleados['EDO_LABORAL_CVE'] = $datos_siap['status'];
                                        $datos_empleados['EMP_APE_PATERNO'] = $datos_siap['paterno'];
                                        $datos_empleados['EMP_APE_MATERNO'] = $datos_siap['materno'];
                                        $datos_empleados['EMP_ANTIGUEDAD'] = $datos_siap['antiguedad'];
                                        $datos_empleados['EMP_MATRICULA'] = $datos_registro['reg_matricula'];
                                        $datos_empleados['EMP_CURP'] = $datos_siap['curp'];
                                        $datos_empleados['DELEGACION_CVE'] = $datos_siap['delegacion'];
                                        $datos_empleados['CATEGORIA_CVE'] = $id_cat;
                                        $datos_empleados['USUARIO_CVE'] = $result_id_user;
                                        $datos_empleados['ADSCRIPCION_CVE'] = $datos_siap['adscripcion'];
                                        // $datos_empleados['EMP_GENERO'] = $datos_usuario['USU_GENERO'];
                                        $datos_empleados['EMP_EMAIL'] = $datos_registro['reg_correo'];
                                        $result_id_emp = $this->mod_registro->insert_registro_empleado($datos_empleados); //Retorna id usuario
                                    } else {//Si existe el empleado, le asigna el id del usuario
                                        $datos_empleados['USUARIO_CVE'] = $result_id_user;
                                        $where =$datos_registro['reg_matricula'];
                                        $result_id_emp = $this->mod_registro->update_registro_empleado($datos_empleados, $where); //Retorna id usuario
                                        $datos_empleados['EMP_MATRICULA'] = $where;
                                    }
                                    //Asocia rol al usuario
                                    $datos_usuario_rol ['USUARIO_CVE'] = $result_id_user;
                                    $datos_usuario_rol ['ROL_CVE'] = 1;
                                    $result_id_rol_modulo = $this->mod_registro->insert_ususario_rol($datos_usuario_rol); //Retorna id usuario

                                    if (isset($result_id_emp) AND $result_id_emp < 1) {//si el id del empleado es menor que 1, entonces existe un error
                                        $this->session->set_flashdata('error', $string_values['registro']['phl_registro_incorrecto_del_empleado']);
                                        $array_datos_entidad['usuario'] = $datos_usuario;
                                        $array_operacion_id_entidades['usuario'] = array('insert' => $result_id_user); //Registro de usuario 
                                        $id_emp = $result_id_emp;
                                    } else {//Codificamos json con usuario y empleado
                                        $array_datos_entidad['usuario'] = $datos_usuario;
                                        $array_datos_entidad['empleado'] = $datos_empleados;

                                        $array_operacion_id_entidades['usuario'] = array('insert' => $result_id_user); //Registro de usuario 
                                        $ope_emp = ($verifica_existe_empleado_local < 1) ? 'insert' : 'update';
                                        $id_emp = ($verifica_existe_empleado_local < 1) ? $result_id_emp : $verifica_existe_empleado_local; //Obtiene id del registro de la entidad empleado
                                        $array_operacion_id_entidades['empleado'] = array($ope_emp => $id_emp); //Registro de operacion de usuario 
                                    }


                                    $json_datos_entidad = json_encode($array_operacion_id_entidades); //Codifica a json datos de entidad
                                    $json_registro_bitacora = json_encode($array_datos_entidad); //Codifica a json la actualización o insersión a las entidades involucradas
//                                    //Datos de bitacora el registro del usuario
//                                    $parametros = $this->config->item('parametros_bitacora');
//                                    $parametros['USUARIO_CVE'] = $result_id_user; //Asigna id del usuario
////                                    $parametros['BIT_IP'] = $this->get_real_ip();//Le manda la ip del cliente
//                                    $parametros['BIT_RUTA'] = '/registro/';
//                                    $result = $this->lm->set_bitacora($parametros); //Invoca la función para guardar bitacora
                                    registro_bitacora($result_id_user, null, $json_datos_entidad, $result_id_user . ':' . $id_emp, $json_registro_bitacora, null);

                                    //Envia correo electrÓnico de datos de registro
                                    $plantilla = $this->load->view('template/email/enviar_confirmacion.tpl.php', $datos_usuario, true);
                                    $sentMail = $this->enviar_confirmacion_registro_usuario($datos_usuario + array('plantilla' => $plantilla)); //Enviar correo

                                    if (!$sentMail["result"]) {
                                        $this->session->set_flashdata('error', $sentMail['error']);
//                                        $this->session->set_flashdata('success', 'bien');
                                    }
                                    $datos_registro['error'] = $string_values['registro']['phl_registro_correcto'];
                                    $datos_registro['tipo_msg'] = $tipo_msg['SUCCESS']['class'];
                                    $resultado = iniciar_sesion(intval($datos_usuario['USU_MATRICULA']), $datos_registro['reg_confirma_contrasenia']); //Valida sesión correcta
//                                    pr($resultado['login']);
                                    if ($resultado['success'] === 1) {//Passwor correcto
                                        $this->session->set_userdata($resultado['datos_session']); ///Si es correcto iniciamos sesión
                                        $this->session->unset_userdata('token'); //Eliminar token

                                        redirect("rol/index");
                                        exit();
                                    } else {
                                        echo '<script type="text/javascript">
                                    window.setTimeout(function(){ 
                                    }, 3000);
                                    </script>';
                                        redirect("login/");
                                        exit();
                                    }
                                }
                            }//matricula inactiva
                            /*else{
                                $datos_registro['error'] = str_replace('[field]', $datos_registro['reg_matricula'], $string_values['registro']['phl_la_matricula_existe']); //Remplaza
                                $datos_registro['tipo_msg'] = $tipo_msg['DANGER']['class'];
                            }*/
                        } /*else {
                            //Mosttrar mensaje de que no existe el registro en "SIAP"
                            $datos_registro['error'] = str_replace('[field]', $datos_registro['reg_matricula'], $string_values['registro']['phl_la_matricula_existe']); //Remplaza
                            $datos_registro['tipo_msg'] = $tipo_msg['DANGER']['class'];
                        }*/
                    } else {
                        //La contraseña no coinside, verificar  queda pendiente
//                         form_error('reg_contrasenia','La contraseña no coinside');
//                        $this->form_validation->set_message('reg_contrasenia', 'La contraseña no coincide');
                        $datos_registro['error'] = $string_values['registro']['lbl_contrasenia'];
                        $datos_registro['tipo_msg'] = $tipo_msg['DANGER']['class'];
                    }
                } else {
                    //Manda advertencia, el usuario ya existe en el sistema
                    $datos_registro['error'] = str_replace('[field]', $datos_registro['reg_matricula'], $string_values['registro']['phl_la_matricula_existe']); //Remplaza
                    $datos_registro['tipo_msg'] = $tipo_msg['DANGER']['class'];
                }
            }
        }
        /* Carga delegaciones */
        $this->load->model('Catalogos_generales', 'cg');
        $data['delegaciones'] = $this->cg->getDelegaciones(); //Obtiene delegaciones del modelo
        $datos_registro['delegaciones'] = dropdown_options($data['delegaciones'], 'DELEGACION_CVE', 'DEL_NOMBRE'); //Manipulamos la información a mostrar de delegación
        $datos_registro['string_values'] = $string_values;

        //$this->load->view('registro/index', $datos_registro);
        $main_contet = $this->load->view('registro/registro', $datos_registro, true);
        $this->template->setMainContent($main_contet);
//        $this->template->getTemplate(false, 'template/sipimss/index_no_menu.tpl.php');
        $this->template->getTemplate();
    }

    public function imprime_texto_lang() {
        $this->lang->load('interface', 'spanish');
//        pr($this->lang->line('interface'));
        echo "Hola";
    }

    private function enviar_confirmacion_registro_usuario($data) {
        $this->load->library('My_phpmailer');
        $mail = $this->my_phpmailer->phpmailerclass(); //Se cargan datos por default definidos en config/email
        $resultado = array('result' => 1, 'error' => null);
        $mail->addAddress($data['USU_CORREO'], utf8_decode($data['USU_NOMBRE'] . $data['USU_PATERNO'] . $data['USU_MATERNO']));
        $mail->Subject = utf8_decode('Confirmación de registro :: Censo IMSS');
        $mail->msgHTML(utf8_decode($data['plantilla']));
//        pr($mail);
        if (!$mail->send()) { //send the message, check for errors
            $resultado['result'] = 0;
            $resultado['error'] = $mail->ErrorInfo;
        }
        return $resultado;
    }

    /**
     * ********Confirmación de registro
     * Función que cancela el registro al taller
     * @method: void enviar_confirmacion()
     * @author: Pablo José J.
     */
    public function enviar_confirmacion($datos) {
        //$this->load->config('email');
        $this->load->library('My_phpmailer');

        $mail = $this->my_phpmailer->phpmailerclass(); //Se cargan datos por default definidos en config/email

        $resultado = array('result' => false, 'error' => null);

        // $mail->IsSMTP(); // establecemos que utilizaremos SMTP
        // $mail->Host = "172.16.23.18";

        $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
        /* $mail->IsSMTP(); // telling the class to use SMTP
          $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
          // 1 = errors and messages
          // 2 = messages only
          $mail->SMTPAuth   = true;                  // enable SMTP authentication
          $mail->Host       = "smtp.gmail.com"; // sets the SMTP server
          $mail->Port       = 587;                    // set the SMTP port for the GMAIL server
          $mail->Username   = "sied.ad.imss@gmail.com"; // SMTP account username
          $mail->Password   = "s13d.4d.1mss"; */

        $mail->addAddress($datos['usuario']->usr_correo, utf8_decode($datos['usuario']->usr_nombre . ' ' . $datos['usuario']->usr_paterno . ' ' . $datos['usuario']->usr_materno));
        $mail->Subject = utf8_decode('Confirmación de registro :: Talleres IMSS');
        $mail->msgHTML(utf8_decode($datos['plantilla']));
        //$mail->AltBody = 'This is a plain-text message body';
        // $resultado['result'] = true;
        if (!$mail->send()) { //send the message, check for errors
            $resultado['result'] = false;
            $resultado['error'] = $mail->ErrorInfo;
        }
        return $resultado;
    }

    public function confirmacion() {
        $this->template->setTitle("Registro a los talleres de actualización de recursos electrónicos");
        $this->template->setMainContent('<div class="container"><div class="text-right" style="margin-right:50px;"><a href="' . site_url('/registro') . '" class="btn btn-primary">< Ir al registro</a></div><br></div>');
        $this->template->getTemplate();
    }

    private function usuarioFactory($siapData = array(), $formData = array()) {
        $usuario = new UsuarioEntity();
        $usuario->usr_matricula = (isset($siapData['matricula']) && !empty($siapData['matricula'])) ? $siapData['matricula'] : null;
        $usuario->usr_nombre = (isset($siapData['nombre']) && !empty($siapData['nombre'])) ? $siapData['nombre'] : null;
        $usuario->usr_paterno = (isset($siapData['paterno']) && !empty($siapData['paterno'])) ? $siapData['paterno'] : null;
        $usuario->usr_materno = (isset($siapData['materno']) && !empty($siapData['materno'])) ? $siapData['materno'] : null;
        $usuario->usr_correo = (isset($formData['reg_email']) && !empty($formData['reg_email'])) ? $formData['reg_email'] : null;

        return $usuario;
    }

}

class UsuarioEntity {

    public $usr_matricula;
    public $usr_nombre;
    public $usr_paterno;
    public $usr_materno;
    public $usr_correo;
    //
    public $cve_depto_adscripcion;
    public $cve_categoria;
    public $cve_delegacion;

}
