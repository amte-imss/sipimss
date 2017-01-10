<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el cambio de contraseña
 * @version 	: 1.0.0
 * @autor 		: Pablo José D.J.
 */
class Account extends MY_Controller {

    /**
     * Class Constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('form_complete');
        $this->load->library('seguridad');
        $this->load->model('Account_model', 'modAccount');
        $this->load->library('Ventana_modal');
        $this->load->config('general');
        $this->config->load('general');
        $this->lang->load('interface', 'spanish');
    }

    /**
     * Método que visualiza el inicio del cambio de contraseña
     * @autor       : Pablo José D.J.
     * @modified    :
     * @access      : public
     */
    public function begin_password_reset() {
        $string_values = $this->lang->line('interface')['password_reset'];
        $data_reset_password['string_values'] = $string_values;

        $main_contet_success = '';

        if ($this->input->post()) { //Validar que la información se haya enviado por método POST para almacenado
            $this->config->load('form_validation'); //Cargar archivo con validaciones
            $validations = $this->config->item('form_begin_password_reset'); //Obtener validaciones de archivo
//            pr(random_code_generate());
//            $post = $this->input->post(null, true);

            $this->form_validation->set_rules($validations);

            if ($this->form_validation->run()) {
                $data_form = $this->input->post(null, true);
                
                $usuario_cve_result = $this->modAccount->get_exist_email($data_form['matricula'], $data_form['correo_electronico']);
                if ($usuario_cve_result['result'] == 1) {
                    $usuario_cve = $usuario_cve_result['data']['USUARIO_CVE'];
                    $data_for_reset = array(
                        'REC_CON_CODIGO' => random_code_generate(),
                        'REC_CON_FCH' => date("Y-m-d H:i:s"),
                        'REC_CON_ESTADO' => 0,
                        'USUARIO_CVE' => $usuario_cve
                    );

                    $reseted_pass = $this->modAccount->insert_password_reset($data_for_reset);

                    if ($reseted_pass > -1) {
                        $data_reset_password = $data_for_reset;
                        $string_to_token = $usuario_cve . $usuario_cve_result['data']['USU_MATRICULA'];
                        $data_reset_password['token'] = $this->seguridad->encrypt_sha512($string_to_token);

                        $main_contet_success = $this->load->view('template/email/enviar_correo_recuperar_contrasenia', $data_reset_password, true);
                    }
                } else {
                    $data_reset_password['error_model'] = $data_reset_password['string_values']['msg_no_user_exists'];
                }
            }
        }

        if (!empty($main_contet_success)) {
            $main_contet = $main_contet_success;
        } else {
            $main_contet = $this->load->view('login/reset_password/begin_reset_password', $data_reset_password, true);
        }

        $this->template->setMainContent($main_contet);
//        $this->template->getTemplate(false, 'template/sipimss/index_no_menu.tpl.php');
        $this->template->getTemplate();
    }

    /**
     * Método que visualiza el final del cambio de contraseña
     * @autor       : Pablo José D.J.
     * @modified    :
     * @access      : public
     */
    public function middle_password_reset($token_activate_middle = null) {
        if (isset($token_activate_middle) && !empty($token_activate_middle)) {

            $main_contet = '';
            $string_values = $this->lang->line('interface')['password_reset'];
            $data_reset_password['string_values'] = $string_values;
            $data_reset_password['token_activate_middle'] = $token_activate_middle;

            $activate_token = $this->modAccount->get_exist_token($data_reset_password['token_activate_middle']);

            if ($activate_token['result'] == 1) {

                $data_change_pass = $activate_token['data'];

                $params = array(
                    'USUARIO_CVE' => $data_change_pass['USUARIO_CVE']
                );

                $find_row_change_pass = $this->modAccount->get_exist_code_password_reset($params);

                if ($find_row_change_pass['result'] == 1) {
                    $data_code_generated = $find_row_change_pass['data'];
                    if ($data_code_generated['REC_CON_FCH'] != 1) {

                        $is_on_time = $this->compareDateCodeGenerated($data_code_generated['REC_CON_FCH']);

                        if ($is_on_time['active'] == 1) {
                            $main_contet = $this->load->view('login/reset_password/middle_password_reset', $data_reset_password, true);
                        } else {
                            $data_reset_password['error_code_end_time'] = $string_values['msg_error_end_time_change_pass'];
                            $main_contet = $this->load->view('login/reset_password/reset_password_msg', $data_reset_password, true);
                        }
                    } else {
                        $data_reset_password['error_code_end_time'] = $string_values['msg_error_code_rec_used'];
                        $main_contet = $this->load->view('login/reset_password/reset_password_msg', $data_reset_password, true);
                    }
                }
            } else {
                //pr($activate_token);
                $data_reset_password['error_token_url'] = $string_values['msg_error_no_token_exists'];
                $main_contet = $this->load->view('login/reset_password/reset_password_msg', $data_reset_password, true);
            }

            $this->template->setMainContent($main_contet);
            $this->template->getTemplate(false, 'template/sipimss/index_no_menu.tpl.php');
//            $this->template->getTemplate();
        } else {
            redirect(site_url());
        }
    }

    /**
     * Método que visualiza el final del cambio de contraseña
     * @autor       : Pablo José D.J.
     * @modified    :
     * @access      : public
     */
    public function ajax_middle_pass($token_activate_middle = null) {
        if ($this->input->is_ajax_request()) {
            if (!is_null($this->input->post())) { //Validar que la información se haya enviado por método POST para almacenado
                //pr($this->input->post());
                $string_values = $this->lang->line('interface')['password_reset'];
                $data_reset_password['string_values'] = $string_values;
                $data_reset_password['token_activate_middle'] = $token_activate_middle;
                $this->config->load('form_validation'); //Cargar archivo con validaciones
                $validations = $this->config->item('form_middle_password_reset'); //Obtener validaciones de archivo

                $this->form_validation->set_rules($validations);

                if ($this->form_validation->run()) {
                    $data_form_middle = $this->input->post(null, true);
                    $params_usu = array(
                        'USU_MATRICULA' => $data_form_middle['matricula']
                    );

                    $data_usu = $this->modAccount->get_user_data($params_usu);

                    if ($data_usu['result'] == 1) {
                        $params_cod_rec = array(
                            'REC_CON_CODIGO' => $data_form_middle['codigo_recuperacion'],
                            'USUARIO_CVE' => $data_usu['data']['USUARIO_CVE']
                        );

                        $update_code_reset = $this->modAccount->get_exist_code_password_reset($params_cod_rec);

                        if ($update_code_reset['result'] == 1) {
                            $data_open_form_pass = $update_code_reset['data'];

                            if ($data_open_form_pass['REC_CON_ESTADO'] != 1) {

                                $is_on_time = $this->compareDateCodeGenerated($data_open_form_pass['REC_CON_FCH']);

                                if ($is_on_time['active'] == 1) {
                                    $data_reset_password['step_success'] = $string_values['msg_success_ultimate_step'];
                                    echo $this->load->view('login/reset_password/form_endup_password_reset', $data_reset_password, true);
                                } else {
                                    $data_reset_password['error_code_end_time'] = $string_values['msg_error_end_time_change_pass'];
                                    echo $this->load->view('login/reset_password/reset_password_msg', $data_reset_password, true);
                                }
                            } else {
                                $data_reset_password['error_code_end_time'] = $string_values['msg_error_code_rec_used'];
                                $main_contet = $this->load->view('login/reset_password/reset_password_msg', $data_reset_password, true);
                            }
                        } else {
                            // el codigo introducido no coincide con la matricula introducida
                            $data_reset_password['error_model'] = $string_values['msg_error_no_mat_on_cod_rec'];
                            echo $this->load->view('login/reset_password/form_middle_password_reset', $data_reset_password, true);
                        }
                    } else {
                        // la matrícula introducida no existe
                        $data_reset_password['error_model'] = $string_values['msg_error_no_mat_exists'];
                        echo $this->load->view('login/reset_password/form_middle_password_reset', $data_reset_password, true);
                    }
                } else {
                    echo $this->load->view('login/reset_password/form_middle_password_reset', $data_reset_password, true);
                }

                //echo 'This is in POST';
            } else {
                //echo 'This is no POST';
            }
        } else {
            redirect(site_url());
        }
    }

    /**
     * Método que visualiza el final del cambio de contraseña
     * @autor       : Pablo José D.J.
     * @modified    :
     * @access      : public
     */
    public function endup_password_reset($token_activate_middle = null) {
        if ($this->input->is_ajax_request()) {

            if (!is_null($this->input->post())) { //Validar que la información se haya enviado por método POST para almacenado
                //pr($token_activate_middle);
                $string_values = $this->lang->line('interface')['password_reset'];
                $data_reset_password['string_values'] = $string_values;
                $data_reset_password['token_activate_middle'] = $token_activate_middle;
                $this->config->load('form_validation'); //Cargar archivo con validaciones
                $validations = $this->config->item('form_endup_password_reset'); //Obtener validaciones de archivo

                $this->form_validation->set_rules($validations);

                if ($this->form_validation->run()) {
                    $data_form_middle = $this->input->post(null, true);
                    $params_usu = array(
                        'USU_MATRICULA' => $data_form_middle['matricula']
                    );

                    $data_usu = $this->modAccount->get_user_data($params_usu);

                    if ($data_usu['result'] == 1) {   // ci¿onfirmamos si existe información de la matrpicula
                        $activate_token = $this->modAccount->get_exist_token($data_reset_password['token_activate_middle']); // consultamos el token de la url                        

                        if ($activate_token['result'] == 1) { // si si existe informacion del token
                            //si la matricula coincide con la información del token
                            if ($data_form_middle['matricula'] == $activate_token['data']['USU_MATRICULA']) {
                                $params_cod_rec = array(
                                    'USUARIO_CVE' => $data_usu['data']['USUARIO_CVE']
                                );

                                $update_code_reset = $this->modAccount->get_exist_code_password_reset($params_cod_rec);
                                //pr($update_code_reset);
                                //exit();

                                if (isset($update_code_reset['data']['REC_CON_ESTADO']) && $update_code_reset['data']['REC_CON_ESTADO'] == 0) {

                                    $is_on_time = $this->compareDateCodeGenerated($update_code_reset['data']['REC_CON_FCH']);

                                    if ($is_on_time['active'] == 1) {
                                        $params_reseted = array(
                                            'USUARIO_CVE' => $data_usu['data']['USUARIO_CVE'],
                                            'USU_MATRICULA' => $data_usu['data']['USU_MATRICULA'],
                                            'REC_CON_CVE' => $update_code_reset['data']['REC_CON_CVE'],
                                            'USU_CONTRASENIA' => contrasenia_formato($data_form_middle['matricula'], $data_form_middle['nueva_contrasenia'])
                                        );

                                        //pr($params_reseted);

                                        $password_reseted_commit = $this->modAccount->reset_password_commit($params_reseted);

                                        // falta validar (no permitir registrar nueva solicitud de recuperacion de contraseña si una esta activa)
                                        // falta hacer esta vista
                                        $data_reset_password['endup_success'] = $string_values['msg_endup_success'] . $string_values['btn_endup_success'];
                                        echo $this->load->view('login/reset_password/reset_password_msg', $data_reset_password, true);

                                        echo $this->load->view('template/email/enviar_correo_rec_contrasenia_exitoso', $data_reset_password, true);
                                    } else {
                                        $data_reset_password['error_code_end_time'] = $string_values['msg_error_end_time_change_pass'];
                                        echo $this->load->view('login/reset_password/reset_password_msg', $data_reset_password, true);
                                    }
                                } else {
                                    $data_reset_password['error_code_end_time'] = $string_values['msg_error_code_rec_used'];
                                    $main_contet = $this->load->view('login/reset_password/reset_password_msg', $data_reset_password, true);
                                }
                            } else {
                                // la matricula que intentanta recuperar la contraseña no coincide con el token generado
                            }
                        } else {
                            //pr($token_activate_middle);
                            //pr($data_reset_password);
                            // el codigo introducido no coincide con la matricula introducida
                            $data_reset_password['error_model'] = $string_values['msg_error_no_mat_on_token'];
                            echo $this->load->view('login/reset_password/form_endup_password_reset', $data_reset_password, true);
                        }
                    } else {
                        // la matrícula introducida no existe
                        $data_reset_password['error_model'] = $string_values['msg_error_no_mat_exists'];
                        echo $this->load->view('login/reset_password/form_endup_password_reset', $data_reset_password, true);
                    }
                } else {
                    echo $this->load->view('login/reset_password/form_endup_password_reset', $data_reset_password, true);
                }

                //echo 'This is in POST';
            } else {
                //echo 'This is no POST';
            }
        } else {
            redirect(site_url());
        }
    }

    /**
     * Método que compara el tiempo en que se genero el token de cambio de contraseña y permite o no seguir con el cambio (se desactiva en 10 minutos el cambio de contraseña)
     * @autor       : Pablo José D.J.
     * @modified    :
     * @access      : private
     */
    private function compareDateCodeGenerated($date_time_code_generate_active = null) {
        $result = array('active' => 0);

        $endup_date_time_change = strtotime("+1440 minutes", strtotime($date_time_code_generate_active));
        $today_date_time = date("Y-m-d H:i:s");

        if (strtotime($today_date_time) < $endup_date_time_change) {
            $result['active'] = 1;
        }

        return $result;
    }

    /**
     * Método que envia el correo para el cambio de contraseña
     * @autor       : Pablo José D.J.
     * @modified    :
     * @access      : private
     */
    private function useMailSendLinkChangePassword($params = array()) {
        
    }

    /**
     * Método que envia el correo para confirmar que el cambio de contraseña fue exitoso
     * @autor       : Pablo José D.J.
     * @modified    :
     * @access      : private
     */
    private function useMailConfirmChangePassword($params = array()) {
        
    }

    /**
     * Método que envia los correos recibiendo los parametros necesarios para el envio
     * @autor       : Pablo José D.J.
     * @modified    :
     * @access      : private
     */
    private function sendMailChangePassword($params = array()) {
        
    }

    public function pre_dictamen_example() {
        $this->load->helper(array('dompdf'));
        $html = $this->load->view('dictamen/formatos/dictamen_formato.php', null, true);

        $nombre_archivo = "Dictamen_" . date("d-m-Y_h-i-s");

        generarPdf($html, $nombre_archivo);
    }

}
