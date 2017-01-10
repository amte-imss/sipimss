<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//pr($historial_estados);
?>

<style type="text/css">
    .button-padding {padding-top: 30px}
    .rojo {color: #a94442}.panel-body table{color: #000} .pinfo{padding-left:20px; padding-bottom: 20px;}
</style>


<!-- Inicio informacion personal -->
<?php echo form_open('', array('id' => 'form_validar_docente')); ?>

<div class="list-group">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#id_div_comentarios_estado" aria-expanded="true"><?php echo $string_values['btn_text_collapse_mensajes']; ?></button>
            <div id="id_div_comentarios_estado" class="collapse" aria-expanded="true">
                <?php
                if (!empty($historial_estados)) {
                    $estados_censo = $this->config->item('estados_val_censo');
                    $array_colores = $this->config->item('cvalidacion_curso_estado');
                    foreach ($historial_estados as $value) {
                        if (intval($value['is_comentario']) === 1) {
                            $estado = $estados_censo[$value['estado_validacion']];
                            $color = $array_colores[$estado['color_status']]['color']; //Obtiene los array de color del estado
                            ?>
                            <div class="alert alert-<?php echo $color; ?>">
                                <span><?php echo $string_values['titulo_estado_validacion'] . $value['nom_estado_validacion']; ?></span><br>
                                <span><?php echo $string_values['titulo_validador'] . $value['nom_validador']; ?></span><br>
                                <span><?php echo $string_values['lbl_comentario'] . $value['comentario_estado']; ?></span>
                            </div>

                            <?php
                        }
                    }
                    ?>

                <?php } else { ?>
                    <span class="alert-info"><?php echo $string_values['msj_sin_comntarios_estado']; ?></span>
                <?php } ?>
            </div>

        </div>
    </div>
    <br>
    <?php if (isset($pie_pag) AND !empty($pie_pag)) { ?>
        <div class="row">
            <div class="col-md-12">
                <label for='lbl_jus_validacion' class="control-label">
                    <?php echo $string_values['lbl_jus_validacion']; ?>
                </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-comment"> </span>
                    </span>
                    <?php
                    echo $this->form_complete->create_element(array('id' => 'comentario_justificacion',
                        'type' => 'textarea',
                        'value' => (isset($comentario_justificacion)) ? $comentario_justificacion : '',
                        'attributes' => array(
                            'class' => 'form-control',
                            'placeholder' => $string_values['lbl_comentario'],
                            'maxlength' => '4000',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => $string_values['lbl_comentario'])));
                    ?>
                </div>
                <?php echo form_error_format('comentario_justificacion'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $pie_pag; ?>
            </div>
        </div>
    <?php } ?>

</div>
<?php echo form_close(); ?>
  
