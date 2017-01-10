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
                       </div>
                    </div>
                    <div class="col-md-6">
                        <label for='lbl_tipo_curso' class="control-label">
                             <?php echo $string_values['lbl_tipo_curso']; ?>
                        </label>
                        <div class="input-group">
                            <label class="registro"><?php echo isset($TIP_CUR_NOMBRE) ? $TIP_CUR_NOMBRE : ''; ?></label>
                       </div>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-md-6">
                        <label for='lbl_tutorizado_no_tuto' class="control-label">
                             <?php echo $string_values['lbl_tutorizado_no_tuto']; ?>
                        </label>
                        <div class="input-group">
                            <label class="registro"><?php $is_tutorizado = array(0 => $string_values['option_no_tutorizado'], 1 => $string_values['option_tutorizado']);
                            echo isset($is_curso_tutorizado)? $is_tutorizado[$is_curso_tutorizado] : ''; ?></label>
                       </div>
                    </div>
                    <div class="col-md-6">
                        <label for='lbl_folio' class="control-label">
                             <?php echo $string_values['lbl_folio']; ?>
                        </label>
                        <div class="input-group">
                            <label class="registro"><?php echo isset($folio_constancia) ? $folio_constancia : ''; ?></label>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-md-6">
                        <label for='lbl_rol_desempenia' class="control-label">
                             <?php echo $string_values['lbl_rol_desempenia']; ?>
                        </label>
                        <div class="input-group">
                            <label class="registro"><?php echo isset($ROL_DESEMPENIA) ? $ROL_DESEMPENIA : ''; ?></label>
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
                                <label class="registro"><?php echo (isset($fecha_inicio_pick))? $fecha_inicio_pick : ''; ?></label>
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
