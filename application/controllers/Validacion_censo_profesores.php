<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 		: LEAS 
 * fecha: 29/07/2016
 */
class Validacion_censo_profesores extends MY_Controller {

    /**
     * Class Constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('empleados_siap');
        $this->load->library('Ventana_modal');
        $this->load->config('general');
        $this->load->library('form_validation');
        $this->load->library('seguridad');
//        $this->load->library('Ventana_modal');

        $this->load->model('Validacion_docente_model', 'vdm');
        //*****Datos perfil 
        $this->load->model('Catalogos_generales', 'cg');
        $this->load->model('Actividad_docente_model', 'adm');
        $this->load->model('Investigacion_docente_model', 'idm');
        $this->load->model('Becas_comisiones_laborales_model', 'bcl');
        $this->load->model('Material_educativo_model', 'mem');
        $this->load->model('Perfil_model', 'modPerfil');
        $this->load->helper('date');

        //$_SESSION['datosvalidadoactual']['validacion_cve'] = 2;
        //pr($_SESSION);
    }

    /**
     * 
     * @author Leas
     * Fecha creación28072016
     */
    public function index() {
        $this->lang->load('interface', 'spanish');
        $string_values = $this->lang->line('interface')['validador_censo'];
        $data = array();
        $this->delete_datos_validado(); //Elimina los datos de empleado validado, si se encuentran los datos almacenados en la variable de sesión
        $data['string_values'] = $string_values;
        $data['order_columns'] = array('em.EMP_MATRICULA' => 'Matrícula', 'em.EMP_NOMBRE' => 'Nombre', 'em.CATEGORIA_CVE' => 'Categoría');
        //Manda el identificador de la delegación del usuario
        $this->load->model('Designar_validador_model', 'dvm');
        $empleado_cve = $this->session->userdata('idempleado');
        $rol_usuario = $this->session->userdata('rol_seleccionado_cve');
        $datos_validador = $this->vdm->get_validador_empleado_rol($empleado_cve, $rol_usuario); //Busca datos del validador actual
        switch ($rol_usuario) {
            case Enum_rols::Validador_N1:
                $departamento_cve = $datos_validador['DEPARTAMENTO_CVE'];
                $delegacion_cve = (isset($datos_validador['DELEGACION_CVE'])) ? $datos_validador['DELEGACION_CVE'] : ''; //Verifica si existe el rol, de lo contrario pone default cero
                if (!empty($delegacion_cve)) {
                    $convocatoria = $this->cg->get_convocatoria_delegacion($delegacion_cve); //Obtiene la última convocatoría
//                    pr($convocatoria);
                    $datos_validador['VAL_CON_CVE'] = $convocatoria->convocatoria_cve;
                    $datos_validador['ETAPA_CONVOCATORIA'] = $convocatoria->aplica_convocatoria;
//                    pr($datos_validador['VAL_CON_CVE']);
                    $secciones_validacion_obligatoria = $this->vdm->get_secciones_validacion_obligatorias_nivel($rol_usuario, null, $departamento_cve)['sec_info_cve']; //Busca datos del validador actual
                    //Obtiene el historial completo de la validación del docente según la convocatoría
                    $historial_estados_validacion = $this->vdm->get_hist_estados_validacion_docente($this->obtener_id_empleado(), $convocatoria->convocatoria_cve);
                    $data['historial_estados_validacion'] = $historial_estados_validacion;
                    $datos_validador['is_interseccion'] = get_is_interseccion_muestreo($rol_usuario, $historial_estados_validacion);
                } else {
                    $datos_validador['VAL_CON_CVE'] = 0; //*No es necesario filtrar por convocatoria para el tipo de usuario profesionalización***
                    $datos_validador['ETAPA_CONVOCATORIA'] = 0;
                }
                $condiciones = array();
                break;
            case Enum_rols::Validador_N2:
                $delegacion_cve = (isset($datos_validador['DELEGACION_CVE'])) ? $datos_validador['DELEGACION_CVE'] : ''; //Verifica si existe el rol, de lo contrario pone default cero
                if (!empty($delegacion_cve)) {
                    $convocatoria = $this->cg->get_convocatoria_delegacion($delegacion_cve); //Obtiene la última convocatoría
                    $datos_validador['VAL_CON_CVE'] = $convocatoria->convocatoria_cve;
                    $datos_validador['ETAPA_CONVOCATORIA'] = $convocatoria->aplica_convocatoria;
                    $secciones_validacion_obligatoria = $this->vdm->get_secciones_validacion_obligatorias_nivel($rol_usuario, $delegacion_cve)['sec_info_cve']; //Busca datos del validador actual
                    //Obtiene el historial completo de la validación del docente según la convocatoría
                    $historial_estados_validacion = $this->vdm->get_hist_estados_validacion_docente($this->obtener_id_empleado(), $convocatoria->convocatoria_cve);
                    $data['historial_estados_validacion'] = $historial_estados_validacion;
                    $datos_validador['is_interseccion'] = get_is_interseccion_muestreo($rol_usuario, $historial_estados_validacion);
                } else {
                    $datos_validador['VAL_CON_CVE'] = 0; //*No es necesario filtrar por convocatoria para el tipo de usuario profesionalización***
                    $datos_validador['ETAPA_CONVOCATORIA'] = 0;
                }
                $array_catalogos[] = enum_ecg::cdepartamento; //agrega vista de departamento
                $condiciones[enum_ecg::cdepartamento] = array('IS_UNIDAD_VALIDACION' => 1, 'cve_delegacion' => $delegacion_cve);
                break;
            case Enum_rols::Profesionalizacion:
                $datos_validador['VAL_CON_CVE'] = 0; //*No es necesario filtrar por convocatoria para el tipo de usuario profesionalización***
                $datos_validador['ETAPA_CONVOCATORIA'] = 0;
                $datos_validador['DELEGACION_CVE'] = 0;
                $array_catalogos[] = enum_ecg::cdelegacion;
                $array_catalogos[] = enum_ecg::cdepartamento; //agrega vista de departamento
                $condiciones[enum_ecg::cdepartamento] = array('IS_UNIDAD_VALIDACION' => 1);
                $secciones_validacion_obligatoria = array();
                $datos_validador['is_interseccion'] = 0;
                break;
        }

        //Almacena la sección obligatoria por nivel de validación, para validacion por profesionalización no aplica la validación 
        $this->session->set_userdata('seccion_validacion_obligatoria', $secciones_validacion_obligatoria);
        $this->session->set_userdata('datos_validador', $datos_validador);


        $array_catalogos[] = enum_ecg::cvalidacion_estado;
        $data = carga_catalogos_generales($array_catalogos, $data, $condiciones, TRUE, NULL, array(enum_ecg::cvalidacion_estado => 'VAL_ESTADO_CVE')); //Carga el catálogo de ejercicio predominante
        $main_contet = $this->load->view('validador_censo/validador_censo_tpl', $data, true);
        $this->template->multiligual = TRUE;
        $this->template->setCuerpoModal($this->ventana_modal->carga_modal());
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate(FALSE, 'template/sipimss/index.tpl.php');
//        $this->template->getTemplate();
    }

    public function data_buscar_docentes_validar($current_row = null) {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) {
                $this->lang->load('interface', 'spanish');
                $string_values = $this->lang->line('interface')['validador_censo'];
                $filtros = $this->input->post(null, true); //Obtenemos el post o los valores 
//                pr($filtros);
                $datos_validador = $this->session->userdata('datos_validador');
                $filtros += $datos_validador;
                $rol_seleccionado = $this->session->userdata('rol_seleccionado_cve');
                $filtros['rol_seleccionado'] = $rol_seleccionado;
//                pr($filtros);
                $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;
                if ($rol_seleccionado !== Enum_rols::Profesionalizacion) {
                    $filtros['delegacion_cve'] = $this->session->userdata('delegacion_cve');
                }

                $resutlado = $this->vdm->get_buscar_docentes_validar($filtros);
//                pr($resutlado['result']);
                $data['string_values'] = $string_values;
                $data['lista_docentes_validar'] = $resutlado['result'];
                $data['total'] = $resutlado['total'];
                $data['current_row'] = $filtros['current_row'];
                $data['per_page'] = $this->input->post('per_page');

                if (isset($data['lista_docentes_validar']) && !empty($data['lista_docentes_validar'])) {
                    $this->listado_resultado_unidades($data, array('form_recurso' => '#form_busqueda_docentes_validar',
                        'elemento_resultado' => '#div_result_docentes_validacion'
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
        $data['controller'] = 'validacion_docente_model';
        $data['action'] = 'data_buscar_docentes_validar';
        $pagination = $this->template->pagination_data($data); //Crear mensaje y links de paginación
        //$pagination = $this->template->pagination_data_buscador_asignar_validador($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                    <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
        $datos['lista_docentes_validar'] = $data['lista_docentes_validar'];
        $datos['string_values'] = $data['string_values'];
        echo $links . $this->load->view('validador_censo/tabla_resultados_validador', $datos, TRUE) . $links . '
                <script>
                $("ul.pagination li a").click(function(event){
                    data_ajax(this, "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
                    event.preventDefault();
                });
                </script>';
    }

    /*     * **********Fin de buscador de docentes ************************** */

    /*     * **********Inicio de carga perfil empleado validacion *********** */

    /**
     * Elimina los datos o información del usuario u empleado a validar
     */
    private function delete_datos_validado() {
        if (!is_null($this->session->userdata('datosvalidadoactual'))) {
            $this->session->unset_userdata('datosvalidadoactual');
        }
    }

    private function obtener_datos_validador($parametros = null) {
        if (is_null($parametros)) {
            if (!is_null($this->session->userdata('datos_validador'))) {
                return $this->session->userdata('datos_validador');
            }
        }
        return null;
    }

    private function obtener_delegacion_validador($parametros = null) {
        if (is_null($parametros)) {
            if (!is_null($this->session->userdata('datos_validador'))) {
                return $this->session->userdata('datos_validador')['DELEGACION_CVE'];
            }
        }
        return null;
    }

    /**
     * 
     * @return identificador del usuario que se va a validar
     */
    private function obtener_id_usuario() {
        if (!is_null($this->session->userdata('datosvalidadoactual'))) {
            $array_validado = $this->session->userdata('datosvalidadoactual');
            return $array_validado['usuario_cve_validado'];
        }
//        return $this->session->userdata('identificador');
        return NULL;
    }

    private function obtener_nombre_docente() {
        if (isset($this->session->userdata('datosvalidadoactual')['nom_docente'])) {
            return $this->session->userdata('datosvalidadoactual')['nom_docente'];
        }
//        return $this->session->userdata('identificador');
        return NULL;
    }

    /**
     * 
     * @return type Identificador del empleado docente a validar
     */
    private function obtener_id_empleado() {
        if (isset($this->session->userdata('datosvalidadoactual')['empleado_cve'])) {
            return intval($this->session->userdata('datosvalidadoactual')['empleado_cve']);
        }
        return NULL;
    }

    /**
     * 
     * @return type Matricula del empleado docente a validar
     */
    private function obtener_matricula_empleado() {
        if (isset($this->session->userdata('datosvalidadoactual')['matricula'])) {
            return intval($this->session->userdata('datosvalidadoactual')['matricula']);
        }
//        return $this->session->userdata('idempleado');
        return NULL;
    }

    /**
     * 
     * @return Obtiene el identificador de la convocatoria actual de la validación del censo
     */
    private function obtener_convocatoria() {
        if (isset($this->session->userdata('datos_validador')['VAL_CON_CVE'])) {
            return intval($this->session->userdata('datos_validador')['VAL_CON_CVE']);
        }
        return NULL;
    }

    /**
     * 
     * @return Obtiene el estado en el que se encuentra la convocatoria actualmente (última convocatoria aplicada a la delegación)
     *  -sin Sin iniciar la convocatoria
     *  -act Registro de actividad docente (registro de censo)
     *  -vf1 Tiempo de validación por N1
     *  -vf2 Tiempo de validacion por N2
     *  -nap La convocatoría se encuentra caducada
     */
    private function obtener_etapa_convocatoria() {
        if (isset($this->session->userdata('datos_validador')['ETAPA_CONVOCATORIA'])) {
            return $this->session->userdata('datos_validador')['ETAPA_CONVOCATORIA'];
        }
        return NULL;
    }

    /**
     * 
     * @return Obtiene el identificador de la convocatoria actual de la validación del censo
     */
    private function obtener_validacion_gral() {
        if (isset($this->session->userdata('datosvalidadoactual')['val_grl_cve'])) {
            return intval($this->session->userdata('datosvalidadoactual')['val_grl_cve']);
        }
        return NULL;
    }

    /**
     * 
     * @return type Obtiene el rol del usuario actual, es decir N1, N2 o profesionalización
     */
    private function obtener_rol_usuario() {
        if (!is_null($this->session->userdata('rol_seleccionado_cve'))) {
            return $this->session->userdata('rol_seleccionado_cve');
        }
//        return $this->session->userdata('idempleado');
        return NULL;
    }

    /**
     * 
     * @return type Indica se el muestreo del docente se encuentra dentro de una 
     * intersección de validación entre nivel 1 y 2 
     */
    private function obtener_is_interseccion() {
        return $this->session->userdata('is_interseccion');
    }

    private function obtener_id_validacion() {
        if (!is_null($this->session->userdata('datosvalidadoactual')) AND isset($this->session->userdata('datosvalidadoactual')['validacion_cve'])) {
            return $this->session->userdata('datosvalidadoactual')['validacion_cve'];
        }
//        return $this->session->userdata('idempleado');
        return NULL;
    }

    private function obtener_estado_validacion_docente() {
//        pr($this->session->userdata('datosvalidadoactual'));
        if (!is_null($this->session->userdata('datosvalidadoactual')) AND isset($this->session->userdata('datosvalidadoactual')['est_val'])) {
            return $this->session->userdata('datosvalidadoactual')['est_val'];
        }
//        return $this->session->userdata('idempleado');
        return NULL;
    }

    public function seccion_delete_datos_validado() {
        if ($this->input->is_ajax_request()) {
//            if ($this->input->post()) {
//                $datos_post = $this->input->post(null, TRUE);
            $this->delete_datos_validado(); //Elimina los datos de empleado validado, si se encuentran los datos almacenados en la variable de sesión
//            }
        } else {
            redirect(site_url());
        }
    }

    /**
     * 
     */
    public function seccion_index() {
        //echo "SOY UN INDEX....";
        if ($this->input->is_ajax_request()) {
            if (!is_null($this->input->post())) {
                $this->lang->load('interface', 'spanish');
                $datos_post = $this->input->post(null, true); //Obtenemos el post o los valores
//                pr($datos_post);
                $rol_seleccionado = $this->session->userdata('rol_seleccionado'); //Rol seleccionado de la pantalla de roles
//                pr($rol_seleccionado);
                $array_menu = get_busca_hijos($rol_seleccionado, $this->uri->segment(1)); //Busca todos los hijos de validador para que generé el menú y cargue los datos de perfil
                $datosPerfil['array_menu'] = $array_menu;
                $datos_validacion = array();
                $datos_validacion['estado_correccion'] = null;
                //Validación general de la validación actual del docente
                if (!empty($datos_post['valgrlcve'])) {
                    $datos_validacion['val_grl_cve'] = $this->seguridad->decrypt_base64($datos_post['valgrlcve']); //Identificador de la comisión
                }

                if (!empty($datos_post['empcve'])) {
                    $datos_validacion['empleado_cve'] = $this->seguridad->decrypt_base64($datos_post['empcve']); //Identificador de la comisión
                }

                if (!empty($datos_post['matricula'])) {
                    $datos_validacion['matricula'] = $this->seguridad->decrypt_base64($datos_post['matricula']); //Identificador de la comisión
                }
                if (!empty($datos_post['usuariocve'])) {
                    $datos_validacion['usuario_cve_validado'] = $this->seguridad->decrypt_base64($datos_post['usuariocve']); //Identificador de la comisión
                }
                if (!empty($datos_post['convocatoria_cve'])) {
                    $datos_validacion['VAL_CON_CVE'] = $this->seguridad->decrypt_base64($datos_post['convocatoria_cve']); //Identificador de la comisión
                }
                $this->load->model('Usuario_model', 'usu');
                $data_empleado = $this->usu->get_empleado($datos_validacion['matricula'], array('concat(EMP_NOMBRE, " ", EMP_APE_PATERNO, " ", EMP_APE_MATERNO) as "nom_docente"'));
                $datos_validacion['nom_docente'] = $data_empleado['nom_docente'];
//                    $datos_validacion[] = $this->seguridad->decrypt_base64($datos_post['convocatoria_cve']); //Identificador de la comisión

                $id_rol_actual = $this->obtener_rol_usuario();
                $hist_actual_rol = $this->vdm->get_detalle_his_val_actual($datos_validacion['val_grl_cve'], $id_rol_actual);
//                pr($hist_actual_rol);
                if (!empty($hist_actual_rol)) {
                    $hist_actual_rol = $hist_actual_rol[0];
                    $datos_validacion['est_val'] = $hist_actual_rol['estado_validacion']; //Identificador de la comisión
                    $datos_validacion['validacion_cve'] = $hist_actual_rol['hist_validacion_cve']; //Identificador de la comisión
                    $datos_validacion['estado'] = $this->obtener_validacion_correccion($datos_validacion['val_grl_cve'], $datos_validacion['est_val']);
//                    pr($datos_validacion['estado']);
                } else {//Si no existe validacion ni estado de validación, el rol actual no puede validar el rol actual ya que no contiene al docente en el muestreo para validarlo 
                    $datos_validacion['est_val'] = Enum_ev::__default; //Identificador de la comisión
                    $datos_validacion['validacion_cve'] = 0; //Identificador de la comisión
                }
//                pr($hist_actual_rol);    
                //Manda el identificador de la delegación del usuario
                $this->session->set_userdata('datosvalidadoactual', $datos_validacion); //Asigna la información del usuario al que se va a validar
//                pr($datos_validacion);
//                pr($this->session->userdata('datos_validador'));

                echo $this->load->view('validador_censo/index', $datosPerfil, true);
            }
//            pr($this->session->userdata('datosvalidadoactual'));$datos_empleado_validar
        } else {
            redirect(site_url());
        }
    }

    //Erradicar, por Luis LEAS
    private function obtener_validacion_correccion($validacion_gral_cve, $est_val) {
        $resultado = array('correccion' => array('result' => false, 'VALIDACION_CVE' => null), 'fue_validado' => array('result' => false, 'VALIDACION_CVE' => null));
        $estado_anterior_verificar = $this->config->item('estados_val_censo')[$est_val]['estado_anterior_verificar'];
        ///Método que obtiene el histórico de validaciones para 'validacion_gral_cve', importante mantener ordenamiento por fecha, en sesión se añade la fecha más actual
        $historico = $this->vdm->get_validacion_historico(array('conditions' => array('hist_validacion.VALIDACION_GRAL_CVE' => $validacion_gral_cve), 'fields' => 'hist_validacion.*, validacion_gral.*, validador.ROL_CVE', 'order' => 'VAL_FCH'));
//        pr($historico);
        //pr($est_val);
        foreach ($historico as $hist) {
            foreach ($this->config->item('estados_val_censo') as $key_evc => $evc) {
                if ($evc['color_status'] == $this->config->item('CORRECCION') && $hist['VAL_ESTADO_CVE'] == $key_evc) { //Se verifica si existe en el histórico alguna validación en CORRECCIÓN
                    $resultado['correccion']['result'] = true; //Si es así se envian datos para ser almacenados en sesión
                    $resultado['correccion']['VALIDACION_CVE'] = $hist['VALIDACION_CVE'];
                    $resultado['correccion']['VAL_ESTADO_CVE'] = $hist['VAL_ESTADO_CVE'];
                }
            }
            ///Se verifica si se ha validado (IS_ACTUAL=0) por el usuario logueado
            //if ($hist['IS_ACTUAL'] == $this->config->item('IS_NOT_ACTUAL') && $this->session->userdata('datos_validador')['VALIDADOR_CVE'] == $hist['VALIDADOR_CVE'] && $hist['VAL_ESTADO_CVE'] == $estado_anterior_verificar) {
            //if ($hist['IS_ACTUAL'] == $this->config->item('IS_NOT_ACTUAL') && $this->session->userdata('datos_validador')['VALIDADOR_CVE'] == $hist['VALIDADOR_CVE']) {
            $condition = true;
            if (!is_null($est_val) && $this->config->item('estados_val_censo')[$est_val]['color_status'] ==
                    $this->config->item('CORRECCION')) { ///Agregar condición cuando se realice una corrección
                $condition = ($hist['VAL_ESTADO_CVE'] == $estado_anterior_verificar) ? true : false;
            }

            if ($hist['IS_ACTUAL'] == $this->config->item('IS_NOT_ACTUAL') && $this->session->userdata('datos_validador')['ROL_CVE'] == $hist['ROL_CVE'] && $condition === true) {
                $resultado['fue_validado']['result'] = true; //Si es así se envian datos para ser almacenados en sesión
                $resultado['fue_validado']['VALIDACION_CVE'] = $hist['VALIDACION_CVE'];
                //pr($resultado); echo "-------";
            }
        }
        return $resultado;
    }

    public function seccion_validar() {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $tipo_msg = $this->config->item('alert_msg');
            $this->lang->load('interface', 'spanish');
            $string_values = $this->lang->line('interface')['validador_censo'];
            $data['string_values'] = $string_values;

            $convocatoria = $this->obtener_convocatoria(); //Se obtiene la convocatoria actual
            $etapa_convoatoria = $this->obtener_etapa_convocatoria();
            $docente_actual = $this->obtener_id_empleado();


            //Valida que exista una convocatoria, y que se encuentré dentro del tiempo de validación por nivel 1 ó 2
            if (!is_null($convocatoria) AND $convocatoria > 0 AND ( $etapa_convoatoria == Enum_etapa_cov::CENSO_VALIDA_N1 || $etapa_convoatoria == Enum_etapa_cov::CENSO_VALIDA_N2)) {
//            $data_pie['string_values'] = $string_values;
                $rol_validador = $this->obtener_rol_usuario();
                //Reglas para profesionalización
                if ($rol_validador == Enum_rols::Profesionalizacion) {//Si el rol es profesionalización, deberia poder validar en cualquier momento
//                    $valida_tiempo_convocatoria = get_valida_tiempo_convocatoria_rol($rol_validador, $etapa_convoatoria); //Valida que el rol pueda validar en la etapa de la convocatoria actual
//
//                    if ($valida_tiempo_convocatoria == 1) {// 
//                        $data_pie['botones_validador'] = genera_botones_estado_validacion($tmp_validado);
//                    } else {
//                        $br = (isset($data['mensaje_general'])) ? '<br>' : '';
//                        $data['mensaje_general'] .= $br . $string_values['msj_convocatoria_periodo_validacion_fuera'];
//                    }
                } else {//Reglas que aplican para N1 y N2
                    $tmp_validado['validacion_cve'] = $this->obtener_id_validacion();
                    if ($tmp_validado['validacion_cve'] > 0) {//Indica que se encuentra dentro del muestreo para validar
                        $tmp_validado['estado_actual'] = $this->obtener_estado_validacion_docente();
                        $tmp_validado['tipo_validador_rol'] = $this->obtener_rol_usuario();

                        //Mensaje de validacion concluida por nivel actual
                        if ($tmp_validado['estado_actual'] == Enum_ev::Validado_n1 || $tmp_validado['estado_actual'] == Enum_ev::Validado_n2) {//Si se encuentra en el estado de validación Validado, por cualquier rol, debe mostrar el mensaje
                            $data['mensaje_general'] = $string_values['msj_validado_nivel_actual']; //Mensaje para validador de nivel 1 ó 2 informando que la infoemación del docente no puede ser validada en el momento
                            $data['tipo_mensaje'] = $tipo_msg['SUCCESS']['class']; //Mensaje para validador de nivel 1 ó 2 informando que la infoemación del docente no puede ser validada en el momento
                        } else if ($tmp_validado['estado_actual'] == Enum_ev::En_revision_n1 || $tmp_validado['estado_actual'] == Enum_ev::En_revision_n2) {
                            $data['mensaje_general'] = $string_values['msj_revision_nivel_actual']; //Mensaje para validador de nivel 1 ó 2 informando que la infoemación del docente no puede ser validada en el momento
                            $data['tipo_mensaje'] = $tipo_msg['WARNING']['class']; //Mensaje para validador de nivel 1 ó 2 informando que la infoemación del docente no puede ser validada en el momento
                        } else if ($tmp_validado['estado_actual'] == Enum_ev::Por_validar_n1 || $tmp_validado['estado_actual'] == Enum_ev::Por_validar_n2) {
                            $data['mensaje_general'] = $string_values['msj_por_validar_nivel_actual']; //Mensaje para validador de nivel 1 ó 2 informando que la infoemación del docente no puede ser validada en el momento
                            $data['tipo_mensaje'] = $tipo_msg['WARNING']['class']; //Mensaje para validador de nivel 1 ó 2 informando que la infoemación del docente no puede ser validada en el momento
                        }

                        $tmp_validado['delegacion_cve'] = $this->obtener_delegacion_validador();
                        //Obtiene el historial completo de la validación del docente según la convocatoría
                        $historial_estados_validacion = $this->vdm->get_hist_estados_validacion_docente($this->obtener_id_empleado(), $convocatoria);
                        $data['historial_estados_validacion'] = $historial_estados_validacion;

//                        if ($this->obtener_is_interseccion() == 1) {//Es una intersección valida tiempo linel de validacion según el rol 

                        $valida_tiempo_convocatoria = get_valida_tiempo_convocatoria_rol($rol_validador, $etapa_convoatoria, $this->obtener_is_interseccion()); //Valida que el rol pueda validar en la etapa de la convocatoria actual

                        if ($valida_tiempo_convocatoria == 1) {// 
                            $data_pie['botones_validador'] = genera_botones_estado_validacion($tmp_validado);
                        } else {
                            $br = (isset($data['mensaje_general'])) ? '<br>' : '';
                            $data['mensaje_general'] .= $br . $string_values['msj_convocatoria_periodo_validacion_fuera'];
                        }
//                        } else {//No es una interseccion
//                            $data_pie['botones_validador'] = genera_botones_estado_validacion($tmp_validado);
//                        }
                        if (!empty($data_pie['botones_validador'])) {
                            $pie_pag = $this->load->view('validador_censo/valida_docente/opciones_validacion_pie', $data_pie, TRUE);
                            $data['pie_pag'] = $pie_pag;
                        }
                    } else {
                        $data['msj_convocatoria_inactiva'] = $string_values['msj_no_muestra_para_validador_actual']; //Mensaje para validador de nivel 1 ó 2 informando que la infoemación del docente no puede ser validada en el momento
                    }
                }
            } else {
                if ($etapa_convoatoria == Enum_etapa_cov::CENSO_REGISTRO) {
                    $data['mensaje_general'] = $string_values['msj_convocatoria_registro_censo']; //Mensaje para validador de nivel 1 ó 2 informando que la infoemación del docente no puede ser validada en el momento
                } else {
                    $data['mensaje_general'] = $string_values['msj_convocatoria_registro_censo']; //Mensaje para validador de nivel 1 ó 2 informando que la infoemación del docente no puede ser validada en el momento
                }
            }

            $data['nom_docente'] = $this->obtener_nombre_docente(); //Nombre del docente
            $data['matricula'] = $this->obtener_matricula_empleado(); //Matricula del docente a validar
            //Obtiene el historial de las últimas dos convocatorias
            $data['historial_estados'] = $this->vdm->get_hist_estados_validacion_docente_convocatorias($docente_actual, 2);
//                pr($data_comentario['historial_estados']);
            $this->load->view('validador_censo/valida_docente/valida_docente_tpl', $data, FALSE);
        } else {
            redirect(site_url());
        }
    }

    public function ver_comentario_estado() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                $datos_post = $this->input->post(null, true); //Obtenemos el post o los valores
//                pr($datos_post);
                $this->lang->load('interface', 'spanish');
                $string_values = $this->lang->line('interface')['validador_censo'];
                $data_comentario['string_values'] = $string_values;
                $convocatoria_cve = intval($this->seguridad->decrypt_base64($datos_post['convocatoria_cve'])); //Des encripta la clave de la historia que viene de post
                $empleado_cve = intval($this->seguridad->decrypt_base64($datos_post['empleado_cve'])); //Des encripta la clave de la historia que viene de post
//                $resul_coment = $this->vdm->get_comentario_hist_validaso($hist_val_cve); //Consulta datos del historico
                $data_comentario['historial_estados'] = $this->vdm->get_hist_estados_validacion_docente($empleado_cve, $convocatoria_cve);
                $data = array(
                    'titulo_modal' => $string_values['titulo_modal_comentario'],
                    'cuerpo_modal' => $this->load->view('validador_censo/valida_docente/comentario_estado', $data_comentario, TRUE),
                    'pie_modal' => $this->load->view('validador_censo/valida_docente/pie_cerrar_modal_pie', NULL, TRUE),
                );
                echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
            }
        } else {
            redirect(site_url());
        }
    }

    public function ver_detalle_validado() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                $datos_post = $this->input->post(null, true); //Obtenemos el post o los valores
//                pr($datos_post);    
                $this->lang->load('interface', 'spanish');
                $string_values = $this->lang->line('interface')['validador_censo'];
                $data_comentario['string_values'] = $string_values;
                $validacion_gral_cve = intval($this->seguridad->decrypt_base64($datos_post['val_gral'])); //Des encripta la clave de la historia que viene de post
                $empleado_cve = intval($this->seguridad->decrypt_base64($datos_post['docente'])); //Des encripta la clave de la historia que viene de post
                //Obtiene la información de validación actual del docente (validación por n1, n2 y profesionalización simultania)
                $data_comentario['validaciones_grales'] = $this->vdm->get_detalle_his_val_actual($validacion_gral_cve);
                $data_comentario['nom_docente'] = '';
                $data_comentario['matricula'] = '';

                $this->load->model('Usuario_model', 'usu');
                $data_empleado = $this->usu->get_empleado(array('EMPLEADO_CVE' => $empleado_cve), array('concat(EMP_NOMBRE, " ", EMP_APE_PATERNO, " ", EMP_APE_MATERNO) as "nom_docente"', 'emp_matricula "matricula"'));
//                
                if (!empty($data_empleado)) {//Si es diferente de vacio, se obtiene el nombre del docente
                    $data_comentario['nom_docente'] = $data_empleado['nom_docente']; //Nombre del empleado docente
                    $data_comentario['matricula'] = $data_empleado['matricula']; //Matricula del empleado docente
                }

//                pr($data_comentario['validaciones_grales']);
                //Obtiene el historial de las últimas dos convocatorias
                $data_comentario['historial_estados'] = $this->vdm->get_hist_estados_validacion_docente_convocatorias($empleado_cve, 2);
//                pr($data_comentario['historial_estados']);
//                exit();
                $data = array(
                    'titulo_modal' => $string_values['titulo_modal_comentario'],
                    'cuerpo_modal' => $this->load->view('validador_censo/valida_docente/comentario_estado', $data_comentario, TRUE),
                    'pie_modal' => $this->load->view('validador_censo/valida_docente/pie_cerrar_modal_pie', NULL, TRUE),
                );
                echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
            }
        } else {
            redirect(site_url());
        }
    }

    /**
     * @author LEAS
     * @fecha 05/09/2016
     * @fechaMod 21/09/2016
     * @param type $validacion_id
     * @param type $tabla_validacion
     * @param type $validacion_registro
     * Función que 
     * cambia de estado Por validar n1 a en revisión n1;
     * cambia de estado Por validar n2 a en revisión n2;
     * cambia de estado correccion n1 a en revisión de corrección n1
     * cambia de estado correccion n2 a en revisión de corrección n2
     * según el validador que se encuentrá haciendo la revisión
     * @return int 1 = cambio a revisión satisfactoriamente; 0= fallo en la transición  
     */
    private function cambiar_estado_revision_validador($validacion_id, $tabla_validacion, $validacion_registro) {
        $datos_validador = $this->session->userdata('datos_validador');
        $datos_empleado_validar = $this->session->userdata('datosvalidadoactual');
        $array_estados = $this->config->item('estados_val_censo');
        $conf_estado_actual_empleado = $array_estados[$datos_empleado_validar['est_val']];
        if (intval($conf_estado_actual_empleado['rol_permite'][0]) === intval($datos_validador['ROL_CVE'])) {//Verifica que el rol actual pueda modificar el estado del docente 
            $estado_transicion = $conf_estado_actual_empleado['estados_transicion'];
            foreach ($estado_transicion as $val_est_trans) {
                if ($val_est_trans === Enum_ev::En_revision_n1 || $val_est_trans === Enum_ev::En_revision_n2 || $val_est_trans === Enum_ev::En_revision_profesionalizacion) {
                    $string_values = $this->lang->line('interface')['validador_censo'];
                    $comentario = $string_values['text_estado_revision'];
                    $result = $this->cambio_estado_validacion_censo($val_est_trans, $comentario, $datos_validador['VALIDADOR_CVE'], $datos_empleado_validar, $validacion_id, $tabla_validacion, $validacion_registro);
                    return $result;
                }
            }
            return 0;
        }
        return 0;
    }

    /**
     * @author  LEAS
     * @fecha 03/09/2016
     * @param type $estado_cambio_cve
     * @param type $comentario_justificacion
     * @param type $validador_cve
     * @param type $datos_empleado_validar
     * @return int
     */
    private function cambio_estado_validacion_censo($estado_cambio_cve, $comentario_justificacion = '', $validador_cve, $datos_empleado_validar, $validacion_id = null, $tabla_validacion = null, $validacion_registro = null) {
        $secciones_validar_obligatorias = $this->session->userdata('seccion_validacion_obligatoria');

        $parametros_insert_hist_val = array();
        $parametros_insert_hist_val['VAL_ESTADO_CVE'] = $estado_cambio_cve;
        $parametros_insert_hist_val['VALIDADOR_CVE'] = $validador_cve;
        $parametros_insert_hist_val['VAL_COMENTARIO'] = $comentario_justificacion;
        $parametros_insert_hist_val['VALIDACION_GRAL_CVE'] = $datos_empleado_validar['val_grl_cve'];
        $parametros_insert_hist_val['IS_ACTUAL'] = 1;
        $cve_hist_actual['VALIDACION_CVE'] = $datos_empleado_validar['validacion_cve'];
        $parametro_hist_actual_mod['IS_ACTUAL'] = 0;

        $pasa_validacion = 1;
        $estado_actual = $this->session->userdata('datosvalidadoactual')['est_val'];
        $prop_estado = $this->config->item('estados_val_censo')[$estado_actual];

        $empleado = $datos_empleado_validar['empleado_cve'];

//        pr($secciones_validar_obligatorias  );
//        exit();
        //Hace la validación del estado actual para solicitar que se pueda validar (estados en de los cuales se puede enviar a validar)
        if (isset($prop_estado['est_apr_para_validacion']) and false) {//importante quitar el false, para que valides
            if ($estado_cambio_cve == Enum_ev::Validado_n1 || $estado_cambio_cve == Enum_ev::Validado_n2) {
                $this->load->model('Expediente_model', 'exp'); //Modelo clase que contiene todos los datos de las secciones
                $secciones_cursos_validar = $this->exp->get_seccionConfig($secciones_validar_obligatorias); //Configuración de secciones de las actividades del docente 
                //Validación 
                $estados_considerados_validacion = $prop_estado['est_apr_para_validacion'];
                $this->load->model('Validacion_docente_model', 'vdm');

                //Consulta que los requerimientos de vlidación minimos se cumplan, para poder validar
                $pasa_validacion = $this->vdm->get_is_envio_validacion($empleado, $estados_considerados_validacion, $parametros_insert_hist_val['VALIDACION_GRAL_CVE'], $this->obtener_rol_usuario(), $secciones_cursos_validar);
//                pr($secciones_cursos_validar);
                exit();
            } else {//corrección
            }
        }
        if ($pasa_validacion) {//Pasa el filtro de validación
//            $updates = null;
//            if ($estado_cambio_cve == Enum_ev::Validado) {//Es la validacion por profecionalización, por lo que hay que cambiar el estado de todos los registros validados
//                $updates = $this->vdm->get_querys_updates_estado_validados_profesionalizacion($datos_empleado_validar['empleado_cve']);
//            }
            //Efectúa la actualización del nuevo estado
            $result_cam_estado = $this->vdm->update_insert_estado_val_docente($parametros_insert_hist_val, $parametro_hist_actual_mod, $cve_hist_actual, $empleado);
//            pr($result_cam_estado);
            if (!empty($result_cam_estado)) {
                $this->actualizar_estado_validar_a_revision($validacion_id, $tabla_validacion, $validacion_registro, $result_cam_estado['VALIDACION_CVE']);

                $parametro_hist_actual_mod['VALIDACION_CVE'] = $cve_hist_actual['VALIDACION_CVE'];
                //Cambio datos variable sesión "datosvalidadoactual" por los nuevos valores
                $datos_empleado_validar['validador_cve'] = $result_cam_estado['VALIDADOR_CVE']; //Asigna el id del validador actual
                $datos_empleado_validar['validacion_cve'] = $result_cam_estado['VALIDACION_CVE']; //Asigna nuevo id de la validacion historia
                $datos_empleado_validar['est_val'] = $result_cam_estado['VAL_ESTADO_CVE']; //Asigna nuevo estado
                $datos_empleado_validar['estado'] = $this->obtener_validacion_correccion($datos_empleado_validar['val_grl_cve'], $datos_empleado_validar['est_val']);
                $this->session->set_userdata('datosvalidadoactual', $datos_empleado_validar); //Asigna datos nuevos datos del validado a la variable de sesión 
                //Registra la bitacora
                //Actualización 
                $array_datos_entidad['hist_validacion'] = $parametro_hist_actual_mod; //Pertenece a bitacora
                $array_operacion_id_entidades['hist_validacion'] = array('update' => $parametro_hist_actual_mod['VALIDACION_CVE']); //Pertenece a bitacora 
                //Insersion nueva
                $array_datos_entidad['hist_validacion'] = $result_cam_estado; //Pertenece a bitacora
                $array_operacion_id_entidades['hist_validacion'] = array('insert' => $result_cam_estado['VALIDACION_CVE']); //Pertenece a bitacora 
                $json_datos_entidad = json_encode($array_operacion_id_entidades); //Codifica a json datos de entidad
                $json_registro_bitacora = json_encode($array_datos_entidad); //Codifica a json la actualización o insersión a las entidades involucradas
                //Datos de bitacora el registro del usuario
                registro_bitacora($this->session->userdata('identificador'), null, $json_datos_entidad, null, $json_registro_bitacora, null);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function enviar_cambio_estado_validacion() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                $datos_post = $this->input->post(null, true); //Obtenemos el post o los valores
                $this->lang->load('interface', 'spanish');
                $string_values = $this->lang->line('interface')['validador_censo'];

                $estado_cambio_cve = $this->seguridad->decrypt_base64($datos_post['estado_cambio_cve']); //Identifica si es un tipo de validar, enviar a correccion o en revisión el estado
                $estado_a_validar = $this->config->item('estados_val_censo')[$estado_cambio_cve]['color_status']; //Verifica que tipo de estado es, para activar validacion de comentario obligatorio (caso de corrección)

                $validation = array();
                $pasa_validacion = TRUE; //Si no requiere validación, está variable abre la puerta que no verifique validación

                if ($pasa_validacion) {
                    $tipo_msg = $this->config->item('alert_msg');
                    $datos_validador = $this->session->userdata('datos_validador');
                    $datos_empleado_validar = $this->session->userdata('datosvalidadoactual');
                    $result_cambio = $this->cambio_estado_validacion_censo($estado_cambio_cve, $datos_post['comentario_justificacion'], $datos_validador['VALIDADOR_CVE'], $datos_empleado_validar);

                    //Efectúa la actualización del nuevo estado
                    if ($result_cambio === 1) {
                        $buscar_mensaje = ($estado_a_validar === 'VALIDO') ? 'save_estado_cambio_envio' : 'save_estado_cambio_correccion';
                        $data['error'] = $string_values[$buscar_mensaje]; //
                        $data['tipo_msg'] = $tipo_msg['SUCCESS']['class']; //Tipo de mensaje de error
                        $data['result'] = 1; //Error resultado success
                    } else {
                        $data['error'] = $string_values['save_estado_error']; //
                        $data['tipo_msg'] = $tipo_msg['DANGER']['class']; //Tipo de mensaje de error
                        $data['result'] = 0; //Error resultado success
                    }
                    echo json_encode($data);
                    exit();
                }

                $data['string_values'] = $string_values;

                $tmp_validado['estado_actual'] = $this->obtener_estado_validacion_docente();
                $tmp_validado['tipo_validador_rol'] = $this->obtener_rol_usuario();
                $tmp_validado['delegacion_cve'] = $this->obtener_delegacion_validador();
                $data_pie['botones_validador'] = genera_botones_estado_validacion($tmp_validado);

                $pie_pag = $this->load->view('validador_censo/valida_docente/opciones_validacion_pie', $data_pie, TRUE);
                $data['pie_pag'] = $pie_pag;
                $this->load->view('validador_censo/valida_docente/valida_docente_tpl', $data, FALSE);
            }
        } else {
            redirect(site_url());
        }
    }

    /**
     * @Author: Mr. Guag
     * @params: void
     * @return: void 
     * @description: This function shows & allows to the users/profesors manage their information
     */
    public function seccion_info_general() {
        $data = array();
        $this->lang->load('interface', 'spanish');
        $string_values = $this->lang->line('interface')['perfil'];
        $id_usuario = $this->obtener_id_usuario();

        /* Esto es de información general */
        if ($this->input->post()) {
            $this->config->load('form_validation'); //Cargar archivo con validaciones
            $validations = $this->config->item('informacion_general'); //Obtener validaciones de archivo general
            $this->form_validation->set_rules($validations); //Añadir validaciones
            if ($this->form_validation->run()) {
                //pr("Validating-data, Saving-data");
                //pr($this->input->post());
                $this->load->model("Registro_model", "reg");
                $empData = $this->input->post();
                foreach ($empData as $key => $field) {
                    if (empty($field)) {
                        unset($empData[$key]);
                    }
                }
                $id = $empData["EMPLEADO_CVE"];
                unset($empData["EMPLEADO_CVE"]);

                //pr($empData);
                //echo $this->reg->update_registro_empleado($empData,$id);
                if ($this->reg->update_registro_empleado($empData, $id) == 1) {
                    $response['message'] = $string_values['save_informacion_personal'];
                    $response['result'] = "true";
                } else {
                    $response['message'] = $string_values['error_informacion_personal'];
                    $response['result'] = false;
                }
                $response["content"] = $this->_load_general_info_form(TRUE);
                echo json_encode($response);
                return 0;
            }
        }
        $this->_load_general_info_form();
    }

    /**
     * @Author: Mr. Guag
     * @param void
     * @return array 
     * @description: This function create & return a form within the general information of the profesor
     */
    function _load_general_info_form($type = FALSE) {
        //$data = array();
        $this->lang->load('interface', 'spanish');
        $string_values = $this->lang->line('interface')['perfil'];
        $id_usuario = $this->obtener_id_usuario();
        //pr("Just showing a preview");
        $datosPerfil = $this->loadInfo($id_usuario);

        $this->load->library("curp");
        $this->curp->setCURP($datosPerfil["curp"]);
        //solo se manda el combo de sexo cuando es el usuario admin
        $datosPerfil['genero'] = $this->curp->getGenero();
        $datosPerfil['edad'] = $this->curp->getEdad();
        $datosPerfil['estadosCiviles'] = dropdown_options($this->modPerfil->getEstadoCivil(), 'CESTADO_CIVIL_CVE', 'EDO_CIV_NOMBRE');
        $datosPerfil['formacionProfesionalOptions'] = array();
        $datosPerfil['tipoComprobanteOptions'] = array();
        $datosPerfil['antiguedad'] = explode('_', $datosPerfil['antiguedad']);
        if ($type) {
            return $this->load->view('validador_censo/informacionGeneral', $datosPerfil, $type);
        }

        $this->load->view('validador_censo/informacionGeneral', $datosPerfil, $type); //Valores que muestrán la lista  
    }

    /**
     * 
     * @param mixed $parameters
     */
    private function loadInfo($identificador) {
        $empleadoData = $this->modPerfil->getEmpleadoData($identificador);
        $datosPerfil = array();
        if (count($empleadoData)) {
            foreach ($empleadoData['0'] as $key => $value) {
                $datosPerfil[$key] = $value;
            }
        }
        return $datosPerfil;
    }

    ////////////////////////Inicio comisiones academicas
    public function seccion_comision_academica() {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Comision_academica_model', 'ca');
            $data = array();

            $this->lang->load('interface');
            $validacion_cve_session = $this->obtener_id_validacion();
            $data['string_values'] = array_merge($this->lang->line('interface')['comision_academica'], $this->lang->line('interface')['general']);

            $condiciones_ = array(enum_ecg::ctipo_comision => array('TIP_COMISION_CVE !=' => $this->config->item('tipo_comision')['DIRECCION_TESIS']['id'], 'IS_COMISION_ACADEMICA' => 1));
            $entidades_ = array(enum_ecg::ctipo_comision);
            $data['catalogos'] = carga_catalogos_generales($entidades_, null, $condiciones_);
            $data['columns'] = array($this->config->item('tipo_comision')['COMITE_EDUCACION']['id'] => array('EC_ANIO' => $data['string_values']['t_h_anio'], 'TIP_CUR_NOMBRE' => $data['string_values']['t_h_tipo']),
                $this->config->item('tipo_comision')['SINODAL_EXAMEN']['id'] => array('EC_ANIO' => $data['string_values']['t_h_anio_'], 'NIV_ACA_NOMBRE' => $data['string_values']['t_h_nivel_academico']),
                $this->config->item('tipo_comision')['COORDINADOR_TUTORES']['id'] => array('EC_ANIO' => $data['string_values']['t_h_anio_'], 'TIP_CUR_NOMBRE' => $data['string_values']['t_h_tipo'], 'EC_FCH_INICIO' => $data['string_values']['t_h_fch_inicio'], 'EC_FCH_FIN' => $data['string_values']['t_h_fch_fin'], 'EC_DURACION' => $data['string_values']['t_h_duracion']),
                $this->config->item('tipo_comision')['COORDINADOR_CURSO']['id'] => array('EC_ANIO' => $data['string_values']['t_h_anio_'], 'TIP_CUR_NOMBRE' => $data['string_values']['t_h_tipo'], 'EC_FCH_INICIO' => $data['string_values']['t_h_fch_inicio'], 'EC_FCH_FIN' => $data['string_values']['t_h_fch_fin'], 'EC_DURACION' => $data['string_values']['t_h_duracion']));

            $data['comisiones'] = array();
            foreach ($data['catalogos']['ctipo_comision'] as $ctc => $tc) {
                ////////Inicio agregar validaciones de estado
                $estado_validacion_actual = $this->session->userdata('datosvalidadoactual')['est_val']; //Estado actual de la validación
                
                $val_estado_comisiones = array('validation_estado' => array(
                    'table' => 'hist_comision_validacion_curso', 
                    'fields' => 'VAL_CUR_EST_CVE', 
                    'conditions' => 'hist_comision_validacion_curso.EMP_COMISION_CVE=emp_comision.EMP_COMISION_CVE ', 
                    'order' => 'VAL_CUR_FCH DESC', 
                    'limit' => '1'));
                /////////Fin agregar validaciones de estado
                $data['comisiones'][$ctc] = $this->ca->get_comision_academica(
                        array_merge(array('conditions' => array('emp_comision.EMPLEADO_CVE' => $this->obtener_id_empleado(), 
                    'emp_comision.TIP_COMISION_CVE' => $ctc), 
                    'order' => 'EC_ANIO desc', 
                    'fields' => 'emp_comision.*, NIV_ACA_NOMBRE, COM_ARE_NOMBRE, TIP_CUR_NOMBRE', 
                    ),
                  $val_estado_comisiones));
            }
//            $tc_cve = array();
//            foreach ($data['catalogos']['ctipo_comision'] as $ctc => $tc) {
//                $tc_cve[] = $ctc;
//            }
//            ////////Inicio agregar validaciones de estado
//            $estado_validacion_actual = $this->session->userdata('datosvalidadoactual')['est_val']; //Estado actual de la validación
//
//            $val_estado_comisiones = array('validation_estado' => array(
//                    'table' => 'hist_comision_validacion_curso',
//                    'fields' => 'VAL_CUR_EST_CVE',
//                    'conditions' => 'hist_comision_validacion_curso.EMP_COMISION_CVE=emp_comision.EMP_COMISION_CVE ',
//                    'order' => 'VAL_CUR_FCH DESC',
//                    'limit' => '1'));
//            /////////Fin agregar validaciones de estado
//            $data['comisiones'][$ctc] = $this->ca->get_comision_academica(
//                    array_merge(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado()),
//                'order' => 'EC_ANIO desc',
//                'fields' => 'emp_comision.*, NIV_ACA_NOMBRE, COM_ARE_NOMBRE, TIP_CUR_NOMBRE',
//                'conditions_in' => array('emp_comision.TIP_COMISION_CVE' => $tc_cve)), $val_estado_comisiones));
//            //pr($data);
            $data['is_interseccion'] = $this->obtener_is_interseccion(); //Agrega si es intersección en muestreo de docentes entré validador de nivel 1 y 2 
            echo $this->load->view('validador_censo/comision_academica/comision_academica.php', $data, true); //Valores que muestrán la lista
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function curso_actividad_docente() {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            if ($this->input->post()) {
                $datos_post = $datos_formulario = $this->input->post(null, true);
//                pr($datos_post);
                if (!empty($datos_post['ctipo_curso_cve'])) {
                    $id_pos = intval($datos_post['ctipo_curso_cve']);
                    echo $this->vista_ccurso($id_pos);
                }
            }
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    private function vista_ccurso($id_tipo_curso, $ccurso_cve = '') {
        $entidades_ = array(enum_ecg::ccurso);
        $condiciones_ = array(enum_ecg::ccurso => array('TIP_CURSO_CVE' => $id_tipo_curso));
        $data['catalogos'] = carga_catalogos_generales($entidades_, null, $condiciones_);
        $data['string_values'] = $this->lang->line('interface')['actividad_docente'];
        if (!empty($ccurso_cve)) {
            $data['CUR_NOMBRE'] = $ccurso_cve;
        }
        return $this->load->view('validador_censo/actividad_docente/vista_curso', $data, TRUE);
    }

    private function comision_academica_configuracion($tipo_comision, $edicion = true) {
        $config = array('plantilla' => null, 'validacion' => null);
        switch ($tipo_comision) {
            case $this->config->item('tipo_comision')['COMITE_EDUCACION']['id']:
                $config['plantilla'] = ($edicion == true) ? 'validador_censo/comision_academica/comision_academica_comite_educacion_formulario' : 'validador_censo/comision_academica/comision_academica_comite_educacion_vista';
                $config['validacion'] = 'form_comision_academica_comite_educacion';
                $entidades_ = array(enum_ecg::ctipo_comprobante, enum_ecg::ctipo_curso);
                break;
            case $this->config->item('tipo_comision')['SINODAL_EXAMEN']['id']:
                $config['plantilla'] = ($edicion == true) ? 'validador_censo/comision_academica/comision_academica_sinodal_examen_formulario' : 'validador_censo/comision_academica/comision_academica_sinodal_examen_vista';
                $config['validacion'] = 'form_comision_academica_sinodal_examen';
                $entidades_ = array(enum_ecg::ctipo_comprobante, enum_ecg::cnivel_academico);
                break;
            case $this->config->item('tipo_comision')['COORDINADOR_TUTORES']['id']:
                $config['plantilla'] = ($edicion == true) ? 'validador_censo/comision_academica/comision_academica_coordinador_tutores_formulario' : 'validador_censo/comision_academica/comision_academica_coordinador_tutores_vista';
                $config['validacion'] = 'form_comision_academica_coordinador_tutores';
                $entidades_ = array(enum_ecg::ctipo_comprobante, enum_ecg::ccurso, enum_ecg::ctipo_curso);
                break;
            case $this->config->item('tipo_comision')['COORDINADOR_CURSO']['id']:
                //$config['plantilla'] = 'perfil/comision_academica/comision_academica_coordinador_curso_formulario';
                //$config['validacion'] = 'form_comision_academica_coordinador_curso';
                $config['plantilla'] = ($edicion == true) ? 'validador_censo/comision_academica/comision_academica_coordinador_tutores_formulario' : 'validador_censo/comision_academica/comision_academica_coordinador_tutores_vista';
                $config['validacion'] = 'form_comision_academica_coordinador_tutores';
                $entidades_ = array(enum_ecg::ctipo_comprobante, enum_ecg::ccurso, enum_ecg::ctipo_curso);
                break;
        }
        $config['catalogos'] = carga_catalogos_generales($entidades_, null, null);
        return $config;
    }

    /////////////////////////Fin comisiones academicas
    ////////////////////////Inicio Dirección de tesis ////////////////////////
    public function seccion_direccion_tesis() {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            $this->lang->load('interface');
            $data['string_values'] = array_merge($this->lang->line('interface')['direccion_tesis'], $this->lang->line('interface')['general']);
            $validacion_cve_session = $this->obtener_id_validacion();

            $this->load->model('Direccion_tesis_model', 'dt');
            $data['lista_direccion'] = $this->dt->get_lista_datos_direccion_tesis(array_merge(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado(), 'TIP_COMISION_CVE' => $this->config->item('tipo_comision')['DIRECCION_TESIS']['id']), 'fields' => 'emp_comision.*, NIV_ACA_NOMBRE, COM_ARE_NOMBRE', 'order' => 'EC_ANIO desc', 'validation_estado' => array('table' => 'hist_comision_validacion_curso', 'fields' => 'VAL_CUR_EST_CVE', 'conditions' => 'hist_comision_validacion_curso.EMP_COMISION_CVE=emp_comision.EMP_COMISION_CVE', 'order' => 'VAL_CUR_FCH desc', 'limit' => 1))));
            //pr($data);
            $data['is_interseccion'] = $this->obtener_is_interseccion(); //Agrega si es intersección en muestreo de docentes entré validador de nivel 1 y 2 
            echo $this->load->view('validador_censo/direccionTesis', $data, true); //Valores que muestrán la lista
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    /**
     * Función que elimina un archivo
     * @method: void eliminar_archivo()
     * @param: $data['archivo']   string     Nombre del archivo
     * @param: $data['matricula']   string      Matrícula del empleado
     * @author: Jesús Z. Díaz P.
     */
    private function eliminar_archivo($data) {
        $resultado = false;
        //pr($data);
        if (isset($data['archivo']) && !empty($data['archivo'])) { //Eliminar archivo
            $ruta = $this->config->item('upload_config')['comprobantes']['upload_path']; //Path de archivos
            //pr($ruta);
            $ruta_archivo = $ruta . $data['archivo']; ///Definir ruta de almacenamiento, se utiliza la matricula
            //pr($ruta_archivo);
            if (file_exists($ruta_archivo)) {
                unlink($ruta_archivo);
                $resultado = true;
            }
        }
        return $resultado;
    }

    /////////////////////////Inicio formación //////////////////////////
    public function seccion_formacion() {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Formacion_model', 'fm');
            $this->load->helper('date');
            $data = array();
            $this->lang->load('interface');
            $data['string_values'] = array_merge($this->lang->line('interface')['perfil'], $this->lang->line('interface')['formacion_salud'], $this->lang->line('interface')['formacion_docente'], $this->lang->line('interface')['general']);
            $validacion_cve_session = $this->obtener_id_validacion();

            $entidades_ = array(enum_ecg::ctipo_formacion_profesional, enum_ecg::csubtipo_formacion_profesional);
            $data['catalogos'] = carga_catalogos_generales($entidades_, null, null);

            ///Obtener dato de ejercicio profesional, para mostrar datos de formación en salud
            $data['ejercicio_profesional'] = $this->fm->get_ejercicio_profesional(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado()), 'fields' => 'emp_eje_pro_cve, EJE_PRO_NOMBRE'))[0];
            //pr($this->session->userdata('datos_validador'));
            //pr($this->session->userdata('datosvalidadoactual'));
            ////////Inicio agregar validaciones de estado

            $val_correc_for_sal = $val_correc_for_doc = $validation_est_corr_for_sal = $validation_est_corr_for_doc = array();
            if (!empty($data['ejercicio_profesional']['emp_eje_pro_cve'])) { //En caso de que exista valor en ejercicio profesional
                $data['formacion_salud']['inicial'] = $this->fm->get_formacion_salud(array_merge(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado(), 'EFPCS_FOR_INICIAL' => 1), 'order' => 'EFPCS_FCH_INICIO desc', 'fields' => 'emp_for_personal_continua_salud.*, ctipo_formacion_salud.TIP_FORM_SALUD_NOMBRE, csubtipo_formacion_salud.SUBTIP_NOMBRE')));
                $data['formacion_salud']['continua'] = $this->fm->get_formacion_salud(array_merge(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado(), 'EFPCS_FOR_INICIAL' => 2), 'order' => 'EFPCS_FCH_INICIO desc', 'fields' => 'emp_for_personal_continua_salud.*, ctipo_formacion_salud.TIP_FORM_SALUD_NOMBRE, csubtipo_formacion_salud.SUBTIP_NOMBRE')));
            } else {
                $data['formacion_salud']['inicial'] = array();
                $data['formacion_salud']['continua'] = array();
            }
            //pr($data);
            //$formacion_docente = $this->fm->get_formacion_docente(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado()), 'order' => 'EFO_ANIO_CURSO', 'fields' => 'emp_formacion_profesional.*, cinstitucion_avala.IA_NOMBRE, ctipo_formacion_profesional.TIP_FOR_PRO_NOMBRE, csubtipo_formacion_profesional.SUB_FOR_PRO_NOMBRE, cmodalidad.MOD_NOMBRE, ccurso.CUR_NOMBRE', 'validation'=>array(array('table'=>'hist_efp_validacion_curso', 'fields'=>'COUNT(*) AS validation', 'conditions'=>'hist_efp_validacion_curso.EMP_FORMACION_PROFESIONAL_CVE=emp_formacion_profesional.EMP_FORMACION_PROFESIONAL_CVE AND VALIDACION_CVE='.$validacion_cve_session), array('table'=>'hist_efp_validacion_curso', 'fields'=>'VAL_CUR_EST_CVE', 'conditions'=>'hist_efp_validacion_curso.EMP_FORMACION_PROFESIONAL_CVE=emp_formacion_profesional.EMP_FORMACION_PROFESIONAL_CVE AND VALIDACION_CVE='.$validacion_cve_session)))); // ctipo_curso.TIP_CUR_NOMBRE, 
            $formacion_docente = $this->fm->get_formacion_docente(array_merge(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado()), 'order' => 'EFO_ANIO_CURSO', 'fields' => 'emp_formacion_profesional.*, cinstitucion_avala.IA_NOMBRE, ctipo_formacion_profesional.TIP_FOR_PRO_NOMBRE, csubtipo_formacion_profesional.SUB_FOR_PRO_NOMBRE, cmodalidad.MOD_NOMBRE, ccurso.CUR_NOMBRE'))); // ctipo_curso.TIP_CUR_NOMBRE, 
            foreach ($formacion_docente as $fd) { ///Ordenar de acuerdo a tipo
                $fd['SUB_FOR_PRO_CVE'] = (!isset($fd['SUB_FOR_PRO_CVE']) || is_null($fd['SUB_FOR_PRO_CVE'])) ? 0 : $fd['SUB_FOR_PRO_CVE'];
                $data['formacion_docente'][$fd['TIP_FOR_PROF_CVE']][$fd['SUB_FOR_PRO_CVE']][] = $fd;
            }
            $data['is_interseccion'] = $this->obtener_is_interseccion(); //Agrega si es intersección en muestreo de docentes entré validador de nivel 1 y 2 
            echo $this->load->view('validador_censo/formacion/formacion.php', $data, true); //Valores que muestrán la lista
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    /////////////////////////Fin formación //////////////////////////
    /////////////////////////Fin dirección de tesis //////////////////////////

    /*     * ******************Inicia actividad docente ********************* */

    /**
     * author LEAS
     * Guarda actividad docente general
     */
    public function seccion_actividad_docente() {
        $data = array();
//        pr($this->obtener_etapa_convocatoria());
        $tipo_msg = $this->config->item('alert_msg');
        $this->lang->load('interface', 'spanish');
        $data['string_values'] = array_merge($this->lang->line('interface')['actividad_docente'], $this->lang->line('interface')['general']);
        $data['actividad_docente'] = $this->adm->get_actividad_docente_general($this->obtener_id_usuario())[0]; //Verifica si existe el ususario ya contiene datos de actividad
        //if (!empty($data['actividad_docente'])) {
        $data['curso_principal'] = $data['actividad_docente']['CURSO_PRINC_IMPARTE']; //Identificador del curso principal 
        $data['actividad_general_cve'] = $data['actividad_docente']['ACT_DOC_GRAL_CVE']; //Identificador del curso principal 
        $data['curso_principal_entidad_contiene'] = $data['actividad_docente']['TIP_ACT_DOC_PRINCIPAL_CVE']; //Entidad que contiene el curso principal
        $data['datos_tabla_actividades_docente'] = $this->adm->get_actividades_docente($data['actividad_docente']['ACT_DOC_GRAL_CVE'], $this->obtener_id_validacion(), $this->obtener_id_empleado()); //Datos de las tablas emp_actividad_docente, emp_educacion_distancia, emp_esp_medica
        $data['is_interseccion'] = $this->session->userdata('datos_validador')['is_interseccion'];
//}

        $this->load->view('validador_censo/actividad_docente/actividad_tpl', $data, FALSE);
    }

    /**
     * author LEAS
     * Carga el modal con opciones de tipo de actividad, tambien carga la información de una actividad
     * @param type $insertar si "insertar" es igual con "0" muestra el combo que 
     * carga los tipos de actividad docente. Si "insertar" es mayor que "0"
     */
    public function carga_datos_actividad($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) {
            //if ($this->input->post()) {
            //$data_post = $this->input->post(null, true);
//                pr($data_post);
            $this->lang->load('interface', 'spanish');
            $data_actividad['string_values'] = array_merge($this->lang->line('interface')['actividad_docente'], $this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']); //Carga textos a utilizar 
            $data_actividad['identificador'] = $identificador;

            $cve_actividad = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
            $tipo_actividad_docente = $this->input->get('t', true);
            /* $act_gral_cve = $this->input->post('act_gral_cve');
              $data_actividad['act_gral_cve'] = $act_gral_cve;
              $datos_pie = array();
              $datos_pie['act_gral_cve'] = $act_gral_cve; */

            /* if ($insertar === '0') {//Muestra el combo para seleccionar tipo de actividad docente 
              $condiciones_ = array(enum_ecg::ctipo_actividad_docente => array('TIP_ACT_DOC_CVE < ' => 15));
              $data_actividad = carga_catalogos_generales(array(enum_ecg::ctipo_actividad_docente), $data_actividad, $condiciones_);
              } else { */
            //$id_tp_act_doc = intval($data_post['tp_actividad_cve']);
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
                //Condiciones extra "pago_extra" y "duracion"
                //$this->lang->load('interface', 'spanish');
                //$string_values = $this->lang->line('interface')['actividad_docente'];
                //************fin de la carga de catálogos ***************************************
                //*****************Carga ccurso según tipo de curso**************************
                //pr($data_formulario);
                $valua_entidad = $propiedades['tabla_guardado'] === 'emp_actividad_docente';
                if ($valua_entidad AND isset($data_formulario['ctipo_curso_cve']) AND ! empty($data_formulario['ctipo_curso_cve']) AND isset($data_formulario['ccurso_cve']) AND ! empty($data_formulario['ccurso_cve'])) {//si existe el "ccurso" y "ctipo_curso", hay que pintarlo
                    $tipo_curso_cve = intval($data_formulario['ctipo_curso_cve']);
                    $data_formulario['ccurso_pinta'] = $this->vista_ccurso($tipo_curso_cve, $data_formulario['CUR_NOMBRE']); //Punta el curso
                }
                //********************************************************************************
                //Carga dsatos de píe 
                //$datos_pie['tp_actividad_cve'] = $tipo_actividad_docente;
                //$datos_pie['act_doc_cve'] = $this->input->post('act_doc_cve');
                //Todo lo de comprobante *********************************************************
                /* $data_comprobante['string_values'] = $this->lang->line('interface')['general'];
                  $entidades_comprobante = array(enum_ecg::ctipo_comprobante);
                  $data_comprobante['catalogos'] = carga_catalogos_generales($entidades_comprobante, null, null);
                  if (isset($data_formulario['comprobante']) AND ! empty($data_formulario['comprobante'])) {
                  $data_comprobante['idc'] = $this->seguridad->encrypt_base64($data_formulario['comprobante']);
                  $datos_pie['comprobantecve'] = $data_comprobante['idc'];
                  $data_comprobante['dir_tes'] = array('TIPO_COMPROBANTE_CVE' => $data_formulario['ctipo_comprobante_cve'],
                  'COMPROBANTE_CVE' => isset($data_formulario['comprobante_cve']) ? $data_formulario['comprobante_cve'] : '',
                  'COM_NOMBRE' => isset($data_formulario['text_comprobante']) ? $data_formulario['text_comprobante'] : '');
                  }
                  $vista_comprobante['vista_comprobante'] = $this->load->view('template/formulario_carga_archivo', $data_comprobante, TRUE);
                  $data_formulario['formulario_carga_comprobante'] = $this->load->view('validador_censo/actividad_docente/comprobante_actividad_docente', $vista_comprobante, TRUE); */
                //*********************************************fin carga comprobante**************
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
                //pr($data_formulario);
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

    private function cargar_datos_actividad($id_tp_actividad, $id_act_doc, $propiedades_entidad) {
        $cve = $propiedades_entidad['llave_primaria'];
        $entidad = $propiedades_entidad['tabla_guardado'];
        $result_consulta = $this->adm->get_datos_actividad_docente($entidad, $id_act_doc);
        return $result_consulta;
    }

    public function get_vista_form_act_docente() {
        if ($this->input->is_ajax_request()) {//Si es un ajax
            if ($this->input->post()) {//Datos mandados por post
                $datos_post = $this->input->post(null, FALSE);
                $this->lang->load('interface', 'spanish');
                $tipo_msg = $this->config->item('alert_msg');
                $string_values = $this->lang->line('interface')['actividad_docente']; //Carga textos a utilizar 
                if (!empty($datos_post['tp_actividad_cve']) AND $datos_post['tp_actividad_cve'] !== 'undefined') {//Carga el formulario correspondiente
                    //Carga los catálogos y vistas correspondientes *****************************
                    $index_tp_actividad = intval($datos_post['tp_actividad_cve']);
                    $configuracion_formularios_actividad_docente = $this->config->item('actividad_docente_componentes')[$index_tp_actividad]; //Carga la configuración  del formularío
                    $condiciones_ = null;
                    if (isset($configuracion_formularios_actividad_docente['where'])) {
                        $condiciones_ = $configuracion_formularios_actividad_docente['where'];
                    }
                    $group_where = null;
                    if (isset($configuracion_formularios_actividad_docente['where_grup'])) {
                        $group_where = $configuracion_formularios_actividad_docente['where_grup'];
                    }
                    $entidades_ = $configuracion_formularios_actividad_docente['catalogos_indexados']; //Nombre de los catátalogos a cargar
                    $data_actividad_doc = carga_catalogos_generales($entidades_, null, $condiciones_, true, $group_where);
                    //************fin de la carga de catálogos ***********************************
                    $data_actividad_doc['mostrar_hora_fecha_duracion'] = 0; //
                    $data_actividad_doc['string_values'] = $string_values;
                    //Todo lo de comprobante *******************************************
                    $data_comprobante['string_values'] = $this->lang->line('interface')['general'];
                    $entidades_comprobante = array(enum_ecg::ctipo_comprobante);
                    $data_comprobante['catalogos'] = carga_catalogos_generales($entidades_comprobante, null, null);
                    $vista_comprobante['vista_comprobante'] = $this->load->view('template/formulario_carga_archivo', $data_comprobante, TRUE);
                    $data_actividad_doc['formulario_carga_comprobante'] = $this->load->view('validador_censo/actividad_docente/comprobante_actividad_docente', $vista_comprobante, TRUE);
                    //**** fi de comprobante *******************************************
                    echo $this->load->view($configuracion_formularios_actividad_docente['vista'], $data_actividad_doc, TRUE);
                    exit();
                } else {
                    //Manda mensaje que debe cargar o seleccionar una opción
                    $res_j['error'] = $string_values['msj_selecciona_actividad_docente']; //Mensaje
                    $res_j['tipo_msg'] = $tipo_msg['WARNING']['class']; //Tipo de mensaje de error
                    $res_j['satisfactorio'] = FALSE; //Tipo de mensaje de error
                    echo json_encode($res_j);
                    exit();
                }
            }
        } else {
            redirect(site_url());
        }
    }

    /**
     * @author LEAS
     * @param type $index_tipo_actividad_docente 
     */
    public function get_add_actividad_docente() {
        if ($this->input->is_ajax_request()) {//Si es un ajax
            $datos_post = $this->input->post(null, true);
            if ($datos_post) {
                $index_tipo_actividad_docente = intval($datos_post['cve_tipo_actividad']);
                $configuracion_formularios_actividad_docente = $this->config->item('actividad_docente_componentes')[$index_tipo_actividad_docente]; //Carga la configuración  del formularío
                $tipo_msg = $this->config->item('alert_msg');
                $this->lang->load('interface', 'spanish');
                $string_values = $this->lang->line('interface')['actividad_docente']; //Carga textos a utilizar
                $data_actividad_doc['string_values'] = $string_values; //Almacena textos de actividad en el arreglo
                $data_actividad_doc['mostrar_hora_fecha_duracion'] = 0; //
                $this->config->load('form_validation'); //Cargar archivo con validaciones
                $validations = $this->config->item('form_ccl'); //Obtener validaciones de archivo
                $data_actividad_doc['mostrar_hora_fecha_duracion'] = $this->get_valor_validacion($datos_post, 'duracion'); //Muestrá validaciones de hora y fecha de inicio y termino según la opción de duración
                $array_validaciones_extra_actividad = $configuracion_formularios_actividad_docente['validaciones_extra']; //Carga las validaciones extrá de archivo config->general que no se pudieron automatizar con el post, es decir radio button etc
                $result_validacion = $this->analiza_validacion_actividades_docentes($validations, $datos_post, $array_validaciones_extra_actividad); //Genera las validaciones del formulario que realmente deben ser tomadas en cuenta
                $validations = $result_validacion['validacion'];
//                pr($result_validacion['insert_entidad']);
                $this->form_validation->set_rules($validations); //Carga las validaciones
                if ($this->form_validation->run()) {//Ejecuta validaciones
                    $result_id_user = $this->obtener_id_usuario(); //Asigna id del usuario
                    $result_id_empleado = $this->obtener_id_empleado(); //Asigna id del usuario
                    $act_doc_gral = isset($datos_post['act_gral_cve']) ? $datos_post['act_gral_cve'] : NULL;
                    $result_guardar_actividad = $this->guardar_actividad($result_validacion['insert_entidad'], $index_tipo_actividad_docente, intval($datos_post['act_doc_cve']), $act_doc_gral, $result_id_empleado, $result_id_user, $string_values);
                    $res = json_encode($result_guardar_actividad);
                    echo $res;
                    exit();
                }

                if ($index_tipo_actividad_docente > 0) {//Checa si debe aparecer el botòn de guardar 
                    //Carga los catálogos y vistas correspondientes *****************************
                    $configuracion_formularios_actividad_docente = $this->config->item('actividad_docente_componentes')[$index_tipo_actividad_docente]; //Carga la configuración  del formularío
                    $condiciones_ = array();
                    if (isset($configuracion_formularios_actividad_docente['where'])) {
                        $condiciones_ = $configuracion_formularios_actividad_docente['where'];
                    }
                    $group_where = array();

                    if (isset($configuracion_formularios_actividad_docente['where_grup'])) {
                        $group_where = $configuracion_formularios_actividad_docente['where_grup'];
                    }
                    $entidades_ = $configuracion_formularios_actividad_docente['catalogos_indexados']; //Nombre de los catátalogos a cargar
                    $data_actividad_doc = carga_catalogos_generales($entidades_, $data_actividad_doc, $condiciones_, true, $group_where);
                    //************fin de la carga de catálogos ***********************************
                    if (isset($datos_post['ctipo_curso']) AND ! empty(isset($datos_post['ctipo_curso'])) AND isset($datos_post['ccurso'])) {//si existe el "ccurso" y "ctipo_curso", hay que pintarlo
                        $tipo_curso_cve = intval($datos_post['ctipo_curso']);
                        $data_actividad_doc['ccurso_pinta'] = $this->vista_ccurso($tipo_curso_cve); //Punta el curso
                    }
                    //Todo lo de comprobante *******************************************
                    $data_comprobante['string_values'] = $this->lang->line('interface')['general'];
                    $entidades_comprobante = array(enum_ecg::ctipo_comprobante);
                    $data_comprobante['catalogos'] = carga_catalogos_generales($entidades_comprobante, null, null);
                    if (isset($datos_post['idc']) AND ! empty($datos_post['idc'])) {
                        $data_comprobante['idc'] = $datos_post['idc'];
                        $data_comprobante['dir_tes'] = array('TIPO_COMPROBANTE_CVE' => $datos_post['tipo_comprobante'],
                            'COM_NOMBRE' => isset($datos_post['text_comprobante']) ? $datos_post['text_comprobante'] : '',
                            'COMPROBANTE_CVE' => isset($datos_post['comprobante_cve']) ? $datos_post['comprobante_cve'] : '');
                    }

                    $vista_comprobante['vista_comprobante'] = $this->load->view('template/formulario_carga_archivo', $data_comprobante, TRUE);
                    $data_actividad_doc['formulario_carga_comprobante'] = $this->load->view('validador_censo/actividad_docente/comprobante_actividad_docente', $vista_comprobante, TRUE);
                    //**** fi de comprobante *******************************************
                    echo $this->load->view($configuracion_formularios_actividad_docente['vista'], $data_actividad_doc, TRUE); //Carga la vista correspondiente al index
                }
            }
        }
    }

    /**
     * @author LEAS
     * @param type $validaciones
     * @param type $key
     * @return int
     */
    private function get_valor_validacion($validaciones, $key) {
        if (array_key_exists($key, $validaciones)) {
            return $validaciones[$key];
        }
        return 0;
    }

    /**
     * author LEAS
     * modificacion 17/08/2016
     * @param type $array_validacion
     * @param type $array_post
     * @param type $validacion_extra Las validaciones extra estan pensadas más 
     *             para "radio button" validaciones_extra, es un array de reglas 
     *             que se encuentrá en 
     * "config"->"general"->"actividad_docente_componentes"->"validaciones_extra"
     * y son de tipo textuales,
     * @return type
     */
    private function analiza_validacion_actividades_docentes($array_validacion, $array_post, $validacion_extra, $is_actualizacion = FALSE) {
//        pr($array_componentes);
//        pr($array_validacion);
        $entidad_name = $this->config->item('actividad_docente_componentes')[$array_post['cve_tipo_actividad']]['tabla_guardado']; //Carga los datos de la entidad para guardar
        $array_insert = $this->config->item($entidad_name);
        $array_result = array();
        foreach ($array_post as $key => $value) {
            switch ($key) {
                case 'idc'://Clave del comprobante 
                    $comprobante_cve = $this->seguridad->decrypt_base64($value); //Desencripta comprobante
                    //Array para insertar
                    $array_result['insert_entidad']['COMPROBANTE_CVE'] = $comprobante_cve; //Agrega id del comprobante
                    break;
                case 'enctype':
                    break;
                case 'tipo_comprobante':
                    break;
                case 'text_comprobante':
                    break;
                case 'extension':
                    break;
                case 'act_doc_cve':
                    break;
                case 'fecha_inicio_pick'://No carga si no hasta duraciòn 
//                    $array_fechas['fecha_inicio_pick'] = date("Y-m-d", strtotime($value));
                    break;
                case 'fecha_fin_pick'://No carga si no hasta duraciòn
//                    $array_fechas['fecha_fin_pick'] = date("Y-m-d", strtotime($value));
                    break;
                case 'hora_dedicadas'://No carga si no hasta duraciòn
                    break;
                case 'duracion':
                    if ($value === 'hora_dedicadas') {
                        $array_result['validacion'][] = $array_validacion['hora_dedicadas'];
                        //Array para insertar
                        if (key_exists('hora_dedicadas', $array_insert)) {
                            $array_result['insert_entidad'][$array_insert['hora_dedicadas']['insert']] = $array_post['hora_dedicadas']; //Agrega valor
                        }
                    } else {//fechas_dedicadas
                        $array_result['validacion'][] = $array_validacion['fecha_inicio_pick'];
                        $array_result['validacion'][] = $array_validacion['fecha_fin_pick'];
                        //Array para insertar
                        if (key_exists('fecha_inicio_pick', $array_insert)) {
                            $array_result['insert_entidad'][$array_insert['fecha_inicio_pick']['insert']] = $array_post['fecha_inicio_pick']; //Agrega valor
                            $array_result['insert_entidad'][$array_insert['fecha_fin_pick']['insert']] = $array_post['fecha_fin_pick']; //Agrega valor
                        }
                    }
                    break;
                default :
//                    pr($key);
                    if (key_exists($key, $array_validacion)) {
                        $array_result['validacion'][] = $array_validacion[$key];
                    }
                    //Array para insertar
                    if (key_exists($key, $array_insert)) {
                        $array_result['insert_entidad'][$array_insert[$key]['insert']] = $value; //Agrega valor
                    }
            }
        }
        //Elimina claves vacias tipo de curso está vacia en "emp_actividad_docente" solo sirve para hacer la validación pero no guarda, solo guarda ccurso
        unset($array_result['insert_entidad']['']);
        //Busca si existen validaciones extra, ejemple pago extra o duración, que son radio button, pero no trae valor si no se selecciona 
        foreach ($validacion_extra as $value_extra) {
            if (!array_key_exists($value_extra, $array_post)) {
                $array_result['validacion'][] = $array_validacion[$value_extra];
            }
        }
        return $array_result;
    }

    private function verifica_curso_principal_actividad_docente($index_tp_actividad = '0', $index_entidad = '0', $id_user = '0') {
        if ($index_entidad === '0' || $index_tp_actividad = '0' || $id_user = '0') {
            return -1; //No es curso principal
        }
        $actividad_docente = $this->adm->get_actividad_docente_general($id_user); //Verifica si existe el ususario ya contiene datos de actividad
        if (!empty($actividad_docente)) {//Existe la actividad docente general
            $actividad_docente = $this->adm->get_verifica_curso_principal_actividad_general($index_tp_actividad, $index_entidad, $actividad_docente); //Verifica si es curso principal
        } else {
            return -1; //No es curso principal
        }
    }

    public function cargar_comprobante() {
//        pr('queueuee');
        if ($this->input->post()) {
//            pr($this->input->post());
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = '50000';
//        $config['file_name'] = $file_name;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) {
                $data['error'] = $this->upload->display_errors();
            } else {

                $file_data = $this->upload->data();
                $data['file_path'] = './uploads/' . $file_data['file_name'];
            }
//            pr($this->upload->data());
            return $data;
        }
    }

//********************Investigación educativa ******************************************************************************/
    public function seccion_investigacion() {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $this->lang->load('interface', 'spanish');
            $data['string_values'] = array_merge($this->lang->line('interface')['investigacion_docente'], $this->lang->line('interface')['general']);
            $validacion_cve_session = $this->obtener_id_validacion();
            //$result_id_user = $this->obtener_id_usuario(); //Asignamos id usuario a variable
            //$empleado = $this->cg->getDatos_empleado($result_id_user); //Obtenemos datos del empleado
            //if (!empty($empleado)) {//Si existe un empleado, obtenemos datos
            $this->load->model('Investigacion_docente_model', 'id');

            ////////Inicio agregar validaciones de estado
            $val_correc_inv = $validation_est_corr_inv = array();
            $estado_validacion_actual = $this->session->userdata('datosvalidadoactual')['est_val']; //Estado actual de la validación
            $val_correc_inv = array('validation_estado' => array('table' => 'hist_eaid_validacion_curso', 'fields' => 'VAL_CUR_EST_CVE', 'conditions' => 'hist_eaid_validacion_curso.EAID_CVE=eaid.EAID_CVE AND VALIDACION_CVE != ' . $validacion_cve_session, 'order' => 'VAL_CUR_FCH DESC', 'limit' => '1'));
            /////////Fin agregar validaciones de estado
            $data['is_interseccion'] = $this->session->userdata('datos_validador')['is_interseccion'];
            $data['lista_investigaciones'] = $this->id->get_lista_datos_investigacion_docente($this->obtener_id_empleado(), array_merge(array('validation' => array('table' => 'hist_eaid_validacion_curso', 'fields' => 'COUNT(*) AS validation', 'conditions' => 'hist_eaid_validacion_curso.EAID_CVE=eaid.EAID_CVE AND VALIDACION_CVE=' . $validacion_cve_session)), $val_correc_inv, $validation_est_corr_inv));
            $this->load->view('validador_censo/investigacion/investigacion_tpl', $data, FALSE); //Valores que muestrán la lista
            /* } else {
              //Error, No existe el empleado
              } */
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function cargar_formulario_investigacion() {
        if ($this->input->is_ajax_request()) {
            $this->lang->load('interface', 'spanish');
            $string_values = $this->lang->line('interface')['investigacion_docente']; //Carga textos a utilizar 
            $data_investigacion['string_values'] = $string_values; //Crea la variable
            $data_investigacion['divulgacion'] = ''; //Crea la variable 
            $condiciones_ = array(enum_ecg::ctipo_actividad_docente => array('TIP_ACT_DOC_CVE > ' => 14));
            $entidades_ = array(enum_ecg::ctipo_actividad_docente, enum_ecg::ctipo_comprobante, enum_ecg::ctipo_participacion, enum_ecg::ctipo_estudio, enum_ecg::cmedio_divulgacion);
            $data_investigacion = carga_catalogos_generales($entidades_, $data_investigacion, $condiciones_);
            $datos_pie = array();

            $data = array(
                'titulo_modal' => 'Investigación',
                'cuerpo_modal' => $this->load->view('validador_censo/investigacion/investigacion_formulario', $data_investigacion, TRUE),
                'pie_modal' => $this->load->view('validador_censo/investigacion/investigacion_pie', $datos_pie, true)
            );
            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
        } else {
            redirect(site_url());
        }
    }

    public function cargar_opcion_divulgacion() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {//Después de cargar el formulario
                $datos_post = $this->input->post(null, true);
                $vista = $this->divulgacion_cargar($datos_post['cve_divulgacion']);
                echo $vista;
            }
        } else {
            redirect(site_url());
        }
    }

    public function carga_datos_investigacion($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) {
            $this->lang->load('interface', 'spanish');
            $data_investigacion['string_values'] = array_merge($this->lang->line('interface')['investigacion_docente'], $this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']); //Carga textos a utilizar 
            //$divulgacion = '';
            $data_investigacion['identificador'] = $identificador;
            $result_id_user = $this->obtener_id_usuario(); //Asignamos id usuario a variable
            $matricula_user = $this->session->userdata('matricula');
            //$datos_pie = array();
            //if ($this->input->post()) {
            //$datos_post = $this->input->post(null, true);
//                pr($datos_post);
            //if (isset($datos_post['cve_inv'])) {
            //$datos_pie['cve_inv'] = $datos_post['cve_inv'];
            //$datos_pie['comprobantecve'] = $datos_post['comprobantecve'];
            $id_inv = $this->seguridad->decrypt_base64($identificador);
            $data_investigacion['dir_tes'] = $this->idm->get_datos_investigacion_docente($id_inv); //Variable que carga los datos del registro de investigación, será enviada a la vista para cargar los datos
            //Selecciona divulgación
            $data_investigacion['formulario_carga_opt_tipo_divulgacion'] = $this->divulgacion_cargar($data_investigacion['dir_tes']['med_divulgacion_cve'], $data_investigacion, TRUE);
            //}
            //}
            //}
            $accion_general = $this->config->item('ACCION_GENERAL');
            if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                $data_investigacion = $this->validar_registro(array_merge($data_investigacion, array('tipo_id' => 'INVESTIGACION_EDUCATIVA', 'seccion_actualizar' => 'seccion_investigacion', 'identificador_registro' => $id_inv)));
            } else {
                $data_investigacion['formulario_validacion'] = $this->historico_registro(array_merge($data_investigacion, array('tipo_id' => 'INVESTIGACION_EDUCATIVA', 'seccion_actualizar' => 'seccion_investigacion', 'identificador_registro' => $id_inv)));
                $data_investigacion['pie_modal'] = '<div class="col-xs-12 col-sm-12 col-md-12 text-right"><button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">' . $data_investigacion['string_values']['cerrar'] . '</button></div>';
            }
            //$data_investigacion['formulario_carga_archivo'] = $this->load->view('template/formulario_visualizar_archivo', $data_investigacion, TRUE);
            //$data_investigacion['divulgacion'] = $divulgacion; //Crea la variable 
            //$condiciones_ = array(enum_ecg::ctipo_actividad_docente => array('TIP_ACT_DOC_CVE > ' => 14));
            //$entidades_ = array(enum_ecg::ctipo_actividad_docente, enum_ecg::ctipo_comprobante, enum_ecg::ctipo_participacion, enum_ecg::ctipo_estudio, enum_ecg::cmedio_divulgacion);
            //$data_investigacion = carga_catalogos_generales($entidades_, $data_investigacion, $condiciones_);
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
                    //Todo lo de comprobante *******************************************
                    //$data_comprobante['string_values'] = $this->lang->line('interface')['general'];
                    /* $entidades_comprobante = array(enum_ecg::ctipo_comprobante);
                      $data_comprobante['catalogos'] = carga_catalogos_generales($entidades_comprobante, null, null);
                      if ($is_actualizacion) {
                      if (!empty($array_comprobante) AND isset($array_comprobante['idc'])) {//si existe el id del comprobante
                      //                        $id_desencript = $this->seguridad->decrypt_base64($datos_post['idc']);
                      $data_comprobante['idc'] = $array_comprobante['idc'];
                      $data_comprobante['dir_tes'] = array('TIPO_COMPROBANTE_CVE' => $array_comprobante['tipo_comprobante'],
                      'COM_NOMBRE' => isset($array_comprobante['text_comprobante']) ? $array_comprobante['text_comprobante'] : '',
                      'COMPROBANTE_CVE' => isset($array_comprobante['comprobante_cve']) ? $array_comprobante['comprobante_cve'] : '');
                      }
                      } else {

                      if (!empty($array_comprobante) AND isset($array_comprobante['idc'])) {//si existe el id del comprobante
                      //                        $id_desencript = $this->seguridad->decrypt_base64($datos_post['idc']);
                      $data_comprobante['idc'] = $array_comprobante['idc'];
                      //                            pr($array_comprobante);
                      $data_comprobante['dir_tes'] = array('TIPO_COMPROBANTE_CVE' => $array_comprobante['tipo_comprobante'],
                      'COM_NOMBRE' => isset($array_comprobante['text_comprobante']) ? $array_comprobante['text_comprobante'] : '',
                      'COMPROBANTE_CVE' => isset($array_comprobante['comprobante_cve']) ? $array_comprobante['comprobante_cve'] : '');
                      }
                      } */
                    //**** fi de comprobante *******************************************
                    //$data['vista_comprobante'] = $this->load->view('template/formulario_carga_archivo', $data_comprobante, TRUE);
                    $data['vista_comprobante'] = $this->load->view('template/formulario_visualizar_archivo', $array_comprobante, TRUE);
                    return $this->load->view('validador_censo/investigacion/comprobante_foro', $data, TRUE);
            }
            return '';
        }
    }

    /**
     * author LEAS
     * @param type $array_validaciones
     * @param type $array_elementos_post
     * @param type $validacion_extra Las validaciones extra estan pensadas más 
     *             para "radio button" validaciones_extra, es un array de reglas 
     *             que se encuentrá en 
     * "config"->"general"->"actividad_docente_componentes"->"validaciones_extra"
     * y son de tipo textuales,
     * @return type
     */
    private function analiza_validacion_investigacion_docente($array_validaciones, $array_elementos_post, $file = null, $is_actualizacion = FALSE) {
//        pr($array_validaciones);
//        pr($array_elementos_post);
        $array_result = array();
        $emp_act_inv_edu = $this->config->item('emp_act_inv_edu'); //Campos de la tabla
//        pr($array_elementos_post);
//        pr($$array_validaciones);
        foreach ($array_elementos_post as $key => $value) {
            if (array_key_exists($key, $array_validaciones)) {
                $array_result['validacion'][] = $array_validaciones[$key];
                if (array_key_exists($key, $emp_act_inv_edu)) {
                    $array_result['emp_act_inv_edu_inser'][$emp_act_inv_edu[$key]['insert']] = $value;
                    $array_result['emp_act_inv_edu_update'][$emp_act_inv_edu[$key]['insert']] = $value;
                }
            }
        }

        if ($is_actualizacion) {//si es acyualización limpía los datos de la entidad que no se ocupen, como limpiar el comprobante o la cita bibliografica
            foreach ($emp_act_inv_edu as $value) {
                $key_prima = $value['insert'];
                if (!isset($array_result['emp_act_inv_edu_update'][$key_prima])) {//Si no existe el elemento lo agraga null
                    $array_result['emp_act_inv_edu_update'][$key_prima] = NULL;
                }
            }
        }

//      pr($array_result);
        return $array_result;
    }

    public function get_fecha_ultima_actualizacion() {
        $this->lang->load('interface', 'spanish');
        $string_values = $this->lang->line('interface')['perfil'];
        $id_usuario = $this->obtener_id_usuario();

        /* setlocale(LC_ALL, 'es_ES');
          $upDate = $this->modPerfil->get_fecha_ultima_actualizacion($id_usuario)->fecha_bitacora;
          $datosPerfil['fecha_ult_act'] = $string_values['span_fecha_last_update'] . strftime("%d de %B de %G a las %H:%M:%S", strtotime($upDate));
         */

        $fecha_ultima_actualizacion['fecha_ult_act'] = $string_values['span_fecha_last_update'] . $this->modPerfil->get_fecha_ultima_actualizacion($id_usuario)->fecha_bitacora;
        $json = json_encode($fecha_ultima_actualizacion);

        echo $json;
        // pr($json);
    }

    /**
     * @author LEAS
     * @param type $name_comprobante //nombre del comprobante sin extención 
     * @return devuelve un mensaje de 
     */
    private function guardar_archivo($name_comprobante, $nom_propiedades = 'comprobantes') {
        $config_comprobante = $this->config->item('upload_config')[$nom_propiedades]; //Carga configuración para subir archivo comprobante
        $config_comprobante['file_name'] = $name_comprobante; //Asigna nombre del comprobante
        //$_FILE -> contiene contiene el archivo
        $this->load->library('upload', $config_comprobante); //Carga la configuración para subir el archivo
        if (!$this->upload->do_upload('file')) {//Nombre del componente file
            $data['error'] = $this->upload->display_errors();
//            pr('fin ------------>' . $data['error']);
        } else {
            $file_data = $this->upload->data();
            $data['file_path'] = './upload/' . $file_data['file_name'];
//            pr('fin ------------>' . $data['file_path']);
        }
        return $data;
    }

    ////////////////////////Inicio Factory de tipos de comisión
    private function emp_comision_fac($comision) {
        $com = new stdClass();
        switch ($comision['tipo_comision']) {
            case $this->config->item('tipo_comision')['DIRECCION_TESIS']['id']:
                $com = $this->direccion_tesis_vo($comision);
                break;
            case $this->config->item('tipo_comision')['COMITE_EDUCACION']['id']:
                $com = $this->comite_educacion_vo($comision);
                break;
            case $this->config->item('tipo_comision')['SINODAL_EXAMEN']['id']:
                $com = $this->sinodal_examen_vo($comision);
                break;
            case $this->config->item('tipo_comision')['COORDINADOR_TUTORES']['id']:
                $com = $this->coordinador_tutores_vo($comision);
                break;
            case $this->config->item('tipo_comision')['COORDINADOR_CURSO']['id']:
                $com = $this->coordinador_curso_vo($comision);
                break;
        }

        return $com;
    }

    private function direccion_tesis_vo($comision) {
        $com = new Direccion_tesis_dao;
        $com->EMPLEADO_CVE = (isset($comision['empleado']) && !empty($comision['empleado'])) ? $comision['empleado'] : NULL;
        $com->TIP_COMISION_CVE = (isset($comision['tipo_comision']) && !empty($comision['tipo_comision'])) ? $comision['tipo_comision'] : NULL;
        $com->COMPROBANTE_CVE = (isset($comision['idc']) && !empty($comision['idc'])) ? $this->seguridad->decrypt_base64($comision['idc']) : NULL;
        $com->EC_ANIO = (isset($comision['dt_anio']) && !empty($comision['dt_anio'])) ? $comision['dt_anio'] : NULL;
        $com->COM_AREA_CVE = (isset($comision['comision_area']) && !empty($comision['comision_area'])) ? $comision['comision_area'] : NULL;
        $com->NIV_ACADEMICO_CVE = (isset($comision['nivel_academico']) && !empty($comision['nivel_academico'])) ? $comision['nivel_academico'] : NULL;

        return $com;
    }

    private function comite_educacion_vo($comision) {
        $com = new Comite_educacion_dao;
        $com->EMPLEADO_CVE = (isset($comision['empleado']) && !empty($comision['empleado'])) ? $comision['empleado'] : NULL;
        $com->TIP_COMISION_CVE = (isset($comision['tipo_comision']) && !empty($comision['tipo_comision'])) ? $comision['tipo_comision'] : NULL;
        $com->COMPROBANTE_CVE = (isset($comision['idc']) && !empty($comision['idc'])) ? $this->seguridad->decrypt_base64($comision['idc']) : NULL;
        $com->EC_ANIO = (isset($comision['dt_anio']) && !empty($comision['dt_anio'])) ? $comision['dt_anio'] : NULL;
        $com->TIP_CURSO_CVE = (isset($comision['tipo_curso']) && !empty($comision['tipo_curso'])) ? $comision['tipo_curso'] : NULL;

        return $com;
    }

    private function sinodal_examen_vo($comision) {
        $com = new Sinodal_examen_dao;
        $com->EMPLEADO_CVE = (isset($comision['empleado']) && !empty($comision['empleado'])) ? $comision['empleado'] : NULL;
        $com->TIP_COMISION_CVE = (isset($comision['tipo_comision']) && !empty($comision['tipo_comision'])) ? $comision['tipo_comision'] : NULL;
        $com->COMPROBANTE_CVE = (isset($comision['idc']) && !empty($comision['idc'])) ? $this->seguridad->decrypt_base64($comision['idc']) : NULL;
        $com->EC_ANIO = (isset($comision['dt_anio']) && !empty($comision['dt_anio'])) ? $comision['dt_anio'] : NULL;
        $com->NIV_ACADEMICO_CVE = (isset($comision['nivel_academico']) && !empty($comision['nivel_academico'])) ? $comision['nivel_academico'] : NULL;

        return $com;
    }

    private function coordinador_tutores_vo($comision) {
        $com = new Coordinador_tutores_dao;
        $com->EMPLEADO_CVE = (isset($comision['empleado']) && !empty($comision['empleado'])) ? $comision['empleado'] : NULL;
        $com->TIP_COMISION_CVE = (isset($comision['tipo_comision']) && !empty($comision['tipo_comision'])) ? $comision['tipo_comision'] : NULL;
        $com->COMPROBANTE_CVE = (isset($comision['idc']) && !empty($comision['idc'])) ? $this->seguridad->decrypt_base64($comision['idc']) : NULL;
        $com->EC_ANIO = (isset($comision['dt_anio']) && !empty($comision['dt_anio'])) ? $comision['dt_anio'] : NULL;
        $com->EC_FCH_INICIO = (isset($comision['fecha_inicio_pick']) && !empty($comision['fecha_inicio_pick'])) ? date("Y-m-d", strtotime($comision['fecha_inicio_pick'])) : NULL;
        $com->EC_FCH_FIN = (isset($comision['fecha_fin_pick']) && !empty($comision['fecha_fin_pick'])) ? date("Y-m-d", strtotime($comision['fecha_fin_pick'])) : NULL;
        $com->EC_DURACION = (isset($comision['hora_dedicadas']) && !empty($comision['hora_dedicadas'])) ? $comision['hora_dedicadas'] : NULL;
        $com->TIP_CURSO_CVE = (isset($comision['tipo_curso']) && !empty($comision['tipo_curso'])) ? $comision['tipo_curso'] : NULL;
        $com->CURSO_CVE = (isset($comision['curso']) && !empty($comision['curso'])) ? $comision['curso'] : NULL;

        return $com;
    }

    private function coordinador_curso_vo($comision) {
        $com = new Coordinador_curso_dao;
        $com->EMPLEADO_CVE = (isset($comision['empleado']) && !empty($comision['empleado'])) ? $comision['empleado'] : NULL;
        $com->TIP_COMISION_CVE = (isset($comision['tipo_comision']) && !empty($comision['tipo_comision'])) ? $comision['tipo_comision'] : NULL;
        $com->COMPROBANTE_CVE = (isset($comision['idc']) && !empty($comision['idc'])) ? $this->seguridad->decrypt_base64($comision['idc']) : NULL;
        $com->EC_ANIO = (isset($comision['dt_anio']) && !empty($comision['dt_anio'])) ? $comision['dt_anio'] : NULL;
        $com->EC_FCH_INICIO = (isset($comision['fecha_inicio_pick']) && !empty($comision['fecha_inicio_pick'])) ? date("Y-m-d", strtotime($comision['fecha_inicio_pick'])) : NULL;
        $com->EC_FCH_FIN = (isset($comision['fecha_fin_pick']) && !empty($comision['fecha_fin_pick'])) ? date("Y-m-d", strtotime($comision['fecha_fin_pick'])) : NULL;
        $com->EC_DURACION = (isset($comision['hora_dedicadas']) && !empty($comision['hora_dedicadas'])) ? $comision['hora_dedicadas'] : NULL;
        $com->TIP_CURSO_CVE = (isset($comision['tipo_curso']) && !empty($comision['tipo_curso'])) ? $comision['tipo_curso'] : NULL;
        $com->CURSO_CVE = (isset($comision['curso']) && !empty($comision['curso'])) ? $comision['curso'] : NULL;

        return $com;
    }

    private function formacion_salud_vo($formacion) {
        $for = new Formacion_salud_dao;
        $for->EMPLEADO_CVE = (isset($formacion['empleado']) && !empty($formacion['empleado'])) ? $formacion['empleado'] : NULL;
        $for->COMPROBANTE_CVE = (isset($formacion['idc']) && !empty($formacion['idc'])) ? $this->seguridad->decrypt_base64($formacion['idc']) : NULL;
        $for->EFPCS_FCH_INICIO = (isset($formacion['fch_inicio']) && !empty($formacion['fch_inicio'])) ? date("Y-m-d", strtotime('1-' . $formacion['fch_inicio'])) : NULL;
        $for->EFPCS_FCH_FIN = (isset($formacion['fch_fin']) && !empty($formacion['fch_fin'])) ? date("Y-m-d", strtotime('1-' . $formacion['fch_fin'])) : NULL;
        $for->EFPCS_FOR_INICIAL = (isset($formacion['es_inicial']) && !empty($formacion['es_inicial'])) ? $formacion['es_inicial'] : NULL;
        $for->TIP_FORM_SALUD_CVE = (isset($formacion['tipo_formacion']) && !empty($formacion['tipo_formacion'])) ? $formacion['tipo_formacion'] : NULL;
        $for->CSUBTIP_FORM_SALUD_CVE = (isset($formacion['subtipo']) && !empty($formacion['subtipo'])) ? $formacion['subtipo'] : NULL;

        return $for;
    }

    ////////////////////////Fin Factory de tipos de comisión
    ////////////////////////Inicio formacion docente
    private function formacion_docente_vo($formacion) {
        $for = new Formacion_docente_dao;
        $for->EMPLEADO_CVE = (isset($formacion['empleado']) && !empty($formacion['empleado'])) ? $formacion['empleado'] : NULL;
        $for->COMPROBANTE_CVE = (isset($formacion['idc']) && !empty($formacion['idc'])) ? $this->seguridad->decrypt_base64($formacion['idc']) : NULL;
        $for->EFP_DURACION = (isset($formacion['hora_dedicadas']) && !empty($formacion['hora_dedicadas'])) ? $formacion['hora_dedicadas'] : NULL;
        $for->MODALIDAD_CVE = (isset($formacion['modalidad']) && !empty($formacion['modalidad'])) ? $formacion['modalidad'] : NULL;
        $for->INS_AVALA_CVE = (isset($formacion['institucion']) && !empty($formacion['institucion'])) ? $formacion['institucion'] : NULL;
        $for->EFP_FCH_INICIO = (isset($formacion['fecha_inicio_pick']) && !empty($formacion['fecha_inicio_pick'])) ? date("Y-m-d", strtotime($formacion['fecha_inicio_pick'])) : NULL;
        $for->EFP_FCH_FIN = (isset($formacion['fecha_fin_pick']) && !empty($formacion['fecha_fin_pick'])) ? date("Y-m-d", strtotime($formacion['fecha_fin_pick'])) : NULL;
        $for->CURSO_CVE = (isset($formacion['tipo_curso']) && !empty($formacion['tipo_curso'])) ? $formacion['tipo_curso'] : NULL;
        $for->TIP_FOR_PROF_CVE = (isset($formacion['tipo_formacion']) && !empty($formacion['tipo_formacion'])) ? $formacion['tipo_formacion'] : NULL;
        $for->SUB_FOR_PRO_CVE = (isset($formacion['subtipo']) && !empty($formacion['subtipo'])) ? $formacion['subtipo'] : NULL;
        $for->EFO_ANIO_CURSO = (isset($formacion['fd_anio']) && !empty($formacion['fd_anio'])) ? $formacion['fd_anio'] : NULL;
        $for->EFP_NOMBRE_CURSO = (isset($formacion['nombre_curso']) && !empty($formacion['nombre_curso'])) ? $formacion['nombre_curso'] : NULL;

        return $for;
    }

    private function formacion_docente_tematica_vo($tematicas, $identificador) {
        $formacion = array();
        foreach ($tematicas as $key_t => $tematica) {
            $tem = new Formacion_docente_tematica_dao;
            $tem->TEMATICA_CVE = $tematica;
            $tem->EMP_FORMACION_PROFESIONAL_CVE = $identificador;
            $formacion[] = $tem;
        }
        return $formacion;
    }

    ////////////////////////Fin formacion docente
    /*     * *********************************** Material educativo **************************** */

    public function seccion_material_educativo() {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $this->lang->load('interface', 'spanish');
            $data['string_values'] = array_merge($this->lang->line('interface')['material_educativo'], $this->lang->line('interface')['general']);
            $result_id_user = $this->obtener_id_usuario(); //Asignamos id usuario a variable
            $empleado = $this->obtener_id_empleado(); //Asignamos id usuario a variable
            if (!empty($empleado)) {//Si existe un empleado, obtenemos datos
                ////////Inicio agregar validaciones de estado
                $validation_estado = array('validation_estado' => array('table' => 'hist_me_validacion_curso', 'fields' => 'VAL_CUR_EST_CVE', 'conditions' => 'hist_me_validacion_curso.MATERIA_EDUCATIVO_CVE=eme.MATERIA_EDUCATIVO_CVE ', 'order' => 'VAL_CUR_FCH DESC', 'limit' => '1'));
                ///////////////// Cara si es una intersección ///////////////
                $data['is_interseccion'] = $this->session->userdata('datos_validador')['is_interseccion'];
                /////////Fin agregar validaciones de estado
                $data['lista_material_educativo'] = $this->mem->get_lista_material_educativo($empleado, $validation_estado);
                $this->load->view('validador_censo/material_educativo/elaboracion_material_edu_tpl', $data, FALSE); //Valores que muestrán la lista
            }
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function get_form_general_material_educativo() {
        if ($this->input->is_ajax_request()) {
            $this->lang->load('interface', 'spanish');
            $string_values = $this->lang->line('interface')['material_educativo']; //Carga textos a utilizar 
            $datos_mat_edu['string_values'] = $string_values; //Crea la variable
            $condiciones_ = array(enum_ecg::ctipo_material => array('TIP_MAT_TIPO =' => NULL));
            $entidades_ = array(enum_ecg::ctipo_material);
            $datos_mat_edu = carga_catalogos_generales($entidades_, $datos_mat_edu, $condiciones_);
            //Todo lo de comprobante *******************************************
            $data_comprobante['string_values'] = $this->lang->line('interface')['general'];
            $entidades_comprobante = array(enum_ecg::ctipo_comprobante);
            $data_comprobante['catalogos'] = carga_catalogos_generales($entidades_comprobante, null, null);
            $datos_mat_edu['formulario_carga_archivo'] = $this->load->view('template/formulario_carga_archivo', $data_comprobante, TRUE);
            //**** fi de comprobante *******************************************
            $datos_pie = array();
            $data = array(
                'titulo_modal' => $string_values['title_material_eduacativo'],
                'cuerpo_modal' => $this->load->view('validador_censo/material_educativo/formulario_mat_edu_general', $datos_mat_edu, TRUE),
                'pie_modal' => $this->load->view('validador_censo/material_educativo/material_edu_pie', $datos_pie, true)
            );
            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function get_cargar_tipo_material() {
        if ($this->input->is_ajax_request()) {
//            pr($this->input->post(null, TRUE));
            $this->lang->load('interface', 'spanish');
            $string_values = $this->lang->line('interface')['material_educativo']; //Carga textos a utilizar 
            $datos_mat_edu['string_values'] = $string_values; //Crea la variable

            if ($this->input->post()) {//Después de cargar el formulario
                $datos_post = $this->input->post(null, true);
//                pr($datos_post);
                if (!empty($datos_post['ctipo_material'])) {
                    $index_tipo_mat = $datos_post['ctipo_material'];
                    $datos_tipo_material ['string_values'] = $string_values;
                    $datos_tipo_material ['cantidad_hojas'] = $this->config->item('opciones_tipo_material')['cantidad_hojas'];
                    $datos_tipo_material ['numero_horas'] = $this->config->item('opciones_tipo_material')['numero_horas'];
                    $datos_mat_edu['formulario_complemento'] = $this->load->view('validador_censo/material_educativo/formulario_mat_edu_' . $index_tipo_mat, $datos_tipo_material, TRUE);
                }
            }
            $condiciones_ = array(enum_ecg::ctipo_material => array('TIP_MAT_TIPO =' => NULL));
            $entidades_ = array(enum_ecg::ctipo_material);
            $datos_mat_edu = carga_catalogos_generales($entidades_, $datos_mat_edu, $condiciones_);
            //Todo lo de comprobante *******************************************
            $data['string_values'] = $this->lang->line('interface')['general'];
            $entidades_comprobante = array(enum_ecg::ctipo_comprobante);
            $data['catalogos'] = carga_catalogos_generales($entidades_comprobante, null, null);
            if (isset($datos_post['idc'])) {//si existe el id del comprobante
                $data['idc'] = $datos_post['idc'];
//                $id_desencript = $this->seguridad->decrypt_base64($datos_post['idc']);
//                pr($id_desencript);
            }
            $datos_mat_edu['formulario_carga_archivo'] = $this->load->view('template/formulario_carga_archivo', $data, TRUE);
            //**** fi de comprobante *******************************************
            echo $this->load->view('validador_censo/material_educativo/formulario_mat_edu_general', $datos_mat_edu, TRUE);
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    private function analiza_validacion_material_educativo($array_validacion, $array_post, $is_actualizacion = FALSE, $file = null) {
//        pr($array_post);
//        pr($array_validacion);
        $array_result = array();
        $insert_emp_materia_educativo = $this->config->item('emp_materia_educativo');
        $insert_ctipo_material = $this->config->item('ctipo_material');
        if ($is_actualizacion) {//Pone en nulo todos los campos de las entidades "ctipo_material" y "emp_materia_educativo" para actualizar
            foreach ($insert_ctipo_material as $value_t_m) {
//                pr($value_t_m['insert']);
                $array_result['insert_ctipo_material'][$value_t_m['insert']] = 'NULL'; //Limpia todos los registros`, ya que los campos que contenian información, previamente y en la actualización  ya no, estos no guarden información que no debería
            }
            foreach ($insert_ctipo_material as $value_t_m) {
//                pr($value_t_m['insert']);
                $array_result['insert_emp_materia_educativo'][$value_t_m['insert']] = 'NULL'; //Limpia todos los registros`, ya que los campos que contenian información, previamente y en la actualización  ya no, estos no guarden información que no debería
            }
        }
//        pr($insert_emp_materia_educativo);
//        pr($array_post);
        foreach ($array_post as $key => $value) {
            switch ($key) {
                case 'numero_horas'://Cambia el valor a texto del array
                    if (!empty($value)) {
                        $value = $this->config->item('opciones_tipo_material')['numero_horas'][$value];
                    }
                    break;
                case 'cantidad_hojas'://Cambia el valor a texto del array
                    if (!empty($value)) {
                        $value = $this->config->item('opciones_tipo_material')['cantidad_hojas'][$value];
                    }
                    break;
            }
            if (array_key_exists($key, $array_validacion)) {//Verifica existencia de la llave
                $array_result['validacion'][] = $array_validacion[$key];
            }
            if (array_key_exists($key, $insert_emp_materia_educativo)) {//Verifica existencia de la llave
                $array_result['insert_emp_mat_educativo'][$insert_emp_materia_educativo[$key]['insert']] = $value;
            }
            if (array_key_exists($key, $insert_ctipo_material)) {//Verifica existencia de la llave
                if ($is_actualizacion AND $key === 'ctipo_material') {
                    if (intval($value) === 2 OR intval($value) === 5) {//El campo "TIP_MAT_TIPO" que es el padré lo ponemos en null, ya que no debe ya que la opcion 2 ó 5 no contiene hijos
                        $array_result['insert_ctipo_material'][$insert_ctipo_material[$key]['insert']] = 'NULL';
                    } else {
                        $array_result['insert_ctipo_material'][$insert_ctipo_material[$key]['insert']] = $value;
                    }
                } else {
                    $array_result['insert_ctipo_material'][$insert_ctipo_material[$key]['insert']] = $value;
                }
            }
        }

        return $array_result;
    }

    private function filtrar_datos_material_educatiovo($array_datos) {
//        $insert_emp_materia_educativo = $this->config->item('emp_materia_educativo');
//        $insert_ctipo_material = $this->config->item('ctipo_material');
//        $value = $this->config->item('opciones_tipo_material')['numero_horas'][$value];
        $padre_tp_material_padre = $array_datos['padre_tp_material'];
        $array_datos_res = array();
        if (!empty($padre_tp_material_padre)) {
            $padre_tp_material_padre = intval($padre_tp_material_padre);
            $array_opciones = $this->config->item('opciones_tipo_material')[$padre_tp_material_padre];
            foreach ($array_opciones as $key => $val) {//Asigna los valores a los campos de texto según el formulario secundario
                if ($key === 'opt_tipo_material') {//Para seleccionar opción
                    $array_option = $this->config->item('opciones_tipo_material')[$val];
                    foreach ($array_option as $key_option => $value_option) {//Busca la llave del texto
                        if ($array_datos['opt_tipo_material'] === $value_option) {
                            $array_datos_res[$key] = $key_option;
                            break;
                        }
                    }
                } else {//Para asignar texto
                    $array_datos_res[$key] = $array_datos[$key];
                }
            }
            $array_datos_res['material_educativo_cve'] = $padre_tp_material_padre; //Agrega el id del padré
        } else {
            $array_datos_res['material_educativo_cve'] = $array_datos['tipo_material_cve']; //Agrega el id almacenado en "tipo_material_cve"
        }
        $array_tmp_campos_entidad = $this->config->item('ctipo_material'); //Obtiene los campos de la entidad "ctipo_material"
        foreach ($array_datos as $key => $value) {
            if (array_key_exists($key, $array_tmp_campos_entidad)) {//Verifica existencia de la llave en la entidad "emp_materia_educativo" para enviar los datos
                $array_datos_res[$key] = $array_datos[$key];
            }
        }
        $array_tmp_campos_entidad = $this->config->item('emp_materia_educativo'); //Obtiene los campos de la entidad "emp_materia_educativo"
        foreach ($array_datos as $key => $value) {
            if (array_key_exists($key, $array_tmp_campos_entidad)) {//Verifica existencia de la llave en la entidad "emp_materia_educativo" para enviar los datos
                $array_datos_res[$key] = $array_datos[$key];
            }
        }
        $array_tmp_campos_entidad = $this->config->item('comprobante'); //Obtiene los campos de la entidad "emp_materia_educativo"
        foreach ($array_datos as $key => $value) {
            if (array_key_exists($key, $array_tmp_campos_entidad)) {//Verifica existencia de la llave en la entidad "emp_materia_educativo" para enviar los datos
                $array_datos_res[$key] = $array_datos[$key];
            }
        }
        return $array_datos_res;
    }

    public function carga_datos_editar_material_educativo($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) {
            //if ($this->input->post()) {//Indica que debe intentar eliminar el curso
            //$datos_post = $this->input->post(null, true);
            //pr($datos_post);
            $this->lang->load('interface', 'spanish');
            $datos_mat_edu['string_values'] = array_merge($this->lang->line('interface')['material_educativo'], $this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']); //Carga textos a utilizar 
            //$condiciones_ = array(enum_ecg::ctipo_material => array('TIP_MAT_TIPO =' => NULL));
            //$entidades_ = array(enum_ecg::ctipo_material);
            //$datos_mat_edu = carga_catalogos_generales($entidades_, $datos_mat_edu, $condiciones_);
            $material_edu_cve = $this->seguridad->decrypt_base64($identificador); //Identificador de materia_educativo
            $datos_mat_edu['identificador'] = $identificador;
            $datos_mat_edu['info_material_educativo'] = $this->mem->get_datos_material_educativo($material_edu_cve);
            //pr($datos_mat_edu['info_material_educativo']);
            //$datos_reg_mat_edu_validados = $this->filtrar_datos_material_educatiovo($datos_reg_mat_edu); //Modifica los nombres e las llaves para ajustar a los formilarios secundarios
            //pr($datos_reg_mat_edu_validados);
            //$datos_mat_edu['info_material_educativo'] = $datos_reg_mat_edu_validados;
            //pr($datos_mat_edu['info_material_educativo']);
            //Todo lo de comprobante *******************************************
            /* $data_comprobante['string_values'] = $this->lang->line('interface')['general'];
              $data_comprobante['dir_tes'] = array('TIPO_COMPROBANTE_CVE' => $datos_reg_mat_edu_validados['ctipo_comprobante'], 'COM_NOMBRE' => $datos_reg_mat_edu_validados['text_comprobante'], 'COMPROBANTE_CVE' => $datos_reg_mat_edu_validados['comprobante_cve']);
              if (!empty($datos_reg_mat_edu_validados['comprobante'])) {//Si existe comprobante, manda el identificador
              $data_comprobante['idc'] = $this->seguridad->encrypt_base64($datos_reg_mat_edu_validados['comprobante_cve']);
              }
              $entidades_comprobante = array(enum_ecg::ctipo_comprobante);
              $data_comprobante['catalogos'] = carga_catalogos_generales($entidades_comprobante, null, null);
              $datos_mat_edu['formulario_carga_archivo'] = $this->load->view('template/formulario_carga_archivo', $data_comprobante, TRUE); */
            //**** fi de comprobante *******************************************
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
            //Carga datos de pie de página
            /* $datos_pie = array();
              $datos_pie['cve_mat_edu'] = $datos_post['material_edu_cve']; //Cve del material encriptado base64
              $datos_pie['cve_tp_mat_edu'] = $datos_post['ti_material_cve']; //Cve del material encriptado base64
              $datos_pie['comprobantecve'] = $datos_post['comprobantecve']; //Cve del material encriptado base64 */

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

    /*     * *********************************** Becas_ **************************** */

    public function seccion_becas_comisiones() {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $this->lang->load('interface', 'spanish');
            $string_values = array_merge($this->lang->line('interface')['becas_comisiones'], $this->lang->line('interface')['general']);
            $data['string_values'] = $string_values;
            $empleado = $this->obtener_id_empleado(); //Asignamos id usuario a variable
            if (!empty($empleado)) {//Si existe un empleado, obtenemos datos
                ////////Inicio agregar validaciones de estado
                $val_estado_val_bec = array('validation_estado' => array('table' => 'hist_beca_validacion_curso', 'fields' => 'VAL_CUR_EST_CVE', 'conditions' => 'hist_beca_validacion_curso.EMP_BECA_CVE=eb.EMP_BECA_CVE ', 'order' => 'VAL_CUR_FCH DESC', 'limit' => '1'));
                $val_estado_val_com = array('validation_estado' => array('table' => 'hist_comision_validacion_curso', 'fields' => 'VAL_CUR_EST_CVE', 'conditions' => 'hist_comision_validacion_curso.EMP_COMISION_CVE=ecm.EMP_COMISION_CVE ', 'order' => 'VAL_CUR_FCH DESC', 'limit' => '1'));
                /////////Fin agregar validaciones de estado
                $lista_becas = $this->bcl->get_lista_becas($empleado, $val_estado_val_bec);
                $lista_comisiones = $this->bcl->get_lista_comisiones($empleado, $val_estado_val_com);
                $data_becas['lista_becas'] = $lista_becas;
                $data_comision['lista_comisiones'] = $lista_comisiones;
                $data_becas['string_values'] = $string_values;
                $data_comision['string_values'] = $string_values;
                $data_becas['is_interseccion'] = $this->session->userdata('datos_validador')['is_interseccion']; //Para validar que no sea una intersección en becas 
                $data['cuerpo_becas'] = $this->load->view('validador_censo/becas_comisiones/becas_cuerpo', $data_becas, TRUE); //Valores que muestrán la lista
                $data_comision['is_interseccion'] = $this->session->userdata('datos_validador')['is_interseccion']; //Para validar que no sea una intersección en comisiones
                $data['cuerpo_comisiones'] = $this->load->view('validador_censo/becas_comisiones/comisiones_cuerpo', $data_comision, TRUE); //Valores que muestrán la lista
                $this->load->view('validador_censo/becas_comisiones/becas_comisiones_tpl', $data, FALSE); //Valores que muestrán la lista
                //Error, No existe el empleado
            }
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function get_form_comisiones() {
        if ($this->input->is_ajax_request()) {
            $this->lang->load('interface', 'spanish');
            $string_values = $this->lang->line('interface')['becas_comisiones']; //Carga textos a utilizar 
            $data_comisiones['string_values'] = $string_values; //Crea la variable
            $condiciones_ = array(enum_ecg::ctipo_comision => array('IS_COMISION_ACADEMICA = ' => 0)); //Sólo comisiones que no son academicas, es decir, puras comisiones laborales
            $entidades_ = array(enum_ecg::ctipo_comprobante, enum_ecg::ctipo_comision);
            $data_comisiones = carga_catalogos_generales($entidades_, $data_comisiones, $condiciones_);
            $datos_pie = array();
            //Todo lo de comprobante *******************************************
            $data_comprobante['string_values'] = $this->lang->line('interface')['general'];
            $entidades_comprobante = array(enum_ecg::ctipo_comprobante);
            $data_comprobante['catalogos'] = carga_catalogos_generales($entidades_comprobante, null, null);
            $data_comisiones['formulario_carga_archivo'] = $this->load->view('template/formulario_carga_archivo', $data_comprobante, TRUE);
            //**** fi de comprobante *******************************************

            $data = array(
                'titulo_modal' => $string_values['title_comisiones'],
                'cuerpo_modal' => $this->load->view('validador_censo/becas_comisiones/formulario_comisiones', $data_comisiones, TRUE),
                'pie_modal' => $this->load->view('validador_censo/becas_comisiones/comisiones_pie', $datos_pie, true)
            );
            echo $this->ventana_modal->carga_modal($data); //Carga los div de modal
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    private function analiza_validacion_becas_comisiones_laborales($array_validacion, $array_post, $name_entidad, $file = null) {
//        pr($array_post);
//        pr($array_validacion);
        $array_result = array();
        //Carga la entidad emp_beca o, emp_comision según sea el caso
        $insert_emp_entidad = $this->config->item($name_entidad);
//        pr($array_post);
        foreach ($array_post as $key => $value) {
            if (array_key_exists($key, $array_validacion)) {//Verifica existencia de la llave
                $array_result['validacion'][] = $array_validacion[$key];
            }
            if (array_key_exists($key, $insert_emp_entidad)) {//Verifica existencia de la llave
                //Nombres insert_emp_beca o, insert_emp_comision
                $array_result['insert_' . $name_entidad][$insert_emp_entidad[$key]['insert']] = $value;
            }
        }

        return $array_result;
    }

    private function filtrar_datos_becas_comisiones($array_datos, $name_entidad) {
        //emp_beca o emp_comision
        $array_tmp_campos_entidad = $this->config->item($name_entidad); //Obtiene los campos de la entidad "ctipo_material"

        foreach ($array_datos as $key => $value) {
            if (array_key_exists($key, $array_tmp_campos_entidad)) {//Verifica existencia de la llave en la entidad "emp_materia_educativo" para enviar los datos
                $array_datos_res[$key] = $array_datos[$key];
            }
        }

        $array_tmp_campos_entidad = $this->config->item('comprobante'); //Obtiene los campos de la entidad "emp_materia_educativo"
        foreach ($array_datos as $key => $value) {
            if (array_key_exists($key, $array_tmp_campos_entidad)) {//Verifica existencia de la llave en la entidad "emp_materia_educativo" para enviar los datos
                $array_datos_res[$key] = $array_datos[$key];
            }
        }
        return $array_datos_res;
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

    public function genera_array($array_validados, $datos_post, $array_campos) {
        $array_result = array();
        foreach ($datos_post as $keyp => $val) {
            switch ($keyp) {
                case '':
                    break;
                default :
                    $array_result[] = $array_validados[$keyp];
            }
        }
    }

    ///////////////////////////////////Inicio detalle de registros
    public function formacion_salud_detalle($identificador = null, $validar = null) {
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            $this->load->model('Formacion_model', 'fm');
            $this->lang->load('interface');
            $data['identificador'] = $identificador;
            $fs_id = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
            //$data['idc'] = $this->input->post('idc', true); //Campo necesario para mostrar link de comprobante
            $data['string_values'] = array_merge($this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['formacion_salud'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']);

            $data['dir_tes'] = $this->fm->get_formacion_salud(array('conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado(), 'FPCS_CVE' => $fs_id), 'fields' => 'emp_for_personal_continua_salud.*, ctipo_formacion_salud.TIP_FORM_SALUD_NOMBRE, csubtipo_formacion_salud.SUBTIP_NOMBRE, TIPO_COMPROBANTE_CVE'))[0]; //Obtener datos

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
            $data['tipo_comision'] = $tipo_comision;
            $data['identificador'] = $identificador;
            $tc_id = $this->seguridad->decrypt_base64($tipo_comision); //Identificador del tipo de comisión
            $ca_id = $this->seguridad->decrypt_base64($identificador); //Identificador de la comisión
            $validar = $this->input->get('dv'); //Bandera que habilita la validación
            //$data['idc'] = $this->input->post('idc', true); //Campo necesario para mostrar link de comprobante
            $data['string_values'] = array_merge($this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['comision_academica'], $this->lang->line('interface')['general'], $this->lang->line('interface')['error']);

            $config = $this->comision_academica_configuracion($tc_id, false);
            $data['catalogos'] = $config['catalogos'];

            $data['mostrar_hora_fecha_duracion'] = 0; //$this->get_valor_validacion($datos_formulario, 'duracion'); //Muestrá validaciones de hora y fecha de inicio y termino según la opción de duración

            $data['dir_tes'] = $this->ca->get_comision_academica(array(
                'conditions' => array('EMPLEADO_CVE' => $this->obtener_id_empleado(), 'EMP_COMISION_CVE' => $ca_id), 
                'fields' => 'emp_comision.*, comprobante.COM_NOMBRE, comprobante.TIPO_COMPROBANTE_CVE, '
                . 'ctipo_curso.TIP_CUR_NOMBRE, ccurso.CUR_NOMBRE, cnivel_academico.NIV_ACA_NOMBRE'))[0]; //Obtener datos

            $accion_general = $this->config->item('ACCION_GENERAL');
            if ($this->seguridad->decrypt_base64($validar) == $accion_general['VALIDAR']['valor']) { //En caso de que la acción almacenada
                $data = $this->validar_registro(array_merge($data, array(
                    'tipo_id' => 'COMISION_ACADEMICA', 'seccion_actualizar' => 'seccion_comision_academica', 
                    'identificador_registro' => $ca_id)));
            } else {
                $data['formulario_validacion'] = $this->historico_registro(array_merge($data, array(
                    'tipo_id' => 'COMISION_ACADEMICA', 'seccion_actualizar' => 'seccion_comision_academica', 
                    'identificador_registro' => $ca_id)));
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

    /**
     * Método que permite agregar formulario de validación a las ventanas que muestran la información del registro (curso, beca, comisión, etc.)
     * seccion_actualizar       Sección que se actualizará al cierre del modal
     * tipo_id                  Obtener tabla y campo donde se almacenará
     * identificador_registro   Identificador del registro (curso, beca, comisión, etc) a validar
     */
    private function validar_registro($data) {
        $this->load->helper('date');
        $this->load->model('Validacion_docente_model', 'vd');
        $tipo_id = $data['tipo_id']; //Definido en archivo de configuración general. Arreglo que contiene tablas y campo para la actualización de datos
        $data['tipo'] = $this->seguridad->encrypt_base64($tipo_id);
        $tipo_validacion = $this->config->item('TABLAS')[$tipo_id]; ///Obtener tabla y campo donde se almacenará

        $validacion_cve = $this->obtener_id_validacion(); //Se obtiene identificador de la validación de sesión

        $entidades_ = array(enum_ecg::cvalidacion_curso_estado); //Obtener catálogo de estados para la validación de cada curso
        $data['catalogos'] = carga_catalogos_generales($entidades_, null, null);

        ///Obtener validación del curso
        $data['registro_validado'] = $this->vd->get_validacion_registro(array('conditions' => array("{$tipo_validacion['tabla_validacion']}.validacion_cve" => $validacion_cve, "{$tipo_validacion['campo']}" => $data['identificador_registro']), 'table' => $tipo_validacion['tabla_validacion'], 'order' => 'VAL_CUR_FCH DESC'));

        $data['formulario_validacion'] = $this->load->view('validador_censo/validacion_formulario', $data, TRUE);

        return $data;
    }

    private function historico_registro($data) {
        $tipo_id = $data['tipo_id']; //Definido en archivo de configuración general. Arreglo que contiene tablas y campo para la actualización de datos
        $data['tipo'] = $this->seguridad->encrypt_base64($tipo_id);
        return $this->load->view('validador_censo/validacion_listado', $data, TRUE);
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

    ///////////////////////////////////Fin detalle de registros

    /**
     * Método que almacena la validación del censo, registro por registro(curso, beca, comisión, etc.)
     * @autor       : Jesús Z. Díaz P.
     * @modified    :
     * @access      : public
     */
    public function validar_censo_registro($identificador_registro = null, $identificador_validacion = null) {
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if ($this->input->post()) { //Validar si se recibió información
                $this->lang->load('interface');
                $string_values = array_merge($this->lang->line('interface')['validador_censo'], $this->lang->line('interface')['general']);
                $resultado = array('result' => false, 'msg' => '', 'id' => '');
                $tipo = $this->input->get('tipo'); //Tipo de tabla a utilizar

                if (!is_null($identificador_registro) && !is_null($tipo)) {
                    $data['identificador_registro'] = $identificador_registro;
                    $data['identificador_validacion'] = $identificador_validacion;
                    $registro_id = $this->seguridad->decrypt_base64($identificador_registro); //Identificador del registro
                    $validacion_id = (!is_null($identificador_validacion)) ? $this->seguridad->decrypt_base64($identificador_validacion) : $identificador_validacion; //Identificador del registro
                    //pr($_SESSION);
                    if (!is_null($this->input->post()) && !empty($this->input->post())) { //Se verifica que se haya recibido información por método post
                        $validacion_cve = $this->obtener_id_validacion(); ///Obtener de sesión el identificador de la validación que se esta editando
                        //$validacion_gral_cve = $this->session->userdata('validacion_gral_cve'); ///Obtener de sesión el identificador de la validación que se esta editando
                        $data['formulario'] = $this->input->post(null, true); //Se limpian y obtienen datos

                        $this->config->load('form_validation'); //Cargar archivo con validaciones
                        $validations = $this->config->item('form_validacion_registro'); //Obtener validaciones de archivo general
                        $this->form_validation->set_rules($validations); //Añadir validaciones
                        $cvalidacion_curso_estado = $this->config->item('cvalidacion_curso_estado');

                        //////Agregar validación de comentario, si el estado elegido es no valido o en corrección
                        if (in_array($data['formulario']['estado_validacion'], array($cvalidacion_curso_estado['NO_VALIDO']['id'], $cvalidacion_curso_estado['CORRECCION']['id']))) {
                            $this->form_validation->set_rules('comentario', 'Comentario', 'required');
                        }

                        if ($this->form_validation->run() == TRUE) { //Validar datos
                            $tipo_id = $this->seguridad->decrypt_base64($tipo); //Identificador del tipo
                            $tipo_validacion = $this->config->item('TABLAS')[$tipo_id]; ///Obtener tabla y campo donde se almacenará
                            $validacion_registro = $this->validacion_registro_vo(array_merge($data['formulario'], array('validacion_cve' => $validacion_cve, 'registro' => $registro_id, 'tipo_validacion' => $tipo_validacion))); //'validacion_gral_cve' => $validacion_gral_cve
                            //$this->vdm->get_validacion_registro(array('table'=>$tipo_validacion['tabla_validacion'], 'conditions'=>''));
                            if (is_null($identificador_validacion)) {
                                $resultado_almacenado = $this->vdm->insert_validacion_registro($tipo_validacion['tabla_validacion'], $validacion_registro);
                                $resultado['id'] = $this->seguridad->encrypt_base64($resultado_almacenado['data']['identificador']);
                                $validacion_id = $resultado_almacenado['data']['identificador'];
                            } else {
                                $resultado_almacenado = $this->vdm->update_validacion_registro(array('HIST_VAL_CURSO_CVE' => $validacion_id), $tipo_validacion['tabla_validacion'], $validacion_registro);
                            }

                            if ($resultado_almacenado['result'] == true) {
                                $this->cambiar_estado_revision_validador(array('HIST_VAL_CURSO_CVE' => $validacion_id), $tipo_validacion['tabla_validacion'], $validacion_registro); //Cambiar estado de validación 'Por validar' a 'Revisión'.
                                $resultado['result'] = true;
                                $resultado['msg'] = $string_values['datos_almacenados_correctamente'];
                            } else {
                                $resultado['msg'] = $resultado_almacenado['msg'];
                            }
                            //pr($validacion_registro);
                            //pr($resultado_almacenado);
                        } else {
                            $resultado['msg'] = validation_errors();
                        }
                    } else {
                        $resultado['msg'] = $string_values['error_datos_enviados'];
                    }
                } else {
                    $resultado['msg'] = $string_values['error_datos_enviados'];
                }
                //echo imprimir_resultado($resultado); ///Muestra mensaje
                //pr($_POST); //pr($_SESSION);
                //pr($data);
                echo json_encode($resultado);
            }
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    private function actualizar_estado_validar_a_revision($validacion_id, $tabla_validacion, $validacion_registro, $VALIDADOR_CVE) { //$validacion_id, $tabla_validacion, $validacion_registro
        $estado_validacion_actual = $this->session->userdata('datosvalidadoactual')['est_val'];
        if ($this->config->item('estados_val_censo')[$estado_validacion_actual]['cambiar_estado_revision'] === true) { //Actualizar registro una vez que se realizó el cambio de estado del método anterior
            $validacion_registro->VALIDACION_CVE = $VALIDADOR_CVE;
            $actualizar_registro = $this->vdm->update_validacion_registro($validacion_id, $tabla_validacion, $validacion_registro);
        }
    }

    ////////////////////////Inicio Factory de validación
    private function validacion_registro_vo($validacion) {
        $val = new Validacion_registro_dao;
        $val->VALIDACION_CVE = (isset($validacion['validacion_cve']) && !empty($validacion['validacion_cve'])) ? $validacion['validacion_cve'] : NULL;
        $val->VAL_CUR_EST_CVE = (isset($validacion['estado_validacion']) && !empty($validacion['estado_validacion'])) ? $validacion['estado_validacion'] : NULL;
        $val->VAL_CUR_COMENTARIO = (isset($validacion['comentario']) && !empty($validacion['comentario'])) ? $validacion['comentario'] : NULL;
        //$val->VAL_CUR_FCH = (isset($validacion['fecha']) && !empty($validacion['fecha'])) ? $validacion['fecha'] : NULL;
        $val->{$validacion['tipo_validacion']['campo']} = $validacion['registro'];

        return $val;
    }

}

class Validacion_registro_dao {

    //public $HIST_VAL_CURSO_CVE;
    public $VALIDACION_CVE;
    public $VAL_CUR_EST_CVE;
    public $VAL_CUR_COMENTARIO;

    //public $VAL_CUR_FCH;
    //public $EMP_COMISION_CVE;
}

class Emp_comision_dao {

    //public $EMP_COMISION_CVE;
    public $EMPLEADO_CVE;
    public $TIP_COMISION_CVE;
    public $COMPROBANTE_CVE;

}

class Direccion_tesis_dao extends Emp_comision_dao {

    public $EC_ANIO;
    public $COM_AREA_CVE;
    public $NIV_ACADEMICO_CVE;

}

class Comite_educacion_dao extends Emp_comision_dao {

    public $EC_ANIO;
    public $TIP_CURSO_CVE;

}

class Sinodal_examen_dao extends Emp_comision_dao {

    public $EC_ANIO;
    public $NIV_ACADEMICO_CVE;

}

class Coordinador_tutores_dao extends Emp_comision_dao {

    public $EC_ANIO;
    public $EC_FCH_INICIO;
    public $EC_FCH_FIN;
    public $EC_DURACION;
    public $TIP_CURSO_CVE;
    public $CURSO_CVE;

}

class Coordinador_curso_dao extends Emp_comision_dao {

    public $EC_ANIO;
    public $EC_FCH_INICIO;
    public $EC_FCH_FIN;
    public $EC_DURACION;
    public $TIP_CURSO_CVE;
    public $CURSO_CVE;

}

class Formacion_salud_dao {

    //public $FPCS_CVE;
    public $EMPLEADO_CVE;
    public $COMPROBANTE_CVE;
    public $EFPCS_FCH_INICIO;
    public $EFPCS_FCH_FIN;
    public $EFPCS_FOR_INICIAL;
    public $TIP_FORM_SALUD_CVE;
    public $CSUBTIP_FORM_SALUD_CVE;

}

class Formacion_docente_dao {

    //public $EMP_FORMACION_PROFESIONAL_CVE;
    public $EMPLEADO_CVE;
    public $COMPROBANTE_CVE;
    public $EFP_DURACION;
    public $MODALIDAD_CVE;
    public $INS_AVALA_CVE;
    public $EFP_FCH_INICIO;
    public $EFP_FCH_FIN;
    public $CURSO_CVE;
    public $TIP_FOR_PROF_CVE;
    public $SUB_FOR_PRO_CVE;
    public $EFO_ANIO_CURSO;
    public $EFP_NOMBRE_CURSO;

}

class Formacion_docente_tematica_dao {

    //public $RFORM_PROF_TEMATICA_CVE;
    public $TEMATICA_CVE;
    public $EMP_FORMACION_PROFESIONAL_CVE;

}
