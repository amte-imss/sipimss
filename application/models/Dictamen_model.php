<?php   defined('BASEPATH') OR exit('No direct script access allowed');

class Dictamen_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /*
     *  Obtiene los registros del historico de dictamenes correspondientes a un evaluador
     *  ya sean dictaminados, en proceso de dictamen o en correción.
     * 
     *  Param   idEvaluador         int             cve de empleado del eveluador que inica la busqueda.
     *  Param   segundoCampo        string          Nombre del segundo campo a buscar (opcional).
     *  Param   parametroSegundoCampo   string      Valor del segundo campo a buscar (opcional, se requiere si se mandó el anterior). 
     *  Return  Resultset array  
     */
    public function tablaDictamen($idEvaluador, $segundoCampo, $parametroSegundoCampo){
        if(isset($idEvaluador)){
            $sql2 = '';
            $sql = 'SELECT
                        hist_evaluacion_dic.HIST_EVALUACION_CVE,
                        hist_evaluacion_dic.TOTAL_PUNTOS,
                        hist_evaluacion_dic.EVA_FCH,
                        hist_evaluacion_dic.SOLICITUD_VAL_CVE,
                        hist_evaluacion_dic.EST_EVALUACION_CVE,
                        hist_evaluacion_dic.EVALUADOR_CVE,
                        empleado.EMP_NOMBRE,
                        empleado.EMP_APE_PATERNO,
                        empleado.EMP_APE_MATERNO,
                        empleado.emp_matricula,
                        empleado.EMPLEADO_CVE,
                        adscripcion.ADS_NOM_AREA,
                        adscripcion.ADS_NOM_UNIDAD,
                        cdelegacion.DEL_NOMBRE,
                        dictamen.CATEGORIA_CVE,
                        dictamen.ESTADO_DICTAMEN_CVE,
                        dictamen.DICTAMEN_CVE,
                        evaluacion_solicitud.VALIDACION_CVE,
                        ccategoria_dictamen.CAT_NOMBRE
                    FROM
                        hist_evaluacion_dic
                        INNER JOIN evaluador ON hist_evaluacion_dic.EVALUADOR_CVE = evaluador.ROL_EVALUADOR_CVE
                        INNER JOIN evaluacion_solicitud ON hist_evaluacion_dic.SOLICITUD_VAL_CVE = evaluacion_solicitud.VALIDACION_CVE
                        INNER JOIN empleado ON evaluacion_solicitud.EMPLEADO_CVE = empleado.EMPLEADO_CVE
                        LEFT JOIN adscripcion ON empleado.ADSCRIPCION_CVE = adscripcion.ADSCRIPCION_CVE
                        INNER JOIN cdelegacion ON empleado.DELEGACION_CVE = cdelegacion.DELEGACION_CVE
                        RIGHT JOIN dictamen ON dictamen.VALIDACION_CVE = evaluacion_solicitud.VALIDACION_CVE
                        INNER JOIN ccategoria_dictamen ON dictamen.CATEGORIA_CVE = ccategoria_dictamen.CATEGORIA_CVE
                    WHERE
                                hist_evaluacion_dic.IS_ACTUAL = 1 AND
                                evaluador.IS_ACTUAL = 1 AND
                                evaluacion_solicitud.CESE_CVE >= 7 AND
                                dictamen.IS_ACTUAL = 1 AND
                        evaluador.EMPLEADO_CVE ='.$idEvaluador.' '  ;
//            if($segundoCampo !== ''){
//                $sql2 .= " AND ".$segundoCampo." LIKE  '%".$parametroSegundoCampo."%' ";
//            }
//            $sql = $sql.$sql2;
            $resultset = $this->db->query($sql);
            return $resultset->result_array();
        }else{
            return 'ERROR no id evaluador';
        }
    
    }

    /*
     * Param    dictamen    string      id de dictamen asignado corresponde con la tabla de tipos de dictamenes  asignables.
     * Param    mensaje     string      mensaje de recomendaciones.
     * Return               bool        si se guardo correctamente true else false.        
     */
    public function guardaDictamen($solicEvalCve, $dictamenCve, $estadoCve, $empleadoCve, $mensaje ){
        $this->db->trans_start();
        $sql = "UPDATE dictamen SET IS_ACTUAL = 0 WHERE VALIDACION_CVE = ".$solicEvalCve." ";
        $this->db->query($sql);
        $sql = "UPDATE evaluacion_solicitud SET CESE_CVE = 8 WHERE VALIDACION_CVE = ".$solicEvalCve;
        $this->db->query($sql);
        $sql = "INSERT INTO dictamen "
                    . " (CATEGORIA_CVE, ESTADO_DICTAMEN_CVE, EMPLEADO_CVE, VALIDACION_CVE, IS_ACTUAL, OBSERVACIONES ) "
                    . " VALUES "
                    . " ( ".$dictamenCve.", ".$estadoCve.", ".$empleadoCve.", ".$solicEvalCve.", 1, '".$mensaje."'  ) ";
        $guardado = $this->db->query($sql);
        $this->db->trans_complete();
        return $guardado;
    }
    
    public function correcionDictamen($solicEvalCve,  $estadoCve, $empleadoCve, $mensaje ){
        $this->db->trans_start();
        $sql = "UPDATE dictamen SET IS_ACTUAL = 0 WHERE VALIDACION_CVE = ".$solicEvalCve." ";
        $this->db->query($sql);
        $sql = "UPDATE evaluacion_solicitud SET CESE_CVE = 9 WHERE VALIDACION_CVE = ".$solicEvalCve;
        $this->db->query($sql);
        $sql = "INSERT INTO dictamen "
                    . " ( ESTADO_DICTAMEN_CVE, EMPLEADO_CVE, VALIDACION_CVE, IS_ACTUAL, OBSERVACIONES ) "
                    . " VALUES "
                    . " ( ".$estadoCve.", ".$empleadoCve.", ".$solicEvalCve.", 1, '".$mensaje."'  ) ";
        $guardado = $this->db->query($sql);
        $this->db->trans_complete();
        return $guardado;
    }
    
}
