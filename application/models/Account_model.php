<?php   defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }


    /**
     * @author Pablo José D.J. 
     * @fecha creación 18-08-2016 
     * @param type String: $matricula , $correo
     * @return int si el usuario existe devuelve "1" de lo contrario devuelve "0"
     */
    public function get_exist_email($matricula = null, $correo = null) {
        $result = array('result'=>0, 'data'=>null);
        if (is_null($correo) && is_null($matricula)) {
            return $result;
        }
        
        $this->db->where('USU_CORREO', $correo);
        $this->db->where('USU_MATRICULA', $matricula);
        $query = $this->db->get('usuario');
        $cantidad = $query->num_rows();
        if ($cantidad > 0) {
            $result['result'] = 1;
            $result['data'] =  $query->result_array()[0];
            return $result;
        } else {
            return $result;
        }
    
    }

    /**
     * @author Pablo José D.J. 
     * @fecha creación 18-08-2016 
     * @param type String: $matricula , $correo
     * @return int si el usuario existe devuelve "1" de lo contrario devuelve "0"
     */
    public function get_user_data($params = array()) {
        $result = array('result'=>0, 'data'=>null);
        if (is_null($params)) {
            return $result;
        }
        
        $this->db->where($params);
        $query = $this->db->get('usuario');
        $cantidad = $query->num_rows();

        if ($cantidad > 0) {
            $result['result'] = 1;
            $result['data'] =  $query->result_array()[0];
            return $result;
        } else {
            return $result;
        }
    
    }


    /**
     * @author Pablo José D.J. 
     * @fecha creación 18-08-2016 
     * @param type String: $token
     * @return int si el usuario existe devuelve "1" de lo contrario devuelve "0"
     */
    public function get_exist_token($token = null) {
        $result = array('result'=>0, 'data'=>null);
        if (is_null($token)) {
            return $result;
        }
        
        $this->db->where('SHA2(concat(usuario.USUARIO_CVE,usuario.USU_MATRICULA), 512) = ', $token);
        $query = $this->db->get('usuario');
        $cantidad = $query->num_rows();
//        pr($this->db->last_query());
        if ($cantidad > 0) {
            $result['result'] = 1;
            $result['data'] =  $query->result_array()[0];
            return $result;
        } else {
            return $result;
        }
    
    }


    /**
     * @author Pablo José D.J. 
     * @fecha creación 18-08-2016 
     * @param type String: $data_reset_password
     * @return array() si el código de recuperación existe devuelve array('exists'=>1) de lo contrario devuelve array('exists'=>0)
     */
    public function insert_password_reset($data_reset_password = null) {
        if (is_null($data_reset_password)) {
            return null;
        }
        $this->db->trans_begin(); // inicio de transaccion
            
        $this->db->insert('recuperar_contrasenia', $data_reset_password); //Almacena usuario
        $obtiene_id_password_reset = $this->db->insert_id();
        pr($this->db->last_query());
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return -1;
        } else {
            $this->db->trans_commit(); // si la transacción es correcta retornar TRUE
            return $obtiene_id_password_reset;
        }
    }


    /**
     * @author Pablo José D.J. 
     * @fecha creación 18-08-2016 
     * @param type String: $code_password_reset
     * @return array() si el código de recuperación existe devuelve array('exists'=>1) de lo contrario devuelve array('exists'=>0)
     */
//    public function get_exist_code_password_reset($params=array()) {
//        $result = array('result'=>0, 'data'=>null);
//        if (is_null($params)) {
//            return $result;
//        }
//        $data_select = array(
//            'MAX(REC_CON_FCH) as MAX_REC_CON_FCH',
//            'REC_CON_CVE',
//            'REC_CON_CODIGO',
//            'REC_CON_FCH',
//            'REC_CON_ESTADO',
//            'USUARIO_CVE',
//        );
//
//        $this->db->select($data_select);
//        $this->db->where($params);
//        //$this->db->where('REC_CON_ESTADO = 0');
//        //$this->db->where('REC_CON_CODIGO', $code_password_reset);
//        //$this->db->where('USU_MATRICULA', $matricula);
//        $query = $this->db->get('recuperar_contrasenia');
//        $cantidad = $query->num_rows();
//        pr($this->db->last_query());
//        if ($cantidad > 0) {
//            $result['result'] = 1;
//            $result['data'] =  $query->result_array()[0];
//            return $result;
//        } else {
//            return $result;
//        }
//    
//    }
    
    /**
     * @author Pablo José D.J. 
     * @fecha creación 18-08-2016 
     * @param type String: $code_password_reset
     * @return array() si el código de recuperación existe devuelve array('exists'=>1) de lo contrario devuelve array('exists'=>0)
     */
    public function get_exist_code_password_reset($params=array()) {
        $result = array('result'=>0, 'data'=>null);
        if (is_null($params)) {
            return $result;
        }
        $data_select = 'SELECT REC_CON_CVE, REC_CON_CODIGO, REC_CON_FCH, '
                . 'REC_CON_ESTADO, USUARIO_CVE FROM recuperar_contrasenia '
                . 'where REC_CON_FCH in (SELECT MAX(REC_CON_FCH) as MAX_FCH FROM recuperar_contrasenia WHERE USUARIO_CVE = ' . $params['USUARIO_CVE'] .') '
                . 'and USUARIO_CVE = '.  $params['USUARIO_CVE'];
        $query = $this->db->query($data_select);
        $query = $query->result_array();
        if (!empty($query)) {
            $result['result'] = 1;
            $result['data'] =  $query[0];
            return $result;
        } else {
            return $result;
        }
    
    }


    /**
     * 
     * @param type $datos_empleado
     * @param type $where
     * @return int 
     */
    public function update_pass_recover($rec_con_cve = null, $data_rec_update = array())
    {
        if (is_null($rec_con_cve) && empty($data_rec_update)) {
            return 0;
        }
        $this->db->where('REC_CON_CVE', $rec_con_cve);
        if($this->db->update('recuperar_contrasenia', $data_rec_update)){
            //pr($this->db->last_query());
            return 1;

        }
        return 0;

    }


    /**
     * 
     * @param type $datos_empleado
     * @param type $where
     * @return int 
     */
    public function update_password_user($data_pass_save = array(), $matricula = null) {
        if (is_null($matricula) && empty($data_pass_save)) {
            return 0;
        }
        $this->db->where('USU_MATRICULA', $matricula);
        if($this->db->update('usuario', $data_pass_save)){
            //pr($this->db->last_query());
            return 1;

        }
        return 0;

    }

    public function reset_password_commit($params = array())
    {
        /*
                                            'USUARIO_CVE'=>'',
                                            'USU_MATRICULA'=>'',
                                            'REC_CON_CVE'=>'',
                                            'USU_CONTRASENIA'=>''
        */
        if (is_null($params)) {
            return null;
        }
        $this->db->trans_begin(); // inicio de transaccion
        
        $params_rec_pass = array(
                'REC_CON_ESTADO'=>1
            );


        $params_pass_upd = array(
                'USU_CONTRASENIA'=>$params['USU_CONTRASENIA']
            );

        $pass['_cod'] = $this->update_password_user($params_pass_upd, $params['USU_MATRICULA']);
        $pass['_rec'] = $this->update_pass_recover($params['REC_CON_CVE'], $params_rec_pass);

        //pr($pass);


        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return -1;
        } else {
            $this->db->trans_commit(); // si la transacción es correcta retornar TRUE
            return 1;
        }
        

    }


}
