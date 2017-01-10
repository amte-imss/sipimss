<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Validacion_docente_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
        $this->string_values = $this->lang->line('interface')['model']; //Cargar textos utilizados en vista
    }

    public function get_buscar_docentes_validar($params) {
        $arra_buscar_por = array(
            'matricula' => 'em.EMP_MATRICULA',
            'clavecategoria' => 'em.CATEGORIA_CVE',
            'nombre' => array('em.EMP_NOMBRE', 'em.EMP_APE_PATERNO', 'em.EMP_APE_MATERNO')
        );
        $busqueda_text = $arra_buscar_por[$params['menu_busqueda']]; //busqueda en texto por
//        $select = array('em.EMPLEADO_CVE "empleado_cve"', 'em.EMP_MATRICULA "matricula"',
//            'concat(em.EMP_NOMBRE, " ", em.EMP_APE_PATERNO, " ",em.EMP_APE_MATERNO) as "nom_docente"',
//            'hv.VAL_ESTADO_CVE "estado_validacion"', 'cve.VAL_EST_NOMBRE "nombre_estado_validacion"',
//            'if(hv.VAL_COMENTARIO is null or hv.VAL_COMENTARIO = "",0,1) "is_comentario"', 'hv.VAL_FCH "fecha_estado_validacion"',
//            'hv.VALIDADOR_CVE  "validador_cve"', 'em.ADSCRIPCION_CVE "emp_adscripcion_cve"',
//            'em.DELEGACION_CVE "emp_delegacion_cve"', 'em.CATEGORIA_CVE "emp_categoria"',
//            'hv.VALIDACION_CVE "hist_validacion_cve"', 'vg.VALIDACION_GRAL_CVE "validaor_grl_cve"',
//            'em.USUARIO_CVE "usuario_cve"', 'vg.VAL_CONV_CVE "convocatoria_cve"', 'cc.nom_categoria "nom_categoria"'
//        );
        $select = array('em.EMPLEADO_CVE "empleado_cve"', 'em.EMP_MATRICULA "matricula"',
            'concat(em.EMP_NOMBRE, " ", em.EMP_APE_PATERNO, " ",em.EMP_APE_MATERNO) as "nom_docente"',
            'em.ADSCRIPCION_CVE "emp_adscripcion_cve"', 'em.DELEGACION_CVE "emp_delegacion_cve"',
            'em.CATEGORIA_CVE "emp_categoria"', 'vg.VALIDACION_GRAL_CVE "validaor_grl_cve"',
            'em.USUARIO_CVE "usuario_cve"', 'vg.VAL_CONV_CVE "convocatoria_cve"',
            'cc.nom_categoria "nom_categoria"', 'cd.DEL_NOMBRE "nom_delegacion"',
            'concat(em.ADSCRIPCION_CVE, " ", cdp.nom_dependencia) "unidad_adscripcion"'
        );

        $this->db->start_cache();/**         * *************Inicio cache  *************** */
//        $this->db->from('cdepartamento as dp');
        $this->db->join('empleado em', 'em.EMPLEADO_CVE = vg.EMPLEADO_CVE');
        $this->db->join('ccategoria cc', 'cc.id_cat = em.CATEGORIA_CVE', 'left');
        $this->db->join('cdelegacion cd', 'cd.DELEGACION_CVE = em.DELEGACION_CVE', 'left');
        $this->db->join('cdepartamento cdp', 'cdp.departamento_cve = em.ADSCRIPCION_CVE', 'left');
//        $this->db->join('hist_validacion hv', 'hv.VALIDACION_GRAL_CVE = vg.VALIDACION_GRAL_CVE');
//        $this->db->join('cvalidacion_estado cve', 'cve.VAL_ESTADO_CVE = hv.VAL_ESTADO_CVE');
        //where que son obligatorios
        $this->db->where('em.EDO_LABORAL_CVE', 1);
//        $this->db->where('hv.IS_ACTUAL', 1);

        switch ($params['rol_seleccionado']) {
            case Enum_rols::Profesionalizacion:
                if ($params['DELEGACION_CVE'] > 0) {
                    $this->db->where('em.DELEGACION_CVE', $params['DELEGACION_CVE']);
                }
                if ($params['VAL_CON_CVE'] > 0) {
                    $this->db->where('vg.VAL_CONV_CVE', $params['VAL_CON_CVE']);
                }
//                pr($params['departamento_cve']);
                if (!empty($params['departamento_cve'])) {
                    $this->db->where('em.ADSCRIPCION_CVE', $params['departamento_cve']);
                }
                break;
            case Enum_rols::Validador_N2:
                if ($params['departamento_cve'] > 0) {
                    $this->db->where('em.ADSCRIPCION_CVE', $params['departamento_cve']);
                }
                if (isset($params['DELEGACION_CVE'])) {
                    $this->db->where('em.DELEGACION_CVE', $params['DELEGACION_CVE']);
                } else {//Condision de seguridad, si el validador no existe en la entidad validación
                    $this->db->where('em.DELEGACION_CVE', 0);
                }
                if (isset($params['VAL_CON_CVE'])) {
                    $this->db->where('vg.VAL_CONV_CVE', $params['VAL_CON_CVE']);
                } else {//Condision de seguridad, si el validador no existe en la entidad validación
                    $this->db->where('vg.VAL_CONV_CVE', 0);
                }
                break;
            case Enum_rols::Validador_N1:
                if (isset($params['DELEGACION_CVE'])) {
                    $this->db->where('em.DELEGACION_CVE', $params['DELEGACION_CVE']);
                } else {//Condision de seguridad, si el validador no existe en la entidad validación
                    $this->db->where('em.DELEGACION_CVE', 0);
                }
                $this->db->where('em.ADSCRIPCION_CVE', $params['DEPARTAMENTO_CVE']);
                if (isset($params['VAL_CON_CVE'])) {
                    $this->db->where('vg.VAL_CONV_CVE', $params['VAL_CON_CVE']);
                } else {//Condision de seguridad, si el validador no existe en la entidad validación
                    $this->db->where('vg.VAL_CONV_CVE', 0);
                }
                break;
        }


        if (!empty($params['cvalidacion_estado'])) {//where estado de la validación, no es obligatorio
            $this->db->where('hv.VAL_ESTADO_CVE', $params['cvalidacion_estado']);
        }

        if (is_array($busqueda_text)) {//si es un array lo recorre, ejemplo es la concatenación de nombre, ap y am
            foreach ($busqueda_text as $value) {
                $this->db->or_like($value, $params['buscador_docente']);
            }
        } else {//pone un like para buscar por matricula, o categoria
            $this->db->like($busqueda_text, $params['buscador_docente']);
        }
//        group by em.EMP_MATRICULA
        $this->db->group_by('em.EMP_MATRICULA');
        $this->db->stop_cache(); //************************************Fin cache
        //Cuenta la cantidad de registros
        $num_rows = $this->db->query($this->db->select('count(*) as total')->get_compiled_select('validacion_gral as vg'))->result();
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
                $orden = 'em.EMP_NOMBRE, em.EMP_APE_PATERNO, em.EMP_APE_MATERNO';
            }
            $this->db->order_by($orden, $order_type);
        }

        $ejecuta = $this->db->get('validacion_gral as vg'); //Prepara la consulta ( aún no la ejecuta)
        $query = $ejecuta->result_array();
//        pr($this->db->last_query());
//        $query->free_result();
        $this->db->flush_cache(); //Limpia la cache
        $result['result'] = $query;
        $result['total'] = $num_rows[0]->total;
        return $result;
    }

    public function get_obtener_empleado($id_empleado = null) {
        if (is_null($id_empleado)) {
            return array();
        }
        $select = array('e.EMP_MATRICULA "matricula"', 'e.EMPLEADO_CVE "empleado_cve"', 'e.EDO_LABORAL_CVE "status"'
            , 'concat(e.EMP_MATRICULA, "  " ,e.EMP_NOMBRE, e.EMP_APE_PATERNO, e.EMP_APE_MATERNO) as "nom_empleado"'
            , 'e.EMP_NOMBRE "nombre"', 'e.EMP_APE_PATERNO "paterno"', 'e.EMP_APE_MATERNO "materno"'
            , 'id_cat "categoria_id"', 'c.des_clave "desc_categoria_cve"', 'nom_categoria "nom_categoria"'
            , 'e.DELEGACION_CVE "delegacion_cve"', 'dl.DEL_NOMBRE "nom_delegacion"'
            , 'dp.departamento_cve "adscripcion_cve"', 'dp.nom_dependencia "nom_dependencia_adscripcion"'
        );

        $this->db->join('empleado e', 'e.CATEGORIA_CVE = c.id_cat');
        $this->db->join('cdepartamento dp', 'dp.departamento_cve = e.ADSCRIPCION_CVE');
        $this->db->join('cdelegacion dl', 'dl.DELEGACION_CVE = dp.cve_delegacion');

        $this->db->where('e.EMPLEADO_CVE', $id_empleado);
        $this->db->select($select);

        $ejecuta = $this->db->get('ccategoria as c'); //
        $query = $ejecuta->result_array();
        return $query;
    }

    public function delete_vinculo_validador($id_validador = null) {
        $result_asignar_validador['result'] = -1;
        $result_asignar_validador['entidad'] = '';
        if (is_null($id_validador)) {
            return $result_asignar_validador;
        }
        $res = $this->get_validador($id_validador);
        if (!empty($res)) {
            $res = $res[0];
            $this->db->where('VALIDADOR_CVE', $id_validador);
            $this->db->delete('validador');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $result_asignar_validador['result'] = $id_validador;
                $result_asignar_validador['entidad'] = $res;
            }
        }
        return $result_asignar_validador;
    }

    /**
     * 
     * @param autor LEAS
     * @param type $validador
     * @return type
     */
    public function get_validador($validador = null) {
        if (!is_null($validador)) {
            $this->db->where('VALIDADOR_CVE', $validador);
        }
        $query = $this->db->get('validador');
        $array_validador = $query->result_array();
        $query->free_result();
        return $array_validador;
    }

    public function insert_designar_validador($parametros) {
        if (empty($parametros)) {
            return -1;
        }
        $parametros['DELEGACION_CVE'] = (strlen($parametros['DELEGACION_CVE']) < 2) ? '0' . $parametros['DELEGACION_CVE'] : $parametros['DELEGACION_CVE'];
        $this->db->insert('validador', $parametros); //Almacena usuario
        $obtiene_id_validador_designado = $this->db->insert_id();
//        pr($this->db->last_query());
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return -1;
        } else {
            return $obtiene_id_validador_designado;
        }
    }

    public function get_buscar_empleado_delegacion($id_empleado = null, $id_delegacion = null) {
        if (is_null($id_empleado)) {
            return array();
        }
        $select = array('e.EMP_MATRICULA "matricula"', 'e.EMPLEADO_CVE "empleado_cve"', 'e.EDO_LABORAL_CVE "status"'
            , 'concat(e.EMP_MATRICULA, "  " ,e.EMP_NOMBRE, e.EMP_APE_PATERNO, e.EMP_APE_MATERNO) as "nom_empleado"'
            , 'e.EMP_NOMBRE "nombre"', 'e.EMP_APE_PATERNO "paterno"', 'e.EMP_APE_MATERNO "materno"'
            , 'id_cat "categoria_id"', 'c.des_clave "desc_categoria_cve"', 'nom_categoria "nom_categoria"'
            , 'e.DELEGACION_CVE "delegacion_cve"', 'dl.DEL_NOMBRE "nom_delegacion"'
            , 'dp.departamento_cve "adscripcion_cve"', 'dp.nom_dependencia "nom_dependencia_adscripcion"'
        );

        $this->db->join('empleado e', 'e.CATEGORIA_CVE = c.id_cat');
        $this->db->join('cdepartamento dp', 'dp.departamento_cve = e.ADSCRIPCION_CVE');
        $this->db->join('cdelegacion dl', 'dl.DELEGACION_CVE = dp.cve_delegacion');

        $this->db->where('e.EMP_MATRICULA', $id_empleado);
        $this->db->where('e.DELEGACION_CVE', $id_delegacion);
        $this->db->select($select);
        $ejecuta = $this->db->get('ccategoria as c'); //
        $query = $ejecuta->result_array();
//        pr($this->db->last_query());
        return $query;
    }

    public function get_buscar_candidatos_validador_por_unidad_delegacion_categoria($params) {
        if (!empty($params['departamento_cve']) AND ! empty($params['delegacion_cve'] AND ! empty($params['categorias']))) {

            $select = array('e.EMP_MATRICULA "matricula"', 'e.EMPLEADO_CVE "empleado_cve"'
                , 'concat(e.EMP_MATRICULA, "  " ,e.EMP_NOMBRE, e.EMP_APE_PATERNO, e.EMP_APE_MATERNO) as "nom_empleado"'
                , 'id_cat "categoria_id"', 'c.des_clave "desc_categoria_cve"', 'nom_categoria "nom_categoria"'
                , 'e.DELEGACION_CVE "delegacion_cve"', 'dl.DEL_NOMBRE "nom_delegacion"'
                , 'dp.departamento_cve "adscripcion_cve"', 'dp.nom_dependencia "nom_dependencia_adscripcion"'
            );

            $this->db->join('empleado e', 'e.CATEGORIA_CVE = c.id_cat');
            $this->db->join('cdepartamento dp', 'dp.departamento_cve = e.ADSCRIPCION_CVE');
            $this->db->join('cdelegacion dl', 'dl.DELEGACION_CVE = dp.cve_delegacion');

            $this->db->where('e.EDO_LABORAL_CVE=', 1);
            $this->db->where('dp.departamento_cve', $params['departamento_cve']);
            $this->db->where('dl.DELEGACION_CVE', $params['delegacion_cve']);
        }

        $this->db->where_in('c.des_clave', $params['categorias']);

        $this->db->select($select);
        $orden = 'e.EMP_NOMBRE, e.EMP_APE_PATERNO, e.EMP_APE_MATERNO';
        $this->db->order_by($orden, 'asc');

        $ejecuta = $this->db->get('ccategoria as c'); //
        $query = $ejecuta->result_array();
        return $query;
    }

    public function get_buscar_usuarios_categoria_sied($params = null) {
        $result = array();
        if (is_null($params)) {
            return $result;
        }

        $result = array('resp_info' => null, 'resultado' => 'false');
        $params = array("Delegacion" => "{$data_siap['reg_delegacion']}", "Matricula" => "{$data_siap['asp_matricula']}", "RFC" => '');

        $client = new SoapClient("http://172.26.18.156/ServiciosWeb/wsSIED.asmx?WSDL");
        $resultado_siap = $client->__soapCall("ConsultaSIED", array($params));
        $resultado = simplexml_load_string($resultado_siap->ConsultaSIEDResult->any); //obtenemos la consulta xml
        $res_json = json_encode($resultado); // la codificamos en json
        $array_result = json_decode($res_json); // y la decodificamos en un arreglo compatible php

        $result['resp_info'] = $array_result;
        if (isset($resultado->EMPLEADOS)) {
            $result['resultado'] = true;
            $return_info = $this->regresa_datos($result, $data_siap['reg_delegacion']);
        }
        return $return_info;
    }

    public function get_validacion_historico($params = null) {
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
        $this->db->join('validacion_gral', "validacion_gral.VALIDACION_GRAL_CVE=hist_validacion.VALIDACION_GRAL_CVE");
        $this->db->join('validador', 'validador.VALIDADOR_CVE=hist_validacion.VALIDADOR_CVE', 'left');
        //pr($params);
        $query = $this->db->get('hist_validacion'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_validacion_registro($params = null) {
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
        $this->db->join('cvalidacion_curso_estado', "{$params['table']}.VAL_CUR_EST_CVE=cvalidacion_curso_estado.VAL_CUR_EST_CVE", 'left');
        $this->db->join('hist_validacion', "{$params['table']}.VALIDACION_CVE=hist_validacion.VALIDACION_CVE", 'left');
        $this->db->join('validador', "hist_validacion.VALIDADOR_CVE=validador.VALIDADOR_CVE", 'left');
        $this->db->join('crol', "validador.ROL_CVE=crol.ROL_CVE", 'left');
        //pr($params);
        $query = $this->db->get($params['table']); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function insert_validacion_registro($tabla, $datos) {
        $resultado = array('result' => null, 'msg' => '', 'data' => null);

        $this->db->trans_begin(); //Definir inicio de transacción

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
        //pr($this->db->last_query());
        return $resultado;
    }

    public function update_validacion_registro($identificador, $tabla, $datos) {
        $resultado = array('result' => null, 'msg' => '', 'data' => null);

        $this->db->trans_begin(); //Definir inicio de transacción
        $this->db->where($identificador);
        $this->db->update($tabla, $datos); //Inserción de registro

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $resultado['msg'] = $this->string_values['error'];
        } else {
            $this->db->trans_commit();
            $resultado['data']['identificador'] = $identificador;
            $resultado['msg'] = $this->string_values['actualizacion'];
            $resultado['result'] = TRUE;
        }
        //pr($this->db->last_query());
        return $resultado;
    }

    /**
     * @author LEAS 
     * @fecha 29/08/2016
     * @param $empleado_cve empleado del validador
     * @param $rol_cve rol que del usuario que inicio sesion
     * @return datos del validador
     */
    function get_validador_empleado_rol($empleado_cve = null, $rol_cve = null) {

        $this->db->where('EMPLEADO_CVE=', intval($empleado_cve));
        $this->db->where('ROL_CVE=', intval($rol_cve));
        $this->db->where('IS_ACTUAL=', 1);

        $query = $this->db->get('validador'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $resultado = $query->result_array();
        if (!empty($resultado)) {
            $resultado = $resultado[0];
        }

        $query->free_result(); //Libera la memoria
//        pr($this->db->last_query());
        return $resultado;
    }

    /**
     * @author LEAS 
     * @fecha 30/08/2016
     * @param $empleado_cve 
     * @param $convocatoria 
     * @return datos del validador
     */
//    function get_hist_estado_validacion_docente_actual($empleado_cve = null, $convocatoria = null) {
//        if (is_null($convocatoria) || is_null($empleado_cve) || empty($convocatoria) || empty($empleado_cve)) {
////            pr('ashdlasldakl  es vacia');
//            return array();
//        }
////        pr($convocatoria);
////        pr($empleado_cve);
//        $select = array('vg.VALIDACION_GRAL_CVE "val_grl_cve"', 'hv.VALIDACION_CVE "validacion_cve"',
//            'hv.VALIDADOR_CVE "validador_cve"', 'hv.VAL_ESTADO_CVE "est_val"', 'vg.VAL_CONV_CVE',
//            'hv.VAL_COMENTARIO "comentario_estado"', 'vg.EMPLEADO_CVE "empleado_cve"');
//        $this->db->where('hv.IS_ACTUAL', 1); //Para obtener el último registro de la actualización
//        $this->db->where('vg.VAL_CONV_CVE', $convocatoria);
//        $this->db->where('vg.EMPLEADO_CVE', $empleado_cve);
//        $this->db->select($select);
//
//        $this->db->join('hist_validacion hv', 'hv.VALIDACION_GRAL_CVE = vg.VALIDACION_GRAL_CVE');
//
//        $query = $this->db->get('validacion_gral vg'); //Obtener conjunto de registros
//        pr($query);
//        if (!is_null($query->row()) AND is_object($query->row())) {
//        $row_query = $query->result_array();
//        pr($row_query);
//        }
//        
//        pr($row_query);
//        if (!empty($row_query)) {
//            $row_query = $row_query[0];
//        }
//        pr($this->db->last_query());    
//        pr($this->db->last_query());
//        return $row_query;
//    }

    /**
     * @author LEAS 
     * @fecha 30/08/2016
     * @param $empleado_cve 
     * @param $convocatoria 
     * @return Historias de los estados de validación del docente, incluye todos 
     * los mensajes y comentarios de los validadores en el proceso de validación
     */
    function get_hist_estados_validacion_docente($empleado_cve, $convocatoria) {
//        $select = array('vg.VALIDACION_GRAL_CVE "validaor_grl_cve"', 'hv.VALIDACION_CVE "validacion_cve"',
//            'hv.VALIDADOR_CVE "validador_cve"', 'hv.VAL_ESTADO_CVE "estado_validacion"',
//            'cve.VAL_EST_NOMBRE "nom_estado_validacion"', 'hv.VAL_COMENTARIO "comentario_estado"',
//            'if(hv.VAL_COMENTARIO is null or hv.VAL_COMENTARIO = "",0,1) "is_comentario"',
//            'hv.VAL_FCH "fecha_validacion"',
//            'concat(em.EMP_NOMBRE, " ", em.EMP_APE_PATERNO, " ",em.EMP_APE_MATERNO) as "nom_validador"'
//        );
        $select = array('vg.VALIDACION_GRAL_CVE "validacion_gral"', 'v.VALIDADOR_CVE "validador_cve"',
            'vg.EMPLEADO_CVE "emp_docente_cve"', 'vg.VAL_CONV_CVE "convocatoria_cve"',
            'hv.VALIDACION_CVE "hist_validacion_cve"', 'v.ROL_CVE "rol_validador"',
            'v.EMPLEADO_CVE "emp_validador_cve"', 'hv.VAL_ESTADO_CVE "est_val"');

        $this->db->select($select);
        $this->db->where('vg.VAL_CONV_CVE', $convocatoria);
        $this->db->where('vg.EMPLEADO_CVE', $empleado_cve);
        $this->db->join('hist_validacion hv', 'hv.VALIDACION_GRAL_CVE = vg.VALIDACION_GRAL_CVE');
        $this->db->join('cvalidacion_estado cve', 'cve.VAL_ESTADO_CVE = hv.VAL_ESTADO_CVE');
        $this->db->join('validador v', 'v.VALIDADOR_CVE = hv.VALIDADOR_CVE', 'left');
        $this->db->join('empleado em', 'em.EMPLEADO_CVE = v.EMPLEADO_CVE', 'left');
        $this->db->order_by('hv.VALIDACION_CVE', "desc");
        $this->db->order_by('vg.VAL_CONV_CVE', "desc");
        $query = $this->db->get('validacion_gral vg'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $result = $query->result_array();
        return $result;
    }

    /**
     * @author LEAS 
     * @fecha 07/11/2016
     * @param $empleado_cve 
     * Uso actual en docente
     * @param $convocatoria 
     * @return Historias de los estados de validación del docente, incluye todos 
     * los mensajes y comentarios de los validadores en el proceso de validación
     */
    function get_estado_validacion_docente($empleado_cve, $convocatoria) {
        $select = array('vg.VALIDACION_GRAL_CVE "validacion_gral"', 'v.VALIDADOR_CVE "validador_cve"',
            'vg.EMPLEADO_CVE "emp_docente_cve"', 'vg.VAL_CONV_CVE "convocatoria_cve"',
            'hv.VALIDACION_CVE "hist_validacion_cve"', 'v.ROL_CVE "rol_validador"',
            'v.EMPLEADO_CVE "emp_validador_cve"', 'hv.VAL_ESTADO_CVE "est_val"');

        $this->db->select($select);
        $this->db->where('vg.VAL_CONV_CVE', $convocatoria);
        $this->db->where('vg.EMPLEADO_CVE', $empleado_cve);

        $this->db->join('hist_validacion hv', 'hv.VALIDACION_GRAL_CVE = vg.VALIDACION_GRAL_CVE');
        $this->db->join('cvalidacion_estado cve', 'cve.VAL_ESTADO_CVE = hv.VAL_ESTADO_CVE');
        $this->db->join('validador v', 'v.VALIDADOR_CVE = hv.VALIDADOR_CVE', 'left');
        $this->db->join('empleado em', 'em.EMPLEADO_CVE = v.EMPLEADO_CVE', 'left');

        $this->db->order_by('hv.VALIDACION_CVE', "desc");
        $this->db->order_by('vg.VAL_CONV_CVE', "desc");
        $this->db->order_by('hv.VAL_ESTADO_CVE', "desc");

        $this->db->limit(1);

        $query = $this->db->get('validacion_gral vg'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $result = $query->result_array();
        return $result;
    }

    /**
     * @author LEAS 
     * @fecha 23/10/2016
     * @param $empleado_cve 
     * @param $ultimas_convocatorias 
     * @return Obtiene el historial de las últimas convocatorias (por defecto las últimas 2)  
     */
    function get_hist_estados_validacion_docente_convocatorias($empleado_cve, $ultimas_convocatorias = 2) {
        $result = array();
        $convocatorias = $this->get_ultimas_convocatorias_cve_empleado($empleado_cve, $ultimas_convocatorias); //Obtiene las últimas dos convocatorias en las que participo el empleado
//        pr($convocatorias);
        if (!empty($convocatorias)) {//Si existen convocatorias, entonces se ejecua la consulta
//            $id_convs = $convocatorias[0]['VAL_CONV_CVE'];
//            for ($i = 1; $i < $ultimas_convocatorias; $i++) {
//                pr($convocatorias[$i]['VAL_CONV_CVE']);
//                $id_convs .= ', ' . $convocatorias[$i]['VAL_CONV_CVE'];
//            }
            $array_in = array();
            foreach ($convocatorias as $value) {
                $array_in[] = intval($value['VAL_CONV_CVE']);
            }

            $select = array('vg.VALIDACION_GRAL_CVE "validaor_grl_cve"', 'hv.VALIDACION_CVE "validacion_cve"',
                'hv.VALIDADOR_CVE "validador_cve"', 'hv.VAL_ESTADO_CVE "estado_validacion"',
                'cve.VAL_EST_NOMBRE "nom_estado_validacion"', 'hv.VAL_COMENTARIO "comentario_estado"',
                'if(hv.VAL_COMENTARIO is null or hv.VAL_COMENTARIO = "",0,1) "is_comentario"',
                'hv.VAL_FCH "fecha_validacion"',
                'concat(em.EMP_NOMBRE, " ", em.EMP_APE_PATERNO, " ",em.EMP_APE_MATERNO) as "nom_validador"'
            );

            $this->db->select($select);
            $this->db->where('vg.EMPLEADO_CVE', $empleado_cve);
            $this->db->where_in('vg.VAL_CONV_CVE', $array_in);
            $this->db->join('hist_validacion hv', 'hv.VALIDACION_GRAL_CVE = vg.VALIDACION_GRAL_CVE');
            $this->db->join('cvalidacion_estado cve', 'cve.VAL_ESTADO_CVE = hv.VAL_ESTADO_CVE');
            $this->db->join('validador v', 'v.VALIDADOR_CVE = hv.VALIDADOR_CVE', 'left');
            $this->db->join('empleado em', 'em.EMPLEADO_CVE = v.EMPLEADO_CVE', 'left');
            $this->db->order_by('vg.VAL_CONV_CVE', "desc");
            $this->db->order_by('hv.VALIDACION_CVE', "desc");
            $query = $this->db->get('validacion_gral vg'); //Obtener conjunto de registros
//            pr($this->db->last_query());
            $result = $query->result_array();
        }
        return $result;
    }

    /**
     * @author LEAS 
     * @fecha 23/10/2016
     * @param $empleado_cve 
     * @param type $cantidad_convocatorias
     * @return Obtiene las ultimas convocatorias en las que participo el docente
     */
    function get_ultimas_convocatorias_cve_empleado($empleado_cve, $cantidad_convocatorias) {
        $select = array('VAL_CONV_CVE');
        $this->db->select($select);
        $this->db->where('EMPLEADO_CVE', $empleado_cve);
        $this->db->order_by('VAL_CONV_CVE', "desc");
        $this->db->limit($cantidad_convocatorias);
        $query = $this->db->get('validacion_gral'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $result = $query->result_array();
        return $result;
    }

    /**
     * @author LEAS 
     * @fecha 22/10/2016
     * @param type $validacion_gral
     * @return Historias de los estados de validación del docente, incluye todos 
     * los mensajes y comentarios de los validadores en el proceso de validación
     */
    function get_detalle_his_val_actual($validacion_gral, $rol_validador = null) {
        $select = array('hv.VALIDACION_CVE "hist_validacion_cve"', 'hv.VALIDADOR_CVE "validador_cve"',
            'hv.VAL_ESTADO_CVE "estado_validacion"', 'cev.VAL_EST_NOMBRE "nom_estado_val"',
            'concat(emv.EMP_NOMBRE, " ", emv.EMP_APE_PATERNO, " ",emv.EMP_APE_MATERNO) as "nom_validador"',
            'cr.ROL_NOMBRE "rol_valido"', 'hv.VAL_COMENTARIO "comentario_estado"',
            'if(hv.VAL_COMENTARIO is null or hv.VAL_COMENTARIO = "",0,1) "is_comentario"',
            'concat(emd.EMP_NOMBRE, " ", emd.EMP_APE_PATERNO, " ",emd.EMP_APE_MATERNO) as "nom_docente"',
            'emd.emp_matricula "matricula"', 'hv.VAL_FCH "fecha_validacion"'
        );

        $this->db->select($select);
        $this->db->where('hv.VALIDACION_GRAL_CVE', $validacion_gral);
        $this->db->where('hv.IS_ACTUAL', 1);
        if (!is_null($rol_validador)) {
            $this->db->where('v.ROL_CVE', intval($rol_validador));
        }
        $this->db->join('validacion_gral vg', 'vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE');
        $this->db->join('empleado emd', 'emd.EMPLEADO_CVE = vg.EMPLEADO_CVE');
        $this->db->join('cvalidacion_estado cev', 'cev.VAL_ESTADO_CVE = hv.VAL_ESTADO_CVE');
        $this->db->join('validador v', 'v.VALIDADOR_CVE = hv.VALIDADOR_CVE', 'left');
        $this->db->join('empleado emv', 'emv.EMPLEADO_CVE = v.EMPLEADO_CVE', 'left');
        $this->db->join('crol cr', 'cr.ROL_CVE = v.ROL_CVE', 'left');
        $this->db->order_by('hv.VALIDACION_CVE', "desc");
        $query = $this->db->get('hist_validacion hv'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $result = $query->result_array();
        return $result;
    }

    /**
     * @author LEAS
     * @fecha 26/10/2016
     * @param type $rol_validador Rol validador aactual
     * @param type $delegacion                                                                                                                                                                                 
     * @param type $adscripcion Departamento de adscripción, 
     * @return type descript 
     */
    public function get_secciones_validacion_obligatorias_nivel($rol_validador, $delegacion, $adscripcion = null) {
//        $select = array('vpm.departamento_cve', 'vpm.delegacion_cve', 'vpm.regiones_cve',
//            'vpm.val_esperados_minimos', 'vpm.porsentaje_muestra', 'vpms.sec_info_cve'
//        );
        $select = array('vpms.sec_info_cve');
        $this->db->select($select);
        $this->db->join('validacion_parametros_muestra_seccion vpms', 'vpms.val_par_muestra = vpm.val_par_muestra');
        $this->db->where('is_actual', 1);
        switch ($rol_validador) {
            case Enum_rols::Validador_N1:
                $this->db->where('vpm.departamento_cve', $adscripcion);
                //Secciones por defecto, para el rol correspondiente a N1
                $val_secc_ = array('sec_info_cve' => array(Enum_sec::S_FORMACION_PROFESIONAL,
                        Enum_sec::S_EDUCACION_DISTANCIA, Enum_sec::S_ESP_MEDICA, Enum_sec::S_ACTIVIDAD_DOCENTE));
                break;
            case Enum_rols::Validador_N2:
                //Secciones por defecto, para el rol correspondiente a N2
                $this->db->where('vpm.delegacion_cve', $delegacion);
                $val_secc_ = array('sec_info_cve' => array(Enum_sec::S_ACT_INV_EDU, Enum_sec::S_FORMACION_PROFESIONAL));
                break;
            case Enum_rols::Docente:
                $this->db->where('vpm.departamento_cve', $adscripcion);
                $this->db->or_where('vpm.delegacion_cve', $delegacion);
                //Secciones por defecto, para el rol correspondiente a docente
                $val_secc_ = array('sec_info_cve' => array(Enum_sec::S_FORMACION_PROFESIONAL,
                        Enum_sec::S_EDUCACION_DISTANCIA, Enum_sec::S_ESP_MEDICA, Enum_sec::S_ACTIVIDAD_DOCENTE
                ));

                break;
        }
        $query = $this->db->get('validacion_parametros_muestra vpm'); //Obtener conjunto de registros
        $result = $query->result_array();
//        pr($this->db->last_query());

        if (empty($result)) {
            //Asigna validación por defecto
            $result = $val_secc_;
        } else {
            //Asigna validaciones almacenadas en la base de datos
            $val_secc_ = array();
            foreach ($result as $value) {
//                pr($value['sec_info_cve']);
                $val_secc_['sec_info_cve'][] = $value['sec_info_cve'];
            }
            $result = $val_secc_;
        }
        return $result;
    }

    public function update_insert_estado_val_docente($parametros_insert_nuevo_hist, $parametros_update_hist_actual, $condicion_hist_actual, $empleado = null, $update = null) {

        $this->db->trans_begin(); //Definir inicio de transacción

        $this->db->where($condicion_hist_actual);
        $this->db->update('hist_validacion', $parametros_update_hist_actual); //Inserción de registro


        $this->db->insert('hist_validacion', $parametros_insert_nuevo_hist); //Inserción de registro
        $data_hist_id = $this->db->insert_id(); //Obtener identificador insertado

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array();
        } else {
            if (!is_null($update)) {
                $secciones_propiedades = $this->config->item('secciones');
                $actualizacion_correcta = 1;
                foreach ($update as $key => $val) {
                    $prop = $secciones_propiedades[$key];
                    $array_validacion = array('IS_VALIDO_PROFESIONALIZACION' => 1, 'EMPLEADO_CVE' => $empleado);
                    $this->db->where_in($prop['pk'], $val);
                    $this->db->update($prop['entidad'], $array_validacion);

                    if ($this->db->trans_status() === FALSE) {
                        $actualizacion_correcta = 0;
                        break;
                    }
                }
//                pr($actualizacion_correcta);
                if ($actualizacion_correcta == 1) {//Se actualizo correctamente
                    $this->db->trans_commit();
                    $parametros_insert_nuevo_hist['VALIDACION_CVE'] = $data_hist_id;
                } else {
                    $this->db->trans_rollback();
                    return array();
                }
            } else {//No es validación por profesionalización, 
                $this->db->trans_commit();
                $parametros_insert_nuevo_hist['VALIDACION_CVE'] = $data_hist_id;
            }
            return $parametros_insert_nuevo_hist;
        }
        //pr($this->db->last_query());
    }

    public function insert_val_gral_estado_val_docente($param_inser_val_gral, $param_inser_historial) {
        $this->db->trans_begin(); //Definir inicio de transacción
        $this->db->where($param_inser_val_gral);
        $query = $this->db->get('validacion_gral'); //Obtener conjunto de registros
        $resultado = $query->result_array();
        $query->free_result(); //Libera la memoria
        
        if (!empty($resultado)) {
            $data_gral_cve = $resultado[0]['VALIDACION_GRAL_CVE'];
        } else {
            $this->db->insert('validacion_gral', $param_inser_val_gral); //Inserción de registro de la validación general
            $data_gral_cve = $this->db->insert_id(); //Obtener identificador insertado
        }

        if ($this->db->trans_status() === FALSE || $data_gral_cve < 1) {//rolback 
            $this->db->trans_rollback();
            return 0;
        } else {
            $param_inser_historial['VALIDACION_GRAL_CVE'] = $data_gral_cve; //agrega cve de la validación general
            $this->db->insert('hist_validacion', $param_inser_historial); //Inserción de registro en historial de validación
            $data_hist_cve = $this->db->insert_id(); //Obtener identificador insertado

            if ($this->db->trans_status() === FALSE || $data_hist_cve < 1) {//rolback 
                $this->db->trans_rollback();
                return 0;
            } else {//No es validación por profesionalización, 
                $this->db->trans_commit();
                return $data_hist_cve;
            }
        }
    }

    /**
     * @author LEAS
     * @param type $empleado
     * @return Querys de actualización para indicar curso validado por profesionalización   
     */
    public function get_querys_updates_estado_validados_profesionalizacion($empleado) {
        $select = 'select B1 "id_registros_estado_val   ido", clave "seccion_informacion"
        from (
         select  hgn.EMP_COMISION_CVE "B1" , 1 "clave"
            from hist_comision_validacion_curso hgn 
            join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE
            join validacion_gral vg on vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE
            where  hgn.VAL_CUR_EST_CVE in(1, 2) and hv.VAL_ESTADO_CVE in(10, 11) and  vg.EMPLEADO_CVE = ' . $empleado . '
        union /*Formacion en salud*/
            select  hgn.FPCS_CVE "B1", 2 "clave"
            from hist_fpcs_validacion_curso hgn 
            join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE
            join validacion_gral vg on vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE
            where  hgn.VAL_CUR_EST_CVE in(1, 2) and hv.VAL_ESTADO_CVE in(10,11) and  vg.EMPLEADO_CVE = ' . $empleado . '
        union /*Investigacion en salud*/            
            select  hgn.EDIS_CVE "B1", 3 "clave"
            from hist_edis_validacion_curso hgn 
            join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE
            join validacion_gral vg on vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE
            where  hgn.VAL_CUR_EST_CVE in(1, 2) and hv.VAL_ESTADO_CVE in(10,11) and  vg.EMPLEADO_CVE = ' . $empleado . '
        union /*Investigación educativa*/
            select  hgn.EAID_CVE "B1", 4 "clave"
            from hist_eaid_validacion_curso hgn 
            join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE
            join validacion_gral vg on vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE
            where  hgn.VAL_CUR_EST_CVE in(1, 2) and hv.VAL_ESTADO_CVE in(10,11) and  vg.EMPLEADO_CVE = ' . $empleado . '
        union /*Beca*/            
            select  hgn.EMP_BECA_CVE "B1", 5 "clave"
            from hist_beca_validacion_curso hgn 
            join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE
            join validacion_gral vg on vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE
            where  hgn.VAL_CUR_EST_CVE in(1, 2) and hv.VAL_ESTADO_CVE in(10,11) and  vg.EMPLEADO_CVE = ' . $empleado . '
        union /*formación profesional*/            
            select  EMP_FORMACION_PROFESIONAL_CVE "B1", 6 "clave"
            from hist_efp_validacion_curso hgn 
            join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE
            join validacion_gral vg on vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE
            where  hgn.VAL_CUR_EST_CVE in(1, 2) and hv.VAL_ESTADO_CVE in(10,11) and  vg.EMPLEADO_CVE = ' . $empleado . '
        union /*Material educativo*/            
            select  hgn.MATERIA_EDUCATIVO_CVE "B1", 7 "clave"
            from hist_me_validacion_curso hgn 
            join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE
            join validacion_gral vg on vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE
            where  hgn.VAL_CUR_EST_CVE in(1, 2) and hv.VAL_ESTADO_CVE in(10,11) and  vg.EMPLEADO_CVE = ' . $empleado . '
        union /*Educación a distancia*/
            select  hgn.EMP_EDU_DISTANCIA_CVE "B1", 8 "clave"
            from hist_edd_validacion_curso hgn 
            join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE
            join validacion_gral vg on vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE
            where  hgn.VAL_CUR_EST_CVE in(1, 2) and hv.VAL_ESTADO_CVE in(10,11) and  vg.EMPLEADO_CVE = ' . $empleado . '
        union /*Especialidad medica*/
            select  hgn.EMP_ESP_MEDICA_CVE "B1", 9 "clave"
            from hist_eem_validacion_curso hgn 
            join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE
            join validacion_gral vg on vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE
            where  hgn.VAL_CUR_EST_CVE in(1, 2) and hv.VAL_ESTADO_CVE in(10,11) and  vg.EMPLEADO_CVE = ' . $empleado . '
        union /*Actividad docente*/
            select  hgn.EMP_ACT_DOCENTE_CVE "B1", 10 "clave" 
            from hist_efpd_validacion_curso hgn 
            join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE
            join validacion_gral vg on vg.VALIDACION_GRAL_CVE = hv.VALIDACION_GRAL_CVE
            where  hgn.VAL_CUR_EST_CVE in(1, 2) and hv.VAL_ESTADO_CVE in(10,11) and  vg.EMPLEADO_CVE = ' . $empleado . '
    ) as res order by clave;';

        $query = $this->db->query($select)->result();
        $this->db->reset_query();
//        pr($this->db->last_query());
        $updates = array();
        if (!empty($query)) {//Construye los querys update
            /* [0] => stdClass Object(
              [id_registros_estado_valido] => 160
              [seccion_informacion] => 1) */
//            $updates = $this->genera_querys_update_is_profesionalizacion($query, $empleado);
            $updates = $this->genera_array_querys_update_is_profesionalizacion($query);
        }
        return $updates;
    }

    /**
     * 
     * @author LEAS
     * @param type $array_ids
     * @param type $empleado
     * Crear los querys de actual
     */
    private function genera_array_querys_update_is_profesionalizacion($array_ids) {
        $array_res = array();
        for ($i = 0; $i < count($array_ids); $i++) {
            $value = $array_ids[$i];
            if (!isset($array_res[$value->seccion_informacion])) {//si no existe el array, se crea el espacio
                $array_res[$value->seccion_informacion] = array();
                $array_res[$value->seccion_informacion][] = $value->id_registros_estado_valido;
            } else {
                $array_res[$value->seccion_informacion][] = $value->id_registros_estado_valido;
            }
        }
        return $array_res;
    }

    /**
     * 
     * @author LEAS
     * @param type $array_ids
     * @param type $empleado
     * Crear los querys de actual
     */
    private function genera_querys_update_is_profesionalizacion($array_ids, $empleado) {
        $secciones_propiedades = $this->config->item('secciones');
        $prop = '';
        $puntero = '';
        $array_res = array();
        $string = '';
        for ($i = 0; $i < count($array_ids); $i++) {
            $value = $array_ids[$i];
            $prop = $secciones_propiedades[$value->seccion_informacion];
            if (!isset($array_res[$value->seccion_informacion])) {//si no existe el array, se crea el espacio
                if (!empty($puntero)) {
                    $tmp = $array_res[$puntero];
                    $tmp .= $string . " where EMPLEADO_CVE = " . $empleado . " AND IS_VALIDO_PROFESIONALIZACION = 0 ";
                    $array_res[$puntero] = $tmp;
                }
                $array_res[$value->seccion_informacion] = "update " . $prop['entidad'] . " set ";
                $string = $prop['pk'] . " = " . $value->id_registros_estado_valido;
                $puntero = $value->seccion_informacion;
            } else {
                $string .= ", " . $prop['pk'] . " = " . $value->id_registros_estado_valido;
            }

            if (!isset($array_ids[$i + 1])) {//Si no existe el siguiente indice, lo termina
                if (!empty($puntero)) {
                    $tmp = $array_res[$puntero];
                    $tmp .= $string . " where EMPLEADO_CVE = " . $empleado . " AND IS_VALIDO_PROFESIONALIZACION = 0 ";
                    $array_res[$puntero] = $tmp;
                }
            }
        }

//        pr($array_res);
    }

    public function insert_inicio_estado_correccion($parametros_hist, $parametros_val_gen) {

        $this->db->trans_begin(); //Definir inicio de transacción

        $this->db->insert('validacion_gral', $parametros_val_gen); //Inserción de registro
        $data_gen_id = $this->db->insert_id(); //Obtener identificador insertado

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array();
        } else {
            $parametros_hist['VALIDACION_GRAL_CVE'] = $data_gen_id;
            $this->db->insert('hist_validacion', $parametros_hist); //Inserción de registro
            $data_hist_id = $this->db->insert_id(); //Obtener identificador insertado
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array();
            } else {
                $this->db->trans_commit();
                $parametros_val_gen['VALIDACION_GRAL_CVE'] = $data_gen_id;
                $parametros_hist['VALIDACION_CVE'] = $data_hist_id;
                $result['validacion_gral'] = $parametros_val_gen;
                $result['hist_validacion'] = $parametros_hist;
                return $result;
            }
        }
        //pr($this->db->last_query());
    }

    /**
     * 
     * @param type $empleado empleado a validar 
     * @param type $hist_estados_curso_evaluar estado de curso a validar, es decir, "valido" y "no valido" 
     * @param type $val_gral validacion general de la validacion, activa con la convocatoria
     * @param type $rol_cve rol que va a validar N1 o N2
     * @param type $secciones_validacion array() de propiedades de las secciones obligatorias a validar
     * @return type Un entero, donde "1->valido" y "0->No valido"
     */
    public function get_is_envio_validacion($empleado, $hist_estados_curso_evaluar, $val_gral, $rol_cve, $secciones_validacion) {
        $result_estados = '';
        $or = '';
        foreach ($hist_estados_curso_evaluar as $value) {
            $result_estados .= $or . ' hv.VAL_ESTADO_CVE = ' . $value;
            $or = ' or ';
        }
        $where_estados = ' hgn.VAL_CUR_EST_CVE in(1,2) '; //Estados para validar cursos (valido, no valido)

        $union = '';
        $select = 'select sum(A1) "num_registros_cargados", sum(B1) "num_registros_est_valido" from ( ';
        foreach ($secciones_validacion as $value) {
            $select .= $union .
                    ' select count(*) "A1", 0 "B1" from ' . $value['entidad'] . ' where EMPLEADO_CVE = ' . $empleado . ' and IS_VALIDO_PROFESIONALIZACION = 0 and IS_CARGA_SISTEMA = 0 '
                    . ' union  '
                    . 'select 0 "A1", count(*) "B1" from ' . $value['entidad_validacion_curso'] . ' hgn '
                    . ' join hist_validacion hv on hv.VALIDACION_CVE = hgn.VALIDACION_CVE '
                    . ' join validador v on v.VALIDADOR_CVE  = hv.VALIDADOR_CVE '
                    . ' where  ' . $where_estados . ' and (' . $result_estados . ') and  hv.VALIDACION_GRAL_CVE = ' . $val_gral . ' and v.ROL_CVE = ' . $rol_cve
            ;
            $union = ' union ';
        }
        $select .= ' ) as res ';

        $query = $this->db->query($select)->result();
//        $this->db->reset_query();
        $is_validados = 1;
        if (!empty($query)) {
            $num_reg_cargados = intval($query[0]->num_registros_cargados);
            $numero_registros_validos = intval($query[0]->num_registros_est_valido);
            $is_validados = ($num_reg_cargados == $numero_registros_validos) ? 1 : 0; //Si el valor es igual, entonces todo se encuentra validado
        }
//        pr($query);
//        pr($this->db->last_query());
        return $is_validados;
    }

    /**
     * 
     * @param type $empleado empleado a validar 
     * @param type $secciones_validacion array() de propiedades de las secciones obligatorias a validar
     * @return type Un entero, donde "1->Registro actividades minimas para validar" y "0->No cumple con lo"
     * @descript Los bloques o secciones del la carrera docente para que puedan ser validados, deben cumplir con un minimo
     * cursos o actividades registradas
     */
    public function get_minimo_cursos_envio_validacion($empleado, $secciones_validacion) {
//        pr($secciones_validacion);
        $union = '';
        $select = 'select sum(A1) "num_registros_cargados", seccion "secciones" from ( ';
        foreach ($secciones_validacion as $seccion => $value) {
            $select .= $union .
                    ' select count(*) "A1", ' . $seccion . ' "seccion" from ' . $value['entidad'] . ' where EMPLEADO_CVE = ' . $empleado . ' and IS_VALIDO_PROFESIONALIZACION = 0 and IS_CARGA_SISTEMA = 0 '
            ;
            $union = ' union ';
        }
        $select .= ' ) as res ';
        $group_by = ' group by secciones ';
        $order_by = ' order by num_registros_cargados desc ';

        $select .= $group_by . $order_by;

        $query = $this->db->query($select)->result();
        $this->db->reset_query();
        $tmp_bufer_bloque = array();
        //Recorre los resultados, con el objetivo de identificarque exista por lo menos un registro en cada bloque o sección obligatoria
        foreach ($query as $value) {
            $prop_seccion = $secciones_validacion[$value->secciones]; //Se obtiene las propiedades de una sección
            if ($value->num_registros_cargados > 0) {//Cuenta que la cantidad de registros por la sección, sea mayor que cero, para agregar como parte de un bloque
                if (!isset($tmp_bufer_bloque[$prop_seccion['bloque']])) {//Si no existe el bloque en el temporal, lo agregará
                    $tmp_bufer_bloque[$prop_seccion['bloque']] = $value->num_registros_cargados; //guarda el bloque
                }
            }
        }
        $tmp_bufer_bloque_esperado = array();
        //Cuenta bloques de seccion esperados
        foreach ($secciones_validacion as $key => $value) {
            if ($value['bloque']) {
                if (!isset($tmp_bufer_bloque_esperado[$value['bloque']])) {//Si no existe el bloque en el temporal, lo agregará
                    $tmp_bufer_bloque_esperado[$value['bloque']] = $key;
                }
            }
        }

        //Cuenta cantidad de bloques esperados y bloques con cursos registrados 
        $count_bloques_netos = count($tmp_bufer_bloque);
        $count_bloques_esperados = count($tmp_bufer_bloque_esperado);
        $res = ($count_bloques_netos == $count_bloques_esperados) ? 1 : 0; //Si la cantidad de bloques esperados minimos es igual a la cantidad de bloques cubiertos por los cursos registrados pasa para enviar a validar
//        pr($count_bloques_netos . ' -> ' . $count_bloques_esperados);
//        pr($query);
//        pr($this->db->last_query());
        return $res;
    }

}
