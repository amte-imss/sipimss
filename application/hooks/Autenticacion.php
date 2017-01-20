<?php

if (!defined('BASEPATH'))
    exit('NO DIRECT SCRIPT ACCESS ALLOWED');

class Iniciar_sesion {

    var $CI;

    function login() {
        $CI = & get_instance(); //Obtiene la insatancia del super objeto en codeigniter para su uso directo

        $CI->load->helper('url');
        $CI->config->load('general');
        $CI->load->library('session');

        $logeado = $CI->session->userdata('usuario_logeado'); ///Obtener datos de sesión
//        $privilegios = $CI->session->userdata('lista_roles_modulos'); //Toma los privilegios de todos los roles, no importa cual selecciono
        $privilegios[] = $CI->session->userdata('rol_seleccionado'); //tipo de usuario que inicio sesión, sólo si tiene acceso el rol seleccionado

        $controlador = $CI->uri->segment(1);  //Controlador actual o dirección actual
        $funcion_controlador = $CI->uri->segment(2);  //Función que se llama en el controlador


        if (!$logeado) {//Cuando no esta logueado el ususario
            $modulos_no_sesion = $CI->config->item('modulos_no_sesion'); //Carga roles de no logeado Roles de no logueado
//            pr($modulos_no_sesion);
            $is_acceso_pagina = get_busca_acceso_controlador_funcion($modulos_no_sesion, $controlador, $funcion_controlador); //Pregunta si tiene acceso  
//            
            //si existe el controlador, buscar que tenga acceso al metodo o funciones del controlador            
            if (!$is_acceso_pagina) {//Si no tiene acceso a pagina, redirecciona
                redirect('login');
                exit();
            }
        } else {//Logeado
            //Carga los módulos que se puede tener acceso, pero sólo con sesión iniciada
            $modulos_sesion_generales = $CI->config->item('modulos_sesion_generales');
            //Si ya inicio sesión, verifica el acceso al controlador o la URL 
            $is_acceso_pagina = get_busca_acceso_controlador_funcion($modulos_sesion_generales, $controlador, $funcion_controlador); //Pregunta si tiene acceso a modulos generales
            if (!$is_acceso_pagina) {//Si no existe, buscará en rol_seleccionado
            /**Nota: buscar en la ruta, no solo el controlador, si no tambien la funcion del controlador, como index algun otro método
             * eso en la función  "get_busca_array_nivel_profundidad_dos" 
             * 
             */
                $valor_array = get_busca_array_nivel_profundidad_dos($privilegios, $controlador, $funcion_controlador, 'ruta'); //Busca la primera incidencia con del controlador con la ruta seleccionada
//                pr($valor_array);
                if (empty($valor_array)) {//Si el array es vacio, manda a pagina no encontrada
//                    pr($rol_seleccionado);
                    redirect('rol/');
                    exit();
                }
            }
        }
    }

}
