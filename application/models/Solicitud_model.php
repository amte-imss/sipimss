<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona la solicitud
 * @version     : 1.0.0
 * @autor       : Mr. Guag
 * @date: 07/10/2016
 * @attributes: config
 */
class Solicitud_model extends MY_Model {
    protected $language;

    function __construct(){
    	parent::__construct();
    	$this->load->database();
    }

    function get_info($solicitud_id = null){
    }

    /**
     * Método que lista las solicitudes de un empleado
     * @autor       : Mr Guag
     * @param       : int $empleado_cve identificador del empleado
                    bool $return Boleano que determina si se imprema o se retorna el valor
     * @return      : mix resultado arreglo de resultados de 
     */
    function list_solicitudes($empleado_cve=null){
    	if(is_null($empleado_cve)){
    		throw new Exception('La clave del empleado no existe.');
    	}
    	$this->db->where("EMPLEADO_CVE",$empleado_cve);
    	$this->db->join('cestado_solicitud_evauacion', 'cestado_solicitud_evauacion.cese_cve = evaluacion_solicitud.cese_cve');
    	$query = $this->db->get('evaluacion_solicitud');
    	$resultado = $query->result_array();

        $query->free_result(); //Libera la memoria
        return $resultado;
    }

    /**
     * Método que guarda una nueva solicitud
     * @autor       : Mr Guag
     * @param       : int $empleado_cve identificador del empleado
                      array $mix lista de actividades por registrar en la solicitud
     * @return      : int Error En el caso de si se ha podido guardar por cada tipo de error
                        0=>no existe el id del empleado
                        1=> no existen actividades en el arreglo
                        2=> Actualmente existe una solicitud vigente
     */
    function add_solicitud($empleado_cve = null,$mix = null){
        if(is_null($empleado_cve)){
            return 0;
        }
        if(is_null($mix)){
            return 1;
        }
        if($this->another_request($empleado_cve)){
            return 2;
        }
        return $mix;
        /*$result = $query->result_array();
        $query->free_result();
        return $result;*/
    }

    function another_request($empleado_cve=null){
        if(is_null($empleado_cve)){
            throw new Exception('La clave del empleado no existe.');
        }
        $this->db->limit(1);
        $this->db->where("empleado_cve",$empleado_cve);
        $this->db->where_not_in("cese_cve",array(8,9));
        $query = $this->db->get('evaluacion_solicitud');
        $num_result = $query->num_rows();
        $query->free_result();
        if($num_result > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function set_active($solicitud_id=null){
    }

    function detail_solitud($solicitud_id=null){
    }
}
