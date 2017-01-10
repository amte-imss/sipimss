<?php // pr( $identificador); ?>
<div class="list-group-item text-center center">
    <div class="row">
        <!-- <?php /*if (isset($cve_inv)) {//Actualizar?> 
            <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
                <button id="btn_guardar_direccion_tesis" type="button" class="btn btn-success" data-invcve= "<?php echo $cve_inv; ?>"
                        data-comprobantecve= "<?php echo $comprobantecve; ?>" data-idrow="<?php echo $idrow; ?>" onclick="guardar_direccion_tesis(this)" >
                    Actualizar 
                </button>
            </div>
        <?php } else { //Guardar ?> 
            <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
                <button id="btn_guardar_direccion_tesis" type="button" class="btn btn-success" onclick="guardar_direccion_tesis()" >
                    Guardar
                </button>
            </div>
        <?php }*/ ?> -->
        <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
            <button id="btn_guardar_direccion_tesis" type="button" class="btn btn-success" onclick="guardar_direccion_tesis(this)">
                <?php echo $string_values['guardar']; ?>
            </button>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 text-left">
            <button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal"><?php echo $string_values['cerrar']; ?></button>
        </div>
    </div>
</div>