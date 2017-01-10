ALTER TABLE censo_v678.ctipo_actividad_docente MODIFY COLUMN TIP_ACT_DOC_NOMBRE varchar(50) NOT NULL; /*Cambio en tamano de tipo de dato 20 to 50 6-16-2016  */

ALTER TABLE censo_v678.ctipo_formacion_salud MODIFY COLUMN TIP_FORM_SALUD_NOMBRE varchar(50) NOT NULL; /*Cambio en tamano de tipo de dato 20 to 50 6-16-2016 */

ALTER TABLE censo_v678.cejercicio_profesional MODIFY COLUMN EJE_PRO_NOMBRE varchar(50) NOT NULL;  /*Cambio en tamano de tipo de dato 20 to 50 6-16-2016 */

ALTER TABLE censo_v678.ctipo_especialidad MODIFY COLUMN TIP_ESP_MED_NOMBRE varchar(70) NOT NULL;  /*Cambio en tamano de tipo de dato 35 to 70 6-16-2016   */

ALTER TABLE censo_v678.ccurso MODIFY COLUMN CUR_NOMBRE varchar(70) NOT NULL;    /*Cambio en tamano de tipo de dato 30 to 70 6-16-2016 */


/* modifica relaciÃ³n ******************************************
quitar relaciÃ³n  
EMPLEADO_CVE "emp_actividad_docente_ibfk" */

ALTER TABLE `emp_actividad_docente` DROP FOREIGN KEY `emp_actividad_docente_ibfk_6`; /*Quita relación*/
ALTER TABLE `emp_actividad_docente` DROP `EMPLEADO_CVE`; /*Elimina campo*/

ALTER TABLE `actividad_docente_gral` ADD `EMPLEADO_CVE` INT(11) NOT NULL AFTER `EJER_PREDOMI_CVE`, ADD INDEX (`EMPLEADO_CVE`) ; /*Agrega campo empleado*/

/*emp_actividad_docente_gral_ibfk se agrega la referencia foranea*/
ALTER TABLE `actividad_docente_gral` ADD CONSTRAINT `emp_actividad_docente_gral_ibfk` 
FOREIGN KEY (`EMPLEADO_CVE`) REFERENCES `censo_v678`.`empleado`(`EMPLEADO_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/*fin**********************************************************************/

ALTER TABLE censo_v678.crol_desempenia MODIFY COLUMN ROL_DESEMPENIA varchar(35) NOT NULL;   /*Cambio en tamano de tipo de dato 25 to 35 6-22-2016

ALTER TABLE censo_v678.cinstitucion_avala MODIFY COLUMN IA_NOMBRE varchar(70) NOT NULL;  /*Cambio en tamano de tipo de dato 40 to 70 6-22-2016*/

ALTER TABLE censo_v678.cmodalidad MODIFY COLUMN MOD_NOMBRE varchar(30) NOT NULL;   /*Cambio en tamano de tipo de dato 20 to 30 6-22-2016*/

ALTER TABLE `emp_actividad_docente` ADD `EAD_NOMBRE_MATERIA_IMPARTIO` VARCHAR(100) NULL AFTER `EAD_ANIO_CURSO`;  /*/Campo agregado a la tabla "emp_actividad_docente" 6-29-2016*/

ALTER TABLE censo_v678.ctipo_material MODIFY COLUMN TIP_MAT_NOMBRE varchar(100) NOT NULL;  /*Cambio en tamano de tipo de dato 20 to 100 6-29-2016*/

ALTER TABLE censo_v678.ctipo_material MODIFY COLUMN TIP_MAT_TIPO varchar(100) NOT NULL;  /*Cambio en tamano de tipo de dato 20 to 100 6-29-2016*/

/* dia 5******************************************************************************/
ALTER TABLE censo_v678.emp_actividad_docente DROP COLUMN EAD_NOMBRE_MATERIA_IMPARTIO;   /*se elimino la columna, ya que se agrego la de "nombre_curso" */

ALTER TABLE `emp_actividad_docente` ADD `EAD_NOMBRE_CURSO` VARCHAR(100) NULL AFTER `EAD_ANIO_CURSO`;  /*Campo agregado a la tabla "emp_actividad_docente" 7-05-2016*/

ALTER TABLE `emp_formacion_profesional` ADD `EFP_NOMBRE_CURSO` VARCHAR(100) NULL AFTER `EFO_ANIO_CURSO`;  /*Campo agregado a la tabla "emp_formacion_profesional" 7-05-2016*/

ALTER TABLE `emp_educacion_distancia` ADD `FOLIO_CONSTANCIA` VARCHAR(35) NULL AFTER `TIP_ACT_DOC_CVE`;  /*Campo agregado a la tabla "emp_educacion_distancia" 7-05-2016*/

/* Agrega un tipo de curso a la tabla educación a distancia*/
ALTER TABLE `emp_educacion_distancia` ADD `TIPO_CURSO_CVE` INT(11) NOT NULL AFTER `FOLIO_CONSTANCIA`;  /*Campo agregado a la tabla "emp_educacion_distancia" 7-05-2016*/
CREATE INDEX XIF9EMP_EDUCACION_DISTANCIA ON censo_v678.emp_educacion_distancia (TIPO_CURSO_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_educacion_distancia` ADD CONSTRAINT `emp_educacion_distancia_tpcfk`   /* Asigna llave foranía*/
FOREIGN KEY (`TIPO_CURSO_CVE`) REFERENCES `censo_v678`.`ctipo_curso`(`TIP_CURSO_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/* fin */

ALTER TABLE `emp_actividad_docente` ADD `EAD_NOMBRE_MATERIA_IMPARTIO` VARCHAR(100) NULL AFTER `EAD_NOMBRE_CURSO`; /*Campo agregado a la tabla "emp_actividad_docente" 7-06-2016

ALTER TABLE `emp_educacion_distancia` ADD `EED_NOMBRE_CURSO` VARCHAR(100) NULL AFTER `TIPO_CURSO_CVE`;  /*Campo agregado a la tabla "emp_educacion_distancia" 7-06-2016

/* Agregar "ACT_DOC_GRAL_CVE" a tabla "emp_educacion_distancia" 7-06-2016 y hacer la relacion con "actividad_docente_gral"*/
ALTER TABLE `emp_educacion_distancia` ADD `ACT_DOC_GRAL_CVE` INT(10) NULL AFTER `EED_NOMBRE_CURSO`;  /*Campo agregado a la tabla "emp_educacion_distancia" 7-06-2016*/
CREATE INDEX XIF10EMP_EDUCACION_DISTANCIA ON censo_v678.emp_educacion_distancia (ACT_DOC_GRAL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_educacion_distancia` ADD CONSTRAINT `emp_educacion_distancia_eadcfk`   /* Asigna llave foranía*/
FOREIGN KEY (`ACT_DOC_GRAL_CVE`) REFERENCES `censo_v678`.`actividad_docente_gral`(`ACT_DOC_GRAL_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/* fin */

/* Agregar "ACT_DOC_GRAL_CVE" a tabla "emp_formacion_profesional" 7-06-2016 y hacer la relacion con "actividad_docente_gral"*/
ALTER TABLE `emp_formacion_profesional` ADD `ACT_DOC_GRAL_CVE` INT(10) NULL AFTER `EFP_NOMBRE_CURSO`;  /*Campo agregado a la tabla "emp_formacion_profesional" 7-06-2016*/
CREATE INDEX XIF10EMP_FORMACION_PROFESIONAL ON censo_v678.emp_formacion_profesional (ACT_DOC_GRAL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_formacion_profesional` ADD CONSTRAINT `emp_formacion_profesional_eadcfk`   /* Asigna llave foranía*/
FOREIGN KEY (`ACT_DOC_GRAL_CVE`) REFERENCES `censo_v678`.`actividad_docente_gral`(`ACT_DOC_GRAL_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/* fin */

/* Agregar "ACT_DOC_GRAL_CVE" a tabla "emp_esp_medica" 7-06-2016 y hacer la relacion con "actividad_docente_gral"*/
ALTER TABLE `emp_esp_medica` ADD `ACT_DOC_GRAL_CVE` INT(10) NULL AFTER `EMP_ESP_MEDICA_CVE`;  /*Campo agregado a la tabla "emp_esp_medica" 7-06-2016*/
CREATE INDEX XIF10EMP_ESP_MEDICA ON censo_v678.emp_esp_medica (ACT_DOC_GRAL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_esp_medica` ADD CONSTRAINT `emp_esp_medica_eadcfk`   /* Asigna llave foranía*/
FOREIGN KEY (`ACT_DOC_GRAL_CVE`) REFERENCES `censo_v678`.`actividad_docente_gral`(`ACT_DOC_GRAL_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/* fin */

/* Agregar "ROL_DESEMPENIA_CVE" a tabla "emp_formacion_profesional" 7-06-2016 y hacer la relacion con "actividad_docente_gral"*/
ALTER TABLE `emp_formacion_profesional` ADD `ROL_DESEMPENIA_CVE` INT(10) NULL AFTER `ACT_DOC_GRAL_CVE`;  /*Campo agregado a la tabla "emp_esp_medica" 7-06-2016*/
CREATE INDEX XIF20EMP_FORMACION_PROFESIONAL ON censo_v678.emp_formacion_profesional (ROL_DESEMPENIA_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_formacion_profesional` ADD CONSTRAINT `emp_formacion_profesional_efpfk`   /* Asigna llave foranía*/
FOREIGN KEY (`ROL_DESEMPENIA_CVE`) REFERENCES `censo_v678`.`crol_desempenia`(`ROL_DESEMPENIA_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/* fin */

"EMP_ESP_MEDICA_CVE" en "emp_esp_medica"  checar que relación tiene con la entidad "conv_periodo_horas" 

ALTER TABLE `emp_esp_medica` CHANGE COLUMN `EMP_ACT_DOCENTE_CVE` `ACT_DOC_GRAL_CVE` INT(10) NULL;  /* cambia nombre a columna */
ALTER TABLE `emp_formacion_profesional` CHANGE COLUMN `EMP_ACT_DOCENTE_CVE` `ACT_DOC_GRAL_CVE` INT(10) NULL;  /* cambia nombre a columna */
ALTER TABLE `emp_educacion_distancia` CHANGE COLUMN `EMP_ACT_DOCENTE_CVE` `ACT_DOC_GRAL_CVE` INT(10) NULL;  /* cambia nombre a columna */

/* Agregar "TIP_FOR_PROF_CVE" a tabla "emp_actividad_docente" 7-08-2016 y hacer la relacion con "ctipo_formacion_profesional"*/
ALTER TABLE `emp_actividad_docente` ADD `TIP_FOR_PROF_CVE` INT(10) NULL AFTER `EAD_NOMBRE_MATERIA_IMPARTIO`;  /*Campo agregado a la tabla "emp_actividad_docente" 7-08-2016*/
CREATE INDEX XIF20EMP_ACTIVIDAD_DOCENTE ON censo_v678.emp_actividad_docente (`TIP_FOR_PROF_CVE`);  /* Se vuelve index el campo */
ALTER TABLE `emp_actividad_docente` ADD CONSTRAINT `emp_actividad_docente_tfpcfk`   /* Asigna llave foranía*/
FOREIGN KEY (`TIP_FOR_PROF_CVE`) REFERENCES `censo_v678`.`ctipo_formacion_profesional`(`TIP_FOR_PROF_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/* fin */

ALTER TABLE censo_v678.bitacora MODIFY COLUMN BIT_RUTA varchar(250) NULL;  /* Cambio en tamano de tipo de dato 50 to 250 6-08-2016*/
ALTER TABLE censo_v678.ctipo_formacion_profesional MODIFY COLUMN TIP_FOR_PRO_NOMBRE varchar(30) NOT NULL;  /* Cambio en tamano de tipo de dato 20 to 30 6-08-2016*/

/* Agregar "TIP_FOR_PROF_CVE" a tabla "emp_esp_medica" 7-08-2016 y hacer la relacion con "ctipo_formacion_profesional"*/
ALTER TABLE `emp_esp_medica` ADD `TIP_ACT_DOC_CVE` INT(10) NULL AFTER `ACT_DOC_GRAL_CVE`;  /*Campo agregado a la tabla "emp_esp_medica" 7-08-2016*/
CREATE INDEX XIF15EMP_ESP_MEDICA ON censo_v678.emp_actividad_docente (`TIP_ACT_DOC_CVE`);  /* Se vuelve index el campo */
ALTER TABLE `emp_esp_medica` ADD CONSTRAINT `emp_esp_medica_tadcfk`   /* Asigna llave foranía*/
FOREIGN KEY (`TIP_ACT_DOC_CVE`) REFERENCES `censo_v678`.`ctipo_actividad_docente`(`TIP_ACT_DOC_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/* fin */

/*Revertir cambios de emp_formacion_profesional  crol_desempenia  08-07-2016*/
ALTER TABLE censo_v678.emp_formacion_profesional DROP FOREIGN KEY emp_formacion_profesional_efpfk;  /* crol destruye llave foranea */
ALTER TABLE emp_formacion_profesional DROP COLUMN ROL_DESEMPENIA_CVE;  /* crol elimina campo */

/*Revertir cambios de emp_formacion_profesional  actividad_docente_gral  08-07-2016*/
ALTER TABLE censo_v678.emp_formacion_profesional DROP FOREIGN KEY emp_formacion_profesional_eadcfk;  /* crol destruye llave foranea */
ALTER TABLE emp_formacion_profesional DROP COLUMN ACT_DOC_GRAL_CVE;  /* actividad_docente_gral elimina campo ACT_DOC_GRAL_CVE*/

/*Revertir cambios de emp_formacion_profesional  EFP_NOMBRE_CURSO  08-07-2016*/
ALTER TABLE emp_formacion_profesional DROP COLUMN EFP_NOMBRE_CURSO;


/* Agregar "TIP_FOR_PROF_CVE" a tabla "actividad_docente_gral" 11-08-2016 para identificar la entidad que almacena el curso principal que imparte"*/
ALTER TABLE `actividad_docente_gral` ADD `TIP_ACT_DOC_PRINCIPAL_CVE` INT(10) NULL AFTER `EMPLEADO_CVE`;  /*Campo agregado a la tabla "actividad_docente_gral" 11-08-2016*/
CREATE INDEX XIF10EMP_ACTIVIDAD_DOCENTE_GRAL ON censo_v678.actividad_docente_gral (`TIP_ACT_DOC_PRINCIPAL_CVE`);  /* Se vuelve index el campo */
ALTER TABLE `actividad_docente_gral` ADD CONSTRAINT `actividad_docente_gral_tadpcfk`   /* Asigna llave foranía*/
FOREIGN KEY (`TIP_ACT_DOC_PRINCIPAL_CVE`) REFERENCES `censo_v678`.`ctipo_actividad_docente`(`TIP_ACT_DOC_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/* fin */

ALTER TABLE `modulo` ADD `ORDEN_MODULO` INT(10) NULL AFTER `IS_CONTROLADOR`;  /*Campo agregado a la tabla "modulo" 11-08-2016 asigna presedencia a los módulos */


/* +++++++++++++++++++++++++++++++++++++++ cambios el 14/07/2016  +++++++++++++++++++++++++++++++++++++++++++++++++++ */
ALTER TABLE censo_v678.bitacora ADD ENTIDAD varchar(100) NULL; /* agraga campo ENTIDAD a tabla bitacora*/
ALTER TABLE censo_v678.bitacora ADD REGISTRO_ENTIDAD_CVE varchar(50) NULL; /* agraga campo REGISTRO_ENTIDAD_CVE a tabla bitacora*/
ALTER TABLE censo_v678.bitacora ADD PARAMETROS_JSON varchar(2000) NULL; /* agraga campo PARAMETROS_JSON a tabla bitacora*/
ALTER TABLE censo_v678.bitacora CHANGE BIT_VALORES BIT_OPERACION varchar(500) NULL; /* cambia nombre a campo BIT_VALORES por BIT_OPERACION en tabla bitacora para guardar si es un insert, update o delete*/
ALTER TABLE censo_v678.bitacora MODIFY COLUMN BIT_OPERACION varchar(20) NULL; /* cambia longitud de campo BIT_OPERACION 500 to 20 */
ALTER TABLE `usuario` DROP FOREIGN KEY `usuario_ibfk_2`; /*Quita relación usuario con adscripción */
ALTER TABLE `usuario` DROP FOREIGN KEY `usuario_ibfk_1`; /*Quita relación usuario con catégoria */
ALTER TABLE `usuario` DROP FOREIGN KEY `usuario_ibfk_8`; /*Quita relación usuario con delegación */
ALTER TABLE `empleado` DROP FOREIGN KEY `empleado_ibfk_3`; /*Quita relación empleado con adscripción */
ALTER TABLE `empleado` DROP FOREIGN KEY `empleado_ibfk_2`; /*Quita relación empleado con catégoria */
ALTER TABLE `empleado` DROP FOREIGN KEY `empleado_ibfk_1`; /*Quita relación empleado con delegación */
/* +++++++++++++++++++++++++++++++++++++++ fin fecha ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* +++++++++++++++++++++++++++++++++++++++ cambios el 14/07/2016  +++++++++++++++++++++++++++++++++++++++++++++++++++ */
ALTER TABLE `empleado` DROP FOREIGN KEY `empleado_ibfk_8`; /*Quita relación empleado con cdepartamento */
ALTER TABLE `validador` DROP FOREIGN KEY `validador_ibfk_4`; /*Quita relación validador con cdepartamento */
/* +++++++++++++++++++++++++++++++++++++++ fin fecha ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/*````-------------------------------------------------------------------------*/
/*  *********************modificaciónes 20/07/2016 ***********************************/
ALTER TABLE bitacora MODIFY PARAMETROS_JSON TEXT;  /* Modifica el tipo de dato de la entidad bitacora */

/* Agrega tipo de actividad docente a la tabla */   
ALTER TABLE `emp_act_inv_edu` ADD `TIP_ACT_DOC_CVE` INT(11) NOT NULL AFTER `TIP_ESTUDIO_CVE`;  /*Campo agregado a la tabla "emp_educacion_distancia" 7-05-2016*/
CREATE INDEX XIF9EMP_ACT_INV_EDU ON emp_act_inv_edu (TIP_ACT_DOC_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_act_inv_edu` ADD CONSTRAINT `emp_act_inv_edu_tpdfk`   /* Asigna llave foranía*/
FOREIGN KEY (`TIP_ACT_DOC_CVE`) REFERENCES `ctipo_actividad_docente`(`TIP_ACT_DOC_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE emp_act_inv_edu MODIFY COLUMN EAIE_PUB_CITA MEDIUMTEXT NULL; /* Permite 'NULL' el campo "EAIE_PUB_CITA"  de la entidad "emp_act_inv_edu" */

/* Agrega relacion empleado a la tabla dictamen */   
ALTER TABLE `dictamen` ADD `EMPLEADO_CVE` INT(11) NOT NULL AFTER `ESTADO_DICTAMEN_CVE`;  /*Campo agregado a la tabla "dictamen" 7-05-2016*/
CREATE INDEX XIF20DICTAMEN ON dictamen (EMPLEADO_CVE);  /* Se vuelve index el campo */
ALTER TABLE `dictamen` ADD CONSTRAINT `dictamen_empleado_tpdfk`   /* Asigna llave foranía*/
FOREIGN KEY (`EMPLEADO_CVE`) REFERENCES `empleado`(`EMPLEADO_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*  *********************modificaciónes 21/07/2016 ***********************************/
ALTER TABLE empleado MODIFY COLUMN EMP_EDAD DECIMAL NULL; /* Permite 'NULL' el campo "EMP_EDAD"  de la entidad "empleado" */
ALTER TABLE empleado MODIFY COLUMN EMP_CURP varchar(20) NOT NULL; /* Cambio en tamano de tamaño tipo de dato 15 to 20 a la entidad empleado */
ALTER TABLE empleado MODIFY COLUMN USUARIO_CVE INT NULL; /* Permite 'NULL' el campo "USUARIO_CVE"  de la entidad "empleado" */
ALTER TABLE bitacora MODIFY COLUMN ENTIDAD varchar(300) NULL; /* Cambio en tamano de tamaño tipo de dato 100 to 300 a la entidad bitacora */
    /* Agregar llave primaria a tabla sipimss.dictamen */
ALTER TABLE sipimss.dictamen ADD DICTAMEN_CVE INT(11) not null AFTER `EMPLEADO_CVE`;
ALTER table sipimss.dictamen add primary key (DICTAMEN_CVE);
ALTER TABLE sipimss.dictamen CHANGE `DICTAMEN_CVE` `DICTAMEN_CVE` INT( 11 ) NOT NULL AUTO_INCREMENT;
	/*fin de agragar key primary*/
	
/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*  *********************modificaciónes 21/07/2016 ***********************************/
ALTER TABLE `empleado` ADD `PRESUPUESTAL_ADSCRIPCION_CVE` varchar(20) NULL AFTER `DEPARTAMENTO_CVE`; /* Agrega campo presupuestal_cve a entidad empleado */
ALTER TABLE `usuario` ADD `USU_ANTIGUEDAD` varchar(10) NULL AFTER `ESTADO_USUARIO_CVE`;  /* Agrega campo usu_antiguedad a entidad usuario*/

ALTER TABLE `usuario` DROP FOREIGN KEY `usuario_ibfk_4`; /*Rompe el el constrain entre catálogo cpresupuestal y usuario, ya que la relación debe ser con adscripción*/
ALTER TABLE sipimss.usuario CHANGE `PRESUPUESTAL_CVE` `PRESUPUESTAL_ADSCRIPCION_CVE` varchar(20) NULL;  /* cambia el tipo de dato de int(11) a varchar(20)*/

/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*  *********************modificaciónes 28/07/2016 ***********************************/
ALTER TABLE validador MODIFY COLUMN DEPARTAMENTO_CVE CHAR(10) NOT NULL;  /*Cambia tipo de dato al campo "DEPARTAMENTO_CVE" de int(11) to char(10)*/
/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificaciónes 04/08/2016 **************************************/
	/* Crear la tabla de tipo de unidad medica, es decir, UMAE, DEIS, CAME*/
CREATE TABLE sipimss.ctipo_unidad_adscripcion (
TIPO_UNIDAD_ADSCRIPCION_CVE INT NOT null AUTO_INCREMENT,
DESCRIPCION_TIPO_UNIDAD VARCHAR(30) NOT NULL,
CONSTRAINT `PRIMARY` PRIMARY KEY (TIPO_UNIDAD_ADSCRIPCION_CVE)
);
CREATE UNIQUE INDEX XPKCTIPO_UNIDAD_ADSCRIPCION ON sipimss.ctipo_unidad_adscripcion (TIPO_UNIDAD_ADSCRIPCION_CVE);

ALTER TABLE `cunidad` DROP `UNI_DESC`; /* ELIMINA CAMPO, no se ocupa */

/* Agrega relacion con tipoo de unidad UMAE, DEIS ***/
ALTER TABLE `cunidad` ADD `TIPO_UNIDAD_ADSCRIPCION_CVE` INT(11) NULL AFTER `DELEGACION_CVE`;  /*Campo agregado a la tabla "cunidad" */
CREATE INDEX XIF3CUNIDAD_ADS ON cunidad (TIPO_UNIDAD_ADSCRIPCION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `cunidad` ADD CONSTRAINT `cunidad_cufk`   /* Asigna llave foranía*/
FOREIGN KEY (`TIPO_UNIDAD_ADSCRIPCION_CVE`) REFERENCES `ctipo_unidad_adscripcion`(`TIPO_UNIDAD_ADSCRIPCION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;


/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificaciónes 05/08/2016  HORA DE INSERSION A LAS SIGUIENTES ENTIADES  **************************************/
ALTER TABLE `emp_actividad_docente` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `TIP_FOR_PROF_CVE`;  /*Campo agregado a la tabla "emp_actividad_docente" */
ALTER TABLE `emp_materia_educativo` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `MATERIA_EDUCATIVO_CVE`;
ALTER TABLE `emp_act_inv_edu` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `TIP_ACT_DOC_CVE`;
ALTER TABLE `emp_for_personal_continua_salud` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `TIP_FORM_SALUD_CVE`;
ALTER TABLE `emp_formacion_profesional` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `EFO_ANIO_CURSO`;
ALTER TABLE `emp_beca` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `BECA_INTERRIMPIDA_CVE`;
ALTER TABLE `emp_comision` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `EC_FCH_FIN`;
ALTER TABLE `emp_educacion_distancia` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `ACT_DOC_GRAL_CVE`;
ALTER TABLE `emp_esp_medica` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `TIP_ACT_DOC_CVE`;
ALTER TABLE `emp_ciclos_clinicos` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `ECC_FCH_FIN`;
ALTER TABLE `actividad_docente_gral` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `TIP_ACT_DOC_PRINCIPAL_CVE`;
/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,


/* ********************modificaciónes 06/08/2016   **************************************/
ALTER TABLE comprobante MODIFY COLUMN COM_NOMBRE varchar(250) NULL;    /* CAMBIA EL TAMAÑO O LONGITUD DE 20 TO 250*/
/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificaciónes 08/08/2016   **************************************/
ALTER TABLE `ctipo_comision` ADD `IS_COMISION_ACADEMICA` INT(10)  DEFAULT 1 NOT NULL AFTER `TIP_COM_NOMBRE`;   /* Agrega campo que identifique si es una comisión academica o laboral*/

/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificaciónes 09/08/2016   **************************************/
ALTER TABLE `emp_materia_educativo` ADD NOMBRE_MATERIAL_EDUCATIVO varchar(100) NOT NULL AFTER `EMPLEADO_CVE`;
ALTER TABLE `ctipo_material` DROP TIP_MAT_TIPO;  /*Elimina tipo de material, por que debe ser un campo tipo intdex int(11)*/
/*Agrega campo para hacer una recursividad*/
ALTER TABLE ctipo_material ADD TIP_MAT_TIPO INT(11) NULL AFTER `TIP_MAT_NOMBRE`;
CREATE INDEX XIF15CTIP_MATERIAL ON ctipo_material (TIP_MAT_TIPO);  /* Se vuelve index el campo */
ALTER TABLE `ctipo_material` ADD CONSTRAINT `ctipo_material_padre_ctmfk`   /* Asigna llave foranía*/
FOREIGN KEY (`TIP_MAT_TIPO`) REFERENCES `ctipo_material`(`TIP_MATERIAL_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificació®¥³ 11/08/2016   **************************************/
ALTER TABLE `comprobante` ADD FECHA_INSERSION TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `com_extension`;
ALTER TABLE csubtipo_formacion_profesional MODIFY COLUMN SUB_FOR_PRO_NOMBRE varchar(50) NULL;
ALTER TABLE csubtipo_formacion_salud MODIFY COLUMN SUBTIP_NOMBRE varchar(50) NULL;

/* Agrega relacion "ctipo_formacion_profesional" a la tabla "csubtipo_formacion_profesional" */   
ALTER TABLE `csubtipo_formacion_profesional` ADD `TIP_FOR_PROF_CVE` INT(11) NULL AFTER `SUB_FOR_PRO_NOMBRE`;  /*Campo agregado a la tabla "csubtipo_formacion_profesional"*/
CREATE INDEX XIF10SUBTIPO_FORMACION_PROFESIONAL ON csubtipo_formacion_profesional (TIP_FOR_PROF_CVE);  /* Se vuelve index el campo */
ALTER TABLE `csubtipo_formacion_profesional` ADD CONSTRAINT `csubtipo_formacion_profesional_cdfpfk`   /* Asigna llave foranî¡ª*/
FOREIGN KEY (`TIP_FOR_PROF_CVE`) REFERENCES `ctipo_formacion_profesional`(`TIP_FOR_PROF_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;


/* eLIMINA CONSTRAIN "ctipo_formacion_profesional" CON "csubtipo_formacion_profesional"*/
ALTER TABLE `ctipo_formacion_profesional` DROP FOREIGN KEY `ctipo_formacion_profesional_ibfk_1`; 
ALTER TABLE `ctipo_formacion_profesional` DROP `SUB_FOR_PRO_CVE`; 

ALTER TABLE emp_comision MODIFY COLUMN EC_ANIO int(11) NULL; 

/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificació®¥³ 11/08/2016   **************************************/
/* Agrega relacion "ctipo_curso" a la tabla "emp_comision" */   
ALTER TABLE `emp_comision` ADD `TIP_CURSO_CVE` INT(11) NULL AFTER `FECHA_INSERSION`;  /*Campo agregado a la tabla "emp_comision"*/
CREATE INDEX XIF6EMP_COMISION ON emp_comision (TIP_CURSO_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_comision` ADD CONSTRAINT `emp_comision_ibfk_6`   /* Asigna llave foranî¡ª*/
FOREIGN KEY (`TIP_CURSO_CVE`) REFERENCES `ctipo_curso`(`TIP_CURSO_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/* Agrega relacion "ctipo_curso" a la tabla "ccurso" */    
ALTER TABLE `emp_comision` ADD `CURSO_CVE` INT(11) NULL AFTER `TIP_CURSO_CVE`;  /*Campo agregado a la tabla "emp_comision"*/
CREATE INDEX XIF7EMP_COMISION ON emp_comision (CURSO_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_comision` ADD CONSTRAINT `emp_comision_ibfk_7`   /* Asigna llave foranî¡ª*/
FOREIGN KEY (`CURSO_CVE`) REFERENCES `ccurso`(`CURSO_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificaci 13/08/2016   **************************************/
ALTER TABLE sipimss.ctipo_material MODIFY COLUMN TIP_MAT_OPCION varchar(30) NULL; /*Cambio en tamano de tipo de dato 20 to 50 6-16-2016  */
/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificaci 14/08/2016   **************************************/
ALTER TABLE sipimss.csubtipo_formacion_salud MODIFY COLUMN SUBTIP_NOMBRE varchar(100) NULL;  /*Cabio de longitud de 50 to 100*/

ALTER TABLE `emp_for_personal_continua_salud` DROP FOREIGN KEY `emp_for_personal_continua_salud_ibfk_3`; 
ALTER TABLE emp_for_personal_continua_salud DROP TIP_FORM_SALUD_CVE;

ALTER TABLE `emp_for_personal_continua_salud` ADD `CSUBTIP_FORM_SALUD_CVE` INT(11) NULL AFTER `FECHA_INSERSION`;  /*Campo agregado a la tabla "emp_comision"*/
CREATE INDEX XIF10EMP_FOR_PERSONAL_CONTINUA_SALUD ON emp_for_personal_continua_salud (CSUBTIP_FORM_SALUD_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_for_personal_continua_salud` ADD CONSTRAINT `emp_for_personal_continua_salud_efcsfk_10`   /* Asigna llave foranî¡ª*/
FOREIGN KEY (`CSUBTIP_FORM_SALUD_CVE`) REFERENCES `csubtipo_formacion_salud`(`CSUBTIP_FORM_SALUD_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
/*Cambios efectuados por jesusu DÃ­as, ajuste de campos en entidad "emp_for_personal_continua_salud"*/
ALTER TABLE `emp_for_personal_continua_salud` CHANGE `EFPCS_FCH_FIN` `EFPCS_FCH_FIN` DATE NULL DEFAULT NULL, CHANGE `EFPCS_FOR_INICIAL` `EFPCS_FOR_INICIAL` BOOLEAN NULL DEFAULT NULL;
ALTER TABLE `emp_for_personal_continua_salud` DROP `EFPCS_ANIO`, DROP `EFPCS_DURACION`;
/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificaci 15/08/2016   ****************************************/
ALTER TABLE sipimss_20160815.emp_for_personal_continua_salud MODIFY COLUMN CSUBTIP_FORM_SALUD_CVE int(11) NULL;  /*Modifica para que se a null la llave*/

ALTER TABLE `emp_for_personal_continua_salud` ADD `TIP_FORM_SALUD_CVE` INT(11) NULL AFTER `CSUBTIP_FORM_SALUD_CVE`;  /*Campo agregado a la tabla "emp_comision"*/
CREATE INDEX XIF11EMP_FOR_PERSONAL_CONTINUA_SALUD ON emp_for_personal_continua_salud (TIP_FORM_SALUD_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_for_personal_continua_salud` ADD CONSTRAINT `emp_for_personal_continua_salud_efcsfk_11`   /* Asigna llave foranî¡ª*/
FOREIGN KEY (`TIP_FORM_SALUD_CVE`) REFERENCES `ctipo_formacion_salud`(`TIP_FORM_SALUD_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificaci 16/08/2016   ****************************************/
/*Agraga nueva entidad */
CREATE TABLE `rform_prof_tematica` (
  `RFORM_PROF_TEMATICA_CVE` int(11) NOT NULL AUTO_INCREMENT,
  `TEMATICA_CVE` int(11) DEFAULT NULL,
  `EMP_FORMACION_PROFESIONAL_CVE` int(10) DEFAULT NULL,
  PRIMARY KEY (`RFORM_PROF_TEMATICA_CVE`),
  UNIQUE KEY `XPKRFORM_PROF_TEMATICA_CVE` (`RFORM_PROF_TEMATICA_CVE`),
  KEY `XIF14EMP_FORMACION_PROFESIONAL_CVE` (`EMP_FORMACION_PROFESIONAL_CVE`),
  KEY `XIF10TEMATICA_CVE` (`TEMATICA_CVE`),
  CONSTRAINT `emp_formacion_profesional_efpfrk` FOREIGN KEY (`EMP_FORMACION_PROFESIONAL_CVE`) REFERENCES `emp_formacion_profesional` (`EMP_FORMACION_PROFESIONAL_CVE`),
  CONSTRAINT `ctematica_ctmrfk` FOREIGN KEY (`TEMATICA_CVE`) REFERENCES `ctematica` (`TEMATICA_CVE`),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* Elimina relaciÃ³n entre "ctematica" y "emp_formacion_profesional"*/
ALTER TABLE `emp_formacion_profesional` DROP FOREIGN KEY `emp_formacion_profesional_ibfk_1`;
ALTER TABLE `emp_formacion_profesional` DROP TEMATICA_CVE;
/* Agrega a la entidad "emplead" la relacion con "cejercicio_profesional;"*/
ALTER TABLE `empleado` ADD `emp_eje_pro_cve` INT(11) NULL AFTER `delegacion_cve`;  /*Campo agregado a la tabla "emp_comision"*/
CREATE INDEX XIF12_EMPLEADO ON empleado (emp_eje_pro_cve);  /* Se vuelve index el campo */
ALTER TABLE `empleado` ADD CONSTRAINT `cejercicio_profesional_cjpfk_12`   /* Asigna llave foranî¡ª*/
FOREIGN KEY (`emp_eje_pro_cve`) REFERENCES `cejercicio_profesional`(`eje_pro_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificaci 17/08/2016   ****************************************/
ALTER TABLE `emp_educacion_distancia` DROP FOREIGN KEY `emp_educacion_distancia_ibfk_4`; /* Rompe la llave foranea*/
ALTER TABLE emp_educacion_distancia MODIFY COLUMN CURSO_CVE varchar(50) NOT NULL;
ALTER TABLE emp_educacion_distancia DROP CURSO_CVE;
ALTER TABLE `emp_formacion_profesional` ADD `CLAVE_CURSO` varchar(50) NOT NULL AFTER `COMPROBANTE_CVE`

ALTER TABLE `emp_formacion_profesional` ADD `SUB_FOR_PRO_CVE` INT(11) NULL AFTER `FECHA_INSERSION`;  /*Campo agregado a la tabla "emp_comision"*/
CREATE INDEX XIF11EMP_FORMACION_PROFESIONAL ON emp_formacion_profesional (SUB_FOR_PRO_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_formacion_profesional` ADD CONSTRAINT `emp_formacion_profesional_csfpfk_15`   /* Asigna llave foranî¡ª*/
FOREIGN KEY (`SUB_FOR_PRO_CVE`) REFERENCES `csubtipo_formacion_profesional`(`SUB_FOR_PRO_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `emp_educacion_distancia` ADD `IS_CURSO_TUTURIZADO` BOOLEAN NOT NULL AFTER `FECHA_INSERSION`;

ALTER TABLE `emp_actividad_docente` ADD `EMPLEADO_CVE` INT(11) NULL AFTER `FECHA_INSERSION`;  /*Campo agregado a la tabla "emp_comision"*/
CREATE INDEX XIF11EMP_ACTIVIDAD_DOCENTE ON emp_actividad_docente (EMPLEADO_CVE);  /* Se vuelve index el campo */
ALTER TABLE `emp_actividad_docente` ADD CONSTRAINT `emp_actividad_docente_empfk_11`   /* Asigna llave foranî¡ª*/
FOREIGN KEY (`EMPLEADO_CVE`) REFERENCES `empleado`(`EMPLEADO_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ********************modificaci 18/08/2016   ****************************************/
ALTER TABLE emp_formacion_profesional ADD EFP_NOMBRE_CURSO VARCHAR(125) NULL;emp_formacion_profesional_ibfk_9

ALTER TABLE emp_formacion_profesional` DROP FOREIGN KEY `emp_formacion_profesional_ibfk_9`;
ALTER TABLE emp_formacion_profesional DROP EFP_TIENE_FORMA_EDU;
ALTER TABLE emp_formacion_profesional DROP TIP_ACT_DOC_CVE;

ALTER TABLE recuperar_contrasenia MODIFY COLUMN REC_CON_FCH TIMESTAMP NULL;

/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/* *
ALTER TABLE `emp_esp_medica` CHANGE COLUMN `EMP_ESP_MEDICA_CVE` `EMP_ESP_MEDICA_CVE` INT(10) NULL;  /* cambia nombre a columna 
ALTER TABLE `emp_esp_medica` CHANGE `EMP_ESP_MEDICA_CVE` `EMP_ESP_MEDICA_CVE` INT(10) NULL;
*/

call bitacora_ejecuta_historico(272, 'NULL', '11.32.41.86', '/sipimss_censo/index.php/registro', 
NULL, '{"usuario":{"insert":272},"empleado":{"insert":9}}', '272,9', '{"usuario":{"USU_MATRICULA":"311091476","DELEGACION_CVE":"09","USU_CORREO":"leyhlani@gmail.com","USU_CONTRASENIA":"3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","USU_NOMBRE":"LEYLANI","USU_PATERNO":"GARCIA","USU_MATERNO":"BA&UELOS","USU_GENERO":"F","USU_CURP":"GABL800219MDFRXY08","ADSCRIPCION_CVE":"09NC012520","CATEGORIA_CVE":"35312180","ESTADO_USUARIO_CVE":1,"USU_FCH_REGISTRO":"04\/05\/2015"},"empleado":{"EMP_NOMBRE":"LEYLANI","EMP_APE_PATERNO":"GARCIA","EMP_APE_MATERNO":"BA&UELOS","EMP_MATRICULA":"311091476","EMP_CURP":"GABL800219MDFRXY08","DELEGACION_CVE":"09","USUARIO_CVE":272,"ADSCRIPCION_CVE":"09NC012520","EMP_GENERO":"F","EMP_EMAIL":"leyhlani@gmail.com"}}', @res );

{"usuario":{"USU_MATRICULA":"311091476","DELEGACION_CVE":"09","USU_CORREO":"leylanyh@gmail.com","USU_CONTRASENIA":"3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","USU_NOMBRE":"LEYLANI","USU_PATERNO":"GARCIA","USU_MATERNO":"BA&UELOS","USU_GENERO":"F","USU_CURP":"GABL800219MDFRXY08","ADSCRIPCION_CVE":"09NC012520","CATEGORIA_CVE":"35312180","ESTADO_USUARIO_CVE":1,"USU_FCH_REGISTRO":"04/05/2015"},"empleado":{"USUARIO_CVE":276,"EMP_MATRICULA":"311091476"}}