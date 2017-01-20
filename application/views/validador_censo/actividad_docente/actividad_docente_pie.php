<?php // pr( $identificador);  ?>
<div class="list-group-item text-center center" id="id_pie_modal_actividad_docente">
    <div class="row">
        <!--<div class="col-xs-12 col-sm-12 col-md-6 text-right rightSpring" >-->
        <div class="col-xs-6 col-sm-6 col-md-6 text-right ">
            <button type="button" id="close_modal_censo" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <!--</div>-->
        <?php if (isset($act_doc_cve)) {//Actualizar?> 
            <div class="col-xs-6 col-sm-6 col-md-6 text-left " >
                <button id="btn_actualizar_investigacion_docente" type="button" class="btn btn-success" 
                        data-invcve= "<?php echo $act_doc_cve; ?>"
                        data-comprobantecve= "<?php echo $comprobantecve; ?>" 
                        data-tpactividadcve="<?php echo (isset($tp_actividad_cve)) ? $tp_actividad_cve : ''; ?>"
                        onclick="funcion_actualizar_actividad_docente(this)" >
                    Actualizar 
                </button>
            </div>
        <?php } else { //Guardar ?> 
            <div class="col-xs-6 col-sm-6 col-md-6 text-left" >
                <button id="btn_guardar_investigacion_docente" type="button" class="btn btn-success"
                        data-actgralcve="<?php echo (isset($act_gral_cve))?$act_gral_cve :''; ?> "
                        onclick="funcion_guardar(this)" >
                    Guardar
                </button>
            </div>
        <?php } ?> 

    </div>
</div>