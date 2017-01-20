<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$fecha_ultima_actualizacion = 'Fecha de última actualizacón: 11 de julio de 2016 ';
?>

<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/validacion_censo_profesores/investigacion_docente.js"></script>

<!-- Inicio informacion personal -->


<div class="list-group">

    <div class="list-group-item">

        <div class="panel-body">
            <div>
                <br>
                <h4>Investigación </h4>
                <br>
            </div>

            <div class="row">
                <div class="form-group col-xs-12 col-md-12 col-lg-12 text-right">
                    <button type="button" class="btn btn-success btn-lg" id="btn_agregar_investigacion_modal" data-toggle="modal" data-target="#modal_censo">
                        <?php echo $string_values['btn_add_new_investigacion']; ?>
                    </button>
                </div>
            </div>

            <div class="row" >
                <div id="tabla_actividades_docente" class="table-responsive">
                    <!--Mostrará la tabla de actividad docente --> 
                    <table class="table table-striped table-hover table-bordered" id="tabla_investigacion_docente">
                        <thead>
                            <tr class='btn-default'>
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
                                        $tiene_cita_comprobante =  '<a href="'.site_url('administracion/ver_archivo/'.$comprobante).'" target="_blank">'.$string_values['lbl_ver_comprobante'].'</a>';
                                    }else{
                                        $comprobante = 0;
                                        $tiene_cita_comprobante  = ''; 
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
                                //Crea los row de la tabla
                                echo "<tr id='id_row_" . $key_ai . "' data-keyrow=" . $key_ai . ">";
                                echo "<td>" . $val['tpad_nombre'] . "</td>";
                                echo "<td>" . $val['nombre_investigacion'] . "</td>";
                                echo "<td>" . $val['folio_investigacion'] . "</td>";
                                echo "<td>" . $tiene_cita_comprobante . "</td>";
                                echo "<td>"
                                . '<button '
                                . 'type="button" '
                                . 'class="btn btn-link btn-sm" '
                                . 'id="btn_eliminar_actividad_modal" '
                                . 'data-idrow ="' . $key_ai . '"'
                                . 'data-invcve ="' . $key . '"'
                                . 'data-comprobantecve ="' . $comprobante . '"'
                                . 'data-toggle="modal"'
                                . 'data-target="#modal_censo"'
                                . 'onclick="funcion_editar_reg_investigacion(this)" >' .
                                $string_values['tab_titulo_editar']
                                . '</button>'
                                . "</td>";
                                echo "<td>"//Botón eliminar
                                . '<button '
                                . 'type="button" '
                                . 'class="btn btn-link btn-sm"'
                                . 'id="btn_eliminar_actividad_modal" '
                                . 'data-idrow ="' . $key_ai . '"'
                                . 'data-invcve ="' . $key . '"'
                                . 'data-comprobantecve ="' . $comprobante . '"'
                                . 'onclick="funcion_eliminar_reg_investigacion(this)" >' .
                                $string_values['tab_titulo_eliminar']
                                . '</button>'
                                . "</td>";
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



  