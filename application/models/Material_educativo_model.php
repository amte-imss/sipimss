<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * FECHA: 10/08/2016
 * @param autor LEAS
 * @param type $tipo_mat_edu
 * @return type
 */
class Material_educativo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
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

    public function get_lista_material_educativo($empleado_cve, $params = null) {
        if ($empleado_cve < 1) {
            return -1;
        }
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
        $this->db->select('(' . $subquery1 . ') AS validation_estado');
        ////////////////////////////////Fin verificación existencia de validación actual

        $select = array('eme.MATERIA_EDUCATIVO_CVE "emp_material_educativo_cve"',
            'eme.NOMBRE_MATERIAL_EDUCATIVO "nombre_material"',
            'eme.MAT_EDU_ANIO "material_educativo_anio"', 'eme.COMPROBANTE_CVE "comprobante"',
            'c.COM_NOMBRE "nom_comprobante"', 'c.TIPO_COMPROBANTE_CVE "ctc_comprobante_cve"',
            'ctc.TIP_COM_NOMBRE "nom_ctp_comprobante"', 'ctm.TIP_MATERIAL_CVE "tipo_material_cve"',
            'ctm.TIP_MAT_TIPO "padre_tp_material"', 'ctm.TIP_MAT_NOMBRE "nom_tipo_material"',
            'ctm.TIP_MAT_OPCION "opt_tipo_material"', 'eme.IS_VALIDO_PROFESIONALIZACION', 'eme.IS_CARGA_SISTEMA');

        $this->db->select($select);
        $this->db->from('emp_materia_educativo eme');
        $this->db->join('ctipo_material ctm', 'ctm.TIP_MATERIAL_CVE = eme.TIP_MATERIAL_CVE');
        $this->db->join('comprobante c', 'c.COMPROBANTE_CVE = eme.COMPROBANTE_CVE', 'left');
        $this->db->join('ctipo_comprobante ctc', 'ctc.TIPO_COMPROBANTE_CVE = c.TIPO_COMPROBANTE_CVE', 'left');
        if (is_array($empleado_cve) && isset($empleado_cve["conditions"])) {
            $this->db->where($empleado_cve["conditions"]);
        } else {
            $this->db->where('eme.EMPLEADO_CVE', $empleado_cve);
        }

        $query = $this->db->get();
//        pr($this->db->last_query());
        return $query->result_array();
    }

    public function get_datos_material_educativo($MATERIA_EDUCATIVO_CVE = null) {
        if (isset($MATERIA_EDUCATIVO_CVE) AND is_null($MATERIA_EDUCATIVO_CVE)) {
            return -1;
        }
        $select = array('eme.MATERIA_EDUCATIVO_CVE "emp_material_educativo_cve"',
            'eme.NOMBRE_MATERIAL_EDUCATIVO "nombre_material"',
            'eme.MAT_EDU_ANIO "material_educativo_anio"', 'eme.COMPROBANTE_CVE "comprobante_cve"',
            'c.COM_NOMBRE "text_comprobante"', 'c.TIPO_COMPROBANTE_CVE "ctipo_comprobante"',
            'ctc.TIP_COM_NOMBRE "nom_ctp_comprobante"', 'ctm.TIP_MATERIAL_CVE "tipo_material_cve"',
            'ctm.TIP_MAT_TIPO "padre_tp_material"', 'ctm.TIP_MAT_NOMBRE "nom_tipo_material"',
            'ctm.TIP_MAT_OPCION "opt_tipo_material"');

        $this->db->select($select);
        $this->db->from('emp_materia_educativo eme');
        $this->db->join('ctipo_material ctm', 'ctm.TIP_MATERIAL_CVE = eme.TIP_MATERIAL_CVE');
        $this->db->join('comprobante c', 'c.COMPROBANTE_CVE = eme.COMPROBANTE_CVE', 'left');
        $this->db->join('ctipo_comprobante ctc', 'ctc.TIPO_COMPROBANTE_CVE = c.TIPO_COMPROBANTE_CVE', 'left');
        $this->db->where('eme.MATERIA_EDUCATIVO_CVE', $MATERIA_EDUCATIVO_CVE);
        $query = $this->db->get();
//        pr($this->db->last_query());
        $result = array();
        if (!empty($query->result_array())) {
            $result = $query->result_array()[0];
        }
        return $result;
    }

    public function insert_emp_materia_educativo($datos_material_educativo) {
        $this->db->insert('emp_materia_educativo', $datos_material_educativo); //Almacena usuario
        $obtiene_id_emp_material_edu = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return -1;
        } else {
            return intval($obtiene_id_emp_material_edu);
        }
    }

    public function insert_ctipo_material($datos_ctipo_material_educativo) {
        if (is_null($datos_ctipo_material_educativo)) {
            return null;
        }
        $this->db->insert('ctipo_material', $datos_ctipo_material_educativo); //Almacena usuario
        $obtiene_id_tipo_material_edu = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return -1;
        } else {
            return intval($obtiene_id_tipo_material_edu);
        }
    }

    public function insert_material_and_tipo_mat($datos_material_educativo, $datos_tipo_material_educativo) {
        $this->db->trans_begin();
        $id_tp_material = $this->insert_ctipo_material($datos_tipo_material_educativo);
        if ($id_tp_material === -1) {
            $this->db->trans_rollback();
            return array();
        } else {
            $datos_material_educativo['TIP_MATERIAL_CVE'] = $id_tp_material;
            $datos_tipo_material_educativo['TIP_MATERIAL_CVE'] = $id_tp_material;
            $id_emp_material_educ = $this->insert_emp_materia_educativo($datos_material_educativo);
            if ($id_emp_material_educ === -1) {
                $this->db->trans_rollback();
                return array();
            } else {
                $datos_material_educativo['MATERIA_EDUCATIVO_CVE'] = $id_emp_material_educ;
                $this->db->trans_commit();
                $result['emp_materia_educativo'] = $datos_material_educativo;
                $result['ctipo_material'] = $datos_tipo_material_educativo;
                return $result;
            }
        }
    }

    public function update_material_educativo($id_material_educativo = null, $array_datos_material_educativo = null) {
        if (is_null($id_material_educativo)) {
            return array();
        }
        if (is_null($array_datos_material_educativo)) {
            return array();
        }

        $this->db->where('MATERIA_EDUCATIVO_CVE', $id_material_educativo);
        $this->db->update('emp_materia_educativo', $array_datos_material_educativo);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array();
        } else {
            $array_datos_material_educativo['MATERIA_EDUCATIVO_CVE'] = $id_material_educativo; //Asigna el identifucador
            return $array_datos_material_educativo;
        }
    }

    public function update_tipo_material_educativo($id_tipo_material_educativo = null, $array_datos_tipo_material_educativo = null) {
        if (is_null($id_tipo_material_educativo)) {
            return array();
        }
        if (is_null($array_datos_tipo_material_educativo)) {
            return array();
        }

        $this->db->where('TIP_MATERIAL_CVE', $id_tipo_material_educativo);
        $this->db->update('ctipo_material', $array_datos_tipo_material_educativo);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array();
        } else {
            $array_datos_tipo_material_educativo['TIP_MATERIAL_CVE'] = $id_tipo_material_educativo; //Asigna el identifucador
            return $array_datos_tipo_material_educativo;
        }
    }

    /**
     * 
     * @param type $id_tipo_mat_edu identificador del tipo de material educativo
     * @return type $arrar con los valores el registro tipo de material educativo eliminado
     */
    public function delete_tipo_material_educativo($id_tipo_mat_edu = null) {
        if (is_null($id_tipo_mat_edu)) {
            return array();
        }
        $res = $this->get_tipo_material_educativo($id_tipo_mat_edu);
        if (!empty($res)) {
            $res = $res[0];
            $this->db->where('TIP_MATERIAL_CVE', $id_tipo_mat_edu);
            $this->db->delete('ctipo_material');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array();
            } else {
                return $res; //Retorna array de tipo de actividad docente
            }
        }
    }

    /**
     * 
     * @param autor LEAS
     * @param type $tipo_mat_edu
     * @return type
     */
    public function get_tipo_material_educativo($tipo_mat_edu = null) {
        if (!is_null($tipo_mat_edu)) {
            $this->db->where('TIP_MATERIAL_CVE', $tipo_mat_edu);
        }
        $query = $this->db->get('ctipo_material');
        $array_validador = $query->result_array();
        $query->free_result();
        return $array_validador;
    }

}
