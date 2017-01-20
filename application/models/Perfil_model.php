<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil_model extends CI_Model {

    var $genero = array('F' => 'Femenino', 'M' => 'Masculino');

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->lang->load('interface');
        $this->string_values = $this->lang->line('interface')['model']; //Cargar textos utilizados en vista
    }

    /**
     * 
     * @return Array
     */
    public function getEstadoCivil() {
        $query = $this->db->get('cestado_civil');
        $estadoCivil = $query->result_array();
        $query->free_result();
        return $estadoCivil;
    }

    /**
     * @author LEAS
     * @return máximo_valor,  fecha_bitacora
     */
    public function get_fecha_ultima_actualizacion($id_usuario) {
        $select_ = 'select BIT_FCH_CAMBIO "fecha_bitacora" from bitacora b 
                        where BITACORA_CVE in (select max(BITACORA_CVE) 
                        from bitacora b where usuario_cve = 1 and BIT_RUTA like "%/perfil/%")';
        $query = $this->db->query($select_)->result();
//        $estadoCivil = $query->result_array();
//        $result = $query->row();
        if (!empty($query)) {
            $query = $query[0];
        }
//        pr($this->db->last_query());
//        pr($query);
        return $query;
    }

    /**
     * 
     * @param int $identificador
     */
    public function getEmpleadoData($identificador, $campoId = 'EM.USUARIO_CVE') {
        $this->db->select(array(
            'EMPLEADO_CVE as emp_id',
            'EMP_NOMBRE as nombre',
            'EMP_APE_PATERNO as apellidoPaterno',
            'EMP_APE_MATERNO as apellidoMaterno',
            'EMP_CURP as curp',
            //'EMP_EDAD as edad',
            'EMP_ANTIGUEDAD as antiguedad',
            'emp_fch_nac as fecha_nacimiento',
            'EMP_GENERO as generoSelected',
            'CESTADO_CIVIL_CVE as estadoCivilSelected',
            'EMP_EMAIL as correoElectronico',
            'EMP_TEL_PARTICULAR as telParticular',
            'EMP_TEL_LABORAL as telLaboral',
            'EMP_NUM_FUE_IMSS as empleosFueraImss',
            'EMP_MATRICULA as matricula',
            'DEL_NOMBRE as delegacion',
            'NOM_CATEGORIA as nombreCategoria',
            'EM.CATEGORIA_CVE as claveCategoria',
            'ADS_NOM_AREA as nombreAreaAdscripcion',
            'ADS_NOM_UNIDAD as nombreUnidadAdscripcion',
            'EM.ADSCRIPCION_CVE as claveAdscripcion',
            'TIP_CON_NOMBRE as tipoContratacion',
            'EMP_TEL_PARTICULAR as estatusEmpleado',
            'CP.PRE_NOMBRE as clavePresupuestal',
            ''
        ));
        $this->db->from('empleado AS EM');
        $this->db->join('cdelegacion AS CDEL', 'CDEL.DELEGACION_CVE = EM.DELEGACION_CVE', 'left');
        $this->db->join('ccategoria AS CCAT', 'CCAT.ID_CAT = EM.CATEGORIA_CVE', 'left');
        $this->db->join('adscripcion AS ADS', 'ADS.ADSCRIPCION_CVE = EM.ADSCRIPCION_CVE', 'left');
        $this->db->join('ctipo_contratacion AS CTC', 'EM.tip_contratacion_cve =  CTC.tip_contratacion_cve', 'left');
        $this->db->join('cdepartamento AS CD', 'CD.DEPARTAMENTO_CVE =  EM.DEPARTAMENTO_CVE', 'left');
        $this->db->join('cpresupuestal AS CP', 'CP.PRESUPUESTAL_CVE =  CD.PRESUPUESTAL_CVE  ', 'left');
        $this->db->where($campoId, $identificador);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * @author LEAS
     * @param type $id_empleado
     * @return type Cantidad de registros que existen en "formación profesional docente y actividad docente"
     * Para que se cumpla la regla de cambiar de estado "completa" el docente debe cumplir ciertos requisitos, 
     * 1.- Ya haber registrado almenos información en profesionalización en salud
     * 2.- Ya haber registrado almenos una actividad docente, y la actividad principal 
     */
    public function get_estado_valida_completa($id_empleado) {
        $select_ = 'select SUM(count_salud) as "total_prof_salud", SUM(count_act_doc) as "total_act_docente" 
                    from
                    (select count(efpcs.EMPLEADO_CVE) "count_salud", 0 "count_act_doc"
                    from empleado as em
                    join emp_for_personal_continua_salud efpcs on efpcs.EMPLEADO_CVE = em.EMPLEADO_CVE
                    where em.EMPLEADO_CVE = ' . $id_empleado . '
                    union
                    select 0 "count_salud", count(ead.EMPLEADO_CVE) "count_act_doc"
                    from empleado as em
                    join emp_actividad_docente ead on ead.EMPLEADO_CVE = em.EMPLEADO_CVE
                    join actividad_docente_gral ag on ag.EMPLEADO_CVE = em.EMPLEADO_CVE
                    where em.EMPLEADO_CVE = ' . $id_empleado . ' and ag.TIP_ACT_DOC_PRINCIPAL_CVE is not null) as res';
        $query = $this->db->query($select_)->row();
//        pr($this->db->last_query());
        return $query;
    }
    
    public function get_verifica_registro_($id_empleado) {
        
    }

}
