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
                    * <?php echo $string_values['t_h_tipo_curso']; ?>:
                </label>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
                <div class="form-group">
                    <div class="input-group">
                        <?php
                        echo $this->form_complete->create_element(array('id'=>'tipo_curso', 'type'=>'dropdown', 'value'=>$dir_tes['TIP_CURSO_CVE'], 'options'=>$catalogos['ctipo_curso'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['t_h_tipo_curso'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['t_h_tipo_curso'])));
                        ?>                      
                    </div>
                </div>
                <?php echo form_error_format('tipo_curso'); ?>
            </div>
        </div>
        <div id="capa_curso" class="row">
        </div>
        <?php echo form_error_format('curso'); ?>
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
                    if(isset($dir_tes['EC_DURACION']) && !empty($dir_tes['EC_DURACION'])){
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
//                                                    'disabled'=> '',
//                                                        'checked'=>"checked",
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
                    if(isset($dir_tes['EC_FCH_INICIO']) && !empty($dir_tes['EC_FCH_INICIO']) && isset($dir_tes['EC_FCH_FIN']) && !empty($dir_tes['EC_FCH_FIN'])){
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
//                                                    'disabled'=> '',
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
                                'value' => $dir_tes['EC_DURACION'],
                                'attributes'=>array(
                                'class'=>'form-control',
                                'placeholder'=>$string_values['radio_duracion_horas'],
                                'min'=> '0',
                                'max'=> '100',
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>$string_values['radio_duracion_horas'],
//                                                    'style'=>"display: none"
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
                                //'value' => $dir_tes['EC_FCH_INICIO'],
                                'attributes'=>array(
                                'class'=>'form-control',
                                //'placeholder'=>$string_values['lbl_duracion_fecha_inicio'],
                                'data-toggle'=>'tooltip',
                                'title'=>$string_values['lbl_duracion_fecha_inicio'],
//                                                    'style'=>"display: none"
                                )
                            )
                        );
                        $js_fch_ini = (isset($dir_tes['EC_FCH_INICIO']) && !empty($dir_tes['EC_FCH_INICIO'])) ? "defaultDate:moment('".$dir_tes['EC_FCH_INICIO']."')" : '';
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
                                //'value' => $dir_tes['EC_FCH_FIN'],
                                'attributes'=>array(
                                'class'=>'form-control',
                                //'placeholder'=>$string_values['lbl_duracion_fecha_final'],
                                'data-toggle'=>'tooltip',
                                'title'=>$string_values['lbl_duracion_fecha_final'],
//                                                    'style'=>"display: none"
                                )
                            )
                        );
                        $js_fch_fin = (isset($dir_tes['EC_FCH_FIN']) && !empty($dir_tes['EC_FCH_FIN'])) ? "defaultDate:moment('".$dir_tes['EC_FCH_FIN']."')" : '';
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
	            <button id="btn_guardar_comision_academica" type="button" class="btn btn-success" data-value="<?php echo $identificador; ?>">
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
        viewMode: "years"
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
        <?php echo $js_fch_fin; ?>
    });
    if($('#btn_guardar_comision_academica').length){
        $('#btn_guardar_comision_academica').on('click', function() {
            if($('#idc').length){ //Validar carga de archivo
                if($("#userfile").val()==""){ //Validar carga de archivo
                    data_ajax(site_url+'/validacion_censo_profesores/comision_academica_formulario/<?php echo $tipo_comision; ?>/<?php echo $identificador; ?>', '#formulario_comision_academica', '#modal_content');
                } else {
                    $('#error_carga_archivo').html(html_message("<?php echo $string_values['falta_carga_archivo']; ?>", 'danger'));
                }
            } else {
                $('#error_carga_archivo').html(html_message("<?php echo $string_values['falta_carga_archivo']; ?>", 'danger'));
            }
        });
    }
    if($('#tipo_curso').length){
        $( "#tipo_curso" ).change(function() {
            if($(this).val()!=""){
                data_ajax(site_url+'/validacion_censo_profesores/curso/'+$(this).val(), null, '#capa_curso');
            }
        });
        <?php
        if(isset($dir_tes['TIP_CURSO_CVE']) && !empty($dir_tes['TIP_CURSO_CVE'])){ ?>
            data_ajax(site_url+"/validacion_censo_profesores/curso/"+$('#tipo_curso').val()+"/<?php echo ((isset($dir_tes['CURSO_CVE']) && !empty($dir_tes['CURSO_CVE'])) ? $dir_tes['CURSO_CVE'] : '')?>", null, '#capa_curso');
        <?php } ?>
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