<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que muestra los datos de cada curso
 * @version 	: 1.0.0
 * @autor 		: JZDP
 * fecha        : 21/09/2016
 */
class Perfil_registro extends MY_Controller {

    /**
     * Class Constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->library('form_complete');
        //$this->load->library('empleados_siap');
        $this->load->library('Ventana_modal');
        $this->load->config('general');
        $this->load->library('form_validation');
        $this->load->library('seguridad');
        //$this->load->model('Validacion_docente_model', 'vdm');
        //*****Datos perfil 
        //$this->load->model('Catalogos_generales', 'cg');
        $this->load->model('Actividad_docente_model', 'adm');
        $this->load->model('Investigacion_docente_model', 'idm');
        $this->load->model('Becas_comisiones_laborales_model', 'bcl');
        $this->load->model('Material_educativo_model', 'mem');
        //$this->load->model('Perfil_model', 'modPerfil');
        $this->load->helper('date');
    }

    public function index() {
        redirect('/');
    }

    public function formacion_salud_detalle($identificador = null, $validar = null) {
        //pr($this->session->userdata());
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            $this->load->model('Formacion_model', 'fm');
            $this->lang->load('interface');
            $data['identificador'] = $identificador;
            $fs_id = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
            //$data['idc'] = $this->input->post('idc', true); //Campo necesario para mostrar link de comprobante
            $data['string_values'] = array_merge($this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['formacion_salud'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']);

            $data['dir_tes'] = $this->fm->get_formacion_salud(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado(), 'FPCS_CVE' => $fs_id), 'fields' => 'emp_for_personal_continua_salud.*, licenciatura.*, ctipo_formacion_salud.TIP_FORM_SALUD_NOMBRE, csubtipo_formacion_salud.SUBTIP_NOMBRE, TIPO_COMPROBANTE_CVE'))[0]; //Obtener datos
//            pr($data['dir_tes']);
            $accion_general = $this->config->item('ACCION_GENERAL');
            if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                $data = $this->validar_registro(array_merge($data, array('tipo_id' => 'FORMACION_SALUD', 'seccion_actualizar' => 'seccion_formacion', 'identificador_registro' => $fs_id)));
            } else {
                $data['formulario_validacion'] = $this->historico_registro(array_merge($data, array('tipo_id' => 'FORMACION_SALUD', 'seccion_actualizar' => 'seccion_formacion', 'identificador_registro' => $fs_id)));
                $data['pie_modal'] = '<div class="col-xs-12 col-sm-12 col-md-12 text-right"><button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">' . $data['string_values']['cerrar'] . '</button></div>';
            }

            $data['formulario_carga_archivo'] = $this->load->view('template/formulario_visualizar_archivo', $data, TRUE);
            $data['titulo_modal'] = $data['string_values']['title'];
            //pr($data);
            $data['cuerpo_modal'] = $this->load->view('validador_censo/formacion/formacion_salud_detalle', $data, TRUE);

            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function formacion_docente_detalle($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            $this->load->model('Formacion_model', 'fm');
            $this->lang->load('interface');
            $data['identificador'] = $identificador;
            $fs_id = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
            $validacion_cve_session = $this->obtener_id_validacion();
            $data['idc'] = $this->input->post('idc', true); //Campo necesario para mostrar link de comprobante
            $data['string_values'] = array_merge($this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['formacion_docente'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']);
            $tmp = $resultado_almacenado = array();
            $tmp_tematica = '0';

            $condiciones_ = array(enum_ecg::cinstitucion_avala => array('IA_TIPO' => $this->config->item('institucion')['imparte'])); //Obtener catálogos para llenar listados desplegables
            $entidades_ = array(enum_ecg::ctipo_comprobante, enum_ecg::cinstitucion_avala, enum_ecg::cmodalidad, enum_ecg::ctipo_formacion_profesional, enum_ecg::ctematica);
            $data['catalogos'] = carga_catalogos_generales($entidades_, null, $condiciones_);

            $data['mostrar_hora_fecha_duracion'] = 0;
            //pr($this->session->userdata());
            $data['dir_tes'] = $this->fm->get_formacion_docente(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado(), 'EMP_FORMACION_PROFESIONAL_CVE' => $fs_id), 'order' => 'EFO_ANIO_CURSO', 'fields' => 'emp_formacion_profesional.*, cinstitucion_avala.IA_NOMBRE, ctipo_formacion_profesional.TIP_FOR_PRO_NOMBRE, csubtipo_formacion_profesional.SUB_FOR_PRO_NOMBRE, cmodalidad.MOD_NOMBRE, comprobante.TIPO_COMPROBANTE_CVE, ccurso.CUR_NOMBRE'))[0]; //ctipo_curso.TIP_CUR_NOMBRE,
            $data['dir_tes']['tematica'] = $this->fm->get_formacion_docente_tematica(array('conditions' => array('EMP_FORMACION_PROFESIONAL_CVE' => $fs_id), 'order' => 'TEM_NOMBRE'));

            $accion_general = $this->config->item('ACCION_GENERAL');
            if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                $data = $this->validar_registro(array_merge($data, array('tipo_id' => 'FORMACION_PROFESIONAL', 'seccion_actualizar' => 'seccion_formacion', 'identificador_registro' => $fs_id)));
            } else {
                $data['formulario_validacion'] = $this->historico_registro(array_merge($data, array('tipo_id' => 'FORMACION_PROFESIONAL', 'seccion_actualizar' => 'seccion_formacion', 'identificador_registro' => $fs_id)));
                $data['pie_modal'] = '<div class="col-xs-12 col-sm-12 col-md-12 text-right"><button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">' . $data['string_values']['cerrar'] . '</button></div>';
            }

            $data['formulario_carga_archivo'] = $this->load->view('template/formulario_visualizar_archivo', $data, TRUE);
            $data['titulo_modal'] = $data['string_values']['title'];
            //pr($data['formulario_validacion']);
            $data['cuerpo_modal'] = $this->load->view('validador_censo/formacion/formacion_docente_detalle', $data, TRUE);

            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function direccion_tesis_detalle($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            $controlador_solicitante = $this->session->userdata('ctr_solicitante');//Controlador que solicita que se carguen los datos
            $this->load->model('Direccion_tesis_model', 'dt');
            $this->lang->load('interface');
            $data['identificador'] = $identificador;
            $dt_id = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
            $data['string_values'] = array_merge($this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['direccion_tesis'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']);
            //pr($this->session->userdata());
            $data['dir_tes'] = $this->dt->get_lista_datos_direccion_tesis(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado(), 'EMP_COMISION_CVE' => $dt_id), 'fields' => 'emp_comision.*, comprobante.COM_NOMBRE, comprobante.TIPO_COMPROBANTE_CVE, ctipo_comprobante.TIP_COM_NOMBRE, cnivel_academico.NIV_ACA_NOMBRE, comision_area.COM_ARE_NOMBRE'))[0]; //Obtener datos

            $accion_general = $this->config->item('ACCION_GENERAL');
            if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                $data = $this->validar_registro(array_merge($data, array('tipo_id' => 'COMISION_ACADEMICA', 'seccion_actualizar' => 'seccion_direccion_tesis', 'identificador_registro' => $dt_id)));
            } else {
                $data['formulario_validacion'] = $this->historico_registro(array_merge($data, array('tipo_id' => 'COMISION_ACADEMICA', 'seccion_actualizar' => 'seccion_direccion_tesis', 'identificador_registro' => $dt_id)));
                $data['pie_modal'] = '<div class="col-xs-12 col-sm-12 col-md-12 text-right"><button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">' . $data['string_values']['cerrar'] . '</button></div>';
            }
            //pr($data['formulario_validacion']);
            $data['formulario_carga_archivo'] = $this->load->view('template/formulario_visualizar_archivo', $data, TRUE);
            $data = array(
                'titulo_modal' => $data['string_values']['title'],
                'cuerpo_modal' => $this->load->view('validador_censo/direccionTesis/direccion_tesis_detalle', $data, TRUE)
            );

            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function comision_academica_detalle($tipo_comision = null, $identificador = null) {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            $this->load->model('Comision_academica_model', 'ca');
            $this->lang->load('interface');
            if ($this->input->post()) {//
                $data = $this->input->post(null, true);
                $identificador = $data['value'];
                if ($data['tipo'] AND ! empty($data['tipo'])) {
                    $tipo_comision = $data['tipo'];
                }
            }
            $data['tipo_comision'] = $tipo_comision;
            $data['identificador'] = $identificador;
            $tc_id = (!is_numeric($tipo_comision)) ? $this->seguridad->decrypt_base64($tipo_comision) : $tipo_comision; //Identificador del tipo de comisión

            $ca_id = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
            $validar = $this->input->get('dv'); //Bandera que habilita la validación
            //$data['idc'] = $this->input->post('idc', true); //Campo necesario para mostrar link de comprobante
            $data['string_values'] = array_merge($this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['comision_academica'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']);

            $config = $this->comision_academica_configuracion($tc_id, false);
            $data['catalogos'] = $config['catalogos'];

            $data['mostrar_hora_fecha_duracion'] = 0; //$this->get_valor_validacion($datos_formulario, 'duracion'); //Muestrá validaciones de hora y fecha de inicio y termino según la opción de duración

            $data['dir_tes'] = $this->ca->get_comision_academica(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado(), 'EMP_COMISION_CVE' => $ca_id), 'fields' => 'emp_comision.*, comprobante.COM_NOMBRE, comprobante.TIPO_COMPROBANTE_CVE, ctipo_curso.TIP_CUR_NOMBRE, ccurso.CUR_NOMBRE, cnivel_academico.NIV_ACA_NOMBRE'))[0]; //Obtener datos

            $accion_general = $this->config->item('ACCION_GENERAL');
            if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                $data = $this->validar_registro(array_merge($data, array('tipo_id' => 'COMISION_ACADEMICA', 'seccion_actualizar' => 'seccion_comision_academica', 'identificador_registro' => $ca_id)));
            } else {
                $data['formulario_validacion'] = $this->historico_registro(array_merge($data, array('tipo_id' => 'COMISION_ACADEMICA', 'seccion_actualizar' => 'seccion_comision_academica', 'identificador_registro' => $ca_id)));
                $data['pie_modal'] = '<div class="col-xs-12 col-sm-12 col-md-12 text-right"><button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">' . $data['string_values']['cerrar'] . '</button></div>';
            }
            //pr($data);
            $data['formulario_carga_archivo'] = $this->load->view('template/formulario_visualizar_archivo', $data, TRUE);
            $data['titulo_modal'] = $data['string_values']['title'];

            $data['cuerpo_modal'] = $this->load->view($config['plantilla'], $data, TRUE);

            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function carga_datos_investigacion($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) {
            $this->lang->load('interface', 'spanish');
            $data_investigacion['string_values'] = array_merge($this->lang->line('interface')['investigacion_docente'], $this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']); //Carga textos a utilizar 

            $data_investigacion['identificador'] = $identificador;
            //$result_id_user = $this->obtener_id_usuario(); //Asignamos id usuario a variable
            //$matricula_user = $this->session->userdata('matricula');

            $id_inv = $this->seguridad->decrypt_base64($identificador);
            $data_investigacion['dir_tes'] = $this->idm->get_datos_investigacion_docente($id_inv); //Variable que carga los datos del registro de investigación, será enviada a la vista para cargar los datos
            //Selecciona divulgación
            $data_investigacion['formulario_carga_opt_tipo_divulgacion'] = $this->divulgacion_cargar($data_investigacion['dir_tes']['med_divulgacion_cve'], $data_investigacion, TRUE);
            $accion_general = $this->config->item('ACCION_GENERAL');
            if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                $data_investigacion = $this->validar_registro(array_merge($data_investigacion, array('tipo_id' => 'INVESTIGACION_EDUCATIVA', 'seccion_actualizar' => 'seccion_investigacion', 'identificador_registro' => $id_inv)));
            } else {
                $data_investigacion['formulario_validacion'] = $this->historico_registro(array_merge($data_investigacion, array('tipo_id' => 'INVESTIGACION_EDUCATIVA', 'seccion_actualizar' => 'seccion_investigacion', 'identificador_registro' => $id_inv)));
                $data_investigacion['pie_modal'] = '<div class="col-xs-12 col-sm-12 col-md-12 text-right"><button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">' . $data_investigacion['string_values']['cerrar'] . '</button></div>';
            }
            $data = array(
                'titulo_modal' => $data_investigacion['string_values']['title_investigacion'],
                'cuerpo_modal' => $this->load->view('validador_censo/investigacion/investigacion_formulario', $data_investigacion, TRUE),
                'pie_modal' => null //$this->load->view('validador_censo/investigacion/investigacion_pie', $datos_pie, true)
            );

            echo $this->ventana_modal->carga_modal($data);
        } else {
            redirect(site_url());
        }
    }

    public function carga_datos_editar_material_educativo($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) {
            $this->lang->load('interface', 'spanish');
            $datos_mat_edu['string_values'] = array_merge($this->lang->line('interface')['material_educativo'], $this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']); //Carga textos a utilizar 

            $material_edu_cve = $this->seguridad->decrypt_base64($identificador); //Identificador de materia_educativo
            $datos_mat_edu['identificador'] = $identificador;
            $datos_mat_edu['info_material_educativo'] = $this->mem->get_datos_material_educativo($material_edu_cve);

            //Carga el formulario secundario segun la opcion de tipo de material educativo
            $datos_mat_edu['info_material_educativo']['material_educativo_cve'] = (!empty($datos_mat_edu['info_material_educativo']['padre_tp_material'])) ? $datos_mat_edu['info_material_educativo']['padre_tp_material'] : $datos_mat_edu['info_material_educativo']['tipo_material_cve'];
            $datos_form_secundario['datos'] = $datos_mat_edu['info_material_educativo'];
            $datos_form_secundario['string_values'] = $datos_mat_edu['string_values'];
            $datos_form_secundario['cantidad_hojas'] = $this->config->item('opciones_tipo_material')['cantidad_hojas'];
            $datos_form_secundario['numero_horas'] = $this->config->item('opciones_tipo_material')['numero_horas'];
            $datos_mat_edu['formulario_complemento'] = $this->load->view('validador_censo/material_educativo/formulario_mat_edu_' . $datos_mat_edu['info_material_educativo']['material_educativo_cve'], $datos_form_secundario, TRUE);

            $accion_general = $this->config->item('ACCION_GENERAL');
            if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                $datos_mat_edu = $this->validar_registro(array_merge($datos_mat_edu, array('tipo_id' => 'MATERIAL_EDUCATIVO', 'seccion_actualizar' => 'seccion_material_educativo', 'identificador_registro' => $material_edu_cve)));
            } else {
                $datos_mat_edu['formulario_validacion'] = $this->historico_registro(array_merge($datos_mat_edu, array('tipo_id' => 'MATERIAL_EDUCATIVO', 'seccion_actualizar' => 'seccion_material_educativo', 'identificador_registro' => $material_edu_cve)));
                $datos_mat_edu['pie_modal'] = '<div class="col-xs-12 col-sm-12 col-md-12 text-right"><button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">' . $datos_mat_edu['string_values']['cerrar'] . '</button></div>';
            }
            $datos_mat_edu['formulario_carga_archivo'] = $this->load->view('template/formulario_visualizar_archivo', array('dir_tes' => $datos_mat_edu['info_material_educativo']), TRUE);

            $data = array(
                'titulo_modal' => $datos_mat_edu['string_values']['title_material_eduacativo'],
                'cuerpo_modal' => $this->load->view('validador_censo/material_educativo/formulario_mat_edu_general', $datos_mat_edu, TRUE),
                'pie_modal' => null //$this->load->view('validador_censo/material_educativo/material_edu_pie', $datos_pie, true)
            );
            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
            /* } else {

              } */
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function carga_datos_editar_beca($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) {
            $this->lang->load('interface', 'spanish');
            $data_becas['string_values'] = array_merge($this->lang->line('interface')['becas_comisiones'], $this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']); //Carga textos a utilizar 
            $data_becas['identificador'] = $identificador;
            $cve_beca = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
            $data_becas['dir_tes'] = $this->bcl->get_datos_becas($cve_beca); //Datos de becas

            $accion_general = $this->config->item('ACCION_GENERAL');
            if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                $data_becas = $this->validar_registro(array_merge($data_becas, array('tipo_id' => 'BECA', 'seccion_actualizar' => 'seccion_becas_comisiones', 'identificador_registro' => $cve_beca)));
            } else {
                $data_becas['formulario_validacion'] = $this->historico_registro(array_merge($data_becas, array('tipo_id' => 'BECA', 'seccion_actualizar' => 'seccion_becas_comisiones', 'identificador_registro' => $cve_beca)));
                $data_becas['pie_modal'] = '<div class="col-xs-12 col-sm-12 col-md-12 text-right"><button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">' . $data_becas['string_values']['cerrar'] . '</button></div>';
            }
            $data_becas['formulario_carga_archivo'] = $this->load->view('template/formulario_visualizar_archivo', $data_becas, TRUE);
            //**** fi de comprobante *******************************************

            $data = array(
                'titulo_modal' => $data_becas['string_values']['title_becas'],
                'cuerpo_modal' => $this->load->view('validador_censo/becas_comisiones/formulario_becas', $data_becas, TRUE),
                'pie_modal' => null //$this->load->view('validador_censo/becas_comisiones/becas_pie', $datos_pie, true)
            );
            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function carga_datos_editar_comision($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) {
            //$datos_post = $this->input->post(null, true);
            $this->lang->load('interface', 'spanish');
            $data_comisiones['string_values'] = array_merge($this->lang->line('interface')['becas_comisiones'], $this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']); //Carga textos a utilizar 
            $data_comisiones['identificador'] = $identificador;
            $cve_comision = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
            $data_comisiones['dir_tes'] = $this->bcl->get_datos_comisiones($cve_comision); //Datos de becas

            $accion_general = $this->config->item('ACCION_GENERAL');
            if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                $data_comisiones = $this->validar_registro(array_merge($data_comisiones, array('tipo_id' => 'COMISION_ACADEMICA', 'seccion_actualizar' => 'seccion_becas_comisiones', 'identificador_registro' => $cve_comision)));
            } else {
                $data_comisiones['formulario_validacion'] = $this->historico_registro(array_merge($data_comisiones, array('tipo_id' => 'COMISION_ACADEMICA', 'seccion_actualizar' => 'seccion_becas_comisiones', 'identificador_registro' => $cve_comision)));
                $data_comisiones['pie_modal'] = '<div class="col-xs-12 col-sm-12 col-md-12 text-right"><button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">' . $data_comisiones['string_values']['cerrar'] . '</button></div>';
            }
            $data_comisiones['formulario_carga_archivo'] = $this->load->view('template/formulario_visualizar_archivo', $data_comisiones, TRUE);

            $data = array(
                'titulo_modal' => $data_comisiones['string_values']['tabs_comisiones'],
                'cuerpo_modal' => $this->load->view('validador_censo/becas_comisiones/formulario_comisiones', $data_comisiones, TRUE),
                'pie_modal' => null //$this->load->view('validador_censo/becas_comisiones/comisiones_pie', $datos_pie, true)
            );
            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function carga_datos_actividad($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) {
            $this->lang->load('interface', 'spanish');
            $data_actividad['string_values'] = array_merge($this->lang->line('interface')['actividad_docente'], $this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']); //Carga textos a utilizar 
            $data_actividad['identificador'] = $identificador;

            $cve_actividad = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
//            pr($cve_actividad);
            $tipo_actividad_docente = $this->input->get('t', true);

            if ($tipo_actividad_docente > 0) {
                $propiedades = $this->config->item('actividad_docente_componentes')[$tipo_actividad_docente]; //Carga el nombre de la vista del diccionario 
                $data_formulario = $this->cargar_datos_actividad($tipo_actividad_docente, $cve_actividad, $propiedades); //No mover posición puede romperse
//                        pr($data_formulario);
                $carga_extra = $propiedades['validaciones_extra'];
                $data_formulario = $this->cargar_extra($data_formulario, $carga_extra); //No mover posición puede romperse
                //pr($data_formulario);
                $condiciones_ = array(); //Carga, únicamente el tipo de actividad docente
                if (isset($propiedades['where'])) {
                    $condiciones_ = $propiedades['where']; //Carga, únicamente el tipo de actividad docente
                }

                $tipo_were = array(); //Carga, únicamente el tipo de actividad docente
                if (isset($propiedades['where_grup'])) {
                    $tipo_were = $propiedades['where_grup']; //Carga, únicamente el tipo de actividad docente
                }
                $catalogos_ = $propiedades['catalogos_indexados']; //Carga, únicamente el tipo de actividad docente
                $data_formulario = carga_catalogos_generales($catalogos_, $data_formulario, $condiciones_, true, $tipo_were);

                $valua_entidad = $propiedades['tabla_guardado'] === 'emp_actividad_docente';
                if ($valua_entidad AND isset($data_formulario['ctipo_curso_cve']) AND ! empty($data_formulario['ctipo_curso_cve']) AND isset($data_formulario['ccurso_cve']) AND ! empty($data_formulario['ccurso_cve'])) {//si existe el "ccurso" y "ctipo_curso", hay que pintarlo
                    $tipo_curso_cve = intval($data_formulario['ctipo_curso_cve']);
                    $data_formulario['ccurso_pinta'] = $this->vista_ccurso($tipo_curso_cve, $data_formulario['CUR_NOMBRE']); //Punta el curso
                }

                $data_formulario['string_values'] = $data_actividad['string_values'];
                $data_formulario['identificador'] = $identificador;
                $accion_general = $this->config->item('ACCION_GENERAL');
                //pr($this->config->item('actividad_docente_componentes')[$tipo_actividad_docente]['tabla_validacion']);
                if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                    //pr($data_formulario);
                    $data_formulario = $this->validar_registro(array_merge($data_formulario, array('tipo_id' => $this->config->item('actividad_docente_componentes')[$tipo_actividad_docente]['tabla_validacion'], 'seccion_actualizar' => 'seccion_actividad_docente', 'identificador_registro' => $cve_actividad)));
                } else {
                    $data_formulario['formulario_validacion'] = $this->historico_registro(array_merge($data_formulario, array('tipo_id' => $this->config->item('actividad_docente_componentes')[$tipo_actividad_docente]['tabla_validacion'], 'seccion_actualizar' => 'seccion_actividad_docente', 'identificador_registro' => $cve_actividad)));
                    $data_formulario['pie_modal'] = '<div class="col-xs-12 col-sm-12 col-md-12 text-right"><button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">' . $data_actividad['string_values']['cerrar'] . '</button></div>';
                }
                $data_formulario['formulario_carga_archivo'] = $this->load->view('template/formulario_visualizar_archivo', array('dir_tes' => $data_formulario), TRUE);

                //Carga la vista del formulario                        
                $data_actividad['formulario'] = $this->load->view($propiedades['vista_validacion'], $data_formulario, TRUE);
                $data_actividad['nada'] = '';
            }
            //}

            $data = array(
                'titulo_modal' => 'Actividad docente',
                'cuerpo_modal' => $this->load->view('validador_censo/actividad_docente/actividad_modal_tpl', $data_actividad, TRUE),
                'pie_modal' => null //$this->load->view('validador_censo/actividad_docente/actividad_docente_pie', $datos_pie, true)
            );
            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
            //}
        } else {
            redirect(site_url());
        }
    }

    private function cargar_datos_actividad($id_tp_actividad, $id_act_doc, $propiedades_entidad) {
        $cve = $propiedades_entidad['llave_primaria'];
        $entidad = $propiedades_entidad['tabla_guardado'];
        $result_consulta = $this->adm->get_datos_actividad_docente($entidad, $id_act_doc);
        return $result_consulta;
    }

    private function cargar_extra($array_datos, $array_extras) {
        foreach ($array_extras as $value) {
            switch ($value) {
                case 'pago_extra':
                    if (key_exists($value, $array_datos)) {
                        $array_datos['pago_extra'];
                    }
                    break;
                case 'duracion':
                    if (key_exists('hora_dedicadas', $array_datos) AND ! is_null($array_datos['hora_dedicadas'])) {
                        $array_datos['duracion'] = 'hora_dedicadas';
                        $array_datos['mostrar_hora_fecha_duracion'] = 'hora_dedicadas';
                    } else {
                        $array_datos['duracion'] = 'fecha_dedicadas';
                        $array_datos['mostrar_hora_fecha_duracion'] = 'fecha_dedicadas';
                    }

                    break;
            }
        }
        return $array_datos;
    }

    private function divulgacion_cargar($divulgacion_cve, $array_comprobante = array(), $is_actualizacion = FALSE) {
        if (!empty($divulgacion_cve)) {
            $cve_divulgacion = intval($divulgacion_cve);
            $this->lang->load('interface', 'spanish');
            switch ($cve_divulgacion) {
                case 3:
                    $array_comprobante['string_values'] = $this->lang->line('interface')['investigacion_docente'];
                    if ($is_actualizacion AND key_exists('cita_publicada', $array_comprobante['dir_tes'])) {
                        $array_comprobante['bibliografia_libro'] = $array_comprobante['dir_tes']['cita_publicada'];
                    }
                    return $this->load->view('validador_censo/investigacion/bibliografia_libro', $array_comprobante, TRUE);
                    break;
                case 4:
                    $array_comprobante['string_values'] = $this->lang->line('interface')['investigacion_docente'];
                    if ($is_actualizacion AND key_exists('cita_publicada', $array_comprobante['dir_tes'])) {
                        $array_comprobante['bibliografia_revista'] = $array_comprobante['dir_tes']['cita_publicada'];
                    }
                    return $this->load->view('validador_censo/investigacion/bibliografia_revista', $array_comprobante, TRUE);
                    break;
                default :
                    $data['vista_comprobante'] = $this->load->view('template/formulario_visualizar_archivo', $array_comprobante, TRUE);
                    return $this->load->view('validador_censo/investigacion/comprobante_foro', $data, TRUE);
            }
            return '';
        }
    }

    private function comision_academica_configuracion($tipo_comision, $edicion = true) {
        $config = array('plantilla' => null, 'validacion' => null);
        switch ($tipo_comision) {
            case $this->config->item('tipo_comision')['COMITE_EDUCACION']['id']:
                $config['plantilla'] = ($edicion == true) ? 'perfil_registro/comision_academica/comision_academica_comite_educacion_formulario' : 'perfil_registro/comision_academica/comision_academica_comite_educacion_vista';
                $config['validacion'] = 'form_comision_academica_comite_educacion';
                $entidades_ = array(enum_ecg::ctipo_comprobante, enum_ecg::ctipo_curso);
                break;
            case $this->config->item('tipo_comision')['SINODAL_EXAMEN']['id']:
                $config['plantilla'] = ($edicion == true) ? 'perfil_registro/comision_academica/comision_academica_sinodal_examen_formulario' : 'perfil_registro/comision_academica/comision_academica_sinodal_examen_vista';
                $config['validacion'] = 'form_comision_academica_sinodal_examen';
                $entidades_ = array(enum_ecg::ctipo_comprobante, enum_ecg::cnivel_academico);
                break;
            case $this->config->item('tipo_comision')['COORDINADOR_TUTORES']['id']:
                $config['plantilla'] = ($edicion == true) ? 'perfil_registro/comision_academica/comision_academica_coordinador_tutores_formulario' : 'perfil_registro/comision_academica/comision_academica_coordinador_tutores_vista';
                $config['validacion'] = 'form_comision_academica_coordinador_tutores';
                $entidades_ = array(enum_ecg::ctipo_comprobante, enum_ecg::ccurso, enum_ecg::ctipo_curso);
                break;
            case $this->config->item('tipo_comision')['COORDINADOR_CURSO']['id']:
                //$config['plantilla'] = 'perfil/comision_academica/comision_academica_coordinador_curso_formulario';
                //$config['validacion'] = 'form_comision_academica_coordinador_curso';
                $config['plantilla'] = ($edicion == true) ? 'perfil_registro/comision_academica/comision_academica_coordinador_tutores_formulario' : 'perfil_registro/comision_academica/comision_academica_coordinador_tutores_vista';
                $config['validacion'] = 'form_comision_academica_coordinador_tutores';
                $entidades_ = array(enum_ecg::ctipo_comprobante, enum_ecg::ccurso, enum_ecg::ctipo_curso);
                break;
        }
        $config['catalogos'] = carga_catalogos_generales($entidades_, null, null);
        return $config;
    }

    private function obtener_id_empleado() {
        if (!is_null($this->session->userdata('datosvalidadoactual'))) {
            $array_validado = $this->session->userdata('datosvalidadoactual');
            return (!isset($array_validado['empleado_cve'])) ? $this->session->userdata('idempleado') : intval($array_validado['empleado_cve']);
        }
        return NULL;
    }

    private function obtener_id_validacion() {
        if (!is_null($this->session->userdata('datosvalidadoactual')) && isset($this->session->userdata('datosvalidadoactual')['validacion_cve'])) {
            return $this->session->userdata('datosvalidadoactual')['validacion_cve'];
        }
//        return $this->session->userdata('idempleado');
        return NULL;
    }

    private function obtener_id_usuario() {
        if (!is_null($this->session->userdata('datosvalidadoactual'))) {
            $array_validado = $this->session->userdata('datosvalidadoactual');
            return $array_validado['usuario_cve_validado'];
        }
//        return $this->session->userdata('identificador');
        return NULL;
    }

    private function historico_registro($data) {
        $tipo_id = $data['tipo_id']; //Definido en archivo de configuración general. Arreglo que contiene tablas y campo para la actualización de datos
        $data['tipo'] = $this->seguridad->encrypt_base64($tipo_id);
        return $this->load->view('perfil_registro/validacion_listado', $data, TRUE);
    }

    public function listado_estado_registro($identificador = null, $tipo = null) {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            $this->load->helper('date');
            $this->load->model('Validacion_docente_model', 'vd');
            $data['identificador'] = $identificador;
            $data['string_values'] = array_merge($this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['direccion_tesis'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']);
            $id = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
            $tipo_id = $this->seguridad->decrypt_base64($tipo);
            $tipo_validacion = $this->config->item('TABLAS')[$tipo_id]; ///Obtener tabla y campo donde se almacenará

            $validacion_cve = $this->obtener_id_validacion(); //Se obtiene identificador de la validación de sesión
            $data['registro_validado'] = $this->vd->get_validacion_registro(array('conditions' => array("{$tipo_validacion['campo']}" => $id), 'table' => $tipo_validacion['tabla_validacion'], 'order' => 'VAL_CUR_FCH DESC'));

            echo $this->load->view('validador_censo/validacion_historico_listado', $data, TRUE);
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

}
