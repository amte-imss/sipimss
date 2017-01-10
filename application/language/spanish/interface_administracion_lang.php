<?php
/**
 * Archivo que contiene los textos del sistema
 * Contrucción del índice.
 * 	- Archivo fuente: interface_
 * 	- Modulo: login
 *  - Controlador: login
 *  - Identificador único del texto dentro del arreglo: texto_bienvenida
 * 		Ej:
 * 			$lang['interface_login']['login']['texto_bienvenida'] = 'Bienvenido al sistema SIPIMSS';
 * 			$lang['interface_login']['login']['texto_usuario'] = 'Usuario:';
 * 			$lang['interface_login']['login']['texto_contrasenia'] = 'Contraseña:';
 * 			$lang['interface_censo']['formacion']['texto_bienvenida'] = '...';
 * 			$lang['interface_censo']['actividad']['texto_bienvenida'] = '...';
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//$lang['interface_'][''][''] = '';
//$lang['interface']['registro']['texto_bienvenida'] = 'Hola mundo';
$lang['interface_administracion'] = array(
    'usuario' => array(
        'buscador' => array(
            'titulo' => 'Administración de usuarios',
            'titulo_agregar' => 'Agregar usuario',
            'tab_head_matricula' => 'Matrícula',
            'tab_head_nombre' => 'Nombre',
            'tab_head_delegacion' => 'Delegación',
            'tab_head_adscripcion' => 'Adscripción',
            'tab_head_rol' => 'Rol',
            'tab_head_estado' => 'Estado',
            'fil_mat_nom' => 'Nombre del usuario o matricula',
            'fil_delegacion' => 'Delegación',
            'fil_rol' => 'Rol',
            'fil_estado' => 'Estado del usuario',
            'lbl_por_validar' => 'Matrícula por validar',
            'txt_del_mat' => 'Debe seleccionar la delegación y escribir la matrícula.'
        ),
        'formulario' => array(
            'titulo_formulario' => 'Gestionar usuario',
            'error_del_mat' => 'No existe usuario registrado con esos datos, favor de verificarlo.',
            'btn_administrar_rol' => 'Administrar rol',
            'btn_administrar_modulo' => 'Administrar modulo',
        ),
        'model' => array(
            'insercion' => 'Se ha insertado correctamente la información.',
            'actualizacion' => 'Se ha actualizado correctamente la información.',
            'eliminacion' => 'Se ha eliminado correctamente.',
            'error' => 'Ocurrió un error, por favor intentelo de nuevo más tarde.',
        ),
        /*'buscador_dictamen' => array(
            'titulo_dictamen' => 'Administrar dictamen',
            'agregar_dictamen' => 'Agregar dictamen',
            'tab_head_fecha_inicia_evaluacion' => 'Fecha inicio de evaluación',
            'tab_head_fecha_fin_evaluacion' => 'Fecha final de evaluación',
            'tab_head_fecha_fin_inconformidad' => 'Fecha final de inconformidad',
        ),
        'general' => array(
            'acciones' => 'Acciones',
            'editar' => 'Editar',
            'eliminar' => 'Eliminar',
            'enviar' => 'Enviar',
            'cancelar' => 'Cancelar',
            'no_existe_datos' => 'No existen datos.',
            'confirmar_eliminacion' => 'Confirme que realmente desea eliminar los datos',
            'compare_date' => 'El campo %s debería ser menor o igual que el campo predecesor.',
        ),*/
        'rol_modulo' => array(
            'titulo' => 'Administración rol - modulo',
            'texto' => '¿Esta seguro de modificar los permisos?\n<br>Los cambios realizados afectaran a todos los <br>usuarios que pertecezcan a los roles modificados.'
        )
    ),
    'catalogos' => array(
        'cdelegacion' => 'Delegación: '
    ),
    'general' => array(
        'acciones' => 'Acciones',
        'editar' => 'Editar',
        'eliminar' => 'Eliminar',
        'enviar' => 'Enviar',
        'cancelar' => 'Cancelar',
        'no_existe_datos' => 'No existen datos.',
        'confirmar_eliminacion' => 'Confirme que desea desactivar el registro',
        'compare_date' => 'El campo %s debería ser menor o igual que el campo predecesor.',
        'detalle_fechas' => 'Detalle de fechas'
    ),
);
//$lang['interface_registro_profesor'] = 'Impresión de texto prueba';
//$lang['interface_otro_mensaje'] = '&lsaquo; Primero';
