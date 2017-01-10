<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (empty($comentarios)) {//No existen comentarios
    ?>
    <div class="list-group">
        <div class="row">
            <?php echo $string_values['no_comment']; ?>
        </div>
    </div>
<?php } else {
    ?>
    <div class="list-group">
        <div class="row">
            <?php
//            $estados_censo = $this->config->item('estados_val_evaluacion');
            $this->load->helper('fecha');
            foreach ($comentarios as $value) {
                if (intval($value['is_comentario']) === 1) {
//                    $estado = $estados_censo[$value['estado_validacion']];
//                    $color = $estados_val[$value['estado_validacion']]['color']; //Obtiene los array de color del estado
                    ?>
                    <!--<div class="alert alert-<?php // echo $color; ?>">-->
                    <div class="alert alert-info">
                        <span><?php echo $string_values['titulo_fecha_validacion'] . get_fecha_local($value['fecha_validacion']); ?></span><br>
                        <span><?php echo $string_values['titulo_estado_validacion'] . $value['nom_estado_val']; ?></span><br>
                        <?php if (!empty($value['existe_validador'])) { ?>
                            <span><?php echo $string_values['titulo_validador'] . $value['nom_validador']; ?></span><br>
                        <?php }else{ ?>
                            <span><?php echo $string_values['titulo_docente'] . $value['nom_validador']; ?></span><br>
                        <?php } ?>
                        <span><?php echo $string_values['lbl_comentario'] . ': ' . $value['comentartio_estado']; ?></span>
                    </div>

                <?php } ?>
            <?php } ?>
        </div>
    </div>
<?php } ?>

