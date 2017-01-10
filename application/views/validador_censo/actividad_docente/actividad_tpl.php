<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//    pr($tipo_msg);
$colapso_div_ejercicio_profesional = 'collapse in';
//        $colapso_div_ejercicio_profesional = 'collapse';
//        pr($datos_tabla_actividades_docente);
//        pr($actividades_docente_objet);
echo js('validacion_censo_profesores/actividad_docente.js');
$this->seguridad->set_tiempo_convocatoria_null(); //Reinicia validacion de convocatoria
$this->seguridad->set_tiempo_convocatoria(null, null, $is_interseccion); //Valida paso de convocatoria y, si la validación actual es una intersección
?>

<style type="text/css">
    .button-padding {padding-top: 30px}
    .rojo {color: #a94442}.panel-body table{color: #000} .pinfo{padding-left:20px; padding-bottom: 20px;}
</style>

<div class="list-group">
    <div class="list-group-item">
        <div class="panel-body">
            <div>
                <br>
                <h4><?php echo $string_values['tl_titulo']; ?></h4>
                <br>
            </div>
            <div class='row'>
                <div class="form-group col-xs-5 col-md-5">
                    <label for='perfil_anios_dedicados_docencia' class="control-label">
                        <?php echo $string_values['lbl_anios_dad']; ?>:
                    </label>
                    <div class="input-group">
                        <label class="registro"><?php echo $actividad_docente['ANIOS_DEDICADOS']; ?></label>
                    </div>
                </div>

                <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                    <label for='lbl_ejercicio_pd' class="control-label">
                        <?php echo $string_values['lbl_ejercicio_pd']; ?>:
                    </label>
                    <div class="input-group">
                        <label class="registro"><?php echo $actividad_docente['EJE_PRE_NOMBRE']; ?></label>
                    </div>
                </div>

            </div>
            <?php if (isset($datos_tabla_actividades_docente)) { ?>
                <div class="row" >
                    <div id="tabla_actividades_docente" class="table-responsive">
                        <!--Mostrará la tabla de actividad docente --> 
                        <table class="table table-striped table-hover table-bordered" id="tabla_actividades">
                            <thead>
                                <tr class='btn-default'>
                                    <th><?php echo $string_values['validado']; ?></th>
                                    <th><?php echo $string_values['tab_titulo_pro_salud_cur_principal'] ?></th>
                                    <th><?php echo $string_values['tab_titulo_pro_salud_actividad'] ?></th>
                                    <th><?php echo $string_values['tab_titulo_pro_salud_anio'] ?></th>
                                    <th><?php echo $string_values['tab_titulo_pro_salud_duracion'] ?></th>
                                    <th><?php echo $string_values['tab_titulo_pro_salud_fecha_inicio'] ?></th>
                                    <th><?php echo $string_values['tab_titulo_pro_salud_fecha_fin'] ?></th>
                                    <th><?php echo $string_values['tab_titulo_comprobante'] ?></th>
                                    <th><?php echo $string_values['opciones'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //Generará la tabla que muestrá las actividades del docente
                                foreach ($datos_tabla_actividades_docente as $key => $value) {
                                    $is_cur_principal_igual = ($curso_principal === $value['cve_actividad_docente']) ? 1 : 0;
                                    $is_tp_actividad_igual = ($curso_principal_entidad_contiene === $value['ta_cve']) ? 1 : 0;
                                    $is_cur_principal = ($is_cur_principal_igual === 1 AND $is_tp_actividad_igual === 1) ? 1 : 0;
                                    if ($is_cur_principal) {//Muestra icono de valido
                                        $checked = '<span class="glyphicon glyphicon-ok class_validacion_registro" data-original-title="Curso principal de la actividad"></span>';
                                    } else {
                                        $checked = $this->seguridad->html_verificar_evaluado_issistema_valido($value['IS_VALIDO_PROFESIONALIZACION'], $value['IS_CARGA_SISTEMA'], $value['validation_estado']);
                                    }
//                                    pr($checked);
                                    $idcomprobante = $value['comprobante'];
                                    if (!is_null($idcomprobante)) {//Valida existencia del comprobante
                                        $idcomprobante = $this->seguridad->encrypt_base64($idcomprobante); //Encripta
                                        $btn_comprobante = '<a href="' . site_url('administracion/ver_archivo/' . $idcomprobante) . '" target="_blank">' . $string_values['lbl_ver_comprobante'] . '</a>';
                                    } else {
                                        $comprobante = 0;
                                        $btn_comprobante = '';
                                    }
                                    $id = $this->seguridad->encrypt_base64($value['cve_actividad_docente']);
                                    //$btn_validar = ($this->seguridad->verificar_liga_validar($value['IS_VALIDO_PROFESIONALIZACION'])) ?                                                '<button type="button" class="btn btn-link btn-sm btn_validar_ad" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="'.$id.'" onclick="validar_ad(this, '.$value['ta_cve'].');" data-valid="'.$this->seguridad->encrypt_base64($this->config->item('ACCION_GENERAL')['VALIDAR']['valor']).'">'.$string_values['validar'].'</button>' : '';
                                    ///////////Inicio ver liga de validación
                                    $valido_eliminar_editar = $this->seguridad->verificar_liga_validar($value['IS_VALIDO_PROFESIONALIZACION'], $value['IS_CARGA_SISTEMA']);
//                                    pr($valido_eliminar_editar);
                                    $btn_validar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm btn_validar_ad" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="' . $id . '" onclick="validar_ad(this, ' . $value['ta_cve'] . ');" data-valid="' . $this->seguridad->encrypt_base64($this->config->item('ACCION_GENERAL')['VALIDAR']['valor']) . '">' . $string_values['validar'] . '</button>' : '';
                                    ///////////Fin ver liga de validación
                                    echo "<tr data-keyrow=" . $key . ">";
//                                        echo '<td class="text-center">'.$this->seguridad->html_verificar_validacion_registro($value['validation'], $value['IS_VALIDO_PROFESIONALIZACION'], $validation_estado, $validation_estado_anterior).'</td>';
                                    echo "<td >" . $checked . "</td>";
                                    echo "<td class='class_titulo'>" . $value['nombre_tp_actividad'] . "</td>";
                                    echo "<td >" . $value['nombre_tp_actividad'] . "</td>";
                                    echo "<td >" . $value['anio'] . "</td>";
                                    echo "<td >" . $value['duracion'] . "</td>";
                                    echo "<td >" . $value['fecha_inicio'] . "</td>";
                                    echo "<td>" . $value['fecha_fin'] . "</td>";
                                    echo "<td>" . $btn_comprobante . "</td>";
                                    echo '<td>'
                                    . '<button type="button" class="btn btn-link btn-sm btn_ver_ad"'
                                    . 'aria-expanded="false" data-toggle="modal" '
                                    . 'data-target="#modal_censo" data-value="' . $id . '" '
                                    . 'onclick="ver_ad(this, ' . $value['ta_cve'] . ');">' .
                                    $string_values['ver'] .
                                    '</button>'
                                    . $btn_validar;
                                    echo '</td>';
                                    echo "</tr>";
                                    //data-tacve ="' . $value['ta_cve'] . '"'
                                    //. 'data-cvead ="' . $value['cve_actividad_docent
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div id='mensaje_error_div' class='alert'>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span id='mensaje_error'><?php echo $string_values['alert_no_existe_actividad_principal']; ?></span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
