<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author LEAS
 */
class Actividad_docente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getGeneros() {
        
    }

    /**
     * 
     * @param int $usuario_id
     */
    public function get_actividad_docente_general($usuario_id) {
        $this->db->select(array('adg.ACT_DOC_GRAL_CVE', 'adg.ANIOS_DEDICADOS', 'adg.EJER_PREDOMI_CVE',
            'adg.EMPLEADO_CVE "EMPLEADO_CVE"', 'adg.CURSO_MAS_DEDICADO', 'adg.CURSO_PRINC_IMPARTE', 'adg.TIP_ACT_DOC_PRINCIPAL_CVE', 'ejpre.EJE_PRE_NOMBRE'));
        $this->db->from('actividad_docente_gral as adg');
        $this->db->join('empleado as em', 'em.EMPLEADO_CVE = adg.EMPLEADO_CVE');
        $this->db->join('cejercicio_predominante as ejpre', 'ejpre.EJER_PREDOMI_CVE=adg.EJER_PREDOMI_CVE', 'left');
        $this->db->where('em.USUARIO_CVE', $usuario_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_actividad_docente_general($datos_actividad_docente) {
        $result['return'] = -1;
        $result['parametros'] = '';
        if (is_null($datos_actividad_docente)) {
            return $result;
        }
        $this->db->insert('actividad_docente_gral', $datos_actividad_docente); //Almacena usuario
        $index = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result['return'] = -1;
        } else {
            $this->db->trans_commit();
            $result['return'] = $index;
            $datos_actividad_docente['ACT_DOC_GRAL_CVE'] = $index;
            $result['actualizados'] = $datos_actividad_docente;
        }
        return $result;
    }

    public function update_actividad_docente_general($datos_actividad_docente) {
        $result['return'] = -1;
        $result['actualizados'] = '';
        if (is_null($datos_actividad_docente)) {
            return $result;
        }
        //Actualiza
        $error = $this->db->where("EMPLEADO_CVE", $datos_actividad_docente['EMPLEADO_CVE']);
        $this->db->update('actividad_docente_gral', $datos_actividad_docente);
//        pr($this->db->last_query());
        $result['return'] = 1;
        $result['actualizados'] = $datos_actividad_docente;
        return $result;
    }

    public function update_curso_principal_actividad_docente($datos_cur_principal = null) {
        $result['return'] = -1;
        $result['actualizados'] = '';
        if (is_null($datos_cur_principal)) {
            return $result;
        }
        //'\'
        //Actualiza
        $this->db->where("ACT_DOC_GRAL_CVE", $datos_cur_principal['ACT_DOC_GRAL_CVE']);
        $query = $this->db->update('actividad_docente_gral', $datos_cur_principal);
//        $num_row = $this->db->num_rows();
//        pr($query);
//        pr($this->db->last_query());
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result['return'] = 0;
        } else {
            $result['return'] = 1;
            $result['actualizados'] = $datos_cur_principal;
        }
        return $result;
    }

    public function insert_emp_actividad_docente_gen($name_entidad, $array_campos) {
        if (is_null($name_entidad)) {
            return -1;
        }
        if (is_null($array_campos)) {
            return -1;
        }
        $this->db->insert($name_entidad, $array_campos); //Almacena tipo de actividad, según nombre de la entidad enviado
        $index = $obtiene_id_entidad_actividad_docente = $this->db->insert_id();
//        pr($this->db->last_query());
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return -1;
        } else {
            return $index;
        }
    }

    public function update_emp_actividad_docente_gen($id_entidad, $name_clave_primaria, $name_entidad, $array_campos) {
        if (is_null($id_entidad)) {
            return array();
        }
        if (is_null($array_campos)) {
            return array();
        }

        $this->db->where($name_clave_primaria, $id_entidad);
        $this->db->update($name_entidad, $array_campos);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array();
        } else {
            $array_datos_beca_laboral[$name_clave_primaria] = $id_entidad; //Asigna el identifucador
            return $array_datos_beca_laboral;
        }
    }

    /**
     * @author LEAS
     * @param int $actividad_docente_general_cve Lista de actividades del docente
     * 
     */
    public function get_actividades_docente($actividad_docente_general_cve = null, $validacion_cve_session = null, $empleado_cve = null) {
        /* if (isset($actividad_docente_general_cve) AND is_nan($actividad_docente_general_cve)) {

          return -1;
          } */
        if (is_null($actividad_docente_general_cve)) {
            return -1;
        }

        /////////Agregar validaciones de estado
        $sead = ' (SELECT VAL_CUR_EST_CVE FROM hist_efpd_validacion_curso 
                WHERE hist_efpd_validacion_curso.EMP_ACT_DOCENTE_CVE = ead.EMP_ACT_DOCENTE_CVE
                ORDER BY `VAL_CUR_FCH` desc LIMIT 1) AS validation_estado, ';
        $seed = ' (SELECT VAL_CUR_EST_CVE FROM hist_edd_validacion_curso 
                WHERE hist_edd_validacion_curso.EMP_EDU_DISTANCIA_CVE = eed.EMP_EDU_DISTANCIA_CVE
                ORDER BY `VAL_CUR_FCH` desc LIMIT 1) AS validation_estado, ';
        $seem = ' (SELECT VAL_CUR_EST_CVE FROM hist_eem_validacion_curso
                WHERE hist_eem_validacion_curso.EMP_ESP_MEDICA_CVE = esm.EMP_ESP_MEDICA_CVE
                ORDER BY `VAL_CUR_FCH` desc LIMIT 1) AS validation_estado, ';
        /* Validaciones para ciclo general getAll() */
        if (is_array($actividad_docente_general_cve) && isset($actividad_docente_general_cve["conditions"]["empleado_cve"])) {
            $empleado_cve = $actividad_docente_general_cve["conditions"]["empleado_cve"];
        }

        //Entidad de emp_actividad_docente 
        $select_emp_actividad_docente = 'select ' . $sead .
            ' ead.EMP_ACT_DOCENTE_CVE "cve_actividad_docente", ead.EAD_ANIO_CURSO "anio", ead.EAD_DURACION "duracion"
            ,ead.EAD_FCH_INICIO "fecha_inicio", ead.EAD_FCH_FIN "fecha_fin", ead.COMPROBANTE_CVE "comprobante"
            ,ead.TIP_ACT_DOC_CVE "ta_cve", ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad", ead.ACT_DOC_GRAL_CVE "actividad_general_cve"
            , ead.IS_VALIDO_PROFESIONALIZACION, ead.EAD_NOMBRE_CURSO "nom_curso", ead.IS_CARGA_SISTEMA 
            from emp_actividad_docente as ead
            inner join ctipo_actividad_docente as ctad on ctad.TIP_ACT_DOC_CVE = ead.TIP_ACT_DOC_CVE
            where ead.EMPLEADO_CVE = ' . $empleado_cve;
        //Entidad de emp_educacion_distancia 
        $select_emp_educacion_distancia = 'select ' . $seed .
            ' eed.EMP_EDU_DISTANCIA_CVE "cve_actividad_docente", eed.EDD_CUR_ANIO "anio", eed.EED_DURACION "duracion"
            ,eed.EDD_FCH_INICIO "fecha_inicio", eed.EED_FCH_FIN "fecha_fin", eed.COMPROBANTE_CVE "comprobante"
            ,eed.TIP_ACT_DOC_CVE "ta_cve", ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad", eed.ACT_DOC_GRAL_CVE "actividad_general_cve"
            , eed.IS_VALIDO_PROFESIONALIZACION, eed.EED_NOMBRE_CURSO "nom_curso", eed.IS_CARGA_SISTEMA 
            from emp_educacion_distancia as eed
            inner join ctipo_actividad_docente as ctad on ctad.TIP_ACT_DOC_CVE = eed.TIP_ACT_DOC_CVE
            where eed.EMPLEADO_CVE = ' . $empleado_cve;
        //Entidad de emp_esp_medica
        $select_emp_esp_medica = 'select ' . $seem .
            ' esm.EMP_ESP_MEDICA_CVE "cve_actividad_docente", esm.EEM_ANIO_FUNGIO "anio", esm.EEM_DURACION "duracion"
            ,esm.EEM_FCH_INICIO "fecha_inicio", esm.EEM_FCH_FIN "fecha_fin", esm.COMPROBANTE_CVE "comprobante"
            ,esm.TIP_ACT_DOC_CVE "ta_cve", ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad", esm.ACT_DOC_GRAL_CVE "actividad_general_cve"
            , esm.IS_VALIDO_PROFESIONALIZACION, cte.TIP_ESP_MED_NOMBRE "nom_curso", esm.IS_CARGA_SISTEMA 
            from emp_esp_medica as esm
            inner join ctipo_actividad_docente as ctad on ctad.TIP_ACT_DOC_CVE = esm.TIP_ACT_DOC_CVE
            inner join ctipo_especialidad cte on cte.TIP_ESP_MEDICA_CVE = esm.TIP_ESP_MEDICA_CVE
            where esm.EMPLEADO_CVE = ' . $empleado_cve;

        if (is_array($actividad_docente_general_cve) && isset($actividad_docente_general_cve["validations"]["IS_VALIDO_PROFESIONALIZACION"])) {
            $select_emp_actividad_docente .= " AND IS_VALIDO_PROFESIONALIZACION = " . $actividad_docente_general_cve["validations"]["IS_VALIDO_PROFESIONALIZACION"];
            $select_emp_educacion_distancia .= " AND IS_VALIDO_PROFESIONALIZACION = " . $actividad_docente_general_cve["validations"]["IS_VALIDO_PROFESIONALIZACION"];
            $select_emp_esp_medica .= " AND IS_VALIDO_PROFESIONALIZACION = " . $actividad_docente_general_cve["validations"]["IS_VALIDO_PROFESIONALIZACION"];
        }
        $string_query = $select_emp_actividad_docente . " UNION " . $select_emp_educacion_distancia . " UNION " . $select_emp_esp_medica;
//        pr($string_query);
        $query = $this->db->query($string_query);
//        pr($this->db->last_query());
        return $query->result_array();
    }

    /**
     * @author LEAS
     * @param int $param Lista de actividades del docente
     * 
     */
    public function get_actividades_docente_unique($param = null) {
        /* Validaciones para ciclo general getAll() */
        if (is_array($param) && isset($param["conditions"]["empleado_cve"])) {
            $empleado_cve = $param["conditions"]["empleado_cve"];
        }

        //Entidad de emp_actividad_docente 
        $select_emp_actividad_docente = 'select 
            ead.EMP_ACT_DOCENTE_CVE "cve_actividad_docente", ead.EAD_ANIO_CURSO "anio", ead.EAD_DURACION "duracion"
            ,ead.EAD_FCH_INICIO "fecha_inicio", ead.EAD_FCH_FIN "fecha_fin", ead.COMPROBANTE_CVE "comprobante"
            ,ead.TIP_ACT_DOC_CVE "ta_cve", ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad", ead.ACT_DOC_GRAL_CVE "actividad_general_cve"
            , ead.IS_VALIDO_PROFESIONALIZACION, ead.EAD_NOMBRE_CURSO "nom_curso"
            from emp_actividad_docente as ead
            inner join ctipo_actividad_docente as ctad on ctad.TIP_ACT_DOC_CVE = ead.TIP_ACT_DOC_CVE
            where ead.EMPLEADO_CVE = ' . $empleado_cve;

        if (is_array($param) && isset($param["validations"]["IS_VALIDO_PROFESIONALIZACION"])) {
            $select_emp_actividad_docente .= " AND IS_VALIDO_PROFESIONALIZACION = " . $param["validations"]["IS_VALIDO_PROFESIONALIZACION"];
        }
        $query = $this->db->query($select_emp_actividad_docente);
//        pr($this->db->last_query());
        return $query->result_array();
    }

    /**
     * @author LEAS
     * @param int $param  Lista de actividades del docente
     * 
     */
    public function get_act_docente_espec_med_unique($param = null) {

        /* Validaciones para ciclo general getAll() */
        if (is_array($param) && isset($param ["conditions"]["empleado_cve"])) {
            $empleado_cve = $param ["conditions"]["empleado_cve"];
        }

        //Entidad de emp_educacion_distancia 
        $select_emp_esp_medica = 'select 
            esm.EMP_ESP_MEDICA_CVE "cve_actividad_docente", esm.EEM_ANIO_FUNGIO "anio", esm.EEM_DURACION "duracion"
            ,esm.EEM_FCH_INICIO "fecha_inicio", esm.EEM_FCH_FIN "fecha_fin", esm.COMPROBANTE_CVE "comprobante"
            ,esm.TIP_ACT_DOC_CVE "ta_cve", ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad", esm.ACT_DOC_GRAL_CVE "actividad_general_cve"
            , esm.IS_VALIDO_PROFESIONALIZACION, cte.TIP_ESP_MED_NOMBRE "nom_curso"
            from emp_esp_medica as esm
            inner join ctipo_actividad_docente as ctad on ctad.TIP_ACT_DOC_CVE = esm.TIP_ACT_DOC_CVE
            inner join ctipo_especialidad cte on cte.TIP_ESP_MEDICA_CVE = esm.TIP_ESP_MEDICA_CVE
            where esm.EMPLEADO_CVE = ' . $empleado_cve;

        if (is_array($param) && isset($param ["validations"]["IS_VALIDO_PROFESIONALIZACION"])) {
            $select_emp_esp_medica .= " AND IS_VALIDO_PROFESIONALIZACION = " . $param ["validations"]["IS_VALIDO_PROFESIONALIZACION"];
        }
        $query = $this->db->query($select_emp_esp_medica);
//        pr($this->db->last_query());
        return $query->result_array();
    }

    public function get_act_docente_edu_dist_unique($param = null) {

        /* Validaciones para ciclo general getAll() */
        if (is_array($param) && isset($param["conditions"]["empleado_cve"])) {
            $empleado_cve = $param["conditions"]["empleado_cve"];
        }

        //Entidad de emp_educacion_distancia 
        $select_emp_educacion_distancia = 'select 
            eed.EMP_EDU_DISTANCIA_CVE "cve_actividad_docente", eed.EDD_CUR_ANIO "anio", eed.EED_DURACION "duracion"
            ,eed.EDD_FCH_INICIO "fecha_inicio", eed.EED_FCH_FIN "fecha_fin", eed.COMPROBANTE_CVE "comprobante"
            ,eed.TIP_ACT_DOC_CVE "ta_cve", ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad", eed.ACT_DOC_GRAL_CVE "actividad_general_cve"
            , eed.IS_VALIDO_PROFESIONALIZACION, eed.EED_NOMBRE_CURSO "nom_curso"
            from emp_educacion_distancia as eed
            inner join ctipo_actividad_docente as ctad on ctad.TIP_ACT_DOC_CVE = eed.TIP_ACT_DOC_CVE
            where eed.EMPLEADO_CVE = ' . $empleado_cve;
        //Entidad de emp_esp_medica
        if (is_array($param) && isset($param["validations"]["IS_VALIDO_PROFESIONALIZACION"])) {
            $select_emp_educacion_distancia .= " AND IS_VALIDO_PROFESIONALIZACION = " . $param["validations"]["IS_VALIDO_PROFESIONALIZACION"];
        }
        $query = $this->db->query($select_emp_educacion_distancia);
//        pr($this->db->last_query());
        return $query->result_array();
    }

    /**
     * 
     * @param type $entidad   Nombre de la entidad (emp_actividad_docente, emp_educacion_distancia o emp_esp_medica)
     * @param type $index_entidad 
     * @return type
     */
    public function get_datos_actividad_docente($entidad = null, $index_entidad) {
        if (isset($actividad_docente_general_cve) AND is_nan($actividad_docente_general_cve)) {
            return array();
        }
        $select = null;
        $from = '';
        $where = '';
        $on = '';
        switch ($entidad) {
            case 'emp_actividad_docente':
                $select = array('ead.EMP_ACT_DOCENTE_CVE "cve_actividad_docente"',
                    'ead.ACT_DOC_GRAL_CVE "actividad_general_cve"', 'ead.TIP_ACT_DOC_CVE "ta_cve"',
                    'ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad"',
                    'ead.EAD_ANIO_CURSO "actividad_anios_dedicados_docencia"',
                    'ead.EAD_DURACION "hora_dedicadas"',
                    'ead.EAD_FCH_INICIO "fecha_inicio_pick"', 'ead.EAD_FCH_FIN "fecha_fin_pick"',
                    'ead.EAD_FCH_INICIO "periodo_fecha_inicio_pick"', 'ead.EAD_FCH_FIN "periodo_fecha_fin_pick"',
                    'ead.EAD_NOMBRE_CURSO "nombre_curso"', 'ead.EAD_NOMBRE_MATERIA_IMPARTIO "nombre_materia_impartio"',
                    'ead.EAD_EXTRA_INS_AVALA "pago_extra"', 'ead.COMPROBANTE_CVE "comprobante"', 'ead.MODULO_CVE "cmodulo_cve"',
                    'ead.AREA_CVE "carea_cve"', 'ead.TIP_MATERIAL_CVE "cmateria_cve"', 'ead.CURSO_CVE "ccurso_cve"',
                    'cc.TIP_CURSO_CVE "ctipo_curso_cve"', 'ead.INS_AVALA_CVE "cinstitucion_avala_cve"',
                    'ead.ROL_DESEMPENIA_CVE "crol_desempenia_cve"', 'ead.LICENCIATURA_CVE "licenciatura_cve"',
                    'ead.MODALIDAD_CVE "cmodalidad_cve"', 'ead.TIP_FOR_PROF_CVE "ctipo_formacion_profesional_cve"',
                    'com.TIPO_COMPROBANTE_CVE "ctipo_comprobante_cve"', 'ROL_DESEMPENIA', 'IA_NOMBRE', 'LIC_NOMBRE',
                    'MOD_NOMBRE', 'COM_NOMBRE', 'com.COMPROBANTE_CVE', 'AREA_NOMBRE', 'TIP_CUR_NOMBRE', 'cc.CUR_NOMBRE',
                    'TIP_FOR_PRO_NOMBRE', 'MODULO_NOMBRE');
                $from = 'emp_actividad_docente as ead';
                $where = 'ead.EMP_ACT_DOCENTE_CVE';
                $on = 'ctad.TIP_ACT_DOC_CVE = ead.TIP_ACT_DOC_CVE';
                $this->db->join('ccurso as cc', 'cc.CURSO_CVE = ead.CURSO_CVE', 'left');
                $this->db->join('ctipo_curso as ctc', 'ctc.TIP_CURSO_CVE = cc.TIP_CURSO_CVE ', 'left');
                $this->db->join('comprobante as com', 'com.COMPROBANTE_CVE = ead.COMPROBANTE_CVE ', 'left');
                $this->db->join('crol_desempenia as rd', 'rd.ROL_DESEMPENIA_CVE = ead.ROL_DESEMPENIA_CVE', 'left');
                $this->db->join('cinstitucion_avala as ia', 'ia.INS_AVALA_CVE = ead.INS_AVALA_CVE', 'left');
                $this->db->join('licenciatura as lic', 'lic.LICENCIATURA_CVE = ead.LICENCIATURA_CVE', 'left');
                $this->db->join('cmodalidad as mod', 'mod.MODALIDAD_CVE = ead.MODALIDAD_CVE', 'left');
                $this->db->join('carea', 'carea.AREA_CVE = ead.AREA_CVE', 'left');
                $this->db->join('ctipo_formacion_profesional', 'ctipo_formacion_profesional.TIP_FOR_PROF_CVE = ead.TIP_FOR_PROF_CVE', 'left');
                $this->db->join('cmodulo', 'cmodulo.MODULO_CVE = ead.MODULO_CVE', 'left');
                break;
            case 'emp_educacion_distancia':
                $select = array('eed.EMP_EDU_DISTANCIA_CVE "cve_actividad_docente"',
                    'eed.ACT_DOC_GRAL_CVE  "actividad_general_cve"', 'eed.TIP_ACT_DOC_CVE "ta_cve"',
                    'ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad"',
                    'eed.EDD_CUR_ANIO "actividad_anios_dedicados_docencia"',
                    'eed.EED_DURACION "hora_dedicadas"',
                    'eed.EDD_FCH_INICIO "fecha_inicio_pick"', 'eed.EED_FCH_FIN "fecha_fin_pick"',
                    'eed.COMPROBANTE_CVE "comprobante"', 'eed.IS_CURSO_TUTURIZADO "is_curso_tutorizado"',
                    'eed.TIPO_CURSO_CVE "ctipo_curso_cve"', 'eed.EED_NOMBRE_CURSO "nombre_curso"',
                    'eed.FOLIO_CONSTANCIA "folio_constancia"', 'eed.ROL_DESEMPENIA_CVE "crol_desempenia_cve"',
                    'com.TIPO_COMPROBANTE_CVE "ctipo_comprobante_cve"', 'ROL_DESEMPENIA', 'COM_NOMBRE', 'com.COMPROBANTE_CVE',
                    'TIP_CUR_NOMBRE');
                $from = 'emp_educacion_distancia as eed';
                $where = 'eed.EMP_EDU_DISTANCIA_CVE';
                $on = 'ctad.TIP_ACT_DOC_CVE = eed.TIP_ACT_DOC_CVE';
                $this->db->join('comprobante as com', 'com.COMPROBANTE_CVE = eed.COMPROBANTE_CVE ', 'left');
                $this->db->join('crol_desempenia as rd', 'rd.ROL_DESEMPENIA_CVE = eed.ROL_DESEMPENIA_CVE', 'left');
                $this->db->join('ctipo_curso as ctc', 'ctc.TIP_CURSO_CVE = eed.TIPO_CURSO_CVE ', 'left');
                break;
            case 'emp_esp_medica':
                $select = array('esm.EMP_ESP_MEDICA_CVE "cve_actividad_docente"',
                    'esm.TIP_ACT_DOC_CVE "ta_cve"', 'esm.COMPROBANTE_CVE "comprobante"',
                    'ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad"', 'esm.ACT_DOC_GRAL_CVE "actividad_general_cve"',
                    'esm.EEM_ANIO_FUNGIO "actividad_anios_dedicados_docencia"', 'esm.EEM_DURACION "hora_dedicadas"',
                    'esm.EEM_FCH_INICIO "periodo_fecha_inicio_pick"', 'esm.EEM_FCH_FIN "periodo_fecha_fin_pick"',
                    'esm.EEM_PAGO_EXTRA "pago_extra"', 'esm.INS_AVALA_CVE "cinstitucion_avala_cve"',
                    'esm.MODALIDAD_CVE "cmodalidad_cve"', 'esm.ROL_DESEMPENIA_CVE "crol_desempenia_cve"',
                    'esm.TIP_ESP_MEDICA_CVE "ctipo_especialidad_cve"',
                    'com.TIPO_COMPROBANTE_CVE "ctipo_comprobante_cve"', 'ROL_DESEMPENIA', 'IA_NOMBRE',
                    'MOD_NOMBRE', 'COM_NOMBRE', 'com.COMPROBANTE_CVE', 'TIP_ESP_MED_NOMBRE');
                $this->db->join('comprobante as com', 'com.COMPROBANTE_CVE = esm.COMPROBANTE_CVE ', 'left');
                $this->db->join('crol_desempenia as rd', 'rd.ROL_DESEMPENIA_CVE = esm.ROL_DESEMPENIA_CVE', 'left');
                $this->db->join('cinstitucion_avala as ia', 'ia.INS_AVALA_CVE = esm.INS_AVALA_CVE', 'left');
                $this->db->join('cmodalidad as mod', 'mod.MODALIDAD_CVE = esm.MODALIDAD_CVE', 'left');
                $this->db->join('ctipo_especialidad', 'ctipo_especialidad.TIP_ESP_MEDICA_CVE = esm.TIP_ESP_MEDICA_CVE', 'left');
                $from = 'emp_esp_medica as esm';
                $where = 'esm.EMP_ESP_MEDICA_CVE';
                $on = 'ctad.TIP_ACT_DOC_CVE = esm.TIP_ACT_DOC_CVE';
                break;
        }

        $this->db->select($select);
        $this->db->from($from);
        $this->db->join('ctipo_actividad_docente as ctad', $on);
        $this->db->where($where, $index_entidad);
        $query = $this->db->get();
        $result = $query->result_array();
        if (!empty($result)) {
            $result = $result[0];
        }
//        pr($this->db->last_query());
        return $result;
    }

    /**
     * 
     * @param int $usuario_id
     */
//    public function get_actividades_docente($actividad_docente_general_cve = null) {
//        if (isset($actividad_docente_general_cve) AND is_nan($actividad_docente_general_cve)) {
//            return -1;
//        }
//        //Entidad de emp_actividad_docente 
//        $array_emp_actividad_docente = array('ead.EMP_ACT_DOCENTE_CVE "cve_actividad_docente"', 'ead.EAD_ANIO_CURSO "anio"'
//            , 'ead.EAD_DURACION "duracion"', 'ead.EAD_FCH_INICIO "fecha_inicio"', 'ead.EAD_FCH_FIN "fecha_fin"', 'ead.TIP_ACT_DOC_CVE "ta_cve"'
//            , 'ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad"', 'ead.ACT_DOC_GRAL_CVE "actividad_general_cve"');
//
//        //Entidad de emp_educacion_distancia 
//        $array_emp_educacion_distancia = array('eed.EMP_EDU_DISTANCIA_CVE "cve_actividad_docente"', 'eed.EDD_CUR_ANIO "anio"'
//            , 'eed.EED_DURACION "duracion"', 'eed.EED_DURACION "duracion"', 'eed.EDD_FCH_INICIO "fecha_inicio"', 'eed.EED_FCH_FIN "fecha_fin"', 'eed.TIP_ACT_DOC_CVE "ta_cve"'
//            , 'ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad"', 'eed.ACT_DOC_GRAL_CVE "actividad_general_cve"');
//
//        //Entidad de emp_esp_medica
//        $array_emp_esp_medica = array('esm.EMP_ESP_MEDICA_CVE "cve_actividad_docente"', 'esm.EEM_ANIO_FUNGIO "anio"'
//            , 'esm.EEM_DURACION "duracion"', 'esm.EEM_FCH_INICIO "fecha_inicio"', 'esm.EEM_FCH_FIN "fecha_fin"', 'esm.TIP_ACT_DOC_CVE "ta_cve"'
//            , 'ctad.TIP_ACT_DOC_NOMBRE "nombre_tp_actividad"', 'esm.ACT_DOC_GRAL_CVE "actividad_general_cve"');
//
//        $this->db->select($array_emp_actividad_docente);
//        $this->db->from('emp_actividad_docente as ead');
//        $this->db->join('ctipo_actividad_docente as ctad', 'ctad.TIP_ACT_DOC_CVE = ead.TIP_ACT_DOC_CVE');
//        $this->db->where_in('ead.ACT_DOC_GRAL_CVE', $actividad_docente_general_cve);
////        $this->db->get();
//        $subQuery1 = $this->db->_compile_select();
////        $this->db->_reset_select();
//
//        $this->db->select($array_emp_educacion_distancia);
//        $this->db->from('emp_educacion_distancia as eed');
//        $this->db->join('ctipo_actividad_docente as ctad', 'ctad.TIP_ACT_DOC_CVE = eed.TIP_ACT_DOC_CVE');
//        $this->db->where_in('eed.ACT_DOC_GRAL_CVE', $actividad_docente_general_cve);
////        $this->db->get();
//        $subQuery2 = $this->db->_compile_select();
////        $this->db->_reset_select();
//
//        $this->db->select($array_emp_esp_medica);
//        $this->db->from('emp_esp_medica as esm');
//        $this->db->join('ctipo_actividad_docente as ctad', 'ctad.TIP_ACT_DOC_CVE = esm.TIP_ACT_DOC_CVE');
//        $this->db->where_in('esm.ACT_DOC_GRAL_CVE', $actividad_docente_general_cve);
////        $this->db->get();
//        $subQuery3 = $this->db->_compile_select();
////        $this->db->_reset_select();
//
//        $this->db->query("select * from ($subQuery1 UNION $subQuery2 UNION $subQuery3) as union_actividad_docente");
//        $this->db->from("($subQuery1 UNION $subQuery2 UNION $subQuery3)");
//        $query = $this->db->get();
//
//        return $query->result_array();
//    }


    public function get_verifica_curso_principal_actividad_general($index_tp_actividad = null, $index_entidad = null, $index_actividad_general = null) {
        $this->db->select(array('*'));
        $this->db->from('actividad_docente_gral as adg');
        $this->db->where('TIP_ACT_DOC_PRINCIPAL_CVE', $index_tp_actividad);
        $this->db->where('CURSO_PRINC_IMPARTE', $index_entidad);
        $this->db->where('CURSO_PRINC_IMPARTE', $index_actividad_general);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_actividad_docente($entidad = null, $campo_where = null, $id_registro = null) {
        if (is_null($entidad) || is_null($campo_where) || is_null($id_registro)) {
            return -1;
        }
        $this->db->where($campo_where, $id_registro);
        $this->db->delete($entidad);
        return 1;
    }

}
