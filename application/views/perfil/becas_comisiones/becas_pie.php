<?php // pr( $identificador); ?>
<div class="list-group-item text-center center">
    <div class="row">
    <?php if (isset($cve_beca)) {//Actualizar?> 
        <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
            <button id="btn_actualizar_investigacion_docente" type="button" class="btn btn-success" 
                    data-becacve= "<?php echo $cve_beca; ?>"
                    data-comprobantecve= "<?php echo $comprobantecve; ?>" onclick="funcion_actualizar_beca(this)" >
                <?php echo $string_values['btn_actualizar']; ?>
            </button>
        </div>
    <?php } else { //Guardar ?> 
        <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
            <button id="btn_guardar_investigacion_docente" type="button" class="btn btn-success" onclick="funcion_guardar_beca()" >
                <?php echo $string_values['btn_guardar']; ?>
            </button>
        </div>
    <?php } ?> 
    <div class="col-xs-6 col-sm-6 col-md-6 text-left">
        <button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal"><?php echo $string_values['btn_cerrar']; ?></button>
    </div>
    </div>
</div>