<script type="text/javascript">
$(function() {
	$("#datetimepicker1").datetimepicker( {
	    format: "YYYY", // Notice the Extra space at the beginning
	    viewMode: "years",
	    minDate: moment("<?php echo $this->config->item('minDate'); ?>"),
        maxDate : 'now',
	});
	if($('#btn_guardar_comision_academica').length){
        $('#btn_guardar_comision_academica').on('click', function() {
        	if($('#idc').length){ //Validar carga de archivo
        		if($("#userfile").val()==""){ //Validar carga de archivo
	            	//data_ajax(site_url+'/perfil/comision_academica_formulario/<?php echo $tipo_comision; ?>/<?php echo $identificador; ?>', '#formulario_comision_academica', '#modal_content');
	            	$.ajax({
                        url: site_url+'/perfil/comision_academica_formulario/<?php echo $tipo_comision; ?>/<?php echo $identificador; ?>',
                        method: 'POST',
                        //dataType: "json",
                        data: $('#formulario_comision_academica').serialize(),
                        beforeSend: function(xhr) {
                            $('#modal_content').html(create_loader());
                        }
                    })
                    .done(function(response) {
                        try{
                        	var json = $.parseJSON(response);
	                        recargar_opcion_menu_mostrar_mensaje('seccion_comision_academica', json.result, json.msg);
	                    } catch (e) {
	                        $('#modal_content').html(response);
	                    }
                    })
                    .fail(function(jqXHR, response) {
                    	$('modal_content').html(imprimir_resultado(response));
                    })
                    .always(function() {
                        remove_loader();
                        recargar_fecha_ultima_actualizacion();
                    });
                } else {
            	    $('#error_carga_archivo').html(html_message("<?php echo $string_values['falta_carga_archivo']; ?>", 'danger'));
                }
            } else {
            	$('#error_carga_archivo').html(html_message("<?php echo $string_values['falta_carga_archivo']; ?>", 'danger'));
            }
        });
    }
    $('.btn_subir_comprobante').click(function() {
        cargar_archivo($(this).attr('data-key'), "#formulario_comision_academica");
    });
    $('#modal_censo').on('hide.bs.modal', function (e) {
		cargar_datos_menu_perfil('seccion_comision_academica');
		recargar_fecha_ultima_actualizacion();
		var btn_gdt = $("#btn_guardar_comision_academica").attr('data-value');
		if($('#idc').length && btn_gdt == ""){ ///Eliminar archivo que no hayan sido asociados
			data_ajax(site_url+'/administracion/eliminar_archivos', null, null);
		}
		$(this).off(e);
	});
});
</script>
<div id="capa_html">
	<?php echo form_open_multipart('', array('id'=>'formulario_comision_academica')); ?>
	<div id="capa_direccion_tesis" style="padding:20px;">
		<?php if(isset($msg) && !is_null($msg)){ echo $msg; } //Imprimir mensaje ?>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            * <?php echo $string_values['t_h_anio']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker" id="datetimepicker1">
		                <?php
		                echo $this->form_complete->create_element(
		                	array('id'=>'dt_anio','type'=>'text',
		                		'value' => $dir_tes['EC_ANIO'],
		                        'attributes'=>array(
			                        'class'=>'form-control',
			                        'placeholder'=>$string_values['t_h_anio'],
			                        'data-toggle'=>'tooltip',
			                        'title'=>$string_values['t_h_anio']
		                        )
		                    )
		                );
		                //$js_fch_fin_reg = (isset($dato_convocatoria[0]['dt_anio']) && !empty($dato_convocatoria[0]['FCH_FIN_REG_DOCENTE'])) ? "defaultDate:moment('".$dato_convocatoria[0]['FCH_FIN_REG_DOCENTE']."')" : '';
		                ?>
		                <span class="input-group-addon">
		                    <span class="fa fa-calendar"></span>
		                </span>
		            </div>
		        </div>
		        <?php echo form_error_format('dt_anio'); ?>
		    </div>
		</div>

		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            * <?php echo $string_values['t_h_nivel_academico']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group">
		                <?php
		                echo $this->form_complete->create_element(array('id'=>'nivel_academico', 'type'=>'dropdown', 'value'=>$dir_tes['NIV_ACADEMICO_CVE'], 'options'=>$catalogos['cnivel_academico'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['t_h_nivel_academico'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['t_h_nivel_academico'])));
		                ?>		                
		            </div>
		        </div>
		        <?php echo form_error_format('nivel_academico'); ?>
		    </div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            * <?php echo $string_values['t_h_area']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group">
		                <?php
		                echo $this->form_complete->create_element(array('id'=>'comision_area', 'type'=>'dropdown', 'value'=>$dir_tes['COM_AREA_CVE'], 'options'=>$catalogos['comision_area'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['t_h_area'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['t_h_area'])));
		                ?>
		            </div>
		        </div>
		        <?php echo form_error_format('comision_area'); ?>
		    </div>
		</div>
		<?php echo $formulario_carga_archivo; ?>
	</div>
	<div class="list-group-item text-center center">
	    <div class="row">
	        <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
	            <button id="btn_guardar_comision_academica" type="button" class="btn btn-success" data-value="<?php echo $identificador; ?>">
	                <?php echo $string_values['guardar']; ?>
	            </button>
	        </div>
	        <div class="col-xs-6 col-sm-6 col-md-6 text-left">
	            <button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal"><?php echo $string_values['cerrar']; ?></button>
	        </div>
	    </div>
	</div>
	<?php echo form_close(); ?>
</div>