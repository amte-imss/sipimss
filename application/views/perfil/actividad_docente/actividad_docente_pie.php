<?php // pr( $identificador);  ?>
<div class="list-group-item text-center center" id="id_pie_modal_actividad_docente">
    <div class="row">
        <!--</div>-->
        <?php if (isset($act_doc_cve)) {//Actualizar?> 
            <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
                <button id="btn_actualizar_investigacion_docente" type="button" class="btn btn-success" 
                        data-invcve= "<?php echo $act_doc_cve; ?>"
                        data-comprobantecve= "<?php echo $comprobantecve; ?>" 
                        data-tpactividadcve="<?php echo (isset($tp_actividad_cve)) ? $tp_actividad_cve : ''; ?>"
                        onclick="funcion_actualizar_actividad_docente(this)" >
                    <?php echo $string_values['btn_actualizar'];?> 
                </button>
            </div>
        <?php } else { //Guardar ?> 
            <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
                <button id="btn_guardar_investigacion_docente" type="button" class="btn btn-success"
                        data-actgralcve="<?php echo (isset($act_gral_cve))?$act_gral_cve :''; ?> "
                        onclick="funcion_guardar(this)" >
                    <?php echo $string_values['btn_guardar'];?>
                </button>
            </div>
        <?php } ?> 
        <div class="col-xs-6 col-sm-6 col-md-6 text-left ">
            <button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal"><?php echo $string_values['btn_cerrar'];?></button>
        </div>

    </div>
</div>