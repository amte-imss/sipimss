<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['salt'] = "B0no5"; ///SALT

$config['minDate'] = '01/01/1980';

$config['superadmin'] = 5;

$config['upload_config'] = array(
        'comprobantes'=>array(
            'upload_path'=>'./assets/files/comprobantes/',
            'allowed_types'=>'pdf',
            'remove_spaces'=>TRUE,
            'max_size'=>1024 * 15,
            'detect_mime'=>true,
            'file_name'=>'tmp_comprobante',
        ),
    );

$config['extension_comprobante'] = array('pdf');

$config['modulos_no_sesion'] = array(
    'login' => array('index', 'cerrar_session', 'cerrar_session_ajax'),
    'registro' => array('*'),
    'account' => array('*'),
    'pagina_no_encontrada' => array('index'),
    'recuperar_contrasenia' => '*',
    'captcha' => '*'
);
$config['modulos_sesion_generales'] = array(
    'login' => array('cerrar_session', 'cerrar_session_ajax'),
    'rol' => '*',
    'pagina_no_encontrada' => array('index'),
    'pruebas' => '*'
);

$config['institucion'] = array('avala'=>'A', 'imparte'=>'I');

$config['categorias_designar_validador'] = array('36112580','35312180');

/////Ruta de solicitudes
$config['ruta_documentacion'] = $_SERVER["DOCUMENT_ROOT"] . "/sipimss_bonos/assets/files/archivos_bono/";
$config['ruta_documentacion_web'] = asset_url() . 'files/archivos_bono/'; //base_url()."assets/files/solicitudes/";

$config['tiempo_eliminar_archivo'] = 60 * 10; //3600 = 1 hora => Tiempo que no será considerado para eliminación de archivo. Referencia administración/eliminar_archivos

$config['numero_registros_eliminar'] = 100;

$config['tiempo_fuerza_bruta'] = 60 * 60; //3600 = 1 hora => Tiempo válido para chequeo de fuerza bruta

$config['intentos_fuerza_bruta'] = 10; ///Número de intentos válidos durante tiempo 'tiempo_fuerza_bruta'

$config['tiempo_recuperar_contrasenia'] = 60 * 60 * 24; //3600 * 24 = 86400 = 1 día => Límite de tiempo que estará activo el link

$config['meses'] = array(1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre');

$config['rol_admin'] = array('COORDINADOR' => array('id' => 1, 'text' => 'Coordinador'), 'VALIDADOR' => array('id' => 2, 'text' => 'Validador'), 'TITULAR' => array('id' => 3, 'text' => 'Titular del programa'));

$config['bon_pro_eva_min'] = (float) 80.00;

$config['bon_sum_act_min'] = 26;

$config['cestado_usuario'] = array('ACTIVO'=>array('id'=>1), 'INACTIVO'=>array('id'=>2), 'RESTABLECERCONTRASENIA'=>array('id'=>3), 'RESTABLECERCMA'=>array('id'=>4));

$config['USU_GENERO'] = array('M'=>'Masculino', 'F'=>'Femenino', 'H'=>'Masculino');

$config['categoria_participante'] = array('36112580', '35312180');

$config['EFPCS_FOR_INICIAL'] = array(
    'INICIAL'=>array('id'=>1, 'datos'=>array(2, 4)), 'CONTINUA'=>array('id'=>2, 'datos'=>array(5,6,7,9,10,12,13)), 'LICENCIATURA'=>array('id' => 4)
);

$config['alert_msg'] = array(
    'SUCCESS' => array('id_msg' => 1, 'class' => 'success'),
    'DANGER' => array('id_msg' => 2, 'class' => 'danger'),
    'WARNING' => array('id_msg' => 3, 'class' => 'warning'),
    'INFO' => array('id_msg' => 4, 'class' => 'info')
);

$config['tipo_comision'] = array(
    'DIRECCION_TESIS' => array('id'=>1),
    'COMITE_EDUCACION' => array('id'=>3),
    'SINODAL_EXAMEN' => array('id'=>4),
    'COORDINADOR_TUTORES' => array('id'=>5),
    'COORDINADOR_CURSO' => array('id'=>6)
);

$config['tipo_curso'] = array(
    'FORMACION_INICIAL' => array('id'=>1),
    'FORMACION_CONTINUA' => array('id'=>2),
    'EDUCACION_CONTINUA' => array('id'=>3),
    'CURSO_INTERACTIVO' => array('id'=>4)
);

$config['parametros_bitacora'] = array(
        'USUARIO_CVE' => 'NULL', 
        'BIT_OPERACION' => 'NULL',
        'BIT_IP' => 'NULL', 
        'BIT_RUTA' => 'NULL', 
        'MODULO_CVE' => 'NULL',
        'ENTIDAD' => 'NULL', 
        'REGISTRO_ENTIDAD_CVE' => 'NULL',
        'PARAMETROS_JSON' => 'NULL');
$config['parametros_log'] = array('USUARIO_CVE' => 'NULL', 'LOG_INI_SES_IP' => 'NULL',
    'INICIO_SATISFACTORIO' => 'NULL');

$config['catalogos_indexados'] = array(//Catógos generales que existen actualmente y su identificación
    1 => 'cmodalidad',
    2 => 'licenciatura',
    3 => 'cmodulo',
    4 => 'carea',
    5 => 'cmateria',
    6 => 'ccurso',
    7 => 'cinstitucion_avala',
    8 => 'ctipo_actividad_docente',
    9 => 'crol_desempenia',
    10 => 'ctipo_comprobante',
    11 => 'ctipo_licenciatura',
    12 => 'ctipo_curso',
    13 => 'ctipo_especialidad',
    14 => 'ctipo_formacion_profesional',
    15 => 'ctipo_participacion',
    16 => 'ctipo_material',
    17 => 'cestado_civil',
    18 => 'cejercicio_predominante',
    19 => 'cejercicio_profesional',
);
//ejemplo para enviar un where $condiciones = array(enum_ecg::cejercicio_predominante=>array('EJER_PREDOMI_CVE '=>'2'));                  
$config['catalogos_definidos'] = array(//Catógos generales que existen actualmente y su identificación
    'cmodalidad' => array('id' => 'MODALIDAD_CVE', 'nombre' => 'MOD_NOMBRE' , 'where' => null),
    'licenciatura' => array('id' => 'LICENCIATURA_CVE', 'nombre' => 'LIC_NOMBRE' , 'where' => null),
    'cmodulo' => array('id' => 'MODULO_CVE', 'nombre' => 'MODULO_NOMBRE' , 'where' => null),
    'carea' => array('id' => 'AREA_CVE', 'nombre' => 'AREA_NOMBRE' , 'where' => null),
    'cmateria' => array('id' => 'MATERIA_CVE', 'nombre' => 'MATERIA_NOMBRE' , 'where' => null),
    'ccurso' => array('id' => 'CURSO_CVE', 'nombre' => 'CUR_NOMBRE' , 'where' => null),
    'cinstitucion_avala' => array('id' => 'INS_AVALA_CVE', 'nombre' => 'IA_NOMBRE' , 'where' => null),
    'ctipo_actividad_docente' => array('id' => 'TIP_ACT_DOC_CVE', 'nombre' => 'TIP_ACT_DOC_NOMBRE' , 'where' => null),
    'crol_desempenia' => array('id' => 'ROL_DESEMPENIA_CVE', 'nombre' => 'ROL_DESEMPENIA' , 'where' => null),
    'ctipo_comprobante' => array('id' => 'TIPO_COMPROBANTE_CVE', 'nombre' => 'TIP_COM_NOMBRE' , 'where' => null),
    'ctipo_licenciatura' => array('id' => 'TIP_LICENCIATURA_CVE', 'nombre' => 'TIP_LIC_NOMBRE' , 'where' => null),
    'ctipo_curso' => array('id' => 'TIP_CURSO_CVE', 'nombre' => 'TIP_CUR_NOMBRE' , 'where' => null),
    'ctipo_especialidad' => array('id' => 'TIP_ESP_MEDICA_CVE', 'nombre' => 'TIP_ESP_MED_NOMBRE' , 'where' => null),
    'ctipo_formacion_profesional' => array('id' => 'TIP_FOR_PROF_CVE', 'nombre' => 'TIP_FOR_PRO_NOMBRE' , 'where' => null),
    'ctipo_participacion' => array('id' => 'TIP_PARTICIPACION_CVE', 'nombre' => 'TIP_PAR_NOMBRE' , 'where' => null),
    'ctipo_material' => array('id' => 'TIP_MATERIAL_CVE', 'nombre' => 'TIP_MAT_NOMBRE' , 'where' => null),
    'cestado_civil' => array('id' => 'CESTADO_CIVIL_CVE', 'nombre' => 'EDO_CIV_NOMBRE' , 'where' => null),
    'cejercicio_predominante' => array('id' => 'EJER_PREDOMI_CVE', 'nombre' => 'EJE_PRE_NOMBRE' , 'where' => null),
    'cejercicio_profesional' => array('id' => 'EJE_PRO_CVE', 'nombre' => 'EJE_PRO_NOMBRE' , 'where' => null),
    'cmedio_divulgacion' => array('id' => 'MED_DIVULGACION_CVE', 'nombre' => 'MED_DIV_NOMBRE' , 'where' => null),
    'ctipo_estudio' => array('id' => 'TIP_ESTUDIO_CVE', 'nombre' => 'TIP_EST_NOMBRE' , 'where' => null),
    'cdelegacion' => array('id' => 'DELEGACION_CVE', 'nombre' => 'DEL_NOMBRE' , 'where' => null),
    'ccategoria' => array('id' => 'des_clave', 'nombre' => 'nom_categoria' , 'where' => null),
    'cdepartamento' => array('id' => 'departamento_cve', 'nombre' => 'dep_nombre' , 'where' => null),
    'crol' => array('id' => 'ROL_CVE', 'nombre' => 'ROL_NOMBRE' , 'where' => null),
    'modulo' => array('id' => 'MODULO_CVE', 'nombre' => 'MOD_NOMBRE' , 'where' => null),
    'cestado_usuario' => array('id' => 'ESTADO_USUARIO_CVE', 'nombre' => 'EDO_USUARIO_DESC' , 'where' => null),
    'cunidad' => array('id' => 'UNIDAD_CVE', 'nombre' => 'UNI_DESC' , 'where' => null),
    'cestado_validacion' => array('id' => 'EST_VALIDACION_CVE', 'nombre' => 'EST_VALIDA_DESC' , 'where' => null),
    'comision_area' => array('id' => 'COM_AREA_CVE', 'nombre' => 'COM_ARE_NOMBRE' , 'where' => null),
    'cnivel_academico' => array('id' => 'NIV_ACADEMICO_CVE', 'nombre' => 'NIV_ACA_NOMBRE' , 'where' => null),
    'ctipo_comision' => array('id' => 'TIP_COMISION_CVE', 'nombre' => 'TIP_COM_NOMBRE', 'where' => 'IS_COMISION_ACADEMICA'),
    'cmotivo_becado' => array('id' => 'MOTIVO_BECADO_CVE', 'nombre' => 'MOT_BEC_NOMBRE', 'where' => null),
    'cbeca_interrumpida' => array('id' => 'BECA_INTERRIMPIDA_CVE', 'nombre' => 'MSG_BEC_INTE', 'where' => null),
    'cclase_beca' => array('id' => 'CLA_BECA_CVE', 'nombre' => 'CLA_BEC_NOMBRE', 'where' => null),
    'csubtipo_formacion_profesional' => array('id'=>'SUB_FOR_PRO_CVE', 'nombre'=>'SUB_FOR_PRO_NOMBRE', 'where'=>null),
    'ctipo_formacion_salud' => array('id'=>'TIP_FORM_SALUD_CVE', 'nombre'=>'TIP_FORM_SALUD_NOMBRE', 'where'=>null),
    'csubtipo_formacion_salud' => array('id'=>'CSUBTIP_FORM_SALUD_CVE', 'nombre'=>'SUBTIP_NOMBRE', 'where'=>null),
    'ctematica' => array('id'=>'TEMATICA_CVE', 'nombre'=>'TEM_NOMBRE', 'where'=>null),
     'cvalidacion_estado' => array('id' => 'VAL_ESTADO_CVE', 'nombre' => 'VAL_EST_NOMBRE' , 'where' => null),
     'cvalidacion_curso_estado' => array('id'=>'VAL_CUR_EST_CVE', 'nombre'=>'VAl_CUR_EST_NOMBRE', 'where'=>null),
     'cseccion' => array('id'=>'SECCION_CVE', 'nombre'=>'SECCION_DES', 'where'=>null),
     Enum_ecg::cestado_evaluacion => array('id' => 'EST_EVALUACION_CVE', 'nombre' => 'EST_EVA_NOMBRE' , 'where' => null),
    '' => array('id' => '', 'nombre' => '' , 'where' => null),
);

$config['actividad_docente_componentes'] = array(//Arreglo que se utilizará para leer las configuraciones de cada formularío de actividad docente
    0 => array('texto' => '', 'tabla_validacion' => '', 'tabla_guardado' => '', 'llave_primaria' => '', 'vista' => '', 'validaciones' => '', 'catalogos_indexados' => array(), 'validaciones_extra' => array()),
    1 => array('texto' => 'Ciclos Clínicos', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_ciclos_clinicos', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_ciclos_clinicos', 'validaciones' => 'form_ccl', 'catalogos_indexados' => array(Enum_ecg::cmodalidad, Enum_ecg::licenciatura, Enum_ecg::ccurso, Enum_ecg::cinstitucion_avala, Enum_ecg::crol_desempenia), 'where'=>array(Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])),'validaciones_extra' => array('duracion', 'pago_extra')),
    2 => array('texto' => 'Internado Médico', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_internado_medico', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_internado_medico', 'validaciones' => 'form_ime', 'catalogos_indexados' => array(Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodulo, Enum_ecg::cmodalidad), 'where'=>array(Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])),'validaciones_extra' => array('pago_extra')),
    3 => array('texto' => 'Servicio Social', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_servicio_social', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_servicio_social', 'validaciones' => 'form_sso', 'catalogos_indexados' => array(Enum_ecg::cmodalidad, Enum_ecg::licenciatura, Enum_ecg::cinstitucion_avala, Enum_ecg::crol_desempenia), 'where'=>array(Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])), 'validaciones_extra' => array('pago_extra')),
    4 => array('texto' => 'Licenciatura', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_licenciatura', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_licenciatura', 'validaciones' => 'form_lic', 'catalogos_indexados' => array(Enum_ecg::cmodalidad, Enum_ecg::licenciatura, Enum_ecg::ccurso, Enum_ecg::cinstitucion_avala, Enum_ecg::crol_desempenia), 'where'=>array(Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])), 'validaciones_extra' => array('duracion', 'pago_extra')),
    5 => array('texto' => 'Especialidad Médica', 'tabla_validacion' => 'ESPECIALIDAD_MEDICA', 'tabla_guardado' => 'emp_esp_medica', 'llave_primaria' => 'EMP_ESP_MEDICA_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_especialidad_medica', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_especialidad_medica', 'validaciones' => 'form_eme', 'catalogos_indexados' => array(Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodulo, Enum_ecg::cmodalidad, Enum_ecg::ctipo_especialidad), 'where'=>array(Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])), 'validaciones_extra' => array('pago_extra')),
    6 => array('texto' => 'Maestría', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_maestria', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_maestria', 'validaciones' => 'form_mas', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'where'=>array(Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])), 'validaciones_extra' => array('duracion', 'pago_extra')),
    7 => array('texto' => 'Doctorado', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_doctorado', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_doctorado', 'validaciones' => 'form_doc', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'where'=>array(Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])), 'validaciones_extra' => array('duracion', 'pago_extra')),
    8 => array('texto' => 'Técnico', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_tecnico', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_tecnico', 'validaciones' => 'form_tec', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'where'=>array(Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])), 'validaciones_extra' => array('duracion', 'pago_extra')),
    9 => array('texto' => 'Postécnico', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_postecnico', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_postecnico', 'validaciones' => 'form_pos', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ctipo_curso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'where'=>array(Enum_ecg::ctipo_curso=>array('TIP_CURSO_CVE'=>array(5,6,7,8)), Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])), 'where_grup'=>array(Enum_ecg::ctipo_curso=>'OR'), 'validaciones_extra' => array('duracion', 'pago_extra')),
    10 => array('texto' => 'Educación continua', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_educacion_continua', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_educacion_continua', 'validaciones' => 'form_eco', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cmodalidad,Enum_ecg::ctipo_curso), 'validaciones_extra' => array('duracion', 'pago_extra'), 'where'=>array(Enum_ecg::crol_desempenia=>array('ROL_DESEMPENIA_CVE'=>array(1,2))), 'where_grup'=>array(Enum_ecg::crol_desempenia=>'OR') ),
    11 => array('texto' => 'Directivos para la salud', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_directivos_para_la_salud', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_directivos_para_la_salud', 'validaciones' => 'form_dplsa', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'where'=>array(Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])), 'validaciones_extra' => array('duracion', 'pago_extra')),
    12 => array('texto' => 'Formación de docentes', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_educacion_formacion_de_profesores', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_educacion_formacion_de_profesores', 'validaciones' => 'form_efdp', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ctipo_curso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad, Enum_ecg::ctipo_formacion_profesional), 'where'=>array(Enum_ecg::ctipo_curso=>array('TIP_CURSO_CVE'=>array(1,2)), Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala']), Enum_ecg::crol_desempenia=>array('ROL_DESEMPENIA_CVE'=>array(1,2))), 'where_grup'=>array(Enum_ecg::ctipo_curso=>'OR', Enum_ecg::crol_desempenia=>'OR'), 'validaciones_extra' => array('duracion', 'pago_extra')),
    13 => array('texto' => 'Formacionde Profesoresen Investigación', 'tabla_validacion' => 'ACTIVIDAD_DOCENTE', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_formacion_de_profesores_en_investigacion', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_formacion_de_profesores_en_investigacion', 'validaciones' => 'form_fdpei', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'where'=>array(Enum_ecg::cinstitucion_avala=>array('IA_TIPO = '=>$config['institucion']['avala'])), 'validaciones_extra' => array('duracion', 'pago_extra')),
    14 => array('texto' => 'Educación a Distancia', 'tabla_validacion' => 'EDUCACION_DISTANCIA', 'tabla_guardado' => 'emp_educacion_distancia', 'llave_primaria' => 'EMP_EDU_DISTANCIA_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_educacion_a_distancia', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_educacion_a_distancia', 'validaciones' => 'form_ead', 'catalogos_indexados' => array(Enum_ecg::crol_desempenia, Enum_ecg::ctipo_curso), 'where'=>array(Enum_ecg::ctipo_curso=>array('TIP_CURSO_CVE'=>array(9,10,11))), 'where_grup'=>array(Enum_ecg::ctipo_curso=>'OR'),'validaciones_extra' => array('duracion', 'ctipo_curso')),
    15 => array('texto' => '', 'tabla_validacion' => 'EDUCACION_DISTANCIA', 'tabla_guardado' => 'emp_educacion_distancia', 'llave_primaria' => 'EMP_EDU_DISTANCIA_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_actividades_de_investigacion_educativa', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_actividades_de_investigacion_educativa', 'validaciones' => 'form_adie', 'catalogos_indexados' => array(), 'validaciones_extra' => array('duracion'))
);
/*$config['actividad_docente_componentes'] = array(//Arreglo que se utilizará para leer las configuraciones de cada formularío de actividad docente
    0 => array('texto' => '', 'tabla_guardado' => '', 'llave_primaria' => '', 'vista' => '', 'validaciones' => '', 'catalogos_indexados' => array(), 'validaciones_extra' => array()),
    1 => array('texto' => 'Ciclos Clínicos', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_ciclos_clinicos', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_ciclos_clinicos', 'validaciones' => 'form_ccl', 'catalogos_indexados' => array(Enum_ecg::cmodalidad, Enum_ecg::licenciatura, Enum_ecg::ccurso, Enum_ecg::cinstitucion_avala, Enum_ecg::crol_desempenia), 'validaciones_extra' => array('duracion', 'pago_extra')),
    2 => array('texto' => 'Internado Médico', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_internado_medico', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_internado_medico', 'validaciones' => 'form_ime', 'catalogos_indexados' => array(Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodulo, Enum_ecg::cmodalidad), 'validaciones_extra' => array('pago_extra')),
    3 => array('texto' => 'Servicio Social', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_servicio_social', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_servicio_social', 'validaciones' => 'form_sso', 'catalogos_indexados' => array(Enum_ecg::cmodalidad, Enum_ecg::licenciatura, Enum_ecg::cinstitucion_avala, Enum_ecg::crol_desempenia), 'validaciones_extra' => array('pago_extra')),
    4 => array('texto' => 'Licenciatura', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_licenciatura', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_licenciatura', 'validaciones' => 'form_lic', 'catalogos_indexados' => array(Enum_ecg::cmodalidad, Enum_ecg::licenciatura, Enum_ecg::ccurso, Enum_ecg::cinstitucion_avala, Enum_ecg::crol_desempenia), 'validaciones_extra' => array('duracion', 'pago_extra')),
    5 => array('texto' => 'Especialidad Médica', 'tabla_guardado' => 'emp_esp_medica', 'llave_primaria' => 'EMP_ESP_MEDICA_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_especialidad_medica', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_especialidad_medica', 'validaciones' => 'form_eme', 'catalogos_indexados' => array(Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodulo, Enum_ecg::cmodalidad, Enum_ecg::ctipo_especialidad), 'validaciones_extra' => array('pago_extra')),
    6 => array('texto' => 'Maestría', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_maestria', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_maestria', 'validaciones' => 'form_mas', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'validaciones_extra' => array('duracion', 'pago_extra')),
    7 => array('texto' => 'Doctorado', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_doctorado', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_doctorado', 'validaciones' => 'form_doc', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'validaciones_extra' => array('duracion', 'pago_extra')),
    8 => array('texto' => 'Técnico', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_tecnico', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_tecnico', 'validaciones' => 'form_tec', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'validaciones_extra' => array('duracion', 'pago_extra')),
    9 => array('texto' => 'Postécnico', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_postecnico', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_postecnico', 'validaciones' => 'form_pos', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ctipo_curso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'where'=>array(Enum_ecg::ctipo_curso=>array('TIP_CURSO_CVE'=>array(5,6,7,8))), 'where_grup'=>array(Enum_ecg::ctipo_curso=>'OR'), 'validaciones_extra' => array('duracion', 'pago_extra')),
    10 => array('texto' => 'Educación continua', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_educacion_continua', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_educacion_continua', 'validaciones' => 'form_eco', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'validaciones_extra' => array('duracion', 'pago_extra')),
    11 => array('texto' => 'Directivos para la salud', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_directivos_para_la_salud', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_directivos_para_la_salud', 'validaciones' => 'form_dplsa', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'validaciones_extra' => array('duracion', 'pago_extra')),
    12 => array('texto' => 'Educación / Formación de Profesores', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_educacion_formacion_de_profesores', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_educacion_formacion_de_profesores', 'validaciones' => 'form_efdp', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ctipo_curso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad, Enum_ecg::ctipo_formacion_profesional), 'where'=>array(Enum_ecg::ctipo_curso=>array('TIP_CURSO_CVE'=>array(1,3))), 'where_grup'=>array(Enum_ecg::ctipo_curso=>'OR'), 'validaciones_extra' => array('duracion', 'pago_extra')),
    13 => array('texto' => 'Formacionde Profesoresen Investigación', 'tabla_guardado' => 'emp_actividad_docente', 'llave_primaria' => 'EMP_ACT_DOCENTE_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_formacion_de_profesores_en_investigacion', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_formacion_de_profesores_en_investigacion', 'validaciones' => 'form_fdpei', 'catalogos_indexados' => array(Enum_ecg::carea, Enum_ecg::ccurso, Enum_ecg::crol_desempenia, Enum_ecg::cinstitucion_avala, Enum_ecg::cmodalidad), 'validaciones_extra' => array('duracion', 'pago_extra')),
    14 => array('texto' => 'Educacióna Distancia', 'tabla_guardado' => 'emp_educacion_distancia', 'llave_primaria' => 'EMP_EDU_DISTANCIA_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_educacion_a_distancia', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_educacion_a_distancia', 'validaciones' => 'form_ead', 'catalogos_indexados' => array(Enum_ecg::crol_desempenia, Enum_ecg::ctipo_curso), 'where'=>array(Enum_ecg::ctipo_curso=>array('TIP_CURSO_CVE'=>array(9,10,11))), 'where_grup'=>array(Enum_ecg::ctipo_curso=>'OR'),'validaciones_extra' => array('duracion', 'ctipo_curso')),
    15 => array('texto' => '', 'tabla_guardado' => 'emp_educacion_distancia', 'llave_primaria' => 'EMP_EDU_DISTANCIA_CVE', 'vista' => 'perfil/actividad_docente/actividad_d_actividades_de_investigacion_educativa', 'vista_validacion' => 'validador_censo/actividad_docente/actividad_d_actividades_de_investigacion_educativa', 'validaciones' => 'form_adie', 'catalogos_indexados' => array(), 'validaciones_extra' => array('duracion'))
);*/

$config['emp_actividad_docente'] = array(
//    'ctipo_actividad_docente' => array('select' => 'TIP_ACT_DOC_CVE', 'insert' => 'TIP_ACT_DOC_CVE'),
    'hora_dedicadas' => array('select' => 'EAD_DURACION', 'insert' => 'EAD_DURACION'),
    'fecha_inicio_pick' => array('select' => 'EAD_FCH_INICIO', 'insert' => 'EAD_FCH_INICIO'),
    'fecha_fin_pick' => array('select' => 'EAD_FCH_FIN', 'insert' => 'EAD_FCH_FIN'),
    'periodo_fecha_inicio_pick' => array('select' => 'EAD_FCH_INICIO', 'insert' => 'EAD_FCH_INICIO'),
    'periodo_fecha_fin_pick' => array('select' => 'EAD_FCH_FIN', 'insert' => 'EAD_FCH_FIN'),
    'cmodalidad' => array('select' => 'MODALIDAD_CVE', 'insert' => 'MODALIDAD_CVE'),
    'licenciatura' => array('select' => 'LICENCIATURA_CVE', 'insert' => 'LICENCIATURA_CVE'),
    'crol_desempenia' => array('select' => 'ROL_DESEMPENIA_CVE', 'insert' => 'ROL_DESEMPENIA_CVE'),
    'cinstitucion_avala' => array('select' => 'INS_AVALA_CVE', 'insert' => 'INS_AVALA_CVE'),
    'ctipo_curso' => array('select' => '', 'insert' => ''),
    'ccurso' => array('select' => 'CURSO_CVE', 'insert' => 'CURSO_CVE'),
    'cmateria' => array('select' => 'TIP_MATERIAL_CVE', 'insert' => 'TIP_MATERIAL_CVE'),
    'carea' => array('select' => 'AREA_CVE', 'insert' => 'AREA_CVE'),
    'cmodulo' => array('select' => 'MODULO_CVE', 'insert' => 'MODULO_CVE'),
    'comprobante' => array('select' => 'COMPROBANTE_CVE', 'insert' => 'COMPROBANTE_CVE'),
    'pago_extra' => array('select' => 'EAD_EXTRA_INS_AVALA', 'insert' => 'EAD_EXTRA_INS_AVALA'),
//    'actividad_docente_general' => array('select' => 'ACT_DOC_GRAL_CVE', 'insert' => 'ACT_DOC_GRAL_CVE'),
//    'actividad_docente_gral' => array('select' => 'ACT_DOC_GRAL_CVE', 'insert' => 'ACT_DOC_GRAL_CVE'),
    'actividad_anios_dedicados_docencia' => array('select' => 'EAD_ANIO_CURSO', 'insert' => 'EAD_ANIO_CURSO'),
    'nombre_curso' => array('select' => 'EAD_NOMBRE_CURSO', 'insert' => 'EAD_NOMBRE_CURSO'),
    'curso_principal' => array('select' => 'EAD_CURSO_PRIN_IMPARTE', 'insert' => 'EAD_CURSO_PRIN_IMPARTE'),
    'nombre_materia_impartio' => array('select' => 'EAD_NOMBRE_MATERIA_IMPARTIO', 'insert' => 'EAD_NOMBRE_MATERIA_IMPARTIO'),
    'ctipo_formacion_profesional' => array('select' => 'TIP_FOR_PROF_CVE', 'insert' => 'TIP_FOR_PROF_CVE'),
);


$config['emp_educacion_distancia'] = array(
    'hora_dedicadas' => array('select' => 'EED_DURACION', 'insert' => 'EED_DURACION'),
//    'empleado_cve' => array('select' => 'EMPLEADO_CVE', 'insert' => 'EMPLEADO_CVE'),
    'crol_desempenia' => array('select' => 'ROL_DESEMPENIA_CVE', 'insert' => 'ROL_DESEMPENIA_CVE'),
    'fecha_fin_pick' => array('select' => 'EED_FCH_FIN', 'insert' => 'EED_FCH_FIN'),
    'comprobante' => array('select' => 'COMPROBANTE_CVE', 'insert' => 'COMPROBANTE_CVE'),
    'is_curso_tutorizado' => array('select' => 'CLAVE_CURSO', 'insert' => 'CLAVE_CURSO'),
    'fecha_inicio_pick' => array('select' => 'EDD_FCH_INICIO', 'insert' => 'EDD_FCH_INICIO'),
    'actividad_anios_dedicados_docencia' => array('select' => 'EDD_CUR_ANIO', 'insert' => 'EDD_CUR_ANIO'),
    'is_curso_tutorizado' => array('select' => 'IS_CURSO_TUTURIZADO', 'insert' => 'IS_CURSO_TUTURIZADO'),
    '' => array('select' => 'EDD_CUR_PUN_ROL', 'insert' => 'EDD_CUR_PUN_ROL'),
    '' => array('select' => 'EDD_CUR_PUN_ALCANCE', 'insert' => 'EDD_CUR_PUN_ALCANCE'),
    '' => array('select' => 'EDD_CUR_PUN_DURACION', 'insert' => 'EDD_CUR_PUN_DURACION'),
    '' => array('select' => 'EDD_CUR_SUM_TOT_ACT', 'insert' => 'EDD_CUR_SUM_TOT_ACT'),
    '' => array('select' => 'EDD_CUR_PROM_EVALUACIONES', 'insert' => 'EDD_CUR_PROM_EVALUACIONES'),
//    'ctipo_actividad_docente' => array('select' => 'TIP_ACT_DOC_CVE', 'insert' => 'TIP_ACT_DOC_CVE'),
    'folio_constancia' => array('select' => 'FOLIO_CONSTANCIA', 'insert' => 'FOLIO_CONSTANCIA'),
    'ctipo_curso' => array('select' => 'TIPO_CURSO_CVE', 'insert' => 'TIPO_CURSO_CVE'),
    'nombre_curso' => array('select' => 'EED_NOMBRE_CURSO', 'insert' => 'EED_NOMBRE_CURSO'),
//    'actividad_docente_general' => array('select' => 'ACT_DOC_GRAL_CVE', 'insert' => 'ACT_DOC_GRAL_CVE'),
);

$config['emp_esp_medica'] = array(
    'ctipo_especialidad' => array('select' => 'TIP_ESP_MEDICA_CVE', 'insert' => 'TIP_ESP_MEDICA_CVE'),
    'crol_desempenia' => array('select' => 'ROL_DESEMPENIA_CVE', 'insert' => 'ROL_DESEMPENIA_CVE'),
    'cinstitucion_avala' => array('select' => 'INS_AVALA_CVE', 'insert' => 'INS_AVALA_CVE'),
    'cmodalidad' => array('select' => 'MODALIDAD_CVE', 'insert' => 'MODALIDAD_CVE'),
    'comprobante' => array('select' => 'COMPROBANTE_CVE', 'insert' => 'COMPROBANTE_CVE'),
    'periodo_fecha_inicio_pick' => array('select' => 'EEM_FCH_INICIO', 'insert' => 'EEM_FCH_INICIO'),
    'periodo_fecha_fin_pick' => array('select' => 'EEM_FCH_FIN', 'insert' => 'EEM_FCH_FIN'),
    'pago_extra' => array('select' => 'EEM_PAGO_EXTRA', 'insert' => 'EEM_PAGO_EXTRA'),
    'actividad_anios_dedicados_docencia' => array('select' => 'EEM_ANIO_FUNGIO', 'insert' => 'EEM_ANIO_FUNGIO'),
//    'empleado_cve' => array('select' => 'EMPLEADO_CVE', 'insert' => 'EMPLEADO_CVE'),
    'hora_dedicadas' => array('select' => 'EEM_DURACION', 'insert' => 'EEM_DURACION'),
//    'actividad_docente_general' => array('select' => 'ACT_DOC_GRAL_CVE', 'insert' => 'ACT_DOC_GRAL_CVE'),
);

$config['emp_formacion_profesional'] = array(
    'hora_dedicadas' => array('select' => 'EFP_DURACION', 'insert' => 'EFP_DURACION'),
    'ctematica' => array('select' => 'TEMATICA_CVE', 'insert' => 'TEMATICA_CVE'),
    'cmodalidad' => array('select' => 'MODALIDAD_CVE', 'insert' => 'MODALIDAD_CVE'),
    'comprobante' => array('select' => 'COMPROBANTE_CVE', 'insert' => 'COMPROBANTE_CVE'),
    'cinstitucion_avala' => array('select' => 'INS_AVALA_CVE', 'insert' => 'INS_AVALA_CVE'),
    'fecha_inicio_pick' => array('select' => 'EFP_FCH_INICIO', 'insert' => 'EFP_FCH_INICIO'),
    'fecha_fin_pick' => array('select' => 'EFP_FCH_FIN', 'insert' => 'EFP_FCH_FIN'),
    'pago_extra' => array('select' => 'EFP_EXTRA_INS_AVALA', 'insert' => 'EFP_EXTRA_INS_AVALA'),
    'empleado_cve' => array('select' => 'EMPLEADO_CVE', 'insert' => 'EMPLEADO_CVE'),
    'nd_a' => array('select' => 'EFP_TIENE_FORMA_EDU', 'insert' => 'EFP_TIENE_FORMA_EDU'),
    'ctipo_curso' => array('select' => 'CURSO_CVE', 'insert' => 'CURSO_CVE'),
    'cejercicio_profesional' => array('select' => 'EJE_PRO_CVE', 'insert' => 'EJE_PRO_CVE'),
    'nd_b' => array('select' => 'EMP_FORMACION_PROFESIONAL_CVE', 'insert' => 'EMP_FORMACION_PROFESIONAL_CVE'),
    'licenciatura' => array('select' => 'LICENCIATURA_CVE', 'insert' => 'LICENCIATURA_CVE'),
    'actividad_docente_gral' => array('select' => 'ACT_DOC_GRAL_CVE', 'insert' => 'ACT_DOC_GRAL_CVE'),
    'ctipo_formacion_profesional' => array('select' => 'TIP_FOR_PROF_CVE', 'insert' => 'TIP_FOR_PROF_CVE'),
    'actividad_anios_dedicados_docencia' => array('select' => 'EFO_ANIO_CURSO', 'insert' => 'EFO_ANIO_CURSO'),
    'nombre_curso' => array('select' => 'EFP_NOMBRE_CURSO', 'insert' => 'EFP_NOMBRE_CURSO'),
    'actividad_docente_general' => array('select' => 'ACT_DOC_GRAL_CVE', 'insert' => 'ACT_DOC_GRAL_CVE'),
    'crol_desempenia' => array('select' => 'ROL_DESEMPENIA_CVE', 'insert' => 'ROL_DESEMPENIA_CVE'),
);




$config['comprobante'] = array(
    'comprobante_cve' => array('select' => 'COMPROBANTE_CVE', 'insert' => 'COMPROBANTE_CVE'), //comprobante
    'ctipo_comprobante' => array('select' => 'TIPO_COMPROBANTE_CVE', 'insert' => 'TIPO_COMPROBANTE_CVE'), //comprobante
    'text_comprobante' => array('select' => 'COM_NOMBRE', 'insert' => 'COM_NOMBRE'), //comprobante
);
$config['comprobante_dos'] = array(
//    'comprobante' => array('select' => 'COMPROBANTE_CVE', 'insert' => 'COMPROBANTE_CVE'), //comprobante
    'ctipo_comprobante' => array('select' => 'TIPO_COMPROBANTE_CVE', 'insert' => 'TIPO_COMPROBANTE_CVE'), //comprobante
    'text_comprobante' => array('select' => 'COM_NOMBRE', 'insert' => 'COM_NOMBRE'), //comprobante
);

$config['emp_act_inv_edu'] = array(
    'nombre_investigacion' => array('select' => 'EIAE_NOMBRE_INV', 'insert' => 'EIAE_NOMBRE_INV'), 
    'folio_investigacion' => array('select' => 'EAIE_FOLIO_ACEPTACION', 'insert' => 'EAIE_FOLIO_ACEPTACION'), 
    'ctipo_estudio' => array('select' => '', 'insert' => 'TIP_ESTUDIO_CVE'), 
    'ctipo_participacion' => array('select' => 'TIP_PARTICIPACION_CVE', 'insert' => 'TIP_PARTICIPACION_CVE'), 
    'cmedio_divulgacion' => array('select' => 'MED_DIVULGACION_CVE', 'insert' => 'MED_DIVULGACION_CVE'), 
    'comprobante' => array('select' => 'COMPROBANTE_CVE', 'insert' => 'COMPROBANTE_CVE'), 
    'bibliografia_revista' => array('select' => 'EAIE_PUB_CITA', 'insert' => 'EAIE_PUB_CITA'), 
    'bibliografia_libro' => array('select' => 'EAIE_PUB_CITA', 'insert' => 'EAIE_PUB_CITA'),
    'ctipo_actividad_docente' => array('select' => 'TIP_ACT_DOC_CVE', 'insert' => 'TIP_ACT_DOC_CVE'),    
);

$config['emp_beca'] = array(
    'fecha_inicio' => array('select' => 'EB_FCH_INICIO', 'insert' => 'EB_FCH_INICIO'),
    'fecha_fin' => array('select' => 'EB_FCH_FIN', 'insert' => 'EB_FCH_FIN'),
    'cclase_beca' => array('select' => 'CLA_BECA_CVE', 'insert' => 'CLA_BECA_CVE'),
    'cmotivo_becado' => array('select' => 'MOTIVO_BECADO_CVE', 'insert' => 'MOTIVO_BECADO_CVE'),
    'cbeca_interrumpida' => array('select' => 'BECA_INTERRIMPIDA_CVE', 'insert' => 'BECA_INTERRIMPIDA_CVE'),
    'empleado_cve' => array('select' => 'EMPLEADO_CVE', 'insert' => 'EMPLEADO_CVE'),
    'comprobante' => array('select' => 'COMPROBANTE_CVE', 'insert' => 'COMPROBANTE_CVE'),
    'clase_beca_cve' => '',
    'motivo_beca_cve' => '',
    'beca_interrumpida_cve' => '',
    
);
$config['emp_comision'] = array(
    'fecha_inicio' => array('select' => 'EC_FCH_INICIO', 'insert' => 'EC_FCH_INICIO'),
    'fecha_fin' => array('select' => 'EC_FCH_FIN', 'insert' => 'EC_FCH_FIN'),
    'empleado_cve' => array('select' => 'EMPLEADO_CVE', 'insert' => 'EMPLEADO_CVE'),
    'ctipo_comision' => array('select' => 'TIP_COMISION_CVE', 'insert' => 'TIP_COMISION_CVE'),
    'comprobante' => array('select' => 'COMPROBANTE_CVE', 'insert' => 'COMPROBANTE_CVE'),
    'tipo_comision_cve' => '',
    'nom_tipo_comision' => '',
);
$config['emp_materia_educativo'] = array(
    'empleado_cve' => array('select' => 'EMPLEADO_CVE', 'insert' => 'EMPLEADO_CVE'),
    'emp_material_educativo_cve' => array('select' => 'MATERIA_EDUCATIVO_CVE', 'insert' => 'MATERIA_EDUCATIVO_CVE'),
    'tipo_material_regreso' => array('select' => 'TIP_MATERIAL_CVE', 'insert' => 'TIP_MATERIAL_CVE'),
    'comprobante' => array('select' => 'COMPROBANTE_CVE', 'insert' => 'COMPROBANTE_CVE'),
    'material_educativo_anio' => array('select' => 'MAT_EDU_ANIO', 'insert' => 'MAT_EDU_ANIO'),
    'nombre_material' => array('select' => 'NOMBRE_MATERIAL_EDUCATIVO', 'insert' => 'NOMBRE_MATERIAL_EDUCATIVO'),
);
$config['ctipo_material'] = array(
    'tipo_material_cve' => array('select' => 'TIP_MATERIAL_CVE', 'insert' => 'TIP_MATERIAL_CVE'),
    'ctipo_material' => array('select' => 'TIP_MAT_TIPO', 'insert' => 'TIP_MAT_TIPO'),

    'nombre_unidad' => array('select' => 'TIP_MAT_NOMBRE', 'insert' => 'TIP_MAT_NOMBRE'),

    'nombre_objeto_aprendizaje' => array('select' => 'TIP_MAT_NOMBRE', 'insert' => 'TIP_MAT_NOMBRE'),
    'numero_horas' => array('select' => 'TIP_MAT_OPCION', 'insert' => 'TIP_MAT_OPCION'),
    'cantidad_hojas' => array('select' => 'TIP_MAT_OPCION', 'insert' => 'TIP_MAT_OPCION'),
);
$config['opciones_tipo_material'] = array(
    'cantidad_hojas' => array(1 => 'Menos de 100 hojas', 2 => '100 ó más hojas'),
    'numero_horas' => array(1 => 'Menor o igual que cuatro horas', 2 => 'Mayor que cuatro horas'),
    1=>array('opt_tipo_material'=>'cantidad_hojas'),
    3=>array('nom_tipo_material'=>'nombre_unidad', 'opt_tipo_material'=>'numero_horas'),
    4=>array('nom_tipo_material'=>'nombre_objeto_aprendizaje', 'opt_tipo_material'=>'numero_horas'),
);

$config['ccatalogo_modulo'] = array(
    'GENERAL'=>array('id'=>1),
    'FOR_SAL'=>array('id'=>2),
    'FOR_CON_SAL'=>array('id'=>3),
    'EJE_PRO'=>array('id'=>4),
    'DES_INV'=>array('id'=>5),
    'FOR_DOC'=>array('id'=>6),
    'FOR_EDU_DIS'=>array('id'=>7),
    'FOR_DES_CON'=>array('id'=>8),
    'FOR_DIS_INS'=>array('id'=>9),
    'FOR_INV_EDU'=>array('id'=>10),
    'OTROS'=>array('id'=>11),
    'BEC_Y_COM'=>array('id'=>12),
    'ACT_DOC'=>array('id'=>13),
    'CIC_CLI'=>array('id'=>14),
    'INT_MED'=>array('id'=>15),
    'SER_SOC'=>array('id'=>16),
    'LICENCIATURA'=>array('id'=>17),
    'ESP_MED'=>array('id'=>18),
    'MAESTRIA'=>array('id'=>19),
    'DOCTORADO'=>array('id'=>20),
    'TECNICO'=>array('id'=>21),
    'POSTECNICO'=>array('id'=>22),
    'EDU_CON'=>array('id'=>23),
    'DIR_SAL'=>array('id'=>24),
    'EDU_FOR_PRO'=>array('id'=>25),
    'FOR_PRO_INV'=>array('id'=>26),
    'EDU_DIS'=>array('id'=>27),
    'ACT_INV_EDU'=>array('id'=>28),
    'COM_EDU'=>array('id'=>29),
    'SIN_EXA'=>array('id'=>30),
    'COO_TUT_EDU_DIS'=>array('id'=>31),
    'COO_CUR_EDU_DIS'=>array('id'=>32),
    'DIR_TES'=>array('id'=>33),
    'ELA_MAT_EDU'=>array('id'=>34)
);

$config['formacion_tipo_subtipo'] = array(
    'INICIAL' => array('id' => 1),
    'CONTINUA' => array('id' => 2, 
        'subtipo'=>array('EDU_DIS'=>array('id'=>1),
            'DES_CON'=>array('id'=>2),
            'DIS_INS'=>array('id'=>3),
            'INV_EDU'=>array('id'=>4))),
    'OTRO' => array('id' => 3),
);

$config['formacion_tipo_subtipo__ccatalogo_modulo'] = array(
    $config['formacion_tipo_subtipo']['INICIAL']['id']=>array(0=>$config['ccatalogo_modulo']['FOR_DOC']['id']),
    $config['formacion_tipo_subtipo']['CONTINUA']['id']=>array(
        $config['formacion_tipo_subtipo']['CONTINUA']['subtipo']['EDU_DIS']['id']=>$config['ccatalogo_modulo']['FOR_EDU_DIS']['id'],
        $config['formacion_tipo_subtipo']['CONTINUA']['subtipo']['DES_CON']['id']=>$config['ccatalogo_modulo']['FOR_DES_CON']['id'],
        $config['formacion_tipo_subtipo']['CONTINUA']['subtipo']['DIS_INS']['id']=>$config['ccatalogo_modulo']['FOR_DIS_INS']['id'],
        $config['formacion_tipo_subtipo']['CONTINUA']['subtipo']['INV_EDU']['id']=>$config['ccatalogo_modulo']['FOR_INV_EDU']['id']
    ),
    $config['formacion_tipo_subtipo']['OTRO']['id']=>array(0=>$config['ccatalogo_modulo']['OTROS']['id']),
);

$config['ccurso'] = array(
    'OTRO' => array('id'=>57)
);

$config['ACCION_GENERAL'] = array(
    'VALIDAR' => array('id'=>'validar', 'valor'=>'validar')
);

////////////////////////////////////////Inicio parámetros de validación
$config['cvalidacion_curso_estado'] = array(
    'VALIDO' => array('id' => 1, 'color' => 'success'),
    'NO_VALIDO' => array('id' => 2, 'color' => 'danger'),
    'CORRECCION' => array('id' => 3, 'color' => 'warning'),
    'REVISION' => array('id' => 4, 'color' => 'info')
);

$config['CORRECCION'] = 'CORRECCION';

$config['IS_ACTUAL'] = 1;
$config['IS_NOT_ACTUAL'] = 0;

$config['TABLAS'] = array(
    'COMISION_ACADEMICA' => array(
        'tabla_censo'=>'emp_comision', 
        'tabla_validacion'=>'hist_comision_validacion_curso', 
        'campo'=>'EMP_COMISION_CVE',
        'lbl'=>'lbl_ca_titulo'
    ),
    'FORMACION_SALUD' => array(
        'tabla_censo'=>'emp_for_personal_continua_salud', 
        'tabla_validacion'=>'hist_fpcs_validacion_curso', 
        'campo'=>'FPCS_CVE',
        'lbl'=>'lbl_fs_titulo'
    ),
    'INVESTIGACION_SALUD' => array(
        'tabla_censo'=>'emp_desa_inv_salud', 
        'tabla_validacion'=>'hist_edis_validacion_curso', 
        'campo'=>'EDIS_CVE',
        'lbl'=>'lbl_is_titulo'
    ),
    'INVESTIGACION_EDUCATIVA' => array(
        'tabla_censo'=>'emp_act_inv_edu', 
        'tabla_validacion'=>'hist_eaid_validacion_curso', 
        'campo'=>'EAID_CVE',
        'lbl'=>'lbl_ie_titulo'
    ),
    'BECA' => array(
        'tabla_censo'=>'emp_beca', 
        'tabla_validacion'=>'hist_beca_validacion_curso', 
        'campo'=>'EMP_BECA_CVE',
        'lbl'=>'lbl_b_titulo'
    ),
    'FORMACION_PROFESIONAL' => array(
        'tabla_censo'=>'emp_formacion_profesional', 
        'tabla_validacion'=>'hist_efp_validacion_curso', 
        'campo'=>'EMP_FORMACION_PROFESIONAL_CVE',
        'lbl'=>'lbl_fp_titulo'
    ),
    'MATERIAL_EDUCATIVO' => array(
        'tabla_censo'=>'emp_materia_educativo', 
        'tabla_validacion'=>'hist_me_validacion_curso', 
        'campo'=>'MATERIA_EDUCATIVO_CVE',
        'lbl'=>'lbl_me_titulo'
    ),
    'EDUCACION_DISTANCIA' => array(
        'tabla_censo'=>'emp_educacion_distancia', 
        'tabla_validacion'=>'hist_edd_validacion_curso', 
        'campo'=>'EMP_EDU_DISTANCIA_CVE',
        'lbl'=>'lbl_ed_titulo'
    ),
    'ESPECIALIDAD_MEDICA' => array(
        'tabla_censo'=>'emp_esp_medica', 
        'tabla_validacion'=>'hist_eem_validacion_curso', 
        'campo'=>'EMP_ESP_MEDICA_CVE',
        'lbl'=>'lbl_em_titulo'
    ),
    'ACTIVIDAD_DOCENTE' => array(
        'tabla_censo'=>'emp_actividad_docente', 
        'tabla_validacion'=>'hist_efpd_validacion_curso', 
        'campo'=>'EMP_ACT_DOCENTE_CVE',
        'lbl'=>'lbl_ad_titulo'
    )
);

/**
 *  Array de los estados que conforman la validación del censo 12
 * 
 *  
 */
/*$config['estados_val_censo'] = array(
    Enum_ev::Inicio => array('value' => 'Inicio', 'rol_permite' =>array(Enum_rols::Docente), 'estados_transicion' => array(), 'value_boton' => '', 'funcion_demandada' => '', 'value_boton' => '', 'tipo_transaccion'=>'', 'color_status' => ''),
    Enum_ev::Incompleta => array('value' => 'Incompleta', 'rol_permite' =>array(Enum_rols::Docente), 'estados_transicion' => array(), 'value_boton' => '', 'tipo_transaccion'=>'', 'color_status' => ''), 
    Enum_ev::Completa => array('value' => 'Completa', 'rol_permite' => array(Enum_rols::Docente), 'estados_transicion' => array(Enum_ev::Por_validar_n1), 'value_boton' => 'Enviar a validación', 'funcion_demandada' => '', 'tipo_transaccion'=>'', 'color_status' => 'NO_VALIDO'), 
    Enum_ev::Por_validar_n1 => array('value' => 'Por validar N1', 'rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_ev::En_revision_n1), 'value_boton' => 'Enviar a revisión nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'', 'color_status' => 'REVISION'),
    Enum_ev::En_revision_n1 => array('value' => 'En revisión N1', 'rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_ev::Correccion_docente, Enum_ev::Val_n1_por_validar_n2), 'value_boton' => 'Enviar a revisión nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)' ,'is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'est_apr_para_validacion'=>array(Enum_ev::Por_validar_n1, Enum_ev::En_revision_n1, Enum_ev::Correccion_n1)),
    Enum_ev::Correccion_docente => array('value' => 'Corrección docente', 'rol_permite' =>  array(Enum_rols::Docente),'estados_transicion' => array(Enum_ev::Por_validar_n1), 'value_boton' => 'Enviar a corrección por docente', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION'),
    Enum_ev::Val_n1_por_validar_n2 => array('value' => 'Validado Nivel 1-Por validar Nivel 2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_ev::En_revision_n2), 'value_boton' => 'Enviar a validar por nivel 2', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)','is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO'),
    Enum_ev::En_revision_n2 => array('value' => 'En revisión N2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_ev::Correccion_n1, Enum_ev::Val_n2_por_validar_profesionalizacion), 'value_boton' => 'Enviar a revisión nivel 2', 'funcion_demandada' => 'envio_revision(this)','is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'est_apr_para_validacion'=>array(Enum_ev::Val_n1_por_validar_n2, Enum_ev::En_revision_n2, Enum_ev::Correccion_n2)),
    Enum_ev::Correccion_n1 => array('value' => 'Corrección N1', 'rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_ev::Correccion_docente, Enum_ev::Val_n1_por_validar_n2), 'value_boton' => 'Enviar a corrección por nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'est_apr_para_validacion'=>array(Enum_ev::Por_validar_n1, Enum_ev::En_revision_n1, Enum_ev::Correccion_n1)),
    Enum_ev::Val_n2_por_validar_profesionalizacion => array('value' => 'Validado Nivel 2-Por validar profesionalización', 'rol_permite' =>array(Enum_rols::Profesionalizacion),'estados_transicion' => array(Enum_ev::En_revision_profesionalizacion), 'value_boton' => 'Enviar a validar por profesionalización', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO'),
    Enum_ev::En_revision_profesionalizacion => array('value' => 'En revisión profesionalización', 'rol_permite' =>array(Enum_rols::Profesionalizacion),'estados_transicion' => array(Enum_ev::Correccion_n2, Enum_ev::Validado), 'value_boton' => 'Enviar a revisión profesionalización', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'est_apr_para_validacion'=>array(Enum_ev::Val_n2_por_validar_profesionalizacion, Enum_ev::En_revision_profesionalizacion)),
    Enum_ev::Correccion_n2 => array('value' => 'Corrección N2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_ev::Correccion_n1, Enum_ev::Val_n2_por_validar_profesionalizacion), 'value_boton' => 'Enviar a corrección por nivel 2', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'est_apr_para_validacion'=>array(Enum_ev::Val_n1_por_validar_n2, Enum_ev::En_revision_n2, Enum_ev::Correccion_n2)),
    Enum_ev::Validado => array('value' => 'Validado profesionalización', 'rol_permite' =>array(),'estados_transicion' => array(), 'value_boton' => 'Validar', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO'),
);*/
//$config['estados_val_censo'] = array(
//    Enum_ev::Inicio => array('value' => 'Inicio', 'rol_permite' =>array(Enum_rols::Docente), 'estados_transicion' => array(), 'value_boton' => '', 'funcion_demandada' => '', 'value_boton' => '', 'tipo_transaccion'=>'', 'color_status' => '', 'cambiar_estado_revision' => false, 'estado_anterior_verificar'=>'', 'edicion_docente' => true, 'eliminacion_docente' => true, 'agregar_docente' => true),
//    Enum_ev::Incompleta => array('value' => 'Incompleta', 'rol_permite' =>array(Enum_rols::Docente), 'estados_transicion' => array(), 'value_boton' => '', 'tipo_transaccion'=>'', 'color_status' => '', 'cambiar_estado_revision' => false, 'estado_anterior_verificar'=>'', 'edicion_docente' => true, 'eliminacion_docente' => true, 'agregar_docente' => true),
//    Enum_ev::Completa => array('value' => 'Completa', 'rol_permite' => array(Enum_rols::Docente), 'estados_transicion' => array(Enum_ev::Por_validar_n1), 'value_boton' => 'Enviar a validación', 'funcion_demandada' => '', 'tipo_transaccion'=>'', 'color_status' => 'VALIDO', 'cambiar_estado_revision' => false, 'estado_anterior_verificar'=>'', 'edicion_docente' => true, 'eliminacion_docente' => true, 'agregar_docente' => true),
//    Enum_ev::Por_validar_n1 => array('value' => 'Por validar N1', 'rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_ev::En_revision_n1), 'value_boton' => 'Enviar a revisión nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'', 'color_status' => 'REVISION', 'cambiar_estado_revision' => true, 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
//    Enum_ev::En_revision_n1 => array('value' => 'En revisión N1', 'rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_ev::Correccion_docente, Enum_ev::Val_n1_por_validar_n2), 'value_boton' => 'Enviar a revisión nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)' ,'is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Por_validar_n1, Enum_ev::En_revision_n1, Enum_ev::Correccion_n1), 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
//    Enum_ev::Correccion_docente => array('value' => 'Corrección docente', 'rol_permite' =>  array(Enum_rols::Docente),'estados_transicion' => array(Enum_ev::Por_validar_n1), 'value_boton' => 'Enviar a corrección por docente', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'cambiar_estado_revision' => false, 'estado_anterior_verificar'=>Enum_ev::En_revision_n1, 'edicion_docente' => true, 'eliminacion_docente' => false, 'agregar_docente' => false),
//    Enum_ev::Val_n1_por_validar_n2 => array('value' => 'Validado Nivel 1-Por validar Nivel 2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_ev::En_revision_n2), 'value_boton' => 'Enviar a validar por nivel 2', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)','is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO', 'cambiar_estado_revision' => true, 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
//    Enum_ev::En_revision_n2 => array('value' => 'En revisión N2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_ev::Correccion_n1, Enum_ev::Val_n2_por_validar_profesionalizacion), 'value_boton' => 'Enviar a revisión nivel 2', 'funcion_demandada' => 'envio_revision(this)','is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Val_n1_por_validar_n2, Enum_ev::En_revision_n2, Enum_ev::Correccion_n2), 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
///**/Enum_ev::Correccion_n1 => array('value' => 'Corrección N1', 'rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_ev::En_revision_de_correccion_n1), 'value_boton' => 'Enviar a corrección por nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'cambiar_estado_revision' => true, 'estado_anterior_verificar'=>Enum_ev::En_revision_n2, 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
////    Enum_ev::Correccion_n1 => array('value' => 'Corrección N1', 'rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_ev::Correccion_docente, Enum_ev::Val_n1_por_validar_n2), 'value_boton' => 'Enviar a corrección por nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Por_validar_n1, Enum_ev::En_revision_n1, Enum_ev::Correccion_n1), 'estado_anterior_verificar'=>Enum_ev::En_revision_n2, 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
//    Enum_ev::Val_n2_por_validar_profesionalizacion => array('value' => 'Validado Nivel 2-Por validar profesionalización', 'rol_permite' =>array(Enum_rols::Profesionalizacion),'estados_transicion' => array(Enum_ev::En_revision_profesionalizacion), 'value_boton' => 'Enviar a validar por profesionalización', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO', 'cambiar_estado_revision' => true, 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
//    Enum_ev::En_revision_profesionalizacion => array('value' => 'En revisión profesionalización', 'rol_permite' =>array(Enum_rols::Profesionalizacion),'estados_transicion' => array(Enum_ev::Correccion_n2, Enum_ev::Validado), 'value_boton' => 'Enviar a revisión profesionalización', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Val_n2_por_validar_profesionalizacion, Enum_ev::En_revision_profesionalizacion), 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
///**/Enum_ev::Correccion_n2 => array('value' => 'Corrección N2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_ev::En_revision_de_correccion_n2), 'value_boton' => 'Enviar a corrección por nivel 2', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'cambiar_estado_revision' => true, 'estado_anterior_verificar'=>Enum_ev::En_revision_profesionalizacion, 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
////    Enum_ev::Correccion_n2 => array('value' => 'Corrección N2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_ev::Correccion_n1, Enum_ev::Val_n2_por_validar_profesionalizacion), 'value_boton' => 'Enviar a corrección por nivel 2', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Val_n1_por_validar_n2, Enum_ev::En_revision_n2, Enum_ev::Correccion_n2), 'estado_anterior_verificar'=>Enum_ev::En_revision_profesionalizacion, 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
//    Enum_ev::Validado => array('value' => 'Validado profesionalización', 'rol_permite' =>array(),'estados_transicion' => array(), 'value_boton' => 'Validar', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO', 'cambiar_estado_revision' => false, 'estado_anterior_verificar'=>'', 'edicion_docente' => true, 'eliminacion_docente' => true, 'agregar_docente' => true),
//    
//    Enum_ev::En_revision_de_correccion_n1 => array('value' => 'En revisión de corrección N1', 'rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_ev::Correccion_docente, Enum_ev::Val_n1_por_validar_n2), 'value_boton' => 'Enviar a revisión de corrección nivel 1', 'funcion_demandada' => 'envio_revision(this)' ,'is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Por_validar_n1, Enum_ev::En_revision_n1, Enum_ev::Correccion_n1, Enum_ev::En_revision_de_correccion_n1), 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
//    Enum_ev::En_revision_de_correccion_n2 => array('value' => 'En revisión de corrección N2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_ev::Correccion_n1, Enum_ev::Val_n2_por_validar_profesionalizacion), 'value_boton' => 'Enviara revisión de corrección revisión nivel 2', 'funcion_demandada' => 'envio_revision(this)','is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Val_n1_por_validar_n2, Enum_ev::En_revision_n2, Enum_ev::Correccion_n2, Enum_ev::En_revision_de_correccion_n1), 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
//);
$config['estados_val_censo'] = array(
    Enum_ev::Inicio => array(
        'value' => 'Inicio', 'rol_permite' =>array(Enum_rols::Docente), 
        'estados_transicion' => array(Enum_ev::Completa), 'value_boton' => '', 
        'funcion_demandada' => '', 'value_boton' => '', 'tipo_transaccion'=>'', 
        'color_status' => '', 'cambiar_estado_revision' => false, 'estado_anterior_verificar'=>'', 
        'edicion_docente' => true, 'eliminacion_docente' => true, 'agregar_docente' => true),
    Enum_ev::Incompleta => array('value' => 'Incompleta', 'rol_permite' =>array(Enum_rols::Docente), 'estados_transicion' => array(), 'value_boton' => '', 'tipo_transaccion'=>'', 'color_status' => '', 'cambiar_estado_revision' => false, 'estado_anterior_verificar'=>'', 'edicion_docente' => true, 'eliminacion_docente' => true, 'agregar_docente' => true),
    Enum_ev::Completa => array('value' => 'Completa', 
        'rol_permite' => array(Enum_rols::Docente), 'estados_transicion' => array(Enum_ev::Listo_por_validar), 
        'value_boton' => 'Enviar a validación', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)',
        'is_boton' => TRUE, 'tipo_transaccion'=>'', 'color_status' => 'VALIDO', 
        'cambiar_estado_revision' => false,
        'estado_anterior_verificar'=>'', 'edicion_docente' => true, 'eliminacion_docente' => true,
        'agregar_docente' => true),
    Enum_ev::Listo_por_validar => array('value' => 'Listo para validar', 'rol_permite' =>  array(),
        'estados_transicion' => array(Enum_ev::Por_validar_n1), 'value_boton' => 'Enviar información a validar', 
        'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => FALSE, 
        'tipo_transaccion'=>'corrección', 'color_status' => 'VALIDO', 'cambiar_estado_revision' => false, 
        'estado_anterior_verificar'=>Enum_ev::Completa, 'edicion_docente' => true, 
        'eliminacion_docente' => false, 'agregar_docente' => false),
    Enum_ev::Por_validar_n1 => array('value' => 'Por validar N1', 'rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_ev::En_revision_n1), 'value_boton' => 'Enviar a revisión nivel 1', 'funcion_demandada' => 'envio_revision(this)', 'is_boton' => FALSE, 'tipo_transaccion'=>'', 'color_status' => 'REVISION', 'cambiar_estado_revision' => true, 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
    Enum_ev::En_revision_n1 => array('value' => 'En revisión N1', 'rol_permite' =>array(Enum_rols::Validador_N1),
        'estados_transicion' => array(Enum_ev::Validado_n1), 'value_boton' => 'Enviar a revisión nivel 1', 
        'funcion_demandada' => 'envio_cambio_estado_validacion(this)' ,'is_boton' => FALSE, 
        'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'cambiar_estado_revision' => false, 
        'est_apr_para_validacion'=>array(Enum_ev::Por_validar_n1, Enum_ev::En_revision_n1),
        'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false,
        'agregar_docente' => false),
    Enum_ev::Validado_n1 => array('value' => 'Validado por N1', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(), 'value_boton' => 'Validar N1', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)','is_boton' => TRUE, 'tipo_transaccion'=>'revisión', 'color_status' => 'VALIDO', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Por_validar_n1, Enum_ev::En_revision_n1), 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
    Enum_ev::Por_validar_n2 => array('value' => 'Por validar nivel 2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_ev::En_revision_n2), 'value_boton' => 'Enviar a validar por nivel 2', 'funcion_demandada' => 'envio_revision(this)','is_boton' => FALSE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO', 'cambiar_estado_revision' => true, 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
    Enum_ev::En_revision_n2 => array('value' => 'En revisión N2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_ev::Validado_n2), 'value_boton' => 'Enviar a revisión nivel 2', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)','is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Por_validar_n2, Enum_ev::En_revision_n2), 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
    Enum_ev::Validado_n2 => array('value' => 'Validado por N2', 'rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(), 'value_boton' => 'Validar N2', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)','is_boton' => TRUE, 'tipo_transaccion'=>'revisión', 'color_status' => 'VALIDO', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Por_validar_n2, Enum_ev::En_revision_n2), 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
    Enum_ev::Por_validar_profesionalizacion => array('value' => 'Validado Nivel 2-Por validar profesionalización', 'rol_permite' =>array(Enum_rols::Profesionalizacion),'estados_transicion' => array(Enum_ev::En_revision_profesionalizacion), 'value_boton' => 'Enviar a validar por profesionalización', 'funcion_demandada' => 'envio_revision(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO', 'cambiar_estado_revision' => true, 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
    Enum_ev::En_revision_profesionalizacion => array('value' => 'En revisión profesionalización', 'rol_permite' =>array(Enum_rols::Profesionalizacion),'estados_transicion' => array(Enum_ev::Validado_profesionalizacion), 'value_boton' => 'Enviar a revisión profesionalización', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'cambiar_estado_revision' => false, 'est_apr_para_validacion'=>array(Enum_ev::Por_validar_profesionalizacion, Enum_ev::En_revision_profesionalizacion), 'estado_anterior_verificar'=>'', 'edicion_docente' => false, 'eliminacion_docente' => false, 'agregar_docente' => false),
    Enum_ev::Validado_profesionalizacion => array('value' => 'Validado por rofesionalización', 'rol_permite' =>array(),'estados_transicion' => array(), 'value_boton' => 'Validar', 'funcion_demandada' => 'envio_cambio_estado_validacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO', 'cambiar_estado_revision' => false, 'estado_anterior_verificar'=>'', 'edicion_docente' => true, 'eliminacion_docente' => true, 'agregar_docente' => true),
);
/**
 *  Array de los estados que conforman la validación para la evaluacion curricular del docente
 *  @param : est_apr_para_validacion : Estados 
 *  
 */
$config['estados_val_evaluacion'] = array(
    Enum_evec::Inicio => array('rol_permite' =>array(Enum_rols::Docente), 'estados_transicion' => array(), 'value_boton' => '', 'funcion_demandada' => '', 'value_boton' => '', 'tipo_transaccion'=>'', 'color_status' => ''),
    Enum_evec::No_validado_censo => array('rol_permite' =>array(Enum_rols::Docente), 'estados_transicion' => array(), 'value_boton' => '', 'tipo_transaccion'=>'', 'color_status' => ''), 
    Enum_evec::Por_validar_n1 => array('rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_evec::En_revision_n1), 'value_boton' => 'Enviar a revisión nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'', 'color_status' => 'REVISION'),
    Enum_evec::En_revision_n1 => array('rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_evec::Correccion_docente, Enum_evec::Val_n1_por_validar_n2), 'value_boton' => 'Enviar a revisión nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)' ,'is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'est_apr_para_validacion'=>array(Enum_evec::Por_validar_n1, Enum_evec::En_revision_n1, Enum_evec::Correccion_n1)),
    Enum_evec::Correccion_docente => array('rol_permite' =>  array(Enum_rols::Docente),'estados_transicion' => array(Enum_evec::Por_validar_n1), 'value_boton' => 'Enviar a corrección por docente', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION'),
    Enum_evec::Val_n1_por_validar_n2 => array('rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_evec::En_revision_n2), 'value_boton' => 'Enviar a validar por nivel 2', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)','is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO'),
    Enum_evec::En_revision_n2 => array('rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_evec::Correccion_n1, Enum_evec::Val_n2_por_validar_profesionalizacion), 'value_boton' => 'Enviar a revisión nivel 2', 'funcion_demandada' => 'envio_revision(this)','is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'est_apr_para_validacion'=>array(Enum_evec::Val_n1_por_validar_n2, Enum_evec::En_revision_n2, Enum_evec::Correccion_n2)),
    Enum_evec::Correccion_n1 => array('rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_evec::En_revision_n1), 'value_boton' => 'Enviar a corrección por nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'est_apr_para_validacion'=>array(Enum_evec::Por_validar_n1, Enum_evec::En_revision_n1, Enum_evec::Correccion_n1)),
    Enum_evec::Val_n2_por_validar_profesionalizacion => array('rol_permite' =>array(Enum_rols::Profesionalizacion),'estados_transicion' => array(Enum_evec::En_revision_profesionalizacion), 'value_boton' => 'Enviar a validar por profesionalización', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO'),
    Enum_evec::En_revision_profesionalizacion => array('rol_permite' =>array(Enum_rols::Profesionalizacion),'estados_transicion' => array(Enum_evec::Correccion_n2, Enum_evec::Validado_profesionalizacion), 'value_boton' => 'Enviar a revisión profesionalización', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'est_apr_para_validacion'=>array(Enum_evec::Val_n2_por_validar_profesionalizacion, Enum_evec::En_revision_profesionalizacion)),
    Enum_evec::Correccion_n2 => array('rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_evec::En_revision_n2), 'value_boton' => 'Enviar a corrección por nivel 2', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'est_apr_para_validacion'=>array(Enum_evec::Val_n1_por_validar_n2, Enum_evec::En_revision_n2, Enum_evec::Correccion_n2)),
    Enum_evec::Validado_profesionalizacion => array('rol_permite' =>array(),'estados_transicion' => array(), 'value_boton' => 'Validar', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO'),
);
//$config['estados_val_evaluacion'] = array(
//    Enum_evec::Inicio => array('rol_permite' =>array(Enum_rols::Docente), 'estados_transicion' => array(), 'value_boton' => '', 'funcion_demandada' => '', 'value_boton' => '', 'tipo_transaccion'=>'', 'color_status' => ''),
//    Enum_evec::No_validado_censo => array('rol_permite' =>array(Enum_rols::Docente), 'estados_transicion' => array(), 'value_boton' => '', 'tipo_transaccion'=>'', 'color_status' => ''), 
//    Enum_evec::Por_validar_n1 => array('rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_evec::En_revision_n1), 'value_boton' => 'Enviar a revisión nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'', 'color_status' => 'REVISION'),
//    Enum_evec::En_revision_n1 => array('rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_evec::Correccion_docente, Enum_evec::Val_n1_por_validar_n2), 'value_boton' => 'Enviar a revisión nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)' ,'is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'est_apr_para_validacion'=>array(Enum_evec::Por_validar_n1, Enum_evec::En_revision_n1, Enum_evec::Correccion_n1)),
//    Enum_evec::Correccion_docente => array('rol_permite' =>  array(Enum_rols::Docente),'estados_transicion' => array(Enum_evec::Por_validar_n1), 'value_boton' => 'Enviar a corrección por docente', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION'),
//    Enum_evec::Val_n1_por_validar_n2 => array('rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_evec::En_revision_n2), 'value_boton' => 'Enviar a validar por nivel 2', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)','is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO'),
//
//    Enum_evec::En_revision_n2 => array('rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_evec::Correccion_n1, Enum_evec::Val_n2_por_validar_profesionalizacion), 'value_boton' => 'Enviar a revisión nivel 2', 'funcion_demandada' => 'envio_revision(this)','is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'est_apr_para_validacion'=>array(Enum_evec::Val_n1_por_validar_n2, Enum_evec::En_revision_n2, Enum_evec::Correccion_n2)),
//    Enum_evec::Correccion_n1 => array('rol_permite' =>array(Enum_rols::Validador_N1),'estados_transicion' => array(Enum_evec::En_revision_n1), 'value_boton' => 'Enviar a corrección por nivel 1', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'est_apr_para_validacion'=>array(Enum_evec::Por_validar_n1, Enum_evec::En_revision_n1, Enum_evec::Correccion_n1)),
//    Enum_evec::Val_n2_por_validar_profesionalizacion => array('rol_permite' =>array(Enum_rols::Profesionalizacion),'estados_transicion' => array(Enum_evec::En_revision_profesionalizacion), 'value_boton' => 'Enviar a validar por profesionalización', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO'),
//    Enum_evec::En_revision_profesionalizacion => array('rol_permite' =>array(Enum_rols::Profesionalizacion),'estados_transicion' => array(Enum_evec::Correccion_n2, Enum_evec::Validado_profesionalizacion), 'value_boton' => 'Enviar a revisión profesionalización', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => FALSE, 'tipo_transaccion'=>'revisión', 'color_status' => 'REVISION', 'est_apr_para_validacion'=>array(Enum_evec::Val_n2_por_validar_profesionalizacion, Enum_evec::En_revision_profesionalizacion)),
//    Enum_evec::Correccion_n2 => array('rol_permite' =>array(Enum_rols::Validador_N2),'estados_transicion' => array(Enum_evec::En_revision_n2), 'value_boton' => 'Enviar a corrección por nivel 2', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'corrección', 'color_status' => 'CORRECCION', 'est_apr_para_validacion'=>array(Enum_evec::Val_n1_por_validar_n2, Enum_evec::En_revision_n2, Enum_evec::Correccion_n2)),
//    Enum_evec::Validado_profesionalizacion => array('rol_permite' =>array(),'estados_transicion' => array(), 'value_boton' => 'Validar', 'funcion_demandada' => 'envio_cambio_estado_validacion_evaluacion(this)', 'is_boton' => TRUE, 'tipo_transaccion'=>'validación', 'color_status' => 'VALIDO'),
//);


////////////////////////////////////////Fin parámetros de validación

$config['cestado_evaluacion'] = array(
    Enum_ee::Por_evaluar => array('value'=>'Por evaluar'),
    Enum_ee::En_revision => array('value'=>'En revisión'),
    Enum_ee::Completa => array('value'=>'Completa')
);

$config['EVA_CUR_VALIDO'] = array(
    'VALIDO'=>array('id'=>1, 'value'=>'Válido'),
    'NO_VALIDO'=>array('id'=>2, 'value'=>'No válido')
);

//    EAD_DURACION
//    EAD_FCH_INICIO
//    EAD_FCH_FIN
//    MODALIDAD_CVE *
//    LICENCIATURA_CVE *
//    COMPROBANTE_CVE
//    EAD_EXTRA_INS_AVALA
//    EAD_CURSO_PRIN_IMPARTE
//    ROL_DESEMPENIA_CVE
//    TIP_ACT_DOC_CVE *
//    INS_AVALA_CVE
//    CURSO_CVE
//    EMP_ACT_DOCENTE_CVE
//    TIP_MATERIAL_CVE *
//    AREA_CVE *
//    ACT_DOC_GRAL_CVE
//    MODULO_CVE *
//    EAD_ANIO_CURSO *
    
//tabla comprobante
//COMPROBANTE_CVE * 
//COM_NOMBRE *
//TIPO_COMPROBANTE_CVE *

//////////////solicitud de evaluacion curricular
$config['solicitar_evaluacion'] = (object)array("tabla"=>"emp_formacion_profesional",
                                                "campo"=>"efp_aplica_ecd",
                                                "validacion"=>array());


/**
 * @acronimo : clave diminutiva para identificar el curso
 * @entidad : Nombre de la entidad en la base de datos
 * @curso : Nombre del curso o campo de donde se optiene el nombre del curso
 * @tipo_curso: Tipo de curso 
 * @pk : Llave primaria de la entidad en base de datos
 
$config["secciones"] = array(
    Enum_sec::informacion_general=>array(
        "acronimo"=>"ig", 
        "entidad"=>"empleado",
        "curso"=>"",
        "tipo_curso"=>"",
        "pk"=>"EMPLEADO_CVE"
    ),
    Enum_sec::comision=>array("acronimo"=>"ca", "entidad"=>"emp_comision","curso"=>"TIP_CUR_NOMBRE","tipo_curso"=>"TIP_COM_NOMBRE","pk"=>"EMP_COMISION_CVE"),
    Enum_sec::for_personal_continua_salud=>array("acronimo"=>"fs","entidad"=>"emp_for_personal_continua_salud","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"FPCS_CVE"),
    Enum_sec::desa_inv_salud=>array("acronimo"=>"is","entidad"=>"emp_desa_inv_salud","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"EDIS_CVE"),
    Enum_sec::act_inv_edu=>array("acronimo"=>"ie","entidad"=>"emp_act_inv_edu","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"EAID_CVE"),
    Enum_sec::beca_comisiones_laborales=>array("acronimo"=>"b","entidad"=>"emp_beca ","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"EMP_BECA_CVE"),
    Enum_sec::formacion_profesional=>array("acronimo"=>"fp","entidad"=>"emp_formacion_profesional","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"EMP_FORMACION_PROFESIONAL_CVE"),
    Enum_sec::materia_educativo=>array("acronimo"=>"me","entidad"=>"emp_materia_educativo","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"MATERIA_EDUCATIVO_CVE"),
    Enum_sec::educacion_distancia=>array("acronimo"=>"ed","entidad"=>"emp_educacion_distancia","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"EMP_EDU_DISTANCIA_CVE"),
    Enum_sec::esp_medica=>array("acronimo"=>"em","entidad"=>"emp_esp_medica","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"EMP_ESP_MEDICA_CVE"),
    Enum_sec::actividad_docente=>array("acronimo"=>"ad","entidad"=>"emp_actividad_docente","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"EMP_ACT_DOCENTE_CVE"),
);

$config["secciones_cont_val_solicitud_eval"] = array(
    "ca"=>array("seccion" => 'seccion_comision_academica', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "fs"=>array("seccion" => 'seccion_formacion_salud', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "is"=>array("seccion" => 'seccion_investigacion_salud', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "ie"=>array("seccion" => 'seccion_investigacion_educativa', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "b"=> array("seccion" => 'seccion_becas_comisiones', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "fp"=>array("seccion" => 'seccion_formacion_profesional', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "me"=>array("seccion" => 'seccion_material_educativo', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "ed"=>array("seccion" => 'seccion_educacion_distancia', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "em"=>array("seccion" => 'seccion_especialidad_medica', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "ad"=>array("seccion" => 'seccion_actividad_docente', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "dt"=>array("seccion" => 'seccion_direccion_tesis', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
    "ig"=>array("seccion" => 'seccion_info_general', 'isActivo'=>true, "controlador_validacion" => 'evaluacion_curricular_validar'),
);
*/
///////////*//solicitud de evaluacion curricular
$config["secciones"] = array(
    "ca"=>array("id"=>"1","curso"=>"TIP_CUR_NOMBRE","tipo_curso"=>"TIP_COM_NOMBRE","pk"=>"EMP_COMISION_CVE"),
    "fs"=>array("id"=>"2","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"FPCS_CVE"),
    "is"=>array("id"=>"2","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"FPCS_CVE"),
    "ie"=>array("id"=>"2","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"FPCS_CVE"),
     "b"=>array("id"=>"2","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"FPCS_CVE"),
    "fp"=>array("id"=>"2","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"FPCS_CVE"),
    "me"=>array("id"=>"2","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"FPCS_CVE"),
    "ed"=>array("id"=>"2","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"FPCS_CVE"),
    "em"=>array("id"=>"2","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"FPCS_CVE"),
    "ad"=>array("id"=>"2","curso"=>"SUBTIP_NOMBRE","tipo_curso"=>"TIP_FORM_SALUD_NOMBRE","pk"=>"FPCS_CVE"),
);
/*
$config["secciones_model"] = array(
    Enum_sec::comision=>array(
        "acronimo"=>"ca",
        "entidad"=>"emp_comision",
        "curso"=>"COM_ARE_NOMBRE",
        "tipo_curso"=>"TIP_COM_NOMBRE",
        "pk"=>"EMP_COMISION_CVE",
        "model"=>"Comision_academica_model",
        "function"=>"get_comision_academica",
        "ver_datos"=>"comision_academica_detalle",
    ),
    Enum_sec::for_personal_continua_salud=>array(
        "acronimo"=>"fs",
        "entidad"=>"emp_for_personal_continua_salud",
        "curso"=>"SUBTIP_NOMBRE",
        "tipo_curso"=>"TIP_FORM_SALUD_NOMBRE",
        "pk"=>"FPCS_CVE",
        "model"=>"Formacion_model",
        "function"=>"get_formacion_salud",
        "ver_datos"=>"formacion_salud_detalle",
//        formacion_docente_detalle
    ),
    Enum_sec::desa_inv_salud=>array(
        "acronimo"=>"is",
        "entidad"=>"emp_desa_inv_salud",
        "curso"=>"nombre_investigacion",
        "tipo_curso"=>"tpad_nombre",
        "pk"=>"cve_investigacion",
        "model"=>"Investigacion_docente_model",
        "function"=>"get_lista_datos_investigacion_docente",
        "ver_datos"=>"carga_datos_investigacion",
    ),
    Enum_sec::beca_comisiones_laborales=>array(
        "acronimo"=>"b",
        "entidad"=>"emp_beca",
        "curso"=>"nom_beca",
        "tipo_curso"=>"nom_motivo_beca",
        "pk"=>"emp_beca_cve",
        "model"=>"Becas_comisiones_laborales_model",
        "function"=>"get_lista_becas",
        "ver_datos"=>"carga_datos_editar_beca",
//        carga_datos_editar_comision   
    ),
    Enum_sec::formacion_profesional=>array(
        "acronimo"=>"fp",
        "entidad"=>"emp_formacion_profesional",
        "curso"=>"SUB_FOR_PRO_NOMBRE",
        "tipo_curso"=>"TIP_FOR_PRO_NOMBRE",
        "pk"=>"EMP_FORMACION_PROFESIONAL_CVE",
        "model"=>"Formacion_model",
        "function"=>"get_formacion_docente",
        "ver_datos"=>"formacion_docente_detalle",
    ),
    Enum_sec::materia_educativo=>array(
        "acronimo"=>"me",
        "entidad"=>"emp_materia_educativo",
        "curso"=>"nombre_material",
        "tipo_curso"=>"opt_tipo_material",
        "pk"=>"emp_material_educativo_cve",
        "model"=>"Material_educativo_model",
        "function"=>"get_lista_material_educativo",
        "ver_datos"=>"carga_datos_editar_material_educativo",
    ),
    Enum_sec::actividad_docente=>array(
        "acronimo"=>"ad",
        "entidad"=>"emp_actividad_docente",
        "curso"=>"nom_curso",
        "tipo_curso"=>"nombre_tp_actividad",
        "pk"=>"cve_actividad_docente",
        "model"=>"Actividad_docente_model",
        "function"=>"get_actividades_docente",
        "ver_datos"=>"carga_datos_actividad",
        
    ),
    Enum_sec::direccion_tesis=>array(
        "acronimo"=>"dt",
        "entidad"=>"emp_comision",
        "curso"=>"NIV_ACA_NOMBRE",
        "tipo_curso"=>"COM_ARE_NOMBRE",
        "pk"=>"EMP_COMISION_CVE",
        "model"=>"Direccion_tesis_model",
        "function"=>"get_lista_datos_direccion_tesis",
        "ver_datos"=>"direccion_tesis_detalle",
    ),
);
*/