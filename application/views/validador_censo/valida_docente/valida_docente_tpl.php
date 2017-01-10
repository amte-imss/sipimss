<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//pr($historial_estados);
 $tipo_mensaje = (isset($tipo_mensaje))? $tipo_mensaje : 'info';
?>

<style type="text/css">
    .button-padding {padding-top: 30px}
    .rojo {color: #a94442}.panel-body table{color: #000} .pinfo{padding-left:20px; padding-bottom: 20px;}
</style>

<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/validacion_censo_profesores/validador_docente.js"></script>

<!-- Inicio informacion personal -->
<?php echo form_open('', array('id' => 'form_validar_docente')); ?>

<?php ?>

<div class="list-group">
    <div class="row">
        <div class="col-sm-6">
            <strong><?php echo $string_values["li_matricula"] ?></strong>
            <?php echo $matricula; ?><br />
        </div>
        <div class="col-sm-6">
            <strong><?php echo $string_values["titulo_docente"] ?></strong>
            <?php echo $nom_docente; ?>
        </div>
    </div>
    <br/>
    <?php if (isset($mensaje_general)) { ?>
        <div class="row">
            <div class="alert alert-<?php echo $tipo_mensaje;?> col-md-12 icon-pos-right">
                <span><?php echo $mensaje_general; ?></span><br>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-tumblr" data-toggle="collapse" data-target="#id_div_comentarios_estado" aria-expanded="true"><?php echo $string_values['btn_text_collapse_mensajes']; ?></button>
            <div id="id_div_comentarios_estado" class="collapse" aria-expanded="true">
                <?php
                if (!empty($historial_estados)) {
                    $estados_censo = $this->config->item('estados_val_censo');
                    $array_colores = $this->config->item('cvalidacion_curso_estado');
                    $this->load->helper('fecha');
                    foreach ($historial_estados as $value) {
                        if (intval($value['is_comentario']) === 1) {
                            $estado = $estados_censo[$value['estado_validacion']];
                            $color = $array_colores[$estado['color_status']]['color']; //Obtiene los array de color del estado
                            ?>
                            <div class="alert alert-<?php echo $color; ?>">
                                <strong><?php echo $string_values['titulo_fecha_validacion'] ?></strong><?php echo get_fecha_local($value['fecha_validacion']); ?><br>
                                <strong><?php echo $string_values['titulo_estado_validacion'] ?></strong><?php echo $value['nom_estado_validacion']; ?><br>
                                <strong><?php echo $string_values['titulo_validador'] ?></strong><?php echo $value['nom_validador']; ?><br>
                                <strong><?php echo $string_values['lbl_comentario'] ?></strong><?php echo $value['comentario_estado']; ?><br>
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
    <?php if (isset($pie_pag)) { ?>
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
  