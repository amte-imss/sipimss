<?php

class Enum_etapa_cov {

    const
            __default = 0,
            /**
             * Etapa de registro de información del censo por el docente 
             */
            CENSO_REGISTRO = 'act',
            /**
             * Etapa de validación para nivel 1, aplica para la intersección del 
             * muestreo de docentes con nivel 2 (tiempo de validación n1)
             */
            CENSO_VALIDA_N1 = 'vf1',
            /**
             * Etapa de validación para nivel 2, aplica para la intersección del 
             * muestreo de docentes con nivel 1 (tiempo de validación n2)
             */
            CENSO_VALIDA_N2 = 'vf2',
            /**
             * Aún no inicia la convocatoria para registrar docentes (según la regla 
             * de negocio actual, puede el docente registrar o actualizar curso)
             */
            CEN_SIN_INICIAR_CONVOCATORIA = 'sin',
            /**
             * El tiempo de la convocatoria a terminado (los 3  niveles de tiempo para terminaron)
             *  registrar, validar n1 y validar n2 (según la regla 
             * de negocio actual, puede el docente registrar o actualizar curso)
             */
            CEN_CADUCO_CONVOCATORIA = 'nap',
            /**
             * No existe una convocatoria actualmente (según la regla 
             * de negocio actual, puede el docente registrar o actualizar curso)
             */
            CEN_NO_EXISTE_CONVOCATORIA = 'nec'

    ;
}
