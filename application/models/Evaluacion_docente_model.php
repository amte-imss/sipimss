<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluacion_docente_model extends CI_Model {
    var $string_values;

	public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
        $this->lang->load('interface_evaluacion');
        $this->string_values = $this->lang->line('interface_evaluacion')['evaluacion']['model']; //Cargar textos utilizados en vista
    }

    public function get_evaluacion_docente($params=null){
        $resultado = array();

        ///////////////////// Iniciar almacenado de parámetros en cache /////////////////////////
        $this->db->start_cache();

        if(array_key_exists('conditions', $params)){
            $this->db->where($params['conditions']);
        }
        if(array_key_exists('order', $params)){
            $this->db->order_by($params['order']);
        }

        $this->db->join('cestado_solicitud_evauacion', 'cestado_solicitud_evauacion.CESE_CVE=evaluacion_solicitud.CESE_CVE', 'left');
        $this->db->join('empleado', 'empleado.EMPLEADO_CVE = evaluacion_solicitud.EMPLEADO_CVE');
        $this->db->join('ccategoria', 'ccategoria.id_cat = empleado.CATEGORIA_CVE', 'left');
        $this->db->join('cdelegacion', 'cdelegacion.DELEGACION_CVE = empleado.DELEGACION_CVE', 'left');

        //condiciones obligatorias
        $this->db->where('empleado.EDO_LABORAL_CVE', 1);

        $this->db->stop_cache();
        /////////////////////// Fin almacenado de parámetros en cache ///////////////////////////
        $this->db->select('evaluacion_solicitud.*');

        ///////////////////////////// Obtener número de registros ///////////////////////////////
        $nr = $this->db->get_compiled_select('evaluacion_solicitud'); //Obtener el total de registros
        $num_rows = $this->db->query("SELECT count(*) AS total FROM (" . $nr . ") AS temp")->result();
        //pr($this->db->last_query());
        /////////////////////////////// FIN número de registros /////////////////////////////////

        if(array_key_exists('fields', $params)){
            if(is_array($params['fields'])){
                $this->db->select($params['fields'][0], $params['fields'][1]);
            } else {
                $this->db->select($params['fields']);
            }
        }
        
        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }

        if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación
            $this->db->limit($params['per_page'], $params['current_row']);
        }

        $query = $this->db->get('evaluacion_solicitud'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        //$resultado=$query->result_array();
        $resultado['total'] = $num_rows[0]->total;
        $resultado['columns'] = $query->list_fields();
        $resultado['data'] = $query->result_array();
        //pr($resultado['data']);
        $this->db->flush_cache();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_dictamen($params=null){
        $resultado = array();
        if(array_key_exists('fields', $params)){
            if(is_array($params['fields'])){
                $this->db->select($params['fields'][0], $params['fields'][1]);
            } else {
                $this->db->select($params['fields']);
            }
        }        
        if(array_key_exists('conditions', $params)){
            $this->db->where($params['conditions']);
        }
        if(array_key_exists('order', $params)){
            $this->db->order_by($params['order']);
        }

        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }

        $query = $this->db->get('admin_dictamen_evaluacion'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado=$query->result_array();
        
        $query->free_result(); //Libera la memoria

        return $resultado;        
    }

    public function get_evaluador($params=null){
        $resultado = array();
        if(array_key_exists('fields', $params)){
            if(is_array($params['fields'])){
                $this->db->select($params['fields'][0], $params['fields'][1]);
            } else {
                $this->db->select($params['fields']);
            }
        }        
        if(array_key_exists('conditions', $params)){
            $this->db->where($params['conditions']);
        }
        if(array_key_exists('order', $params)){
            $this->db->order_by($params['order']);
        }

        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }

        $query = $this->db->get('evaluador'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado=$query->result_array();
        
        $query->free_result(); //Libera la memoria

        return $resultado;        
    }

    public function get_hist_evaluacion_dic($params=null){
        $resultado = array();
        if(array_key_exists('fields', $params)){
            if(is_array($params['fields'])){
                $this->db->select($params['fields'][0], $params['fields'][1]);
            } else {
                $this->db->select($params['fields']);
            }
        }        
        if(array_key_exists('conditions', $params)){
            $this->db->where($params['conditions']);
        }
        if(array_key_exists('order', $params)){
            $this->db->order_by($params['order']);
        }

        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }

        $this->db->join('evaluador', 'hist_evaluacion_dic.EVALUADOR_CVE=EVALUADOR.ROL_EVALUADOR_CVE', 'left');
        $this->db->join('crol', 'evaluador.ROL_CVE=crol.ROL_CVE', 'left');
        $this->db->join('cestado_evaluacion', 'hist_evaluacion_dic.EST_EVALUACION_CVE=cestado_evaluacion.EST_EVALUACION_CVE', 'left');

        $query = $this->db->get('hist_evaluacion_dic'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado=$query->result_array();
        
        $query->free_result(); //Libera la memoria

        return $resultado;        
    }

    public function update_evaluacion_curso($datos, $params){
        $resultado = array('result'=>null, 'msg'=>'', 'data'=>null);
        $this->db->trans_begin(); //Definir inicio de transacción
        
        if(array_key_exists('conditions', $params)){
            $this->db->where($params['conditions']);
        }

        $this->db->update('evaluacion_solicitud', $datos); //Inserción de registro
                
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $resultado['msg'] = $this->string_values['error'];
        } else {
            $this->db->trans_commit();
            $resultado['msg'] = $this->string_values['actualizacion'];
            $resultado['result'] = TRUE;
        }
        
        return $resultado;
    }

    public function update_hist_evaluacion_dic($datos, $params){
        $resultado = array('result'=>null, 'msg'=>'', 'data'=>null);
        $this->db->trans_begin(); //Definir inicio de transacción
        
        if(array_key_exists('conditions', $params)){
            $this->db->where($params['conditions']);
        }

        $this->db->update('hist_evaluacion_dic', $datos); //Inserción de registro
                
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $resultado['msg'] = $this->string_values['error'];
        } else {
            $this->db->trans_commit();
            $resultado['msg'] = $this->string_values['actualizacion'];
            $resultado['result'] = TRUE;
        }
        
        return $resultado;
    }
}
