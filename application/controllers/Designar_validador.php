<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 		: LEAS 
 * fecha: 29/07/2016
 */
class Designar_validador extends MY_Controller {

    /**
     * Class Constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('empleados_siap');
        $this->load->model('Designar_validador_model', 'dvm');
        $this->load->library('Ventana_modal');
        $this->load->config('general');
        $this->load->library('form_validation');
        $this->load->library('seguridad');
//        $this->load->library('Ventana_modal');
    }

    /**
     * 
     * @author Leas
     * Fecha creación28072016
     */
    public function index() {
//        $filtros['delegacion_cve'] = '01';
//        $filtros['buscar_unidad_medica'] = 'al';
//           $resutlado = $this->dvm->get_buscar_unidades($filtros);
//           pr($resutlado);
//        $array_siap = array("reg_delegacion" => $datos_registro['reg_delegacion'], 
//            "asp_matricula" => $datos_registro['reg_matricula']);
//        $datos_siap = $this->empleados_siap->buscar_usuario_siap($array_siap);
//        pr();
//        exit();
        $this->lang->load('interface', 'spanish');
        $string_values = $this->lang->line('interface')['designar_validador'];
        $data = array();

        $data['string_values'] = $string_values;
        $data['order_columns'] = array('dp.nom_dependencia' => 'Nombre del departamento', 'dp.nom_delegacion' => 'Nombre de la delegación', 'fullname' => 'Nombre del validador');
        $data = carga_catalogos_generales(array(enum_ecg::cdelegacion), $data); //Carga el catálogo de ejercicio predominante
        $main_contet = $this->load->view('designar_validador/designarvalidador_tpl', $data, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate(false, 'template/sipimss/index.tpl.php');
//        $this->template->getTemplate();
    }

    public function get_data_cargar_elemento() {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            $this->lang->load('interface', 'spanish');
            $string_values = $this->lang->line('interface')['designar_validador'];
            $data_selecciona_validador['mostrar_buscador'] = "display: none";
            if (!is_null($this->input->post())) {
                $datos_post = $this->input->post(null, true); //Obtenemos el post o los valores
//            $data_selecciona_validador['status'] = '0';
//                pr($datos_post);
                $param['departamento_cve'] = $this->seguridad->decrypt_base64($datos_post['departamento_desc']); //
                $param['delegacion_cve'] = $this->seguridad->decrypt_base64($datos_post['delegacion_cve']);

                $param['categorias'] = $this->config->item('categorias_designar_validador'); //Categorias permitidas para validador
                $res_busqueda = $this->dvm->get_buscar_candidatos_validador_por_unidad_delegacion_categoria_($param);
                $res_items = $res_busqueda;
                foreach ($res_busqueda as $key => $value) {//Quita a los candidatos que ya sean validadores
                    if (!empty($value['estado_validador']) AND intval($value['estado_validador']) === 1) {
                        unset($res_items[$key]);
                    }
                }
//            array_unshift($res_busqueda, array('nom_empleado' => 'Otro candidato', 'empleado_cve' => 0  ));//Agrega al principio del array otro empleado para, se pueda buscar en el sied
                $lista_candidaros = dropdown_options($res_items, 'empleado_cve', 'nom_empleado');
//            $result_candidatos = 
                $data_selecciona_validador['string_values'] = $string_values;
                $data_selecciona_validador['lista_candidaros'] = $lista_candidaros;
                $data_selecciona_validador['reg_delegacion_cve'] = $datos_post['delegacion_cve'];
                $data_selecciona_validador['reg_departamento_desc'] = $datos_post['departamento_desc'];
//                $data_selecciona_validador['reg_id_validador'] = $datos_post['id_validaor'];
                $data_selecciona_validador['reg_idrow'] = $datos_post['idrow'];
                $data = array(
                    'titulo_modal' => $string_values['tab_titulo_seleccionar_validador'],
                    'cuerpo_modal' => $this->load->view('designar_validador/carga_validadores_unidad', $data_selecciona_validador, true),
//                    'pie_modal' => $this->load->view('designar_validador/designar_validador_pie', $data_selecciona_validador, true)
                );
                echo $this->ventana_modal->carga_modal($data);
            }
        } else {
            redirect(site_url());
        }
    }

    public function get_data_cargar_datos_opcion_validador() {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) {
                $this->lang->load('interface', 'spanish');
                $string_values = $this->lang->line('interface')['designar_validador'];
                $data_selecciona_validador['mostrar_buscador'] = "display: none";
                $datos_post = $this->input->post(null, true); //Obtenemos el post o los valores
//            pr($datos_post);
                $data_selecciona_validador['string_values'] = $string_values;
                $data_selecciona_validador['reg_delegacion_cve'] = $datos_post['delegacion_cve'];
                $data_selecciona_validador['reg_departamento_desc'] = $this->seguridad->decrypt_base64($datos_post['departamento_desc']);
                $data_selecciona_validador['reg_id_validador'] = $datos_post['id_validaor'];
                $data_selecciona_validador['reg_idrow'] = $datos_post['idrow'];
                $index_validador = intval($datos_post['candidato_a_validador']);
                switch ($index_validador) {
                    case 0://Carga el buscador
                        $data_selecciona_validador = carga_catalogos_generales(array(enum_ecg::cdelegacion), $data_selecciona_validador);
                        echo $this->load->view('designar_validador/busquedor_sied', $data_selecciona_validador, true);
                        break;
                    case -1:
                        $data_selecciona_validador['mensaje'] = $string_values['drop_selecciona_validador_nulo'];
                        echo $this->load->view('designar_validador/mensajes', $data_selecciona_validador, true);
                        break;
                    default ://Carga el resultado de validador seleccionado 
                        $res_obtener_empleado = $this->dvm->get_obtener_empleado($index_validador);
                        if (!empty($res_obtener_empleado)) {
                            $data_selecciona_validador['base_reg_encontrado'] = 'sipimss';
                            $data_selecciona_validador['empleado_cve'] = $res_obtener_empleado[0]['empleado_cve'];
                            $data_selecciona_validador['matricula'] = $res_obtener_empleado[0]['matricula'];
                            $data_selecciona_validador['nombre'] = $res_obtener_empleado[0]['nombre'];
                            $data_selecciona_validador['paterno'] = $res_obtener_empleado[0]['paterno'];
                            $data_selecciona_validador['materno'] = $res_obtener_empleado[0]['materno'];
                            $data_selecciona_validador['delegacion_id'] = $res_obtener_empleado[0]['delegacion_cve'];
                            $data_selecciona_validador['delegacion'] = $res_obtener_empleado[0]['nom_delegacion'];
                            $data_selecciona_validador['adscripcion'] = $res_obtener_empleado[0]['adscripcion_cve'];
                            $data_selecciona_validador['descripcion'] = $res_obtener_empleado[0]['nom_dependencia_adscripcion'];
                            $data_selecciona_validador['pue_despue'] = $res_obtener_empleado[0]['nom_categoria'];
                            $data_selecciona_validador['emp_keypue'] = $res_obtener_empleado[0]['desc_categoria_cve'];
                            $data_selecciona_validador['status'] = $res_obtener_empleado[0]['status'];
                            //Datos para generar botón para validar
                            $data_pie_pag['reg_delegacion_cve'] = $datos_post['delegacion_cve'];
                            $data_pie_pag['reg_departamento_desc'] = $datos_post['departamento_desc'];
                            $data_pie_pag['matricula'] = $this->seguridad->encrypt_base64($res_obtener_empleado[0]['matricula']);
                            $data_pie_pag['reg_idrow'] = $datos_post['idrow'];
                            $data_selecciona_validador['pie_pag'] = $this->load->view('designar_validador/designar_validador_pie', $data_pie_pag, true);
                            echo $this->load->view('designar_validador/seleccionar_validador', $data_selecciona_validador, true);
                        }
                }
            }
        } else {
            redirect(site_url());
        }
    }

    public function get_data_buscar_sied_validador() {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) {
                $this->lang->load('interface', 'spanish');
                $string_values = $this->lang->line('interface')['designar_validador'];
                $datos_post = $this->input->post(null, true); //Obtenemos el post o los valores
//                pr($datos_post);
                $this->load->library('empleados_siap');
                //Datos que vienen desde raíz.......................................
                $data_selecciona_validador['string_values'] = $string_values;
                $data_selecciona_validador['reg_delegacion_cve'] = $datos_post['delegacion_cve'];
                $data_selecciona_validador['reg_departamento_desc'] = $datos_post['departamento_desc'];
                $data_selecciona_validador['reg_id_validador'] = $datos_post['id_validaor'];
                $data_selecciona_validador['reg_idrow'] = $datos_post['idrow'];

                //Busca en sipimss que exista el empleado solicitado
                $datos_sipimss = $this->dvm->get_buscar_empleado_delegacion_validador($datos_post['buscar_unidad_medica'], $datos_post['delegacion_busqueda_validador']);
//                pr($datos_sipimss);

                if (!empty($datos_sipimss)) {//Existe el empleado en sipimss
                    if (intval($datos_sipimss[0]['status']) === 1) {

                        if (empty($datos_sipimss[0]['is_actual_validador']) || intval($datos_sipimss[0]['is_actual_validador']) === 0) {
                            $data_selecciona_validador['base_reg_encontrado'] = 'sipimss';
                            $data_selecciona_validador['empleado_cve'] = $datos_sipimss[0]['empleado_cve'];
                            $data_selecciona_validador['matricula'] = $datos_sipimss[0]['matricula'];
                            $data_selecciona_validador['nombre'] = $datos_sipimss[0]['nombre'];
                            $data_selecciona_validador['materno'] = $datos_sipimss[0]['materno'];
                            $data_selecciona_validador['paterno'] = $datos_sipimss[0]['paterno'];
                            $data_selecciona_validador['delegacion'] = $datos_sipimss[0]['nom_delegacion'];
                            $data_selecciona_validador['delegacion_id'] = $datos_sipimss[0]['delegacion_cve'];
                            $data_selecciona_validador['adscripcion'] = $datos_sipimss[0]['adscripcion_cve'];
                            $data_selecciona_validador['descripcion'] = $datos_sipimss[0]['nom_dependencia_adscripcion'];
                            $data_selecciona_validador['pue_despue'] = $datos_sipimss[0]['nom_categoria'];
                            $data_selecciona_validador['emp_keypue'] = $datos_sipimss[0]['desc_categoria_cve'];
                            $data_selecciona_validador['categoria_id_sipimss'] = $datos_sipimss[0]['categoria_id'];
                            $data_selecciona_validador['status'] = $datos_sipimss[0]['status'];

                            $data_pie_pag['reg_delegacion_cve'] = $datos_post['delegacion_cve'];
                            $data_pie_pag['reg_departamento_desc'] = $this->seguridad->encrypt_base64($datos_post['departamento_desc']);
                            $data_pie_pag['matricula'] = $this->seguridad->encrypt_base64($datos_sipimss[0]['matricula']);
                            $data_pie_pag['reg_idrow'] = $datos_post['idrow'];
                            $data_selecciona_validador['pie_pag'] = $this->load->view('designar_validador/designar_validador_pie', $data_pie_pag, true);
                            echo $this->load->view('designar_validador/seleccionar_validador', $data_selecciona_validador, true);
                        } else {
                            $data_selecciona_validador['mensaje'] = $string_values['lbl_validador_asignado'];
                            echo $this->load->view('designar_validador/mensajes', $data_selecciona_validador, true);
                        }
                    } else {
                        $data_selecciona_validador['mensaje'] = $string_values['lbl_status_empleado_cero'];
                        echo $this->load->view('designar_validador/mensajes', $data_selecciona_validador, true);
                    }
                } else {
                    $datos_siap = $this->empleados_siap->buscar_usuario_siap(array("reg_delegacion" => $datos_post['delegacion_busqueda_validador'], "asp_matricula" => $datos_post['buscar_unidad_medica']));
//                    pr($datos_siap);
                    if (isset($datos_siap) AND is_array($datos_siap)) {//Si existe y es un array 
                        if (intval($datos_siap['status']) === 1) {
                            $data_selecciona_validador['base_reg_encontrado'] = 'sied';
                            $data_selecciona_validador['matricula'] = $datos_siap['matricula'];
                            $data_selecciona_validador['nombre'] = $datos_siap['nombre'];
                            $data_selecciona_validador['materno'] = $datos_siap['materno'];
                            $data_selecciona_validador['paterno'] = $datos_siap['paterno'];
                            $data_selecciona_validador['delegacion'] = $datos_siap['delegacion'];
                            $data_selecciona_validador['delegacion_id'] = $datos_siap['delegacion'];
                            $data_selecciona_validador['adscripcion'] = $datos_siap['adscripcion'];
                            $data_selecciona_validador['descripcion'] = $datos_siap['descripcion']; //Adscripción cve
                            $data_selecciona_validador['pue_despue'] = $datos_siap['pue_despue']; //categoría descripción
                            $data_selecciona_validador['emp_keypue'] = $datos_siap['emp_keypue']; //categoría cve
                            $data_selecciona_validador['status'] = $datos_siap['status'];
                            $data_selecciona_validador['categoria_id_sipimss'] = '0';
                            $data_selecciona_validador['antiguedad'] = $datos_siap['antiguedad'];
                            $data_selecciona_validador['sexo'] = $datos_siap['sexo'];
                            $data_selecciona_validador['curp'] = $datos_siap['curp'];
                            $data_selecciona_validador['emp_regims'] = $datos_siap['emp_regims'];
                            $data_selecciona_validador['fecha_ingreso'] = $datos_siap['fecha_ingreso'];
                            $data_selecciona_validador['rfc'] = $datos_siap['rfc'];
                            echo $this->load->view('designar_validador/seleccionar_validador', $data_selecciona_validador, true);
                        } else {
                            $data_selecciona_validador['mensaje'] = $string_values['lbl_status_empleado_cero'];
                            echo $this->load->view('designar_validador/mensajes', $data_selecciona_validador, true);
                        }
                    } else {
                        $data_selecciona_validador['mensaje'] = $string_values['lbl_no_se_encontro_empleado_sied'];
                        echo $this->load->view('designar_validador/mensajes', $data_selecciona_validador, true);
                    }
                }
            }
        } else {
            redirect(site_url());
        }
    }

    /**
     * Guarda los datos que se encuentran en los campos de datos de validador
     */
    public function get_data_seleccionar_validador() {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            $this->lang->load('interface', 'spanish');
            $string_values = $this->lang->line('interface')['designar_validador'];
            if (!is_null($this->input->post())) {
                $datos_post = $this->input->post(null, true); //Obtenemos el post o los valores
//                pr($datos_post);
//                exit();
//            $data_selecciona_validador['status'] = '0';
                $id_validacion = '';
                $categoria_name = '';
                if (isset($datos_post['bus_base_reg_encontrado'])) {//Si existe esté parametro, entonces se intenta guardar el registro
                    $id_usuario = $this->session->userdata('identificador'); //Asignamos id usuario a variable
                    $array_validador = array('EMPLEADO_CVE' => $datos_post['bus_empleado_cve'], 'DEPARTAMENTO_CVE' => $datos_post['bus_clave_adscripcion'], 'DELEGACION_CVE' => $datos_post['bus_delegacion_id_'], 'ROL_CVE' => enum_rols::Validador_N1, 'VAL_ESTADO' => 1);
                    $array_operacion_id_entidades = array(); //json array de registros por entidad
                    $array_datos_entidad = array(); //json array de operaciones por entidad
                    $almacenamiento_correcto = FALSE;
                    switch ($datos_post['bus_base_reg_encontrado']) {
                        case 'not'://Datos del empleado 
                            $data_selecciona_validador['mensaje'] = $string_values['lbl_no_se_encontro_empleado_sied'];
                            echo $this->load->view('designar_validador/mensajes', $data_selecciona_validador, true);
                            $almacenamiento_correcto = FALSE;
                            break;
                        case 'sipimss'://Si es de sipimss, ya existe en la base, sólo hay que seleccionar el id del empleado
//                                $delegacion_cve = $this->seguridad->decrypt_base64($datos_post['delegacion_cve']);
//                                $departamento_desc = $this->seguridad->decrypt_base64($datos_post['departamento_desc']);
//                                $departamento_desc = $this->seguridad->decrypt_base64($datos_post['MATRICULA']);

                            $this->load->model('Usuario_model', 'usum');
                            $datos_empleado = $this->usum->get_empleado($this->seguridad->decrypt_base64($datos_post['matricula'])); //Obtiene datos de validador y si existe el usuario relacionado con el empleado 
//                            pr($datos_empleado);
                            if (!empty($datos_empleado)) {//Si existe el empleado, se inserta como validador
                                $result_inser_validador = $this->dvm->insert_designar_validador_rol_use($array_validador, array('usuario_cve' => $datos_empleado['USUARIO_CVE']));
                            }
                            if (isset($result_inser_validador['usuario'])) {//Si existe la llave usuario, entonces, si se inserto el nuevo rol relacionado con usuario 
                                $array_datos_entidad['usuario_rol'] = array('USUARIO_CVE' => $result_inser_validador['usuario'], 'ROL_CVE' => $result_inser_validador['rol']);
                                $array_operacion_id_entidades['usuario_rol'] = array('insert' => $result_inser_validador['usuario'] . ' ' . $result_inser_validador['rol'], 'USUARIO_CVE' => $result_inser_validador['usuario'], 'ROL_CVE' => $result_inser_validador['rol']);
                                $id_validacion = $result_inser_validador['validador'];
                                
                            }
                            $almacenamiento_correcto = TRUE;
                            $categoria_name = $datos_post['bus_nombre_categoria'];
                            break;
                        case 'sied'://si es de sied, entonces, se debe de guardar el empleado, ya que no existe en la base de datos local 
                            $this->load->model('Registro_model', 'mod_registro');
                            $datos_empleados = array();
                            $datos_empleados['EMP_NOMBRE'] = $datos_post['bus_nombre'];
                            $datos_empleados['EMP_APE_PATERNO'] = $datos_post['bus_paterno'];
                            $datos_empleados['EMP_APE_MATERNO'] = $datos_post['bus_materno'];
                            $datos_empleados['EDO_LABORAL_CVE'] = $datos_post['bus_status'];
                            $datos_empleados['EMP_ANTIGUEDAD'] = $datos_post['bus_antiguedad'];
                            $datos_empleados['EMP_MATRICULA'] = $datos_post['bus_matricula'];
                            $datos_empleados['EMP_CURP'] = $datos_post['bus_curp'];
                            $datos_empleados['DELEGACION_CVE'] = $datos_post['bus_delegacion_id_'];
                            $datos_empleados['ADSCRIPCION_CVE'] = $datos_post['bus_clave_adscripcion'];
                            $datos_empleados['EMP_GENERO'] = $datos_post['bus_sexo'];
                            $res_cat = $this->mod_registro->get_categoria($datos_post['bus_clave_categoria']);
                            if (!empty($res_cat)) {//Sie es diferente de vacio, agrega la categoria y el nombre de la misma
//                                $res_cat = $res_cat[0];
                                $datos_empleados['CATEGORIA_CVE'] = $res_cat[0]['id_cat'];
                                $categoria_name = $res_cat[0]['nom_categoria'];
                            }
                            $result_id_emp = $this->mod_registro->insert_registro_empleado($datos_empleados); //Retorna id usuario
                            if ($result_id_emp > 0) {//se guardo el empleado correctamente 
                                //Actualizacion de los datos de empleado********
                                $this->load->model('Usuario_model', 'usum');
                                $this->usum->updateEmpleado($result_id_emp);
                                //**********************************************

                                $datos_empleados['EMPLEADO_CVE'] = $result_id_emp; //asigna id del empleado nuevo insertado
                                //Asigna arrays para guardar a bitacora 
                                $array_operacion_id_entidades['empleado'] = array('insert' => $result_id_emp, 'EMPLEADO_CVE' => $result_id_emp);
                                $array_datos_entidad ['empleado'] = $datos_empleados;
                                //Prepara para insertar datos del validador
                                $info_validador = $datos_post['id_validaor'];
                                $this->load->model('Usuario_model', 'usum');
                                if (!empty($info_validador) AND $info_validador !== '0') {
                                    $info_validador = $this->seguridad->decrypt_base64($info_validador);
                                    $result = $this->dvm->get_validador_n1(null, $info_validador);
                                    $usuario_validador = $this->usum->get_usuario_validador(null, $info_validador); //Obtiene datos de validador y si existe el usuario relacionado con el empleado 
                                } else {
                                    $result_inser_validador = $this->dvm->insert_designar_validador_rol_use($array_validador, $usuario_validador);
                                    $result = array();
                                }

                                $array_validador['EMPLEADO_CVE'] = $result_id_emp; //Asigna al array el id del empledo agregado 
                                if (empty($result)) {//Si es vacio el array, entonces, se agrega el validador
                                    $usuario_validador = $this->usum->get_usuario_validador($result_id_emp); //Obtiene datos de validador y si existe el usuario relacionado con el empleado 
//                                    pr($result_inser_validador);
                                    if (!empty($result_inser_validador)) {
                                        $id_validacion = $result_inser_validador['validador'];
                                        $result_id_emp = $datos_post['bus_empleado_cve'];
                                        $array_validador['VALIDADOR_CVE'] = $result_inser_validador['validador'];
                                        $array_datos_entidad['validador'] = $array_validador;
                                        $array_operacion_id_entidades['validador'] = array('insert' => $result_inser_validador['validador'], 'VALIDADOR_CVE' => $result_inser_validador['validador']);
                                        if (isset($result_inser_validador['usuario'])) {//Si existe la llave usuario, entonces, si se inserto el nuevo rol relacionado con usuario 
                                            $array_datos_entidad['usuario_rol'] = array('USUARIO_CVE' => $result_inser_validador['usuario'], 'ROL_CVE' => $result_inser_validador['rol']);
                                            $array_operacion_id_entidades['usuario_rol'] = array('insert' => $result_inser_validador['usuario'] . ' ' . $result_inser_validador['rol'], 'USUARIO_CVE' => $result_inser_validador['usuario'], 'ROL_CVE' => $result_inser_validador['rol']);
                                        }
                                        $almacenamiento_correcto = TRUE;
                                    }
                                } else if (intval($result['VAL_ESTADO']) === 0) {//Si no es vacio, hace una actualización  
                                    $id_validacion = $result['VALIDADOR_CVE'];
                                    $this->load->model('Usuario_model', 'usum');
                                    $usuario_validador = $this->usum->get_usuario_validador($datos_post['bus_empleado_cve']); //Obtiene datos de validador y si existe el usuario relacionado con el empleado 
                                    $result_actualizacion = $this->dvm->update_designar_validador($id_validacion, $array_validador, $usuario_validador);
                                    if (!empty($result_actualizacion)) {
                                        if (isset($result_actualizacion['usuario_rol'])) {//Si se guardo o inserto un registro de usuario rol
                                            $array_operacion_id_entidades['usuario_rol'] = array('update' => $result_actualizacion['usuario_rol']['USUARIO_CVE'], 'USUARIO_CVE' => $result_actualizacion['usuario_rol']['USUARIO_CVE'], 'ROL_CVE' => $result_actualizacion['usuario_rol']['ROL_CVE']);
                                            $array_datos_entidad['usuario_rol'] = $result_actualizacion['usuario_rol'];
                                        }
                                        $array_operacion_id_entidades['validador'] = array('update' => $result_actualizacion['validador']['VALIDADOR_CVE'], 'VALIDADOR_CVE' => $result_actualizacion['validador']['VALIDADOR_CVE']);
                                        $array_datos_entidad['validador'] = $result_actualizacion['validador'];
                                        $almacenamiento_correcto = TRUE;
                                    }
                                }
                                $categoria_name = $datos_post['bus_nombre_categoria'];
                            }
                            break;
                    }


                    if ($almacenamiento_correcto) {//Bandera que indica si se almaceno correctamente los datos
                        //Prepara para almacenar en bitacora
                        //Convierte a json las variables 
                        $json_datos_entidad = json_encode($array_operacion_id_entidades); //Codifica a json datos de entidad
                        $json_registro_bitacora = json_encode($array_datos_entidad); //Codifica a json la actualización o insersión a las entidades involucradas
                        //Datos de bitacora el registro del usuario
                        registro_bitacora($id_usuario, null, $json_datos_entidad, null, $json_registro_bitacora, null);
                        $id_validacion = (!empty($id_validacion)) ? $this->seguridad->encrypt_base64($id_validacion) : $id_validacion;
                        $name = $datos_post['bus_nombre'] . ' ' . $datos_post['bus_paterno'] . ' ' . $datos_post['bus_materno'];
                        $rs = array('id_validador' => $id_validacion,
                            'matricula' => $datos_post['bus_matricula'],
                            'nombre' => $name,
                            'categoria_nombre' => $categoria_name,
                        );
                        $tipo_msg = $this->config->item('alert_msg');
                        $resultado['result_datos'] = $rs;
                        $resultado['error'] = $string_values['insert_validador_asignacion']; //
                        $resultado['tipo_msg'] = $tipo_msg['SUCCESS']['class']; //Tipo de mensaje de error
                        echo json_encode($resultado);
                    } else {
                        $data_selecciona_validador['mensaje'] = $string_values['lbl_fallo_designar_validador'];
                        echo $this->load->view('designar_validador/mensajes', $data_selecciona_validador, true);
                    }
                } else {//NO existe, manda un mensaje que debe seleccionar validador
                    $data_selecciona_validador['mensaje'] = $string_values['lbl_no_selecciono_validador'];
                    echo $this->load->view('designar_validador/mensajes', $data_selecciona_validador, true);
                }
            }
        } else {
            redirect(site_url());
        }
    }

    /**
     * @author Luis Eduardo Aguilera Soto
     * Desvincula el validador asignado a la unidad 
     */
    public function get_data_eliminar_vinculo_validador() {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) {
                $datos_post = $this->input->post(null, true); //Obtenemos el post o los valores
                $id_validador = intval($this->seguridad->decrypt_base64($datos_post['id_validador']));
                if ($id_validador > 0) {//Contiene un id el validador
                    $this->lang->load('interface', 'spanish');
                    $string_values = $this->lang->line('interface')['designar_validador'];
                    $array_operacion_id_entidades = array(); //json array de registros por entidad
                    $array_datos_entidad = array(); //json array de operaciones por entidad
                    $tipo_msg = $this->config->item('alert_msg');
                    $this->load->model('Usuario_model', 'usum');
                    $usuario_validador = $this->usum->get_usuario_validador(null, $id_validador); //Obtiene datos de validador
                    $result_delete_desig_val = $this->dvm->delete_vinculo_validador_n1($usuario_validador);
                    if (!empty($result_delete_desig_val)) {//Se elimino el vinculo entré validador y rol usuario 
                        $result_id_user = $this->session->userdata('identificador'); //Obtiene identificador del usuario de la sesión
                        if (isset($result_delete_desig_val['usuario_rol'])) {
                            $array_datos_entidad['usuario_rol'] = $result_delete_desig_val['usuario_rol'];
                            $array_operacion_id_entidades['usuario_rol'] = array('delete' => $result_delete_desig_val['usuario_rol']['USUARIO_CVE'] . ',' . $result_delete_desig_val['usuario_rol']['ROL_CVE']);
                        }
                        $array_datos_entidad['validador'] = $result_delete_desig_val['validador'];
                        $array_operacion_id_entidades['validador'] = array('update' => $result_delete_desig_val['validador']['VALIDADOR_CVE']);

                        $json_datos_entidad = json_encode($array_datos_entidad); //Codifica a json datos de entidad
                        $json_registro_bitacora = json_encode($array_operacion_id_entidades); //Codifica a json la actualización o insersión a las entidades involucradas
                        //Datos de bitacora el registro del usuario
                        registro_bitacora($result_id_user, null, $json_datos_entidad, null, $json_registro_bitacora, null);
                        $resultado['success'] = 1;
                        $resultado['error'] = $string_values['delete_validador_asignacion_succes']; //
                        $resultado['tipo_msg'] = $tipo_msg['SUCCESS']['class']; //Tipo de mensaje de error
                    } else {
                        $resultado['success'] = 0;
                        $resultado['error'] = $string_values['delete_validador_asignacion_fallo']; //
                        $resultado['tipo_msg'] = $tipo_msg['DANGER']['class']; //Tipo de mensaje de error
                    }
                    echo json_encode($resultado);
                }
            }
        } else {
            redirect(site_url());
        }
    }

    public function get_data_buscar_datos_opcion_validador() {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            $this->lang->load('interface', 'spanish');
            $string_values = $this->lang->line('interface')['designar_validador'];
            $data_selecciona_validador['mostrar_buscador'] = "display: none";
            if (!is_null($this->input->post())) {
                $datos_post = $this->input->post(null, true); //Obtenemos el post o los valores
//                pr($datos_post);
                if (intval($datos_post['candidato_a_validador']) === 0) {
                    $data_selecciona_validador['mostrar_buscador'] = "display: block";
                } else {
                    $data_selecciona_validador['mostrar_buscador'] = "display: none";
                }

                $data_selecciona_validador['string_values'] = $string_values;
                $data_selecciona_validador['reg_delegacion_cve'] = $datos_post['delegacion_cve'];
                $data_selecciona_validador['reg_departamento_desc'] = $datos_post['departamento_desc'];
                $data_selecciona_validador['reg_id_validador'] = $datos_post['id_validaor'];
            }
            echo $this->load->view('designar_validador/seleccionar_validador', $data_selecciona_validador, true);
        } else {
            redirect(site_url());
        }
    }

    public function get_data_buscar_unidades($current_row = null) {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) {
                $this->lang->load('interface', 'spanish');
                $string_values = $this->lang->line('interface')['designar_validador'];
                $filtros = $this->input->post(null, true); //Obtenemos el post o los valores 
                $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
                $id_delegacion = (strlen($this->session->userdata('delegacion_cve')) > 1) ? $this->session->userdata('delegacion_cve') : '0' . $this->session->userdata('delegacion_cve');
                $filtros['delegacion_cve'] = $id_delegacion; //Carga la delegación del usuario
//            $filtros['per_page'] = 10;
//            pr($filtros);
                $resutlado = $this->dvm->get_buscar_unidades($filtros);
//                pr($resutlado);
                $data['string_values'] = $string_values;
                $data['lista_unidades'] = $resutlado['result'];
                $data['total'] = $resutlado['total'];
                $data['current_row'] = $filtros['current_row'];
                $data['per_page'] = $this->input->post('per_page');

                if (isset($data['lista_unidades']) && !empty($data['lista_unidades'])) {
                    $this->listado_resultado_unidades($data, array('form_recurso' => '#form_busqueda_unidades',
                        'elemento_resultado' => '#div_result_unidades_medicas'
                    )); //Generar listado en caso de obtener datos
                } else {
                    echo $string_values ['resp_sin_resultados'];
                }
            }
        } else {
            redirect(site_url());
        }
    }

    private function listado_resultado_unidades($data, $form) {
        $data['controller'] = 'designar_validador';
        $data['action'] = 'get_data_buscar_unidades';
        $pagination = $this->template->pagination_data($data); //Crear mensaje y links de paginación
        //$pagination = $this->template->pagination_data_buscador_asignar_validador($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                    <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
        $datos['lista_unidades'] = $data['lista_unidades'];
        $datos['string_values'] = $data['string_values'];
        echo $links . $this->load->view('designar_validador/tabla_resultados_dv', $datos, TRUE) . $links . '
                <script>
                $("ul.pagination li a").click(function(event){
                    data_ajax(this, "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
                    event.preventDefault();
                });
                </script>';
    }

}
