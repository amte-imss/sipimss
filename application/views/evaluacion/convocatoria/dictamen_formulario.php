<div id="capa_dictamen_form">
	<div style="padding:20px;">
		<?php echo form_open('', array('id' => 'formularioDictamen')); ?>
		<?php if(isset($msg) && !is_null($msg)){ echo $msg; } //Imprimir mensaje ?>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['tab_head_fecha_inicia_evaluacion']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker" id="datetimepicker4">
		                <?php
		                echo $this->form_complete->create_element(
		                	array('id'=>'FCH_INICIO_EVALUACION','type'=>'text',
		                        'attributes'=>array(
			                        'class'=>'form-control',
			                        'data-toggle'=>'tooltip',
			                        'title'=>$string_values['tab_head_fecha_inicia_evaluacion']
		                        )
		                    )
		                );
		                $js_fch_fin_reg = (isset($dato_dictamen[0]['FCH_INICIO_EVALUACION']) && !empty($dato_dictamen[0]['FCH_INICIO_EVALUACION'])) ? "defaultDate:moment('".$dato_dictamen[0]['FCH_INICIO_EVALUACION']."')" : '';
		                ?>
		                <span class="input-group-addon">
		                    <span class="fa fa-calendar"></span>
		                </span>
		            </div>
		        </div>
		        <?php echo form_error_format('FCH_INICIO_EVALUACION'); ?>
		    </div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['tab_head_fecha_fin_evaluacion']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker" id="datetimepicker5">
		                <?php
		                echo $this->form_complete->create_element(
		                	array('id'=>'FCH_FIN_EVALUACION','type'=>'text',
		                        'attributes'=>array(
			                        'class'=>'form-control',
			                        'data-toggle'=>'tooltip',
			                        'title'=>$string_values['tab_head_fecha_fin_evaluacion']
		                        )
		                    )
		                );
		                $js_fch_fin_val1 = (isset($dato_dictamen[0]['FCH_FIN_EVALUACION']) && !empty($dato_dictamen[0]['FCH_FIN_EVALUACION'])) ? "defaultDate:moment('".$dato_dictamen[0]['FCH_FIN_EVALUACION']."')" : '';
		                ?>
		                <span class="input-group-addon">
		                    <span class="fa fa-calendar"></span>
		                </span>
		            </div>
		        </div>
		        <?php echo form_error_format('FCH_FIN_EVALUACION'); ?>
		    </div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['tab_head_fecha_fin_inconformidad']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker" id="datetimepicker6">
		                <?php
		                echo $this->form_complete->create_element(
		                	array('id'=>'FCH_FIN_INCONFORMIDAD','type'=>'text',
		                        'attributes'=>array(
			                        'class'=>'form-control',
			                        'data-toggle'=>'tooltip',
			                        'title'=>$string_values['tab_head_fecha_fin_inconformidad']
		                        )
		                    )
		                );
		                $js_fch_fin_val2 = (isset($dato_dictamen[0]['FCH_FIN_INCONFORMIDAD']) && !empty($dato_dictamen[0]['FCH_FIN_INCONFORMIDAD'])) ? "defaultDate:moment('".$dato_dictamen[0]['FCH_FIN_INCONFORMIDAD']."')" : '';
		                ?>
		                <span class="input-group-addon">
		                    <span class="fa fa-calendar"></span>
		                </span>
		            </div>
		        </div>
		        <?php echo form_error_format('FCH_FIN_INCONFORMIDAD'); ?>
		    </div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-12 text-right'>
		    	<div class="input-group-btn">
	                <button type="button" id="btn_dictamen_enviar" aria-expanded="false" class="btn btn-default browse" data-value="<?php echo $identificador; ?>" style="margin-right:10px;">
	                    <?php echo $string_values['enviar']; ?>
	                </button>
	                <button type="button" id="btn_dictamen_cancelar" aria-expanded="false" class="btn btn-default browse">
	                    <?php echo $string_values['cancelar']; ?>
	                </button>
	            </div>
		    </div>
		</div>
	</div>
	<script type="text/javascript">
	$(function() {
		$('#datetimepicker4').datetimepicker({
	        locale: 'es',
	        format: 'DD-MM-YYYY',
	        useCurrent: false,
	        //defaultDate:moment('2016-01-20')
	        <?php echo $js_fch_fin_reg; ?>
	    });
	    $('#datetimepicker5').datetimepicker({
	        locale: 'es',
	        format: 'DD-MM-YYYY',
	        useCurrent: false,
	        <?php echo $js_fch_fin_val1; ?>
	    });
	    $('#datetimepicker6').datetimepicker({
	        locale: 'es',
	        format: 'DD-MM-YYYY',
	        useCurrent: false,
	        <?php echo $js_fch_fin_val2; ?>
	    });
	    /*$( "#datetimepicker4" ).load(function(e) {
            $('#datetimepicker3').data("DateTimePicker").minDate(e.date);
        });*/
	    $("#datetimepicker4").on("dp.change", function (e) {
            $('#datetimepicker5').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker5").on("dp.change", function (e) {
            $('#datetimepicker4').data("DateTimePicker").maxDate(e.date);
            $('#datetimepicker6').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker5').data("DateTimePicker").maxDate(e.date);
        });
	    if($('#btn_dictamen_enviar').length){
	        $('#btn_dictamen_enviar').on('click', function() {
	            data_ajax(site_url+'/convocatoria_evaluacion/gestionar_dictamen/'+$("#btn_convocatoria_enviar").attr('data-value')+'/'+$(this).attr('data-value'), '#formularioDictamen', '#capa_dictamen_formulario');
	            setTimeout(function(){ 
	            	data_ajax(site_url+'/convocatoria_evaluacion/listar_dictamen/'+$("#btn_convocatoria_enviar").attr('data-value'), null, '#capa_dictamen');
	            }, 1000);
	        });
	    }
	    if($('#btn_dictamen_cancelar').length){
	        $('#btn_dictamen_cancelar').on('click', function() {
	            $("#capa_dictamen_formulario").html("");
	        });
	    }
	    <?php
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