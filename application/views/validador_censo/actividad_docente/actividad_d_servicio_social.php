<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <div class="">
        <div class="">
                <div class="panel-body">
                            <div class='row'>
                                  <div class="col-md-6">
                                     <label for='lbl_rol_desempenia' class="control-label">
                                         <b class="rojo">*</b>
                                         <?php echo $string_values['lbl_rol_desempenia']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($ROL_DESEMPENIA) ? $ROL_DESEMPENIA : ''; ?></label>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                    <label for='lbl_institucion_edu_avala' class="control-label">
                                         <?php echo $string_values['lbl_institucion_edu_avala']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($IA_NOMBRE) ? $IA_NOMBRE : ''; ?></label>
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
                                    <label for='lbl_licenciatura' class="control-label">
                                         <?php echo $string_values['lbl_licenciatura']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($LIC_NOMBRE) ? $LIC_NOMBRE : ''; ?></label>
                                   </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="col-md-6">
                                    <label for='lbl_modalidad' class="control-label">
                                         <?php echo $string_values['lbl_modalidad']; ?>
                                    </label>
                                    <div class="input-group">
                                        <label class="registro"><?php echo isset($MOD_NOMBRE) ? $MOD_NOMBRE : ''; ?></label>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                        <label for='lbl_anio_que_impartio_curso' class="control-label">
                                            <?php echo $string_values['lbl_anio_que_impartio_curso']; ?>
                                        </label>
                                        <div class="input-group date datepicker" id="datetimepicker_anio">
                                            <label class="registro"><?php echo isset($actividad_anios_dedicados_docencia) ? $actividad_anios_dedicados_docencia : ''; ?></label>
                                        </div>
                                </div>
                            </div>
                        <br>
                            <div class='row'>
                                <div class='col-sm-12 text-center' id="fecha_inicio">
                                    <label for='lbl_periodo' class="control-label">
                                        <?php echo $string_values['lbl_periodo']; ?>
                                    </label>
                                </div>
                            </div>
                        <br>
                            <div class='row'>
                                <div class='col-sm-6' id="fecha_inicio">
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker1" >
                                            <label class="registro"><?php echo (isset($periodo_fecha_inicio_pick))? $periodo_fecha_inicio_pick : ''; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-sm-6 ' id="fecha_fin">
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker2'>
                                            <label class="registro"><?php echo (isset($periodo_fecha_fin_pick))? $periodo_fecha_fin_pick : ''; ?></label>
                                        </div>
                                    </div>
                                    <?php echo form_error_format('periodo_fecha_fin_pick'); ?>
                                </div>
                            </div>
                        <br>
                        <?php echo $formulario_carga_archivo; ?>
                        <?php echo $formulario_validacion; ?>
                </div>
            </div>
        </div>
