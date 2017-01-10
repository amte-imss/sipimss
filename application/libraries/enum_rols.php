<?php

abstract class MyEnumRols {

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

class Enum_rols extends MyEnumRols {

    const
            __default = 0,
            Docente = 1,
            Validador_N1 = 2,
            Validador_N2 = 3,
            Administrador = 4,
            Super_Administrador = 5,
            Presidente = 6,
            Secretario = 7,
            Vocal = 8,
            Coordinador = 9,
            Jefe_de_area_bono = 10,
            Titular = 11,
            Mesa_de_ayuda = 12,
            Jefe_de_rea_eva = 13,
            Profesionalizacion = 14

    ;
    /*
      guardar actuación (evaluaciones)
      corregir

     */
}
