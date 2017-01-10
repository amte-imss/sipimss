<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestión de convocatorias de evaluación
 * @version 	: 1.0.0
 * @author      : Jesús Z. Díaz P.
 * */
class Convocatoria_evaluacion extends MY_Controller {

    /*     * *********Costructor
     * Función inicial que carga los elementos utilizados en todos los métodos de la clase
     */
    function __construct() {
        parent::__construct();
        /*
        $this->load->config('general');
        $this->config->load('general');*/
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->library('seguridad');
        $this->load->model('Convocatoria_evaluacion_model','conv_eval_model');
        $this->lang->load('interface_evaluacion');
        $this->load->helper('date');
    }

    /** 
     * Búsqueda y listado de convocatorias de evaluación
     * @method: void index()
     * @author: Jesús Z. Díaz P.
     */
    public function index() {
        $main_content = null;
        $datos = array();
        $anio_actual = $this->anio_actual(); //Obtener año seleccionado para mostrar convocatorias
        
        ////Obtener años, para mostrar en listado desplegable
        $anio_convocatoria_dictamen_evaluacion = $this->conv_eval_model->get_convocatoria_dictamen_evaluacion(array('fields'=>'distinct(YEAR(FCH_INICIO_EVALUACION)) AS anio'));
        $datos['anio_convocatoria_dictamen_evaluacion'] = dropdown_options($anio_convocatoria_dictamen_evaluacion, 'anio', 'anio');
        
        ////Obtener próxima evaluación
        $datos['proxima_convocatoria_evaluacion'] = $this->conv_eval_model->get_convocatoria_dictamen_evaluacion(array('conditions'=>"FCH_FIN_EVALUACION>NOW()", 'fields'=>'MIN(FCH_FIN_EVALUACION) AS anio'));

        ////Obtener listado de evaluaciones de acuerdo al año seleccionado
        //$datos['convocatoria_evaluacion'] = $this->conv_eval_model->get_convocatoria_evaluacion(array('conditions'=>"YEAR(admin_dictamen_evaluacion.FCH_INICIO_EVALUACION)='".$anio_actual."'", 'fields'=>array('distinct admin_validador.*', false)));
        $datos['convocatoria_evaluacion'] = $this->conv_eval_model->get_convocatoria_evaluacion(array('conditions'=>"YEAR(FCH_FIN_VALIDACION_2)='".$anio_actual."'"));
        foreach ($datos['convocatoria_evaluacion'] as $key_ce => $ce) {
            $datos['convocatoria_evaluacion'][$key_ce]['dictamen'] = $this->conv_eval_model->get_convocatoria_dictamen_evaluacion(array('conditions'=>"ADMIN_VALIDADOR_CVE=".$ce['ADMIN_VALIDADOR_CVE']));
        }
        
        $datos['string_values'] = array_merge($this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['buscador'], $this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['general'], $this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['model']); //Cargar textos utilizados en vista
        //pr($datos);
        $main_content = $this->load->view('evaluacion/convocatoria/buscador_listado', $datos, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    /**
     * Función que permite agregar y actualizar convocatorias
     * @method: void gestionar_convocatoria()
     * @author: Jesús Z. Díaz P.
     */
    public function gestionar_convocatoria($identificador = null){
        if($this->input->is_ajax_request()){ //Solo se accede al método a través de una petición ajax
            $datos['identificador'] = $identificador;
            $datos['msg'] = null;
            $convocatoria_id = $this->seguridad->decrypt_base64($identificador); //Identificador de la convocatoria
            $datos['string_values'] = array_merge($this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['agregar'], $this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['general']); //Cargar textos utilizados en vista

            if(!is_null($this->input->post()) && !empty($this->input->post())){ //Se verifica que se haya recibido información por método post
                $datos_formulario = $this->input->post(null, true); //Datos del formulario se envían para generar la consulta
                //pr($datos_formulario);
                $this->config->load('form_validation'); //Cargar archivo con validaciones
                
                $validations = $this->config->item('form_convocatoria_evaluacion'); //Obtener validaciones de archivo
                $this->form_validation->set_rules($validations);

                if(!empty($datos_formulario['FCH_FIN_REG_DOCENTE']) && !empty($datos_formulario['FCH_FIN_VALIDACION_1']) && !empty($datos_formulario['FCH_FIN_VALIDACION_2'])){ ///Agregar validación de comparación de fechas
                    $this->form_validation->set_rules(array(
                        array('field' => 'FCH_FIN_VALIDACION_1', 'label' => $datos['string_values']['tab_head_fecha_fin_validacion1'], 'rules' => 'required|callback_compare_date['.$datos_formulario['FCH_FIN_REG_DOCENTE'].']'),
                        array('field' => 'FCH_FIN_VALIDACION_2', 'label' => $datos['string_values']['tab_head_fecha_fin_validacion2'], 'rules' => 'required|callback_compare_date['.$datos_formulario['FCH_FIN_VALIDACION_1'].']')
                    ));
                    $this->form_validation->set_message('compare_date', $datos['string_values']['compare_date']);
                }

                if($this->form_validation->run() == TRUE){ //Validar datos
                    ///Se forma el objeto para ser insertado
                    $ce_vo = $this->convocatoria_evaluacion_vo(array('FCH_FIN_REG_DOCENTE'=>(!empty($datos_formulario['FCH_FIN_REG_DOCENTE']) ? date("Y-m-d", strtotime($datos_formulario['FCH_FIN_REG_DOCENTE'])) : null ),
                        'FCH_FIN_VALIDACION_1'=>(!empty($datos_formulario['FCH_FIN_VALIDACION_1']) ? date("Y-m-d", strtotime($datos_formulario['FCH_FIN_VALIDACION_1'])) : null ),
                        'FCH_FIN_VALIDACION_2'=>(!empty($datos_formulario['FCH_FIN_VALIDACION_2']) ? date("Y-m-d", strtotime($datos_formulario['FCH_FIN_VALIDACION_2'])) : null )));

                    if(!is_null($convocatoria_id) && !empty($convocatoria_id)){ //Se almacena en la base de datos
                        $resultado = $this->conv_eval_model->update_convocatoria_evaluacion($convocatoria_id, $ce_vo); //Actualización
                    } else {
                        $resultado = $this->conv_eval_model->insert_convocatoria_evaluacion($ce_vo); //Inserción
                        $datos['identificador'] = $this->seguridad->encrypt_base64($resultado['data']['identificador']); //Obtenemos identificador de registro aceptado y se encripta
                    }
                    $datos['msg'] = imprimir_resultado($resultado); ///Muestra mensaje
                }
            }
            if(!is_null($identificador)){ ///En caso de que se haya elegido alguna convocatoria                
                $datos['dato_convocatoria'] = $this->conv_eval_model->get_convocatoria_evaluacion(array('conditions'=>array('ADMIN_VALIDADOR_CVE'=>$convocatoria_id))); //Obtener datos
            }            
            echo $this->load->view('evaluacion/convocatoria/convocatoria_formulario', $datos, true);
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    /**
     * Función que permite listar dictamenes
     * @method: void eliminar_convocatoria()
     * @param: $Identificador   string en base64    Identificador de la convocatoria codificado en base64
     * @author: Jesús Z. Díaz P.
     */
    public function eliminar_convocatoria($identificador){
        if($this->input->is_ajax_request()){ //Solo se accede al método a través de una petición ajax
            $datos['identificador'] = $identificador; //Identificador de convocatoria
            $datos['msg'] = null;
            $convocatoria_id = $this->seguridad->decrypt_base64($identificador); //Identificador de la convocatoria

            $datos['string_values'] = array_merge($this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['buscador'], $this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['general']); //Cargar textos utilizados en vista

            $datos['dictamen_evaluacion'] = $this->conv_eval_model->get_convocatoria_dictamen_evaluacion(array('conditions'=>array('ADMIN_VALIDADOR_CVE'=>$convocatoria_id))); //Obtener datos
            if(empty($datos['dictamen_evaluacion'])){ //En caso de que este vacío se elimina
                $resultado = $this->conv_eval_model->delete_convocatoria_evaluacion(array('conditions'=>array('ADMIN_VALIDADOR_CVE'=>$convocatoria_id))); //Eliminar datos
            } else {
                $resultado = array('result'=>FALSE, 'msg'=>$datos['string_values']['eliminacion_imposible']);
            }            
            
            //echo json_encode(imprimir_resultado($resultado)); ///Muestra mensaje
            echo json_encode($resultado); ///Muestra mensaje
            
            //echo $this->load->view('evaluacion/convocatoria/dictamen_listado', $datos, true);
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    /**
     * Función que permite listar dictamenes
     * @method: void listar_dictamen()
     * @param: $Identificador   string en base64    Identificador de la convocatoria codificado en base64
     * @author: Jesús Z. Díaz P.
     */
    public function listar_dictamen($identificador = null){
        if($this->input->is_ajax_request()){ //Solo se accede al método a través de una petición ajax
            $datos['identificador'] = $identificador; //Identificador de convocatoria
            $datos['msg'] = null;
            $convocatoria_id = $this->seguridad->decrypt_base64($identificador); //Identificador de la convocatoria

            $datos['dictamen_evaluacion'] = $this->conv_eval_model->get_convocatoria_dictamen_evaluacion(array('conditions'=>array('ADMIN_VALIDADOR_CVE'=>$convocatoria_id))); //Obtener datos
            
            $datos['string_values'] = array_merge($this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['buscador_dictamen'], $this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['general']); //Cargar textos utilizados en vista
            
            echo $this->load->view('evaluacion/convocatoria/dictamen_listado', $datos, true);
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    /**
     * Función que permite agregar y actualizar dictamenes
     * @method: void gestionar_dictamen()
     * @author: Jesús Z. Díaz P.
     */
    public function gestionar_dictamen($convocatoria = null , $identificador = null){
        if($this->input->is_ajax_request()){ //Solo se accede al método a través de una petición ajax
            $datos['identificador'] = $identificador;
            $datos['msg'] = null;
            $dictamen_id = $this->seguridad->decrypt_base64($identificador); //Identificador del dictamen
            $convocatoria_id = $this->seguridad->decrypt_base64($convocatoria); //Identificador de la convocatoria

            $datos['string_values'] = array_merge($this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['buscador_dictamen'], $this->lang->line('interface_evaluacion')['convocatoria_evaluacion']['general']); //Cargar textos utilizados en vista

            if(!is_null($this->input->post()) && !empty($this->input->post())){ //Se verifica que se haya recibido información por método post
                $datos_formulario = $this->input->post(null, true); //Datos del formulario se envían para generar la consulta
                
                $this->config->load('form_validation'); //Cargar archivo con validaciones
                
                $validations = $this->config->item('form_dictamen_evaluacion'); //Obtener validaciones de archivo
                $this->form_validation->set_rules($validations);

                if(!empty($datos_formulario['FCH_INICIO_EVALUACION']) && !empty($datos_formulario['FCH_FIN_EVALUACION']) && !empty($datos_formulario['FCH_FIN_INCONFORMIDAD'])){ ///Agregar validación de comparación de fechas
                    $this->form_validation->set_rules(array(
                        array('field' => 'FCH_FIN_EVALUACION', 'label' => $datos['string_values']['tab_head_fecha_fin_evaluacion'], 'rules' => 'required|callback_compare_date['.$datos_formulario['FCH_INICIO_EVALUACION'].']'),
                        array('field' => 'FCH_FIN_INCONFORMIDAD', 'label' => $datos['string_values']['tab_head_fecha_fin_inconformidad'], 'rules' => 'required|callback_compare_date['.$datos_formulario['FCH_FIN_EVALUACION'].']')
                    ));
                    $this->form_validation->set_message('compare_date', $datos['string_values']['compare_date']);
                }

                if($this->form_validation->run() == TRUE){ //Validar datos
                    ///Se forma el objeto para ser insertado
                    $de_vo = $this->convocatoria_evaluacion_dictamen_vo(array('FCH_INICIO_EVALUACION'=>(!empty($datos_formulario['FCH_INICIO_EVALUACION']) ? date("Y-m-d", strtotime($datos_formulario['FCH_INICIO_EVALUACION'])) : null ),
                        'FCH_FIN_EVALUACION'=>(!empty($datos_formulario['FCH_FIN_EVALUACION']) ? date("Y-m-d", strtotime($datos_formulario['FCH_FIN_EVALUACION'])) : null ),
                        'FCH_FIN_INCONFORMIDAD'=>(!empty($datos_formulario['FCH_FIN_INCONFORMIDAD']) ? date("Y-m-d", strtotime($datos_formulario['FCH_FIN_INCONFORMIDAD'])) : null ),
                        'ADMIN_VALIDADOR_CVE'=>(!empty($convocatoria_id) ? $convocatoria_id : null )
                    ));

                    if(!is_null($dictamen_id) && !empty($dictamen_id)){ //Se almacena en la base de datos
                        $resultado = $this->conv_eval_model->update_dictamen_evaluacion($dictamen_id, $de_vo); //Actualización
                    } else {
                        $resultado = $this->conv_eval_model->insert_dictamen_evaluacion($de_vo); //Inserción
                        $datos['identificador'] = $this->seguridad->encrypt_base64($resultado['data']['identificador']); //Obtenemos identificador de registro aceptado y se encripta
                    }
                    $datos['msg'] = imprimir_resultado($resultado); ///Muestra mensaje
                }
            }
            if(!is_null($identificador)){ ///En caso de que se haya elegido alguna convocatoria                
                $datos['dato_dictamen'] = $this->conv_eval_model->get_convocatoria_dictamen_evaluacion(array('conditions'=>array('ADMIN_DICTAMEN_EVA_CVE'=>$dictamen_id))); //Obtener datos
            }
            
            echo $this->load->view('evaluacion/convocatoria/dictamen_formulario', $datos, true);
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function eliminar_dictamen($identificador){
        if($this->input->is_ajax_request()){ //Solo se accede al método a través de una petición ajax
            $datos['identificador'] = $identificador; //Identificador de convocatoria
            $datos['msg'] = null;
            $dictamen_id = $this->seguridad->decrypt_base64($identificador); //Identificador de la convocatoria

            $resultado = $this->conv_eval_model->delete_dictamen_evaluacion(array('conditions'=>array('ADMIN_DICTAMEN_EVA_CVE'=>$dictamen_id))); //Eliminar datos
            
            echo json_encode($resultado); ///Muestra mensaje
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }


    public function compare_date($end, $start){
        if($start>$end){
            return false;
        } else {
            return true;
        }
    }

    private function anio_actual(){
        $anio_seleccionado = $this->input->get('a', true);
        return (is_null($anio_seleccionado) || empty($anio_seleccionado)) ? date('Y') : $anio_seleccionado;
    }

    private function convocatoria_evaluacion_vo($convocatoria){
        $ce = new Convocatoria_evaluacion_dao;
        $ce->FCH_FIN_REG_DOCENTE = (isset($convocatoria['FCH_FIN_REG_DOCENTE']) && isset($convocatoria['FCH_FIN_REG_DOCENTE'])) ? $convocatoria['FCH_FIN_REG_DOCENTE'] : NULL;
        $ce->FCH_FIN_VALIDACION_1 = (isset($convocatoria['FCH_FIN_VALIDACION_1']) && isset($convocatoria['FCH_FIN_VALIDACION_1'])) ? $convocatoria['FCH_FIN_VALIDACION_1'] : NULL;
        $ce->FCH_FIN_VALIDACION_2 = (isset($convocatoria['FCH_FIN_VALIDACION_2']) && isset($convocatoria['FCH_FIN_VALIDACION_2'])) ? $convocatoria['FCH_FIN_VALIDACION_2'] : NULL;
        return $ce;
    }

    private function convocatoria_evaluacion_dictamen_vo($dictamen){
        $ced = new Convocatoria_evaluacion_dictamen_dao;
        $ced->FCH_INICIO_EVALUACION = (isset($dictamen['FCH_INICIO_EVALUACION']) && isset($dictamen['FCH_INICIO_EVALUACION'])) ? $dictamen['FCH_INICIO_EVALUACION'] : NULL;
        $ced->FCH_FIN_EVALUACION = (isset($dictamen['FCH_FIN_EVALUACION']) && isset($dictamen['FCH_FIN_EVALUACION'])) ? $dictamen['FCH_FIN_EVALUACION'] : NULL;
        $ced->FCH_FIN_INCONFORMIDAD = (isset($dictamen['FCH_FIN_INCONFORMIDAD']) && isset($dictamen['FCH_FIN_INCONFORMIDAD'])) ? $dictamen['FCH_FIN_INCONFORMIDAD'] : NULL;
        $ced->ADMIN_VALIDADOR_CVE = (isset($dictamen['ADMIN_VALIDADOR_CVE']) && isset($dictamen['ADMIN_VALIDADOR_CVE'])) ? $dictamen['ADMIN_VALIDADOR_CVE'] : NULL;
        return $ced;
    }
}

class Convocatoria_evaluacion_dao {
    //public $ADMIN_VALIDADOR_CVE;
    public $FCH_FIN_REG_DOCENTE;
    public $FCH_FIN_VALIDACION_1;
    public $FCH_FIN_VALIDACION_2;
}

class Convocatoria_evaluacion_dictamen_dao {
    //public $ADMIN_VALIDADOR_CVE;
    public $FCH_INICIO_EVALUACION;
    public $FCH_FIN_EVALUACION;
    public $FCH_FIN_INCONFORMIDAD;
    public $ADMIN_VALIDADOR_CVE;
}