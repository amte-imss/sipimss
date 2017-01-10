<?php

abstract class MyEnum3 {

    final public function __construct($value = null) {
        $c = new ReflectionClass($this);
        if (!in_array($value, $c->getConstants())) {
            throw IllegalArgumentException();
        }
        $this->value = $value;
    }

    final public function buscar($value = null) {
        $text = $this->getTextoEnum($value);
        $this->texto = $text;
    }

    final public function __toString() {
        return $this->value;
    }

    function getTextoEnum($value = null) {
        return "";
    }

}

class Enum_ecg extends MyEnum3 {

    const
            __default = '',
            cmodalidad = 'cmodalidad',
            licenciatura = 'licenciatura',
            cmodulo = 'cmodulo',
            carea = 'carea',
            cmateria = 'cmateria',
            ccurso = 'ccurso',
            cinstitucion_avala = 'cinstitucion_avala',
            ctipo_actividad_docente = 'ctipo_actividad_docente',
            crol_desempenia = 'crol_desempenia',
            ctipo_comprobante = 'ctipo_comprobante',
            ctipo_licenciatura ='ctipo_licenciatura',
            ctipo_curso = 'ctipo_curso',
            ctipo_especialidad = 'ctipo_especialidad',
            ctipo_formacion_profesional = 'ctipo_formacion_profesional',
            ctipo_participacion = 'ctipo_participacion',
            ctipo_material = 'ctipo_material',
            csubtipo_formacion_profesional = 'csubtipo_formacion_profesional',
            cestado_civil = 'cestado_civil',
            cejercicio_predominante = 'cejercicio_predominante',
            cejercicio_profesional = 'cejercicio_profesional',
            cmedio_divulgacion = 'cmedio_divulgacion',
            ctipo_estudio = 'ctipo_estudio',
            cdelegacion = 'cdelegacion',
            ccategoria = 'ccategoria',
            cdepartamento = 'cdepartamento',
            crol = 'crol',
            cestado_usuario = 'cestado_usuario',
            modulo = 'modulo',
            cunidad = 'cunidad',
            cestado_validacion = 'cestado_validacion',
            comision_area = 'comision_area',
            cnivel_academico = 'cnivel_academico',
            ctipo_comision = 'ctipo_comision' ,
            cmotivo_becado = 'cmotivo_becado' ,
            cbeca_interrumpida = 'cbeca_interrumpida', 
            cclase_beca = 'cclase_beca',
            csubtipo_formacion_salud = 'csubtipo_formacion_salud',
            ctipo_formacion_salud = 'ctipo_formacion_salud',
            ctematica = 'ctematica',
            cvalidacion_estado = 'cvalidacion_estado',
            cvalidacion_curso_estado = 'cvalidacion_curso_estado',
            cestado_evaluacion = 'cestado_evaluacion',
            cseccion = 'cseccion'
    ;
    /*
      guardar actuación (evaluaciones)
      corregir

     */

    function getTextoEnum($value = null) {
        switch ($value) {
            case 'CLUBS':
                return 'Genial de clubes';
                break;
        }
    }

}
