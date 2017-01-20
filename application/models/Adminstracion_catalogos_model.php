<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Adminstracion_catalogos_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database('default');
        $this->db_encuestas = $this->load->database('encuestas', TRUE);
    }


    public function get_reglas_evaluacion()
    {
        
       /*select reglas_evaluacion_cve, (select name from public.mdl_role where id=rol_evaluado_cve) as evaluado,(select name from public.mdl_role where id=rol_evaluador_cve) as evaluador
		from encuestas.sse_reglas_evaluacion */        
        
        
        $this->db_encuestas->select("reglas_evaluacion_cve, (select name from public.mdl_role where id=rol_evaluado_cve) as evaluado,(select name from public.mdl_role where id=rol_evaluador_cve) as evaluador,
        	(case when tutorizado=1 then 'Tutorizado' else 'No tutorizado' end) as tutorizado");

        $this->db_encuestas->order_by('reglas_evaluacion_cve','asc');
        $query = $this->db_encuestas->get(' encuestas.sse_reglas_evaluacion');
        
        $data_reglas=0;
        $data_reglas = array();
            foreach ($query->result_array() as $row)
            {
                $nombres=$row['evaluador'].' - '.$row['evaluado'].'( '.$row['tutorizado'].' )';
                $data_reglas[$row['reglas_evaluacion_cve']] = $nombres; 
            }
        $query->free_result();

        return $data_reglas;       

    }


    public function get_tipo_cat()
    {
        
       /*select distinct(cve_tipo_categoria),nom_tipo_cat from ccategoria order by nom_tipo_cat */        
        
        
        $this->db->select("distinct(cve_tipo_categoria), nom_tipo_cat");

        $this->db->order_by('nom_tipo_cat','asc');
        $query = $this->db->get('ccategoria');
        
        $data_cat=0;
        $data_cat = array();
            foreach ($query->result_array() as $row)
            {
                
                $data_cat[$row['cve_tipo_categoria']] = $row['nom_tipo_cat']; 
            }
        $query->free_result();

        return $data_cat;       

    }

    public function get_proyecto()
    {
        
       /*select distinct(cve_tipo_categoria),nom_tipo_cat from ccategoria order by nom_tipo_cat */        
        
        
        $this->db->select("PROYECTO_CVE, PRO_NOMBRE");

        $this->db->order_by('PRO_NOMBRE','asc');
        $query = $this->db->get('proyecto');
        
        $data_cat=0;
        $data_cat = array();
            foreach ($query->result_array() as $row)
            {
                
                $data_cat[$row['PROYECTO_CVE']] = $row['PRO_NOMBRE']; 
            }
        $query->free_result();

        return $data_cat;       

    }


    public function get_rol_desempenia()
    {
        
       /*select distinct(cve_tipo_categoria),nom_tipo_cat from ccategoria order by nom_tipo_cat */        
        
        
        $this->db->select("ROL_DESEMPENIA_CVE, ROL_DESEMPENIA");

        $this->db->order_by('ROL_DESEMPENIA','asc');
        $query = $this->db->get('crol_desempenia');
        
        $data_cat=0;
        $data_cat = array();
            foreach ($query->result_array() as $row)
            {
                
                $data_cat[$row['ROL_DESEMPENIA_CVE']] = $row['ROL_DESEMPENIA']; 
            }
        $query->free_result();

        return $data_cat;       

    }


    public function get_rol_moodle()
    {
        
       /*select distinct(cve_tipo_categoria),nom_tipo_cat from ccategoria order by nom_tipo_cat */        
        
        
        $this->db_encuestas->select("id, name");

        $this->db_encuestas->order_by('name','asc');
        $query = $this->db_encuestas->get('public.mdl_role');
        
        $data_cat=0;
        $data_cat = array();
            foreach ($query->result_array() as $row)
            {
                
                $data_cat[$row['id']] = $row['name']; 
            }
        $query->free_result();

        return $data_cat;       
    }


    

}    
