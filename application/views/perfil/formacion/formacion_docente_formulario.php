<div id="capa_html_docente">
	<?php echo form_open_multipart('', array('id'=>'formulario_formacion_docente')); ?>
	<div id="capa_formacion_docente" style="padding:20px;">
		<?php if(isset($msg) && !is_null($msg)){ echo $msg; } //Imprimir mensaje ?>
		<div class="row">
            <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
                <label class="control-label">
                    * <?php echo $string_values['lbl_tipo_formacion_docente']; ?>:
                </label>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
                <div class="form-group">
                    <div class="input-group">
                        <?php
                        echo $this->form_complete->create_element(array('id'=>'tipo_formacion', 'type'=>'dropdown', 'value'=>$dir_tes['TIP_FOR_PROF_CVE'], 'options'=>$catalogos['ctipo_formacion_profesional'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_tipo_formacion_docente'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_tipo_formacion_docente'])));
                        ?>                      
                    </div>
                </div>
                <?php echo form_error_format('tipo_formacion'); ?>
            </div>
        </div>
        
        <div id="capa_subtipo" class="row"></div>
        <div class="row">
            <div class='col-sm-12 col-md-12 col-lg-4 text-right'></div>
            <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
                <?php echo form_error_format('subtipo'); ?>
                <?php echo form_error_format('tipo_curso'); ?>
            </div>
        </div>
        
        <!-- <div id="capa_tipo_curso" class="row"></div> -->

		<div class="row">
            <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
                <label class="control-label">
                    * <?php echo $string_values['t_h_institucion']; ?>:
                </label>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
                <div class="form-group">
                    <div class="input-group">
                        <?php
                        echo $this->form_complete->create_element(array('id'=>'institucion', 'type'=>'dropdown', 'value'=>$dir_tes['INS_AVALA_CVE'], 'options'=>$catalogos['cinstitucion_avala'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['t_h_institucion'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['t_h_institucion'])));
                        ?>                      
                    </div>
                </div>
                <?php echo form_error_format('institucion'); ?>
            </div>
        </div>

        <div class="row">
            <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
                <label class="control-label">
                    * <?php echo $string_values['t_h_modalidad']; ?>:
                </label>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
                <div class="form-group">
                    <div class="input-group">
                        <?php
                        echo $this->form_complete->create_element(array('id'=>'modalidad', 'type'=>'dropdown', 'value'=>$dir_tes['MODALIDAD_CVE'], 'options'=>$catalogos['cmodalidad'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['t_h_modalidad'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['t_h_modalidad'])));
                        ?>                      
                    </div>
                </div>
                <?php echo form_error_format('modalidad'); ?>
            </div>
        </div>

        <div class="row">
            <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
                <label class="control-label">
                    * <?php echo $string_values['lbl_tematica']; ?>:
                </label>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-6 text-left'>
                <div class="form-group">
                    <div class="input-group">
                        <?php
                        echo $this->form_complete->create_element(array('id'=>'tematicas', 'type'=>'dropdown', 'value'=>'', 'options'=>$catalogos['ctematica'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_tematica'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_tematica'])));
                        ?>                      
                    </div>
                </div>
                <?php echo form_error_format('tematica[]'); ?>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-2 text-right'>
                <div class="form-group">
                    <div class="input-group">
                        <button type="button" id="btn_crear_tematica" class="btn btn-success"><?php echo $string_values['agregar_tematica']; ?></button>
                    </div>
                </div>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-4 text-right'></div>
            <div id="capa_tematicas" class='col-sm-12 col-md-12 col-lg-8 text-left' style="padding-bottom:10px;">
            	<?php
            	foreach ($dir_tes['tematica'] as $key_t => $tematicad) {
            		$tematicad = (array) $tematicad;
            		echo '<div id="tematica_'.$tematicad['TEMATICA_CVE'].'" class="col-md-5 text-left div_tematica" 
            			data-value="'.$tematicad['TEMATICA_CVE'].'">
            			<span id="remove_'.$tematicad['TEMATICA_CVE'].'" class="glyphicon glyphicon-remove" 
            			onclick="remover_tematica(this);"></span> 
            			'.$tematicad['TEM_NOMBRE'].'<input type="hidden" id="tematica[]" name="tematica[]" value="'.$tematicad['TEMATICA_CVE'].'"></div>';
            	}            	
            	?>
            </div>
        </div>

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
		                	array('id'=>'fd_anio','type'=>'text',
		                		'value' => $dir_tes['EFO_ANIO_CURSO'],
		                        'attributes'=>array(
			                        'class'=>'form-control',
			                        //'placeholder'=>$string_values['t_h_anio'],
			                        'data-toggle'=>'tooltip',
			                        'title'=>$string_values['t_h_anio']
		                        )
		                    )
		                );
		                ?>
		                <span class="input-group-addon">
		                    <span class="fa fa-calendar"></span>
		                </span>
		            </div>
		        </div>
		        <?php echo form_error_format('fd_anio'); ?>
		    </div>
		</div>

		<div class='row'>
            <div class="col-md-4 text-right">
                <label for='lbl_duracion' class="control-label">
                    <b class="rojo ">*</b>
                     <?php echo $string_values['lbl_duracion']; ?>
                </label>
            </div>
            <div class="col-md-4 text-center">
                <label>
                    <?php
                    $radio_val = "";
                    if(isset($dir_tes['EFP_DURACION']) && !empty($dir_tes['EFP_DURACION'])){
                        $checked = array('checked'=>'checked');
                        $radio_val = '<script>$(function () { mostrar_horas_fechas("block"); });</script>';
                    } else {
                        $checked = array();
                    }
                    echo $this->form_complete->create_element(
                    array('id'=>'duracion', 'type'=>'radio',
                            'value' => 'hora_dedicadas',
                            'attributes'=>array_merge(array(
                            'class'=>'radio-inline m-r-sm',
                            'title'=> $string_values['radio_duracion_horas'],
                            'onchange' =>"mostrar_horas_fechas('block')"    
                            ), $checked)
                        )
                    );
                    echo $string_values['radio_duracion_horas'];
                    ?>
                </label>
            </div>
            <div class="col-md-4 text-left">
                <label>
                    <?php
                    if(isset($dir_tes['EFP_FCH_INICIO']) && !empty($dir_tes['EFP_FCH_INICIO']) && isset($dir_tes['EFP_FCH_FIN']) && !empty($dir_tes['EFP_FCH_FIN'])){
                        $checked = array('checked'=>'checked');
                        $radio_val = '<script>$(function () { mostrar_horas_fechas("none"); });</script>';
                    } else {
                        $checked = array();
                    }
                    echo $this->form_complete->create_element(
                    array('id'=>'duracion', 'type'=>'radio',
                           'value' => 'fecha_dedicadas',
                           'attributes'=>array_merge(array(
                           'class'=>'radio-inline m-r-sm',
                           'title'=> $string_values['radio_duracion_fecha'],
                           'onchange' =>"mostrar_horas_fechas('none')"    
                           ), $checked)
                       )
                   );
                   echo $string_values['radio_duracion_fecha'];
                   ?>
                </label>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12 col-sm-12 col-lg-12' >
                <?php echo form_error_format('duracion'); ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-6 col-lg-6' id="div_horas_dedicadas" style="<?php echo $mostrar_hora_fecha_duracion==='hora_dedicadas'?'display: block':'display: none';?>">
                    <label for='lbl_duracion_horas' class="control-label">
                        <?php echo $string_values['radio_duracion_horas']; ?>
                    </label>
                    <div class="input-group">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"> </span>
                    </span>
                    <?php
                        echo $this->form_complete->create_element(
                        array('id'=>'hora_dedicadas','type'=>'number',
                                'value' => $dir_tes['EFP_DURACION'],
                                'attributes'=>array(
                                'class'=>'form-control',
                                'placeholder'=>$string_values['radio_duracion_horas'],
                                'min'=> '0',
                                'max'=> '100',
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>$string_values['radio_duracion_horas'],
                                )
                            )
                        );
                    ?>
                    </div>
                    <?php echo form_error_format('hora_dedicadas'); ?>
            </div>
            <div class='col-sm-6 col-lg-6 text-center' id="fecha_inicio" style="<?php echo $mostrar_hora_fecha_duracion==='fecha_dedicadas'?'display: block':'display: none';?>">
                <label for='lbl_duracion_fecha_inicio' class="control-label">
                    <?php echo $string_values['lbl_duracion_fecha_inicio']; ?>
                </label>

                <div class="form-group">
                    <div class="input-group date" id="datetimepickerfi" >
                        <?php
                        echo $this->form_complete->create_element(
                        array('id'=>'fecha_inicio_pick','type'=>'text',
                                'attributes'=>array(
                                'class'=>'form-control',
                                'data-toggle'=>'tooltip',
                                'title'=>$string_values['lbl_duracion_fecha_inicio'],
                                )
                            )
                        );
                        $js_fch_ini = (isset($dir_tes['EFP_FCH_INICIO']) && !empty($dir_tes['EFP_FCH_INICIO'])) ? "defaultDate:moment('".$dir_tes['EFP_FCH_INICIO']."')" : '';
                        ?>
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>
                </div>
                <?php echo form_error_format('fecha_inicio_pick'); ?>
            </div>

            <div class='col-sm-6 text-center' id="fecha_fin" style="<?php echo $mostrar_hora_fecha_duracion==='fecha_dedicadas'?'display: block':'display: none';?>">
                <label for='radio_duracion_fecha' class="control-label">
                    <?php echo $string_values['lbl_duracion_fecha_final']; ?>
                </label>
                <div class="form-group">
                    <div class='input-group date' id='datetimepickerff'>
                        <?php
                        echo $this->form_complete->create_element(
                        array('id'=>'fecha_fin_pick','type'=>'text',
                                'attributes'=>array(
                                'class'=>'form-control',
                                'data-toggle'=>'tooltip',
                                'title'=>$string_values['lbl_duracion_fecha_final']
                                )
                            )
                        );
                        $js_fch_fin = (isset($dir_tes['EFP_FCH_FIN']) && !empty($dir_tes['EFP_FCH_FIN'])) ? "defaultDate:moment('".$dir_tes['EFP_FCH_FIN']."')" : '';
                        ?>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <?php echo form_error_format('fecha_fin_pick'); ?>
            </div>
        </div>        
		<?php echo $formulario_carga_archivo; ?>
	</div>

	<div class="list-group-item text-center center">
	    <div class="row">
	        <div class="col-xs-6 col-sm-6 col-md-6 text-right" >
	            <button id="btn_guardar_formacion_docente" type="button" class="btn btn-success" data-value="<?php echo $identificador; ?>">
	                <?php echo $string_values['guardar']; ?>
	            </button>
	        </div>
	        <div class="col-xs-6 col-sm-6 col-md-6 text-left">
	            <button type="button" id="close_modal_censo" class="btn btn-success" data-dismiss="modal"><?php echo $string_values['cerrar']; ?></button>
	        </div>
	    </div>
	</div>
	<?php echo form_close(); echo $radio_val; ?>
</div>
<script type="text/javascript">
$(function() {
	$("#datetimepicker1").datetimepicker( {
        format: "YYYY", // Notice the Extra space at the beginning
        viewMode: "years",
        minDate: moment("<?php echo $this->config->item('minDate'); ?>"),
        maxDate : 'now'
    });
    $('#datetimepickerfi').datetimepicker({
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        format:'DD-MM-YYYY', 
        locale: 'es',
        useCurrent: false,
        minDate: moment("<?php echo $this->config->item('minDate'); ?>"),
        maxDate : 'now',
        <?php echo $js_fch_ini; ?>
    });
    $('#datetimepickerff').datetimepicker({
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        format:'DD-MM-YYYY', 
        locale: 'es',
        useCurrent: false,
        minDate: moment("<?php echo $this->config->item('minDate'); ?>"),
        maxDate : 'now',
        <?php echo $js_fch_fin; ?>
    });
    /*$("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepickerff').data("DateTimePicker").maxDate(e.date);
    });*/
    $("#datetimepickerfi").on("dp.change", function (e) {
        $('#datetimepickerff').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerff").on("dp.change", function (e) {
        $('#datetimepickerfi').data("DateTimePicker").maxDate(e.date);
        //$('#datetimepicker1').data("DateTimePicker").maxDate(e.date);        
    });
	if($('#btn_guardar_formacion_docente').length){
        $('#btn_guardar_formacion_docente').on('click', function() {
        	if($('#idc').length){ //Validar carga de archivo
        		if($("#userfile").val()==""){ //Validar carga de archivo
            		//data_ajax(site_url+'/perfil/formacion_docente_formulario/<?php echo $identificador; ?>', '#formulario_formacion_docente', '#modal_content');
                $.ajax({
                        url: site_url+'/perfil/formacion_docente_formulario/<?php echo $identificador; ?>',
                        method: 'POST',
                        //dataType: "json",
                        data: $('#formulario_formacion_docente').serialize(),
                        beforeSend: function(xhr) {
                            $('#modal_content').html(create_loader());
                        }
                    })
                    .done(function(response) {
                        try {
                            var json = $.parseJSON(response);
                            recargar_opcion_menu_mostrar_mensaje('seccion_formacion', json.result, json.msg);
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
        cargar_archivo($(this).attr('data-key'), "#formulario_formacion_docente");
    });
    $('#modal_censo').on('hide.bs.modal', function (e) {
		cargar_datos_menu_perfil('seccion_formacion');
		recargar_fecha_ultima_actualizacion();
		var btn_gdt = $("#btn_guardar_formacion_docente").attr('data-value');
		if($('#idc').length && btn_gdt == ""){ ///Eliminar archivo que no hayan sido asociados
			data_ajax(site_url+'/administracion/eliminar_archivos', null, null);
		}
    setTimeout(function(){
            $('#tabList a:last').tab('show');
        }, 1000);
        
		$(this).off(e);
	});
	if($('#tipo_formacion').length){
        $( "#tipo_formacion" ).change(function() {
            if($(this).val()!=""){
                data_ajax(site_url+'/perfil/subtipo_formacion_docente/'+$(this).val()+"/<?php echo ((isset($dir_tes['SUB_FOR_PRO_CVE']) && !empty($dir_tes['SUB_FOR_PRO_CVE'])) ? $dir_tes['SUB_FOR_PRO_CVE'].'?' : '?').((isset($dir_tes['CURSO_CVE']) && !empty($dir_tes['CURSO_CVE'])) ? 'curso='.$dir_tes['CURSO_CVE'] : '').((isset($dir_tes['EFP_NOMBRE_CURSO']) && !empty($dir_tes['EFP_NOMBRE_CURSO'])) ? '&nombre_curso='.$dir_tes['EFP_NOMBRE_CURSO'] : ''); ?>", null, '#capa_subtipo');
            }
        });
        <?php
        if(isset($dir_tes['TIP_FOR_PROF_CVE']) && !empty($dir_tes['TIP_FOR_PROF_CVE'])){ ?>
            data_ajax(site_url+"/perfil/subtipo_formacion_docente/"+$('#tipo_formacion').val()+"/<?php echo ((isset($dir_tes['SUB_FOR_PRO_CVE']) && !empty($dir_tes['SUB_FOR_PRO_CVE'])) ? $dir_tes['SUB_FOR_PRO_CVE'].'?' : '?').((isset($dir_tes['CURSO_CVE']) && !empty($dir_tes['CURSO_CVE'])) ? 'curso='.$dir_tes['CURSO_CVE'] : '').((isset($dir_tes['EFP_NOMBRE_CURSO']) && !empty($dir_tes['EFP_NOMBRE_CURSO'])) ? '&nombre_curso='.$dir_tes['EFP_NOMBRE_CURSO'] : ''); ?>", null, '#capa_subtipo');
        <?php } ?>
    }   
    if($('#btn_crear_tematica').length){
        $( "#btn_crear_tematica").click(function() {
            crear_tematica("#tematicas", "#capa_tematicas");
        });
    }
});
function crear_tematica(elemento, destino){
	var identificador = $(elemento).val();
	if(identificador!=""){	
		var exis = verificar_existencia(".div_tematica", identificador);
		if(exis==false){
			var texto = $(elemento+" option:selected").text();
			var html = "<div id='tematica_"+identificador+"' class='col-md-5 text-left div_tematica' data-value='"+identificador+"'><span id='remove_"+identificador+"' class='glyphicon glyphicon-remove' onclick='remover_tematica(this);'></span> "+texto+"<input type='hidden' id='tematica[]' name='tematica[]' value='"+identificador+"'></div>";
			$(destino).append(html);
			$(elemento).val("");
		} else {
			apprise('<?php echo $string_values['alert_tematica_duplicado']; ?>');
		}
	} else {
		apprise('<?php echo $string_values['alert_tematica']; ?>');
	}
}
function remover_tematica(elemento){
	apprise('<?php echo $string_values['confirmar_tematica_eliminacion']; ?>', {verify: true}, function(btnClick) {
	    if (btnClick) {
	    	$(elemento).parent().remove();
	    } else {
            return false;
        }
	});	
}

function verificar_existencia(elemento, identificador){
	var flag=0;
	$(elemento).each(function( index ) {
		var existencia = $(this).attr("data-value");
		if(identificador==existencia){
			flag++;
		}
	});
	return (flag>0) ? true : false;
}
</script>
<style type="text/css">
.div_tematica{
	border-radius: 10px;
	background-color: #ccc;
	border: 1px solid #999;
	margin: 5px;
}
.div_tematica:hover{
	background-color: #eee;
}
.div_tematica .glyphicon-remove{
	cursor: pointer;
}
</style>