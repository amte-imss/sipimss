<div id="capa_html_validacion">
	<?php echo form_open('', array('id'=>'formulario_validacion')); ?>
	<div id="capa_validacion" style="padding:20px;">
		<?php if(isset($msg) && !is_null($msg)){ echo $msg; } //Imprimir mensaje ?>
        <div id="error"><?php echo form_error_format('estado_validacion'); ?></div>
		<div class="row">
            <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
                <label class="control-label">
                    * <?php echo $string_values['lbl_estado_validacion']; ?>:
                </label>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
                <div class="form-group">
                    <div class="input-group">
                        <?php
                        echo $this->form_complete->create_element(array('id'=>'estado_validacion', 'value'=>((isset($registro_validado[0]['VAL_CUR_EST_CVE']) && !empty($registro_validado[0]['VAL_CUR_EST_CVE'])) ? $registro_validado[0]['VAL_CUR_EST_CVE'] : ''), 'type'=>'dropdown', 'options'=>$catalogos['cvalidacion_curso_estado'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_estado_validacion'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_estado_validacion'])));
                        ?>                      
                    </div>
                </div>                
            </div>
        </div>

		<div class="row">
            <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
                <label class="control-label">
                    * <?php echo $string_values['lbl_comentario']; ?>:
                </label>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
                <div class="form-group">
                    <div class="input-group">
                        <?php
                        echo $this->form_complete->create_element(array('id'=>'comentario', 'value'=>((isset($registro_validado[0]['VAL_CUR_COMENTARIO']) && !empty($registro_validado[0]['VAL_CUR_COMENTARIO'])) ? $registro_validado[0]['VAL_CUR_COMENTARIO'] : ''), 'type'=>'textarea', 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_comentario'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'rows'=>'5', 'title'=>$string_values['lbl_comentario'])));
                        ?>                      
                    </div>
                </div>
                <?php echo form_error_format('comentario'); ?>
            </div>
        </div>
	</div>

	<div class="list-group-item text-center center">
	    <div class="row">
	        <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
	            <button id="btn_guardar_validacion" type="button" class="btn btn-success" data-value="<?php echo (isset($registro_validado[0]["HIST_VAL_CURSO_CVE"]) && !empty($registro_validado[0]["HIST_VAL_CURSO_CVE"])) ? $this->seguridad->encrypt_base64($registro_validado[0]["HIST_VAL_CURSO_CVE"]) : ""; ?>">
	                <?php echo $string_values['validar']; ?>
	            </button>
	        </div>
	        <div class="col-xs-6 col-sm-6 col-md-6 text-left">
	            <button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal"><?php echo $string_values['cerrar']; ?></button>
	        </div>
	    </div>
	</div>
	<?php echo form_close(); ?>
</div>
<div id="capa_historico_registro"></div>
<script type="text/javascript">
$(function() {
	if($('#btn_guardar_validacion').length){
        $('#btn_guardar_validacion').on('click', function() {
    		if($("#estado_validacion").val()!=""){ //Validar selección de estado
                $.ajax({
                    //url: site_url+'/validacion_censo_profesores/validar_censo_registro/<?php echo $identificador.'/+$(this).attr("data-value")+?tipo='.$tipo; ?>',
                    url: site_url+'/validacion_censo_profesores/validar_censo_registro/<?php echo $identificador."/'+$(this).attr('data-value')+'?tipo=".$tipo; ?>',
                    method: 'POST',
                    dataType: "json",
                    data: $('#formulario_validacion').serialize(),
                    beforeSend: function(xhr) {
                        $('#error').html(create_loader());
                    }
                })
                .done(function(response) {
                    $('#error').html(imprimir_resultado(response));
                    if(response.id!=""){
                        $("#btn_guardar_validacion").attr('data-value', response.id);
                    }
                    data_ajax(site_url+'/validacion_censo_profesores/listado_estado_registro/<?php echo $identificador.'/'.$tipo; ?>', null, '#capa_historico_registro');
                })
                .fail(function(jqXHR, response) {
                    $('#error').html(imprimir_resultado(response));
                })
                .always(function() {
                    remove_loader();
                    recargar_fecha_ultima_actualizacion();
                });
        	} else {
        	    $('#error').html(html_message("<?php echo $string_values['falta_estado_validacion']; ?>", 'danger'));
            }
        });
    }
    
    data_ajax(site_url+'/validacion_censo_profesores/listado_estado_registro/<?php echo $identificador.'/'.$tipo; ?>', null, '#capa_historico_registro');

    $('#modal_censo').on('hide.bs.modal', function (e) {
		cargar_datos_menu_perfil('<?php echo $seccion_actualizar; ?>');
		$(this).off(e);
	});
});
</script>