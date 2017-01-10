<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluacion_curricular_validar_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
        $this->string_values = $this->lang->line('interface')['model']; //Cargar textos utilizados en vista
    }

    public function get_buscar_docentes_validar_evaluacion_c($params) {
        $arra_buscar_por = array(
            'matricula' => 'ems.EMP_MATRICULA',
            'clavecategoria' => 'ems.CATEGORIA_CVE',
            'nombre' => array('ems.EMP_NOMBRE', 'ems.EMP_APE_PATERNO', 'ems.EMP_APE_MATERNO')
        );
        $busqueda_text = $arra_buscar_por[$params['menu_busqueda']]; //busqueda en texto por
        $select = array('es.VALIDACION_CVE "solicitu_cve"', 'es.EMPLEADO_CVE "empleado_cve"',
            'ems.emp_matricula "matricula"',
            'concat(ems.EMP_NOMBRE, " ", ems.EMP_APE_PATERNO, " ", ems.EMP_APE_MATERNO) "nom_docente"',
            'cd.DEL_NOMBRE "nom_delegacion"', 'cdp.dep_nombre "unidad_adscripcion"', 'cc.nom_categoria "nom_categoria"',
            'es.CESE_CVE "estado_solicitud"', 'ehv.hist_validacion_cve "historia_validacion_cve"',
            'ehv.convocatoria_cve "convocatori_cve"', 'ehv.est_validacion_cve "estado_validacion"',
            'cev.EST_VALIDA_DESC "nom_estado_validacion"', 'ehv.fch_registro_historia "fecha_ultima_actualizacion"',
            'if(ehv.msg_correcciones is null or ehv.msg_correcciones = "",0,1) "is_comentario"',
            'ems.USUARIO_CVE "usuario_cve"'
        );

        $this->db->start_cache();
//        $this->db->from('evaluacion_solicitud es');
        $this->db->join('evaluacion_hist_validacion ehv', 'ehv.solicitud_cve = es.VALIDACION_CVE');
        $this->db->join('cestado_validacion cev', 'cev.EST_VALIDACION_CVE = ehv.est_validacion_cve');
        $this->db->join('empleado ems', 'ems.EMPLEADO_CVE = es.EMPLEADO_CVE');
        $this->db->join('cdelegacion cd', 'cd.delegacion_cve = ems.delegacion_cve');
        $this->db->join('cdepartamento cdp', 'cdp.departamento_cve = ems.ADSCRIPCION_CVE', 'left');
        $this->db->join('ccategoria cc', 'cc.id_cat = ems.CATEGORIA_CVE', 'left');
        //where que son obligatorios
        $this->db->where('es.CESE_CVE <', 4); //Sólo muestrá estados menores a la evaluación del docente (quitar comentario)
        $this->db->where('ems.EDO_LABORAL_CVE', 1); //Empleado activos en el sistema
        $this->db->where('ehv.is_actual', 1); //obtiene el último estado de la historia
        $rol = intval($params['rol_seleccionado']);
        switch ($rol) {
            case Enum_rols::Profesionalizacion:
                if ($params['DELEGACION_CVE'] > 0) {
                    $this->db->where('ems.DELEGACION_CVE', $params['DELEGACION_CVE']);
                }
                if ($params['departamento_cve'] > 0) {
                    $this->db->where('ems.ADSCRIPCION_CVE', $params['departamento_cve']);
                }
                break;
            case Enum_rols::Validador_N2:
                if ($params['departamento_cve'] > 0) {
                    $this->db->where('ems.ADSCRIPCION_CVE', $params['departamento_cve']);
                }
                break;
            case Enum_rols::Validador_N1:
                $this->db->where('ems.ADSCRIPCION_CVE', $params['DEPARTAMENTO_CVE']);
                break;
        }
        //Estado de la validación
        if (!empty($params['cestado_validacion'])) {//where estado de la validación, no es obligatorio
            $this->db->where('cev.EST_VALIDACION_CVE', $params['cestado_validacion']);
        }

        if (is_array($busqueda_text)) {//si es un array lo recorre, ejemplo es la concatenación de nombre, ap y am
            foreach ($busqueda_text as $value) {
                $this->db->or_like($value, $params['buscador_docente']);
            }
        } else {//pone un like para buscar por matricula, o categoria
            $this->db->like($busqueda_text, $params['buscador_docente']);
        }
        $this->db->stop_cache();

        //Cuenta la cantidad de registros
        $num_rows = $this->db->query($this->db->select('count(*) as total')->get_compiled_select('evaluacion_solicitud es'))->result();
        $this->db->reset_query(); //Reset de query 
        $this->db->select($select); //Crea query de consulta
        if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación 
            $this->db->limit($params['per_page'], $params['current_row']);
        }

        $order_type = (isset($params['order_type'])) ? $params['order_type'] : 'asc';

        if (isset($params['order'])) { //Establecer límite definido para paginación 
            $orden = $params['order'];
//            pr($orden);
            if ($orden === 'fullname') {
                $orden = 'ems.EMP_NOMBRE, ems.EMP_APE_PATERNO, ems.EMP_APE_MATERNO';
            }
            $this->db->order_by($orden, $order_type);
        }

        $ejecuta = $this->db->get('evaluacion_solicitud es'); //Prepara la consulta ( aún no la ejecuta)
        $query = $ejecuta->result_array();
//        $query->free_result();
//        pr($this->db->last_query());
        $this->db->flush_cache(); //Limpia la cache
        $result['result'] = $query;
        $result['total'] = $num_rows[0]->total;
        return $result;
    }

    /**
     * Obtiene la última convocatoría de la validación de evaluación curricular 
     * llave primaria ADMIN_VALIDADOR_CVE "convocatoria_cve"
     * y una etapa de convocatoria "etapa_convocatoria"
     * scd = etapa de solicitud del docente para evaluación
     * vn1 = etapa de validación del n1
     * vn2 = etapa de validación del n2
     * fcv = termino la convocatoria (fin de última convocatoria )
     */
    public function get_convocatoria_actual_evaluacion() {
        $select = array(
            'ADMIN_VALIDADOR_CVE "convocatoria_cve"',
            'if(DATE_FORMAT(now(),"%Y-%m-%d") <= ec.FCH_FIN_REG_DOCENTE, "scd", 
        (if(DATE_FORMAT(now(),"%Y-%m-%d") between ec.FCH_FIN_REG_DOCENTE and ec.FCH_FIN_VALIDACION_1,"vn1",
        (if(DATE_FORMAT(now(),"%Y-%m-%d) between ec.FCH_FIN_VALIDACION_1 and ec.FCH_FIN_VALIDACION_2, "vn2", "fcv"))
        )))
        "etapa_convocatoria"');
        $this->db->select($select);
        $this->db->where('ec.is_actual', 1);
        $get = $this->db->get('evaluacion_convocatoria ec'); //Prepara la consulta ( aún no la ejecuta)
        $query = $get->result_array();
        if (!empty($query)) {
            $query = $query[0];
        }
        return $query;
    }

            /**
     * 
     * @autor LEAS
     * @fecha 09/09/2016
     * @param type $validadacion_cve
     * @return Obtiene la historia completa indicada por la clave
     */
    public function get_comentario_hist_validacion_evaluacion($solicitud_cve) {
        $select = array('if(hv.validador_cve is null,0,1) "existe_validador"',
            'if(hv.validador_cve is null,
            concat(emd.EMP_NOMBRE, " ", emd.EMP_APE_PATERNO, " ",emd.EMP_APE_MATERNO),
            concat(em.EMP_NOMBRE, " ", em.EMP_APE_PATERNO, " ",em.EMP_APE_MATERNO)) as "nom_validador"',
            'hv.msg_correcciones "comentartio_estado"', 'hv.est_validacion_cve "hist_estado"',
            'fch_registro_historia "fecha_validacion"',
            'if(hv.msg_correcciones is null or hv.msg_correcciones = "",0,1) "is_comentario"',
            'cev.EST_VALIDA_DESC "nom_estado_val"'
        );
        $this->db->where('hv.solicitud_cve', $solicitud_cve);
        $this->db->join('evaluacion_solicitud es', 'es.VALIDACION_CVE = hv.solicitud_cve');
        $this->db->join('cestado_validacion cev', 'cev.EST_VALIDACION_CVE = hv.est_validacion_cve');
        $this->db->join('empleado emd', 'emd.EMPLEADO_CVE = es.EMPLEADO_CVE');
        $this->db->join('validador v', 'v.VALIDADOR_CVE = hv.validador_cve', 'left');
        $this->db->join('empleado em', 'em.EMPLEADO_CVE = v.EMPLEADO_CVE', 'left');
        $this->db->order_by('hv.hist_validacion_cve', 'desc');
//        $this->db->join('validador v', 'v.VALIDADOR_CVE = hv.validador_cve');
//        $this->db->join('empleado em', 'em.EMPLEADO_CVE = v.EMPLEADO_CVE');
        $this->db->select($select);
        $query = $this->db->get('evaluacion_hist_validacion hv');
        $row_hist = $query->result_array();
//        pr($this->db->last_query());
        return $row_hist;
    }

    /**
     * 
     * @autor LEAS
     * @fecha 10/09/2016
     * @return Obtiene las fechas de dictamen que inician después de la fecha actual
     */
    public function get_admin_dictamen_evaluacion() {
        $select = array('ADMIN_DICTAMEN_EVA_CVE',
            'concat("Inicio: ",DATE_FORMAT(FCH_INICIO_EVALUACION,"%d-%m-%Y"),"  Fin: ", DATE_FORMAT(FCH_FIN_EVALUACION,"%d-%m-%Y")) "fecha_dicatmen"'
        );
        $this->db->where('DATE_FORMAT(now(),"%Y-%m-%d")<= ade.FCH_INICIO_EVALUACION');
        $this->db->select($select);
        $query = $this->db->get('admin_dictamen_evaluacion ade');
        $row_hist = $query->result_array();
//        pr($this->db->last_query());
        return $row_hist;
    }

    /**
     * 
     * @autor LEAS
     * @fecha 29/09/2016
     * @param $solicitud_eva_cve Solicitud del docente para evaluar 
     * @return los cursos que se enviaron a validar según la solicitud
     */
    public function get_cursos_validar_evaluar($solicitud_eva_cve, $parametros = null) {

        if (is_null($parametros)) {
            $parametros = array('ecv_cve "cursos_evaluacion_cve"', 'ebs_cve "bloque_seccion"',
                'es_cve "solicitud_cve"', 'csi_cve "seccion_cve"',
                'registro_cve "curso_registro_cve"');
        }
        $this->db->where('es_cve', $solicitud_eva_cve);
        $this->db->select($parametros);
        $query = $this->db->get('evaluacion_curso_validacion');
        $row_hist = $query->result_array();
//        pr($this->db->last_query());
        return $row_hist;
    }

    /**
     * 
     * @autor LEAS
     * @fecha 29/09/2016
     * @param $solicitud_eva_cve Solicitud del docente para evaluar 
     * @param $parametros Parametros especificos 
     * @return Historia de validación para la evaluación curricular el docente 
     */
    public function get_last_hist_validacion_evaluacion($solicitud_eva_cve, $parametros = null) {

        if (is_null($parametros)) {
            $parametros = array('ehv.hist_validacion_cve "historia_gral_cve"', 'ehv.validador_cve "validador_cve"',
                'ehv.est_validacion_cve "estado_hist_validacion"', 'ehv.convocatoria_cve',
                'ces.CESE_CVE "estado_solicitud_cve"', 'ces.EMPLEADO_CVE "empleado_cve"',
                'ehv.fch_registro_historia "fecha_historia_validacion_grl"');
        }
        $this->db->where('ces.VALIDACION_CVE', $solicitud_eva_cve);
        $this->db->where('ehv.is_actual', 1);
        $this->db->select($parametros);
        $this->db->join('evaluacion_solicitud ces', 'ces.VALIDACION_CVE = ehv.solicitud_cve');
        $query = $this->db->get('evaluacion_hist_validacion ehv');
        $row_hist = $query->result_array();
        if (!empty($row_hist)) {
            $row_hist = $row_hist[0];
        }
//        pr($this->db->last_query());
        return $row_hist;
    }

    /**
     * 
     * @autor LEAS
     * @fecha 29/09/2016
     * @param $historia_cve clave historia general de la validación de la solicitud
     * @param $parametros Parametros especificos 
     * @return Historias de la validación de los bloques de sección 
     */
    public function get_last_estado_bloque_evluacion($historia_cve, $parametros = null) {

        if (is_null($parametros)) {
            $parametros = array('ece.ebv_cve "bloque_evaluacion_cve"', 'ece.ehv_cve "historia_gral_cve"',
                'ece.estado_validacion_cve "estado_validacion"', 'cce.VAl_CUR_EST_NOMBRE "nom_estado_bloque"',
                'ece.txt_descripcion "comentario_bloque"', 'ece.ebs_cve "bloque_seccion_cve"',
                'ece.fch_insert "fecha_validacion"');
        }

        $this->db->where('ece.ehv_cve', $historia_cve);
        $this->db->select($parametros);
        $this->db->join('cvalidacion_curso_estado cce', 'cce.VAL_CUR_EST_CVE = ece.estado_validacion_cve');
        $query = $this->db->get('evaluacion_bloques_val ece');
        $row_hist = $query->result_array();
        $result = array();
        if (!empty($row_hist)) {
            $result = $this->asignar_bloque_llave_hist_bloque($row_hist);
        }
        return $result;
    }

    /**
     * @author LEAS
     * @fecha 07/10/2016
     * @param type $array_historial_bloque 
     * Historial de bloques, pero le asigna como llave acronimo o clave 
     * del bloque al que pertenece 
     */
    private function asignar_bloque_llave_hist_bloque($array_historial_bloque) {
        $array_result = array();
        foreach ($array_historial_bloque as $value) {
            $array_result[$value['bloque_seccion_cve']] = $value;
        }
        return $array_result;
    }

    /**
     * 
     * @autor LEAS
     * @fecha 08/10/2016
     * @param type $solicitud Solicitu de la validación
     * @param string $parametros 
     * @return type
     */
    public function get_estados_por_bloque($solicitud, $bloque, $parametros = null) {
        if (is_null($parametros)) {
            $parametros = array('ece.ebv_cve "bloque_evaluacion_cve"', 'ece.ehv_cve "historia_gral_cve"',
                'ece.estado_validacion_cve "estado_validacion"', 'cce.VAl_CUR_EST_NOMBRE "nom_estado_bloque"',
                'ece.txt_descripcion "comentario_bloque"', 'ece.ebs_cve "bloque_seccion_cve"', 
                'ece.fch_insert "fecha_validacion"',
                'concat(emv.EMP_NOMBRE, " ", emv.EMP_APE_PATERNO, " ", emv.EMP_APE_MATERNO) "nom_validador"',
                'ehv.validador_cve "validador_cve"', 'if(ece.txt_descripcion is null or ece.txt_descripcion = "",0,1) "is_comentario"'
            );
        }

        $this->db->where('ehv.solicitud_cve', $solicitud);
        $this->db->where('ece.ebs_cve', $bloque);

        $this->db->select($parametros);
        $this->db->join('evaluacion_hist_validacion ehv', 'ehv.hist_validacion_cve = ece.ehv_cve');
        $this->db->join('cvalidacion_curso_estado cce', 'cce.VAL_CUR_EST_CVE = ece.estado_validacion_cve');
        $this->db->join('validador v', 'v.VALIDADOR_CVE = ehv.validador_cve', 'left');
        $this->db->join('empleado emv', 'emv.EMPLEADO_CVE = v.EMPLEADO_CVE', 'left');
        $query = $this->db->get('evaluacion_bloques_val ece');
        $this->db->order_by('ece.ebv_cve', 'desc');
        $row_hist = $query->result_array();

        return $row_hist;
    }

}
