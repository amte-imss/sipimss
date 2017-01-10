<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->seguridad->set_tiempo_convocatoria_null(); //Reinicia validacion de convocatoria
$this->seguridad->set_tiempo_convocatoria(); //Valida paso de convocatoria
?>

<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/perfil/investigacion_docente.js"></script>

<!-- Inicio informacion personal -->


<div class="list-group">

    <div class="list-group-item">

        <div class="panel-body">
            <div>
                <br>
                <h4>Investigación </h4>
                <br>
            </div>
            <?php if ($this->seguridad->verificar_liga_validar()) { ?>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12 col-lg-12 text-right">
                        <button type="button" class="btn btn-success btn-lg" id="btn_agregar_investigacion_modal" data-toggle="modal" data-target="#modal_censo">
                            <?php echo $string_values['btn_add_new_investigacion']; ?>
                        </button>
                    </div>
                </div>
            <?php } ?>
            <div class="row" >
                <div id="tabla_actividades_docente" class="table-responsive">
                    <!--Mostrará la tabla de actividad docente --> 
                    <table class="table table-striped table-hover table-bordered" id="tabla_investigacion_docente">
                        <thead>
                            <tr class='btn-default'>
                                <th><?php echo $string_values['validado']; ?></th>
                                <th><?php echo $string_values['tab_titulo_tipo_investigacion'] ?></th>
                                <th><?php echo $string_values['tab_titulo_nombre_trabajo_investigacion'] ?></th>
                                <th><?php echo $string_values['tab_titulo_folio'] ?></th>
                                <th><?php echo $string_values['tab_titulo_cita_bibliografica'] ?></th>
                                <th><?php echo $string_values['tab_titulo_editar'] ?></th>
                                <th><?php echo $string_values['tab_titulo_eliminar'] ?></th>
                                <!--<th>Opciones</th>-->
                            </tr>
                        </thead>
                        <tbody>

                            <?php
//                            pr($lista_investigaciones);
                            foreach ($lista_investigaciones as $key_ai => $val) {
                                $key = $val['cve_investigacion'];
                                $key = $this->seguridad->encrypt_base64($key);
                                $c_bb = $val['cita_publicada'];
                                if (is_null($c_bb)) {//Pone texto referente a que no existe una cita bibliografica
                                    $tiene_cita = $string_values['text_sin_cita'];
                                    $idcomprobante = $val['comprobante_cve'];
                                    if (!is_null($idcomprobante)) {
                                        //Btn comprobante
                                        $comprobante = $this->seguridad->encrypt_base64($idcomprobante); //Encripta
                                        $tiene_cita_comprobante = '<a href="' . site_url('administracion/ver_archivo/' . $comprobante) . '" target="_blank">' . $string_values['lbl_ver_comprobante'] . '</a>';
                                    } else {
                                        $comprobante = 0;
                                        $tiene_cita_comprobante = '';
                                    }
                                } else {//Crea boton vinculo para ver cita bibliografica
                                    $comprobante = 0;
                                    $tiene_cita_comprobante = '<button '
                                            . 'type="button" '
                                            . 'class="btn btn-link btn-sm" '
                                            . 'id="btn_ver_cita_bibliografica" '
                                            . 'data-cita ="' . $c_bb . '"'
                                            . 'onclick="funcion_ver_cita_bibliografica(this)" >' .
                                            $string_values['text_con_cita']
                                            . '</button>';
                                }
                                $valido_eliminar_editar = $this->seguridad->verificar_liga_validar($val['IS_VALIDO_PROFESIONALIZACION'], $val['IS_CARGA_SISTEMA'], $val['validation_estado']);
//                                $validation_estado = (isset($val['validation_estado']) && !empty($val['validation_estado'])) ? $val['validation_estado'] : null;
                                $btn_eliminar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm" id="btn_eliminar_actividad_modal" data-idrow ="' . $key_ai . '" data-invcve ="' . $key . '" data-comprobantecve ="' . $comprobante . '" onclick="funcion_eliminar_reg_investigacion(this)" >' . $string_values['tab_titulo_eliminar'] . '</button>' : '';
                                $btn_editar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm" id="btn_eliminar_actividad_modal" data-idrow ="' . $key_ai . '" data-invcve ="' . $key . '" data-comprobantecve ="' . $comprobante . '" data-toggle="modal" data-target="#modal_censo" onclick="funcion_editar_reg_investigacion(this)" >' . $string_values['tab_titulo_editar'] . '</button>' : '';
                                //Crea los row de la tabla
                                echo "<tr id='id_row_" . $key_ai . "' data-keyrow=" . $key_ai . ">
                                      <td class='text-center'>" . $this->seguridad->html_verificar_valido_profesionalizacion($val['IS_VALIDO_PROFESIONALIZACION'], $val['IS_CARGA_SISTEMA'], $val['validation_estado']) . "</td>";
                                echo "<td>" . $val['tpad_nombre'] . "</td>";
                                echo "<td>" . $val['nombre_investigacion'] . "</td>";
                                echo "<td>" . $val['folio_investigacion'] . "</td>";
                                echo "<td>" . $tiene_cita_comprobante . "</td>";
                                echo '<td><button type="button" class="btn btn-link btn-sm btn_ver_in" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="' . $key . '" onclick="ver_in(this);">' .
                                $string_values['ver'] .
                                '</button>
                                    ' . $btn_editar . '</td>';
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
</div>
<script type="text/template" id="template_row_nueva_investigacion">
    <tr id='id_row_"$$key_ai$$"' data-keyrow="$$key_ai$$">
    <td><p id="p_inv_nombre">"$$tpad_nombre$$"</p></td>
    <td id="td_nom_investigacion">"$$nombre_investigacion$$"</td>
    <td>"$$folio_investigacion$$"</td>
    <td>"$$tiene_cita$$"</td>
    <td>
    <button type="button" class="btn btn-link btn-sm" id="btn_update_actividad_modal" data-idrow = "$$key_ai$$"  data-toggle="modal" data-target="#modal_censo"
    data-invcve ="$$key$$" data-comprobantecve ="$$comprobante$$" onclick="funcion_editar_reg_investigacion(this)" >Editar</button>
    </td>
    <td><button type="button" class="btn btn-link btn-sm" id="btn_eliminar_actividad_modal" data-idrow ="$$key_ai$$"
    data-invcve = "$$key$$" data-comprobantecve ="$$comprobante$$"
    onclick="funcion_eliminar_reg_investigacion(this)" >Eliminar</button>
    </td>
    </tr>;
</script>



