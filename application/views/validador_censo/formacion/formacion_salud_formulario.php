<div id="capa_html">
	<?php echo form_open_multipart('', array('id'=>'formulario_formacion_salud')); ?>
	<div id="capa_formacion_salud" style="padding:20px;">
		<?php if(isset($msg) && !is_null($msg)){ echo $msg; } //Imprimir mensaje ?>
		<div class="row">
		    <div class='col-sm-12 col-md-4 col-lg-4 text-right'>
		        <label class="control-label">
		            * <?php echo $string_values['lbl_tipo_for']; ?>:
		        </label>
		    </div>
		    <div class="col-md-4 col-lg-4 text-center">
                <label>
                    <?php
                    $checkedI = $checkedC = array();
                    if(isset($dir_tes['EFPCS_FOR_INICIAL']) && $dir_tes['EFPCS_FOR_INICIAL']==1){
                        $checkedI = array('checked'=>'checked');
                    } elseif(isset($dir_tes['EFPCS_FOR_INICIAL']) && $dir_tes['EFPCS_FOR_INICIAL']==2) {
                        $checkedC = array('checked'=>'checked');
                    }
                    echo $this->form_complete->create_element(
                    array('id'=>'es_inicial', 'type'=>'radio',
                            'value' => '1',
                            'attributes'=>array_merge(array(
                            'class'=>'radio-inline m-r-sm',
                            'title'=> $string_values['lbl_es_inicial']
                            ), $checkedI)
                        )
                    );
                    echo $string_values['lbl_es_inicial'];
                    ?>
                </label>
            </div>
            <div class="col-md-4 col-lg-4 text-left">
                <label>
                    <?php
                   	echo $this->form_complete->create_element(
                   		array('id'=>'es_inicial', 'type'=>'radio',
                           'value' => '2',
                           'attributes'=>array_merge(array(
	                           'class'=>'radio-inline m-r-sm',
	                           'title'=> $string_values['lbl_es_continua']
	                           ), $checkedC)
                       	)
                   	);
                   	echo $string_values['lbl_es_continua'];
                   ?>
                </label>
            </div>
		</div><br>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'></div>
		    <div class='col-sm-12 col-md-12 col-lg-8'><?php echo form_error_format('es_inicial'); ?></div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            * <?php echo $string_values['lbl_fecha_inicio']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker" id="datetimepicker1">
		                <?php
		                echo $this->form_complete->create_element(
		                	array('id'=>'fch_inicio','type'=>'text',
		                		//'value' => $dir_tes['EFPCS_FCH_INICIO'],
		                        'attributes'=>array(
			                        'class'=>'form-control',
			                        //'placeholder'=>$string_values['lbl_fecha_inicio'],
			                        'data-toggle'=>'tooltip',
			                        'title'=>$string_values['lbl_fecha_inicio']
		                        )
		                    )
		                );
		                $js_fch_ini = (isset($dir_tes['EFPCS_FCH_INICIO']) && !empty($dir_tes['EFPCS_FCH_INICIO'])) ? "defaultDate:moment('".$dir_tes['EFPCS_FCH_INICIO']."')" : '';
		                ?>
		                <span class="input-group-addon">
		                    <span class="fa fa-calendar"></span>
		                </span>
		            </div>
		        </div>
		        <?php echo form_error_format('fch_inicio'); ?>
		    </div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            * <?php echo $string_values['lbl_fecha_final']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker" id="datetimepicker2">
		                <?php
		                echo $this->form_complete->create_element(
		                	array('id'=>'fch_fin','type'=>'text',
		                		//'value' => $dir_tes['EFPCS_FCH_FIN'],
		                        'attributes'=>array(
			                        'class'=>'form-control',
			                        //'placeholder'=>$string_values['lbl_fecha_final'],
			                        'data-toggle'=>'tooltip',
			                        'title'=>$string_values['lbl_fecha_final']
		                        )
		                    )
		                );
		                $js_fch_fin = (isset($dir_tes['EFPCS_FCH_FIN']) && !empty($dir_tes['EFPCS_FCH_FIN'])) ? "defaultDate:moment('".$dir_tes['EFPCS_FCH_FIN']."')" : '';
		                ?>
		                <span class="input-group-addon">
		                    <span class="fa fa-calendar"></span>
		                </span>
		            </div>
		        </div>
		        <?php echo form_error_format('fch_fin'); ?>
		    </div>
		</div>

		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            * <?php echo $string_values['lbl_tipo_formacion']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group">
		                <?php
		                echo $this->form_complete->create_element(array('id'=>'tipo_formacion', 'type'=>'dropdown', 'value'=>$dir_tes['TIP_FORM_SALUD_CVE'], 'options'=>$catalogos['ctipo_formacion_salud'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_tipo_formacion'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_tipo_formacion'])));
		                ?>
		            </div>
		        </div>
		        <?php echo form_error_format('tipo_formacion'); ?>
		    </div>
		</div>
		<div id="capa_subtipo" class="row"></div>
        <?php echo form_error_format('subtipo'); ?>
		<?php echo $formulario_carga_archivo; ?>
	</div>
	<div class="list-group-item text-center center">
	    <div class="row">
	        <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
	            <button id="btn_guardar_formacion_salud" type="button" class="btn btn-success" data-value="<?php echo $identificador; ?>">
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
<script type="text/javascript">
$(function() {
	$("#datetimepicker1").datetimepicker( {
	    format: "MM-YYYY", // Notice the Extra space at the beginning
	    viewMode: "years",
	    locale: 'es',
        useCurrent: false,
	    <?php echo $js_fch_ini; ?>
	});
	$("#datetimepicker2").datetimepicker( {
	    format: "MM-YYYY", // Notice the Extra space at the beginning
	    viewMode: "years",
	    locale: 'es',
        useCurrent: false,
	    <?php echo $js_fch_fin; ?>
	});
	if($('#btn_guardar_formacion_salud').length){
        $('#btn_guardar_formacion_salud').on('click', function() {
        	if($('#idc').length){ //Validar carga de archivo
        		if($("#userfile").val()==""){ //Validar carga de archivo
            		data_ajax(site_url+'/validacion_censo_profesores/formacion_salud_formulario/<?php echo $identificador; ?>', '#formulario_formacion_salud', '#modal_content');
            	} else {
            	    $('#error_carga_archivo').html(html_message("<?php echo $string_values['falta_carga_archivo']; ?>", 'danger'));
                }
            } else {
            	$('#error_carga_archivo').html(html_message("<?php echo $string_values['falta_carga_archivo']; ?>", 'danger'));
            }
        });
    }
    $('.btn_subir_comprobante').click(function() {
        cargar_archivo($(this).attr('data-key'), "#formulario_formacion_salud");
    });
    $('#modal_censo').on('hide.bs.modal', function (e) {
		cargar_datos_menu_perfil('seccion_formacion');
		recargar_fecha_ultima_actualizacion();
		var btn_gdt = $("#btn_guardar_formacion_salud").attr('data-value');
		if($('#idc').length && btn_gdt == ""){ ///Eliminar archivo que no hayan sido asociados
			data_ajax(site_url+'/administracion/eliminar_archivos', null, null);
		}
		$(this).off(e);
	});
	if($('#tipo_formacion').length){
        $( "#tipo_formacion" ).change(function() {
            if($(this).val()!=""){
                data_ajax(site_url+'/validacion_censo_profesores/subtipo_formacion/'+$(this).val(), null, '#capa_subtipo');
            }
        });
        <?php
        if(isset($dir_tes['TIP_FORM_SALUD_CVE']) && !empty($dir_tes['TIP_FORM_SALUD_CVE'])){ ?>
            data_ajax(site_url+"/validacion_censo_profesores/subtipo_formacion/"+$('#tipo_formacion').val()+"/<?php echo ((isset($dir_tes['CSUBTIP_FORM_SALUD_CVE']) && !empty($dir_tes['CSUBTIP_FORM_SALUD_CVE'])) ? $dir_tes['CSUBTIP_FORM_SALUD_CVE'] : '')?>", null, '#capa_subtipo');
        <?php } ?>
    }
});
</script>