<?php
$this->seguridad->set_tiempo_convocatoria_null(); //Reinicia validacion de convocatoria
$this->seguridad->set_tiempo_convocatoria(null, null, $is_interseccion); //Valida paso de convocatoria y, si la validación actual es una intersección
?>

<div>
    <br>
    <?php echo $string_values['title_becas']; ?>
    <br>
</div>
<div class='row'> 
    <div class="form-group col-xs-12 col-md-12">
        <table class="table table-striped table-hover table-bordered" id="tabla_becas">
            <thead>
                <tr class="btn-default">
                    <th><?php echo $string_values['validado']; ?></th>
                    <th><?php echo $string_values['title_tab_becas_clase_beca']; ?></th>
                    <th><?php echo $string_values['title_tab_becas_fecha_inicio']; ?></th>
                    <th><?php echo $string_values['title_tab_becas_fecha_termino']; ?></th>
                    <th><?php echo $string_values['title_tab_becas_motivo_beca']; ?></th>
                    <th><?php echo $string_values['title_tab_becas_beca_interrumpida']; ?></th>
                    <th><?php echo $string_values['title_tab_becas_comprobante']; ?></th>
                    <th><?php echo $string_values['opciones']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista_becas as $key_ai => $val) {
                    $key = $val['emp_beca_cve'];
                    $key = $this->seguridad->encrypt_base64($key);
                    $idcomprobante = $val['comprobante'];
                    if (!is_null($idcomprobante)) {
                        //Btn comprobante
                        $idcomprobante = $this->seguridad->encrypt_base64($idcomprobante); //Encripta
                        $btn_comprobante = '<a href="' . site_url('administracion/ver_archivo/' . $idcomprobante) . '" target="_blank">' . $string_values['lbl_ver_comprobante'] . '</a>';
                    } else {
                        $comprobante = 0;
                        $btn_comprobante = '';
                    }
                    ///////////Inicio ver liga de validación
                    $validation_estado = (isset($val['validation_estado']) && !empty($val['validation_estado'])) ? $val['validation_estado'] : null;
                    $valido_eliminar_editar = $this->seguridad->verificar_liga_validar($val['IS_VALIDO_PROFESIONALIZACION'], $val['IS_CARGA_SISTEMA'], $validation_estado);
                    $btn_validar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm btn_validar_be" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="' . $key . '" onclick="validar_be(this);" data-valid="' . $this->seguridad->encrypt_base64($this->config->item('ACCION_GENERAL')['VALIDAR']['valor']) . '">' . $string_values['validar'] . '</button>' : '';
                    ///////////Fin ver liga de validación
                    //Crea los row de la tabla
                    echo "<tr id='id_row_" . $key_ai . "' data-keyrow=" . $key_ai . ">";
                    echo '<td class="text-center">' . $this->seguridad->html_verificar_evaluado_issistema_valido($val['IS_VALIDO_PROFESIONALIZACION'], $val['IS_CARGA_SISTEMA'], $validation_estado) . '</td>';
                    echo "<td>" . $val['nom_beca'] . "</td>";
                    echo "<td>" . $val['fecha_inicio'] . "</td>";
                    echo "<td>" . $val['fecha_fin'] . "</td>";
                    echo "<td>" . $val['nom_motivo_beca'] . "</td>";
                    echo "<td>" . $val['msj_beca_interrumpida'] . "</td>";
                    echo "<td>" . $btn_comprobante . "</td>";
                    echo '<td><button type="button" class="btn btn-link btn-sm btn_ver_be" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="' . $key . '" onclick="ver_be(this);">' .
                    $string_values['ver'] .
                    '</button>';
                    echo '' . $btn_validar . '</td>'; ///Botón validar
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
