<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <script type='text/javascript'>
       $(function () {
        $('#datetimepicker1').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'YYYY-MM-DD',
            locale: 'es',
            useCurrent: false,
            minDate: moment("<?php echo $this->config->item('minDate'); ?>"),
            maxDate: 'now'
        });
        $('#datetimepicker2').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'YYYY-MM-DD',
            locale: 'es',
            useCurrent: false,
            minDate: moment("<?php echo $this->config->item('minDate'); ?>"),
            maxDate: 'now'
        });

        $("#datetimepicker_anio").datetimepicker({
            format: "YYYY", // Notice the Extra space at the beginning
            viewMode: "years",
            minDate: moment("<?php echo $this->config->item('minDate'); ?>"),
            maxDate : 'now'
        });
        $("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });
    });
    </script>
    <div class="list-group">
        <div class="list-group-item">
                <div class="panel-body">
                            <div class='row'>
                                <div class="col-md-6">
                                    <label for='lbl_curso' class="control-label">
                                        <b class="rojo">*</b>
                                         <?php echo $string_values['lbl_curso']; ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-education"> </span>
                                        </span>
                                        <?php 
                                            echo $this->form_complete->create_element(array('id' => 'nombre_curso', 
                                                'type' => 'text', 
                                                'value' => isset($nombre_curso) ? $nombre_curso : '',
                                                'attributes' => array( 
                                                'class' => 'form-control', 
                                                'placeholder' => $string_values['text_name_curso_imparte'], 
                                                'data-toggle' => 'tooltip', 
                                                'data-placement' => 'top', 
                                                'title' => $string_values['text_name_curso_imparte'] ))); 
                                        ?>
                                   </div>
                                   <?php   echo form_error_format('nombre_curso'); ?>
                                </div>
                                <div class="col-md-6">
                                     <label for='lbl_rol_desempenia' class="control-label">
                                         <b class="rojo">*</b>
                                         <?php echo $string_values['lbl_rol_desempenia']; ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-user"> </span>
                                        </span>
                                        <?php 
                                            echo $this->form_complete->create_element(array('id' => 'crol_desempenia', 'type' => 'dropdown', 
                                                'options' => $crol_desempenia, 
                                                'first' => array('' => $string_values['drop_rol_desempenia']), 
                                                'value' => (isset($crol_desempenia_cve))? $crol_desempenia_cve : '',
                                                'attributes' => array('name' => 'categoria', 'class' => 'form-control', 
                                                'placeholder' => '', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 
                                                'title' => $string_values['lbl_rol_desempenia'] ))); 
                                        ?>
                                   </div>
                                   <?php   echo form_error_format('crol_desempenia'); ?>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="col-md-6">
                                    <label for='lbl_institucion_edu_avala' class="control-label">
                                        <b class="rojo">*</b>
                                         <?php echo $string_values['lbl_institucion_edu_avala']; ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-oil"> </span>
                                        </span>
                                        <?php 
                                            echo $this->form_complete->create_element(array('id' => 'cinstitucion_avala', 'type' => 'dropdown', 
                                                'options' => $cinstitucion_avala, 
                                                'first' => array('' => $string_values['drop_institucion_edu_avala']), 
                                                'value' => (isset($cinstitucion_avala_cve))? $cinstitucion_avala_cve : '',
                                                'attributes' => array('name' => 'categoria', 'class' => 'form-control', 
                                                'placeholder' => $string_values['lbl_institucion_edu_avala'], 'data-toggle' => 'tooltip', 'data-placement' => 'top', 
                                                'title' => $string_values['lbl_institucion_edu_avala'] ))); 
                                        ?>
                                   </div>
                                   <?php   echo form_error_format('cinstitucion_avala'); ?>
                                </div>
                                <div class="col-md-6">
                                    <label for='lbl_recibe_pago_extra' class="control-label">
                                        <b class="rojo">*</b>
                                         <?php echo $string_values['lbl_recibe_pago_extra']; ?>
                                    </label>
                                    <div class='row'>
                                        <div class="col-md-6 text-right">
                                            <label>
                                                <?php
                                                echo $this->form_complete->create_element(
                                                array('id'=>'pago_extra', 'type'=>'radio',
                                                        'value' => '1',
                                                        'attributes'=>array(
                                                        'checked'=>(isset($pago_extra) AND $pago_extra === '1')? "checked" : "",
                                                        'class'=>'radio-inline m-r-sm',
                                                        'title'=> $string_values['radio_duracion_horas'],
                                                        )
                                                    )
                                                );
                                                ?>
                                                Si
                                            </label>
                                        </div>
                                        <div class="col-md-6 text-left">
                                            <label>
                                                <?php
                                                echo $this->form_complete->create_element(
                                                array('id'=>'pago_extra', 'type'=>'radio',
                                                        'value' => '0',
                                                        'attributes'=>array(
                                                        'checked'=>(isset($pago_extra) AND $pago_extra === '0')? "checked" : "",
                                                        'class'=>'radio-inline m-r-sm',
                                                        'title'=> $string_values['radio_duracion_horas'],
                                                        )
                                                    )
                                                );
                                                ?>
                                                No
                                            </label>
                                        </div>
                                    </div>
                                   <?php   echo form_error_format('pago_extra'); ?>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="col-md-6">
                                    <label for='lbl_modalidad' class="control-label">
                                         <b class="rojo">*</b>
                                         <?php echo $string_values['lbl_modalidad']; ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-user"> </span>
                                        </span>
                                        <?php 
                                            echo $this->form_complete->create_element(array('id' => 'cmodalidad', 'type' => 'dropdown', 
                                                'options' => $cmodalidad, 
                                                'first' => array('' => $string_values['drop_modalidad']), 
                                                'value' => (isset($cmodalidad_cve))? $cmodalidad_cve : '',
                                                'attributes' => array('name' => 'modalidad_name', 'class' => 'form-control', 
                                                'placeholder' => $string_values['lbl_modalidad'], 'data-toggle' => 'tooltip', 'data-placement' => 'top', 
                                                'title' => $string_values['lbl_modalidad'] ))); 
                                        ?>
                                   </div>
                                   <?php   echo form_error_format('cmodalidad'); ?>
                                </div>
                                <div class="col-md-6">
                                        <label for='lbl_anio_que_impartio_curso' class="control-label">
                                            <b class="rojo">*</b>
                                            <?php echo $string_values['lbl_anio_que_impartio_curso']; ?>
                                        </label>
                                        <div class="input-group date datepicker" id="datetimepicker_anio">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"> </span>
                                        </span>
                                        <?php
                                            echo $this->form_complete->create_element(
                                            array('id'=>'actividad_anios_dedicados_docencia','type'=>'text',
                                                    'value' => (isset($actividad_anios_dedicados_docencia))?$actividad_anios_dedicados_docencia:'',
                                                    'attributes'=>array(
                                                    'class'=>'form-control',
                                                    'placeholder'=>$string_values['lbl_anio_que_impartio_curso'],
                                                    'min'=> '1950',
                                                    'max'=> '2050',
                                                    'data-toggle'=>'tooltip',
                                                    'data-placement'=>'bottom',
                                                    'title'=>$string_values['lbl_anio_que_impartio_curso'],
                                                    )
                                                )
                                            );
                                        ?>
                                        </div>
                                        <?php echo form_error_format('actividad_anios_dedicados_docencia'); ?>
                                </div>
                            </div>
                        <br>
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
                                        echo $this->form_complete->create_element(
                                        array('id'=>'duracion', 'type'=>'radio',
                                                'value' => 'hora_dedicadas',
                                                'attributes'=>array(
                                                'class'=>'radio-inline m-r-sm',
                                                'title'=> $string_values['radio_duracion_horas'],
                                                'checked'=>(isset($duracion) AND $duracion === "hora_dedicadas")?"checked":"",
                                                'onchange' =>"mostrar_horas_fechas('block')"    
                                                )
                                            )
                                        );
                                        echo $string_values['radio_duracion_horas'];
                                        ?>
                                    </label>
                                </div>
                                <div class="col-md-4 text-left">
                                    <label>
                                        <?php
                                       echo $this->form_complete->create_element(
                                       array('id'=>'duracion', 'type'=>'radio',
                                               'value' => 'fecha_dedicadas',
                                               'attributes'=>array(
                                               'class'=>'radio-inline m-r-sm',
                                               'title'=> $string_values['radio_duracion_fecha'],
                                               'checked'=>(isset($duracion) AND $duracion === "fecha_dedicadas")?"checked":"",
                                               'onchange' =>"mostrar_horas_fechas('none')"    
                                               )
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
                                                    'value' => (isset($hora_dedicadas))?$hora_dedicadas:'',
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
                                        <div class="input-group date" id="datetimepicker1" >
                                            <?php
                                            echo $this->form_complete->create_element(
                                            array('id'=>'fecha_inicio_pick','type'=>'text',
                                                    'value' => (isset($fecha_inicio_pick))? $fecha_inicio_pick : '',
                                                    'attributes'=>array(
                                                    'class'=>'form-control',
                                                    'placeholder'=>$string_values['lbl_duracion_fecha_inicio'],
                                                    'data-toggle'=>'tooltip',
                                                    'title'=>$string_values['lbl_duracion_fecha_inicio'],
//                                                    'style'=>"display: none"
                                                    )
                                                )
                                            );
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
                                        <div class='input-group date' id='datetimepicker2'>
                                            <?php
                                            echo $this->form_complete->create_element(
                                            array('id'=>'fecha_fin_pick','type'=>'text',
                                                    'value' => (isset($fecha_fin_pick))? $fecha_fin_pick : '',
                                                    'attributes'=>array(
                                                    'class'=>'form-control',
                                                    'placeholder'=>$string_values['lbl_duracion_fecha_final'],
                                                    'data-toggle'=>'tooltip',
                                                    'title'=>$string_values['lbl_duracion_fecha_final'],
//                                                    'style'=>"display: none"
                                                    )
                                                )
                                            );
                                            ?>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <?php echo form_error_format('fecha_fin_pick'); ?>
                                </div>
                            </div>
                        <br>
                            <?php 
                                if(isset($formulario_carga_comprobante)){
                                    echo $formulario_carga_comprobante;
                                }
                            ?>
                            
                    </div>
                </div>
                <?php if(isset($pie_pag)){ echo $pie_pag; }?>
            </div>
    
    