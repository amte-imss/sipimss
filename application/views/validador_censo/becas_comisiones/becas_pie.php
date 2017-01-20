<?php // pr( $identificador); ?>
<div class="list-group-item text-center center">
    <div class="row">
        <!--<div class="col-xs-12 col-sm-12 col-md-6 text-right rightSpring" >-->
            <div class="col-xs-6 col-sm-6 col-md-6 text-right ">
              <button type="button" id="close_modal_censo" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        <!--</div>-->
    <?php if (isset($cve_beca)) {//Actualizar?> 
        <div class="col-xs-6 col-sm-6 col-md-6 text-left " >
            <button id="btn_actualizar_investigacion_docente" type="button" class="btn btn-success" 
                    data-becacve= "<?php echo $cve_beca; ?>"
                    data-comprobantecve= "<?php echo $comprobantecve; ?>" onclick="funcion_actualizar_beca(this)" >
                Actualizar 
            </button>
        </div>
    <?php } else { //Guardar ?> 
        <div class="col-xs-6 col-sm-6 col-md-6 text-left" >
            <button id="btn_guardar_investigacion_docente" type="button" class="btn btn-success" onclick="funcion_guardar_beca()" >
                Guardar
            </button>
        </div>
    <?php } ?> 

    </div>
</div>