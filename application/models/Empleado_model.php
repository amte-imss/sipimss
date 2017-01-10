<?php
/*
 * Author: Rafael Rocha - www.rafaelrocha.net - info@rafaelrocha.net
 * 
 * Create Date: 13-09-2016
 * 
 * Version of MYSQL_to_PHP: 1.1
 * 
 * License: LGPL 
 * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

Class Empleado_model extends My_Model{

	private $EMP_NOMBRE; //varchar(30)
	private $EMP_APE_PATERNO; //varchar(30)
	private $EMP_APE_MATERNO; //varchar(30)
	private $EMP_CURP; //varchar(20)
	private $EMP_GENERO; //varchar(15)
	private $EMP_ANTIGUEDAD; //varchar(10)
	private $EMP_NUM_FUE_IMSS; //int(11)
	private $EMP_EMAIL; //varchar(30)
	private $EMP_TEL_LABORAL; //int(11)
	private $EMP_TEL_PARTICULAR; //int(11)
	private $CATEGORIA_CVE; //int(11)
	private $ADSCRIPCION_CVE; //varchar(20)
	private $EMPLEADO_CVE; //int(11)
	private $DELEGACION_CVE; //char(2)
	private $emp_eje_pro_cve; //int(11)
	private $eje_pro_cve; //int(11)
	private $TIP_CONTRATACION_CVE; //int(11)
	private $CESTADO_CIVIL_CVE; //int(11)
	private $EDO_LABORAL_CVE; //int(11)
	private $emp_matricula; //varchar(25)
	private $USUARIO_CVE; //int(11)
	private $DEPARTAMENTO_CVE; //int(11)
	private $PRESUPUESTAL_ADSCRIPCION_CVE; //varchar(20)
	private $emp_fch_ingreso; //date
	private $EMP_FCH_CREACION; //datetime
	private $emp_fch_nac; //date
	private $EMP_FCH_MODIF; //timestamp
	private $connection;

	function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get($args){
    	if(isset($args["fields"])){
    		if(is_array($args["fields"])){
    			//echo $args["fields"] = implode(",",$args["fields"]);
    		}
    		$this->db->select($args["fields"]);
    	}
    	if(isset($args["conditions"])){
    		$this->db->where($args["conditions"]);
    	}
    	$empleado = $this->db->get('empleado');
    	return $empleado->result_array();
    }

    /**
     * 
     * @param int $identificador
     */
    public function getEmpRelationships($args) {
    	if(isset($args["fields"])){
    		if(is_array($args["fields"])){
    			//echo $args["fields"] = implode(",",$args["fields"]);
    		}
    		$this->db->select($args["fields"]);
    	}
    	else{
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
	            'CP.PRE_NOMBRE as clavePresupuestal'
        	));
    	}
    	if(isset($args["conditions"])){
    		$this->db->where($args["conditions"]);
    	}
        
        $this->db->from('empleado AS EM');
        $this->db->join('cdelegacion AS CDEL', 'CDEL.DELEGACION_CVE = EM.DELEGACION_CVE', 'left');
        $this->db->join('ccategoria AS CCAT', 'CCAT.ID_CAT = EM.CATEGORIA_CVE', 'left');
        $this->db->join('adscripcion AS ADS', 'ADS.ADSCRIPCION_CVE = EM.ADSCRIPCION_CVE', 'left');
        $this->db->join('ctipo_contratacion AS CTC', 'EM.tip_contratacion_cve =  CTC.tip_contratacion_cve', 'left');
        $this->db->join('cdepartamento AS CD', 'CD.DEPARTAMENTO_CVE =  EM.DEPARTAMENTO_CVE', 'left');
        $this->db->join('cpresupuestal AS CP', 'CP.PRESUPUESTAL_CVE =  CD.PRESUPUESTAL_CVE  ', 'left');
        // $this->db->where('EM.EMPLEADO_CVE', $identificador);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * 
     * @param int $identificador
     */
    public function getEmpECD($args) {
    	if(isset($args["fields"])){
    		if(is_array($args["fields"])){
    			//echo $args["fields"] = implode(",",$args["fields"]);
    		}
    		$this->db->select($args["fields"]);
    	}
    	else{
    		$this->db->select(array(
	            'EMPLEADO_CVE as emp_id',
	            'EMP_NOMBRE as nombre',
	            'EMP_APE_PATERNO as apellidoPaterno',
	            'EMP_APE_MATERNO as apellidoMaterno',
	            'EMP_CURP as curp',
	            'emp_fch_nac as fecha_nacimiento',
	            'EMP_MATRICULA as matricula',
	            'DEL_NOMBRE as delegacion',
	            'NOM_CATEGORIA as nombreCategoria',
	            'EM.CATEGORIA_CVE as claveCategoria',
	            'ADS_NOM_AREA as nombreAreaAdscripcion',
	            'ADS_NOM_UNIDAD as nombreUnidadAdscripcion',
	            'EM.ADSCRIPCION_CVE as claveAdscripcion',
	            'EMP_TEL_PARTICULAR as estatusEmpleado',
        	));
    	}
    	if(isset($args["conditions"])){
    		$this->db->where($args["conditions"]);
    	}
        
        $this->db->from('empleado AS EM');
        $this->db->join('cdelegacion AS CDEL', 'CDEL.DELEGACION_CVE = EM.DELEGACION_CVE', 'left');
        $this->db->join('ccategoria AS CCAT', 'CCAT.ID_CAT = EM.CATEGORIA_CVE', 'left');
        $this->db->join('adscripcion AS ADS', 'ADS.ADSCRIPCION_CVE = EM.ADSCRIPCION_CVE', 'left');
        $this->db->join('ctipo_contratacion AS CTC', 'EM.tip_contratacion_cve =  CTC.tip_contratacion_cve', 'left');
        $this->db->join('cdepartamento AS CD', 'CD.DEPARTAMENTO_CVE =  EM.DEPARTAMENTO_CVE', 'left');
        $this->db->join('cpresupuestal AS CP', 'CP.PRESUPUESTAL_CVE =  CD.PRESUPUESTAL_CVE  ', 'left');
        /*
		'pendiente la relación del dictamen....

        */
        // $this->db->where('EM.EMPLEADO_CVE', $identificador);
        $query = $this->db->get();
        // echo "Hola mundo".$query->num_rows(); 
        if($query->num_rows() > 0){
        	return $query->row_array();
        }elseif($query->num_rows() > 1){
        	return $query->result_array();
        }
        
    }

	/**
	 * @return EMP_NOMBRE - varchar(30)
	 */
	public function getEMP_NOMBRE(){
		return $this->EMP_NOMBRE;
	}

	/**
	 * @return EMP_APE_PATERNO - varchar(30)
	 */
	public function getEMP_APE_PATERNO(){
		return $this->EMP_APE_PATERNO;
	}

	/**
	 * @return EMP_APE_MATERNO - varchar(30)
	 */
	public function getEMP_APE_MATERNO(){
		return $this->EMP_APE_MATERNO;
	}

	/**
	 * @return EMP_CURP - varchar(20)
	 */
	public function getEMP_CURP(){
		return $this->EMP_CURP;
	}

	/**
	 * @return EMP_GENERO - varchar(15)
	 */
	public function getEMP_GENERO(){
		return $this->EMP_GENERO;
	}

	/**
	 * @return EMP_ANTIGUEDAD - varchar(10)
	 */
	public function getEMP_ANTIGUEDAD(){
		return $this->EMP_ANTIGUEDAD;
	}

	/**
	 * @return EMP_NUM_FUE_IMSS - int(11)
	 */
	public function getEMP_NUM_FUE_IMSS(){
		return $this->EMP_NUM_FUE_IMSS;
	}

	/**
	 * @return EMP_EMAIL - varchar(30)
	 */
	public function getEMP_EMAIL(){
		return $this->EMP_EMAIL;
	}

	/**
	 * @return EMP_TEL_LABORAL - int(11)
	 */
	public function getEMP_TEL_LABORAL(){
		return $this->EMP_TEL_LABORAL;
	}

	/**
	 * @return EMP_TEL_PARTICULAR - int(11)
	 */
	public function getEMP_TEL_PARTICULAR(){
		return $this->EMP_TEL_PARTICULAR;
	}

	/**
	 * @return CATEGORIA_CVE - int(11)
	 */
	public function getCATEGORIA_CVE(){
		return $this->CATEGORIA_CVE;
	}

	/**
	 * @return ADSCRIPCION_CVE - varchar(20)
	 */
	public function getADSCRIPCION_CVE(){
		return $this->ADSCRIPCION_CVE;
	}

	/**
	 * @return EMPLEADO_CVE - int(11)
	 */
	public function getEMPLEADO_CVE(){
		return $this->EMPLEADO_CVE;
	}

	/**
	 * @return DELEGACION_CVE - char(2)
	 */
	public function getDELEGACION_CVE(){
		return $this->DELEGACION_CVE;
	}

	/**
	 * @return emp_eje_pro_cve - int(11)
	 */
	public function getemp_eje_pro_cve(){
		return $this->emp_eje_pro_cve;
	}

	/**
	 * @return eje_pro_cve - int(11)
	 */
	public function geteje_pro_cve(){
		return $this->eje_pro_cve;
	}

	/**
	 * @return TIP_CONTRATACION_CVE - int(11)
	 */
	public function getTIP_CONTRATACION_CVE(){
		return $this->TIP_CONTRATACION_CVE;
	}

	/**
	 * @return CESTADO_CIVIL_CVE - int(11)
	 */
	public function getCESTADO_CIVIL_CVE(){
		return $this->CESTADO_CIVIL_CVE;
	}

	/**
	 * @return EDO_LABORAL_CVE - int(11)
	 */
	public function getEDO_LABORAL_CVE(){
		return $this->EDO_LABORAL_CVE;
	}

	/**
	 * @return emp_matricula - varchar(25)
	 */
	public function getemp_matricula(){
		return $this->emp_matricula;
	}

	/**
	 * @return USUARIO_CVE - int(11)
	 */
	public function getUSUARIO_CVE(){
		return $this->USUARIO_CVE;
	}

	/**
	 * @return DEPARTAMENTO_CVE - int(11)
	 */
	public function getDEPARTAMENTO_CVE(){
		return $this->DEPARTAMENTO_CVE;
	}

	/**
	 * @return PRESUPUESTAL_ADSCRIPCION_CVE - varchar(20)
	 */
	public function getPRESUPUESTAL_ADSCRIPCION_CVE(){
		return $this->PRESUPUESTAL_ADSCRIPCION_CVE;
	}

	/**
	 * @return emp_fch_ingreso - date
	 */
	public function getemp_fch_ingreso(){
		return $this->emp_fch_ingreso;
	}

	/**
	 * @return EMP_FCH_CREACION - datetime
	 */
	public function getEMP_FCH_CREACION(){
		return $this->EMP_FCH_CREACION;
	}

	/**
	 * @return emp_fch_nac - date
	 */
	public function getemp_fch_nac(){
		return $this->emp_fch_nac;
	}

	/**
	 * @return EMP_FCH_MODIF - timestamp
	 */
	public function getEMP_FCH_MODIF(){
		return $this->EMP_FCH_MODIF;
	}

	/**
	 * @param Type: varchar(30)
	 */
	public function setEMP_NOMBRE($EMP_NOMBRE){
		$this->EMP_NOMBRE = $EMP_NOMBRE;
	}

	/**
	 * @param Type: varchar(30)
	 */
	public function setEMP_APE_PATERNO($EMP_APE_PATERNO){
		$this->EMP_APE_PATERNO = $EMP_APE_PATERNO;
	}

	/**
	 * @param Type: varchar(30)
	 */
	public function setEMP_APE_MATERNO($EMP_APE_MATERNO){
		$this->EMP_APE_MATERNO = $EMP_APE_MATERNO;
	}

	/**
	 * @param Type: varchar(20)
	 */
	public function setEMP_CURP($EMP_CURP){
		$this->EMP_CURP = $EMP_CURP;
	}

	/**
	 * @param Type: varchar(15)
	 */
	public function setEMP_GENERO($EMP_GENERO){
		$this->EMP_GENERO = $EMP_GENERO;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setEMP_ANTIGUEDAD($EMP_ANTIGUEDAD){
		$this->EMP_ANTIGUEDAD = $EMP_ANTIGUEDAD;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setEMP_NUM_FUE_IMSS($EMP_NUM_FUE_IMSS){
		$this->EMP_NUM_FUE_IMSS = $EMP_NUM_FUE_IMSS;
	}

	/**
	 * @param Type: varchar(30)
	 */
	public function setEMP_EMAIL($EMP_EMAIL){
		$this->EMP_EMAIL = $EMP_EMAIL;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setEMP_TEL_LABORAL($EMP_TEL_LABORAL){
		$this->EMP_TEL_LABORAL = $EMP_TEL_LABORAL;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setEMP_TEL_PARTICULAR($EMP_TEL_PARTICULAR){
		$this->EMP_TEL_PARTICULAR = $EMP_TEL_PARTICULAR;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setCATEGORIA_CVE($CATEGORIA_CVE){
		$this->CATEGORIA_CVE = $CATEGORIA_CVE;
	}

	/**
	 * @param Type: varchar(20)
	 */
	public function setADSCRIPCION_CVE($ADSCRIPCION_CVE){
		$this->ADSCRIPCION_CVE = $ADSCRIPCION_CVE;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setEMPLEADO_CVE($EMPLEADO_CVE){
		$this->EMPLEADO_CVE = $EMPLEADO_CVE;
	}

	/**
	 * @param Type: char(2)
	 */
	public function setDELEGACION_CVE($DELEGACION_CVE){
		$this->DELEGACION_CVE = $DELEGACION_CVE;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setemp_eje_pro_cve($emp_eje_pro_cve){
		$this->emp_eje_pro_cve = $emp_eje_pro_cve;
	}

	/**
	 * @param Type: int(11)
	 */
	public function seteje_pro_cve($eje_pro_cve){
		$this->eje_pro_cve = $eje_pro_cve;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setTIP_CONTRATACION_CVE($TIP_CONTRATACION_CVE){
		$this->TIP_CONTRATACION_CVE = $TIP_CONTRATACION_CVE;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setCESTADO_CIVIL_CVE($CESTADO_CIVIL_CVE){
		$this->CESTADO_CIVIL_CVE = $CESTADO_CIVIL_CVE;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setEDO_LABORAL_CVE($EDO_LABORAL_CVE){
		$this->EDO_LABORAL_CVE = $EDO_LABORAL_CVE;
	}

	/**
	 * @param Type: varchar(25)
	 */
	public function setemp_matricula($emp_matricula){
		$this->emp_matricula = $emp_matricula;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setUSUARIO_CVE($USUARIO_CVE){
		$this->USUARIO_CVE = $USUARIO_CVE;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setDEPARTAMENTO_CVE($DEPARTAMENTO_CVE){
		$this->DEPARTAMENTO_CVE = $DEPARTAMENTO_CVE;
	}

	/**
	 * @param Type: varchar(20)
	 */
	public function setPRESUPUESTAL_ADSCRIPCION_CVE($PRESUPUESTAL_ADSCRIPCION_CVE){
		$this->PRESUPUESTAL_ADSCRIPCION_CVE = $PRESUPUESTAL_ADSCRIPCION_CVE;
	}

	/**
	 * @param Type: date
	 */
	public function setemp_fch_ingreso($emp_fch_ingreso){
		$this->emp_fch_ingreso = $emp_fch_ingreso;
	}

	/**
	 * @param Type: datetime
	 */
	public function setEMP_FCH_CREACION($EMP_FCH_CREACION){
		$this->EMP_FCH_CREACION = $EMP_FCH_CREACION;
	}

	/**
	 * @param Type: date
	 */
	public function setemp_fch_nac($emp_fch_nac){
		$this->emp_fch_nac = $emp_fch_nac;
	}

	/**
	 * @param Type: timestamp
	 */
	public function setEMP_FCH_MODIF($EMP_FCH_MODIF){
		$this->EMP_FCH_MODIF = $EMP_FCH_MODIF;
	}

    /**
     * Close mysql connection
     */
	public function endempleado(){
		$this->connection->CloseMysql();
	}

	function toString(){
		print("hello abstract world ");
	}

}