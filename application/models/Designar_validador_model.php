<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Designar_validador_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_buscar_unidades($params) {
        $arra_buscar_por = array('unidad' => 'dp.nom_dependencia',
            'matricula' => 'e.EMP_MATRICULA',
            'claveadscripcion' => 'dp.departamento_cve',
            'nombre' => array('e.EMP_NOMBRE', 'e.EMP_APE_PATERNO', 'e.EMP_APE_MATERNO')
        );
        $busqueda_text = $arra_buscar_por[$params['menu_busqueda']];

        $select = array('dp.cve_delegacion "delegacion_cve"', 'dp.nom_delegacion "nom_delegacion"',
            'dp.nom_dependencia "nom_departamento"', 'dp.departamento_cve "departamento_cve"',
            'v.VALIDADOR_CVE "validador_cve"', 'v.ROL_CVE "rol_cve"', 'cr.ROL_NOMBRE "nom_rol"',
            'v.EMPLEADO_CVE "empleado_cve"', 'v.VAL_ESTADO "estado_validador"',
            'CONCAT(e.EMP_NOMBRE, e.EMP_APE_PATERNO', 'e.EMP_APE_MATERNO) "nom_empleado"',
            'e.EMP_MATRICULA "matricula_empleado"', 'e.CATEGORIA_CVE "categoria_id"',
            'cat.des_clave "categoria_cve"', 'cat.nom_categoria "nom_categoria"',
            'dp.IS_UNIDAD_VALIDACION "is_unidad_validacion"', 'v.IS_ACTUAL "is_validador_actual"'
        );

        $this->db->start_cache();
//        $this->db->from('cdepartamento as dp');
        $this->db->join('validador v', 'v.DEPARTAMENTO_CVE = dp.departamento_cve', 'left');
        $this->db->join('empleado e', 'e.EMPLEADO_CVE = v.EMPLEADO_CVE', 'left');
        $this->db->join('crol cr', 'cr.ROL_CVE = v.ROL_CVE', 'left');
        $this->db->join('ccategoria cat', 'cat.id_cat = e.CATEGORIA_CVE', 'left');

        $this->db->where('dp.IS_UNIDAD_VALIDACION', 1); //es una unidad de validación
//        $this->db->where('v.IS_ACTUAL', 1); //Es el último registro de validación

        if (!empty($params['delegacion_cve'])) {
            $this->db->where('dp.cve_delegacion', $params['delegacion_cve']);
        }

        if (is_array($busqueda_text)) {
            foreach ($busqueda_text as $value) {
                $this->db->or_like($value, $params['buscar_unidad_medica']);
            }
        } else {
            $this->db->like($busqueda_text, $params['buscar_unidad_medica']);
        }
        $this->db->stop_cache();

        //Cuenta la cantidad de registros
        $num_rows = $this->db->query($this->db->select('count(*) as total')->get_compiled_select('cdepartamento as dp'))->result();
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
                $orden = 'e.EMP_NOMBRE, e.EMP_APE_PATERNO, e.EMP_APE_MATERNO';
            }
            $this->db->order_by($orden, $order_type);
        }

        $ejecuta = $this->db->get('cdepartamento as dp'); //Prepara la consulta ( aún no la ejecuta)
        $query = $ejecuta->result_array();
//        pr($this->db->last_query());
//        $query->free_result();
        $this->db->flush_cache(); //Limpia la cache
        $result['result'] = $query;
        $result['total'] = $num_rows[0]->total;
//        pr($result['result']);
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

    public function delete_vinculo_validador_n1($parametros = null) {
        if (is_null($parametros)) {
            return array();
        }
        $crol = $parametros['crol_cve'];
        $ususario = $parametros['usuario_cve'];
        $validador_cve = $parametros['validador_cve'];
        $status_validador = $parametros['estado_validador'];

        if (!empty($validador_cve)) {
            $this->db->trans_begin();
            if (!empty($ususario) AND ! empty($crol)) {//Elimina la relación de rol usuario n1
                $this->load->model('Usuario_model', 'usum');
                $r_d_u_r = $this->usum->delete_usuario_rol($ususario, $crol);
                if ($r_d_u_r > 0) {//Se efectuo la elimincacion de usuario rol
                    $result_asignar_validador['usuario_rol'] = array('USUARIO_CVE' => $ususario, 'ROL_CVE' => $crol);
                }
            }
//            if($res = )
//            $array_validacion = array('VAL_ESTADO' => 0, 'EMPLEADO_CVE' => NULL, 'ROL_CVE' => NULL, 'DELEGACION_CVE' => NULL, 'DEPARTAMENTO_CVE' => NULL);
//            $array_validacion = array('VAL_ESTADO' => 0, 'EMPLEADO_CVE' => NULL, 'ROL_CVE' => NULL, 'IS_ACTUAL' => 0);
            $array_validacion = array('VAL_ESTADO' => 0, 'IS_ACTUAL' => 0);
            $this->db->where('VALIDADOR_CVE', $validador_cve);
            $this->db->update('validador', $array_validacion);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array();
            } else {
                $this->db->trans_commit();
                $array_validacion['VALIDADOR_CVE'] = $validador_cve;
                $result_asignar_validador['validador'] = $array_validacion;
                return $result_asignar_validador;
            }
        } else {
            return array();
        }
    }

    public function insert_designar_validador_rol_use($parametros, $parametros_validador = array()) {
        if (empty($parametros)) {
            return array();
        }
        $parametros['DELEGACION_CVE'] = (strlen($parametros['DELEGACION_CVE']) < 2) ? '0' . $parametros['DELEGACION_CVE'] : $parametros['DELEGACION_CVE'];
        if (!empty($parametros_validador)) {
            $crol = $parametros['ROL_CVE'];
            $usuario = $parametros_validador['usuario_cve'];
//            $validador_cve = $parametros_validador['validador_cve'];
//            $status_validador = $parametros_validador['estado_validador'];
            $this->db->trans_begin();
            $this->db->insert('validador', $parametros); //Almacena usuario
            $obtiene_id_validador_designado = $this->db->insert_id();
//          pr($this->db->last_query());

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array();
            } else {
                if (!empty($usuario)) {//Si existe un usuario que se vincule con el empleado, entonces se debe guardar el rol asociado al usuaerio
                    $this->load->model('Usuario_model', 'usum');
                    $r_d_u_r = $this->usum->insert_usuario_rol(intval($usuario), $crol);
                    if ($r_d_u_r > 0) {
                        $this->db->trans_commit();
                        if ($r_d_u_r < 2) {
                            $result['usuario'] = $usuario;
                            $result['rol'] = $crol;
                        }
                        $result['validador'] = $obtiene_id_validador_designado;
                        return $result;
                    } else {
                        $this->db->trans_rollback();
                        return array();
                    }
                } else {
                    $this->db->trans_commit();
                    $result['validador'] = $obtiene_id_validador_designado;
                    return $result;
                }
            }
        } else {
            return array();
        }
    }

    public function update_designar_validador($id_validador, $parametros, $parametros_validador = array()) {
        $parametros['DELEGACION_CVE'] = (strlen($parametros['DELEGACION_CVE']) < 2) ? '0' . $parametros['DELEGACION_CVE'] : $parametros['DELEGACION_CVE'];
//        pr($this->db->last_query());
        $parametros_result['validador'] = $parametros;
        if (!empty($parametros_validador)) {
            $this->db->trans_begin();
            $crol = $parametros['ROL_CVE'];
            $usuario = $parametros_validador['usuario_cve'];
            $this->db->where('VALIDADOR_CVE', $id_validador);
            $this->db->update('validador', $parametros);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array();
            } else {
                if (!empty($usuario)) {//Si existe un usuario que se vincule con el empleado, entonces se debe guardar el rol asociado al usuaerio
                    $this->load->model('Usuario_model', 'usum');
                    $r_d_u_r = $this->usum->insert_usuario_rol(intval($usuario), $crol);
                    if (intval($r_d_u_r) > 0) {
                        if (intval($r_d_u_r) < 2) {//Asigna la insersión de la entidad usuario rol si es mayor que 1
                            $parametros_result['usuario_rol']['USUARIO_CVE'] = $r_d_u_r;
                            $parametros_result['usuario_rol']['ROL_CVE'] = $crol;
                        }
                        $parametros_result['validador']['VALIDADOR_CVE'] = $id_validador; //Asigna el identifucador
                        $this->db->trans_commit();
                        return $parametros_result;
                    } else {
                        $this->db->trans_rollback();
                        return array();
                    }
                } else {
                    $this->db->trans_commit();
                    $parametros_result['validador']['VALIDADOR_CVE'] = $id_validador; //Asigna el identifucador
                    return $parametros_result;
                }
            }
        }
    }

    public function get_buscar_empleado_delegacion_validador($id_empleado = null, $id_delegacion = null, $rol_designar = Enum_rols::Validador_N1) {
        if (is_null($id_empleado)) {
            return array();
        }
        $select = array('e.EMP_MATRICULA "matricula"', 'e.EMPLEADO_CVE "empleado_cve"', 'e.EDO_LABORAL_CVE "status"'
            , 'concat(e.EMP_MATRICULA, "  " ,e.EMP_NOMBRE, e.EMP_APE_PATERNO, e.EMP_APE_MATERNO) as "nom_empleado"'
            , 'e.EMP_NOMBRE "nombre"', 'e.EMP_APE_PATERNO "paterno"', 'e.EMP_APE_MATERNO "materno"'
            , 'id_cat "categoria_id"', 'c.des_clave "desc_categoria_cve"', 'nom_categoria "nom_categoria"'
            , 'e.DELEGACION_CVE "delegacion_cve"', 'dl.DEL_NOMBRE "nom_delegacion"', 'v.VAL_ESTADO "estado_validador"'
            , 'dp.departamento_cve "adscripcion_cve"', 'dp.nom_dependencia "nom_dependencia_adscripcion"',
            'v.ROL_CVE "rol_validador"', 'v.IS_ACTUAL "is_actual_validador"'
        );

        $this->db->join('empleado e', 'e.CATEGORIA_CVE = c.id_cat');
        $this->db->join('cdepartamento dp', 'dp.departamento_cve = e.ADSCRIPCION_CVE');
        $this->db->join('cdelegacion dl', 'dl.DELEGACION_CVE = e.DELEGACION_CVE');
        $this->db->join('validador v', 'v.EMPLEADO_CVE = e.EMPLEADO_CVE', 'left');

        $this->db->where('e.EMP_MATRICULA', $id_empleado);
//        $this->db->where('e.DELEGACION_CVE', $id_delegacion);
//        $this->db->where('v.ROL_CVE', $rol_designar);
        $this->db->select($select);
        $ejecuta = $this->db->get('ccategoria as c'); //
        $query = $ejecuta->result_array();
//        pr($query);
//        pr($this->db->last_query());
        return $query;
    }

    /**
     * 
     * @author LEAS
     * @fecha 19/10/2016
     * @param $matricula_emp Matricula del empleado 
     * @param type $id_delegacion
     * @return array()
     * @desc Busca empleados en la base de datos de sipimss por medio de la matricula
     */
    public function get_buscar_empleado_delegacion($matricula_emp) {
        if (is_null($matricula_emp)) {
            return array();
        }

        $select = array('e.EMP_MATRICULA "matricula"', 'e.EMPLEADO_CVE "empleado_cve"', 'e.EDO_LABORAL_CVE "status"',
            'concat(e.EMP_MATRICULA, "  " ,e.EMP_NOMBRE, e.EMP_APE_PATERNO, e.EMP_APE_MATERNO) as "nom_empleado"',
            'e.EMP_NOMBRE "nombre"', 'e.EMP_APE_PATERNO "paterno"', 'e.EMP_APE_MATERNO "materno"', 'id_cat "categoria_id"',
            'c.des_clave "desc_categoria_cve"', 'nom_categoria "nom_categoria"', 'e.DELEGACION_CVE "delegacion_cve"',
            'dl.DEL_NOMBRE "nom_delegacion"', 'dp.departamento_cve "adscripcion_cve"',
            'dp.nom_dependencia "nom_dependencia_adscripcion"'
        );

        $this->db->join('empleado e', 'e.CATEGORIA_CVE = c.id_cat');
        $this->db->join('cdepartamento dp', 'dp.departamento_cve = e.ADSCRIPCION_CVE');
        $this->db->join('cdelegacion dl', 'dl.DELEGACION_CVE = dp.cve_delegacion');
//        $this->db->join('validador v', 'v.EMPLEADO_CVE = e.EMPLEADO_CVE', 'left');

        $this->db->where('e.EMP_MATRICULA', $matricula_emp);
//        $this->db->where('e.DELEGACION_CVE', $id_delegacion);
//        $this->db->where('v.ROL_CVE', $rol_designar);
        $this->db->select($select);
        $ejecuta = $this->db->get('ccategoria as c'); //
        $query = $ejecuta->result_array();
//        pr($query);
//        pr($this->db->last_query());
        return $query;
    }

    /**
     * 
     * @author LEAS
     * @fecha 19/10/2016
     * @param type $matricula
     * @param type $rol_validador
     * @return type
     */
    public function get_is_validador_nivel($matricula, $rol_validador = Enum_rols::Validador_N1) {
        $select = 'count(*)';
        $this->db->select($select);
        $this->db->join('empleado em', 'em.EMPLEADO_CVE = v.EMPLEADO_CVE');
        $this->db->where('em.emp_matricula', $matricula);
        $this->db->where('v.ROL_CVE', $rol_validador);
        $ejecuta = $this->db->get('from validador v');
        $query = $ejecuta->result_array();
        return $query[0];
    }

    public function get_buscar_candidatos_validador_por_unidad_delegacion_categoria_($params) {
        if (!empty($params['departamento_cve']) AND ! empty($params['delegacion_cve'] AND ! empty($params['categorias']))) {

            $select = array('e.EMP_MATRICULA "matricula"', 'e.EMPLEADO_CVE "empleado_cve"'
                , 'concat(e.EMP_MATRICULA, "  " ,e.EMP_NOMBRE, e.EMP_APE_PATERNO, e.EMP_APE_MATERNO) as "nom_empleado"'
                , 'c.id_cat "categoria_id"', 'c.des_clave "desc_categoria_cve"', 'c.nom_categoria "nom_categoria"'
                , 'e.DELEGACION_CVE "delegacion_cve"', 'dl.DEL_NOMBRE "nom_delegacion"', 'v.VAL_ESTADO "estado_validador"'
                , 'dp.departamento_cve "adscripcion_cve"', 'dp.nom_dependencia "nom_dependencia_adscripcion"'
            );

            $this->db->join('empleado e', 'e.CATEGORIA_CVE = c.id_cat');
            $this->db->join('cdepartamento dp', 'dp.departamento_cve = e.ADSCRIPCION_CVE');
            $this->db->join('cdelegacion dl', 'dl.DELEGACION_CVE = dp.cve_delegacion');
            $this->db->join('validador v', 'v.EMPLEADO_CVE = e.EMPLEADO_CVE', 'left');

            $this->db->where('e.EDO_LABORAL_CVE=', 1);
            $this->db->where('dp.departamento_cve', $params['departamento_cve']);
            $this->db->where('dl.DELEGACION_CVE', $params['delegacion_cve']);
//            $this->db->where('v.VAL_ESTADO', 0);
        }

        $this->db->where_in('c.des_clave', $params['categorias']);

        $this->db->select($select);
        $orden = 'e.EMP_NOMBRE, e.EMP_APE_PATERNO, e.EMP_APE_MATERNO';
        $this->db->order_by($orden, 'asc');

        $ejecuta = $this->db->get('ccategoria as c'); //
//        pr($this->db->last_query());
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

//    public function get_validador($validador = null) {
//        if (!is_null($validador)) {
//            $this->db->where('VALIDADOR_CVE', $validador);
//        }
//        $query = $this->db->get('validador');
//        $array_validador = $query->result_array();
//        $query->free_result();
//        return $array_validador;
//    }

    /**
     * @author LEAS 
     * @fecha 20/08/2016
     * @param type $id_empleado Empleado cve 
     * @param type $id_validacion
     * @return type
     */
    function get_validador_n1($id_empleado = null, $id_validacion = null) {
        if ((is_null($id_empleado) || empty($id_empleado)) AND ( is_null($id_validacion) || empty($id_validacion))) {
            return array();
        }

        if (!empty($id_empleado)) {
            $this->db->where('EMPLEADO_CVE=', intval($id_empleado));
        }
        if (!empty($id_validacion)) {
            $this->db->where('VALIDADOR_CVE=', intval($id_validacion));
        }

        $query = $this->db->get('validador'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado = $query->result_array();
        if (!empty($resultado)) {
            $resultado = $resultado[0];
        }

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

}
