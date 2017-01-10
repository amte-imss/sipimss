<?php

if (!function_exists('carga_catalogos_generales')) {

    /**
     * @autor  : LEAS   
     * @fecha creacion : 20/07/2016
     * @param array $array_entidades Nombre de las entidades que se van a cargar
     * @param array $data //array que va a devolver, si es vacio, lo devuelve con 
     * los catalogos cargados, si no, devuelve además lo que ya traía
     * @param array $array_where  //Conciciones por catálogo, requiere el nombre de la entidad como llave 
     * y un array como datos que contenga las condiciones involucradas, es decir, nombre del campo y valor
     * @param int $drop_option  //Por default regresa el dropdown_options en $drop_option=true; para que regrese 
     *                          todos los datos del catalogo, poner en "false" o cualquier otro valor
     * @param  $array_tipo_where  //Por default se asigna "where", esto implica puros AND, 
     * argumentos: "or_where", "" 
     * Importante registrar en catalogos_definidos
     * 
     * @return  array con los catálogos  cargados
     */
    function carga_catalogos_generales($array_entidades = array(), $data = array(), $array_where = null, $drop_option = true, $array_tipo_where = null, $array_order_by = null, $order_by_direccion = 'asc') {
        if (is_null($array_entidades)) {
            $array_entidades = array();
        }
        if (is_null($data)) {
            $data = array();
        }
        $CI = & get_instance();
        $CI->load->model('Catalogos_generales', 'cg');
//        $CI->load->config('general');//Requerido cargar
        $catalogos_propertis = $CI->config->item('catalogos_definidos'); //Contiene los campos de "id" y "descripcion" de los campos que forman el "dropdown_options" 
        $where = null;

        foreach ($array_entidades as $entidad) {
            $where = (isset($array_where[$entidad])) ? $array_where[$entidad] : null; //Verifica que exista un where relacionado a la entidad
            $order_by = (isset($array_order_by[$entidad]) AND ! is_null($array_order_by[$entidad])) ? $array_order_by[$entidad] . ' ' . $order_by_direccion : $catalogos_propertis[$entidad]['nombre'] . ' ' . $order_by_direccion; //Verifica que exista un order by relacionado a la entidad, si no existe lo ordena por nombre asendentemente

            $type_group_ = (isset($array_tipo_where[$entidad])) ? $array_tipo_where[$entidad] : 'AND'; //Verifica que exista un order by relacionado a la entidad, si no existe lo ordena por nombre asendentemente
            $tmp_result = $CI->cg->get_catalogo_general($entidad, $order_by, $where, $type_group_); //Funcion general que consulta la base de datos
            if ($drop_option) {
                $data[$entidad] = dropdown_options($tmp_result, $catalogos_propertis[$entidad]['id'], $catalogos_propertis[$entidad]['nombre']); //genera el "dropdown_options" y lo guarda en el array que retornará la función·
            } else {
                $data[$entidad] = $tmp_result; //Carga el resultado con todos los registros
            }
        }

        return $data;
    }

}

/**
 * Método que valida una variable; que exista, no sea nula o vacía
 * @autor 		: LEAS.
 * @modified 	: 
 * @param 		: mixed $valor Parámetro a validar
 * @return 		: bool. TRUE en caso de que exista, no sea vacía o nula de lo contrario devolverá FALSE
 */
if (!function_exists('carga_catalogos')) {

    function carga_catalogos_censo($array_catalogos = array(), $data = array(), $array_where = null) {
        if (isset($array_catalogos) AND is_null($array_catalogos)) {
            $array_catalogos = array();
        }
        if (isset($data) AND is_null($data)) {
            $data = array();
        }
        $CI = & get_instance();
        $CI->load->model('Catalogos_generales', 'cg');
        $tmp_result = null;

        foreach ($array_catalogos as $index) {
            switch ($index) {
                case 1://cmodalidad
                    $tmp_result = $CI->cg->get_cmodalidad();
                    $data['cmodalidad'] = dropdown_options($tmp_result, 'MODALIDAD_CVE', 'MOD_NOMBRE');
                    break;
                case 2://licenciatura
                    $tmp_result = $CI->cg->get_licenciatura();
                    $data['licenciatura'] = dropdown_options($tmp_result, 'LICENCIATURA_CVE', 'LIC_NOMBRE');
                    break;
                case 3://cmodulo
                    $tmp_result = $CI->cg->get_cmodulo();
                    $data['cmodulo'] = dropdown_options($tmp_result, 'MODULO_CVE', 'MODULO_NOMBRE');
                    break;
                case 4://carea
                    $tmp_result = $CI->cg->get_carea();
                    $data['carea'] = dropdown_options($tmp_result, 'AREA_CVE', 'AREA_NOMBRE');
                    break;
                case 5://cmateria
                    $tmp_result = $CI->cg->get_cmateria();
                    $data['cmateria'] = dropdown_options($tmp_result, 'MATERIA_CVE', 'MATERIA_NOMBRE');
                    break;
                case 6://ccurso
                    $tmp_result = $CI->cg->get_ccurso();
                    $data['ccurso'] = dropdown_options($tmp_result, 'CURSO_CVE', 'CUR_NOMBRE');
                    break;
                case 7://cinstitucion_avala
                    $tmp_result = $CI->cg->get_cinstitucion_avala();
                    $data['cinstitucion_avala'] = dropdown_options($tmp_result, 'INS_AVALA_CVE', 'IA_NOMBRE');
                    break;
                case 8://ctipo_actividad_docente
                    $tmp_result = $CI->cg->get_ctipo_actividad_docente();
                    $data['ctipo_actividad_docente'] = dropdown_options($tmp_result, 'TIP_ACT_DOC_CVE', 'TIP_ACT_DOC_NOMBRE');
                    break;
                case 9://crol_desempenia
                    $tmp_result = $CI->cg->get_crol_desempenia();
                    $data['crol_desempenia'] = dropdown_options($tmp_result, 'ROL_DESEMPENIA_CVE', 'ROL_DESEMPENIA');
                    break;
                case 10://ctipo_comprobante
                    $tmp_result = $CI->cg->get_ctipo_comprobante();
                    $data['ctipo_comprobante'] = dropdown_options($tmp_result, 'TIPO_COMPROBANTE_CVE', 'TIP_COM_NOMBRE');
                    break;
                case 11://ctipo_licenciatura
                    $tmp_result = $CI->cg->get_ctipo_licenciatura();
                    $data['ctipo_licenciatura'] = dropdown_options($tmp_result, 'TIP_LICENCIATURA_CVE', 'TIP_LIC_NOMBRE');
                    break;
                case 12://ctipo_curso
                    $tmp_result = $CI->cg->get_ctipo_curso();
                    $data['ctipo_curso'] = dropdown_options($tmp_result, 'TIP_CURSO_CVE', 'TIP_CUR_NOMBRE');
//                    pr($tmp_result);
                    break;
                case 13://ctipo_especialidad
                    $tmp_result = $CI->cg->get_ctipo_especialidad();
                    $data['ctipo_especialidad'] = dropdown_options($tmp_result, 'TIP_ESP_MEDICA_CVE', 'TIP_ESP_MED_NOMBRE');
                    break;
                case 14://ctipo_formacion_profesional
                    $tmp_result = $CI->cg->get_ctipo_formacion_profesional();
                    $data['ctipo_formacion_profesional'] = dropdown_options($tmp_result, 'TIP_FOR_PROF_CVE', 'TIP_FOR_PRO_NOMBRE');
                case 15://ctipo_participacion
                    $tmp_result = $CI->cg->get_ctipo_participacion();
                    $data['ctipo_participacion'] = dropdown_options($tmp_result, 'TIP_PARTICIPACION_CVE', 'TIP_PAR_NOMBRE');
                    break;
                case 16://ctipo_material
                    $tmp_result = $CI->cg->get_ctipo_material();
                    $data['ctipo_material'] = dropdown_options($tmp_result, 'TIP_MATERIAL_CVE', 'TIP_MAT_NOMBRE');
                    break;
                case 17://ctipo_material
                    $tmp_result = $CI->cg->get_cestado_civil();
                    $data['cestado_civil'] = dropdown_options($tmp_result, 'CESTADO_CIVIL_CVE', 'EDO_CIV_NOMBRE');
                    break;
                case 18://cejercicio_predominante
                    $tmp_result = $CI->cg->get_cejercicio_predominante();
                    $data['cejercicio_predominante'] = dropdown_options($tmp_result, 'EJER_PREDOMI_CVE', 'EJE_PRE_NOMBRE');
                    break;
                case 19://cejercicio_profesional
                    $tmp_result = $CI->cg->get_cejercicio_profesional();
                    $data['cejercicio_profesional'] = dropdown_options($tmp_result, 'EJE_PRO_CVE', 'EJE_PRO_NOMBRE');
                    break;
            }
        }
        return $data;
    }

}


if (!function_exists('registro_bitacora')) {

    /**
     * @autor : LEAS
     * @param type $usuario_cve : identificador del usuario que hizo la modificación
     * @param type $ruta : Ruta (controlador) donde se efectuo el cambio
     * @param type $entidad
     * @param type $reg_entidad_cve
     * @param type $parametros_json
     * @param type $operacion
     * @return type
     */
    function registro_bitacora($usuario_cve = null, $ruta = null, $entidad = null, $reg_entidad_cve = null, $parametros_json = null, $operacion = null) {
        $CI = & get_instance();
        $CI->load->config('general');

        $parametros = $CI->config->item('parametros_bitacora');
        $parametros['USUARIO_CVE'] = $usuario_cve; //Asigna id del usuario
        $parametros['BIT_OPERACION'] = $operacion; //insert,update o delete
        if (is_null($ruta) AND empty($ruta)) {
            $parametros['BIT_RUTA'] = $_SERVER['REQUEST_URI']; //Obtiene la ruta URI actual 
        }
        // Obtener ip del cliente
        $parametros['BIT_IP'] = get_ip_cliente(); //Le manda la ip del cliente
        $parametros['ENTIDAD'] = $entidad; //
        $parametros['REGISTRO_ENTIDAD_CVE'] = $reg_entidad_cve; //Id del registro agregado, modificado 
        $parametros['PARAMETROS_JSON'] = $parametros_json; //Le manda valor de json

        $CI->load->model('Catalogos_generales', 'cg');
        $result = $CI->cg->set_bitacora_gral($parametros); //Invoca la función para guardar bitacora
        return $result;
    }

}

if (!function_exists('iniciar_sesion')) {

    /**
     * 
     * @param type $directorio 
     * @param type $file_name
     * @param type $extencion
     */
    function iniciar_sesion($matricula, $passwd) {
        $CI = & get_instance();
        $CI->load->model('Login_model', 'lm');
        $result = array();
        $login_user = $CI->lm->set_login_user($matricula, $passwd); ///Verificar contra base de datos
        if ($login_user->cantidad_reg == 1) { ///Usuario existe en base de datos
            $password_encrypt = contrasenia_formato($matricula, $passwd);
            if ($login_user->usr_passwd == $password_encrypt) {
                $roles = $CI->lm->get_usuario_rol_modulo_sesion($login_user->user_cve); //Módulos por rol 
                $modulos_extra = $CI->lm->get_usuario_modulo_extra_sesion($login_user->user_cve); //Módulos extra por usuario 
                $CI->load->model('Catalogos_generales', 'cg');
                //                            pr($roles);
                $datos_session = array(
                    'usuario_logeado' => TRUE,
                    'identificador' => $login_user->user_cve,
                    'idempleado' => $login_user->empleado_cve,
                    'matricula' => $login_user->usr_matricula,
                    'nombre' => $login_user->usr_nombre,
                    'apaterno' => $login_user->usr_paterno,
                    'amaterno' => $login_user->usr_materno,
                    'mail' => $login_user->usr_correo,
                    'categoria_cve' => $login_user->usr_categoria,
                    'adscripcion_cve' => $login_user->usr_adscripcion,
                    'delegacion_cve' => $login_user->usr_delegacion,
                    'lista_roles' => crear_lista_asociativa_valores($roles, 'cve_rol', 'nombre_rol'), //Listado de roles del usuario
                    'lista_roles_modulos' => generar_propiedades_permisos($roles, $modulos_extra), //Permisos por rol (modulos de acceso)
                    'rol_seleccionado' => array() //Si tiene más de un rol asignado el usuario, permite que pueda seleccionar entre uno y otro
                );
                $result['datos_session'] = $datos_session;

                $parametros_log = $CI->config->item('parametros_log');
                $parametros_log['INICIO_SATISFACTORIO'] = 1;
                $parametros_log['USUARIO_CVE'] = $login_user->user_cve;
                $CI->lm->set_log_ususario_doc($parametros_log);
                $result['success'] = 1;
            } else {
                $result['success'] = 0;
            }
        } else {
            $result['success'] = 0;
        }
        $result['login'] = $login_user;
        return $result;
    }

}
if (!function_exists('generar_propiedades_permisos')) {

    function generar_propiedades_permisos($roles, $modulos_extra) {
        $existe_mod_extra = isset($modulos_extra) and is_null($modulos_extra) and empty($modulos_extra);
        $array_result = array();
        if (isset($roles) and ! is_null($roles) and ! empty($roles)) {//Debe existir rol
            if ($existe_mod_extra) {//Si existen roles extra (usuario-módulo)
                $array_result = evaluar_rol_con_modulos($roles, $modulos_extra);
//            pr($this->evaluar_rol($roles));
            } else {//Evalua unicamente la tabla de usuario - rol
                $array_result = evaluar_rol($roles);
            }
        }
        return $array_result;
    }

}

if (!function_exists('evaluar_rol')) {

    function evaluar_rol($roles) {
        $roles_formato = crear_formato_array($roles, 'cve_rol', FALSE);
        foreach ($roles_formato as $key => $value) {
//            $thiscrear_formato_modulos($value);
            $modulos_formatos = crear_formato_array($value, 'cve_modulo', TRUE);
//            pr($modulos_formatos);
            $roles_formato[$key] = $modulos_formatos;
        }
        return $roles_formato;
    }

}

if (!function_exists('crear_formato_array')) {

    function crear_formato_array($array_value, $key_ref, $not_index_auto_incrementables) {
        $array_modulo = array();
        $index = -1;
        if ($not_index_auto_incrementables) {
            /* Le asigna la llave de referencia $key_ref al formato y no le agrega 
             * index autoincrementables
             */
            for ($i = 0; $i < count($array_value); $i++) {
                $index = $array_value[$i][$key_ref];
                if (array_key_exists($index, $array_modulo)) {
                    $index_num_siguiente = count($array_modulo[$index]);
                    $array_modulo[$index] = array();
                } else {
                    $array_modulo[$index] = array();
                }
                foreach ($array_value[$i] as $key => $value) {
                    if ($key != $key_ref) {
                        $array_modulo[$index][$key] = $value;
                    }
                }
            }
        } else {
            /* Le  asigna un index auto incrementable que va desde "0" ,...., "n"
              al formato del array */
            for ($i = 0; $i < count($array_value); $i++) {
                $index = $array_value[$i][$key_ref];
                if (array_key_exists($index, $array_modulo)) {
                    $index_num_siguiente = count($array_modulo[$index]);
                    $array_modulo[$index][$index_num_siguiente] = array();
                } else {
                    $index_num_siguiente = 0;
                    $array_modulo[$index][$index_num_siguiente] = array();
                }
                foreach ($array_value[$i] as $key => $value) {
                    if ($key != $key_ref) {
                        $array_modulo[$index][$index_num_siguiente][$key] = $value;
                    }
                }
            }
        }
        return $array_modulo;
    }

}

if (!function_exists('get_is_valida_validacion_censo')) {

    function get_is_valida_validacion_censo($empleado = null, $rol = null, $estado_actual = null) {
        //Valida que el rol actual pueda enviar a validación
        $is_rol_valido = valida_acceso_rol_validador($rol, $estado_actual);
        if ($is_rol_valido === 1) {//Valida acceso del rol
            $CI = & get_instance();
            $prop_estado = $CI->config->item('estados_val_censo')[$estado_actual];
            //Hace la validación del estado actual para solicitar que se pueda validar (estados en de los cuales se puede enviar a validar)
            if (isset($prop_estado['est_apr_para_validacion'])) {
                $estados_considerados_validacion = $prop_estado['est_apr_para_validacion'];
                $CI->load->model('Validacion_docente_model', 'vdm');
                $result = $CI->vdm->get_is_envio_validacion($empleado, $estados_considerados_validacion);
//                pr($result);
            } else {//Si el estado no tiene permitido enviar a corrección, retorna 0
                return 0;
            }
        }
        //El rol seleccionado no puede enviar a validacion 
        return 0;
    }

}

if (!function_exists('get_condiciones_catalogos_modulos')) {

    function get_condiciones_catalogos_modulos($modulo_catalogo = null, $ccatalogo = null) {
        if (is_null($modulo_catalogo) AND is_null($ccatalogo)) {
            return array();
        }
        $CI = & get_instance();
        //Carga 
        $nom_identificador_entidad = $CI->config->item('catalogos_definidos')[$ccatalogo]['id'];
        $CI->load->model('Catalogos_generales', 'cg');
        $resultado = $CI->cg->get_condiciones_modulos_($modulo_catalogo, $nom_identificador_entidad);
        $array_result = array();
        foreach ($resultado as $value) {
            $array_result[] = $value['cve'];
        }
        return $array_result;
    }

}

    