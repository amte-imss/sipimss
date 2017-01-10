<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el expediente
 * @version     : 1.2.2
 * @autor       : Mr. Guag
 * @date: 26/09/2016
 * @attributes: 
  config
 */
class Expediente_model extends MY_Model {

    var $string_values;
    private $config;
    private $secciones_config;
    protected $bloque_secciones;
    protected $seccion;
    protected $language;

    function __construct() {
        parent::__construct();
        $this->lang->load('interface');
        $this->string_values = $this->lang->line('interface')['model']; //Cargar textos utilizados en vista
        $this->setArray();
    }

    /* $this->bloque = array(
      "orden"=>"",
      "fields_labels"=>array("curso"=>"","tipo_curso"=>""),
      "secciones"=>array()
      ); */

    public function insert_evaluacion_curso($datos, $data) {
        $resultado = array('result' => null, 'msg' => '', 'data' => null);
        $this->db->trans_begin(); //Definir inicio de transacción

        $tabla = $this->config[$data['bloque']][$data['seccion']]['evaluacion']['entidad'];
        $campo = $this->config[$data['bloque']][$data['seccion']]['evaluacion']['pk'];
        $datos->{$campo} = $data['registro'];

        $this->db->insert($tabla, $datos); //Inserción de registro

        $data_id = $this->db->insert_id(); //Obtener identificador insertado

        if ($this->db->trans_status() === FALSE) {
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

    public function update_evaluacion_curso($datos, $data) {
        $resultado = array('result' => null, 'msg' => '', 'data' => null);
        $this->db->trans_begin(); //Definir inicio de transacción

        $tabla = $this->config[$data['bloque']][$data['seccion']]['evaluacion']['entidad'];
        $campo = $this->config[$data['bloque']][$data['seccion']]['evaluacion']['pk'];
        $datos->{$campo} = $data['registro'];

        $this->db->where('EVA_CURSO_CVE', $data['data_eva_curso']);
        $this->db->update($tabla, $datos); //Inserción de registro

        $data_id = $this->db->insert_id(); //Obtener identificador insertado

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $resultado['msg'] = $this->string_values['error'];
        } else {
            $this->db->trans_commit();
            $resultado['msg'] = $this->string_values['actualizacion'];
            $resultado['result'] = TRUE;
        }

        return $resultado;
    }

    public function get_evaluacion_curso_registro($tabla, $params = null) {
        $resultado = array();

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

        $query = $this->db->get($tabla); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    function setArray() {
        //Formacion
        $this->config = array(
            Enum_sec::B_FORMACION => array(
                //formacion en salud
                Enum_sec::S_FOR_PERSONAL_CONTINUA_SALUD => array(
                    "acronimo" => "fs",
                    "title" => "Formación en salud",
                    "entidad" => "emp_for_personal_continua_salud",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_FOR_PERSONAL_CONTINUA_SALUD . "_nombre" => "SUBTIP_NOMBRE",
                        "lbl_" . Enum_sec::S_FOR_PERSONAL_CONTINUA_SALUD . "_tipo" => "TIP_FORM_SALUD_NOMBRE",
                        "tp_cve" => "",
//                        "lbl" . Enum_sec::S_FOR_PERSONAL_CONTINUA_SALUD . "_tipo_curso" => "TIP_FORM_SALUD_NOMBRE"
                    ),
                    "model" => "Formacion_model",
                    "pk" => "FPCS_CVE",
                    "functions" => array(
                        "get" => "get_formacion_salud",
                        "view" => "formacion_salud_detalle",
                        "is_post" => 0,
                    ),
                    "evaluacion" => array(
                        "entidad" => "evaluacion_curso_fpcs",
                        "pk" => "FPCS_CVE"
                    )
                ),
                //formacion docente
                Enum_sec::S_FORMACION_PROFESIONAL => array(
                    "acronimo" => "fp",
                    "title" => "Formación en docente",
                    "entidad" => "emp_formacion_profesional",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_FORMACION_PROFESIONAL . "_nombre" => "SUB_FOR_PRO_NOMBRE",
                        "lbl_" . Enum_sec::S_FORMACION_PROFESIONAL . "_tipo" => "TIP_FOR_PRO_NOMBRE",
                        "tp_cve" => "",
                    ),
                    "pk" => "EMP_FORMACION_PROFESIONAL_CVE",
                    "model" => "Formacion_model",
                    "functions" => array(
                        "get" => "get_formacion_docente",
                        "view" => "formacion_docente_detalle",
                        "is_post" => 0,
                    ),
                    "activo" => 1,
                    "evaluacion" => array(
                        "entidad" => "evaluacion_curso_for_profesional",
                        "pk" => "EMP_FORMACION_PROFESIONAL_CVE"
                    )
                ),
            ),
            Enum_sec::B_ACTIVIDAD_DOCENTE => array(
                Enum_sec::S_EDUCACION_DISTANCIA => array(
                    "acronimo" => "ed",
                    "title" => "Educación a distancia",
                    "entidad" => "emp_educacion_distancia",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_EDUCACION_DISTANCIA . "_nombre" => "nom_curso",
                        "lbl_" . Enum_sec::S_EDUCACION_DISTANCIA . "_tipo" => "nombre_tp_actividad",
                        "tp_cve" => "ta_cve",
                    ),
//			        "pk"=>"EMP_EDU_DISTANCIA_CVE",
                    "pk" => "cve_actividad_docente",
                    "model" => "Actividad_docente_model",
                    "functions" => array(
                        "get" => "get_act_docente_edu_dist_unique",
                        "view" => "carga_datos_actividad",
                        "is_post" => 0,
                    ),
                    "evaluacion" => array(
                        "entidad" => "evaluacion_curso_edu_dis",
                        "pk" => "EMP_EDU_DISTANCIA_CVE"
                    )
                ),
                Enum_sec::S_ESP_MEDICA => array(
                    "acronimo" => "em",
                    "title" => "Especialidades",
                    "entidad" => "emp_esp_medica",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_ESP_MEDICA . "_nombre" => "nom_curso",
                        "lbl_" . Enum_sec::S_ESP_MEDICA . "_tipo" => "nombre_tp_actividad",
                        "tp_cve" => "ta_cve",
                    ),
//			        "pk"=>"EMP_ESP_MEDICA_CVE",
                    "pk" => "cve_actividad_docente",
                    "model" => "Actividad_docente_model",
                    "functions" => array(
                        "get" => "get_act_docente_espec_med_unique",
                        "view" => "carga_datos_actividad",
                        "is_post" => 0,
                    ),
                    "activo" => 1,
                    "evaluacion" => array(
                        "entidad" => "evaluacion_curso_esp_medica",
                        "pk" => "EMP_ESP_MEDICA_CVE"
                    )
                ),
                Enum_sec::S_ACTIVIDAD_DOCENTE => array(
                    "acronimo" => "ad",
                    "title" => "Actividad",
                    "entidad" => "emp_actividad_docente",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_ACTIVIDAD_DOCENTE . "_nombre" => "nom_curso",
                        "lbl_" . Enum_sec::S_ACTIVIDAD_DOCENTE . "_tipo" => "nombre_tp_actividad",
                        "tp_cve" => "ta_cve",
                    ),
//			        "pk"=>"EMP_ACT_DOCENTE_CVE ",
                    "pk" => "cve_actividad_docente",
                    "model" => "Actividad_docente_model",
                    "functions" => array(
                        "get" => "get_actividades_docente_unique",
                        "view" => "carga_datos_actividad",
                        "is_post" => 0,
                    ),
                    "evaluacion" => array(
                        "entidad" => "evaluacion_curso_act_docente",
                        "pk" => "EMP_ACT_DOCENTE_CVE"
                    )
                ),
            ),
            Enum_sec::B_BECAS_COMISIONES_LABORALES => array(
                Enum_sec::S_BECAS_LABORALES => array(
                    "acronimo" => "cl",
                    "title" => "Becas laborales",
                    "entidad" => "emp_beca",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_BECAS_LABORALES . "_nombre" => "nom_beca",
                        "lbl_" . Enum_sec::S_BECAS_LABORALES . "_tipo" => "nom_motivo_beca",
                        "tp_cve" => "",
                    ),
                    "pk" => "emp_beca_cve",
                    "model" => "Becas_comisiones_laborales_model",
                    "functions" => array(
                        "get" => "get_lista_becas",
                        "view" => "carga_datos_editar_beca",
                        "is_post" => 0,
                    ),
                ),
                Enum_sec::S_COMISIONES_LABORALES => array(
                    "acronimo" => "cl",
                    "entidad" => "emp_comision",
                    "title" => "",
                    "title" => "Comisiones laborales",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_COMISIONES_LABORALES . "_nombre" => "nom_comprobante",
                        "lbl_" . Enum_sec::S_COMISIONES_LABORALES . "_tipo" => "nom_tipo_comision",
                        "tp_cve" => "tipo_comision_cve",
                    ),
                    "pk" => "emp_comision_cve",
                    "model" => "Becas_comisiones_laborales_model",
                    "functions" => array(
                        "get" => "get_lista_comisiones",
                        "view" => "carga_datos_editar_beca",
                        "is_post" => 0,
                    ),
                ),
            ),
            Enum_sec::B_COMISIONES_ACADEMICAS => array(
                Enum_sec::S_COMISIONES_ACADEMICAS => array(
                    "acronimo" => "ca",
                    "title" => "",
                    "entidad" => "emp_comision",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_COMISIONES_ACADEMICAS . "_nombre" => "COM_ARE_NOMBRE",
                        "lbl_" . Enum_sec::S_COMISIONES_ACADEMICAS . "_tipo" => "TIP_COM_NOMBRE",
                        "tp_cve" => "TIP_COMISION_CVE",
                    ),
                    "pk" => "EMP_COMISION_CVE",
                    "model" => "Comision_academica_model",
                    "functions" => array(
                        "get" => "get_comision_academica",
                        "view" => "comision_academica_detalle",
                        "is_post" => 1,
                    ),
                    "evaluacion" => array(
                        "entidad" => "evaluacion_curso_comision",
                        "pk" => "EMP_COMISION_CVE"
                    )
                ),
            ),
            Enum_sec::B_INVESTIGACION_EDUCATIVA => array(
                Enum_sec::S_ACT_INV_EDU => array(
                    "acronimo" => "is",
                    "title" => "",
                    "entidad" => "emp_act_inv_edu",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_ACT_INV_EDU . "_nombre" => "nombre_investigacion",
                        "lbl_" . Enum_sec::S_ACT_INV_EDU . "_tipo" => "tpad_nombre",
                        "tp_cve" => "",
                    ),
//                    "pk" => "EAID_CVE",
                    "pk" => "cve_investigacion",
                    "model" => "Investigacion_docente_model",
                    "functions" => array(
                        "get" => "get_lista_datos_investigacion_docente",
                        "view" => "carga_datos_investigacion",
                        "is_post" => 0,
                    ),
                    "evaluacion" => array(
                        "entidad" => "evaluacion_curso_act_inv_edu",
                        "pk" => "EAID_CVE"
                    )
                ),
            ),
            Enum_sec::B_DIRECCION_TESIS => array(
                Enum_sec::S_DIRECCION_TESIS => array(
                    "acronimo" => "dt",
                    "title" => "",
                    "entidad" => "emp_comision",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_DIRECCION_TESIS . "_nombre" => "NIV_ACA_NOMBRE",
                        "lbl_" . Enum_sec::S_DIRECCION_TESIS . "_tipo" => "COM_ARE_NOMBRE",
                        "tp_cve" => "",
                    ),
                    "pk" => "EMP_COMISION_CVE",
                    "model" => "Direccion_tesis_model",
                    "functions" => array(
                        "get" => "get_lista_datos_direccion_tesis",
                        "view" => "direccion_tesis_detalle",
                        "is_post" => 0,
                    ),
                    "evaluacion" => array(
                        "entidad" => "evaluacion_curso_comision",
                        "pk" => "EMP_COMISION_CVE"
                    )
                ),
            ),
            Enum_sec::B_MATERIAL_EDUCATIVO => array(
                Enum_sec::S_MATERIA_EDUCATIVO => array(
                    "acronimo" => "me",
                    "title" => "",
                    "entidad" => "emp_materia_educativo",
                    "fields" => array(
                        "lbl_" . Enum_sec::S_MATERIA_EDUCATIVO . "_nombre" => "nombre_material",
                        "lbl_" . Enum_sec::S_MATERIA_EDUCATIVO . "_tipo" => "opt_tipo_material",
                        "tp_cve" => "",
                    ),
                    "pk" => "emp_material_educativo_cve",
                    "model" => "Material_educativo_model",
                    "functions" => array(
                        "get" => "get_lista_material_educativo",
                        "view" => "carga_datos_editar_material_educativo",
                        "is_post" => 0,
                    ),
                    "evaluacion" => array(
                        "entidad" => "evaluacion_curso_mat_edu",
                        "pk" => "MATERIA_EDUCATIVO_CVE"
                    )
                ),
            ),
        );
    }

    /**
     * Clase que gestiona el login
     * @version     : 1.2.2
     * @autor       : Mr. Guag
     * @date: 26/09/2016
     * @params: 
     *              $empleado_cve: Id del empleado
     *              $validado: si es nulo ignora la condición; si es TRUE busca todos los registros validados, 
     *                          si es FALSE busca todos los registros sin validación.
     *              $where: debe ir con el formato array("campo"=>valor)
     * @returns: Mixed array()
     * @comments: Usa el archivo de configuración con el arreglo asosiativo
     *               $config["get_secciones"]
     *               @acronimo : clave diminutiva para identificar el curso
     *               @entidad : Nombre de la entidad en la base de datos
     *               @curso : Nombre del curso o campo de donde se optiene el nombre del curso
     *               @tipo_curso: Tipo de curso 
     *               @pk : Llave primaria de la entidad en base de datos
     *               @model : nombre del modelo 
     *               @function : nombre de la funcion que regresa los datos de la sección
     */
    function getAll($empleado_cve = null, $validado = null, $where = null, $where_gral = null) {
        if (is_null($empleado_cve)) {
            throw new Exception('Id de usuario nulo');
        }

        //información del profesor
        $params = array("conditions" => array("empleado_cve" => $empleado_cve));

        $this->load->model("Empleado_model", "emp");
        $data["empleado"] = $this->emp->getEmpECD($params);

        if (!is_null($validado)) {
            if (is_bool($validado)) {
                $parametros["conditions"]["IS_VALIDO_PROFESIONALIZACION"] = $validado;
            } else {
                throw new Exception('La función espera un valor booleano');
            }
        }

        $this->lang->load('interface', 'spanish');

        //Etiquetas
        $data["string_value"] = $this->lang->line('interface_secd') + $this->lang->line('interface')["secciones"] + $this->lang->line('fields');
        // $data["cfg_actividad"] = $this->config->item("get_secciones");
        //$secciones = $this->config->item("secciones_model");
        $data["cfg_actividad"] = $this->config;
        //pr($bloque_seccion);
        foreach ($data["cfg_actividad"] as $b_key => $secciones) {
            foreach ($secciones as $key => $seccion) {
                // echo $b_key."--".$key;
                // pr($seccion);
                $params["conditions"] = (isset($where[$key]) && !is_null($where[$key])) ? array_merge($params["conditions"], $where[$key]) : $params["conditions"];

                if ($seccion["model"] != "") {
                    $this->load->model($seccion["model"], $seccion["acronimo"]);
                    $res = $this->{$seccion["acronimo"]}->$seccion["functions"]["get"]($params);
                    //unset($seccion["model"]);
                    //unset($seccion["functions"]);
                    if (!empty($res)) {
                        $data["bloques"]["bloque_" . $b_key]["seccion_" . $key] = $res;
                        $data["bloques"]["labels"][$seccion["acronimo"]] = "lbl_" . $seccion["acronimo"] . "_titulo";
                    }
                }
            }
            if (!isset($data["bloques"]["labels_bloque"][$b_key])) {
                $data["bloques"]["labels_bloque"][$b_key] = 'lbl_' . $b_key . '_titulo_b';
            }
        } //pr($data);
        return $data;
    }

    function getAllEvaluacion($params = null) {
        $this->lang->load('interface');

        $data = array();
        foreach ($this->config as $b_key => $secciones) {
            foreach ($secciones as $key => $seccion) {
                if (isset($seccion['evaluacion']) && array_key_exists('entidad', $seccion['evaluacion'])) {
                    $tmp_eva = $this->get_evaluacion_curso_registro($seccion["evaluacion"]['entidad'], $params); ////Obtenemos información de los registros
                    foreach ($tmp_eva as $key_tmp => $eval) {
                        $data["evaluaciones"][$b_key][$key][$eval[$seccion["evaluacion"]['pk']]] = $tmp_eva[$key_tmp];
                    }
                }
            }
        } //pr($data);
        return $data;
    }

    /**
     * Clase que gestiona el login
     * @version     : 1.2.2
     * @autor       : Mr. Guag
     * @date: 26/09/2016
     * @params: 
     *              $empleado_cve: Id del empleado
     *              $validado: si es nulo ignora la condición; si es TRUE busca todos los registros validados, 
     *                          si es FALSE busca todos los registros sin validación.
     *              $where: debe ir con el formato array("campo"=>valor)
     * @returns: Mixed array()
     * @comments: Usa el archivo de configuración con el arreglo asosiativo
     *               $config["get_secciones"]
     *               @acronimo : clave diminutiva para identificar el curso
     *               @entidad : Nombre de la entidad en la base de datos
     *               @curso : Nombre del curso o campo de donde se optiene el nombre del curso
     *               @tipo_curso: Tipo de curso 
     *               @pk : Llave primaria de la entidad en base de datos
     *               @model : nombre del modelo 
     *               @function : nombre de la funcion que regresa los datos de la sección
     */
    function getECV($empleado_cve = null, $validado = null, $where = null) {
        unset($this->config[Enum_sec::B_FORMACION][Enum_sec::S_FOR_PERSONAL_CONTINUA_SALUD]);
        unset($this->config[Enum_sec::B_BECAS_COMISIONES_LABORALES]);
        return $this->getAll($empleado_cve, $validado, $where);
    }

    function setFunctions($bloque = null, $seccion = null, $funcs = array()) {
        if (is_null($bloque) && is_null($seccion)) {
            foreach ($this->config as $b_key => $bloque) {
                foreach ($bloque as $key => $seccion) {
                    $this->config[$b_key][$key] = $funcs;
                }
            }
        } elseif (is_null($bloque) && !is_null($seccion)) {
            foreach ($this->config as $b_key => $bloque) {
                $this->config[$b_key][$seccion] = $funcs;
            }
        } elseif (!is_null($bloque) && is_null($seccion)) {
            foreach ($this->config[$bloque] as $key => $seccion) {
                $this->config[$bloque][$key] = $funcs;
            }
        } else {
            $this->config[$bloque][$seccion] = $funcs;
        }
    }

    function setCampos($bloque = null, $seccion = null, $campos = array()) {
        if (is_null($bloque) && is_null($seccion)) {
            foreach ($this->config as $b_key => $bloque) {
                foreach ($bloque as $key => $seccion) {
                    $this->config[$b_key][$key] = $campos;
                }
            }
        } elseif (is_null($bloque) && !is_null($seccion)) {
            foreach ($this->config as $b_key => $bloque) {
                $this->config[$b_key][$seccion] = $campos;
            }
        } elseif (!is_null($bloque) && is_null($seccion)) {
            foreach ($this->config[$bloque] as $key => $seccion) {
                $this->config[$bloque][$key] = $campos;
            }
        } else {
            $this->config[$bloque][$seccion] = $campos;
        }
    }

    /* @version     : 1.0.0
     * @autor       : Mr. Guag
     * @date: 05/10/2016
     * @params: $bloque: number, identificador del bloque
     * 			$section: number, identificador de la seccion
     * @description: Elimina una sección del arreglo de configuración
     */

    function rmSection($bloque, $section) {
        unset($this->config[$bloque][$section]);
    }

    /* @version     : 1.0.0
     * @autor       : Mr. Guag
     * @date: 05/10/2016
     * @params: $bloque: number, identificador del bloque
     * @description: Elimina una bloque del arreglo de configuración
     */

    function rmBloque($bloque) {
        unset($this->cfg_actividad[$bloque]);
    }

    /**
     * 
     * @author LEAS
     * @fecha 26/10/2016
     * @return type Obtiene todas las secciones de configuración para guardar información del docente
     */
    public function get_seccionConfigEspecificas($secciones_especificas) {
        if (is_null($this->secciones_config)) {
            $this->setArrayConfig_secciones();
        }
        return $this->secciones_config;
    }

    /**
     * 
     * @author LEAS
     * @fecha 26/10/2016
     * @param type $secciones_especificas Secciones especificas de configuracion requerida
     * 
     */
    public function get_seccionConfig($secciones_especificas) {
        if (is_null($this->secciones_config)) {
            $this->setArrayConfig_secciones();
        }
        $tem_secciones_config = array();
        foreach ($secciones_especificas as $value) {//Obtiene unicamente los datos de la configuración que se requiere
            $tem_secciones_config[$value] = $this->secciones_config[$value];
        }
        return $tem_secciones_config;
    }

    /**
     * @author LEAS
     * @fecha 26/10/2016
     * Genera el array de configuraciones de las secciones
     */
    private function setArrayConfig_secciones() {
        //Formacion
        $this->secciones_config = array(
            //formacion en salud
            Enum_sec::S_FOR_PERSONAL_CONTINUA_SALUD => array(
                "bloque" => Enum_sec::B_FORMACION,
                "acronimo" => "fs",
                "title" => "Formación en salud",
                "entidad" => "emp_for_personal_continua_salud",
                "entidad_validacion_curso" => "hist_fpcs_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_FOR_PERSONAL_CONTINUA_SALUD . "_nombre" => "SUBTIP_NOMBRE",
                    "lbl_" . Enum_sec::S_FOR_PERSONAL_CONTINUA_SALUD . "_tipo" => "TIP_FORM_SALUD_NOMBRE",
                    "tp_cve" => "",
//                        "lbl" . Enum_sec::S_FOR_PERSONAL_CONTINUA_SALUD . "_tipo_curso" => "TIP_FORM_SALUD_NOMBRE"
                ),
                "model" => "Formacion_model",
                "pk" => "FPCS_CVE",
                "functions" => array(
                    "get" => "get_formacion_salud",
                    "view" => "formacion_salud_detalle",
                    "is_post" => 0,
                ),
                "evaluacion" => array(
                    "entidad" => "evaluacion_curso_fpcs",
                    "pk" => "FPCS_CVE"
                )
            ),
            //formacion docente
            Enum_sec::S_FORMACION_PROFESIONAL => array(
                "bloque" => Enum_sec::B_FORMACION,
                "acronimo" => "fp",
                "title" => "Formación en docente",
                "entidad" => "emp_formacion_profesional",
                "entidad_validacion_curso" => "hist_efp_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_FORMACION_PROFESIONAL . "_nombre" => "SUB_FOR_PRO_NOMBRE",
                    "lbl_" . Enum_sec::S_FORMACION_PROFESIONAL . "_tipo" => "TIP_FOR_PRO_NOMBRE",
                    "tp_cve" => "",
                ),
                "pk" => "EMP_FORMACION_PROFESIONAL_CVE",
                "model" => "Formacion_model",
                "functions" => array(
                    "get" => "get_formacion_docente",
                    "view" => "formacion_docente_detalle",
                    "is_post" => 0,
                ),
                "activo" => 1,
                "evaluacion" => array(
                    "entidad" => "evaluacion_curso_for_profesional",
                    "pk" => "EMP_FORMACION_PROFESIONAL_CVE"
                )
            ),
            Enum_sec::S_EDUCACION_DISTANCIA => array(
                "bloque" => Enum_sec::B_ACTIVIDAD_DOCENTE,
                "acronimo" => "ed",
                "title" => "Educación a distancia",
                "entidad" => "emp_educacion_distancia",
                "entidad_validacion_curso" => "hist_edd_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_EDUCACION_DISTANCIA . "_nombre" => "nom_curso",
                    "lbl_" . Enum_sec::S_EDUCACION_DISTANCIA . "_tipo" => "nombre_tp_actividad",
                    "tp_cve" => "ta_cve",
                ),
//			        "pk"=>"EMP_EDU_DISTANCIA_CVE",
                "pk" => "cve_actividad_docente",
                "model" => "Actividad_docente_model",
                "functions" => array(
                    "get" => "get_act_docente_edu_dist_unique",
                    "view" => "carga_datos_actividad",
                    "is_post" => 0,
                ),
                "evaluacion" => array(
                    "entidad" => "evaluacion_curso_edu_dis",
                    "pk" => "EMP_EDU_DISTANCIA_CVE"
                )
            ),
            Enum_sec::S_ESP_MEDICA => array(
                "bloque" => Enum_sec::B_ACTIVIDAD_DOCENTE,
                "acronimo" => "em",
                "title" => "Especialidades",
                "entidad" => "emp_esp_medica",
                "entidad_validacion_curso" => "hist_eem_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_ESP_MEDICA . "_nombre" => "nom_curso",
                    "lbl_" . Enum_sec::S_ESP_MEDICA . "_tipo" => "nombre_tp_actividad",
                    "tp_cve" => "ta_cve",
                ),
//			        "pk"=>"EMP_ESP_MEDICA_CVE",
                "pk" => "cve_actividad_docente",
                "model" => "Actividad_docente_model",
                "functions" => array(
                    "get" => "get_act_docente_espec_med_unique",
                    "view" => "carga_datos_actividad",
                    "is_post" => 0,
                ),
                "activo" => 1,
                "evaluacion" => array(
                    "entidad" => "evaluacion_curso_esp_medica",
                    "pk" => "EMP_ESP_MEDICA_CVE"
                )
            ),
            Enum_sec::S_ACTIVIDAD_DOCENTE => array(
                "bloque" => Enum_sec::B_ACTIVIDAD_DOCENTE,
                "acronimo" => "ad",
                "title" => "Actividad",
                "entidad" => "emp_actividad_docente",
                "entidad_validacion_curso" => "hist_efpd_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_ACTIVIDAD_DOCENTE . "_nombre" => "nom_curso",
                    "lbl_" . Enum_sec::S_ACTIVIDAD_DOCENTE . "_tipo" => "nombre_tp_actividad",
                    "tp_cve" => "ta_cve",
                ),
//			        "pk"=>"EMP_ACT_DOCENTE_CVE ",
                "pk" => "cve_actividad_docente",
                "model" => "Actividad_docente_model",
                "functions" => array(
                    "get" => "get_actividades_docente_unique",
                    "view" => "carga_datos_actividad",
                    "is_post" => 0,
                ),
                "evaluacion" => array(
                    "entidad" => "evaluacion_curso_act_docente",
                    "pk" => "EMP_ACT_DOCENTE_CVE"
                )
            ),
            Enum_sec::S_BECAS_LABORALES => array(
                "bloque" => Enum_sec::B_BECAS_COMISIONES_LABORALES,
                "acronimo" => "cl",
                "title" => "Becas laborales",
                "entidad" => "emp_beca",
                "entidad_validacion_curso" => "hist_beca_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_BECAS_LABORALES . "_nombre" => "nom_beca",
                    "lbl_" . Enum_sec::S_BECAS_LABORALES . "_tipo" => "nom_motivo_beca",
                    "tp_cve" => "",
                ),
                "pk" => "emp_beca_cve",
                "model" => "Becas_comisiones_laborales_model",
                "functions" => array(
                    "get" => "get_lista_becas",
                    "view" => "carga_datos_editar_beca",
                    "is_post" => 0,
                ),
            ),
            Enum_sec::S_COMISIONES_LABORALES => array(
                "bloque" => Enum_sec::B_BECAS_COMISIONES_LABORALES,
                "acronimo" => "cl",
                "entidad" => "emp_comision",
                "title" => "",
                "title" => "Comisiones laborales",
                "entidad_validacion_curso" => "hist_comision_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_COMISIONES_LABORALES . "_nombre" => "nom_comprobante",
                    "lbl_" . Enum_sec::S_COMISIONES_LABORALES . "_tipo" => "nom_tipo_comision",
                    "tp_cve" => "tipo_comision_cve",
                ),
                "pk" => "emp_comision_cve",
                "model" => "Becas_comisiones_laborales_model",
                "functions" => array(
                    "get" => "get_lista_comisiones",
                    "view" => "carga_datos_editar_beca",
                    "is_post" => 0,
                ),
            ),
            Enum_sec::S_COMISIONES_ACADEMICAS => array(
                "bloque" => Enum_sec::B_COMISIONES_ACADEMICAS,
                "acronimo" => "ca",
                "title" => "",
                "entidad" => "emp_comision",
                "entidad_validacion_curso" => "hist_comision_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_COMISIONES_ACADEMICAS . "_nombre" => "COM_ARE_NOMBRE",
                    "lbl_" . Enum_sec::S_COMISIONES_ACADEMICAS . "_tipo" => "TIP_COM_NOMBRE",
                    "tp_cve" => "TIP_COMISION_CVE",
                ),
                "pk" => "EMP_COMISION_CVE",
                "model" => "Comision_academica_model",
                "functions" => array(
                    "get" => "get_comision_academica",
                    "view" => "comision_academica_detalle",
                    "is_post" => 1,
                ),
                "evaluacion" => array(
                    "entidad" => "evaluacion_curso_comision",
                    "pk" => "EMP_COMISION_CVE"
                )
            ),
            Enum_sec::S_ACT_INV_EDU => array(
                "bloque" => Enum_sec::B_INVESTIGACION_EDUCATIVA,
                "acronimo" => "is",
                "title" => "",
                "entidad" => "emp_act_inv_edu",
                "entidad_validacion_curso" => "hist_eaid_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_ACT_INV_EDU . "_nombre" => "nombre_investigacion",
                    "lbl_" . Enum_sec::S_ACT_INV_EDU . "_tipo" => "tpad_nombre",
                    "tp_cve" => "",
                ),
//                    "pk" => "EAID_CVE",
                "pk" => "cve_investigacion",
                "model" => "Investigacion_docente_model",
                "functions" => array(
                    "get" => "get_lista_datos_investigacion_docente",
                    "view" => "carga_datos_investigacion",
                    "is_post" => 0,
                ),
                "evaluacion" => array(
                    "entidad" => "evaluacion_curso_act_inv_edu",
                    "pk" => "EAID_CVE"
                )
            ),
            Enum_sec::S_DIRECCION_TESIS => array(
                "bloque" => Enum_sec::B_DIRECCION_TESIS,
                "acronimo" => "dt",
                "title" => "",
                "entidad" => "emp_comision",
                "entidad_validacion_curso" => "hist_comision_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_DIRECCION_TESIS . "_nombre" => "NIV_ACA_NOMBRE",
                    "lbl_" . Enum_sec::S_DIRECCION_TESIS . "_tipo" => "COM_ARE_NOMBRE",
                    "tp_cve" => "",
                ),
                "pk" => "EMP_COMISION_CVE",
                "model" => "Direccion_tesis_model",
                "functions" => array(
                    "get" => "get_lista_datos_direccion_tesis",
                    "view" => "direccion_tesis_detalle",
                    "is_post" => 0,
                ),
                "evaluacion" => array(
                    "entidad" => "evaluacion_curso_comision",
                    "pk" => "EMP_COMISION_CVE"
                )
            ),
            Enum_sec::S_MATERIA_EDUCATIVO => array(
                "bloque" => Enum_sec::S_MATERIA_EDUCATIVO,
                "acronimo" => "me",
                "title" => "",
                "entidad" => "emp_materia_educativo",
                "entidad_validacion_curso" => "hist_me_validacion_curso",
                "pk_validacion_curso" => "HIST_VAL_CURSO_CVE",
                "fields" => array(
                    "lbl_" . Enum_sec::S_MATERIA_EDUCATIVO . "_nombre" => "nombre_material",
                    "lbl_" . Enum_sec::S_MATERIA_EDUCATIVO . "_tipo" => "opt_tipo_material",
                    "tp_cve" => "",
                ),
                "pk" => "emp_material_educativo_cve",
                "model" => "Material_educativo_model",
                "functions" => array(
                    "get" => "get_lista_material_educativo",
                    "view" => "carga_datos_editar_material_educativo",
                    "is_post" => 0,
                ),
                "evaluacion" => array(
                    "entidad" => "evaluacion_curso_mat_edu",
                    "pk" => "MATERIA_EDUCATIVO_CVE"
                )
            ),
        );
    }

}

?>