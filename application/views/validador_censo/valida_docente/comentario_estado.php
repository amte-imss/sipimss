<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$label_just = $string_values['lbl_jus_comentario'] . ((isset($tipo_transicion)) ? $tipo_transicion : '');
//pr($historial_estados);
//pr($nom_docente);
//pr($validaciones_grales);
$estados_censo = $this->config->item('estados_val_censo');
$array_colores = $this->config->item('cvalidacion_curso_estado');
$this->load->helper('fecha');
?>

<div class="panel-group" id="accordion">
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
    <?php if (!empty($validaciones_grales)) { ?>
        <br />
        <div class="row">
            <?php foreach ($validaciones_grales as $key => $value) { ?>
                <div class="col-sm-6">
                    <strong><?php echo $string_values["titulo_fecha_validacion"] ?></strong>
                    <?php echo get_fecha_local($value['fecha_validacion']); ?><br />
                    <strong><?php echo $string_values["titulo_estado_validacion"] ?></strong>
                    <?php echo $value['nom_estado_val']; ?><br />
                    <strong><?php echo $string_values["t_h_rol"] ?></strong>
                    <?php echo (!empty($value['rol_valido'])) ? $value['rol_valido'] : '--'; ?><br />
                    <strong><?php echo $string_values["titulo_validador"] ?></strong>
                    <?php echo (!empty($value['nom_validador'])) ? $value['nom_validador'] : '--'; ?><br />

                    <?php if ($value['is_comentario'] == 1) { ?>
                        <button type="button" class="btn btn-github" data-toggle="collapse" data-target="#id_ver_comentario<?php echo $key; ?>" aria-expanded="true"><?php echo $string_values['btn_text_collapse_mensajes']; ?></button>
                        <div id="id_ver_comentario<?php echo $key; ?>" class="collapse" aria-expanded="true">
                            <?php
                            $estado = $estados_censo[$value['estado_validacion']];
                            $color = $array_colores[$estado['color_status']]['color']; //Obtiene los array de color del estado
                            ?>
                            <div class="alert alert-<?php echo $color; ?>">
                                <span><?php echo $string_values['lbl_comentario'] . $value['comentario_estado']; ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<br />
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#id_div_detalles_estado" aria-expanded="true"><?php echo $string_values['btn_text_collapse_mensajes']; ?></button>
        <div id="id_div_detalles_estado" class="collapse" aria-expanded="true">
            <?php
            if (!empty($historial_estados)) {
                foreach ($historial_estados as $value) {
                    if (intval($value['is_comentario']) === 1) {
                        $estado = $estados_censo[$value['estado_validacion']];
                        $color = $array_colores[$estado['color_status']]['color']; //Obtiene los array de color del estado
                        ?>
                        <div class="alert alert-<?php echo $color; ?>">
                            <strong><?php echo $string_values['titulo_fecha_validacion']?></strong><?php echo get_fecha_local($value['fecha_validacion']); ?><br>
                            <strong><?php echo $string_values['titulo_estado_validacion']?></strong><?php echo $value['nom_estado_validacion']; ?><br>
                            <strong><?php echo $string_values['titulo_validador']?></strong><?php echo $value['nom_validador']; ?><br>
                            <strong><?php echo $string_values['lbl_comentario']?></strong><?php echo $value['comentario_estado']; ?><br>
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
</div>

