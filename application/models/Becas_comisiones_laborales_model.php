<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Becas_comisiones_laborales_model extends CI_Model {

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

    public function get_lista_becas($empleado_cve, $params = null) {
        if ($empleado_cve < 1) {
            return -1;
        }
        /////////////////////////////////Inicio verificación existencia de validación actual
//        if (!is_null($params) && (isset($params['validation']) || isset($params['validation_estado']) || isset($params['validation_estado_anterior']))) {
//            $subquery = (array_key_exists('validation', $params)) ? $this->get_formacion_subquery($params['validation']) : null;
//            $subquery2 = (array_key_exists('validation_estado_anterior', $params)) ? $this->get_formacion_subquery($params['validation_estado_anterior']) : null;
//
//            if (!is_null($subquery)) {
//                $this->db->select('(' . $subquery . ') AS validation');
//            }
//            if (!is_null($subquery2)) {
//                $this->db->select('(' . $subquery2 . ') AS validation_estado_anterior');
//            }
//        }
        $subquery1 = (array_key_exists('validation_estado', $params)) ? $this->get_formacion_subquery($params['validation_estado']) : null;
        $this->db->select('(' . $subquery1 . ') AS validation_estado');
        ////////////////////////////////Fin verificación existencia de validación actual

        $select = array('eb.EMP_BECA_CVE "emp_beca_cve"', 'eb.EMPLEADO_CVE "empleado_cve"',
            'eb.EB_FCH_INICIO "fecha_inicio"', 'eb.EB_FCH_FIN "fecha_fin"',
            'eb.CLA_BECA_CVE "clase_beca_cve"', 'cb.CLA_BEC_NOMBRE "nom_beca"',
            'eb.COMPROBANTE_CVE "comprobante"', 'c.COM_NOMBRE "nom_comprobante"',
            'c.TIPO_COMPROBANTE_CVE "tip_comprobante_cve"', 'tc.TIP_COM_NOMBRE "nom_comprobante"',
            'eb.BECA_INTERRIMPIDA_CVE "beca_interrumpida_cve"', 'bi.MSG_BEC_INTE "msj_beca_interrumpida"',
            'eb.MOTIVO_BECADO_CVE "motivo_beca_cve"', 'mb.MOT_BEC_NOMBRE "nom_motivo_beca"', 'eb.IS_VALIDO_PROFESIONALIZACION', 'eb.IS_CARGA_SISTEMA');

        $this->db->select($select);
        $this->db->from('emp_beca as eb');
        $this->db->join('cclase_beca cb', 'cb.CLA_BECA_CVE = eb.CLA_BECA_CVE');
        $this->db->join('cmotivo_becado mb', 'mb.MOTIVO_BECADO_CVE = eb.MOTIVO_BECADO_CVE');
        $this->db->join('cbeca_interrumpida bi', 'bi.BECA_INTERRIMPIDA_CVE = eb.BECA_INTERRIMPIDA_CVE');
        $this->db->join('comprobante c', 'c.COMPROBANTE_CVE = eb.COMPROBANTE_CVE', 'left');
        $this->db->join('ctipo_comprobante tc', 'tc.TIPO_COMPROBANTE_CVE = c.TIPO_COMPROBANTE_CVE', 'left');
        if (is_array($empleado_cve) && isset($empleado_cve["conditions"])) {
            $this->db->where($empleado_cve["conditions"]);
        } else {
            $this->db->where('eb.EMPLEADO_CVE', $empleado_cve);
        }
        $query = $this->db->get();
//        pr($this->db->last_query());
        return $query->result_array();
    }

    public function get_lista_comisiones($empleado_cve, $params = null) {
        if ($empleado_cve < 1) {
            return -1;
        }
        /////////////////////////////////Inicio verificación existencia de validación actual
//        if (!is_null($params) && (isset($params['validation']) || isset($params['validation_estado']) || isset($params['validation_estado_anterior']))) {
//            $subquery = (array_key_exists('validation', $params)) ? $this->get_formacion_subquery($params['validation']) : null;
//            $subquery2 = (array_key_exists('validation_estado_anterior', $params)) ? $this->get_formacion_subquery($params['validation_estado_anterior']) : null;
//
//            if (!is_null($subquery)) {
//                $this->db->select('(' . $subquery . ') AS validation');
//            }
//            if (!is_null($subquery1)) {
//                
//            }
//            if (!is_null($subquery2)) {
//                $this->db->select('(' . $subquery2 . ') AS validation_estado_anterior');
//            }
//        }
        $subquery1 = (array_key_exists('validation_estado', $params)) ? $this->get_formacion_subquery($params['validation_estado']) : null;
        $this->db->select('(' . $subquery1 . ') AS validation_estado');
        ////////////////////////////////Fin verificación existencia de validación actual
        $select = array('ecm.EMP_COMISION_CVE "emp_comision_cve"', 'ecm.EMPLEADO_CVE "empleado_cve"',
            'ecm.EC_FCH_INICIO "fecha_inicio"', 'ecm.EC_FCH_FIN "fecha_fin"',
            'ecm.COMPROBANTE_CVE "comprobante"', 'c.COM_NOMBRE "nom_comprobante"',
            'ecm.TIP_COMISION_CVE "tipo_comision_cve"', 'tcm.TIP_COM_NOMBRE "nom_tipo_comision"', 'ecm.IS_VALIDO_PROFESIONALIZACION', 'ecm.IS_CARGA_SISTEMA');

        $this->db->select($select);
        $this->db->from('emp_comision ecm');
        $this->db->join('ctipo_comision as tcm', 'tcm.TIP_COMISION_CVE = ecm.TIP_COMISION_CVE');
        $this->db->join('comprobante c', 'c.COMPROBANTE_CVE = ecm.COMPROBANTE_CVE', 'left');
        $this->db->join('ctipo_comprobante tc', 'tc.TIPO_COMPROBANTE_CVE = c.TIPO_COMPROBANTE_CVE', 'left');
        $this->db->where('tcm.IS_COMISION_ACADEMICA', 0);
        if (is_array($empleado_cve)) {
            $this->db->where($empleado_cve["conditions"]);
        } else {
            $this->db->where('ecm.EMPLEADO_CVE', $empleado_cve);
        }

        $query = $this->db->get();
//        pr($this->db->last_query());
        return $query->result_array();
    }

    public function get_datos_becas($beca_cve) {
        if ($beca_cve < 1) {
            return -1;
        }
        $select = array('eb.EMP_BECA_CVE "emp_beca_cve"', 'eb.EMPLEADO_CVE "empleado_cve"',
            'eb.EB_FCH_INICIO "fecha_inicio"', 'eb.EB_FCH_FIN "fecha_fin"',
            'eb.CLA_BECA_CVE "clase_beca_cve"', 'cb.CLA_BEC_NOMBRE "nom_beca"',
            'eb.COMPROBANTE_CVE "comprobante_cve"', 'c.COM_NOMBRE "text_comprobante"',
            'c.TIPO_COMPROBANTE_CVE "ctipo_comprobante"', 'tc.TIP_COM_NOMBRE "nom_comprobante"',
            'eb.BECA_INTERRIMPIDA_CVE "beca_interrumpida_cve"', 'bi.MSG_BEC_INTE "msj_beca_interrumpida"',
            'eb.MOTIVO_BECADO_CVE "motivo_beca_cve"', 'mb.MOT_BEC_NOMBRE "nom_motivo_beca"');

        $this->db->select($select);
        $this->db->from('emp_beca as eb');
        $this->db->join('cclase_beca cb', 'cb.CLA_BECA_CVE = eb.CLA_BECA_CVE');
        $this->db->join('cmotivo_becado mb', 'mb.MOTIVO_BECADO_CVE = eb.MOTIVO_BECADO_CVE');
        $this->db->join('cbeca_interrumpida bi', 'bi.BECA_INTERRIMPIDA_CVE = eb.BECA_INTERRIMPIDA_CVE');
        $this->db->join('comprobante c', 'c.COMPROBANTE_CVE = eb.COMPROBANTE_CVE', 'left');
        $this->db->join('ctipo_comprobante tc', 'tc.TIPO_COMPROBANTE_CVE = c.TIPO_COMPROBANTE_CVE', 'left');
        $this->db->where('eb.EMP_BECA_CVE', $beca_cve);
        $query = $this->db->get();
//        pr($this->db->last_query());
        $result = array();
        if (!empty($query->result_array())) {
            $result = $query->result_array()[0];
        }
        return $result;
    }

    public function get_datos_comisiones($comision_cve) {
        if ($comision_cve < 1) {
            return -1;
        }
        $select = array('ecm.EMP_COMISION_CVE "emp_comision_cve"', 'ecm.EMPLEADO_CVE "empleado_cve"',
            'ecm.EC_FCH_INICIO "fecha_inicio"', 'ecm.EC_FCH_FIN "fecha_fin"',
            'ecm.COMPROBANTE_CVE "comprobante_cve"', 'c.COM_NOMBRE "text_comprobante"',
            'c.TIPO_COMPROBANTE_CVE "ctipo_comprobante"',
            'ecm.TIP_COMISION_CVE "tipo_comision_cve"', 'tcm.TIP_COM_NOMBRE "nom_tipo_comision"', 'ecm.IS_VALIDO_PROFESIONALIZACION');

        $this->db->select($select);
        $this->db->from('emp_comision ecm');
        $this->db->join('ctipo_comision as tcm', 'tcm.TIP_COMISION_CVE = ecm.TIP_COMISION_CVE');
        $this->db->join('comprobante c', 'c.COMPROBANTE_CVE = ecm.COMPROBANTE_CVE', 'left');
//        $this->db->join('ctipo_comprobante tc', 'tc.TIPO_COMPROBANTE_CVE = c.TIPO_COMPROBANTE_CVE', 'left');
        $this->db->where('tcm.IS_COMISION_ACADEMICA', 0);
        $this->db->where('ecm.EMP_COMISION_CVE', $comision_cve);
        $query = $this->db->get();
//        pr($this->db->last_query());
        $result = array();
        if (!empty($query->result_array())) {
            $result = $query->result_array()[0];
        }
        return $result;
    }

    public function insert_becas($datos_beca) {
        $this->db->trans_begin();
        $this->db->insert('emp_beca', $datos_beca); //Almacena usuario
        $obtiene_id_emp_beca = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array();
        } else {
            $this->db->trans_commit();
            $datos_beca['EMP_BECA_CVE'] = $obtiene_id_emp_beca;
            return $datos_beca;
        }
    }

    public function insert_comisiones($datos_comision) {
        $this->db->trans_begin();
        $this->db->insert('emp_comision', $datos_comision); //Almacena usuario
        $obtiene_id_emp_comision = $this->db->insert_id();
//        pr($this->db->last_query());
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array();
        } else {
            $this->db->trans_commit();
            $datos_comision['EMP_COMISION_CVE'] = $obtiene_id_emp_comision;
            return $datos_comision;
        }
    }

    public function update_beca_laboral($id_beca_laboral = null, $array_datos_beca_laboral = null) {
        if (is_null($id_beca_laboral)) {
            return array();
        }
        if (is_null($array_datos_beca_laboral)) {
            return array();
        }

        $this->db->where('EMP_BECA_CVE', $id_beca_laboral);
        $this->db->update('emp_beca', $array_datos_beca_laboral);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array();
        } else {
            $array_datos_beca_laboral['EMP_BECA_CVE'] = $id_beca_laboral; //Asigna el identifucador
            return $array_datos_beca_laboral;
        }
    }

    public function update_comision_laboral($id_comision_laboral = null, $array_datos_comision_laboral = null) {
        if (is_null($id_comision_laboral)) {
            return array();
        }
        if (is_null($array_datos_comision_laboral)) {
            return array();
        }

        $this->db->where('EMP_COMISION_CVE', $id_comision_laboral);
        $this->db->update('emp_comision', $array_datos_comision_laboral);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array();
        } else {
            $array_datos_comision_laboral['EMP_COMISION_CVE'] = $id_comision_laboral; //Asigna el identifucador
            return $array_datos_comision_laboral;
        }
    }

}
