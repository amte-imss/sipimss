<?php
        'duracion' => 'duracion'
        'pago_extra' => 'pago_extra_ins_avala'
        'ccurso' => 'curso_cve'
        'crol_desempenia' => 'rol_desempenia_cve'
        'cinstitucion_avala' => 'institucion_avala_cve'
        'licenciatura' => 'licenciatura_cve'
        'cmodalidad' => 'modalidad_cve'
        'ctipo_comprobante' => 'tipo_comprobante_cve'
        'cmodulo' => 'modulo_cve'
        'carea' => 'area_cve'
        'ctipo_formacion_profesional' => 'tipo_formacion_profesional_cve'
        'ctipo_participacion' => 'tipo_participacion_cve'
        'ctipo_material' => 'tipo_material_cve'
        'ctipo_especialidad' => 'tipo_especialidad_cve'
        'ctipo_curso' => 'tipo_curso_cve'
        'material_elaborado' => 'material_elaborado'
        'text_comprobante' => 'text_comprobante'
        'nombre_curso' => 'nombre_curso'
        'nombre_materia_impartio' => 'nombre_materia_impartio'
        'folio_constancia' => 'folio_constancia'
        'actividad_anios_dedicados_docencia' => 'anio_ded'
        'fecha_inicio_pick' => 'fecha_inicio'
        'fecha_fin_pick' => 'fecha_fin'
        'periodo_fecha_inicio_pick' => 'per_fecha_inicio'
        'periodo_fecha_fin_pick' => 'per_fecha_fin'
        'hora_dedicadas' => 'hora_dedicadas'
		
		
		$config['emp_actividad_docente'] = array(
			'hora_dedicadas' => array('select' => 'EAD_DURACION "hora_dedicadas"', 'insert' => 'EAD_DURACION'),
			'fecha_inicio_pick' => array('select' => 'EAD_FCH_INICIO "fecha_inicio"', 'insert' => 'EAD_FCH_INICIO'),
			'fecha_fin_pick' => array('select' => 'EAD_FCH_FIN "fecha_fin"', 'insert' => 'EAD_FCH_FIN'),
			'periodo_fecha_inicio_pick' => array('select' => 'EAD_FCH_INICIO "per_fecha_inicio"', 'insert' => 'EAD_FCH_INICIO'),
			'periodo_fecha_fin_pick' => array('select' => 'EAD_FCH_FIN "per_fecha_fin"', 'insert' => 'EAD_FCH_FIN'),
			'cmodalidad' => array('select' => 'MODALIDAD_CVE "modalidad_cve"', 'insert' => 'MODALIDAD_CVE'),
			'licenciatura' => array('select' => 'LICENCIATURA_CVE "licenciatura_cve"', 'insert' => 'LICENCIATURA_CVE'),
			'comprobante' => array('select' => 'COMPROBANTE_CVE "comprobante_cve"', 'insert' => 'COMPROBANTE_CVE'),
			'pago_extra' => array('select' => 'EAD_EXTRA_INS_AVALA "pago_extra_ins_avala"', 'insert' => 'EAD_EXTRA_INS_AVALA'),
			'curso_principal' => array('select' => 'EAD_CURSO_PRIN_IMPARTE "cur_prin_imparte"', 'insert' => 'EAD_CURSO_PRIN_IMPARTE'),
			'crol_desempenia' => array('select' => 'ROL_DESEMPENIA_CVE "rol_desempenia_cve"', 'insert' => 'ROL_DESEMPENIA_CVE'),
			'ctipo_actividad_docente' => array('select' => 'TIP_ACT_DOC_CVE "tipo_actividad_cve"', 'insert' => 'TIP_ACT_DOC_CVE'),
			'cinstitucion_avala' => array('select' => 'INS_AVALA_CVE "institucion_avala_cve"', 'insert' => 'INS_AVALA_CVE'),
			'ctipo_curso' => array('select' => 'CURSO_CVE "curso_cve"', 'insert' => 'CURSO_CVE'),
			'actividad_docente_general' => array('select' => 'ACT_DOC_GRAL_CVE "actividad_doc_gral_cve"', 'insert' => 'ACT_DOC_GRAL_CVE'),//?1
			'carea' => array('select' => 'AREA_CVE "area_cve"', 'insert' => 'AREA_CVE'),
			'actividad_docente_gral' => array('select' => 'ACT_DOC_GRAL_CVE "actividad_doc_gral_cve"', 'insert' => 'ACT_DOC_GRAL_CVE'),//?1
			'cmodulo' => array('select' => 'MODULO_CVE "modulo_cve"', 'insert' => 'MODULO_CVE'),
			'actividad_anios_dedicados_docencia' => array('select' => 'EAD_ANIO_CURSO "anio_ded"', 'insert' => 'EAD_ANIO_CURSO'),
			'nombre_curso' => array('select' => 'EAD_NOMBRE_CURSO "nombre_curso"', 'insert' => 'EAD_NOMBRE_CURSO'),
			'nombre_materia_impartio' => array('select' => 'EAD_NOMBRE_MATERIA_IMPARTIO "nombre_materia_impartio"', 'insert' => 'EAD_NOMBRE_MATERIA_IMPARTIO'),
			'ctipo_formacion_profesional' => array('select' => 'TIP_FOR_PROF_CVE "tipo_formacion_profesional_cve"', 'insert' => 'TIP_FOR_PROF_CVE'),
		);

		$config['emp_educacion_distancia'] = array(
			'hora_dedicadas' => array('select' => 'EED_DURACION "hora_dedicadas"', 'insert' => 'EED_DURACION'),
			'empleado_cve' => array('select' => 'EMPLEADO_CVE "empleado_cve"', 'insert' => 'EMPLEADO_CVE'),
			'crol_desempenia' => array('select' => 'ROL_DESEMPENIA_CVE "rol_desempenia_cve"', 'insert' => 'ROL_DESEMPENIA_CVE'),
			'fecha_fin_pick' => array('select' => 'EED_FCH_FIN "fecha_fin"', 'insert' => 'EED_FCH_FIN'),
			'comprobante' => array('select' => 'COMPROBANTE_CVE "comprobante_cve"', 'insert' => 'COMPROBANTE_CVE'),
			'ccurso' => array('select' => 'CURSO_CVE "curso_cve"', 'insert' => 'CURSO_CVE'),
			'fecha_inicio_pick' => array('select' => 'EDD_FCH_INICIO "fecha_inicio"', 'insert' => 'EDD_FCH_INICIO'),
			'actividad_anios_dedicados_docencia' => array('select' => 'EDD_CUR_ANIO "anio_ded"', 'insert' => 'EDD_CUR_ANIO'),
			'' => array('select' => 'EDD_CUR_PUN_ROL "ecpr"', 'insert' => 'EDD_CUR_PUN_ROL'),
			'' => array('select' => 'EDD_CUR_PUN_ALCANCE "ecpa"', 'insert' => 'EDD_CUR_PUN_ALCANCE'),
			'' => array('select' => 'EDD_CUR_PUN_DURACION "ecpd"', 'insert' => 'EDD_CUR_PUN_DURACION'),
			'' => array('select' => 'EDD_CUR_SUM_TOT_ACT "ecsta"', 'insert' => 'EDD_CUR_SUM_TOT_ACT'),
			'' => array('select' => 'EDD_CUR_PROM_EVALUACIONES "ecpe"', 'insert' => 'EDD_CUR_PROM_EVALUACIONES'),
			'ctipo_actividad_docente' => array('select' => 'TIP_ACT_DOC_CVE "tipo_actividad_cve"', 'insert' => 'TIP_ACT_DOC_CVE'),
			'folio_constancia' => array('select' => 'FOLIO_CONSTANCIA "folio_constancia"', 'insert' => 'FOLIO_CONSTANCIA'),
			'ctipo_curso' => array('select' => 'TIPO_CURSO_CVE "tipo_curso_cve"', 'insert' => 'TIPO_CURSO_CVE'),
			'nombre_curso' => array('select' => 'EED_NOMBRE_CURSO "nombre_curso"', 'insert' => 'EED_NOMBRE_CURSO'),
			'actividad_docente_general' => array('select' => 'ACT_DOC_GRAL_CVE "actividad_doc_gral_cve"', 'insert' => 'ACT_DOC_GRAL_CVE'),
		);

		$config['emp_esp_medica'] = array(
			'ctipo_especialidad' => array('select' => 'TIP_ESP_MEDICA_CVE "tipo_especialidad_cve"', 'insert' => 'TIP_ESP_MEDICA_CVE'),
			'crol_desempenia' => array('select' => 'ROL_DESEMPENIA_CVE "rol_desempenia_cve"', 'insert' => 'ROL_DESEMPENIA_CVE'),
			'cinstitucion_avala' => array('select' => 'INS_AVALA_CVE "institucion_avala_cve"', 'insert' => 'INS_AVALA_CVE'),
			'cmodalidad' => array('select' => 'MODALIDAD_CVE "modalidad_cve"', 'insert' => 'MODALIDAD_CVE'),
			'comprobante' => array('select' => 'COMPROBANTE_CVE "comprobante_cve"', 'insert' => 'COMPROBANTE_CVE'),
			'periodo_fecha_inicio_pick' => array('select' => 'EEM_FCH_INICIO "per_fecha_inicio"', 'insert' => 'EEM_FCH_INICIO'),
			'periodo_fecha_fin_pick' => array('select' => 'EEM_FCH_FIN "per_fecha_fin"', 'insert' => 'EEM_FCH_FIN'),
			'pago_extra' => array('select' => 'EEM_PAGO_EXTRA "pago_extra_ins_avala"', 'insert' => 'EEM_PAGO_EXTRA'),
			'actividad_anios_dedicados_docencia' => array('select' => 'EEM_ANIO_FUNGIO "anio_ded"', 'insert' => 'EEM_ANIO_FUNGIO'),
			'empleado_cve' => array('select' => 'EMPLEADO_CVE "empleado_cve"', 'insert' => 'EMPLEADO_CVE'),
			'hora_dedicadas' => array('select' => 'EEM_DURACION "hora_dedicadas"', 'insert' => 'EEM_DURACION'),
			'actividad_docente_general' => array('select' => 'ACT_DOC_GRAL_CVE "actividad_doc_gral_cve"', 'insert' => 'ACT_DOC_GRAL_CVE'),
			'ctipo_actividad_docente' => array('select' => 'TIP_ACT_DOC_CVE "tipo_actividad_cve"', 'insert' => 'TIP_ACT_DOC_CVE'),
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
			'ctipo_comprobante' => array('select' => 'TIPO_COMPROBANTE_CVE "tipo_comprobante_cve"', 'insert' => 'TIPO_COMPROBANTE_CVE'), //comprobante
			'text_comprobante' => array('select' => 'COM_NOMBRE "text_comprobante"', 'insert' => 'COM_NOMBRE'), //comprobante
		);