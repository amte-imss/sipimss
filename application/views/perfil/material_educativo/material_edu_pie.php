<?php // pr( $identificador); ?>
<div class="list-group-item text-center center">
    <div class="row">
    <?php if (isset($cve_mat_edu)) {//Actualizar?> 
        <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
            <button id="btn_actualizar_investigacion_docente" type="button" class="btn btn-success" 
                    data-mateducve= "<?php echo $cve_mat_edu; ?>" 
                    data-tpmateducve= "<?php echo $cve_tp_mat_edu; ?>"
                    data-comprobantecve= "<?php echo $comprobantecve; ?>" onclick="funcion_actualizar_material_educativo(this)" >
                 <?php echo $string_values['btn_actualizar'];?> 
            </button>
        </div>
    <?php } else { //Guardar ?>
       
        <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
            <button id="btn_guardar_investigacion_docente" type="button" class="btn btn-success" onclick="funcion_guardar_material_educativo()" >
                 <?php echo $string_values['btn_guardar'];?> 
            </button>
        </div>
    <?php } ?> 
    <div class="col-xs-6 col-sm-6 col-md-6 text-left">
        <button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal"><?php echo $string_values['btn_cerrar'];?> </button>
    </div>
    </div>
</div>