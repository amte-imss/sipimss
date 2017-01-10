<?php

abstract class MyEnum2 {

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
        return "algo";
    }

}

class Enum_estados_empleado extends MyEnum2 {

    const
            __default = 0,
            NO_APROBADO = 1,
            CATEGORIA = 2,
            ACTIVIDAD = 3,
            ACTUACION = 4,
            INCIDENCIA = 5,
            VALIDADO_JA = 6,
            CORRECCION_TARJETON = 7,
            CORRECCION_ENCUESTA = 8,
            VALIDADO_TITULAR = 9,
            REVISION = 10

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
