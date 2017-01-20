<?php   defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase 
 * @version 	: 1.0.0
 * @autor 		: Jesús Z. Díaz P.
 */
class Administracion extends CI_Controller {
    var $string_values;
    /**
     * Carga de clases para el acceso a base de datos y obtencion de las variables de session
     * @access 		: public
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('seguridad');
        $this->load->config('general');
        $this->lang->load('interface');
        $this->string_values = $this->lang->line('interface'); //Cargar textos utilizados en vista
        $this->load->model('Administracion_model','admin');
    }

    /**
     * Método que 
     * @autor 		: 
     * @modified 	:
     * @access 		: public
     */
    public function index() {
        redirect(site_url()); //Redirigir al inicio del sistema, no se tiene método por default
    }


    public function ver_archivo($identificador=null){
        $html = '<div role="alert" class="alert alert-success" style="padding:25px; margin-bottom:80px;"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button><h4>'.$this->string_values['general']['archivo_incorrecto'].'</h4></div>';
        
        if(!is_null($identificador)){
            $file = decrypt_base64($identificador); ///Decodificar url, evitar hack
            $this->load->model("Administracion_model", "admin");
            $archivo = $this->admin->get_comprobante(array('conditions'=>array('COMPROBANTE_CVE'=>$file))); //Se valida que exista registro en base de datos

            if(!empty($archivo)){
                $ruta_archivo = $this->config->item('upload_config')['comprobantes']['upload_path'].$archivo[0]['COM_NOMBRE'];
                if(file_exists($ruta_archivo)){
                    //$main_content = $this->load->view('template/pdfjs/viewer', array('ruta_archivo'=>$ruta_archivo), true);
                    $this->load->view('template/pdfjs/viewer', array('ruta_archivo'=>$archivo[0]['COM_NOMBRE']), false);
                }
            } else {
                $html = '<div role="alert" class="alert alert-success" style="padding:25px; margin-bottom:80px;"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button><h4>'.$this->string_values['general']['archivo_inexistente'].'</h4></div>';
            }
        }
        //$this->template->setMainContent($main_content);
        //$this->template->getTemplate();
    }

    /**
     * Método que visualiza un archivo pdf
     * @autor       : Jesús Z. Díaz P.
     * @modified    :
     * @access      : public
     */
    public function descarga_archivo($identificador=null, $descarga=true){
        $html = '<div role="alert" class="alert alert-success" style="padding:25px; margin-bottom:80px;"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button><h4>'.$this->string_values['general']['archivo_incorrecto'].'</h4></div>';
        
        if(!is_null($identificador)){
            $file = decrypt_base64($identificador); ///Decodificar url, evitar hack
            $this->load->model("Administracion_model", "admin");
            $archivo = $this->admin->get_comprobante(array('conditions'=>array('COMPROBANTE_CVE'=>$file))); //Se valida que exista registro en base de datos

            if(!empty($archivo)){
                $ruta_archivo = $this->config->item('upload_config')['comprobantes']['upload_path'].$archivo[0]['COM_NOMBRE'];
                if(file_exists($ruta_archivo)){
                    $ext = pathinfo($archivo[0]['COM_NOMBRE'], PATHINFO_EXTENSION);
                    header('Content-Description: File Transfer');
                    if($ext!=$this->config->item('upload_config')['comprobantes']['allowed_types']){
                        header('Content-Type: application/octet-stream');
                    } else {
                        header('Content-type: application/pdf');
                    }
                    if($descarga==true){ ///Descargar
                        header('Content-Disposition: attachment; filename="'.$archivo[0]['COM_NOMBRE'].'"');
                    } else { ///Ver en línea
                        header('Content-Disposition: inline; filename="'.$archivo[0]['COM_NOMBRE'].'"');
                    }
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($ruta_archivo));
                    ob_clean();
                    flush();
                    //readfile($ruta_archivo);
                    echo file_get_contents($ruta_archivo);
                    exit;
                }
            } else {
                $html = '<div role="alert" class="alert alert-success" style="padding:25px; margin-bottom:80px;"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button><h4>'.$this->string_values['general']['archivo_inexistente'].'</h4></div>';
            }
        }
        $this->template->setMainContent($html);
        $this->template->getTemplate();
    }

    /**
     * Método que carga un archivo mediante ajax
     * @autor 		: Jesús Z. Díaz P.
     * @modified 	:
     * @access 		: public
     */
    public function cargar_archivo(){
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if($_FILES && $this->input->post()){ //Validar si se recibió archivo e información
                $resultado = array('result'=>false, 'msg'=>'');
                $data = $this->input->post(null, true); //Se obtienen datos
                
                //pr($_POST); pr($_FILES); //pr($_SESSION);
                $config = $this->colocar_configuracion($data); ///Obtener configuración para carga de archivo

                if($this->verificar_carpeta($config['upload_path'])){ //Verificar si existe carpeta donde se almacenaran los archivos, de lo contrario se crea
                    $this->load->library('upload', $config); ///Librería que carga y valida(peso, extensión) los archivos
                    if(!$this->upload->do_upload(key($_FILES))) {
                        $resultado['msg'] = $this->upload->display_errors();
                    } else {
                        $archivo = $this->comprobante_vo(array('nombre'=>$config['carpeta'].'/'.$this->upload->data('file_name'), 'tipo_comprobante'=>$data['tipo_comprobante'], 'extension'=>$this->upload->data('file_ext'))); //Crear objeto para almacenar en BD
                        if(empty($data['identificador'])){ //Insertar
                            $resultado_almacenado = $this->admin->insert_comprobante($archivo);
                            $resultado['idb'] = $this->seguridad->encrypt_base64($resultado_almacenado['data']['identificador']);
                            $resultado['id'] = $this->seguridad->encrypt_sha512($resultado_almacenado['data']['identificador']);
                        } else { ///Actualización
                            $id = $this->seguridad->decrypt_base64($data['idc']);
                            $data_comprobante = $this->admin->get_comprobante(array('conditions'=>array('COMPROBANTE_CVE'=>$id)))[0]; ///Obtener datos de comprobante a modificar
                            $resultado['idb'] = $data['idc'];
                            $resultado['id'] = $data['identificador'];
                            $resultado_almacenado = $this->admin->update_comprobante($id, $archivo);
                            unlink($this->format_path($config['path_simple']).$data_comprobante['COM_NOMBRE']); //Eliminar archivo anterior
                        }
                        if($resultado_almacenado['result']==TRUE){
                            $resultado['result'] = TRUE; //Notificar el almacenado exitoso
                            $resultado['msg'] = $this->string_values['general']['carga_correcta'];
                        } else {
                            unlink($this->format_path($config['path_simple']).$nombre_archivo); //En caso de error eliminar archivo cargado
                        }
                    }
                } else {
                    $resultado['msg'] = $this->string_values['error']['crear_carpeta'];
                }
                echo json_encode($resultado);
            }
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    public function eliminar_archivos(){
        $tiempo_eliminar_archivo = $this->config->item('tiempo_eliminar_archivo'); //Obtenemos lapso de tiempo que no será considerado a partir de la hora actual para la eliminación de archivos
        $numero_registros_eliminar = $this->config->item('numero_registros_eliminar'); //Obtenemos número de registros a eliminar por petición
        $data_comprobante = $this->admin->get_comprobante(array('conditions'=>'COMPROBANTE_CVE NOT IN (SELECT COMPROBANTE_CVE FROM emp_comision WHERE COMPROBANTE_CVE IS NOT NULL) AND FECHA_INSERSION < (NOW() - INTERVAL '.$tiempo_eliminar_archivo.' SECOND)', 'limit'=>$numero_registros_eliminar, 'order'=>'FECHA_INSERSION DESC'));
        $ruta = $this->config->item('upload_config')['comprobantes']['upload_path'];
        $borrados = $no_borrados = array();
        foreach ($data_comprobante as $key_dc => $dc) {
            if(file_exists($ruta.$dc['COM_NOMBRE'])) {
                if(unlink($this->format_path($ruta).$dc['COM_NOMBRE'])) {
                    $borrados[] = $dc['COMPROBANTE_CVE'];
                } else {
                    $no_borrados[] = $dc['COMPROBANTE_CVE'];
                }
            }
        }
        if(count($borrados)>0){
            $resultado = $this->admin->delete_comprobante(array('conditions'=>'COMPROBANTE_CVE IN ('.implode(',', $borrados).')'));
        }
        $resultado['borrados'] = $borrados;
        $resultado['no_borrados'] = $no_borrados;

        echo json_encode($resultado);
    }

    private function format_path($path){
        if (realpath($path) !== FALSE)
        {
            $path = str_replace('\\', '/', realpath($path));
        }
        $path = preg_replace('/(.+?)\/*$/', '\\1/',  $path);
        return $path;
    }

    /**
     * Método que verifica la existencia de la carpeta donde se almacenarán los archivos
     * @autor       : Jesús Z. Díaz P.
     * @modified    :
     * @access      : private
     */
    private function verificar_carpeta($ruta_archivos){
        if(!file_exists($ruta_archivos) && !is_dir($ruta_archivos)){ //Si no existe la carpeta se crea
            try{
                mkdir($ruta_archivos);
            } catch(Exception $e){
                return false;
            }
        }
        return true;
    }

    private function colocar_configuracion($data){
        $configuracion = (isset($data['conf']) && !empty($data['conf'])) ? $data['conf'] : 'comprobantes'; ///Obtener path para carga de archivos
        $configuracion_carga = $this->config->item('upload_config')[$configuracion]; //Obtener parámetros definidos en archivo general de configuración

        $ruta = (isset($data['ruta']) && !empty($data['ruta'])) ? $data['ruta'] : $configuracion_carga['upload_path']; ///Obtener path para carga de archivos
        $carpeta = $this->seguridad->encrypt_carpeta_nombre($this->session->userdata('matricula'));
        $ruta_archivos = $ruta.$carpeta."/"; ///Definir ruta de almacenamiento, se utiliza la matricula

        $nombre_archivo = (isset($data['nombre']) && !empty($data['nombre'])) ? $data['nombre'] : $this->session->userdata('matricula').'_'.time();

        $config['carpeta']              = $carpeta;
        $config['path_simple']          = $ruta;
        $config['upload_path']          = $ruta_archivos;
        $config['allowed_types']        = $configuracion_carga['allowed_types'];
        $config['max_size']             = $configuracion_carga['max_size']; // Definir tamaño máximo de archivo
        $config['detect_mime']          = $configuracion_carga['detect_mime']; // Validar mime type
        $config['file_name']            = $nombre_archivo; ///Renombrar archivo

        return $config;
    }

    private function comprobante_vo($comprobante){
        $comp = new Comprobante_dao;
        $comp->COM_NOMBRE = $comprobante['nombre'];
        $comp->TIPO_COMPROBANTE_CVE = $comprobante['tipo_comprobante'];
        $comp->com_extension = $comprobante['extension'];
        
        return $comp;
    }
}

class Comprobante_dao{
    //public $COMPROBANTE_CVE;
    public $COM_NOMBRE;
    public $TIPO_COMPROBANTE_CVE;
    public $com_extension;
}
