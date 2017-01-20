<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <div class="">
        <div class="">
                <div class="panel-body">
                            <div class='row'>
                                <div class="col-md-6">
                                    <label for='lbl_area' class="control-label">
                                        <b class="rojo">*</b>
                                         <?php echo $string_values['lbl_area']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo (isset($AREA_NOMBRE))? $AREA_NOMBRE : ''; ?></label>
                                        <?php 
                                            /*echo $this->form_complete->create_element(array('id' => 'carea', 'type' => 'dropdown', 
                                                'options' => $carea, 
                                                'first' => array('' => $string_values['drop_area']), 
                                                'value' => (isset($carea_cve))? $carea_cve : '',
                                                'attributes' => array('name' => 'carea_name', 'class' => 'form-control', 
                                                'data-toggle' => 'tooltip', 'data-placement' => 'top', 
                                                'title' => $string_values['lbl_area'] ))); */
                                        ?>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                    <label for='lbl_nombre_materia' class="control-label">
                                         <?php echo $string_values['lbl_nombre_materia']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($nombre_materia_impartio) ? $nombre_materia_impartio : ''; ?></label>
                                        <?php 
                                            /*echo $this->form_complete->create_element(array('id' => 'nombre_materia_impartio', 
                                                'type' => 'text', 
                                                'value' => isset($nombre_materia_impartio) ? $nombre_materia_impartio : '',
                                                'attributes' => array( 
                                                'class' => 'form-control', 
                                                'placeholder' => $string_values['text_nombre_materia'], 
                                                'data-toggle' => 'tooltip', 
                                                'data-placement' => 'top', 
                                                'title' => $string_values['text_nombre_materia'] ))); */
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
                                    <label for='lbl_recibe_pago_extra' class="control-label">
                                         <?php echo $string_values['lbl_recibe_pago_extra']; ?>
                                    </label>
                                    <div class='row'>
                                        <div class="col-md-12 text-left">
                                            <label class="registro"><?php echo (isset($pago_extra) AND $pago_extra === '1') ? 'Si' : 'No' ; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for='lbl_modalidad' class="control-label">
                                         <?php echo $string_values['lbl_modalidad']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($MOD_NOMBRE) ? $MOD_NOMBRE : ''; ?></label>
                                   </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="col-md-6">
                                        <label for='lbl_anio_que_impartio_curso' class="control-label">
                                            <?php echo $string_values['lbl_anio_que_impartio_curso']; ?>
                                        </label>
                                        <div class="input-group date datepicker" id="datetimepicker_anio">
                                            <label class="registro"><?php echo $actividad_anios_dedicados_docencia; ?></label>
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
                                        </div>
                                </div>
                                <div class='col-sm-6 col-lg-6 text-center' id="fecha_inicio" style="<?php echo $mostrar_hora_fecha_duracion==='fecha_dedicadas'?'display: block':'display: none';?>">
                                    <label for='lbl_duracion_fecha_inicio' class="control-label">
                                        <?php echo $string_values['lbl_duracion_fecha_inicio']; ?>
                                    </label>
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker1" >
                                            <label class="registro"><?php echo $fecha_inicio_pick; ?></label>
                                        </div>
                                    </div>
                                </div>                                
                                <div class='col-sm-6 text-center' id="fecha_fin" style="<?php echo $mostrar_hora_fecha_duracion==='fecha_dedicadas'?'display: block':'display: none';?>">
                                    <label for='radio_duracion_fecha' class="control-label">
                                        <?php echo $string_values['lbl_duracion_fecha_final']; ?>
                                    </label>
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker2'>
                                            <label class="registro"><?php echo $fecha_fin_pick; ?></label>
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
