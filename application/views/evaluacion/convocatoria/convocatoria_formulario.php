<div id="capa_html">
	<div id="capa_convocatoria" style="padding:20px;">
		<?php echo form_open('', array('id' => 'formularioConvocatoria')); ?>
		<div class="row">
			<div class='col-lg-12'>
				<h2><?php echo $string_values['titulo_agregar']; ?></h2><br>
			</div>
		</div>
		<?php if(isset($msg) && !is_null($msg)){ echo $msg; } //Imprimir mensaje ?>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['tab_head_fecha_fin_registro']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker" id="datetimepicker1">
		                <?php
		                echo $this->form_complete->create_element(
		                	array('id'=>'FCH_FIN_REG_DOCENTE','type'=>'text',
		                        //'value' => (isset($dato_convocatoria[0]['FCH_FIN_REG_DOCENTE']) && !empty($dato_convocatoria[0]['FCH_FIN_REG_DOCENTE'])) ? $dato_convocatoria[0]['FCH_FIN_REG_DOCENTE'] : '',
		                        'attributes'=>array(
			                        'class'=>'form-control',
			                        //'placeholder'=>$string_values['tab_head_fecha_fin_registro'],
			                        'data-toggle'=>'tooltip',
			                        'title'=>$string_values['tab_head_fecha_fin_registro']
		                        )
		                    )
		                );
		                $js_fch_fin_reg = (isset($dato_convocatoria[0]['FCH_FIN_REG_DOCENTE']) && !empty($dato_convocatoria[0]['FCH_FIN_REG_DOCENTE'])) ? "defaultDate:moment('".$dato_convocatoria[0]['FCH_FIN_REG_DOCENTE']."')" : '';
		                ?>
		                <span class="input-group-addon">
		                    <span class="fa fa-calendar"></span>
		                </span>
		            </div>
		        </div>
		        <?php echo form_error_format('FCH_FIN_REG_DOCENTE'); ?>
		    </div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['tab_head_fecha_fin_validacion1']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker" id="datetimepicker2">
		                <?php
		                echo $this->form_complete->create_element(
		                	array('id'=>'FCH_FIN_VALIDACION_1','type'=>'text',
		                        'attributes'=>array(
			                        'class'=>'form-control',
			                        'data-toggle'=>'tooltip',
			                        'title'=>$string_values['tab_head_fecha_fin_validacion1']
		                        )
		                    )
		                );
		                $js_fch_fin_val1 = (isset($dato_convocatoria[0]['FCH_FIN_VALIDACION_1']) && !empty($dato_convocatoria[0]['FCH_FIN_VALIDACION_1'])) ? "defaultDate:moment('".$dato_convocatoria[0]['FCH_FIN_VALIDACION_1']."')" : '';
		                ?>
		                <span class="input-group-addon">
		                    <span class="fa fa-calendar"></span>
		                </span>
		            </div>
		        </div>
		        <?php echo form_error_format('FCH_FIN_VALIDACION_1'); ?>
		    </div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['tab_head_fecha_fin_validacion2']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker" id="datetimepicker3">
		                <?php
		                echo $this->form_complete->create_element(
		                	array('id'=>'FCH_FIN_VALIDACION_2','type'=>'text',
		                        'attributes'=>array(
			                        'class'=>'form-control',
			                        'data-toggle'=>'tooltip',
			                        'title'=>$string_values['tab_head_fecha_fin_validacion2']
		                        )
		                    )
		                );
		                $js_fch_fin_val2 = (isset($dato_convocatoria[0]['FCH_FIN_VALIDACION_2']) && !empty($dato_convocatoria[0]['FCH_FIN_VALIDACION_2'])) ? "defaultDate:moment('".$dato_convocatoria[0]['FCH_FIN_VALIDACION_2']."')" : '';
		                ?>
		                <span class="input-group-addon">
		                    <span class="fa fa-calendar"></span>
		                </span>
		            </div>
		        </div>
		        <?php echo form_error_format('FCH_FIN_VALIDACION_2'); ?>
		    </div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-12 text-right'>
		    	<div class="input-group-btn">
	                <button type="button" id="btn_convocatoria_enviar" aria-expanded="false" class="btn btn-default browse" data-value="<?php echo $identificador; ?>" style="margin-right:10px;">
	                    <?php echo $string_values['enviar']; ?>
	                </button>
	                <button type="button" id="btn_convocatoria_cancelar" aria-expanded="false" class="btn btn-default browse" data-dismiss="modal">
	                    <?php echo $string_values['cancelar']; ?>
	                </button>
	            </div>
		    </div>
		</div>
	</div>
	<div id="mensaje_dictamen" style="padding:20px;"></div>
	<div id="capa_dictamen" style="padding:20px;"></div>
	<div id="capa_dictamen_formulario" style="padding:20px;"></div>
	<script type="text/javascript">
	$(function() {
		$('#datetimepicker1').datetimepicker({
	        locale: 'es',
	        format: 'DD-MM-YYYY',
	        useCurrent: false,
	        //defaultDate:moment('2016-01-20')
	        <?php echo $js_fch_fin_reg; ?>
	    });
	    $('#datetimepicker2').datetimepicker({
	        locale: 'es',
	        format: 'DD-MM-YYYY',
	        useCurrent: false,
	        <?php echo $js_fch_fin_val1; ?>
	    });
	    $('#datetimepicker3').datetimepicker({
	        locale: 'es',
	        format: 'DD-MM-YYYY',
	        useCurrent: false,
	        <?php echo $js_fch_fin_val2; ?>
	    });
	    $("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
            $('#datetimepicker3').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker3").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").maxDate(e.date);
        });
	    if($('#btn_convocatoria_enviar').length){
	        $('#btn_convocatoria_enviar').on('click', function() {
	            data_ajax(site_url+'/convocatoria_evaluacion/gestionar_convocatoria/'+$(this).attr('data-value'), '#formularioConvocatoria', '#capa_html');
	        });
	    }
	    <?php 
	    if(!is_null($identificador)) { ?>//Si la convocatoria se encuentra almacenada se cargan datos de dictamenes
	    	data_ajax(site_url+'/convocatoria_evaluacion/listar_dictamen/<?php echo $identificador; ?>', null, '#capa_dictamen');
	    <?php }
	    if(isset($msg) && !is_null($msg)){ ///Asignar recarga de página al haberse realizado una actualización ?>
		    if($('#btn_convocatoria_cancelar').length){
		    	$('#btn_convocatoria_cancelar').on('click', function() {
				    $('#modal_censo').on('hidden.bs.modal', function (e) {
						document.location.href=document.location.href;
					})
				});
			}
		<?php } ?>
	});
	</script>
</div>