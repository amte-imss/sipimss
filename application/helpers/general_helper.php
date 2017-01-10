<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// HELPER General
/**
 * Método que preformatea una cadena
 * @autor 		: Jesús Díaz P.
 * @param 		: mixed $mix Cadena, objeto, arreglo a mostrar
  bool $return Boleano que determina si se imprema o se retorna el valor
 * @return  	: Cadena preformateada
 */
if (!function_exists('pr')) {

    function pr($mix, $return = false) {
        if ($return) {
            return print_r($mix, TRUE);
        } else {
            echo "<pre>";
            print_r($mix);
            echo "</pre>";
        }
    }

}

/**
 * Método que valida una variable; que exista, no sea nula o vacía
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: mixed $valor Parámetro a validar
 * @return 		: bool. TRUE en caso de que exista, no sea vacía o nula de lo contrario devolverá FALSE
 */
if (!function_exists('exist_and_not_null')) {

    function exist_and_not_null($valor) {
        return (isset($valor) && !empty($valor) && !is_null($valor)) ? TRUE : FALSE;
    }

}

/**
 * Método que valida un indice dentro de un arreglo; que exista, no sea nulo o vacío
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: mixed $valor Parámetro a validar
 * @return 		: bool. TRUE en caso de que exista, no sea vacía o nula de lo contrario devolverá FALSE
 */
if (!function_exists('exist_and_not_null_array')) {

    function exist_and_not_null_array($arreglo, $llave) {
        return (array_key_exists($llave, $arreglo) && !empty($arreglo[$llave]) && !is_null($arreglo[$llave])) ? TRUE : FALSE;
    }

}

/**
 * Método que genera un arreglo asociativo de la forma llave => valor, derivado de un arreglo multidimensional
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: mixed[] $array_data 
 * @param 		: string $field_key 
 * @param 		: string $field_value 
 * @return 		: mixed[]. TRUE en caso de que exista, no sea vacía o nula de lo contrario devolverá FALSE
 * Ejemplo: $array_multi = array(
 * 		array('llave1'=>'valor1.0', 'llave2'=>'valor2.0', 'llave3'=>'valor3.0'),
 * 		array('llave1'=>'valor1.1', 'llave2'=>'valor2.1', 'llave3'=>'valor3.1'),
 * 		array('llave1'=>'valor1.2', 'llave2'=>'valor2.2', 'llave3'=>'valor3.2'),
 * )
 * dropdown_options($array_multi, 'llave2', 'llave3');
 * Resultado: array(
 * 		array('valor2.0'=>'valor3.0'),
 * 		array('valor2.1'=>'valor3.1'),
 * 		array('valor2.2'=>'valor3.2'),
 * )
 */
if (!function_exists('dropdown_options')) {

    function dropdown_options($array_data, $field_key, $field_value) {
        $options = array();
        foreach ($array_data as $key => $value) {
            $options[$value[$field_key]] = $value[$field_value];
        }
        return $options;
    }

}

/**
 * Método utilizado para mostrar un mensaje en formato predefinido
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: string $msg Texto a mostrar
 * @return 		: string Texto con formato predefinido
 */
if (!function_exists('data_not_exist')) {

    function data_not_exist($msg = null) {
        return '<h2 align="center" style="padding-top:100px; padding-bottom:100px;">' . ((exist_and_not_null($msg)) ? $msg : 'No han sido encontrados datos con los criterios seleccionados.') . '</h2>';
    }

}

/**
 * Método que crea un elemento div
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: string $label_text Contenido de la etiqueta div
 * @param 		: mixed[] $attributes Atributos de la etiqueta div
 * @return 		: string Elemento div
 */
if (!function_exists('html_div')) {

    function html_div($label_text = '', $attributes = array()) {
        $label = '<div';
        if (is_array($attributes) && count($attributes) > 0) {
            foreach ($attributes as $key => $val) {
                $label .= ' ' . $key . '="' . $val . '"';
            }
        }
        return $label . '>' . $label_text . '</div>';
    }

}

/**
 * Método que crea un elemento span
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: string $label_text Contenido de la etiqueta span
 * @param 		: mixed[] $attributes Atributos de la etiqueta span
 * @return 		: string Elemento span
 */
if (!function_exists('html_span')) {

    function html_span($label_text = '', $attributes = array()) {
        $label = '<span';
        if (is_array($attributes) && count($attributes) > 0) {
            foreach ($attributes as $key => $val) {
                $label .= ' ' . $key . '="' . $val . '"';
            }
        }
        return $label . '>' . $label_text . '</span>';
    }

}

/**
 * Método que crea un elemento p
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: string $label_text Contenido de la etiqueta p
 * @param 		: mixed[] $attributes Atributos de la etiqueta p
 * @return 		: string Elemento p
 */
if (!function_exists('html_p')) {

    function html_p($label_text = '', $attributes = array()) {
        $label = '<p';
        if (is_array($attributes) && count($attributes) > 0) {
            foreach ($attributes as $key => $val) {
                $label .= ' ' . $key . '="' . $val . '"';
            }
        }
        return $label . '>' . $label_text . '</p>';
    }

}

/**
 * Método que crea un elemento number
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: string $label_text Contenido de la etiqueta number
 * @param 		: mixed[] $attributes Atributos de la etiqueta number
 * @return 		: string Elemento p
 */
if (!function_exists('form_number')) {

    function form_number($data = '', $value = '', $extra = '') {
        $defaults = array(
            'type' => 'number',
            'name' => is_array($data) ? '' : $data,
            'value' => $value
        );

        return '<input ' . _parse_form_attributes($data, $defaults) . $extra . " />\n";
    }

}


/**
 * Método que encripta una cadena con el algoritmo sha512
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: string $matricula Cadena a codificar
 * @param 		: string $contrasenia Cadena a codificar
 * @return 		: string Cadena codificada
 */
if (!function_exists('contrasenia_formato')) {

    function contrasenia_formato($matricula, $contrasenia) {
        return hash('sha512', $contrasenia . $matricula);
    }

}

/**
 * Método que define una plantilla para los mensajes que mostrará un formulario
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: string $elemento Nombre del elemento form
 * @param 		: string $tipo Posibles valores('success','info','warning','danger')
 * @return 		: string Mensaje con formato predefinido
 */
if (!function_exists('form_error_format')) {

    function form_error_format($elemento, $tipo = null) {
        if (is_null($tipo)) {
            $tipo = 'danger';
        }
        return form_error($elemento, '<div class="alert alert-' . $tipo . '" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    }

}

/**
 * Método que define una plantilla para los mensajes que se mostrarán con bootstrap
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: string $message Texto a mostrar
 * @param 		: string $tipo Posibles valores('success','info','warning','danger')
 * @return 		: string Mensaje de alerta con formato predefinido
 */
if (!function_exists('html_message')) {

    function html_message($message, $tipo = null) {
        if (is_null($tipo)) {
            $tipo = 'danger';
        }
        return '<div class="alert alert-' . $tipo . '" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message . '</div>';
    }

}

/**
 * Método que define una plantilla para los mensajes que se mostrarán con bootstrap
 * @autor     : Jesús Díaz P.
 * @modified  : 
 * @param     : string $message Texto a mostrar
 * @param     : string $tipo Posibles valores('success','info','warning','danger')
 * @return    : string Mensaje de alerta con formato predefinido
 */
if (!function_exists('imprimir_resultado')) {

    function imprimir_resultado($resultado) {
        $tipo_mensaje = ($resultado['result'] === true) ? 'success' : 'danger';

        return '<div id="js_msg" class="row">
                <div class="col-lg-12 alert alert-' . $tipo_mensaje . '">
                    ' . $resultado['msg'] . '
                </div>
            </div>';
    }

}

/**
 * Método que obtiene un listado de archivos de la ruta otorgada
 * @autor 		: Jesús Díaz P.
 * @modified 	: 
 * @param 		: string $path Ruta de donde se obtendrá el listado de archivos
 * @return 		: mixed[] $result Listado de archivos
 */
if (!function_exists('get_files')) {

    function get_files($path) {
        return scandir($path);
    }

}

// ------------------------------------------------------------------------
if (!function_exists('merge_arrays')) {

    function merge_arrays($key, $value) {
        return $key . '="' . $value . '" ';
    }

}

/**
 * Método que hace una intersección entre dos array 
 * @autor 		: Luis E. A.S.
 * @modified            : 
 * @param 		: array $array_1 a comparar con $array_2
 * @return 		: $array_result  de intersección entré dor arrays 
 */
if (!function_exists('filtra_array_por_key')) {

    function filtra_array_por_key($array_bidimencional, $array_unidimencional) {
        $is_array = exist_and_not_null($array_bidimencional);
        $is_array = $is_array && exist_and_not_null($array_unidimencional);
        $is_array = $is_array && is_array($array_bidimencional);
        $is_array = $is_array && is_array($array_unidimencional);
        $array_result = array();
        if ($is_array) {
            foreach ($array_unidimencional as $value) {
                foreach ($array_bidimencional as $key => $value_2) {
                    if ($value == $key) {
                        $array_result[$key] = $value_2;
                    }
                }
            }
            return $array_result;
        } else {
            return null;
        }
    }

}

if (!function_exists('get_propiedades_boton')) {

    function get_propiedades_boton($array_opciones_privilegios = null, $index = -1) {
        //id,value,tipe
        if (exist_and_not_null($array_opciones_privilegios)) {
            $existe_indice = array_key_exists($index, $array_opciones_privilegios);
            if (array_key_exists($index, $array_opciones_privilegios)) {
                $propiedades = $array_opciones_privilegios[$index];
                if (exist_and_not_null($propiedades)) {
//                    return array('id' => $propiedades['id'], 'type' => $propiedades['value'], 'value' => $propiedades['value'], 'attributes' => $propiedades['attributes']);
                    return $propiedades;
                }
            }
        }
        return null;
//        $array_listado = $this->config->item('listado_tareas');
//        pr($array_listado[$index]);
//        $is_array = exist_and_not_null($array_opciones_privilegios);
//        $array_result = array();
//        if ($is_array) {
//            $i = 0;
//            foreach ($array_opciones_privilegios as $key => $value) {
//                foreach ($value as $k => $v) {
//                    $bono = $this->config->item($key);
//                    $array_config = $bono[$k][$v]; //Estados
//                    $array_result[$key] = $array_config;
//                }
//            }
//            return $array_result;
//        } else {
//            return null;
//        }
    }

}

if (!function_exists('get_array_valor')) {

    function get_array_valor($array_busqueda = null, $key = null) {
        if (is_null($array_busqueda) || is_null($key)) {
            return array();
        }
        if (array_key_exists($key, $array_busqueda)) {
            $array_result = $array_busqueda[$key];
            return $array_result;
        }
        return array();
    }

}

if (!function_exists('crear_formato_array')) {

    /**
     * @author : LEAS <cenitluis.pumas@gmail.com>
     * @Fecha creación : 25-05-2016
     * @Fecha modificación : 
     * @param type $array_value : Array ha analizar
     * @param type $key_ref : Llave de referencia del arreglo que será el index
     * del arreglo formateado
     * @param type $not_index_auto_incrementables : En false le agregará 
     * un index autoincrementable, y en true se lo quita y sólo le agrega el $keyref 
     * @return array[] 
     * <p>
     * Array
      (
      [3] => Array
      (
      [0] => Array
      (
      [nombre_rol] => Ayudante
      [cve_modulo] => 3
      [nombre_modulo] => Comisiones académicas
      )

      )

      [4] => Array
      (
      [0] => Array
      (
      [nombre_rol] => Instructor de prácti
      [cve_modulo] => 2
      [nombre_modulo] => Formación del docente
      )

      [1] => Array
      (
      [nombre_rol] => Instructor de prácti
      [cve_modulo] => 3
      [nombre_modulo] => Comisiones académicas
      )

      )
      )

     * </p>
     */
    function crear_formato_array($array_value, $key_ref, $not_index_auto_incrementables) {
        $array_modulo = array();
        $index = -1;
        if ($not_index_auto_incrementables) {
            /* Le asigna la llave de referencia $key_ref al formato y no le agrega 
             * index autoincrementables
             */
            for ($i = 0; $i < count($array_value); $i++) {
                $index = $array_value[$i][$key_ref];
                if (array_key_exists($index, $array_modulo)) {
                    $index_num_siguiente = count($array_modulo[$index]);
                    $array_modulo[$index] = array();
                } else {
                    $array_modulo[$index] = array();
                }
                foreach ($array_value[$i] as $key => $value) {
                    if ($key != $key_ref) {
                        $array_modulo[$index][$key] = $value;
                    }
                }
            }
        } else {
            /* Le  asigna un index auto incrementable que va desde "0" ,...., "n"
              al formato del array */
            for ($i = 0; $i < count($array_value); $i++) {
                $index = $array_value[$i][$key_ref];
                if (array_key_exists($index, $array_modulo)) {
                    $index_num_siguiente = count($array_modulo[$index]);
                    $array_modulo[$index][$index_num_siguiente] = array();
                } else {
                    $index_num_siguiente = 0;
                    $array_modulo[$index][$index_num_siguiente] = array();
                }
                foreach ($array_value[$i] as $key => $value) {
                    if ($key != $key_ref) {
                        $array_modulo[$index][$index_num_siguiente][$key] = $value;
                    }
                }
            }
        }
        return $array_modulo;
    }

}

if (!function_exists('crear_lista_asociativa_valores')) {

    /**
     * 
     * @param type : $array_value array de busqueda
     * @param type : $key_ref llave busqueda
     * @param type : $val_ref valor asociación
     * @return type : array 
     */
    function crear_lista_asociativa_valores($array_value, $key_ref, $val_ref) {
        $array_lista_roles = array();
        $key = -1;
        $value = '';
        for ($i = 0; $i < count($array_value); $i++) {
            $key = $array_value[$i][$key_ref];
            $value = $array_value[$i][$val_ref];
            $array_lista_roles[$key] = $value;
        }

        return $array_lista_roles;
    }

}

if (!function_exists('get_busca_acceso_controlador_metodo')) {

    /**
     * 
     * @param type $array_busqueda Array donde buscará la existencia del controlador o del método
     * @param type $controlador  Controlador a buscar
     * @param type $metodo_controlador Método que incluye el controlador
     * @return boolean True si existe, false si no
     */
    function get_busca_acceso_controlador_funcion($array_busqueda = null, $controlador = null, $metodo_controlador = null) {
        //Si el arreglo es null y vacio, retorna false 
//        pr($array_busqueda);
        if (is_null($array_busqueda) AND empty($array_busqueda)) {
            return FALSE;
        }
        //Si el controlador a buscar es vacio, retorna FALSE
        if (is_null($controlador) AND empty($controlador)) {
            return FALSE;
        }

        if (strlen(trim($metodo_controlador)) == FALSE) {
            $metodo_controlador = 'index';
        }

//        pr($controlador);
//        pr('metodo ' . $metodo_controlador);
        //Buscar el controlador en el array 
        $existe_controlador = array_key_exists($controlador, $array_busqueda);

        if ($existe_controlador) {//Si existe el controlador, buscar en los metodos el acceso
            $array_valor = $array_busqueda[$controlador]; //Obtiene valor de la llave
            //verifica si el valor es un arreglo o un valor normal
            if (is_array($array_valor)) {//Si es array, busca valor
                $existe_metodo = in_array('*', $array_valor) ? 1 : //Si exite el * (todos) tendá acceso
                        in_array($metodo_controlador, $array_valor); //Busca si existe el valor
                return $existe_metodo;
            } else {
//                pr('holas');
                //Verifica que el valor tenga acceso a todo con el caracter "*"
                $is_todos = $array_valor == '*';
                return $is_todos;
            }
        }

        //Si no existe el controlador, retorna false
        return 0;
    }

}


if (!function_exists('get_busca_array_nivel_profundidad_dos')) {

    /**
     * 
     * @param type $array_busqueda
     * @param type $controlador
     * @param type $metodo_controlador
     * @param type $llave
     * @return int|array
     */
    function get_busca_array_nivel_profundidad_dos($array_busqueda = null, $controlador = null, $metodo_controlador = 'index', $llave = null) {
        //Si el arreglo es null y vacio, retorna false 
//        pr($array_busqueda);
        $array_result = array();
        if (is_null($array_busqueda) AND empty($array_busqueda)) {
            return $array_result;
        }
        //Si el controlador a buscar es vacio, retorna FALSE
        if (is_null($controlador) AND empty($controlador)) {
            return $array_result;
        }
        foreach ($array_busqueda as $value_array_n1) {
            foreach ($value_array_n1 as $key_n2 => $value_array_n2) {
                if (is_array($value_array_n2) AND array_key_exists($llave, $value_array_n2)) {//Verifica que sea un array y que se encuentrá la llave
                    $valor_analizar = $value_array_n2[$llave];
                    if ($valor_analizar === $controlador) {//Si la llave es diferente de null y no es vacia
                        $array_result = $value_array_n2; //Retorna el array encontrado
                        break 2;
                    }
                }
            }
        }

        //Si no existe el controlador, retorna false
        return $array_result;
    }

}

if (!function_exists('get_busca_hijos')) {

    /**
     * @author LEAS
     * @param  type $array_busqueda
     * @param  type $controlador
     * @return array
     */
    function get_busca_hijos($array_busqueda = null, $controlador = null) {
        //Si el arreglo es null y vacio, retorna false 
        $array_result = array();
        pr($controlador);
        if (is_null($array_busqueda) AND empty($array_busqueda)) {
            return $array_result;
        }
        pr($array_busqueda);
        foreach ($array_busqueda as $keys => $valores) {
            $cad1 = strtolower($controlador);
//            $cad2 = strtolower($valores['nombre_padre']);
            $cad2 = strtolower($valores['ruta_padre']);
            if (!empty($valores['padre']) AND ( $cad1 === $cad2)) {
                $array_result[$keys] = $valores;
            }
        }

        //Si no existe el controlador, retorna false
        return $array_result;
    }

}

if (!function_exists('get_ip_cliente')) {

    /**
     * @author LEAS
     * @return ip del cliente: obtiene la ip del cliente, por tres tipos de casos, 
     * hasta obtener una ip: 
     * 1 por IP compartido = HTTP_CLIENT_IP;
     * 2 por IP Proxy = HTTP_X_FORWARDED_FOR;
     * 3 por IP Acceso = REMOTE_ADDR;
     * 
     */
    function get_ip_cliente() {
        $ip_cliente = '';
        $conexiones_ip = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR');
        foreach ($conexiones_ip as $value) {
            if (isset($_SERVER[$value]) AND ! empty($_SERVER[$value])) {
                $ip_cliente = $_SERVER[$value];
                break;
            }
        }
        return $ip_cliente;
    }

}
if (!function_exists('guardar_archivos')) {

    /**
     * 
     * @param type $file_name
     * @param type $directorio ejemplo ./uploads/
     * @param type $extencion
     * @param type $max_size_file
     */
    function guardar_archivos($file_name = null, $client_file_componente = 'userfile', $directorio = './uploads/', $extencion = 'pdf', $max_size_file = '50000') {
        $config['upload_path'] = $directorio;
        $config['allowed_types'] = $extencion;
        $config['max_size'] = $max_size_file;
        $config['overwrite'] = TRUE;
        $config['file_name'] = $file_name;
        $CI = & get_instance();
        $CI->load->library('upload', $config);
        if (!$CI->upload->do_upload($client_file_componente)) {
            $data['error'] = $CI->upload->display_errors();
        } else {

            $file_data = $CI->upload->data();
            $data['file_path'] = $directorio . $file_data['file_name'];
        }
        return $data;
    }

}
if (!function_exists('eliminar_archivo')) {

    /**
     * 
     * @param type $path
     * @param type $file_name
     * @param type $extencion
     */
    function eliminar_archivo($path, $file_name, $extencion = '.pdf') {
        $path .= $file_name . $extencion;
        if (file_exists($path)) {
            return unlink($path);
        }
        return FALSE;
    }

}

/**
 * Método que da formato a la antiguedad del usuario
 * @autor     : Jesús Díaz P.
 * @modified  : 
 * @param     : string $antiguedad Cadena que representa la antiguedad
 * @return    : string $result Cadena con nuevo formato
 */
if (!function_exists('antiguedad_format')) {

    function antiguedad_format($antiguedad) {
        $result = explode('_', $antiguedad);
        return (count($result) === 3) ? $result[0] . ' a&ntilde;os ' . $result[1] . ' quincenas ' . $result[2] . ' d&iacute;as' : $antiguedad;
    }

}
/* End of file general_helper.php */

/* if (!function_exists('html_verificar_validacion_registro')) {

  function html_verificar_validacion_registro($valor = 0, $color = 0) {
  return ($valor > 0 || $color == 1) ? '<span class="class_validacion_registro ' . (($color == 1) ? 'text-black' : '') . ' glyphicon glyphicon-ok-sign" data-toggle="tooltip" data-placement="left" title="' . (($color == 1) ? 'Validación confirmada por profesionalización' : 'Validación realizada') . '"></span>' : '-';
  }

  } */

if (!function_exists('genera_botones_estado_validacion')) {

    function genera_botones_estado_validacion($paramentros) {
        $mensaje = "No se encontrarón opciones";
        if (isset($paramentros['msj_vacio'])) {
            $mensaje = $paramentros['msj_vacio']; //Validador N1, Validador N2, Profesionalización o docente-->
        }

        $estado_actual = $paramentros['estado_actual'];
        $tipo_validador_rol = $paramentros['tipo_validador_rol']; //Validador N1, Validador N2, Profesionalización o docente-->
        $delegacion_validador = $paramentros['delegacion_cve']; //Validador N1, Validador N2, Profesionalización o docente-->
//        pr($estado_actual);
//        pr($tipo_validador_rol);
        $CI = & get_instance();
        $propiedades_gen_estado = $CI->config->item('estados_val_censo'); //Carga las propiedades de los estados de la validación del censo de docentes
        $valida_acceso_rol = valida_acceso_rol_validador($tipo_validador_rol, $estado_actual); //Valida el acceso al rol seleccionado
        $respuesta_html_botones = array();
        if ($valida_acceso_rol == 1) {//**Tiene acceso el validar el estado actual la validación del docente 
            $pro_estado_actual = $propiedades_gen_estado[$estado_actual]; //Carga el estado actual del docente 
//            Enum_ev::Por_validar_n1;
//            pr($pro_estado_actual);
//            $estado_transicion = $pro_estado_actual['estados_transicion'];
            $CI->load->library('seguridad');

            foreach ($pro_estado_actual['estados_transicion'] as $value_est_trans) {//Obtiene estados de trancision
                $estados_trans = $propiedades_gen_estado[$value_est_trans];
//                pr($estados_trans['is_boton']);
                if ($estados_trans['is_boton']) {//Verifica si es un botón o el cambio va implicito por el sistema, como es el caso del cambio de estado a "En revision por .."
//                    pr($value_est_trans);
                    $value_est_trans = $CI->seguridad->encrypt_base64($value_est_trans);
//                    $tipo_transicion = $CI->seguridad->encrypt_base64($estados_trans['color_status']);
                    $respuesta_html_botones[] = '<button '
                            . 'type="button" '
                            . 'class="btn btn-success" '
                            . 'data-estadocambiocve ="' . $value_est_trans . '"'
//                            . 'data-tipotransicion ="' . $tipo_transicion . '"'
                            . 'onclick=' . $estados_trans['funcion_demandada'] . '>' .
                            $estados_trans['value_boton']
                            . '</button>';
                }
            }
        }

        return $respuesta_html_botones;
    }

}
if (!function_exists('valida_acceso_rol_validador')) {

    /**
     * @author LEAS
     * @fecha 31/08/2016
     * @param type $rol_validador Rol que intenta validar el estado actual del docente
     * @param type $estado_validacion  Estado actual que se pretende validar por dicho rol
     * @return int 0=No tiene acceso el rol a la validación 1=Tiene acceso el rol a la validación
     */
    function valida_acceso_rol_validador($rol_validador, $estado_validacion, $reglas_estados = 'estados_val_censo') {
        if (!is_null($estado_validacion) AND ! is_null($rol_validador) AND ! empty($estado_validacion) AND ! empty($rol_validador)) {
            $CI = & get_instance();
            $propiedades_gen_estado = $CI->config->item($reglas_estados)[$estado_validacion];
            //Valida el acceso al rol seleccionado
            $valida_acceso_rol = 0;
            foreach ($propiedades_gen_estado['rol_permite'] as $value_rol) {
                if ($value_rol === $rol_validador) {//Si algún rol coinside, acepta el acceso al rol y termina el recorrido del foreach()
                    $valida_acceso_rol = 1;
                    break;
                }
            }
            return $valida_acceso_rol;
        } else {
            return 0;
        }
    }

}

if (!function_exists('get_convocatoria_delegacion')) {

    /**
     * @author LEAS
     * @fecha 05/09/2016 
     * @param type $delegacion_cve
     * @return int 0 No existe la convocatoria
     */
    function get_convocatoria_delegacion_val_censo($delegacion_cve, $rol = Enum_rols::Profesionalizacion) {
        $CI = & get_instance();
        $CI->load->model('Catalogos_generales', 'cg');
        $convocatoria = $CI->cg->get_convocatoria_delegacion($delegacion_cve);
        if (!empty($convocatoria)) {
//            pr($convocatoria->aplica_convocatoria);
//            pr($rol);
            switch ($convocatoria->aplica_convocatoria) {
                case 'sin'://Ya se registro la convocatoria, pero aún no inicía
                    $valida_paso_convocatoria = 0;
                    break;
                case 'act'://Inicia la carga de datos por el docente
                    $valida_paso_convocatoria = ($rol === Enum_rols::Docente) ? 1 : 0;
                    break;
                case 'vf1'://Periodo de validacion por el nivel 1
                    $valida_paso_convocatoria = ($rol === Enum_rols::Validador_N1) ? 1 : 0;
                    break;
                case 'vf2'://Periodo de validación por nivel 2
                    $valida_paso_convocatoria = ($rol === Enum_rols::Validador_N2) ? 1 : 0;
                    break;
                case 'nap'://Convocatoria liberada
                    $valida_paso_convocatoria = 1;
                    break;
            }
            //Existe la convocatoría
            return array('idconv' => $convocatoria->convocatoria_cve, 'aplica_conv_rol' => $valida_paso_convocatoria);
        } else {
            return array(); //NO existe una convocatoría
        }
    }

}

if (!function_exists('genera_botones_estado_validacion_evaluacion')) {

    function genera_botones_estado_validacion_evaluacion($paramentros) {
        $mensaje = "No se encontrarón opciones";
        if (isset($paramentros['msj_vacio'])) {
            $mensaje = $paramentros['msj_vacio']; //Validador N1, Validador N2, Profesionalización o docente-->
        }

        $estado_actual = $paramentros['estado_actual'];
        $tipo_validador_rol = $paramentros['tipo_validador_rol']; //Validador N1, Validador N2, Profesionalización o docente-->
        $delegacion_validador = $paramentros['delegacion_cve']; //Validador N1, Validador N2, Profesionalización o docente-->
        pr($estado_actual);
        pr($tipo_validador_rol);
        $CI = & get_instance();
        $propiedades_gen_estado = $CI->config->item('estados_val_evaluacion'); //Carga las propiedades de los estados de la validación del censo de docentes
        $valida_acceso_rol = valida_acceso_rol_validador($tipo_validador_rol, $estado_actual, 'estados_val_evaluacion'); //Valida el acceso al rol seleccionado
        $respuesta_html_botones = array();
        if ($valida_acceso_rol) {//**Tiene acceso el validar el estado actual la validación del docente 
            $pro_estado_actual = $propiedades_gen_estado[$estado_actual]; //Carga el estado actual del docente 
//            $estado_transicion = $pro_estado_actual['estados_transicion'];
            $CI->load->library('seguridad');
            /* Valida convocatoria para n1 y n2 por delegación */
            if ($tipo_validador_rol == Enum_rols::Validador_N1 || $tipo_validador_rol == Enum_rols::Validador_N2) {
                $pasa_convocatoria_val = get_convocatoria_delegacion_val_censo($delegacion_validador, $tipo_validador_rol);
            }
//            pr($pro_estado_actual['estados_transicion']);
            foreach ($pro_estado_actual['estados_transicion'] as $value_est_trans) {
                $estados_trans = $propiedades_gen_estado[$value_est_trans];
                if ($estados_trans['is_boton']) {//Verifica si es un botón o el cambio va implicito por el sistema, como es el caso del cambio de estado a "En revision por .."
//                    pr($value_est_trans);
                    $value_est_trans = $CI->seguridad->encrypt_base64($value_est_trans);
//                    $tipo_transicion = $CI->seguridad->encrypt_base64($estados_trans['color_status']);
                    $respuesta_html_botones[] = '<button '
                            . 'type="button" '
                            . 'class="btn btn-success" '
                            . 'data-estadocambiocve ="' . $value_est_trans . '"'
//                            . 'data-tipotransicion ="' . $tipo_transicion . '"'
                            . 'onclick=' . $estados_trans['funcion_demandada'] . '>' .
                            $estados_trans['value_boton']
                            . '</button>';
                }
            }
        }

        return $respuesta_html_botones;
    }

}

if (!function_exists('obtener_cursos_bloque_seccion_evaluacion')) {

    /**
     * @author LEAS
     * @FECHA  05/10/2016
     * @param type $fuente_cursos .- cursos totales por bloque y sección, se obtiene de modelo Expediente_mode->getAll();
     * @param type $propiedades_curso
     * @param type $cursos_solicitados
     * Intersecta los cursos que se solicito evaluar y, con separacion por bloque y sección Expediente_model
     */
    function obtener_cursos_bloque_seccion_evaluacion($fuente_cursos, $propiedades_curso, $cursos_solicitados) {
        $acro_b = 'bloque_';
        $acro_s = 'seccion_';
        $array_result = array();
//        pr($fuente_cursos);
        foreach ($cursos_solicitados as $curso) {

            $curso_cve = $curso['curso_registro_cve'];
            $bloque_cur_c = $acro_b . $curso['bloque_seccion']; //Bloque compuesto con el sufijo 'bloque_'
            $seccion_cur_c = $acro_s . $curso['seccion_cve']; //Sección compuesta con el sufijo 'seccion_'
            $bloque = $curso['bloque_seccion']; //Bloque acronimo ejem. 'F', 'AC',...,"x"
            $seccion = $curso['seccion_cve']; //Seccioón identificador 1,2,3,4,...,"n"
//            pr($fuente_cursos[$bloque_cur_c][$seccion_cur_c]);
            if ($bloque == Enum_sec::B_INVESTIGACION_EDUCATIVA) {
//                pr($curso_cve);
//                pr($seccion);
//                pr($fuente_cursos[$bloque_cur_c]);
            }
            if (isset($fuente_cursos[$bloque_cur_c][$seccion_cur_c]) AND ! empty($fuente_cursos[$bloque_cur_c][$seccion_cur_c])) {
                //Si no existe la el bloque y la sección lo crea
                if (!isset($array_result[$bloque][$seccion])) {
                    $array_result[$bloque][$seccion] = array();
                }
                //Busca el curso en la fuente de cursos
                $pk = $propiedades_curso[$bloque][$seccion]['pk']; //Obtiene el nombre de la llave primaria del bloque y la sección seleccionada 
                foreach ($fuente_cursos[$bloque_cur_c][$seccion_cur_c] as $datos_cur) {//Recorre los cursos de la seccion, hasta encontrar el curso
//                    pr($datos_cur);
                    if (isset($datos_cur[$pk]) AND intval($datos_cur[$pk]) == intval($curso_cve)) {
//                        pr($curso_cve .' => '.$datos_cur[$pk]);
                        $array_result[$bloque][$seccion][] = $datos_cur; //Agrega el curso 
                        break; //Sale, por que ya encontro el curso
//                          pr($datos_cur[$pk] . ' => ' . $curso_cve);
//                    } else {
//                        pr($datos_cur);
                    }
                }
            }
        }
//        pr($array_result);
        return $array_result;
    }

}

if (!function_exists('recorrer_array_encontrar_hijos_vacios')) {

    /**
     * @author LEAS
     * @FECHA  05/10/2016
     * @param type $fuente_cursos .- cursos totales por bloque y sección, se obtiene de modelo Expediente_mode->getAll();
     * @param type $propiedades_curso
     * @param type $cursos_solicitados
     * Intersecta los cursos que se solicito evaluar y, con separacion por bloque y sección Expediente_model
     */
    function recorrer_array_encontrar_hijos_vacios($fuente_cursos, $propiedades_curso, $cursos_solicitados) {
        
    }

}

if (!function_exists('get_is_interseccion_muestreo')) {

    /**
     * @author LEAS
     * @FECHA  24/10/2016
     * @param type $rol_actual Puede ser N1, N2 o profesionalización
     * @param type $array_hist_validacion_convocatoria $Conjunto de estados de validación del docente en una convocatoria "X"
     * @return type Description Si no existe una intersección retorna 0 si no retorna 1
     * Para que se considere una intersección, N1 y N2 deberan contener a un docente igual para validar
     */
    function get_is_interseccion_muestreo($rol_actual, $array_hist_validacion_convocatoria) {
//        pr($rol_actual);
//        pr($array_hist_validacion_convocatoria);
        if ($rol_actual != Enum_rols::Profesionalizacion) {//Los roles deberán ser N1 y N2
            $rol_actual = intval($rol_actual);
            foreach ($array_hist_validacion_convocatoria as $value) {
                $rol_validador = intval($value['rol_validador']);
                if (!empty($rol_actual) AND $rol_validador > 0 AND $rol_actual != $rol_validador AND $rol_validador != Enum_rols::Profesionalizacion) {//Si rol validador no es vacio y es diferente al rol actual, se dice que existe una intersección con un validador de nivel diferente
//                pr(($rol_actual != $rol_validador) . ' '.$rol_validador);
                    return 1; //si un validador N1 contiene como parte del muestreo para validar un docente y N2 también, es una interseccion  
                }
            }
        }
        return 0;
    }

}

if (!function_exists('get_valida_tiempo_convocatoria_rol')) {

    /**
     * @author LEAS
     * @FECHA  24/10/2016
     * @param type $rol_actual Puede ser N1, N2 o profesionalización
     * @param type $etapa_convocatoria
     * @return type Description Valida la etapa de la convocatoria del censo 
     */
    function get_valida_tiempo_convocatoria_rol($rol_actual, $etapa_convocatoria, $is_inteseccion = 0) {
//        pr('rol --> '.$rol_actual);
//        pr('convoca --> '.$etapa_convocatoria);
//        pr($array_hist_validacion_convocatoria);
        $CI = & get_instance();
        $CI->load->model('Catalogos_generales', 'cg');
        $reglasValidacionConvocatoria = $CI->cg->getReglasValidacionConvocatoria($is_inteseccion); //Carga las reglas de validacion de la onvocatoria
        if (is_null($rol_actual) AND is_null($etapa_convocatoria)) {
            return 0;
        }
        if (isset($reglasValidacionConvocatoria[$rol_actual])) {
            return (in_array($etapa_convocatoria, $reglasValidacionConvocatoria[$rol_actual])) ? 1 : 0;
        } else {
            return 0;
        }
    }

}
