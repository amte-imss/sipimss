<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestión de usuarios
 * @version 	: 1.0.0
 * @author      : Jesús Z. Díaz P.
 * */
class Usuario extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->lang->load('interface_administracion');
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->library('seguridad');
        $this->load->model('Usuario_model','usuario');
    }

    /** 
     * Búsqueda y listado de usuarios
     * @method: void index()
     * @author: Jesús Z. Díaz P.
     */
    public function index() {
        $main_content = null;
        $datos = array();
        $datos['string_values'] = $this->lang->line('interface_administracion')['usuario']; //Cargar textos utilizados en vista

        //$entidades_ = array(enum_ecg::cdelegacion, enum_ecg::cdepartamento, enum_ecg::ccategoria);
        $entidades_ = array(enum_ecg::cdelegacion, enum_ecg::crol, enum_ecg::cestado_usuario);
        $datos['catalogos'] = carga_catalogos_generales($entidades_, null, null);

        ////Obtener listado de evaluaciones de acuerdo al año seleccionado
        //$datos['usuario'] = $this->usuario->get_usuario();
        /*foreach ($datos['usuario'] as $key_usu => $usu) {
            $datos['usuario'][$key_usu]['rol'] = $this->usuario->get_usuario_rol(array('conditions'=>"USUARIO_CVE=".$usu['USUARIO_CVE']));
        }*/
        
        //pr($datos);
        $datos['order_columns'] = array('USU_MATRICULA'=>$datos['string_values']['buscador']['tab_head_matricula'], 'USU_PATERNO'=>$datos['string_values']['buscador']['tab_head_nombre'], 'nom_delegacion'=>$datos['string_values']['buscador']['tab_head_delegacion'], 'dep_nombre'=>$datos['string_values']['buscador']['tab_head_adscripcion'], 'EDO_USUARIO_DESC'=>$datos['string_values']['buscador']['tab_head_estado']);
        $main_content = $this->load->view('administracion/usuario/buscador_listado', $datos, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    /**
     * Método que a través de una petición ajax muestra el listado de usuarios, estos pueden ser filtrados de acuerdo a parámetros seleccionados
     * @autor       : Jesús Díaz P.
     * @modified    : 
     * @access      : public
     * @param       : integer - $current_row - Registro actual, donde iniciará la visualización de registros
     */
    public function get_data_ajax($current_row=null){
        if($this->input->is_ajax_request()){ //Solo se accede al método a través de una petición ajax
            if(!is_null($this->input->post())){ //Se verifica que se haya recibido información por método post
                
                $datos_busqueda = $this->input->post(null, true); //Datos del formulario se envían para generar la consulta

                $datos_busqueda['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0; //Registro actual, donde inicia la visualización de registros
                
                $datos['usuario'] = $this->usuario->get_usuario_listado($datos_busqueda); ////Obtener listado de evaluaciones de acuerdo al año seleccionado
                $datos['usuario']['string_values'] = array_merge($this->lang->line('interface_administracion')['usuario'], $this->lang->line('interface_administracion')['general']); //Cargar textos utilizados en vista

                $datos['usuario']['current_row'] = $datos_busqueda['current_row'];
                $datos['usuario']['per_page'] = $this->input->post('per_page'); //Número de registros a mostrar por página
                
                if($datos['usuario']['total']>0){
                    foreach ($datos['usuario']['data'] as $key_usu => $usu) {
                        $datos['usuario']['data'][$key_usu]['rol'] = $this->usuario->get_usuario_rol(array('conditions'=>"USUARIO_CVE=".$usu['USUARIO_CVE']));
                    }
                    //pr($datos);
                    $this->resultado_listado($datos['usuario'], array('form_recurso'=>'#form_search', 'elemento_resultado'=>'#resultado_busqueda')); //Generar listado en caso de obtener datos
                } else {
                    echo data_not_exist(); //Mostrar mensaje de datos no existentes
                                        //echo "<script type='text/javascript'>$('.reportes_excel').hide();</script>";
                }
            }
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
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
        $data['controller'] = 'usuario';
        $data['action'] = 'get_data_ajax';
        $pagination = $this->template->pagination_data($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info'>".$pagination['total']."</div>
                <div class='col-sm-7'>".$pagination['links']."</div><input type='hidden' id='cr', name='cr' value='".$data['current_row']."'>";
        echo $links.$this->load->view('administracion/usuario/resultado_busqueda', $data, TRUE).$links.'
            <script>
            $("ul.pagination li a").click(function(event){
                data_ajax(this, "'.$form['form_recurso'].'", "'.$form['elemento_resultado'].'");
                event.preventDefault();
            });
            </script>';
    }

    public function desactivar_usuario($identificador){
        if($this->input->is_ajax_request()){ //Solo se accede al método a través de una petición ajax
            $datos['identificador'] = $identificador; //Identificador de usuario
            $datos['msg'] = null;
            $usuario_id = $this->seguridad->decrypt_base64($identificador); //Identificador del usuario

            $datos['usuario']['string_values'] = array_merge($this->lang->line('interface_administracion')['usuario'], $this->lang->line('interface_administracion')['general']); //Cargar textos utilizados en vista
            $cestado_usuario = $this->config->item('cestado_usuario');
            //pr($cestado_usuario);
            $resultado = $this->usuario->update_usuario_estado($usuario_id, array('ESTADO_USUARIO_CVE'=>$cestado_usuario['INACTIVO']['id'])); //Desactivar usuario
            
            echo json_encode($resultado); ///Muestra mensaje
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function validar_usuario_siap(){
        if($this->input->is_ajax_request()){ //Solo se accede al método a través de una petición ajax
            $resultado = array('result'=>false, 'msg'=>'');
            if(!is_null($this->input->post()) && !empty($this->input->post())) { //Se verifica que se haya recibido información por método post
                $this->load->library('Empleados_siap');
                $string_values = array_merge($this->lang->line('interface_administracion')['usuario'], $this->lang->line('interface_administracion')['general']); //Cargar textos utilizados en vista
                $datos_post = $this->input->post(null, true); //Datos del formulario
                
                $empleado = $this->empleados_siap->buscar_usuario_siap(array('reg_delegacion'=>$datos_post['d'], 'asp_matricula'=>$datos_post['m']));
                //pr($empleado);
                if($empleado==false){
                    $resultado['msg'] = $string_values['formulario']['error_del_mat'];
                } else {
                    //$cestado_usuario = $this->config->item('cestado_usuario');
                    $resultado['result'] = true;
                    //pr($empleado);
                    $empleado['sexo'] = $this->config->item('USU_GENERO')[$empleado['sexo']];
                    $empleado['antiguedad'] = antiguedad_format($empleado['antiguedad']);
                    $resultado['data'] = $empleado;
                }
            }
            echo json_encode($resultado); ///Muestra mensaje
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    /**
     * Función que permite agregar y actualizar usuarios
     * @method: void gestionar_usuario()
     * @author: Jesús Z. Díaz P.
     */
    public function gestionar_usuario($identificador = null){
        $this->lang->load('interface');

        $datos['identificador'] = $identificador;
        $datos['msg'] = null;
        $usuario_id = $this->seguridad->decrypt_base64($identificador); //Identificador del usuario
        $datos['string_values'] = array_merge($this->lang->line('interface_administracion')['usuario'], $this->lang->line('interface_administracion')['general'], $this->lang->line('interface')['perfil'], $this->lang->line('interface')['registro']); //Cargar textos utilizados en vista

        $entidades_ = array(enum_ecg::cdelegacion, enum_ecg::cestado_usuario, enum_ecg::cestado_civil, enum_ecg::crol);
        $condiciones_ = array(enum_ecg::crol=>array('ROL_CVE!='=>$this->config->item('superadmin')));
        $datos['catalogos'] = carga_catalogos_generales($entidades_, null, $condiciones_);

        if(!is_null($this->input->post()) && !empty($this->input->post())){ //Se verifica que se haya recibido información por método post
            $this->load->library('Empleados_siap'); //Cargar librería que permite validar con webservice SIAP
            $datos_formulario = $this->input->post(null, true); //Datos del formulario se envían para generar la consulta
            //pr($datos_formulario);
            $this->config->load('form_validation'); //Cargar archivo con validaciones
            
            ///Obtener el arreglo de validaciones de acuerdo a acción (insert or update)
            $validations = (is_null($identificador)) ? $this->config->item('form_usuario_alta') : $this->config->item('form_usuario_edicion'); //Obtener validaciones de archivo

            $this->form_validation->set_rules($validations);
            if(!is_null($identificador) && !empty($datos_formulario['contrasenia'])) { //Añadir opción en caso de ser edición y exista información en campo de contraseñia
                $this->form_validation->set_rules('contrasenia','Contraseña','callback_valid_pass|max_length[30]|min_length[8]');
            }
            $matricula = (!is_null($identificador)) ? $this->usuario->get_usuario(array('fields'=>'USU_MATRICULA', 'conditions'=>array('USUARIO_CVE'=>$usuario_id)))[0]['USU_MATRICULA'] : $datos_formulario['matricula'];
            $empleado = $this->empleados_siap->buscar_usuario_siap(array('reg_delegacion'=>$datos_formulario['delegacion'], 'asp_matricula'=>$matricula)); //Validar datos con webservice SIAP
            //pr($matricula);
            //pr($empleado);
            if($this->form_validation->run() == TRUE ){ //Validar datos
                if(!is_null($usuario_id) && !empty($usuario_id)) { //Se almacena en la base de datos
                    $usu_vo = $this->usuario_vo($datos_formulario); ///Se forma el objeto para ser actualizado
                    $usu_rol_vo = $this->usuario_rol_vo($usuario_id, $datos_formulario['roles']);

                    $usu_vo->USU_CONTRASENIA = contrasenia_formato($usu_vo->USU_MATRICULA, $usu_vo->USU_CONTRASENIA);
                    unset($usu_vo->USU_MATRICULA); //Se elimina matrícula porque no se actualiza en una edición
                    if(empty($usu_vo->USU_CONTRASENIA)){ //Se elimina contraseña de objeto si se envía vacía
                        unset($usu_vo->USU_CONTRASENIA);
                    }
                    $resultado = $this->usuario->update_usuario($usuario_id, $usu_vo, $usu_rol_vo); //Actualización de información
                } else {
                    $usu_vo = $this->usuario_vo($datos_formulario, true, $empleado); ///Se forma el objeto para ser insertado
                    ///Verificar si el usuario existe en la BD
                    //$existe_usuario = $this->usuario->get_usuario(array('conditions'=>array('USU_MATRICULA'=>$usu_vo->USU_MATRICULA)));

                    $resultado = $this->usuario->insert_usuario($usu_vo, $datos_formulario['roles']); //Inserción
                    
                    $datos['identificador'] = $this->seguridad->encrypt_base64($resultado['data']['identificador']); //Obtenemos identificador de registro aceptado y se encripta
                    $datos['accion'] = 'insert';
                }
                //pr($usu_vo); pr($usu_rol_vo); exit();
                $datos['msg'] = imprimir_resultado($resultado); ///Muestra mensaje */
            }
        }
        if(!is_null($identificador)){ ///En caso de que se haya elegido alguna convocatoria
            $datos['dato_usuario'] = $this->usuario->get_usuario(array('conditions'=>array('USUARIO_CVE'=>$usuario_id)))[0]; //Obtener datos
            $dr = $this->usuario->get_usuario_rol(array('conditions'=>array("USUARIO_CVE"=>$usuario_id))); //Roles disponibles para el usuario
            $datos['dato_usuario']['rol'] = dropdown_options($dr, 'ROL_CVE', 'ROL_CVE');
        } else {
            $datos['dato_usuario'] = (array)$this->usuario_vo(); //Generar objeto para ser enviado al formulario
            $datos['dato_usuario']['rol'] = null;
        }
        $main_content = $this->load->view('administracion/usuario/usuario_formulario', $datos, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    /*public function rol_modulo(){
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();

        $crud->set_table('rol_modulo');
        $crud->columns('ROL_CVE', 'MODULO_CVE');
        
        $main_content = $crud->render();
         
        $this->template->setMainContent($this->load->view('administracion/rol_modulo/rol_modulo.php', $main_content, TRUE));
        $this->template->getTemplate();
    }*/
    
    public function rol_modulo(){
        $datos['string_values'] = array_merge($this->lang->line('interface_administracion')['usuario'], $this->lang->line('interface_administracion')['general']); //Cargar textos utilizados en vista
        $entidades_ = array(enum_ecg::modulo, enum_ecg::crol);
        $datos['catalogos'] = carga_catalogos_generales($entidades_, null, null);
        
        if(!is_null($this->input->post()) && !empty($this->input->post())){ //Se verifica que se haya recibido información por método post
            $datos_formulario = $this->input->post(null, true); //Datos del formulario se envían para generar la consulta
            
            $roles_modulos = $this->rol_modulo_vo($datos_formulario);
            
            $resultado = $this->usuario->update_rol_modulo($roles_modulos); //Actualización de información
            
            $datos['msg'] = imprimir_resultado($resultado); ///Muestra mensaje
            //pr($this->rol_modulo_vo($datos_formulario));
            //pr($datos_formulario);
        }
        //$condiciones_ = array(enum_ecg::crol=>array('ROL_CVE!='=>$this->config->item('superadmin')));
        $datos['rol_modulo'] = $this->usuario->get_rol_modulo();
        
        //pr($datos);
        $this->template->setMainContent($this->load->view('administracion/rol_modulo/rol_modulo.php', $datos, TRUE));
        $this->template->getTemplate();
    }
    
    private function usuario_vo($usuario=array(), $extendido = false, $usuario_siap = array()){
        $result = new Usuario_dao;
        $result->USU_MATRICULA = (isset($usuario['matricula']) && !empty($usuario['matricula'])) ? $usuario['matricula'] : NULL;
        $result->DELEGACION_CVE = (isset($usuario['delegacion']) && !empty($usuario['delegacion'])) ? $usuario['delegacion'] : NULL;
        $result->USU_NOMBRE = (isset($usuario['nombre']) && !empty($usuario['nombre'])) ? $usuario['nombre'] : NULL;
        $result->USU_PATERNO = (isset($usuario['apaterno']) && !empty($usuario['apaterno'])) ? $usuario['apaterno'] : NULL;
        $result->USU_MATERNO = (isset($usuario['amaterno']) && !empty($usuario['amaterno'])) ? $usuario['amaterno'] : NULL;
        $result->USU_CONTRASENIA = (isset($usuario['contrasenia']) && !empty($usuario['contrasenia'])) ? $usuario['contrasenia'] : NULL;
        $result->USU_CORREO = (isset($usuario['correo']) && !empty($usuario['correo'])) ? $usuario['correo'] : NULL;
        $result->USU_CORREO_ALTERNATIVO = (isset($usuario['correo_alt']) && !empty($usuario['correo_alt'])) ? $usuario['correo_alt'] : NULL;
        $result->USU_TEL_LABORAL = (isset($usuario['tel_laboral']) && !empty($usuario['tel_laboral'])) ? $usuario['tel_laboral'] : NULL;
        $result->USU_TEL_PARTICULAR = (isset($usuario['tel_particular']) && !empty($usuario['tel_particular'])) ? $usuario['tel_particular'] : NULL;
        $result->ESTADO_USUARIO_CVE = (isset($usuario['estado_usuario']) && !empty($usuario['estado_usuario'])) ? $usuario['estado_usuario'] : NULL;
        $result->CESTADO_CIVIL_CVE = (isset($usuario['estado_civil']) && !empty($usuario['estado_civil'])) ? $usuario['estado_civil'] : NULL;
        if($extendido===true){
            $ext = new Usuario_ext_dao;
            $ext->CATEGORIA_CVE = (isset($usuario_siap['emp_keypue']) && !empty($usuario_siap['emp_keypue'])) ? $usuario_siap['emp_keypue'] : NULL;
            $ext->USU_CURP = (isset($usuario_siap['curp']) && !empty($usuario_siap['curp'])) ? $usuario_siap['curp'] : NULL;
            $ext->ADSCRIPCION_CVE = (isset($usuario_siap['adscripcion']) && !empty($usuario_siap['adscripcion'])) ? $usuario_siap['adscripcion'] : NULL;
            $ext->TIP_CONTRATACION_CVE = (isset($usuario_siap['tipo_contratacion']) && !empty($usuario_siap['tipo_contratacion'])) ? $usuario_siap['tipo_contratacion'] : NULL;
            $ext->PRESUPUESTAL_ADSCRIPCION_CVE = (isset($usuario_siap['presupuestal']) && !empty($usuario_siap['presupuestal'])) ? $usuario_siap['presupuestal'] : NULL;
            $ext->EDO_LABORAL_CVE = (isset($usuario_siap['status']) && !empty($usuario_siap['status'])) ? $usuario_siap['status'] : NULL;
            //$ext->ROL_DESEMPENIA_CVE = (isset($usuario_siap['emp_keypue']) && !empty($usuario_siap['emp_keypue'])) ? $usuario_siap['emp_keypue'] : NULL;
            $ext->USU_GENERO = (isset($usuario_siap['sexo']) && !empty($usuario_siap['sexo'])) ? $usuario_siap['sexo'] : NULL;
            $ext->USU_ANTIGUEDAD = (isset($usuario_siap['antiguedad']) && !empty($usuario_siap['antiguedad'])) ? $usuario_siap['antiguedad'] : NULL;
            $result = (object)array_merge((array)$result, (array)$ext);
        }
        //pr($usuario_siap); pr($result); exit();
        return $result;
    }

    private function usuario_rol_vo($usuario_id, $roles){
        $result = array();
        foreach ($roles as $key_rol => $rol) {
            $ur = new Usuario_rol_dao;
            $ur->USUARIO_CVE = $usuario_id;
            $ur->ROL_CVE = $rol;
            $result[] = $ur;
        }
        
        return $result;
    }

    private function rol_modulo_vo($datos){
        $result = array();
        foreach ($datos as $key_rol => $rolt) {
            $rol = str_replace('rm_', '', $key_rol);
            foreach ($rolt as $key_mod => $modulo) {
                $ur = new Rol_modulo_dao;
                $ur->MODULO_CVE = $modulo;
                $ur->ROL_CVE = $rol;
                $result[] = $ur;
            }
        }
        
        return $result;
    }
}

class Usuario_dao {
    //public $USUARIO_CVE;
    public $USU_MATRICULA;
    public $DELEGACION_CVE;
    public $USU_NOMBRE;
    public $USU_PATERNO;
    public $USU_MATERNO;
    public $USU_CONTRASENIA;
    public $USU_CORREO;
    public $USU_CORREO_ALTERNATIVO;
    public $USU_TEL_LABORAL;
    public $USU_TEL_PARTICULAR;
    public $ESTADO_USUARIO_CVE;
    public $CESTADO_CIVIL_CVE;
}

class Usuario_ext_dao{
    public $CATEGORIA_CVE;
    public $USU_CURP;
    public $ADSCRIPCION_CVE;
    public $TIP_CONTRATACION_CVE;
    public $PRESUPUESTAL_ADSCRIPCION_CVE;
    public $EDO_LABORAL_CVE;
    public $ROL_DESEMPENIA_CVE;
    public $USU_GENERO;
    public $USU_ANTIGUEDAD;
}

class Usuario_rol_dao{
    public $USUARIO_CVE;
    public $ROL_CVE;
}

class Rol_modulo_dao{
    public $MODULO_CVE;
    public $ROL_CVE;
}