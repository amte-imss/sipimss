<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($informacion_comisiones)) {
    extract($informacion_comisiones, EXTR_OVERWRITE); //EXTR_IF_EXISTS; EXTR_PREFIX_ALL; EXTR_OVERWRITE; EXTR_PREFIX_INVALID
}
?>
<script type="text/javascript">
$(function() {
    $('#modal_censo').on('hide.bs.modal', function (e) {
        cargar_datos_menu_perfil('seccion_becas_comisiones');
        recargar_fecha_ultima_actualizacion();        
        setTimeout(function(){
            $('#tabList a:last').tab('show');
        }, 1000);
        $(this).off(e);
    });
});
</script>
<div class="list-group">
    <div class='row'>
        <div class="col-md-12 text-center">
            <label for='lbl_tipo_comision' class="control-label">
                <?php echo $string_values['lbl_tipo_comision']; ?>
            </label>
            <div class="input-group">
                <label class="registro"><?php echo $dir_tes['nom_tipo_comision']; ?></label>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12 text-center'>
            <label for='lbl_comision_periodo' class="control-label">
                <?php echo $string_values['lbl_comision_periodo']; ?>
            </label>
        </div>
    </div>
    <br>
    <div class='row text-center'>
        <div class='col-sm-6'>
            <div class="">
                <div class="input-group date">
                    <label class="registro"><?php echo nice_date($dir_tes['fecha_inicio'], 'd-m-Y'); ?></label>
                </div>
            </div>
        </div>
        <div class='col-sm-6'>
            <div>
                <div class='input-group date'>
                    <label class="registro"><?php echo nice_date($dir_tes['fecha_fin'], 'd-m-Y'); ?></label>
                </div>
            </div>
        </div>
    </div>
    <?php echo $formulario_carga_archivo; ?>
    <?php echo $formulario_validacion; ?>
</div>