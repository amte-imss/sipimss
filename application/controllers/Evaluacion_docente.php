<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona la evaluación docente por parte del grupo.
 * @version 	: 1.0.0
 * @author      : Jesús Z. Díaz P.
 * */
class Evaluacion_docente extends MY_Controller {
    /*     * *********Costructor
     * Función inicial que carga los elementos utilizados en todos los métodos de la clase
     */
    function __construct() {
        parent::__construct();
        $this->load->library('form_complete');
        /*$this->load->library('form_validation');*/
        $this->load->library('seguridad');
        $this->load->model('evaluacion_docente_model','eval_doce_model');
        $this->lang->load('interface_evaluacion');
        $this->load->helper('date');
        $this->lang->load('interface');
        //pr($_SESSION);
        //$this->session->set_userdata('rol_seleccionado_cve', '8');
    }

    /** 
     * Búsqueda y listado de convocatorias de evaluación
     * @method: void index()
     * @author: Jesús Z. Díaz P.
     */
    /*public function index() {
        $main_content = null;
        $datos = array();
        $anio_actual = $this->anio_actual(); //Obtener año seleccionado para mostrar convocatorias
        $datos['string_values'] = array_merge($this->lang->line('interface_evaluacion')['evaluacion'], $this->lang->line('interface_evaluacion')['general']); //Cargar textos utilizados en vista
        //pr($_SESSION);
        $empleado_cve = $this->session->userdata('idempleado'); //Identificador de usuario logueado
        
        ////Obtener listado de evaluaciones de acuerdo al año seleccionado
        $datos['dictamen'] = $this->eval_doce_model->get_evaluacion_docente(array('conditions'=>"EMPLEADO_CVE='".$empleado_cve."'"));
        
        $main_content = $this->load->view('evaluacion/evaluacion_docente/listado', $datos, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
        //pr($datos);
        //exit();
    }*/

    public function index(){
        $main_content = null;
        $datos = array();

        if($this->validar_evaluador()){
            $dictamen = $this->eval_doce_model->get_dictamen(array('conditions'=>"DATE_FORMAT(now(),'%y-%m-%d') between FCH_INICIO_EVALUACION and FCH_FIN_EVALUACION")); ////Obtener listado de solicitudes a evaluar de acuerdo a convocatoria activa
            if(!empty($dictamen)){ //Agregar dictamen a sesión
                $datos['dictamen'] = $dictamen;
            } else {
                $dictamen[0]['ADMIN_DICTAMEN_EVA_CVE'] = 0;
            }
            $this->session->set_userdata(array('dictamen'=>$dictamen[0]));

            $datos['string_values'] = array_merge($this->lang->line('interface_evaluacion')['evaluacion']['dictamen'], $this->lang->line('interface_evaluacion')['evaluacion']['docente'], $this->lang->line('interface_evaluacion')['general']); //Cargar textos utilizados en vista
            $datos['order_columns'] = array('empleado.EMP_MATRICULA' => $datos['string_values']['matricula_docente'], 'empleado.EMP_NOMBRE' => $datos['string_values']['nombre_docente']);
            //pr($datos);
            $main_content = $this->load->view('evaluacion/evaluacion_docente/evaluacion_formulario', $datos, true);
            /*$this->template->setMainContent($main_content);
            $this->template->getTemplate();*/
            $this->template->setTitle($datos['string_values']["titulo"]);
            $this->template->setMainTitle($datos['string_values']["titulo"]);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate(FALSE,'template/sipimss/index.tpl.php');
        }
    }

    public function revisar(){
        $main_content = null;
        $datos = array();

        if($this->validar_evaluador()){
            $dictamen = $this->eval_doce_model->get_dictamen(array('conditions'=>"DATE_FORMAT(now(),'%y-%m-%d') between FCH_INICIO_EVALUACION and FCH_FIN_EVALUACION")); ////Obtener listado de solicitudes a evaluar de acuerdo a convocatoria activa
            if(!empty($dictamen)){ //Agregar dictamen a sesión
                $datos['dictamen'] = $dictamen;
            } else {
                $dictamen[0]['ADMIN_DICTAMEN_EVA_CVE'] = 0;
            }
            $this->session->set_userdata(array('dictamen'=>$dictamen[0]));

            $datos['string_values'] = array_merge($this->lang->line('interface_evaluacion')['evaluacion']['dictamen'], $this->lang->line('interface_evaluacion')['evaluacion']['docente'], $this->lang->line('interface_evaluacion')['general']); //Cargar textos utilizados en vista
            $datos['order_columns'] = array('empleado.EMP_MATRICULA' => $datos['string_values']['matricula_docente'], 'empleado.EMP_NOMBRE' => $datos['string_values']['nombre_docente']);
            //pr($datos);
            $main_content = $this->load->view('evaluacion/evaluacion_docente/evaluacion_revisar_formulario', $datos, true);
            /*$this->template->setMainContent($main_content);
            $this->template->getTemplate();*/
            $this->template->setTitle($datos['string_values']["titulo"]);
            $this->template->setMainTitle($datos['string_values']["titulo"]);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate(FALSE,'template/sipimss/index.tpl.php');
        }
    }

    public function buscar_docentes_evaluacion_revisar($identificador = null){
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) {
                $datos_busqueda = $this->input->post(null, true); //Datos del formulario se envían para generar la consulta
                $condition_extra = array();
                if(isset($datos_busqueda['menu_busqueda']) && !empty($datos_busqueda['menu_busqueda'])) {
                    switch ($datos_busqueda['menu_busqueda']) {
                        case 'matricula':
                            $condition_extra = "AND emp_matricula like '%".$datos_busqueda['buscador_docente']."%'";
                            break;                        
                        case 'nombre':
                            $condition_extra = "AND (EMP_NOMBRE like '%".$datos_busqueda['buscador_docente']."%' OR EMP_APE_PATERNO like '%".$datos_busqueda['buscador_docente']."%' OR EMP_APE_MATERNO like '%".$datos_busqueda['buscador_docente']."%')";
                            break;
                    }
                }
                $datos_busqueda['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0; //Registro actual, donde inicia la visualización de registros
                $datos_busqueda['conditions'] = 'evaluacion_solicitud.CESE_CVE >='.Enum_es::Envio_evaluacion.' AND ADMIN_DICTAMEN_EVA_CVE='.$this->obtener_id_dictamen().' '.$condition_extra;
                //$datos_busqueda['fields'] = "if(evaluacion_solicitud.CESE_CVE=".Enum_es::Envio_evaluacion.", (select EST_EVALUACION_CVE from hist_evaluacion_dic where hist_evaluacion_dic.SOLICITUD_VAL_CVE=evaluacion_solicitud.VALIDACION_CVE AND IS_ACTUAL=".$this->config->item('IS_ACTUAL')." AND EVALUADOR_CVE=".$this->obtener_id_evaluador()."), 0) AS estado, evaluacion_solicitud.*, cestado_solicitud_evauacion.CESE_NOMBRE, empleado.*, DEL_NOMBRE, nom_categoria";
                $datos_busqueda['fields'] = "evaluacion_solicitud.*, cestado_solicitud_evauacion.CESE_NOMBRE, empleado.*, DEL_NOMBRE, nom_categoria";
                
                $datos['evaluacion'] = $this->eval_doce_model->get_evaluacion_docente($datos_busqueda); ////Obtener listado de evaluaciones de acuerdo al año seleccionado
                foreach ($datos['evaluacion']['data'] as $key_ev => $evaluacion) {
                    $datos['evaluacion']['data'][$key_ev]['estados'] = $this->eval_doce_model->get_hist_evaluacion_dic(array('conditions'=>"SOLICITUD_VAL_CVE=".$evaluacion['VALIDACION_CVE']." AND hist_evaluacion_dic.IS_ACTUAL=".$this->config->item('IS_ACTUAL'), 'order'=>'ROL_NOMBRE'));
                }
                $datos['evaluacion']['string_values'] = array_merge($this->lang->line('interface_evaluacion')['evaluacion']['dictamen'], $this->lang->line('interface_evaluacion')['evaluacion']['docente'], $this->lang->line('interface_evaluacion')['general']); //Cargar textos utilizados en vista

                $datos['evaluacion']['current_row'] = $datos_busqueda['current_row'];
                $datos['evaluacion']['per_page'] = $this->input->post('per_page'); //Número de registros a mostrar por página
                
                $this->resultado_listado($datos['evaluacion'], array('form_recurso'=>'#form_search', 'elemento_resultado'=>'#resultado_busqueda', 'view'=>'evaluacion/evaluacion_docente/resultado_busqueda_revisar')); //Generar listado en caso de obtener datos
            }
        } else {
            redirect(site_url());
        }
    }

    public function seccion_index(){
        if ($this->input->is_ajax_request()) {
            if (!is_null($this->input->post())) {
                $filtros = $this->input->post(null, true); //Obtenemos el post o los valores
                //$rol_seleccionado = $this->session->userdata('rol_seleccionado'); //Rol seleccionado de la pantalla de roles
                //$array_menu = get_busca_hijos($rol_seleccionado, $this->uri->segment(1)); //Busca todos los hijos de validador para que generé el menú y cargue los datos de perfil
                //$datosPerfil['array_menu'] = $array_menu;
                $datos_validacion = array();
                //$datos_validacion['estado_correccion'] = null;

                if (!empty($filtros['empcve'])) {
                    $datos_validacion['empleado_cve'] = $this->seguridad->decrypt_base64($filtros['empcve']); //Identificador de la comisión
                }
                if (!empty($filtros['matricula'])) {
                    $datos_validacion['matricula'] = $this->seguridad->decrypt_base64($filtros['matricula']); //Identificador de la comisión
                }
                if (!empty($filtros['estval'])) {
                    $datos_validacion['est_val'] = $this->seguridad->decrypt_base64($filtros['estval']); //Identificador de la comisión
                }
                /*if (!empty($filtros['usuariocve'])) {
                    $datos_validacion['validador_cve'] = $this->seguridad->decrypt_base64($filtros['usuariocve']); //Identificador de la comisión
                }
                if (!empty($filtros['histvalcve'])) {
                    $datos_validacion['validacion_cve'] = $this->seguridad->decrypt_base64($filtros['histvalcve']); //Identificador de la comisión
                }*/
                if (!empty($filtros['solicitud_cve'])) {
                    $datos_validacion['solicitud_cve'] = $this->seguridad->decrypt_base64($filtros['solicitud_cve']); //Identificador de la comisión
                }
                /*if (!empty($filtros['valgrlcve'])) {
                    $datos_validacion['val_grl_cve'] = $this->seguridad->decrypt_base64($filtros['valgrlcve']); //Identificador de la comisión
                    /////Inicio estado corrección. Obtener si el empleado ya cuenta con validación en estado corrección
                    $datos_validacion['estado'] = $this->obtener_validacion_correccion($datos_validacion['val_grl_cve'], $datos_validacion['est_val']);
                    ////Fin obtener estado corrección
                }*/
                if (!empty($filtros['usuario_cve'])) {
                    $datos_validacion['usuario_cve_validado'] = $this->seguridad->decrypt_base64($filtros['usuario_cve']); //Identificador de la comisión
                }
                $datos_hist_evaluacion_dic = $this->eval_doce_model->get_hist_evaluacion_dic(array('conditions'=>array('SOLICITUD_VAL_CVE'=>$datos_validacion['solicitud_cve'],
                    'hist_evaluacion_dic.IS_ACTUAL'=>$this->config->item('IS_ACTUAL'), 'EVALUADOR_CVE'=>$this->obtener_id_evaluador())));
                //pr($datos_hist_evaluacion_dic);
                $datos_validacion['HIST_EVALUACION_CVE'] = $datos_validacion['EST_EVALUACION_CVE'] = null;
                if(!empty($datos_hist_evaluacion_dic)){
                    $datos_validacion['HIST_EVALUACION_CVE'] = $datos_hist_evaluacion_dic[0]['HIST_EVALUACION_CVE'];
                    $datos_validacion['EST_EVALUACION_CVE'] = $datos_hist_evaluacion_dic[0]['EST_EVALUACION_CVE'];
                }
                //Manda el identificador de la delegación del usuario
                $this->session->set_userdata('evaluacion', $datos_validacion); //Asigna la información del usuario al que se va a validar
                //pr($_SESSION);
                $this->load->model("Expediente_model","expediente");
                /*$conditions = array(Enum_sec::B_COMISIONES_ACADEMICAS=>array('emp_comision.TIP_COMISION_CVE !=' => $this->config->item('tipo_comision')['DIRECCION_TESIS']['id'], 'IS_COMISION_ACADEMICA' => '1'),
                    Enum_sec::B_DIRECCION_TESIS=>array('emp_comision.TIP_COMISION_CVE' => $this->config->item('tipo_comision')['DIRECCION_TESIS']['id']));
                $datosPerfil = $this->expediente->getAll($this->obtener_id_empleado(), null, $conditions);*/
                //pr($_SESSION);
                $conditions = array('conditions'=>array('HIST_EVALUACION_CVE'=>$this->session->userdata('evaluacion')['HIST_EVALUACION_CVE'],
                    'EVALUACION_CVE'=>$this->session->userdata('evaluacion')['solicitud_cve'], 
                    'EVALUADOR_CVE'=>$this->session->userdata('evaluador')['ROL_EVALUADOR_CVE']));
                $datosPerfil = $this->obtener_secciones_evaluacion($datos_validacion['empleado_cve'], $datos_validacion['solicitud_cve'], $conditions);
                //pr($datosPerfil);
                $entidades_ = array(enum_ecg::cseccion);
                //$condiciones_ = array(enum_ecg::ccurso => array('TIP_CURSO_CVE' => $tipo_curso));
                $datosPerfil['catalogos'] = carga_catalogos_generales($entidades_, null, null);
                $datosPerfil['catalogos']['EVA_CUR_VALIDO'] = dropdown_options($this->config->item('EVA_CUR_VALIDO'), 'id', 'value');
                $interface = $this->lang->line('interface');
                $datosPerfil['string_values'] = array_merge($this->lang->line('interface_evaluacion')['evaluacion']['dictamen'], $this->lang->line('interface_evaluacion')['evaluacion']['docente'], $this->lang->line('interface_evaluacion')['general'], $interface['evaluacion_curricular_validar'], $interface['bloques']);
                //pr($datosPerfil);
                //echo $main_content = $this->load->view('solicitar_evaluacion/index.tpl.php',$data, true);

                echo $this->load->view('evaluacion/evaluacion_docente/listado_cursos', $datosPerfil, true);
            }
        } else {
            redirect(site_url());
        }
    }

    public function seccion_revisar_index(){
        if ($this->input->is_ajax_request()) {
            if (!is_null($this->input->post())) {
                $filtros = $this->input->post(null, true); //Obtenemos el post o los valores
                $datos_validacion = array();

                if (!empty($filtros['empcve'])) {
                    $datos_validacion['empleado_cve'] = $this->seguridad->decrypt_base64($filtros['empcve']); //Identificador de la comisión
                }
                if (!empty($filtros['matricula'])) {
                    $datos_validacion['matricula'] = $this->seguridad->decrypt_base64($filtros['matricula']); //Identificador de la comisión
                }
                if (!empty($filtros['estval'])) {
                    $datos_validacion['est_val'] = $this->seguridad->decrypt_base64($filtros['estval']); //Identificador de la comisión
                }
                if (!empty($filtros['solicitud_cve'])) {
                    $datos_validacion['solicitud_cve'] = $this->seguridad->decrypt_base64($filtros['solicitud_cve']); //Identificador de la comisión
                }
                if (!empty($filtros['usuario_cve'])) {
                    $datos_validacion['usuario_cve_validado'] = $this->seguridad->decrypt_base64($filtros['usuario_cve']); //Identificador de la comisión
                }
                $datos_hist_evaluacion_dic = $this->eval_doce_model->get_hist_evaluacion_dic(array('conditions'=>array('SOLICITUD_VAL_CVE'=>$datos_validacion['solicitud_cve'],
                    'hist_evaluacion_dic.IS_ACTUAL'=>$this->config->item('IS_ACTUAL'))));
                //pr($datos_hist_evaluacion_dic);
                //$datos_validacion['HIST_EVALUACION_CVE'] = $datos_validacion['EST_EVALUACION_CVE'] = null;
                if(!empty($datos_hist_evaluacion_dic)){
                    /*$datos_validacion['HIST_EVALUACION_CVE'] = $datos_hist_evaluacion_dic[0]['HIST_EVALUACION_CVE'];
                    $datos_validacion['EST_EVALUACION_CVE'] = $datos_hist_evaluacion_dic[0]['EST_EVALUACION_CVE'];*/
                    foreach ($datos_hist_evaluacion_dic as $key_dhed => $dhed) {
                        $datos_validacion['hist_evaluacion'] = $datos_hist_evaluacion_dic;
                    }                    
                }
                //Manda el identificador de la delegación del usuario
                $this->session->set_userdata('evaluacion', $datos_validacion); //Asigna la información del usuario al que se va a validar
                //pr($_SESSION);
                $this->load->model("Expediente_model","expediente");
                
                /*$conditions = array('conditions'=>array('HIST_EVALUACION_CVE'=>$this->session->userdata('evaluacion')['HIST_EVALUACION_CVE'],
                    'EVALUACION_CVE'=>$this->session->userdata('evaluacion')['solicitud_cve'], 
                    'EVALUADOR_CVE'=>$this->session->userdata('evaluador')['ROL_EVALUADOR_CVE']));*/
                $conditions = array('conditions'=>array('EVALUACION_CVE'=>$this->session->userdata('evaluacion')['solicitud_cve']));
                $datosPerfil = $this->obtener_secciones_evaluacion($datos_validacion['empleado_cve'], $datos_validacion['solicitud_cve'], $conditions);
                //pr($_SESSION);
                $entidades_ = array(enum_ecg::cseccion);
                //$condiciones_ = array(enum_ecg::ccurso => array('TIP_CURSO_CVE' => $tipo_curso));
                $datosPerfil['catalogos'] = carga_catalogos_generales($entidades_, null, null);
                $datosPerfil['catalogos']['EVA_CUR_VALIDO'] = dropdown_options($this->config->item('EVA_CUR_VALIDO'), 'id', 'value');
                $interface = $this->lang->line('interface');
                $datosPerfil['string_values'] = array_merge($this->lang->line('interface_evaluacion')['evaluacion']['dictamen'], $this->lang->line('interface_evaluacion')['evaluacion']['docente'], $this->lang->line('interface_evaluacion')['general'], $interface['evaluacion_curricular_validar'], $interface['bloques']);
                
                echo $this->load->view('evaluacion/evaluacion_docente/listado_revisar_cursos', $datosPerfil, true);
            }
        } else {
            redirect(site_url());
        }
    }

    private function obtener_secciones_evaluacion($empleado_cve = null, $solicitud_cve = null, $conditions = null) {
        if (is_null($solicitud_cve) OR is_null($empleado_cve)) {
            return array();
        }
        $actividad_curso_validado = array();
        //Obtener todos los registros almacenados en actividades del censo, docentes
        $this->load->model('Expediente_model', 'exp'); //Modelo clase que contiene todos los datos de las secciones
        $this->load->model('Evaluacion_curricular_validar_model', 'ecvm');
        $info_docente = $this->exp->getAll($empleado_cve, true); //Resultado
        $info_cursos_evaluados = $this->exp->getAllEvaluacion($conditions);
        //pr($info_cursos_evaluados);
        $acro_b = 'bloque_';
        $acro_s = 'seccion_';
        $emp_bloques_seccion = $info_docente['bloques'];
        $datos_curso = $info_docente['cfg_actividad'];

        //Obtiene
        $cursos_s_evaluar = $this->ecvm->get_cursos_validar_evaluar($solicitud_cve);//Cursos a evaluar
        $cursos_bloques = obtener_cursos_bloque_seccion_evaluacion($info_docente['bloques'], $info_docente['cfg_actividad'], $cursos_s_evaluar);//Depuración de cursos
        //pr($info_cursos_evaluados);
        //pr($cursos_s_evaluar);
        //pr($solicitud_cve);
        $datos_tabla['array_menu'] = $cursos_bloques;
        $datos_tabla['info_actividad'] = $info_docente['cfg_actividad'];
        $datos_tabla['string_value_seccion'] = $info_docente['string_value'];
        $datos_tabla['empleado'] = $info_docente['empleado'];
        $datos_tabla['labels_bloque'] = $info_docente['bloques']['labels_bloque'];
        $datos_tabla['labels_seccion'] = $info_docente['bloques']['labels'];
        $datos_tabla['info_cursos_evaluados'] = $info_cursos_evaluados;
        //pr($datos_tabla);
        return $datos_tabla;
    }

    public function guardar_puntos_registro(){
        if ($this->input->is_ajax_request()) {
            if (!is_null($this->input->post())) {
                $this->load->model('Expediente_model', 'exp'); //Modelo clase que contiene todos los datos de las secciones

                $data = $this->input->post(null, true); //Obtenemos el post o los valores
                $eva = new Evaluacion_curso;
                $eva->EVA_CUR_VALIDO = (isset($data['valido']) && !empty($data['valido'])) ? $data['valido'] : NULL;
                $eva->EVA_CUR_PUNTOS_CURSO = (isset($data['puntos']) && !empty($data['puntos'])) ? $data['puntos'] : NULL;
                $eva->EVALUADOR_CVE = $this->session->userdata('evaluador')['ROL_EVALUADOR_CVE'];
                $eva->EVA_CUR_CATEGORIA = (isset($data['categoria']) && !empty($data['categoria'])) ? $data['categoria'] : NULL;
                $eva->EVA_CUR_MSG_RE_EVALUACION = (isset($data['msg_re_evaluacion']) && !empty($data['msg_re_evaluacion'])) ? $data['msg_re_evaluacion'] : NULL;
                $eva->EVA_CUR_PUNTOS_CURSO_ORIGINAL = (isset($data['puntos']) && !empty($data['puntos'])) ? $data['puntos'] : NULL;
                $eva->EVALUACION_CVE = $this->session->userdata('evaluacion')['solicitud_cve'];
                $eva->HIST_EVALUACION_CVE = $this->session->userdata('evaluacion')['HIST_EVALUACION_CVE'];
                $eva->SECCION_CVE = (isset($data['seccion_dictamen']) && !empty($data['seccion_dictamen'])) ? $data['seccion_dictamen'] : NULL;
                //pr($_SESSION); //pr($data); exit();
                //pr($eva);
                if(isset($data['data_eva_curso']) && !empty($data['data_eva_curso'])){ //Actualización
                    $resultado_almacenado = $this->exp->update_evaluacion_curso($eva, $data);
                    $resultado_almacenado['accion'] = 'U';
                } else { //Inserción
                    $resultado_almacenado = $this->exp->insert_evaluacion_curso($eva, $data);
                    $resultado_almacenado['accion'] = 'I';
                }
                $this->actualizar_estado_evaluacion(); //Actualiza el estado de la solicitud en el primer intento de actualización 

                echo json_encode($resultado_almacenado);
                exit();
            }
        } else {
            redirect(site_url());
        }
    }

    public function finalizar_evaluacion(){
        if ($this->input->is_ajax_request()) {
            //$resultado = array('result'=>FALSE, 'msg'=>'', 'data'=>null);
            ////////////////////////////////////////////////////
            /////////Agregar validación de faltantes por validar
            ////////////////////////////////////////////////////
            /*pr($_SESSION);
            exit();*/
            $this->eval_doce_model->update_hist_evaluacion_dic(array('EST_EVALUACION_CVE'=>Enum_eei::Completa), array('conditions'=>array('HIST_EVALUACION_CVE'=>$this->session->userdata('evaluacion')['HIST_EVALUACION_CVE'])));
            $tmp_ses = $this->session->userdata('evaluacion');
            $tmp_ses['EST_EVALUACION_CVE'] = Enum_eei::Completa;
            $this->session->set_userdata(array('evaluacion'=>$tmp_ses));
            $resultado['result'] = true;
            $string_value = $this->lang->line('interface_evaluacion')['evaluacion']['dictamen'];
            $resultado['msg'] = $string_value['terminar_evaluacion'];
            echo json_encode($resultado);
            exit();
        } else {
            redirect(site_url());
        }
    }

    public function actualizar_estado_evaluacion(){
        if($this->session->userdata('evaluacion')['est_val'] == Enum_es::Envio_evaluacion){
            $this->eval_doce_model->update_evaluacion_curso(array('CESE_CVE'=>Enum_es::Evaluacion), array('conditions'=>array('VALIDACION_CVE'=>$this->session->userdata('evaluacion')['solicitud_cve'])));
            $this->eval_doce_model->update_hist_evaluacion_dic(array('EST_EVALUACION_CVE'=>Enum_eei::Revision), array('conditions'=>array('HIST_EVALUACION_CVE'=>$this->session->userdata('evaluacion')['HIST_EVALUACION_CVE'])));
            $tmp_ses = $this->session->userdata('evaluacion');
            $tmp_ses['est_val'] = Enum_es::Evaluacion;
            $tmp_ses['EST_EVALUACION_CVE'] = Enum_eei::Revision;
            $this->session->set_userdata(array('evaluacion'=>$tmp_ses));
        }
    }

    public function seccion_delete_datos_validado() {
        if ($this->input->is_ajax_request()) {
            $this->delete_datos_validado(); //Elimina los datos de empleado validado, si se encuentran los datos almacenados en la variable de sesión
        } else {
            redirect(site_url());
        }
    }

    /*
     * Permite evaluar
    */
    private function validar_evaluador(){
        $evaluador = $this->eval_doce_model->get_evaluador(array('conditions'=>array('IS_ACTUAL'=>1, 'EMPLEADO_CVE'=>$this->obtener_id_empleado(), 'ROL_CVE'=>$this->session->userdata('rol_seleccionado_cve'))));
        //pr($evaluador);
        //pr($_SESSION);
        if(count($evaluador)==0){
            $main_content = "<div>".$this->lang->line('interface_evaluacion')['evaluacion']['docente']['permiso_acceso']."</div>";
            $this->template->setMainContent($main_content);
            $this->template->getTemplate(FALSE,'template/sipimss/index.tpl.php');
            return FALSE;
        } else {
            if(!isset($evaluador[0]['EVALUADOR_CVE'])){
                $evaluador[0]['EVALUADOR_CVE'] = $evaluador[0]['ROL_EVALUADOR_CVE'];
            }
            $this->session->set_userdata(array('evaluador'=>$evaluador[0])); //Agregar evaluador a sesión
        }
        //pr($evaluador);
        return TRUE;
    }
    
    public function buscar_docentes_evaluacion($identificador = null){
        if ($this->input->is_ajax_request()) { //Solo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) {
                $datos_busqueda = $this->input->post(null, true); //Datos del formulario se envían para generar la consulta
                $condition_extra = array();
                if(isset($datos_busqueda['menu_busqueda']) && !empty($datos_busqueda['menu_busqueda'])) {
                    switch ($datos_busqueda['menu_busqueda']) {
                        case 'matricula':
                            $condition_extra = "AND emp_matricula like '%".$datos_busqueda['buscador_docente']."%'";
                            break;                        
                        case 'nombre':
                            $condition_extra = "AND (EMP_NOMBRE like '%".$datos_busqueda['buscador_docente']."%' OR EMP_APE_PATERNO like '%".$datos_busqueda['buscador_docente']."%' OR EMP_APE_MATERNO like '%".$datos_busqueda['buscador_docente']."%')";
                            break;
                    }
                }
                $datos_busqueda['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0; //Registro actual, donde inicia la visualización de registros
                $datos_busqueda['conditions'] = 'evaluacion_solicitud.CESE_CVE >='.Enum_es::Envio_evaluacion.' AND ADMIN_DICTAMEN_EVA_CVE='.$this->obtener_id_dictamen().' '.$condition_extra;
                $datos_busqueda['fields'] = "if(evaluacion_solicitud.CESE_CVE=".Enum_es::Envio_evaluacion.", (select EST_EVALUACION_CVE from hist_evaluacion_dic where hist_evaluacion_dic.SOLICITUD_VAL_CVE=evaluacion_solicitud.VALIDACION_CVE AND IS_ACTUAL=".$this->config->item('IS_ACTUAL')." AND EVALUADOR_CVE=".$this->obtener_id_evaluador()."), 0) AS estado, evaluacion_solicitud.*, cestado_solicitud_evauacion.CESE_NOMBRE, empleado.*, DEL_NOMBRE, nom_categoria";
                
                $datos['evaluacion'] = $this->eval_doce_model->get_evaluacion_docente($datos_busqueda); ////Obtener listado de evaluaciones de acuerdo al año seleccionado
                $datos['evaluacion']['string_values'] = array_merge($this->lang->line('interface_evaluacion')['evaluacion']['dictamen'], $this->lang->line('interface_evaluacion')['evaluacion']['docente'], $this->lang->line('interface_evaluacion')['general']); //Cargar textos utilizados en vista

                $datos['evaluacion']['current_row'] = $datos_busqueda['current_row'];
                $datos['evaluacion']['per_page'] = $this->input->post('per_page'); //Número de registros a mostrar por página
                
                $this->resultado_listado($datos['evaluacion'], array('form_recurso'=>'#form_search', 'elemento_resultado'=>'#resultado_busqueda', 'view'=>'evaluacion/evaluacion_docente/resultado_busqueda')); //Generar listado en caso de obtener datos
            }
        } else {
            redirect(site_url());
        }
    }

    /**
     * Método que imprime el listado, se agrega paginación.
     * @autor       : Jesús Díaz P.
     * @modified    : 
     * @access      : private
     * @param       : mixed[] $data Arreglo de publicaciones y de información necesaria para generar los links para la paginación
     * @param       : mixed[] $form Arreglo asociativo con 2 elementos. 
     *                  form_recurso -> identificador del formulario que contiene los elementos de filtración
     *                  elemento_resultado -> identificador del elemento donde se mostrará el listado
     */
    private function resultado_listado($data, $form){
        //$this->load->library('seguridad');
        $data['controller'] = 'evaluacion_docente';
        $data['action'] = 'buscar_docentes_evaluacion';
        $pagination = $this->template->pagination_data($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info'>".$pagination['total']."</div>
                <div class='col-sm-7'>".$pagination['links']."</div><input type='hidden' id='cr', name='cr' value='".$data['current_row']."'>";
        echo $links.$this->load->view($form['view'], $data, TRUE).$links.'
            <script>
            $("ul.pagination li a").click(function(event){
                data_ajax(this, "'.$form['form_recurso'].'", "'.$form['elemento_resultado'].'");
                event.preventDefault();
            });
            </script>';
    }

    /**
     * Elimina los datos o información del usuario u empleado a validar
     */
    private function delete_datos_validado() {
        if (!is_null($this->session->userdata('evaluacion'))) {
            $this->session->unset_userdata('evaluacion');
        }
    }

    private function obtener_id_dictamen() {
        if (!is_null($this->session->userdata('dictamen'))) {
            return $this->session->userdata('dictamen')['ADMIN_DICTAMEN_EVA_CVE'];
        }
        return NULL;
    }

    private function obtener_id_empleado() {
        if (!is_null($this->session->userdata('idempleado'))) {
            return $this->session->userdata('idempleado');
        }
        return NULL;
    }
    private function obtener_id_evaluador() {
        if (!is_null($this->session->userdata('evaluador'))) {
            return $this->session->userdata('evaluador')['EVALUADOR_CVE'];
        }
        return NULL;
    }

    ////////////////////////Inicio Factory de tipos de comisión
    /*private function evaluacion_curso_fac($evaluacion) {
        $this->load->model('Expediente_model', 'exp');
        $eva = new stdClass();
        switch ($evaluacion['seccion']) {
            case $this->config->item('tipo_comision')['DIRECCION_TESIS']['id']:
                $eva = $this->direccion_tesis_vo($comision);
                break;
            
        }

        return $eva;
    }

    private function evaluacion_curso_esp_medica_vo($comision) {
        $com = new Comite_educacion_dao;
        $com->EMPLEADO_CVE = (isset($comision['empleado']) && !empty($comision['empleado'])) ? $comision['empleado'] : NULL;

        return $com;
    }*/
}

class Evaluacion_curso {
    //public $EVA_CURSO_CVE;
    public $EVA_CUR_VALIDO;
    public $EVA_CUR_PUNTOS_CURSO;
    public $EVALUADOR_CVE;
    public $EVA_CUR_CATEGORIA;
    public $EVA_CUR_MSG_RE_EVALUACION;
    public $EVA_CUR_PUNTOS_CURSO_ORIGINAL;
    //public $FCH_EVALUACION_CURSO_GAECUD;
    public $EVALUACION_CVE;
    public $HIST_EVALUACION_CVE;
    public $SECCION_CVE;
}
class Evaluacion_curso_esp_medica extends Evaluacion_curso {
    //public $TABU_ACT_DOCENTE_CVE;
    public $EMP_ESP_MEDICA_CVE;
}
class Evaluacion_curso_act_docente extends Evaluacion_curso  {
    //public $TABU_ACT_DOCENTE_CVE;
    public $EMP_ACT_DOCENTE_CVE;
}
class Evaluacion_curso_for_profesional extends Evaluacion_curso {
    public $EMP_FORMACION_PROFESIONAL_CVE;
}
class Evaluacion_curso_act_inv_edu extends Evaluacion_curso {
    //public $TABU_ACT_INV_EDU_CVE;
    public $EAID_CVE;
}
class Evaluacion_curso_mat_edu extends Evaluacion_curso {
    public $MATERIA_EDUCATIVO_CVE;
    //public $TEM_ELA_MATERIAL_CVE;
}
class Evaluacion_curso_comision extends Evaluacion_curso {
    //public $TABU_DIR_TESIS_CVE;
    //public $TAB_COM_ACADEMICA_CVE;
    //public $TABULADOR_COOR_CVE;
    public $EMP_COMISION_CVE;
}
class Evaluacion_curso_fpcs extends Evaluacion_curso {
    //public $TABU_EDU_CONTINUA_CVE;
    public $FPCS_CVE;
}
class Evaluacion_curso_edu_dis extends Evaluacion_curso {
    //public $TABU_EDU_DISTANCIA_CVE;
    public $EMP_EDU_DISTANCIA_CVE;
}