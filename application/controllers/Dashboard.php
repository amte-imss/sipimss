<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona EL DASHBOARD
 * @version 	: 1.0.0
 * @autor 		: Pablo José D.
 */
class Dashboard extends CI_Controller {

    /**
     * Carga de clases para el acceso a base de datos y obtencion de las variables de session
     * @access 		: public
     */
    public function __construct() {
        parent::__construct();
//        $this->load->model('Inicio_bono_model', 'ini_bm');
        //$this->load->model('Dashboard_model', 'dashboard');
        $this->load->library('enum_privilegios_conf');
        $this->load->library('enum_estados_empleado');
        $this->load->helper(array('form', 'captcha'));
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->library('empleados_siap');//Importante que se encuentre dentró de la red interna
        $this->load->model('Registro_model', 'mod_registro');
    }

    public function index() {
//        $this->session->sess_destroy();
//        $privilegios = $this->lm->set_usuario_rol_modulo_sesion("10010629");
//        pr($privilegios);
//        $rol = $this->session->userdata('lista_roles');
//        $mod_ext = $this->session->userdata('lista_modulos_extra');
//        $this->generar_propiedades_permisos($rol, $mod_ext);
//        pr($this->crear_lista_asociativa_valores($this->session->userdata('lista_roles'), 'cve_rol','nombre_rol'));

        $lista_roles = $this->session->userdata('lista_roles');
        $lista_roles_modulos = $this->session->userdata('lista_roles_modulos');
//        $this->session->userdata('rol_seleccionado') = $this->get_array_valor($lista_roles_modulos, 1);
        //pr($lista_roles_modulos);
        //echo "hola mundo";
        //exit();
        $rol_seleccionado = get_array_valor($lista_roles_modulos, 3);
        $this->session->set_userdata('rol_seleccionado', $rol_seleccionado);
        pr($this->session->userdata('rol_seleccionado'));

        $data['rol_seleccionado'] = $rol_seleccionado;
        $data['lista_roles'] = $lista_roles;
        $view_ = $this->load->view('login/Selection_role_tpl', $data, TRUE);
        $this->template->setMainContent($view_);
//        $this->template->setMainContent($imprime);*/
        $this->template->getTemplate();
        //pr('Hola señores');
//        pr('saludos a la bandera');
//        pr($lista_roles);
////        pr('saludos a la bandera');
//        pr($lista_roles_modulos);
//        $datos_siap = $this->empleados_siap->buscar_usuario_siap( array("reg_delegacion"=>'29', "asp_matricula"=>'99292913'));
//        pr($datos_siap);
//        pr($this->mod_registro->get_existe_usuario('99292913'));
    }

    private function get_array_valor($array_busqueda, $key) {
        if (array_key_exists($key, $array_busqueda)) {
            $array_result = $array_busqueda[$key];
            return $array_result;
        }
        return array();
    }

    /**
     * Método que carga el formulario de búsqueda y el listado de publicaciones.
     * @autor 		: Jesús Díaz P.
     * @modified 	:
     * @access 		: public
     */
    public function indexaa() {

        $this->config->load('general');
        $data['msg'] = "";
        $periodo_registrado = $this->ini_bm->check_periodo_registro_candidatos();
//        pr($periodo_registrado);
        if ($periodo_registrado['existe_periodo'] == false) {
            $candidatos_por_categoria = $this->ini_bm->seleccion_candidatos();
            $registro_candidatos = $this->ini_bm->set_candidatos_bono($candidatos_por_categoria);

            if ($registro_candidatos == true) {
                $data['msg'] = "<br> Los usuarios se registraron correctamente como candidatos";
            } else {
                $data['msg'] = "<br> No se pudo efectuar la transacción, por favor comunicalo al area de desarrollo encargada";
            }

            //pr($candidatos_por_categoria);
        } else {
            if ($periodo_registrado['termino_periodo'] === true) {
//                 $this->load->model('Bono_perfil_empleado_model', 'emp_perfil_model');
//                $resultado = $this->emp_perfil_model->get_empleados_filtro(null, enum_estados_empleado::VALIDADO_TITULAR)['result'];
//                $data['empleadoslst'] = $resultado;
//                $html = $this->load->view('template/plantillas_generales/lista_candidatos.php', $data, true);
//                $data['msg'] = $html;
                $data['msg'] .= "<br> <div class=\"alert alert-success alert-dismissible\" role=\"alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                    <span aria-hidden=\"true\">&times;</span>
                                    </button><strong>El proceso de selección de candidatos a bono del periodo " . (date("Y") - 1) . " a terminado </strong>
                                <a href='" . site_url('bonos_titular/generar_reporte_pdf') . "' class='btn btn-link btn-lg btn-block'><span class='glyphicon glyphicon-save'></span> Descargar reporte de candidatos beneficiados</a>
                                </div>";
            } else {
                $data['msg'] .= "";
            }
        }

        $datos['docentes'] = $this->dashboard->get_docentes(array('fields' => 'count(*) AS total'));
        $datos['delegacion'] = $this->dashboard->get_delegacion(); //Obtener listado completo de delegaciones
        $datos['tp'] = $this->dashboard->total_docentes_participantes(); //Obtener totales de docentes agrupados por delegación
        $data['datos'] = $this->obtener_datos_delegacion($datos);

        //pr($data['delegacion']);
        //pr($datos);

        $this->template->setMainContent($this->load->view('login/dashboard.php', $data, TRUE));
        //$this->template->setMainContent($imprime);*/
        $this->template->getTemplate();
    }

    function obtener_datos_delegacion($data) {
        $resultado = array('javascript' => "", 'total' => 0);
        if (isset($data['tp']['data'])) {
            foreach ($data['delegacion'] as $key_del => $valor_del) {
                foreach ($data['tp']['data'] as $key_tp => $valor_tp) {
                    $total = ($valor_del['cve_delegacion'] == $valor_tp['cve_delegacion']) ? $valor_tp['total'] : 0;
                    $resultado['javascript'] .= "{
                        name: '" . $valor_del['nom_delegacion'] . "',
                        y: " . $total . "
                    },";
                    $resultado['total'] += $total;
                }
            }
        }
        return $resultado;
    }

}
