--Modificaciones 10 de agosto de 2016

alter table comprobante add column com_extension varchar(5);

ALTER TABLE `sipimss.`empleado` 
DROP FOREIGN KEY `empleado_ibfk_7`;
ALTER TABLE `sipimss`.`empleado` 
ADD CONSTRAINT `fk_empleaod_usuario`
  FOREIGN KEY (`USUARIO_CVE`)
  REFERENCES `sipimss`.`usuario` (`USUARIO_CVE`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;


alter table empleado 
    add column emp_is_actual numeric(1),
    add column emp_fch_ingreso date,
    add column emp_fch_creacion timestamp,
    add column emp_fch_nac date,
    modify emp_matricula varchar(25);
    
alter table usuario 
    add constraint uq_matricula
    UNIQUE(usu_matricula),
    add constraint uq_matricula_mail
    UNIQUE(usu_matricula,usu_correo);
    
alter table usuario
    drop foreign key usuario_ibfk_3,
    drop foreign key usuario_ibfk_5,
    drop foreign key usuario_ibfk_6,
    drop foreign key usuario_ibfk_7,
    drop foreign key usuario_ibfk_9;

alter table usuario drop column categoria_cve;
alter table usuario drop column adscripcion_cve;
alter table usuario drop column tip_contratacion_cve;
alter table usuario drop column presupuestal_adscripcion_cve;
alter table usuario drop column edo_laboral_cve;
alter table usuario drop column rol_desempenia_cve;
alter table usuario drop column usu_genero;
alter table usuario drop column usu_tel_laboral;
alter table usuario drop column usu_correo_alternativo;
alter table usuario drop column cestado_civil_cve;
alter table usuario drop column delegacion_cve;
alter table usuario drop column usu_antiguedad;

alter table ctipo_material
    add column "TIP_MAT_OPCION" varchar(25);
    
    
    
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
/* finn de modificaciones ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* *
ALTER TABLE `emp_esp_medica` CHANGE COLUMN `EMP_ESP_MEDICA_CVE` `EMP_ESP_MEDICA_CVE` INT(10) NULL;  /* cambia nombre a columna 
ALTER TABLE `emp_esp_medica` CHANGE `EMP_ESP_MEDICA_CVE` `EMP_ESP_MEDICA_CVE` INT(10) NULL;
*/

call bitacora_ejecuta_historico(272, 'NULL', '11.32.41.86', '/sipimss_censo/index.php/registro', 
NULL, '{"usuario":{"insert":272},"empleado":{"insert":9}}', '272,9', '{"usuario":{"USU_MATRICULA":"311091476","DELEGACION_CVE":"09","USU_CORREO":"leyhlani@gmail.com","USU_CONTRASENIA":"3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","USU_NOMBRE":"LEYLANI","USU_PATERNO":"GARCIA","USU_MATERNO":"BA&UELOS","USU_GENERO":"F","USU_CURP":"GABL800219MDFRXY08","ADSCRIPCION_CVE":"09NC012520","CATEGORIA_CVE":"35312180","ESTADO_USUARIO_CVE":1,"USU_FCH_REGISTRO":"04\/05\/2015"},"empleado":{"EMP_NOMBRE":"LEYLANI","EMP_APE_PATERNO":"GARCIA","EMP_APE_MATERNO":"BA&UELOS","EMP_MATRICULA":"311091476","EMP_CURP":"GABL800219MDFRXY08","DELEGACION_CVE":"09","USUARIO_CVE":272,"ADSCRIPCION_CVE":"09NC012520","EMP_GENERO":"F","EMP_EMAIL":"leyhlani@gmail.com"}}', @res );

{"usuario":{"USU_MATRICULA":"311091476","DELEGACION_CVE":"09","USU_CORREO":"leylanyh@gmail.com","USU_CONTRASENIA":"3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","USU_NOMBRE":"LEYLANI","USU_PATERNO":"GARCIA","USU_MATERNO":"BA&UELOS","USU_GENERO":"F","USU_CURP":"GABL800219MDFRXY08","ADSCRIPCION_CVE":"09NC012520","CATEGORIA_CVE":"35312180","ESTADO_USUARIO_CVE":1,"USU_FCH_REGISTRO":"04/05/2015"},"empleado":{"USUARIO_CVE":276,"EMP_MATRICULA":"311091476"}}

------------------------------17_08_206----------------------------------
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

----------------------------17-08-2016-----------------------
CREATE TABLE EMP_ORGANICO AS
SELECT EMP_MATRICULA, CATEGORIA_CVE,ADSCRIPCION_CVE,DELEGACION_CVE,PRESUPUESTAL_ADSCRIPCION_CVE,TIP_CONTRATACION_CVE,EDO_LABORAL_CVE,
EMP_EMAIL,EMP_TEL_LABORAL,EMP_TEL_PARTICULAR,CESTADO_CIVIL_CVE,
EMP_IS_ACTUAL AS EMP_ACTUAL
FROM EMPLEADO;

alter table empleado 
    add constraint uq_empleado_matricula
    unique(emp_matricula);

CREATE TABLE EMP_ORGANICO (
  EMP_ORGANICO_CVE INTEGER NOT NULL,
  EMP_MATRICULA varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  CATEGORIA_CVE int(11) DEFAULT NULL,
  ADSCRIPCION_CVE varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  DELEGACION_CVE char(2) CHARACTER SET utf8 DEFAULT NULL,
  PRESUPUESTAL_ADSCRIPCION_CVE varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  TIP_CONTRATACION_CVE int(11) DEFAULT NULL,
  EDO_LABORAL_CVE int(11) DEFAULT NULL,
  EMP_EMAIL varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  EMP_TEL_LABORAL int(11) DEFAULT NULL,
  EMP_TEL_PARTICULAR int(11) DEFAULT NULL,
  CESTADO_CIVIL_CVE int(11) DEFAULT NULL,
  FCH_REGISTRO DATETIME DEFAULT NOW(), 
  FCH_CAMBIO DATETIME NULL,
  EMP_ACTUAL decimal(1,0) DEFAULT NULL,
    CONSTRAINT FK_EMP_ORGANICO_EMPLEADO
        FOREIGN KEY(EMP_MATRICULA)
        REFERENCES EMPLEADO(emp_matricula),
    CONSTRAINT PK_EMP_ORGANICO
    PRIMARY KEY(EMP_ORGANICO_CVE)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE EMP_BECA
ADD COLUMN IS_LOADED NUMERIC(1) DEFAULT 0 COMMENT 'EL REGISTRO SE CARGÓ POR SISTEMA O POR USUARIO 0->NO, 1->SI';

ALTER TABLE EMP_ACT_INV_EDU
ADD COLUMN IS_LOADED NUMERIC(1) DEFAULT 0 COMMENT 'EL REGISTRO SE CARGÓ POR SISTEMA O POR USUARIO 0->NO, 1->SI';

ALTER TABLE EMP_FORMACION_PROFESIONAL
ADD COLUMN IS_LOADED NUMERIC(1) DEFAULT 0 COMMENT 'EL REGISTRO SE CARGÓ POR SISTEMA O POR USUARIO 0->NO, 1->SI';

ALTER TABLE EMP_EDUCACION_DISTANCIA
ADD COLUMN IS_LOADED NUMERIC(1) DEFAULT 0 COMMENT 'EL REGISTRO SE CARGÓ POR SISTEMA O POR USUARIO 0->NO, 1->SI';

--------------19/08/2016--------------
ALTER TABLE conv_periodo_horas
DROP FOREIGN key `conv_periodo_horas_ibfk_4`;

ALTER TABLE evaluacion_curso_for_profesonal
DROP FOREIGN key `evaluacion_curso_for_profesonal_ibfk_2`;

ALTER TABLE hist_efp_validacion_curso
DROP FOREIGN KEY hist_efp_validacion_curso_ibfk_1;

ALTER TABLE sipimss_20160815.rform_prof_tematica
DROP FOREIGN KEY emp_formacion_profesional_efpfrk; 


ALTER TABLE sipimss_20160815.emp_formacion_profesional 
MODIFY COLUMN EMP_FORMACION_PROFESIONAL_CVE int NOT NULL AUTO_INCREMENT;

ALTER TABLE conv_periodo_horas ADD
CONSTRAINT `conv_periodo_horas_ibfk_4` 
FOREIGN KEY (`EMP_FORMACION_PROFESIONAL_CVE`) 
REFERENCES `emp_formacion_profesional` (`EMP_FORMACION_PROFESIONAL_CVE`);

ALTER TABLE evaluacion_curso_for_profesonal ADD
CONSTRAINT `evaluacion_curso_for_profesonal_ibfk_2` 
FOREIGN KEY (`EMP_FORMACION_PROFESIONAaL_CVE`) 
REFERENCES `emp_formacion_profesional` (`EMP_FORMACION_PROFESIONAL_CVE`);

ALTER TABLE hist_efp_validacion_curso ADD
  CONSTRAINT `hist_efp_validacion_curso_ibfk_1` 
  FOREIGN KEY (`EMP_FORMACION_PROFESIONAL_CVE`) 
  REFERENCES `emp_formacion_profesional` (`EMP_FORMACION_PROFESIONAL_CVE`);
  
ALTER TABLE sipimss_20160815.rform_prof_tematica ADD
CONSTRAINT `emp_formacion_profesional_efpfrk` 
FOREIGN KEY (`EMP_FORMACION_PROFESIONAL_CVE`) 
REFERENCES `emp_formacion_profesional` (`EMP_FORMACION_PROFESIONAL_CVE`);

/* Elimina relación entre "ctematica" y "emp_formacion_profesional"*/
ALTER TABLE `emp_formacion_profesional` DROP FOREIGN KEY `emp_formacion_profesional_ibfk_1`;
ALTER TABLE `emp_formacion_profesional` DROP TEMATICA_CVE;
/* Agrega a la entidad "empleado" la relacion con "cejercicio_profesional;"*/
ALTER TABLE `empleado` ADD `emp_eje_pro_cve` INT(11) NULL AFTER `delegacion_cve`;  /*Campo agregado a la tabla "emp_comision"*/
CREATE INDEX XIF12_EMPLEADO ON empleado (emp_eje_pro_cve);  /* Se vuelve index el campo */
ALTER TABLE `empleado` ADD CONSTRAINT `cejercicio_profesional_cjpfk_12`   /* Asigna llave foran*/
FOREIGN KEY (`emp_eje_pro_cve`) REFERENCES `cejercicio_profesional`(`eje_pro_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;


--------------23/08/2016----LEAS----------
CREATE TABLE `validacion_gral` (
  `VALIDACION_GRAL_CVE` int(11) NULL AUTO_INCREMENT,
  `VAL_CONV_CVE` int(11) DEFAULT NULL,
  `EMPLEADO_CVE` int(10) DEFAULT NULL,
  PRIMARY KEY (`VALIDACION_GRAL_CVE`),
  UNIQUE KEY `XPKRVALIDACION_GRAL_CVE` (`VALIDACION_GRAL_CVE`),
  KEY `XIF011VAL_CONV_CVE` (`VAL_CONV_CVE`),
  KEY `XIF012EMPLEADO_CVE` (`EMPLEADO_CVE`),
  CONSTRAINT `validacion_convocatoria_rvgrfk` FOREIGN KEY (`VAL_CONV_CVE`) REFERENCES `validacion_convocatoria` (`VAL_CON_CVE`),
  CONSTRAINT `empleado_rvgrfk` FOREIGN KEY (`EMPLEADO_CVE`) REFERENCES `empleado` (`EMPLEADO_CVE`),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*Elimina la relacion "validacion_convocatoria" con "hist_validacion" */
ALTER TABLE hist_validacion DROP FOREIGN KEY hist_validacion_ibfk_1;
ALTER TABLE hist_validacion DROP VAL_CON_CVE;

/*Elimina la relacion "empleado" con "hist_validacion" */
ALTER TABLE hist_validacion DROP FOREIGN KEY hist_validacion_ibfk_4;
ALTER TABLE hist_validacion DROP EMPLEADO_CVE;

ALTER TABLE `hist_validacion` ADD `VALIDACION_GRAL_CVE` INT(11) NOT NULL AFTER `EMPLEADO_CVE`;  /*Campo agregado a la tabla "hist_validacion"*/
CREATE INDEX XIF012_HIST_VALIDACION ON hist_validacion (VALIDACION_GRAL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `hist_validacion` ADD CONSTRAINT `validacion_gral_rhvfk_012`   /* Asigna llave foranea*/
FOREIGN KEY (`VALIDACION_GRAL_CVE`) REFERENCES `validacion_gral`(`VALIDACION_GRAL_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/*Campos agregaos a las entidades "hist" de validación*/
ALTER TABLE `hist_beca_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `hist_comision_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `hist_eaid_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `hist_ecc_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `hist_edd_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `hist_edis_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `hist_eem_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `hist_efp_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `hist_efpd_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `hist_fpcs_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `hist_me_validacion_curso` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;

ALTER TABLE `hist_beca_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;
ALTER TABLE `hist_comision_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;
ALTER TABLE `hist_eaid_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;
ALTER TABLE `hist_ecc_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;
ALTER TABLE `hist_edd_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;
ALTER TABLE `hist_edis_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;
ALTER TABLE `hist_eem_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;
ALTER TABLE `hist_efp_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;
ALTER TABLE `hist_efpd_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;
ALTER TABLE `hist_fpcs_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;
ALTER TABLE `hist_me_validacion_curso` DROP `IS_VALIDO_PROFESIONALIZACION` ;

ALTER TABLE `emp_beca` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `emp_comision` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `emp_act_inv_edu` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `emp_ciclos_clinicos` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `emp_educacion_distancia` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `emp_desa_inv_salud` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `emp_esp_medica` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `emp_formacion_profesional` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `emp_actividad_docente` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `emp_for_personal_continua_salud` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;
ALTER TABLE `emp_materia_educativo` ADD `IS_VALIDO_PROFESIONALIZACION` boolean NOT NULL default 0;

ALTER TABLE `hist_validacion` ADD `IS_ACTUAL` boolean NOT NULL default 1;
ALTER TABLE `cdepartamento` ADD `IS_UNIDAD_VALIDACION` boolean NOT NULL default 0;





/*TIPO DE UNIDAD DE VALIDACION (No llevada a cabo)ºº¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡ **/
CREATE TABLE `ctipo_unidad_validacion` (
  `TIPO_UNIDAD_VALIDACION_CVE` int(11) NULL AUTO_INCREMENT,
  `TP_UNIDAD_NOMBRE` VARCHAR(30) DEFAULT NULL,
  PRIMARY KEY (`TIPO_UNIDAD_VALIDACION_CVE`)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*----------------2016/08/25------------------------*/
ALTER TABLE hist_beca_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ;
ALTER TABLE hist_comision_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ;
ALTER TABLE hist_eaid_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ;
ALTER TABLE hist_ecc_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ;
ALTER TABLE hist_edd_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ;
ALTER TABLE hist_edis_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ;
ALTER TABLE hist_eem_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ;
ALTER TABLE hist_efp_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ;
ALTER TABLE hist_efpd_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL;
ALTER TABLE hist_fpcs_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ;
ALTER TABLE hist_me_validacion_curso MODIFY COLUMN VAL_CUR_FCH TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ;


/*----------------2016/08/29------------------------*/
ALTER TABLE sipimss_pdos.modulo MODIFY COLUMN IS_CONTROLADOR int(1) DEFAULT 0 NOT NULL; /*Cambia tipo de dato a int de "1" para distinguir entre un controlador = 1, un controlador de tareas = 2, un hijo de controlador  = 0*/

/*----------------2016/09/05------------------------*/
ALTER TABLE cestado_evaluacion MODIFY COLUMN EST_EVA_NOMBRE varchar(50) NOT NULL;
ALTER TABLE sipimss_20160829.cestado_validacion MODIFY COLUMN EST_VALIDA_DESC varchar(50) NULL;
ALTER TABLE sipimss_20160905.cestado_validacion MODIFY COLUMN EST_VALIDA_DESC varchar(50) NULL;

/*----------------2016/09/06------------------------*/
/*Agrega curso a empleado eucación a distancia */
ALTER TABLE emp_educacion_distancia ADD CURSO_CVE INT(11) NULL AFTER IS_VALIDO_PROFESIONALIZACION;  /*Campo agregado a la tabla "emp_comision"*/
CREATE INDEX XIF11EMP_EDUCACION_DISTANCIA ON emp_educacion_distancia (CURSO_CVE);  /* Se vuelve index el campo */
ALTER TABLE emp_educacion_distancia ADD CONSTRAINT `emp_educacion_distancia_rccfk_11`   /* Asigna llave foran*/
FOREIGN KEY (`CURSO_CVE`) REFERENCES `ccurso`(`CURSO_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;



/*****************2016/09/02*************************/
--Creación de tablas
DROP TABLE IF EXISTS `bono_emp_can_bono`;
DROP table if exists bono_cestado_bono;
DROP table if exists bono_can_bono_reg;
DROP table if exists bono_convocatoria_bono;
DROP table if exists bono_ctipo_evaluacion;
DROP table if exists bono_cadmin_bonos;
DROP table if exists ini_ses_int;
DROP table if exists bono_act_edu_dist;

CREATE TABLE `bono_cestado_bono` (
  `est_bono_cve` int(11) NOT NULL AUTO_INCREMENT,
  `est_nombre` varchar(50) NOT NULL,
  `est_estado_nombre` varchar(30) NOT NULL,
  `est_orden` int(2) NOT NULL,
  constraint pk_cestado_bono
  PRIMARY KEY (`est_bono_cve`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

CREATE TABLE `bono_emp_can_bono` (
  `emp_can_cve` int(11) NOT NULL AUTO_INCREMENT,
  `empleado_cve` int(11) NOT NULL,
  `can_periodo_bono` int(4) NOT NULL,
  `can_sum_act` smallint(3) NOT NULL,
  `can_estado` smallint(1) NOT NULL DEFAULT '0',
  `can_tot_pro_eva` decimal(3,1) NOT NULL DEFAULT '0.0',
  `can_correo` varchar(100) NOT NULL,
  `conv_bono_cve` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`emp_can_cve`),
  CONSTRAINT `FK_EMPCANBONO` 
  FOREIGN KEY (`empleado_cve`) 
  REFERENCES `empleado` (`empleado_cve`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bono_can_bono_reg` (
  `reg_bono_cve` int(11) NOT NULL AUTO_INCREMENT,
  `emp_can_cve` int(11) NOT NULL,
  `est_bono_cve` int(11) NOT NULL,
  `reg_fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `reg_promedio` decimal(5,2) DEFAULT NULL,
  `reg_msg` varchar(150) DEFAULT NULL,
  `tar_cve` int(11) DEFAULT NULL,
  `accion_tarjeton` tinyint(1) NOT NULL DEFAULT '0',
  `act_cve` int(11) DEFAULT NULL,
  `accion_actuacion` tinyint(1) NOT NULL DEFAULT '0',
  constraint pk_reg_bono_cve
  PRIMARY KEY (`reg_bono_cve`),
  CONSTRAINT `cbr_eb_fk` 
  FOREIGN KEY (`est_bono_cve`) 
  REFERENCES `bono_cestado_bono` (`est_bono_cve`),
  CONSTRAINT `cbr_ecb_fk` 
  FOREIGN KEY (`emp_can_cve`) 
  REFERENCES `bono_emp_can_bono` (`emp_can_cve`),
  CONSTRAINT `cbr_tar_fk` 
  FOREIGN KEY (`tar_cve`) 
  REFERENCES `tarjeton` (`tarjeton_cve`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bono_convocatoria_bono` (
  `conv_bono_cve` int(11) NOT NULL AUTO_INCREMENT,
  `nom_bono` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `f_ini_carga_datos` datetime NOT NULL,
  `f_fin_carga_datos` datetime NOT NULL,
  `max_beneficiados` int(4) NOT NULL,
  `anio_bono` year(4) NOT NULL,
  `status_bono` smallint(1) NOT NULL,
  PRIMARY KEY (`conv_bono_cve`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `bono_ctipo_evaluacion` (
  `tipo_eva_cve` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_eva_nombre` varchar(100) NOT NULL,
  `id_regla_evaluacion` int(11) NOT NULL COMMENT 'PK logica viene de tabla reglas evaluacion',
  PRIMARY KEY (`tipo_eva_cve`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `bono_cadmin_bonos` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `usr_matricula` varchar(20) NOT NULL,
  `usr_nombre` varchar(60) NOT NULL,
  `usr_paterno` varchar(60) NOT NULL,
  `usr_materno` varchar(60) DEFAULT NULL,
  `usr_correo` varchar(80) NOT NULL,
  `usr_activo` decimal(1,0) NOT NULL DEFAULT '1',
  `usr_passwd` char(128) NOT NULL,
  `usr_rol_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `ini_ses_int` (
  `usr_matricula` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bono_act_edu_dist` (
  `act_cve` int(11) NOT NULL AUTO_INCREMENT,
  `cur_edu_dist_cve` int(11) NOT NULL,
  `tipo_eva_cve` int(11) NOT NULL,
  `act_promedio` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`act_cve`),
  CONSTRAINT `act_edu_dist_ctipo_evaluacion_fk` 
  FOREIGN KEY (`tipo_eva_cve`) 
  REFERENCES `bono_ctipo_evaluacion` (`tipo_eva_cve`),
  CONSTRAINT `act_edu_dist_emp_educacion_distancia_fk` 
  FOREIGN KEY (`cur_edu_dist_cve`) 
  REFERENCES `emp_educacion_distancia` (`EMP_EDU_DISTANCIA_CVE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*******************2016/09/03************************/
alter table emp_formacion_profesional add
column efp_aplica_ecd numeric(1) default 0;

INSERT INTO `sipimss_20160903`.`modulo`
(`MOD_NOMBRE`,
`MOD_RUTA`,
`MOD_EST_CVE`,
`IS_CONTROLADOR`)
VALUES
('Evaluación de carrera docente','solicitar_evaluacion',1,1);

-------------------2016/09/07------------------------------
ALTER TABLE `crol_desempenia` ADD `ROL_MDL_CVE` bigint NOT NULL ;
ALTER TABLE `ccurso` ADD column `CVE_CURSO_FUENTE` bigint NOT NULL ;

-------------------2016/09/08------------------------------
alter table admin_validador rename evaluacion_convocatoria;
alter table evaluacion_convocatoria add column is_actual numeric(1) default 1;

alter table validador rename evaluacion_validador;
alter table evaluacion_validador add 
column fch_insert datetime default current_timestamp;

CREATE TABLE cestado_solicitud_evauacion(
    CESE_CVE INTEGER NOT NULL AUTO_INCREMENT,
    CESE_NOMBRE VARCHAR(30) NOT NULL,
    CONSTRAINT PK_CESE
    PRIMARY KEY(CESE_CVE)
);


alter table validacion_validador drop foreign key validacion_validador_ibfk_1;
alter table validacion_validador drop foreign key validacion_validador_ibfk_2;
alter table validacion_validador drop foreign key validacion_validador_ibfk_3;
alter table validacion_validador drop foreign key validacion_validador_ibfk_4;
alter table validacion_validador drop foreign key validacion_validador_ibfk_5;
alter table validacion_validador drop column msg_correcciones;
alter table validacion_validador drop column unidad_cve;
alter table validacion_validador drop column est_validacion_cve; 
alter table validacion_validador drop column rol_validador_cve;
alter table validacion_validador drop column seleccion_dictamen;
alter table validacion_validador drop column admin_validador_cve;
alter table validacion_validador rename evaluacion_solicitud;
alter table evaluacion_solicitud add column fch_evaluacion_update timestamp not null;
alter table evaluacion_solicitud drop column FCH_REGISTRO_VALIDADOR;
alter table evaluacion_solicitud add column FCH_REGISTRO_VALIDADOR datetime not null default current_timestamp;
alter table evaluacion_solicitud add column CESE_CVE INTEGER NOT NULL;
ALTER TAble evaluacion_solicitud add
constraint fk_es_cese
foreign key(CESE_CVE)
references cestado_solicitud_evauacion(CESE_CVE);

drop table cunidad;
drop table crol_validador;
create table evaluacion_hist_validacion(
    hist_validacion_cve INTEGER not null auto_increment,
    msg_correcciones text,
    est_validacion_cve integer not null,
    solicitud_cve int not null,
    validador_cve int null,
    fch_registro_historia datetime not null default current_timestamp,
    is_actual numeric(1) not null default 0,
    seleccion_dictamen varchar(18),
    convocatoria_cve integer not null,
    
    constraint pk_hist_validacion
    primary key(hist_validacion_cve),
    
    constraint fk_ehv_cev
    foreign key(est_validacion_cve)
    references cestado_validacion(est_validacion_cve),
    
    constraint fk_ehv_ev
    foreign key(validador_cve)
    references evaluacion_validador(validador_cve),
    
    constraint fk_ehv_es
    foreign key(solicitud_cve)
    references evaluacion_solicitud(validacion_cve),
    
    constraint fk_ehv_conv
    foreign key(convocatoria_cve)
    references evaluacion_convocatoria(admin_validador_cve)
);

create table cseccion_informacion(
    sec_info_cve int auto_increment,
    csi_nombre varchar(20) not null,
    csi_entidad varchar(100) not null,
    constraint pk_cseccion_informacion
    primary key(sec_info_cve)
);

create table evaluacion_bloques_val(
    ebv_cve integer not null auto_increment,
    sec_info_cve int not null,
    fch_insert datetime not null default current_timestamp,
    ehv_cve integer not null,
    estado_validacion_cve integer not null,
    txt_descripcion text,
    
    constraint pk_evaluacion_bloques_val
    primary key(ebv_cve),
    
    constraint fk_ebv_ehv
    foreign key(ehv_cve)
    references evaluacion_hist_validacion(hist_validacion_cve),
    
    constraint fk_ebv_cvce
    foreign key(estado_validacion_cve)
    references cvalidacion_curso_estado(VAL_CUR_EST_CVE),
    
    constraint fk_ebv_csi
    foreign key(sec_info_cve)
    references cseccion_informacion(sec_info_cve)
    
);

create table evaluacion_curso_validacion(
    ecv_cve integer not null auto_increment,
    es_cve integer not null comment 'clave de la solicitud',
    csi_cve integer not null comment 'nombre de la sección a la que pertenece',
    seccion_cve integer not null comment 'clave del curso/registro por validar',
    is_valido numeric(1) not null default 0,
    constraint pk_ecv
    primary key(ecv_cve),
    
    constraint fk_ecv_es
    foreign key(es_cve)
    references evaluacion_solicitud(VALIDACION_CVE),
    
    constraint fk_ecv_csi
    foreign key(csi_cve)
    references cseccion_informacion(sec_info_cve)
);


alter table evaluacion_validador rename validador;
alter table cseccion_informacion add column nom_camp_pk varchar(20) not null;

-------------------2016/09/09 Responsable Jesus, ejecucion LEAS-----------------------------
ALTER TABLE dictamen ADD VALIDACION_CVE INT(11) NOT NULL;  /*Campo agregado a la tabla "dictamen"*/
CREATE INDEX XIF11_DICTAMEN ON dictamen (VALIDACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE dictamen ADD CONSTRAINT `dictamen_vcvefk_11`   /* Asigna llave forania*/
FOREIGN KEY (`VALIDACION_CVE`) REFERENCES `evaluacion_solicitud`(`VALIDACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
-------------------2016/09/13 ----------------------------------------------
ALTER TABLE `validador` ADD IS_ACTUAL BOOLEAN NOT NULL DEFAULT 1; 

-------------------2016/09/19 Responsable Jesus, Miguel Luis, ejecución cambios LEAS-----------------------------

/*Crea tablas valtantes para total de puntos y relación con solicitud de evaluación "evaluacion_for_profesonal"
"evaluacion_esp_medica" "evaluacion_beca"  */
CREATE TABLE `evaluacion_for_profesional` (
  `EVALUACION_CVE` int(11) NOT NULL AUTO_INCREMENT,
  `TOTAL_PUNTOS` int(11) DEFAULT NULL,
  `MSG_INCONFORMIDAD` varchar(200) DEFAULT NULL,
  `SOLICITUD_VAL_CVE` int(11) DEFAULT NULL,
  `EST_EVALUACION_CVE` int(11) DEFAULT NULL,
  PRIMARY KEY (`EVALUACION_CVE`),
  KEY `XIF10EVALUACION_FOR_PROFESIONAL` (`SOLICITUD_VAL_CVE`),
  KEY `XIF011EVALUACION_ACT_DOC` (`EST_EVALUACION_CVE`),
  CONSTRAINT `evaluacion_for_profesonal_esfk_10` FOREIGN KEY (`SOLICITUD_VAL_CVE`) REFERENCES `evaluacion_solicitud` (`VALIDACION_CVE`),
  CONSTRAINT `evaluacion_fpcs_ibfk_011` FOREIGN KEY (`EST_EVALUACION_CVE`) REFERENCES `cestado_evaluacion` (`EST_EVALUACION_CVE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `evaluacion_esp_medica` (
  `EVALUACION_CVE` int(11) NOT NULL AUTO_INCREMENT,
  `TOTAL_PUNTOS` int(11) DEFAULT NULL,
  `MSG_INCONFORMIDAD` varchar(200) DEFAULT NULL,
  `SOLICITUD_VAL_CVE` int(11) DEFAULT NULL,
  `EST_EVALUACION_CVE` int(11) DEFAULT NULL,
  PRIMARY KEY (`EVALUACION_CVE`),
  KEY `XIF11EVALUACION_ESP_MEDICA` (`SOLICITUD_VAL_CVE`),
  KEY `XIF012EVALUACION_ACT_DOC` (`EST_EVALUACION_CVE`),
  CONSTRAINT `evaluacion_esp_medica_esfk_11` FOREIGN KEY (`SOLICITUD_VAL_CVE`) REFERENCES `evaluacion_solicitud` (`VALIDACION_CVE`),
  CONSTRAINT `evaluacion_fpcs_ibfk_013` FOREIGN KEY (`EST_EVALUACION_CVE`) REFERENCES `cestado_evaluacion` (`EST_EVALUACION_CVE`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `evaluacion_beca` (
  `EVALUACION_CVE` int(11) NOT NULL AUTO_INCREMENT,
  `TOTAL_PUNTOS` int(11) DEFAULT NULL,
  `MSG_INCONFORMIDAD` varchar(200) DEFAULT NULL,
  `SOLICITUD_VAL_CVE` int(11) DEFAULT NULL,
  `EST_EVALUACION_CVE` int(11) DEFAULT NULL,
  PRIMARY KEY (`EVALUACION_CVE`),
  KEY `XIF12EVALUACION_BECA` (`SOLICITUD_VAL_CVE`),
  KEY `XIF014EVALUACION_ACT_DOC` (`EST_EVALUACION_CVE`),
  CONSTRAINT `evaluacion_beca_esfk_12` FOREIGN KEY (`SOLICITUD_VAL_CVE`) REFERENCES `evaluacion_solicitud` (`VALIDACION_CVE`),
  CONSTRAINT `evaluacion_fpcs_ibfk_014` FOREIGN KEY (`EST_EVALUACION_CVE`) REFERENCES `cestado_evaluacion` (`EST_EVALUACION_CVE`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `evaluacion_edu_dis` ADD CONSTRAINT `evaluacion_edu_dis_ibfk_1` FOREIGN KEY (`EST_EVALUACION_CVE`) REFERENCES `cestado_evaluacion` (`EST_EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;


/*Crea llave primaria a las siguientes entidades "evaluacion_act_doc", "evaluacion_act_inv_edu", "evaluacion_comision",
"evaluacion_edu_dis", "evaluacion_fpcs", "evaluacion_mat_edu" */
ALTER TABLE evaluacion_act_doc ADD EVALUACION_CVE INT(11) not null;
ALTER table evaluacion_act_doc add primary key (EVALUACION_CVE);
ALTER TABLE evaluacion_act_doc CHANGE `EVALUACION_CVE` `EVALUACION_CVE` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE evaluacion_act_inv_edu ADD EVALUACION_CVE INT(11) not null;
ALTER table evaluacion_act_inv_edu add primary key (EVALUACION_CVE);
ALTER TABLE evaluacion_act_inv_edu CHANGE `EVALUACION_CVE` `EVALUACION_CVE` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE evaluacion_comision ADD EVALUACION_CVE INT(11) not null;
ALTER table evaluacion_comision add primary key (EVALUACION_CVE);
ALTER TABLE evaluacion_comision CHANGE `EVALUACION_CVE` `EVALUACION_CVE` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE evaluacion_edu_dis ADD EVALUACION_CVE INT(11) not null;
ALTER table evaluacion_edu_dis add primary key (EVALUACION_CVE);
ALTER TABLE evaluacion_edu_dis CHANGE `EVALUACION_CVE` `EVALUACION_CVE` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE evaluacion_fpcs ADD EVALUACION_CVE INT(11) not null;
ALTER table evaluacion_fpcs add primary key (EVALUACION_CVE);
ALTER TABLE evaluacion_fpcs CHANGE `EVALUACION_CVE` `EVALUACION_CVE` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE evaluacion_mat_edu ADD EVALUACION_CVE INT(11) not null;
ALTER table evaluacion_mat_edu add primary key (EVALUACION_CVE);
ALTER TABLE evaluacion_mat_edu CHANGE `EVALUACION_CVE` `EVALUACION_CVE` INT( 11 ) NOT NULL AUTO_INCREMENT;

/*Eliminar fore key  y campo "EVA_CURSO_CVE" "evaluacion_act_doc", "evaluacion_act_inv_edu", "evaluacion_comision",
"evaluacion_edu_dis", "evaluacion_fpcs", "evaluacion_mat_edu" */

ALTER TABLE `evaluacion_act_doc` DROP FOREIGN KEY `evaluacion_act_doc_ibfk_1`; 
ALTER TABLE `evaluacion_act_doc` DROP FOREIGN KEY `evaluacion_act_doc_ibfk_2`; 
ALTER TABLE `evaluacion_act_doc` DROP FOREIGN KEY `evaluacion_act_doc_ibfk_3`; 
ALTER TABLE evaluacion_act_doc DROP EVA_CURSO_CVE;

ALTER TABLE `evaluacion_act_inv_edu` DROP FOREIGN KEY `evaluacion_act_inv_edu_ibfk_1`;
ALTER TABLE evaluacion_act_inv_edu DROP EVA_CURSO_CVE;

ALTER TABLE `evaluacion_comision` DROP FOREIGN KEY `evaluacion_comision_ibfk_1`;
ALTER TABLE evaluacion_comision DROP EVA_CURSO_CVE;

ALTER TABLE `evaluacion_edu_dis` DROP FOREIGN KEY `evaluacion_edu_dis_ibfk_2`;
ALTER TABLE evaluacion_edu_dis DROP EVA_CURSO_CVE;

ALTER TABLE `evaluacion_fpcs` DROP FOREIGN KEY `evaluacion_fpcs_ibfk_1`;
ALTER TABLE evaluacion_fpcs DROP EVA_CURSO_CVE;

ALTER TABLE `evaluacion_mat_edu` DROP FOREIGN KEY `evaluacion_mat_edu_ibfk_1`;
ALTER TABLE evaluacion_mat_edu DROP EVA_CURSO_CVE;

/*Relacionar solicitud_cve a las siguientes entidades "SOLICITUD_VAL_CVE" "evaluacion_act_doc", "evaluacion_act_inv_edu", "evaluacion_comision",
"evaluacion_edu_dis", "evaluacion_fpcs", "evaluacion_mat_edu" */

ALTER TABLE `evaluacion_act_doc` ADD `SOLICITUD_VAL_CVE` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_act_doc" */
CREATE INDEX XIF14EVALUACION_ACT_DOC ON evaluacion_act_doc (SOLICITUD_VAL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_act_doc` ADD CONSTRAINT `evaluacion_act_doc_esfk`   /* Asigna llave foran */
FOREIGN KEY (`SOLICITUD_VAL_CVE`) REFERENCES `evaluacion_solicitud`(`VALIDACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_act_inv_edu` ADD `SOLICITUD_VAL_CVE` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_act_inv_edu" */
CREATE INDEX XIF15EVALUACION_ACT_INV ON evaluacion_act_inv_edu (SOLICITUD_VAL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_act_inv_edu` ADD CONSTRAINT `evaluacion_act_inv_edu_esfk`   /* Asigna llave foran */
FOREIGN KEY (`SOLICITUD_VAL_CVE`) REFERENCES `evaluacion_solicitud`(`VALIDACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_comision` ADD `SOLICITUD_VAL_CVE` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_comision" */
CREATE INDEX XIF16EVALUACION_COMISION ON evaluacion_comision (SOLICITUD_VAL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_comision` ADD CONSTRAINT `evaluacion_comision_esfk`   /* Asigna llave foran */
FOREIGN KEY (`SOLICITUD_VAL_CVE`) REFERENCES `evaluacion_solicitud`(`VALIDACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_edu_dis` ADD `SOLICITUD_VAL_CVE` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_edu_dis" */
CREATE INDEX XIF17EVALUACION_EDU_DIS ON evaluacion_edu_dis (SOLICITUD_VAL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_edu_dis` ADD CONSTRAINT `evaluacion_edu_dis_esfk`   /* Asigna llave foran */
FOREIGN KEY (`SOLICITUD_VAL_CVE`) REFERENCES `evaluacion_solicitud`(`VALIDACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_fpcs` ADD `SOLICITUD_VAL_CVE` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_fpcs" */
CREATE INDEX XIF18EVALUACION_FPCS ON evaluacion_fpcs (SOLICITUD_VAL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_fpcs` ADD CONSTRAINT `evaluacion_fpcs_esfk`   /* Asigna llave foran */
FOREIGN KEY (`SOLICITUD_VAL_CVE`) REFERENCES `evaluacion_solicitud`(`VALIDACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_mat_edu` ADD `SOLICITUD_VAL_CVE` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_mat_edu" */
CREATE INDEX XIF19EVALUACION_MAT_EDU ON evaluacion_mat_edu (SOLICITUD_VAL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_mat_edu` ADD CONSTRAINT `evaluacion_mat_edu_esfk`   /* Asigna llave foran */
FOREIGN KEY (`SOLICITUD_VAL_CVE`) REFERENCES `evaluacion_solicitud`(`VALIDACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/*Relacionar SECCION_informacion  a las siguientes entidades "SOLICITUD_VAL_CVE" "evaluacion_act_doc", "evaluacion_act_inv_edu", "evaluacion_comision", "evaluacion_edu_dis", "evaluacion_fpcs", "evaluacion_mat_edu", "evaluacion_for_profesonal", "evaluacion_esp_medica", "evaluacion_beca" */

ALTER TABLE `evaluacion_act_doc` ADD `sec_info_cve` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_act_doc" */
CREATE INDEX XIF141EVALUACION_ACT_DOC ON evaluacion_act_doc (sec_info_cve);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_act_doc` ADD CONSTRAINT `evaluacion_act_doc_csifk`   /* Asigna llave foran */
FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion`(`sec_info_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_act_inv_edu` ADD `sec_info_cve` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_act_inv_edu" */
CREATE INDEX XIF151EVALUACION_ACT_INV ON evaluacion_act_inv_edu (sec_info_cve);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_act_inv_edu` ADD CONSTRAINT `evaluacion_act_inv_edu_csifk`   /* Asigna llave foran */
FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion`(`sec_info_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_comision` ADD `sec_info_cve` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_comision" */
CREATE INDEX XIF161EVALUACION_COMISION ON evaluacion_comision (sec_info_cve);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_comision` ADD CONSTRAINT `evaluacion_comision_csifk`   /* Asigna llave foran */
FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion`(`sec_info_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_edu_dis` ADD `sec_info_cve` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_edu_dis" */
CREATE INDEX XIF171EVALUACION_EDU_DIS ON evaluacion_edu_dis (sec_info_cve);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_edu_dis` ADD CONSTRAINT `evaluacion_edu_dis_csifk`   /* Asigna llave foran */
FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion`(`sec_info_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_fpcs` ADD `sec_info_cve` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_fpcs" */
CREATE INDEX XIF181EVALUACION_FPCS ON evaluacion_fpcs (sec_info_cve);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_fpcs` ADD CONSTRAINT `evaluacion_fpcs_csifk`   /* Asigna llave foran */
FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion`(`sec_info_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_mat_edu` ADD `sec_info_cve` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_mat_edu" */
CREATE INDEX XIF191EVALUACION_MAT_EDU ON evaluacion_mat_edu (sec_info_cve);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_mat_edu` ADD CONSTRAINT `evaluacion_mat_edu_csifk`   /* Asigna llave foran */
FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion`(`sec_info_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_for_profesional` ADD `sec_info_cve` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_for_profesional" */
CREATE INDEX XIF111EVALUACION_FORMACION_PROFESIONAL ON evaluacion_for_profesional (sec_info_cve);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_for_profesional` ADD CONSTRAINT `evaluacion_for_profesonal_csifk`   /* Asigna llave foran */
FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion`(`sec_info_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_esp_medica` ADD `sec_info_cve` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_esp_medica" */
CREATE INDEX XIF121EVALUACION_ESP_MEDICA ON evaluacion_esp_medica (sec_info_cve);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_esp_medica` ADD CONSTRAINT `evaluacion_esp_medica_csifk`   /* Asigna llave foran */
FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion`(`sec_info_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `evaluacion_beca` ADD `sec_info_cve` INT(11) NOT NULL;  /*Campo agregado a la tabla "evaluacion_beca" */
CREATE INDEX XIF131EVALUACION_BECA ON evaluacion_beca (sec_info_cve);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_beca` ADD CONSTRAINT `evaluacion_beca_csifk`   /* Asigna llave foran */
FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion`(`sec_info_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/*Relacionar SECCION_informacion  a las siguientes entidades "SOLICITUD_VAL_CVE" "evaluacion_act_doc", "evaluacion_act_inv_edu", "evaluacion_comision", "evaluacion_edu_dis", "evaluacion_fpcs", "evaluacion_mat_edu", "evaluacion_for_profesonal", "evaluacion_esp_medica", "evaluacion_beca" */

ALTER TABLE `evaluacion_curso_act_docente` ADD `EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_act_docente" */
CREATE INDEX XIF131EVALUACION_CURSO_ACT_DOCENTE ON evaluacion_curso_act_docente (EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_act_docente` ADD CONSTRAINT `evaluacion_curso_act_docente_eadfk`   /* Asigna llave foran */
FOREIGN KEY (`EVALUACION_CVE`) REFERENCES `evaluacion_act_doc`(`EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_act_inv_edu` ADD `EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_act_inv_edu" */
CREATE INDEX XIF132EVALUACION_CURSO_INT_EDU ON evaluacion_curso_act_inv_edu (EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_act_inv_edu` ADD CONSTRAINT `evaluacion_curso_act_inv_edu_eaiefk`   /* Asigna llave foran */
FOREIGN KEY (`EVALUACION_CVE`) REFERENCES `evaluacion_act_inv_edu`(`EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_comision` ADD `EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_comision" */
CREATE INDEX XIF133EVALUACION_CURSO_COMISION ON evaluacion_curso_comision (EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_comision` ADD CONSTRAINT `evaluacion_curso_comision_eaiefk`   /* Asigna llave foran */
FOREIGN KEY (`EVALUACION_CVE`) REFERENCES `evaluacion_comision`(`EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_edu_dis` ADD `EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_edu_dis" */
CREATE INDEX XIF134EVALUACION_CURSO_EDU_DIS ON evaluacion_curso_edu_dis (EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_edu_dis` ADD CONSTRAINT `evaluacion_curso_edu_dis_eedfk`   /* Asigna llave foran */
FOREIGN KEY (`EVALUACION_CVE`) REFERENCES `evaluacion_edu_dis`(`EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `evaluacion_curso_fpcs` ADD `EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_fpcs" */
CREATE INDEX XIF135EVALUACION_CURSO_FPCS ON evaluacion_curso_fpcs (EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_fpcs` ADD CONSTRAINT `evaluacion_curso_fpcs_efpcsfk`   /* Asigna llave foran */
FOREIGN KEY (`EVALUACION_CVE`) REFERENCES `evaluacion_fpcs`(`EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_mat_edu` ADD `EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_mat_edu" */
CREATE INDEX XIF136EVALUACION_CURSO_MAT_EDU ON evaluacion_curso_mat_edu (EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_mat_edu` ADD CONSTRAINT `evaluacion_curso_mat_edu_emefk`   /* Asigna llave foran */
FOREIGN KEY (`EVALUACION_CVE`) REFERENCES `evaluacion_mat_edu`(`EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

rename table evaluacion_curso_for_profesonal to evaluacion_curso_for_profesional; /*Modifica NOMBRE DE la entidad */

ALTER TABLE `evaluacion_curso_for_profesional` ADD `EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_for_profesional" */
CREATE INDEX XIF137EVALUACION_CURSO_FOR_PROFESIONAL ON evaluacion_curso_for_profesional (EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_for_profesional` ADD CONSTRAINT `evaluacion_curso_for_profesional_efpfk`   /* Asigna llave foran */
FOREIGN KEY (`EVALUACION_CVE`) REFERENCES `evaluacion_for_profesional`(`EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `evaluacion_curso_esp_medica` ADD `EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_esp_medica" */
CREATE INDEX XIF138EVALUACION_CURSO_ESP_MEDICA ON evaluacion_curso_esp_medica (EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_esp_medica` ADD CONSTRAINT `	`   /* Asigna llave foran */
FOREIGN KEY (`EVALUACION_CVE`) REFERENCES `evaluacion_esp_medica`(`EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

evaluacion_act_doc
evaluacion_act_inv_edu
evaluacion_comision
evaluacion_edu_dis
evaluacion_fpcs
evaluacion_mat_edu
/* faltantes OK*/
evaluacion_for_profesional
evaluacion_esp_medica
evaluacion_beca   

evaluacion_curso_act_docente
evaluacion_curso_act_inv_edu
evaluacion_curso_comision
evaluacion_curso_edu_dis
evaluacion_curso_fpcs
evaluacion_curso_mat_edu
evaluacion_curso_for_profesional
evaluacion_curso_esp_medica
/* faltante DUDA*/
evaluacion_curso_beca    


emp_actividad_docente
emp_act_inv_edu
emp_comision
emp_educacion_distancia
emp_for_personal_continua_salud
emp_formacion_profesional
emp_materia_educativo
emp_esp_medica
emp_beca
emp_desa_inv_salud /*No contar por ahora*/

evaluacion_solicitud


-------------------2016/09/19 Responsable Pablo, Jesus. Eejecución cambios LEAS-----------------------------
SHOW TABLES IN sipimss_20160915 LIKE 'tabulador%' ;

desc  tabulador_act_docente;
desc  tabulador_act_inv_edu;
desc  tabulador_com_academica;
desc  tabulador_conv_per_horas;
desc  tabulador_coordinador;
desc  tabulador_dir_tesis;
desc  tabulador_edu_continua;
desc  tabulador_edu_distancia;
desc  tabulador_ela_meterial;

SHOW  COLUMNS FROM tabulador_act_docente FROM sipimss_20160915 LIKE '%puntos%';
SHOW  COLUMNS IN tabulador_act_inv_edu FROM sipimss_20160915 LIKE '%puntos%';
SHOW  COLUMNS IN tabulador_com_academica FROM sipimss_20160915 LIKE '%puntos%';
SHOW  COLUMNS IN tabulador_coordinador FROM sipimss_20160915 LIKE '%puntos%';
SHOW  COLUMNS FROM tabulador_dir_tesis FROM sipimss_20160915 LIKE '%puntos%';
SHOW  COLUMNS IN tabulador_edu_continua FROM sipimss_20160915 LIKE '%puntos%';
SHOW  COLUMNS IN tabulador_edu_distancia FROM sipimss_20160915 LIKE '%puntos%';
SHOW  COLUMNS IN tabulador_ela_meterial FROM sipimss_20160915 LIKE '%puntos%';

ALTER TABLE tabulador_act_docente MODIFY COLUMN TAD_PRE_RANGO_1_PUNTOS DECIMAL(8,3) NULL; 
ALTER TABLE tabulador_act_docente MODIFY COLUMN TAD_PRE_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_act_docente MODIFY COLUMN TAD_PRE_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_act_docente MODIFY COLUMN TAD_MIX_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_act_docente MODIFY COLUMN TAD_MIX_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_act_docente MODIFY COLUMN TAD_MIX_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_act_docente MODIFY COLUMN TAD_LINEA_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_act_docente MODIFY COLUMN TAD_LINEA_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_act_docente MODIFY COLUMN TAD_LINEA_RANGO_3_PUNTOS DECIMAL(8,3) NULL;

ALTER TABLE tabulador_com_academica MODIFY COLUMN TCA_RANGO_1_PUNTOS DECIMAL(8,3) NULL;

ALTER TABLE tabulador_coordinador MODIFY COLUMN TC_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_coordinador MODIFY COLUMN TC_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_coordinador MODIFY COLUMN TC_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_continua MODIFY COLUMN TEC_PRE_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_continua MODIFY COLUMN TEC_PRE_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_continua MODIFY COLUMN TEC_PRE_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_continua MODIFY COLUMN TEC_MIX_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_continua MODIFY COLUMN TEC_MIX_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_continua MODIFY COLUMN TEC_MIX_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_continua MODIFY COLUMN TEC_LINEA_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_continua MODIFY COLUMN TEC_LINEA_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_continua MODIFY COLUMN TEC_LINEA_RANGO_3_PUNTOS DECIMAL(8,3) NULL;

ALTER TABLE tabulador_edu_distancia MODIFY COLUMN TUTOR_DIPLO_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN TUTOR_DIPLO_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN TUTOR_DIPLO_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN TUTOR_PROF_TEC_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN TUTOR_PROF_TEC_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN TUTOR_PROF_TEC_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN TUTOR_POSTEC_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN TUTOR_POSTEC_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN TUTOR_POSTEC_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_TUTO_FOR_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_TUTO_FOR_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_TUTO_FOR_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_CUR_FOR_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_CUR_FOR_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_CUR_FOR_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_TUTO_CUR_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_TUTO_CUR_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_TUTO_CUR_RANGO_3_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_CUR_CUR_INT_RANGO_1_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_CUR_CUR_INT_RANGO_2_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE tabulador_edu_distancia MODIFY COLUMN COOR_CUR_CUR_INT_RANGO_3_PUNTOS DECIMAL(8,3) NULL;

ALTER TABLE tabulador_ela_meterial MODIFY COLUMN TEM_PUNTOS_RANGO_1 DECIMAL(8,3) NULL;
ALTER TABLE tabulador_ela_meterial MODIFY COLUMN TEM_PUNTOS_RANGO_2 DECIMAL(8,3) NULL;

ALTER TABLE evaluacion_act_doc MODIFY COLUMN TOTAL_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_act_inv_edu MODIFY COLUMN TOTAL_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_beca MODIFY COLUMN TOTAL_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_comision MODIFY COLUMN TOTAL_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_act_docente MODIFY COLUMN EVA_CUR_PUNTOS_CURSO DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_act_docente MODIFY COLUMN EVA_CUR_PUNTOS_CURSO_ORIGINAL DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_act_inv_edu MODIFY COLUMN EVA_CUR_PUNTOS_CURSO DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_act_inv_edu MODIFY COLUMN EVA_CUR_PUNTOS_CURSO_ORIGINAL DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_comision MODIFY COLUMN EVA_CUR_PUNTOS_CURSO DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_comision MODIFY COLUMN EVA_CUR_PUNTOS_CURSO_ORIGINAL DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_edu_dis MODIFY COLUMN EVA_CUR_PUNTOS_CURSO DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_edu_dis MODIFY COLUMN EVA_CUR_PUNTOS_CURSO_ORIGINAL DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_esp_medica MODIFY COLUMN EVA_CUR_PUNTOS_CURSO DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_esp_medica MODIFY COLUMN EVA_CUR_PUNTOS_CURSO_ORIGINAL DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_for_profesional MODIFY COLUMN EVA_CUR_PUNTOS_CURSO DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_for_profesional MODIFY COLUMN EVA_CUR_PUNTOS_CURSO_ORIGINAL DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_fpcs MODIFY COLUMN EVA_CUR_PUNTOS_CURSO DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_fpcs MODIFY COLUMN EVA_CUR_PUNTOS_CURSO_ORIGINAL DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_mat_edu MODIFY COLUMN EVA_CUR_PUNTOS_CURSO DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_curso_mat_edu MODIFY COLUMN EVA_CUR_PUNTOS_CURSO_ORIGINAL DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_edu_dis MODIFY COLUMN TOTAL_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_esp_medica MODIFY COLUMN TOTAL_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_for_profesional MODIFY COLUMN TOTAL_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_fpcs MODIFY COLUMN TOTAL_PUNTOS DECIMAL(8,3) NULL;
ALTER TABLE evaluacion_mat_edu MODIFY COLUMN TOTAL_PUNTOS DECIMAL(8,3) NULL;

ALTER TABLE emp_educacion_distancia MODIFY COLUMN  EDD_CUR_PUN_ROL DECIMAL(8,3) NULL;
ALTER TABLE emp_educacion_distancia MODIFY COLUMN  EDD_CUR_PUN_ALCANCE DECIMAL(8,3) NULL;
ALTER TABLE emp_educacion_distancia MODIFY COLUMN  EDD_PUN_DURACION DECIMAL(8,3) NULL;
ALTER TABLE emp_educacion_distancia MODIFY COLUMN  EDD_CUR_PROM_EVALUACIONES DECIMAL(8,3) NULL;
ALTER TABLE emp_educacion_distancia MODIFY COLUMN  EDD_CUR_SUM_TOT_ACT DECIMAL(8,3) NULL;

ALTER TABLE cvalidacion_curso_estado MODIFY COLUMN VAl_CUR_EST_NOMBRE varchar(21) NOT NULL;
ALTER TABLE bono_can_bono_reg MODIFY COLUMN  reg_promedio DECIMAL(8,3) NULL;
ALTER TABLE bono_act_edu_dist MODIFY COLUMN  act_promedio DECIMAL(8,3) NULL;
ALTER TABLE bono_emp_can_bono MODIFY COLUMN  can_sum_act DECIMAL(8,3) NULL;
ALTER TABLE bono_emp_can_bono MODIFY COLUMN  can_tot_pro_eva DECIMAL(8,3) NULL;

-------------------2016/09/22 Responsable JESUS Y MIGUEL, EN ejecución cambios LEAS----------------------------
ALTER TABLE emp_act_inv_edu ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_actividad_docente ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_beca ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_can_bono ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_ciclos_clinicos ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_comision ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_desa_inv_salud ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_educacion_distancia ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_esp_medica ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_for_personal_continua_salud ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_formacion_profesional ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_materia_educativo ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE empleado  ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;

-------------------2016/09/22 Responsable JESUS Y MIGUEL, EN ejecución cambios LEAS----------------------------
ALTER TABLE emp_act_inv_edu ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_actividad_docente ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_beca ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_can_bono ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_ciclos_clinicos ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_comision ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_desa_inv_salud ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_educacion_distancia ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_esp_medica ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_for_personal_continua_salud ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_formacion_profesional ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE emp_materia_educativo ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE empleado  ADD IS_CARGA_SISTEMA BOOLEAN NOT NULL DEFAULT 0;

ALTER TABLE cvalidacion_curso_estado MODIFY COLUMN VAl_CUR_EST_NOMBRE varchar(21) NOT NULL;

-------------------2016/09/24 Responsable JESUS, EN ejecución cambios LEAS----------------------------
alter table crol_evaluador drop column CROL_EVALUADOR_NOMBRE;
----empleado----- 
ALTER TABLE `crol_evaluador` ADD `EMPLEADO_CVE` INT(11) NOT NULL;  /*Campo agregado a la tabla "crol_evaluador"*/
CREATE INDEX XIF110CROL_EVALUADOR ON crol_evaluador (EMPLEADO_CVE);  /* Se vuelve index el campo */
ALTER TABLE `crol_evaluador` ADD CONSTRAINT `crol_empleado_empfk_110`   /* Asigna llave foranea*/
FOREIGN KEY (`EMPLEADO_CVE`) REFERENCES `empleado`(`EMPLEADO_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;
-----crol------
ALTER TABLE `crol_evaluador` ADD `ROL_CVE` INT(11) NOT NULL;  /*Campo agregado a la tabla "crol_evaluador"*/
CREATE INDEX XIF111CROL_EVALUADOR ON crol_evaluador (ROL_CVE);  /* Se vuelve index el campo */
ALTER TABLE `crol_evaluador` ADD CONSTRAINT `crol_evaluador_empfk_111`   /* Asigna llave foranea*/
FOREIGN KEY (`ROL_CVE`) REFERENCES `crol`(`ROL_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

alter table crol_evaluador ADD fch_insert datetime not null default current_timestamp; 
alter table crol_evaluador ADD IS_ACTUAL  boolean not null default 1; 

ALTER TABLE `campos_catalogos` ADD `TIPO_COMPROBANTE_CVE` INT(11) NULL;  /*Campo agregado a la tabla "campos_catalogos"*/
CREATE INDEX XIF111CAMPOS_CATALOGOS ON campos_catalogos (TIPO_COMPROBANTE_CVE);  /* Se vuelve index el campo */
ALTER TABLE `campos_catalogos` ADD CONSTRAINT `campos_catalogos_ctcfk_111`   /* Asigna llave foranea*/
FOREIGN KEY (`TIPO_COMPROBANTE_CVE`) REFERENCES `ctipo_comprobante`(`TIPO_COMPROBANTE_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE ctipo_comprobante MODIFY COLUMN TIP_COM_NOMBRE varchar(50) NOT NULL;

-------------------2016/09/26 Responsable Jesus, Miguel, Pablo y Luis, En ejecución cambios LEAS----------------------------
ALTER TABLE `cmedio_divulgacion` ADD `is_otra` INT(1) NOT NULL DEFAULT 0;  /*Campo agregado a la tabla "cmedio_divulgacion"*/
ALTER TABLE `cmedio_divulgacion` ADD `is_reconocido` BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE `cmedio_divulgacion` ADD `tp_f_r_l` char(1) NULL;
ALTER TABLE `emp_act_inv_edu` ADD `ISBN_LIB` varchar(25) NULL;

alter table emp_act_inv_edu add is_edic_comp char(2) null;
alter table emp_act_inv_edu add num_capitulos int(2) null;
alter table emp_act_inv_edu add num_paginas int(5) null;

ALTER TABLE cparametros CHANGE PERAM_PERIODO_INCONFORMIDAD NOM_DESCRIPCION varchar(100);
ALTER TABLE cparametros CHANGE PARAM_VIGENCIA VALOR int(11);
ALTER TABLE cparametros drop PARAM_RE_EVALUACION;
ALTER TABLE evaluacion_curso_validacion CHANGE seccion_cve registro_cve int(11);

--Ejecución Jesús Días 
ALTER TABLE tabulador_dir_tesis MODIFY COLUMN TDT_NIVEL_ESTUDIOS int(11) NULL;
ALTER TABLE tabulador_ela_meterial MODIFY COLUMN TEM_RANGO_1 varchar(40) NULL;
ALTER TABLE tabulador_ela_meterial MODIFY COLUMN TEM_RANGO_2 varchar(40) NULL;


-------------------2016/09/26 Responsable JESUS, En ejecución cambios LEAS----------------------------
ALTER TABLE `evaluacion_solicitud` ADD `ADMIN_DICTAMEN_EVA_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_solicitud"*/
CREATE INDEX XIF1112EVALUACION_SOLICITUD ON evaluacion_solicitud (ADMIN_DICTAMEN_EVA_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_solicitud` ADD CONSTRAINT `evaluacion_solicitud_adefk_1112`   /* Asigna llave foranea*/
FOREIGN KEY (`ADMIN_DICTAMEN_EVA_CVE`) REFERENCES `admin_dictamen_evaluacion`(`ADMIN_DICTAMEN_EVA_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

alter table crol_evaluador rename evaluador; --Cambia nombre a la entidad 
ALTER TABLE evaluador CHANGE ROL_EVALUADOR_CVE EVALUADOR_CVE INT(11);

CREATE TABLE `hist_evaluacion_dic` (
  `HIST_EVALUACION_CVE` int(11) NOT NULL AUTO_INCREMENT,
  `TOTAL_PUNTOS` decimal(8,3) DEFAULT NULL,
  `EVA_FCH` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  `MSG_COMENTARIO` varchar(200) DEFAULT NULL,
  `SOLICITUD_VAL_CVE` int(11) DEFAULT NULL  comment 'solicitud de la evaluación cve',
  `EST_EVALUACION_CVE` int(11) DEFAULT NULL comment 'estado de la evaluación cve',
  `EVALUADOR_CVE` int(11) DEFAULT NULL comment 'Evaluador actual del estado',
  `IS_ACTUAL` BOOLEAN DEFAULT 1,
  PRIMARY KEY (`HIST_EVALUACION_CVE`),
  KEY `XIF101HIST_EVALUACION_DIC` (`SOLICITUD_VAL_CVE`),
  KEY `XIF102HIST_EVALUACION_DIC` (`EVALUADOR_CVE`),
  KEY `XIF103HIST_EVALUACION_DIC` (`EST_EVALUACION_CVE`),
  CONSTRAINT `hist_evaluacion_dic_esfk_101` FOREIGN KEY (`SOLICITUD_VAL_CVE`) REFERENCES `evaluacion_solicitud` (`VALIDACION_CVE`),
  CONSTRAINT `hist_evaluacion_efk_102` FOREIGN KEY (`EVALUADOR_CVE`) REFERENCES `evaluador` (`ROL_EVALUADOR_CVE`),
  CONSTRAINT `hist_evaluacion_ceefk_103` FOREIGN KEY (`EST_EVALUACION_CVE`) REFERENCES `cestado_evaluacion` (`EST_EVALUACION_CVE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `evaluacion_seccion` (
  `EVALUACION_SECCION_CVE` int(11) NOT NULL AUTO_INCREMENT,
  `TOTAL_PUNTOS` decimal(8,3) DEFAULT NULL,
  `sec_info_cve` int(11) NOT NULL comment 'sección a la que pertenece el curso', 
  `HIST_EVALUACION_CVE` int(11) NOT NULL  comment 'Historial de la evaluación',
  PRIMARY KEY (`EVALUACION_SECCION_CVE`),
  KEY `XIF101EVALUACION_SECCION` (`sec_info_cve`),
  KEY `XIF102EVALUACION_SECCION` (`HIST_EVALUACION_CVE`),
  CONSTRAINT `evaluacion_seccion_escfk_101` FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion` (`sec_info_cve`),
  CONSTRAINT `evaluacion_seccion_hecfk_102` FOREIGN KEY (`HIST_EVALUACION_CVE`) REFERENCES `hist_evaluacion_dic` (`HIST_EVALUACION_CVE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `evaluacion_curso_act_docente` ADD `HIST_EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_act_docente" */
CREATE INDEX XIF141EVALUACION_CURSO_ACT_DOCENTE ON evaluacion_curso_act_docente (HIST_EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_act_docente` ADD CONSTRAINT `evaluacion_curso_act_inv_edu_hecfk141`   /* Asigna llave foran */
FOREIGN KEY (`HIST_EVALUACION_CVE`) REFERENCES `hist_evaluacion_dic`(`HIST_EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_act_inv_edu` ADD `HIST_EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_act_inv_edu" */
CREATE INDEX XIF142EVALUACION_CURSO_INT_EDU ON evaluacion_curso_act_inv_edu (HIST_EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_act_inv_edu` ADD CONSTRAINT `evaluacion_curso_act_inv_edu_hecfk142`   /* Asigna llave foran */
FOREIGN KEY (`HIST_EVALUACION_CVE`) REFERENCES `hist_evaluacion_dic`(`HIST_EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_comision` ADD `HIST_EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_comision" */
CREATE INDEX XIF143EVALUACION_CURSO_COMISION ON evaluacion_curso_comision (HIST_EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_comision` ADD CONSTRAINT `evaluacion_curso_comision_hecfk143`   /* Asigna llave foran */
FOREIGN KEY (`HIST_EVALUACION_CVE`) REFERENCES `hist_evaluacion_dic`(`HIST_EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_edu_dis` ADD `HIST_EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_edu_dis" */
CREATE INDEX XIF144EVALUACION_CURSO_EDU_DIS ON evaluacion_curso_edu_dis (HIST_EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_edu_dis` ADD CONSTRAINT `evaluacion_curso_edu_dis_hecfk144`   /* Asigna llave foran */
FOREIGN KEY (`HIST_EVALUACION_CVE`) REFERENCES `hist_evaluacion_dic`(`HIST_EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `evaluacion_curso_fpcs` ADD `HIST_EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_fpcs" */
CREATE INDEX XIF145EVALUACION_CURSO_FPCS ON evaluacion_curso_fpcs (HIST_EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_fpcs` ADD CONSTRAINT `evaluacion_curso_edu_dis_hecfk145`   /* Asigna llave foran */
FOREIGN KEY (`HIST_EVALUACION_CVE`) REFERENCES `hist_evaluacion_dic`(`HIST_EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_mat_edu` ADD `HIST_EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_mat_edu" */
CREATE INDEX XIF146EVALUACION_CURSO_MAT_EDU ON evaluacion_curso_mat_edu (HIST_EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_mat_edu` ADD CONSTRAINT `evaluacion_curso_edu_dis_hecfk146`   /* Asigna llave foran */
FOREIGN KEY (`HIST_EVALUACION_CVE`) REFERENCES `hist_evaluacion_dic`(`HIST_EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_for_profesional` ADD `HIST_EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_for_profesional" */
CREATE INDEX XIF147EVALUACION_CURSO_FOR_PROFESIONAL ON evaluacion_curso_for_profesional (HIST_EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_for_profesional` ADD CONSTRAINT `evaluacion_curso_edu_dis_hecfk147`   /* Asigna llave foran */
FOREIGN KEY (`HIST_EVALUACION_CVE`) REFERENCES `hist_evaluacion_dic`(`HIST_EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `evaluacion_curso_esp_medica` ADD `HIST_EVALUACION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_esp_medica" */
CREATE INDEX XIF148EVALUACION_CURSO_ESP_MEDICA ON evaluacion_curso_esp_medica (HIST_EVALUACION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_esp_medica` ADD CONSTRAINT `evaluacion_curso_edu_dis_hecfk148`   /* Asigna llave foran */
FOREIGN KEY (`HIST_EVALUACION_CVE`) REFERENCES `hist_evaluacion_dic`(`HIST_EVALUACION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE evaluacion_curso_act_docente DROP FOREIGN KEY  evaluacion_curso_act_docente_eadfk;
ALTER TABLE evaluacion_curso_act_inv_edu  DROP FOREIGN KEY  evaluacion_curso_act_inv_edu_eaiefk;
ALTER TABLE evaluacion_curso_comision  DROP FOREIGN KEY  evaluacion_curso_comision_eaiefk;
ALTER TABLE evaluacion_curso_edu_dis  DROP FOREIGN KEY  evaluacion_curso_edu_dis_eedfk;
ALTER TABLE evaluacion_curso_fpcs DROP FOREIGN KEY  evaluacion_curso_fpcs_efpcsfk;
ALTER TABLE evaluacion_curso_mat_edu DROP FOREIGN KEY  evaluacion_curso_mat_edu_emefk;
ALTER TABLE evaluacion_curso_for_profesional DROP FOREIGN KEY  evaluacion_curso_for_profesional_efpfk;
ALTER TABLE evaluacion_curso_esp_medica DROP FOREIGN KEY  evaluacion_curso_esp_medica_eemfk;

DROP TABLE IF EXISTS `evaluacion_act_doc`;
DROP TABLE IF EXISTS `evaluacion_act_inv_edu`;
DROP TABLE IF EXISTS `evaluacion_comision`;
DROP TABLE IF EXISTS `evaluacion_edu_dis`;
DROP TABLE IF EXISTS `evaluacion_fpcs`;
DROP TABLE IF EXISTS `evaluacion_mat_edu`;
DROP TABLE IF EXISTS `evaluacion_for_profesional`;
DROP TABLE IF EXISTS `evaluacion_esp_medica`;
DROP TABLE IF EXISTS `evaluacion_beca`;

-------------------2016/09/28 Responsable LEAS, En ejecución cambios LEAS----------------------------
ALTER TABLE `cseccion_informacion` ADD `PADRE_SEC_INF_CVE` INT(11) NULL;  /*Campo agregado a la tabla "cseccion_informacion" */
CREATE INDEX XIF148CSECCION_INFORMACION ON cseccion_informacion (PADRE_SEC_INF_CVE);  /* Se vuelve index el campo */
ALTER TABLE `cseccion_informacion` ADD CONSTRAINT `cseccion_informacion_csifk148`   /* Asigna llave foran */
FOREIGN KEY (`PADRE_SEC_INF_CVE`) REFERENCES `cseccion_informacion`(`sec_info_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE cseccion_informacion  DROP FOREIGN KEY  cseccion_informacion_csifk148;
alter table cseccion_informacion drop column PADRE_SEC_INF_CVE;

-------------------2016/09/29 Responsable Jesus, En ejecución Miguel y Jesus----------------------------
--jesus
ALTER TABLE cseccion MODIFY COLUMN SECCION_DES varchar(120) NULL;

--Miguel 
CREATE TABLE evaluacion_bloque_seccion(
ebs_cve char(3) not null,
ebs_nombre varchar(50) not null,
constraint pk_ebs
primary key(ebs_cve)
);

ALTER TABLE evaluacion_curso_validacion ADD 
column ebs_cve char(3) null;

ALTER TABLE evaluacion_curso_validacion ADD 
constraint fk_ebs_ecv
foreign key(ebs_cve)
references evaluacion_bloque_seccion(ebs_cve);

ALTER TABLE evaluacion_bloques_val drop ebs_cve;
ALTER TABLE `evaluacion_bloques_val` ADD `ebs_cve` char(3) NOT NULL;
ALTER TABLE evaluacion_bloques_val ADD 
constraint ebv_ebsfk1
foreign key(ebs_cve)
references evaluacion_bloque_seccion(ebs_cve);
--Agrega tipo de curso 
ALTER TABLE `campos_catalogos` ADD `TIP_CURSO_CVE` INT(11) NULL;  /*Campo agregado a la tabla "campos_catalogos"*/
CREATE INDEX XIF112CAMPOS_CATALOGOS ON campos_catalogos (TIP_CURSO_CVE);  /* Se vuelve index el campo */
ALTER TABLE `campos_catalogos` ADD CONSTRAINT `campos_catalogos_ctcurfk_112`   /* Asigna llave foranea*/
FOREIGN KEY (`TIP_CURSO_CVE`) REFERENCES `ctipo_curso`(`TIP_CURSO_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE evaluacion_curso_validacion DROP FOREIGN KEY  fk_ebs_ecv;

--------------------2016/10/04 Ejecución Luis Ramá del conocimiento ---------------------
CREATE TABLE `crama_conocimiento` (
  `RAMA_CONOC_CVE` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_RAMA_CONOC` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`RAMA_CONOC_CVE`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
 drop table crama_conocimiento; -- se elimino despúes  

 
ALTER TABLE `sse_reglas_evaluacion` ADD `tipo_encuesta` INT(2) NULL; 

--------------------2016/10/06  Responsable Jésus Días Ejecución LEAS---------------------
ALTER TABLE `evaluacion_curso_act_docente` ADD `SECCION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_act_docente" */
CREATE INDEX XIF161EVALUACION_CURSO_ACT_DOCENTE ON evaluacion_curso_act_docente (SECCION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_act_docente` ADD CONSTRAINT `evaluacion_curso_act_inv_edu_csecfk161`   /* Asigna llave foran */
FOREIGN KEY (`SECCION_CVE`) REFERENCES `cseccion`(`SECCION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_act_inv_edu` ADD `SECCION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_act_inv_edu" */
CREATE INDEX XIF162EVALUACION_CURSO_INT_EDU ON evaluacion_curso_act_inv_edu (SECCION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_act_inv_edu` ADD CONSTRAINT `evaluacion_curso_act_inv_edu_csecfk162`   /* Asigna llave foran */
FOREIGN KEY (`SECCION_CVE`) REFERENCES `cseccion`(`SECCION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_comision` ADD `SECCION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_comision" */
CREATE INDEX XIF163EVALUACION_CURSO_COMISION ON evaluacion_curso_comision (SECCION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_comision` ADD CONSTRAINT `evaluacion_curso_comision_csecfk163`   /* Asigna llave foran */
FOREIGN KEY (`SECCION_CVE`) REFERENCES `cseccion`(`SECCION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_edu_dis` ADD `SECCION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_edu_dis" */
CREATE INDEX XIF164EVALUACION_CURSO_EDU_DIS ON evaluacion_curso_edu_dis (SECCION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_edu_dis` ADD CONSTRAINT `evaluacion_curso_edu_dis_csecfk164`   /* Asigna llave foran */
FOREIGN KEY (`SECCION_CVE`) REFERENCES `cseccion`(`SECCION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `evaluacion_curso_fpcs` ADD `SECCION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_fpcs" */
CREATE INDEX XIF165EVALUACION_CURSO_FPCS ON evaluacion_curso_fpcs (SECCION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_fpcs` ADD CONSTRAINT `evaluacion_curso_edu_dis_csecfk165`   /* Asigna llave foran */
FOREIGN KEY (`SECCION_CVE`) REFERENCES `cseccion`(`SECCION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_mat_edu` ADD `SECCION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_mat_edu" */
CREATE INDEX XIF166EVALUACION_CURSO_MAT_EDU ON evaluacion_curso_mat_edu (SECCION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_mat_edu` ADD CONSTRAINT `evaluacion_curso_edu_dis_csecfk166`   /* Asigna llave foran */
FOREIGN KEY (`SECCION_CVE`) REFERENCES `cseccion`(`SECCION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `evaluacion_curso_for_profesional` ADD `SECCION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_for_profesional" */
CREATE INDEX XIF167EVALUACION_CURSO_FOR_PROFESIONAL ON evaluacion_curso_for_profesional (SECCION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_for_profesional` ADD CONSTRAINT `evaluacion_curso_edu_dis_csecfk167`   /* Asigna llave foran */
FOREIGN KEY (`SECCION_CVE`) REFERENCES `cseccion`(`SECCION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `evaluacion_curso_esp_medica` ADD `SECCION_CVE` INT(11) NULL;  /*Campo agregado a la tabla "evaluacion_curso_esp_medica" */
CREATE INDEX XIF168EVALUACION_CURSO_ESP_MEDICA ON evaluacion_curso_esp_medica (SECCION_CVE);  /* Se vuelve index el campo */
ALTER TABLE `evaluacion_curso_esp_medica` ADD CONSTRAINT `evaluacion_curso_edu_dis_csecfk168`   /* Asigna llave foran */
FOREIGN KEY (`SECCION_CVE`) REFERENCES `cseccion`(`SECCION_CVE`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-----------
ALTER TABLE evaluador MODIFY COLUMN ROL_EVALUADOR_CVE EVALUADOR_CVE int(11) NOT NULL;

ALTER TABLE evaluacion_curso_act_docente CHANGE COLUMN ROL_EVALUADOR_CVE  EVALUADOR_CVE INT(10) NOT NULL;
ALTER TABLE evaluacion_curso_act_inv_edu CHANGE COLUMN ROL_EVALUADOR_CVE  EVALUADOR_CVE INT(10) NOT NULL;
ALTER TABLE evaluacion_curso_comision CHANGE COLUMN ROL_EVALUADOR_CVE  EVALUADOR_CVE INT(10) NOT NULL;
ALTER TABLE evaluacion_curso_edu_dis CHANGE COLUMN ROL_EVALUADOR_CVE  EVALUADOR_CVE INT(10) NOT NULL;
ALTER TABLE evaluacion_curso_fpcs CHANGE COLUMN ROL_EVALUADOR_CVE  EVALUADOR_CVE INT(10) NOT NULL;
ALTER TABLE evaluacion_curso_mat_edu CHANGE COLUMN ROL_EVALUADOR_CVE  EVALUADOR_CVE INT(10) NOT NULL;
ALTER TABLE evaluacion_curso_for_profesional CHANGE COLUMN ROL_EVALUADOR_CVE  EVALUADOR_CVE INT(10) NOT NULL;
ALTER TABLE evaluacion_curso_esp_medica CHANGE COLUMN ROL_EVALUADOR_CVE  EVALUADOR_CVE INT(10) NOT NULL;

ALTER TABLE evaluador ADD PRIMARY KEY ROL_EVALUADOR_CVE;
ALTER TABLE evaluador ADD PRIMARY KEY (ROL_EVALUADOR_CVE);

ALTER TABLE sipimss_20161005.evaluacion_bloques_val MODIFY COLUMN sec_info_cve int(11) NULL;


-------------------------bd 14/10/2016 ejecución LEAS ----------------------------------------
create table cregiones(  
regiones_cve char(4),
nom_region varchar(40),
primary key (regiones_cve)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `validador` ADD `regiones_cve` char(4) NULL;  /*Campo agregado a la tabla "validador" */
CREATE INDEX XIF12VALIDADOR ON validador (regiones_cve);  /* Se vuelve index el campo */
ALTER TABLE `validador` ADD CONSTRAINT `validador_CRfk12`   /* Asigna llave foran */
FOREIGN KEY (`regiones_cve`) REFERENCES `cregiones`(`regiones_cve`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE cdelegacion DROP FOREIGN KEY  cdelegacion_CRfk12;

create table validacion_parametros_muestra(
val_par_muestra int(11) AUTO_INCREMENT,
is_actual boolean null,
porsentaje_muestra decimal(5,2) default null,
val_esperados_minimos int(5) null,
departamento_cve char(10) NULL, 
delegacion_cve char(2) default null,
regiones_cve char(4),
PRIMARY KEY (`val_par_muestra`),
KEY `XIF11VALIDACION_PARAMETROS_MUESTRA` (`departamento_cve`),
KEY `XIF12VALIDACION_PARAMETROS_MUESTRA` (`delegacion_cve`),
KEY `XIF13VALIDACION_PARAMETROS_MUESTRA` (`regiones_cve`),
CONSTRAINT `validacion_parametros_muestra_dpcfk_11` FOREIGN KEY (`departamento_cve`) REFERENCES `cdepartamento` (`departamento_cve`),
CONSTRAINT `validacion_parametros_muestra_dlcfk_12` FOREIGN KEY (`delegacion_cve`) REFERENCES `cdelegacion` (`DELEGACION_CVE`),
CONSTRAINT `validacion_parametros_muestra_rgcfk_13` FOREIGN KEY (`regiones_cve`) REFERENCES `cregiones` (`regiones_cve`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table validacion_parametros_muestra_seccion(
sec_info_cve int(11),
val_par_muestra int(11),
primary key(sec_info_cve, val_par_muestra),
FOREIGN KEY (`sec_info_cve`) REFERENCES `cseccion_informacion` (`sec_info_cve`),
FOREIGN KEY (`val_par_muestra`) REFERENCES `validacion_parametros_muestra` (`val_par_muestra`)
);

-------------------------bd 28/10/2016 ejecución LEAS ----------------------------------------
ALTER TABLE hist_beca_validacion_curso  ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;
ALTER TABLE hist_comision_validacion_curso ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;
ALTER TABLE hist_eaid_validacion_curso ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;
ALTER TABLE hist_ecc_validacion_curso ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;
ALTER TABLE hist_edd_validacion_curso ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;
ALTER TABLE hist_edis_validacion_curso ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;
ALTER TABLE hist_eem_validacion_curso ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;
ALTER TABLE hist_efp_validacion_curso ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;
ALTER TABLE hist_efpd_validacion_curso ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;
ALTER TABLE hist_fpcs_validacion_curso ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;
ALTER TABLE hist_me_validacion_curso ADD VAL_CUR_FCH_ACTUALIZA TIMESTAMP default current_timestamp on UPDATE current_timestamp;

-------------------------bd 08/11/2016 ejecución LEAS ----------------------------------------
ALTER TABLE validacion_convocatoria_delegacion ADD regiones_cve char(4) default 'd';  --Campo agregado a la tabla 
alter table validacion_convocatoria_delegacion add primary key (regiones_cve);

CREATE TABLE validacion_convocatoria_delegacion_region(
val_conv_del_reg_cve int(11) AUTO_INCREMENT,
VAL_CON_CVE int(11) NOT NULL,
DELEGACION_CVE char(2) null,
regiones_cve char(4) null,
primary key(val_conv_del_reg_cve),
KEY XIF12VALIDACION_CONVOCATORIA_DELEGACION_REGION (VAL_CON_CVE),
CONSTRAINT validacion_convocatoria_delegacion_region_vcfk_10 FOREIGN KEY (VAL_CON_CVE) REFERENCES validacion_convocatoria(VAL_CON_CVE),
CONSTRAINT validacion_convocatoria_delegacion_region_cdfk_11 FOREIGN KEY (DELEGACION_CVE) REFERENCES cdelegacion (DELEGACION_CVE),
CONSTRAINT validacion_convocatoria_delegacion_region_crfk_12 FOREIGN KEY (regiones_cve) REFERENCES cregiones (regiones_cve)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


--- modificar longitud 08/12/2016
ALTER TABLE sipimss_demo_20161020.cmodulo MODIFY COLUMN MODULO_NOMBRE varchar(50) NOT NULL;
ALTER TABLE sipimss_demo_20161103.comision_area MODIFY COLUMN COM_ARE_NOMBRE varchar(50) NOT NULL;