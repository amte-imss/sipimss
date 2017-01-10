<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Formacion_model extends CI_Model {
    var $string_values;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->lang->load('interface');
        $this->string_values = $this->lang->line('interface')['model']; //Cargar textos utilizados en vista
    }

    private function get_formacion_subquery($params){
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
        if(array_key_exists('limit', $params)){
            $this->db->limit($params['limit']);
        }
        $subquery = $this->db->get_compiled_select($params['table']); //Obtener conjunto de registros
        return $subquery;
    }

    public function get_formacion_salud($params=null){
        $resultado = array();
        /////////////////////////////////Inicio verificación existencia de validación actual
        if(!is_null($params) && (isset($params['validation']) || isset($params['validation_estado']) || isset($params['validation_estado_anterior']))){
            $subquery = (array_key_exists('validation', $params)) ? $this->get_formacion_subquery($params['validation']) : null;
            $subquery1 = (array_key_exists('validation_estado', $params)) ? $this->get_formacion_subquery($params['validation_estado']) : null;
            $subquery2 = (array_key_exists('validation_estado_anterior', $params)) ? $this->get_formacion_subquery($params['validation_estado_anterior']) : null;
            if(!is_null($subquery)){
                $this->db->select('('.$subquery.') AS validation');
            }
            if(!is_null($subquery1)){
                $this->db->select('('.$subquery1.') AS validation_estado');
            }
            if(!is_null($subquery2)){
                $this->db->select('('.$subquery2.') AS validation_estado_anterior');
            }
//            pr($subquery);
//            pr($subquery1);
//            pr($subquery2);
        }
        
        ////////////////////////////////Fin verificación existencia de validación actual

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

        $this->db->join('ctipo_formacion_salud', 'emp_for_personal_continua_salud.TIP_FORM_SALUD_CVE=ctipo_formacion_salud.TIP_FORM_SALUD_CVE', 'left');
        $this->db->join('csubtipo_formacion_salud', 'emp_for_personal_continua_salud.CSUBTIP_FORM_SALUD_CVE=csubtipo_formacion_salud.CSUBTIP_FORM_SALUD_CVE', 'left');
        $this->db->join('comprobante', 'emp_for_personal_continua_salud.comprobante_cve=comprobante.comprobante_cve', 'left');
        $this->db->join('licenciatura', 'licenciatura.LICENCIATURA_CVE =  emp_for_personal_continua_salud.LICENCIATURA_CVE', 'left');

        $query = $this->db->get('emp_for_personal_continua_salud'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $resultado=$query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_ejercicio_profesional($params=null){
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

        $this->db->join('cejercicio_profesional', 'empleado.emp_eje_pro_cve=cejercicio_profesional.EJE_PRO_CVE', 'left');

        $query = $this->db->get('empleado'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado=$query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_formacion_docente($params=null){
        $resultado = array();
        /////////////////////////////////Inicio verificación existencia de validación actual
        $subquery = (array_key_exists('validation', $params)) ? $this->get_formacion_subquery($params['validation']) : null;
        $subquery1 = (array_key_exists('validation_estado', $params)) ? $this->get_formacion_subquery($params['validation_estado']) : null;
        $subquery2 = (array_key_exists('validation_estado_anterior', $params)) ? $this->get_formacion_subquery($params['validation_estado_anterior']) : null;
        
        if(!is_null($subquery)){
            $this->db->select('('.$subquery.') AS validation');
        }
        if(!is_null($subquery1)){
            $this->db->select('('.$subquery1.') AS validation_estado');
        }
        if(!is_null($subquery2)){
            $this->db->select('('.$subquery2.') AS validation_estado_anterior');
        }
        ////////////////////////////////Fin verificación existencia de validación actual

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

        $this->db->join('ctipo_formacion_profesional', 'emp_formacion_profesional.TIP_FOR_PROF_CVE=ctipo_formacion_profesional.TIP_FOR_PROF_CVE', 'left');
        $this->db->join('csubtipo_formacion_profesional', 'csubtipo_formacion_profesional.SUB_FOR_PRO_CVE=emp_formacion_profesional.SUB_FOR_PRO_CVE', 'left');
        $this->db->join('cmodalidad', 'cmodalidad.MODALIDAD_CVE=emp_formacion_profesional.MODALIDAD_CVE', 'left');
        $this->db->join('cinstitucion_avala', "cinstitucion_avala.INS_AVALA_CVE=emp_formacion_profesional.INS_AVALA_CVE AND IA_TIPO='".$this->config->item('institucion')['imparte']."'", 'left');
        $this->db->join('licenciatura', 'licenciatura.LICENCIATURA_CVE=emp_formacion_profesional.LICENCIATURA_CVE', 'left');
        $this->db->join('ccurso', 'emp_formacion_profesional.curso_cve=ccurso.curso_cve', 'left');
        
        //$this->db->join('ctematica', 'emp_formacion_profesional.CSUBTIP_FORM_SALUD_CVE=csubtipo_formacion_salud.CSUBTIP_FORM_SALUD_CVE', 'left');
        $this->db->join('comprobante', 'emp_formacion_profesional.comprobante_cve=comprobante.comprobante_cve', 'left');

        $query = $this->db->get('emp_formacion_profesional'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $resultado=$query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_formacion_docente_tematica($params=null){
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
        $this->db->join('ctematica', 'rform_prof_tematica.TEMATICA_CVE=ctematica.TEMATICA_CVE');

        $query = $this->db->get('rform_prof_tematica'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado=$query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_tematica($params=null){
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

        $query = $this->db->get('ctematica'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado=$query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_campos_catalogos($params=null){
        $resultado = array();

        /*if(array_key_exists('fields', $params)){
            if(is_array($params['fields'])){
                $this->db->select($params['fields'][0], $params['fields'][1]);
            } else {
                $this->db->select($params['fields']);
            }*/
            $this->db->select('campos_catalogos.*, MED_DIV_NOMBRE, ccurso.CUR_NOMBRE, ccurso.TIP_CURSO_CVE, ROL_DESEMPENIA, TIP_MAT_NOMBRE, TIP_MAT_TIPO, LIC_NOMBRE, TIP_LICENCIATURA_CVE, ');
        //}
        if(array_key_exists('conditions', $params)){
            $this->db->where($params['conditions']);
        }
        if(array_key_exists('order', $params)){
            $this->db->order_by($params['order']);
        }

        $this->db->join('ccurso', 'ccurso.CURSO_CVE=campos_catalogos.CURSO_CVE', 'left');
        $this->db->join('cmedio_divulgacion', 'cmedio_divulgacion.MED_DIVULGACION_CVE=campos_catalogos.MED_DIVULGACION_CVE', 'left');
        $this->db->join('crol_desempenia', 'crol_desempenia.ROL_DESEMPENIA_CVE=campos_catalogos.ROL_DESEMPENIA_CVE', 'left');
        $this->db->join('ctipo_material', 'ctipo_material.TIP_MATERIAL_CVE=campos_catalogos.TIP_MATERIAL_CVE', 'left');
        $this->db->join('licenciatura', 'licenciatura.LICENCIATURA_CVE=campos_catalogos.LICENCIATURA_CVE', 'left');
        
        $query = $this->db->get('campos_catalogos'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado=$query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }
    
    public function get_tipo_formacion_salud($params=null){
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

        $query = $this->db->get('ctipo_formacion_salud'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $resultado=$query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_subtipo_formacion_salud($params=null){
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
        $this->db->join('ctipo_formacion_salud', 'ctipo_formacion_salud.TIP_FORM_SALUD_CVE=csubtipo_formacion_salud.TIP_FORM_SALUD_CVE', 'left');

        $query = $this->db->get('csubtipo_formacion_salud'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $resultado=$query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_subtipo_formacion_docente($params=null){
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
        $this->db->join('ctipo_formacion_profesional', 'ctipo_formacion_profesional.TIP_FOR_PROF_CVE=csubtipo_formacion_profesional.TIP_FOR_PROF_CVE', 'left');

        $query = $this->db->get('csubtipo_formacion_profesional'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado=$query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function insert_formacion_salud($datos){
        $resultado = array('result'=>null, 'msg'=>'', 'data'=>null);
        
        $this->db->trans_begin(); //Definir inicio de transacción
        
        $this->db->insert('emp_for_personal_continua_salud', $datos); //Inserción de registro
        
        $data_id = $this->db->insert_id(); //Obtener identificador insertado
        
        if ($this->db->trans_status() === FALSE){
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

    public function insert_formacion_docente($datos, $datos_tematica){
        $resultado = array('result'=>null, 'msg'=>'', 'data'=>null);
        
        $this->db->trans_begin(); //Definir inicio de transacción

        $this->db->insert('emp_formacion_profesional', $datos); //Inserción de registro
        
        $data_id = $this->db->insert_id(); //Obtener identificador insertado

        /*$this->db->where('EMP_FORMACION_PROFESIONAL_CVE', $identificador); //Eliminar temáticas para volver a insertarlas
        $this->db->delete('rform_prof_tematica');*/
        foreach ($datos_tematica as $key_dt => $tematica) {
            $tematica->EMP_FORMACION_PROFESIONAL_CVE = $data_id;
            $this->db->insert('rform_prof_tematica', $tematica); //Insertar temáticas relacionadas
        }
        
        if ($this->db->trans_status() === FALSE){
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

    public function update_formacion_docente($identificador, $datos, $datos_tematica){
        $resultado = array('result'=>null, 'msg'=>'', 'data'=>null);
        
        $this->db->trans_begin(); //Definir inicio de transacción
        $this->db->where('EMP_FORMACION_PROFESIONAL_CVE', $identificador);
        $this->db->update('emp_formacion_profesional', $datos); //Actualización del registro

        $this->db->where('EMP_FORMACION_PROFESIONAL_CVE', $identificador); //Eliminar temáticas para volver a insertarlas
        $this->db->delete('rform_prof_tematica');

        $this->db->insert_batch('rform_prof_tematica', $datos_tematica); //Insertar temáticas relacionadas
        
        if ($this->db->trans_status() === FALSE){
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

    public function update_formacion_ejercicio_profesional($identificador, $datos){
        $resultado = array('result'=>null, 'msg'=>'', 'data'=>null);
        
        $this->db->trans_begin(); //Definir inicio de transacción
        $this->db->where('EMPLEADO_CVE', $identificador);
        $this->db->update('empleado', $datos); //Inserción de registro
        
        if ($this->db->trans_status() === FALSE){
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

    public function update_formacion_salud($identificador, $datos){
        $resultado = array('result'=>null, 'msg'=>'', 'data'=>null);
        
        $this->db->trans_begin(); //Definir inicio de transacción
        $this->db->where('FPCS_CVE', $identificador);
        $this->db->update('emp_for_personal_continua_salud', $datos); //Inserción de registro
        
        if ($this->db->trans_status() === FALSE){
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

    public function delete_formacion_salud($params=null){
        $resultado = array('result'=>null, 'msg'=>'', 'data'=>null);

        $this->db->trans_begin(); //Definir inicio de transacción

        $this->db->start_cache();
        if(array_key_exists('conditions', $params)){
            $this->db->where($params['conditions']);
        }
        $this->db->stop_cache();

        $this->db->join('comprobante', 'emp_for_personal_continua_salud.COMPROBANTE_CVE=comprobante.COMPROBANTE_CVE', 'left');
        $subSql = $this->db->get('emp_for_personal_continua_salud', true); //Obtener ID de comprobante para eliminar
        $comp = $subSql->result_array();

        $this->db->delete('emp_for_personal_continua_salud'); //Eliminamos registro de comisión
        
        $this->db->flush_cache(); //Eliminar datos de cache
        
        $this->db->where('COMPROBANTE_CVE', $comp[0]['COMPROBANTE_CVE']);
        $this->db->delete('comprobante'); //Eliminamos comprobante

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $resultado['msg'] = $this->string_values['error'];
        } else {
            $this->db->trans_commit();
            $resultado['result'] = TRUE;
            $resultado['msg'] = $this->string_values['eliminacion'];
            $resultado['data'] = $comp[0];
        }
        
        return $resultado;
    }

    public function delete_formacion_docente($params=null){
        $resultado = array('result'=>null, 'msg'=>'', 'data'=>null);

        $this->db->trans_begin(); //Definir inicio de transacción

        $this->db->start_cache();
        if(array_key_exists('conditions', $params)){
            $this->db->where($params['conditions']);
        }
        $this->db->stop_cache();

        $this->db->join('comprobante', 'emp_formacion_profesional.COMPROBANTE_CVE=comprobante.COMPROBANTE_CVE', 'left');
        $subSql = $this->db->get('emp_formacion_profesional', true); //Obtener ID de comprobante para eliminar
        $comp = $subSql->result_array();

        $this->db->delete('rform_prof_tematica'); //Eliminar temáticas

        $this->db->delete('emp_formacion_profesional'); //Eliminamos registro de formación
        
        $this->db->flush_cache(); //Eliminar datos de cache
        
        $this->db->where('COMPROBANTE_CVE', $comp[0]['COMPROBANTE_CVE']);
        $this->db->delete('comprobante'); //Eliminamos comprobante

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $resultado['msg'] = $this->string_values['error'];
        } else {
            $this->db->trans_commit();
            $resultado['result'] = TRUE;
            $resultado['msg'] = $this->string_values['eliminacion'];
            $resultado['data'] = $comp[0];
        }
        
        return $resultado;
    }
}
