                    <!--data-idvalidador ="<?php // echo $reg_id_validador;?>"-->
<?php // pr( $identificador); ?>
<div class="list-group-item text-center center">
    <div class="row">
        <!--<div class="col-xs-12 col-sm-12 col-md-6 text-right rightSpring" >-->
            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
              <button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        <div class="col-xs-6 col-sm-6 col-md-6 text-left">
            <button id="btn_guardar_investigacion_docente" type="button" class="btn btn-success" 
                    data-tipoevento ="asignar"
                    data-delcve="<?php echo $reg_delegacion_cve;?>"
                    data-depcve="<?php echo $reg_departamento_desc;?>"
                    data-matricula="<?php echo $matricula;?>"
                    data-idrow="<?php echo $reg_idrow; ?>"
                    onclick="funcion_seleccionar_validador(this)" >
                Asignar validador
            </button>
        </div>

    </div>
</div>

