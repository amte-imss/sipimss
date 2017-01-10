<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($informacion_becas)) {
    extract($informacion_becas, EXTR_OVERWRITE); //EXTR_IF_EXISTS; EXTR_PREFIX_ALL; EXTR_OVERWRITE; EXTR_PREFIX_INVALID
} ?>
<script type='text/javascript'>
    $(function () {
    });
</script>
<div class="list-group">
    <div class='row'>
        <div class='col-sm-12 text-center'>
            <label for='lbl_beca_clase' class="control-label">
                <?php echo $string_values['lbl_beca_periodo']; ?>:
            </label>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-6' id="fecha_inicio">
            <div class="input-group text-center">
                <label class="registro"><?php echo nice_date($dir_tes['fecha_inicio'], 'd-m-Y'); ?></label>
            </div>
        </div>
        <div class='col-sm-6 ' id="fecha_fin">
            <div class='input-group text-center'>
                <label class="registro"><?php echo nice_date($dir_tes['fecha_fin'], 'd-m-Y'); ?></label>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-6 text-center">
            <label for='lbl_beca_clase' class="control-label">
                <?php echo $string_values['lbl_beca_clase']; ?>:
            </label>
            <div class="input-group">
                <label class="registro"><?php echo $dir_tes['nom_beca']; ?></label>
            </div>
        </div>
        <div class="col-md-6 text-center">
            <label for='lbl_beca_motivo' class="control-label">
                <?php echo $string_values['lbl_beca_motivo']; ?>:
            </label>
            <div class="input-group">
                <label class="registro"><?php echo $dir_tes['nom_motivo_beca']; ?></label>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-6 text-center">
            <label for='lbl_beca_interrumpida' class="control-label">
                <?php echo $string_values['lbl_beca_interrumpida']; ?>:
            </label>
            <div class="input-group">
                <label class="registro"><?php echo $dir_tes['msj_beca_interrumpida']; ?></label>
            </div>
        </div>
    </div>
    <?php echo $formulario_carga_archivo; ?>
    <?php echo $formulario_validacion; ?>
</div>