<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <div class="">
        <div class="">
                <div class="panel-body">
                            <div class='row'>
                                <!--<div class="form-group col-xs-10 col-md-10 col-md-offset-1 col-md-offset-1">-->
                                <div class="col-md-6">
                                    <label for='lbl_curso' class="control-label">
                                        <?php echo $string_values['lbl_curso']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($nombre_curso) ? $nombre_curso : ''; ?></label>
                                        <!-- <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-education"> </span>
                                        </span> -->
                                        <?php 
                                            /*echo $this->form_complete->create_element(array('id' => 'nombre_curso', 
                                                'type' => 'text', 
                                                'value' => isset($nombre_curso) ? $nombre_curso : '',
                                                'attributes' => array( 
                                                'class' => 'form-control', 
                                                'placeholder' => $string_values['text_name_curso_imparte'], 
                                                'data-toggle' => 'tooltip', 
                                                'data-placement' => 'top', 
                                                'title' => $string_values['text_name_curso_imparte'] ))); */
                                        ?>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                     <label for='lbl_rol_desempenia' class="control-label">
                                         <?php echo $string_values['lbl_rol_desempenia']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($ROL_DESEMPENIA) ? $ROL_DESEMPENIA : ''; ?></label>
                                        <?php 
                                            /*echo $this->form_complete->create_element(array('id' => 'crol_desempenia', 'type' => 'dropdown', 
                                                'options' => $crol_desempenia, 
                                                'first' => array('' => $string_values['drop_rol_desempenia']), 
                                                'value' => (isset($crol_desempenia_cve))? $crol_desempenia_cve : '',
                                                'attributes' => array('name' => 'categoria', 'class' => 'form-control', 
                                                'placeholder' => '', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 
                                                'title' => $string_values['lbl_rol_desempenia'] ))); */
                                        ?>
                                   </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="col-md-6">
                                    <label for='lbl_institucion_edu_avala' class="control-label">
                                         <?php echo $string_values['lbl_institucion_edu_avala']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($IA_NOMBRE) ? $IA_NOMBRE : ''; ?></label>
                                        <?php 
                                            /*echo $this->form_complete->create_element(array('id' => 'cinstitucion_avala', 'type' => 'dropdown', 
                                                'options' => $cinstitucion_avala, 
                                                'first' => array('' => $string_values['drop_institucion_edu_avala']), 
                                                'value' => (isset($cinstitucion_avala_cve))? $cinstitucion_avala_cve : '',
                                                'attributes' => array('name' => 'categoria', 'class' => 'form-control', 
                                                'placeholder' => $string_values['lbl_institucion_edu_avala'], 'data-toggle' => 'tooltip', 'data-placement' => 'top', 
                                                'title' => $string_values['lbl_institucion_edu_avala'] ))); */
                                        ?>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                    <label for='lbl_recibe_pago_extra' class="control-label">
                                         <?php echo $string_values['lbl_recibe_pago_extra']; ?>
                                    </label>
                                    <div class='row'>
                                        <div class="col-md-12 text-left">
                                            <label class="registro"><?php echo (isset($pago_extra) AND $pago_extra === '1') ? 'Si' : 'No' ; ?></label>
                                                <?php
                                                /*echo $this->form_complete->create_element(
                                                array('id'=>'pago_extra', 'type'=>'radio',
                                                        'value' => '1',
                                                        'attributes'=>array(
                                                        'checked'=>(isset($pago_extra) AND $pago_extra === '1')? "checked" : "",
                                                        'class'=>'radio-inline m-r-sm',
                                                        'title'=> $string_values['radio_duracion_horas'],
                                                        )
                                                    )
                                                );*/
                                                ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="col-md-6">
                                    <label for='lbl_licenciatura' class="control-label">
                                         <?php echo $string_values['lbl_licenciatura']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($LIC_NOMBRE) ? $LIC_NOMBRE : ''; ?></label>
                                        <?php 
                                            /*echo $this->form_complete->create_element(array('id' => 'licenciatura', 'type' => 'dropdown', 
                                                'options' => $licenciatura, 
                                                'first' => array('' => $string_values['drop_licenciatura']), 
                                                'value' => (isset($licenciatura_cve))? $licenciatura_cve : '',
                                                'attributes' => array('name' => 'licenciatura_name', 'class' => 'form-control', 
                                                'placeholder' => $string_values['lbl_licenciatura'], 'data-toggle' => 'tooltip', 
                                                'data-placement' => 'top', 
                                                'title' => $string_values['lbl_licenciatura'] ))); */
                                        ?>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                    <label for='lbl_modalidad' class="control-label">
                                         <?php echo $string_values['lbl_modalidad']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($MOD_NOMBRE) ? $MOD_NOMBRE : ''; ?></label>
                                        <?php 
                                            /*echo $this->form_complete->create_element(array('id' => 'cmodalidad', 'type' => 'dropdown', 
                                                'options' => $cmodalidad, 
                                                'first' => array('' => $string_values['drop_modalidad']), 
                                                'value' => (isset($cmodalidad_cve))? $cmodalidad_cve : '',
                                                'attributes' => array('name' => 'modalidad_name', 'class' => 'form-control', 
                                                'placeholder' => $string_values['lbl_modalidad'], 'data-toggle' => 'tooltip', 'data-placement' => 'top', 
                                                'title' => $string_values['lbl_modalidad'] ))); */
                                        ?>
                                   </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="col-md-6">
                                        <label for='lbl_anio_que_impartio_curso' class="control-label">
                                            <?php echo $string_values['lbl_anio_que_impartio_curso']; ?>
                                        </label>
                                        <div class="input-group date datepicker" id="datetimepicker_anio">
                                            <label class="registro"><?php echo isset($actividad_anios_dedicados_docencia) ? $actividad_anios_dedicados_docencia : ''; ?></label>
                                        <?php
                                            /*echo $this->form_complete->create_element(
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
                                            );*/
                                        ?>
                                        </div>
                                </div>
                            </div>
                        <br>
                            <div class='row'>
                                <div class="col-md-12 text-center">
                                    <label for='lbl_duracion' class="control-label">
                                         <?php echo $string_values['lbl_duracion']; ?>
                                    </label>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-6 col-lg-6' id="div_horas_dedicadas" style="<?php echo $mostrar_hora_fecha_duracion==='hora_dedicadas'?'display: block':'display: none';?>">
                                        <label for='lbl_duracion_horas' class="control-label">
                                            <?php echo $string_values['radio_duracion_horas']; ?>
                                        </label>
                                        <div class="input-group">
                                            <label class="registro"><?php echo (isset($hora_dedicadas))?$hora_dedicadas:''; ?></label>
                                        <?php
                                            /*echo $this->form_complete->create_element(
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
                                            );*/
                                        ?>
                                        </div>
                                </div>
                                <div class='col-sm-6 col-lg-6 text-center' id="fecha_inicio" style="<?php echo $mostrar_hora_fecha_duracion==='fecha_dedicadas'?'display: block':'display: none';?>">
                                    <label for='lbl_duracion_fecha_inicio' class="control-label">
                                        <?php echo $string_values['lbl_duracion_fecha_inicio']; ?>
                                    </label>
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker1" >
                                            <label class="registro"><?php echo (isset($fecha_inicio_pick))? $fecha_inicio_pick : ''; ?></label>
                                            <?php
                                            /*echo $this->form_complete->create_element(
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
                                            );*/
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-sm-6 text-center' id="fecha_fin" style="<?php echo $mostrar_hora_fecha_duracion==='fecha_dedicadas'?'display: block':'display: none';?>">
                                    <label for='radio_duracion_fecha' class="control-label">
                                        <?php echo $string_values['lbl_duracion_fecha_final']; ?>
                                    </label>
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker2'>
                                            <label class="registro"><?php echo (isset($fecha_fin_pick))? $fecha_fin_pick : ''; ?></label>
                                            <?php
                                            /*echo $this->form_complete->create_element(
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
                                            );*/
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <?php echo $formulario_carga_archivo; ?>
                            <?php echo $formulario_validacion; ?>
                    </div>
                </div>
            </div>
