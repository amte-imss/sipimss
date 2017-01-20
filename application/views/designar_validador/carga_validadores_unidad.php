<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!isset($lista_candidaros)) {
    $lista_candidaros = array('Raúl', 'José', 'Arturo', 'Francisco', 'Otro');
}
//    pr($paterno);
//    pr($materno);
//    pr($matricula);
?>
<?php echo form_open('', array('id' => 'form_carga_validadores')); ?>
<div class="list-group-item">
    <div class="row">
        <div class="col-lg-12 col-sm-12 text-center">
            <div class="panel-body input-group">
                <span class="input-group-addon"><?php echo $string_values['lbl_validador']; ?></span>
                <?php
                echo $this->form_complete->create_element(array('id' => 'candidato_a_validador',
                    'type' => 'dropdown',
                    'options' => $lista_candidaros,
                    'first' => array('-1' => $string_values['drop_selecciona_validador'],
                        '0' => $string_values['opt_otro_validador']),
                    'value' => (isset($candidatos)) ? $candidatos : '',
                    'class' => 'form-control',
                    'attributes' => array('class' => 'form-control',
                        'aria-describedby' => "help-tipo-comprobante",
                        'placeholder' => $string_values['lbl_validador'],
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'data-tipoevento' => "opciones",
//                        'data-idvalidador' => $reg_id_validador,
                        'data-delcve' => $reg_delegacion_cve,
                        'data-depcve' => $reg_departamento_desc,
                        'data-idrow' => $reg_idrow,
                        'onchange' => "funcion_carga_validador(this)",
                )));
                ?>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<div id = "div_buscador_sied" class="list-group-item" >

</div>
<!--<div id = "div_resultados_validadores" class="list-group-item" >

</div>-->
