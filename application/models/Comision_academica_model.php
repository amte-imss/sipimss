<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comision_academica_model extends My_model {

    var $string_values;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->lang->load('interface');
        $this->string_values = $this->lang->line('interface')['model']; //Cargar textos utilizados en vista
    }

    private function get_formacion_subquery($params) {
        if (array_key_exists('fields', $params)) {
            if (is_array($params['fields'])) {
                $this->db->select($params['fields'][0], $params['fields'][1]);
            } else {
                $this->db->select($params['fields']);
            }
        }
        if (array_key_exists('conditions', $params)) {
            $this->db->where($params['conditions']);
        }
        if (array_key_exists('order', $params)) {
            $this->db->order_by($params['order']);
        }
        if (array_key_exists('limit', $params)) {
            $this->db->limit($params['limit']);
        }
        $subquery = $this->db->get_compiled_select($params['table']); //Obtener conjunto de registros
        return $subquery;
    }

    public function get_comision_academica($params = null) {
        $resultado = array();

        /////////////////////////////////Inicio verificación existencia de validación actual
//        if(!is_null($params) && (isset($params['validation']) ||isset($params['validation_estado']) || isset($params['validation_estado_anterior']))){
//            $subquery = (array_key_exists('validation', $params)) ? $this->get_formacion_subquery($params['validation']) : null;
//            $subquery2 = (array_key_exists('validation_estado_anterior', $params)) ? $this->get_formacion_subquery($params['validation_estado_anterior']) : null;
//            
//            if(!is_null($subquery)){
//                $this->db->select('('.$subquery.') AS validation');
//            }
//            if(!is_null($subquery1)){
//            }
//            if(!is_null($subquery2)){
//                $this->db->select('('.$subquery2.') AS validation_estado_anterior');
//            }
//        }
        $subquery1 = (array_key_exists('validation_estado', $params)) ? $this->get_formacion_subquery($params['validation_estado']) : null;
        if (!is_null($subquery1)) {
            $this->db->select('(' . $subquery1 . ') AS validation_estado');
        }
        ////////////////////////////////Fin verificación existencia de validación actual

        if (array_key_exists('fields', $params)) {
            if (is_array($params['fields'])) {
                $this->db->select($params['fields'][0], $params['fields'][1]);
            } else {
                $this->db->select($params['fields']);
            }
        }
        if (array_key_exists('conditions', $params)) {
            $this->db->where($params['conditions']);
        }
        if (array_key_exists('conditions_in', $params)) {
            $this->db->where_in('emp_comision.TIP_COMISION_CVE', $params['conditions_in']['emp_comision.TIP_COMISION_CVE']);
        }
        if (array_key_exists('order', $params)) {
            $this->db->order_by($params['order']);
        }

        $this->db->join('cnivel_academico', 'cnivel_academico.niv_academico_cve=emp_comision.niv_academico_cve', 'left');
        $this->db->join('comision_area', 'comision_area.com_area_cve=emp_comision.com_area_cve', 'left');
        $this->db->join('comprobante', 'comprobante.comprobante_cve=emp_comision.comprobante_cve', 'left');
        $this->db->join('ctipo_curso', 'ctipo_curso.TIP_CURSO_CVE=emp_comision.TIP_CURSO_CVE', 'left');
        $this->db->join('ccurso', 'ccurso.CURSO_CVE=emp_comision.CURSO_CVE', 'left');
        $this->db->join('ctipo_comision', 'ctipo_comision.TIP_COMISION_CVE=emp_comision.TIP_COMISION_CVE', 'left');

        $query = $this->db->get('emp_comision'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_curso($params = null) {
        $resultado = array();

        if (array_key_exists('fields', $params)) {
            if (is_array($params['fields'])) {
                $this->db->select($params['fields'][0], $params['fields'][1]);
            } else {
                $this->db->select($params['fields']);
            }
        }
        if (array_key_exists('conditions', $params)) {
            $this->db->where($params['conditions']);
        }
        if (array_key_exists('order', $params)) {
            $this->db->order_by($params['order']);
        }

        $this->db->join('ctipo_curso', 'ctipo_curso.TIP_CURSO_CVE=emp_comision.TIP_CURSO_CVE', 'left');

        $query = $this->db->get('ccurso'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function insert_comision($datos) {
        $resultado = array('result' => null, 'msg' => '', 'data' => null);

        $this->db->trans_begin(); //Definir inicio de transacción

        $this->db->insert('emp_comision', $datos); //Inserción de registro

        $data_id = $this->db->insert_id(); //Obtener identificador insertado

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $resultado['msg'] = $this->string_values['error'];
        } else {
            $this->db->trans_commit();
            $resultado['data']['identificador'] = $data_id;
            $resultado['msg'] = $this->string_values['insercion'];
            $resultado['result'] = TRUE;
        }

        return $resultado;
    }

    public function update_comision($identificador, $datos) {
        $resultado = array('result' => null, 'msg' => '', 'data' => null);

        $this->db->trans_begin(); //Definir inicio de transacción
        $this->db->where('EMP_COMISION_CVE', $identificador);
        $this->db->update('emp_comision', $datos); //Inserción de registro

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $resultado['msg'] = $this->string_values['error'];
        } else {
            $this->db->trans_commit();
            $resultado['data']['identificador'] = $identificador;
            $resultado['msg'] = $this->string_values['actualizacion'];
            $resultado['result'] = TRUE;
        }

        return $resultado;
    }

    public function delete_comision($params = null) {
        $resultado = array('result' => null, 'msg' => '', 'data' => null);

        $this->db->trans_begin(); //Definir inicio de transacción

        $this->db->start_cache();
        if (array_key_exists('conditions', $params)) {
            $this->db->where($params['conditions']);
        }
        $this->db->stop_cache();

        $bandera_validar = $this->db->get('hist_comision_validacion_curso', true); //Se verifica que no tenga validaciones asociadas, de lo contrario no se borra
        $bv = $bandera_validar->result_array();
        //pr($this->db->last_query());
        //pr($bv);
        if (!empty($bv)) {
            $this->db->join('comprobante', 'emp_comision.COMPROBANTE_CVE=comprobante.COMPROBANTE_CVE', 'left');
            $subSql = $this->db->get('emp_comision', true); //Obtener ID de comprobante para eliminar
            $comp = $subSql->result_array();

            $this->db->delete('emp_comision'); //Eliminamos registro de comisión

            $this->db->flush_cache(); //Eliminar datos de cache

            $this->db->where('COMPROBANTE_CVE', $comp[0]['COMPROBANTE_CVE']);
            $this->db->delete('comprobante'); //Eliminamos comprobante

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $resultado['result'] = FALSE;
                $resultado['msg'] = $this->string_values['error'];
            } else {
                $this->db->trans_commit();
                $resultado['result'] = TRUE;
                $resultado['msg'] = $this->string_values['eliminacion'];
                $resultado['data'] = $comp[0];
            }
        } else {
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $resultado['msg'] = $this->string_values['error_validaciones_asociadas'];
        }

        return $resultado;
    }

}
