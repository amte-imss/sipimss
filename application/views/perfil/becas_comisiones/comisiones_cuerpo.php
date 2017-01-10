<?php
$this->seguridad->set_tiempo_convocatoria_null(); //Reinicia validacion de convocatoria
$this->seguridad->set_tiempo_convocatoria(); //Valida paso de convocatoria
?>
<div class="list-group">
    <div>
        <br>
        <?php echo $string_values['title_comisiones']; ?>
        <br>
    </div>
    <div class="list-group-item imss-no-border">      
        <?php if ($this->seguridad->verificar_liga_validar()) { ?>
            <div class='row'>
                <div class="form-group col-xs-4 col-md-4 col-md-offset-8">
                    <button type="button" class="btn btn-success btn-lg" id="btn_gregar_comision_modal" data-toggle="modal" data-target="#modal_censo">
                        <?php echo $string_values['btn_agregar_comision']; ?>
                    </button>
                </div>
            </div>
        <?php } ?>
        <div class='row'> 
            <div class="form-group col-xs-12 col-md-12">
                <table class="table table-striped table-hover table-bordered" id="tabla_becas">
                    <thead>
                        <tr class="btn-default">
                            <th><?php echo $string_values['validado']; ?></th>
                            <th><?php echo $string_values['title_tab_comision_tipo_comision']; ?></th>
                            <th><?php echo $string_values['title_tab_comision_fecha_inicio']; ?></th>
                            <th><?php echo $string_values['title_tab_comision_fecha_termino']; ?></th>
                            <th><?php echo $string_values['title_tab_comision_comprobante']; ?></th>
                            <th><?php echo $string_values['title_tab_comision_editar']; ?></th>
                            <th><?php echo $string_values['title_tab_comision_eliminar']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
//                            pr($lista_becas);
                        foreach ($lista_comisiones as $key_ai => $val) {
                            $key = $this->seguridad->encrypt_base64($val['emp_comision_cve']);
                            $idcomprobante = $val['comprobante'];
                            if (!is_null($idcomprobante)) {
                                //Btn comprobante
                                $idcomprobante = $this->seguridad->encrypt_base64($idcomprobante); //Encripta
                                $btn_comprobante = '<a href="' . site_url('administracion/ver_archivo/' . $idcomprobante) . '" target="_blank">' . $string_values['lbl_ver_comprobante'] . '</a>';
                            } else {
                                $comprobante = 0;
                                $btn_comprobante = '';
                            }
                            $valido_eliminar_editar = $this->seguridad->verificar_liga_validar($val['IS_VALIDO_PROFESIONALIZACION'], $val['IS_VALIDO_PROFESIONALIZACION'], $val['validation_estado']);
//                            $validation_estado = (isset($val['validation_estado']) && !empty($val['validation_estado'])) ? $val['validation_estado'] : null;
                            $btn_eliminar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm" id="btn_editar_mat_educativo" data-idrow ="' . $key_ai . '" data-comisioncve ="' . $key . '" data-comprobantecve ="' . $idcomprobante . '" onclick="funcion_eliminar_reg_comision(this)" >' . $string_values['tab_titulo_eliminar'] . '</button>' : '';
                            $btn_editar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm" data-idrow ="' . $key_ai . '" data-comisioncve ="' . $key . '" data-comprobantecve ="' . $idcomprobante . '" data-toggle="modal" data-target="#modal_censo" onclick="funcion_editar_reg_comision(this)" >' . $string_values['tab_titulo_editar'] . '</button>' : '';
                            //Crea los row de la tabla
                            echo "<tr id='id_row_" . $key_ai . "' data-keyrow=" . $key_ai . ">
                                <td class='text-center'>" . $this->seguridad->html_verificar_valido_profesionalizacion($val['IS_VALIDO_PROFESIONALIZACION'], $val['IS_CARGA_SISTEMA'], $val['validation_estado']) . "</td>";
                            echo "<td>" . $val['nom_tipo_comision'] . "</td>";
                            echo "<td>" . $val['fecha_inicio'] . "</td>";
                            echo "<td>" . $val['fecha_fin'] . "</td>";
                            echo "<td>" . $btn_comprobante . "</td>";
                            echo '<td>
                                <button type="button" class="btn btn-link btn-sm btn_ver_co" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="' . $key . '" onclick="ver_co(this);">' .
                            $string_values['ver'] .
                            '</button>
                                ' . $btn_editar . "</td>";
                            echo "<td>" . $btn_eliminar . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>