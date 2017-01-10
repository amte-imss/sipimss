<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//pr($lista_unidades);
?>
<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/designar_validador/designar_validador.js"></script>
<div id="div_tabla_designar_validador">
    <!--Mostrará la tabla de actividad docente --> 
    <table class="table table-striped table-hover table-bordered " id="tabla_designar_validador">
        <thead>
            <tr class="bg-info">
                <th><?php echo $string_values['tab_titulo_unidades'] ?></th>
                <th><?php echo $string_values['tab_titulo_designado'] ?></th>
                <th><?php echo $string_values['tab_delegacion_validador'] ?></th>
                <th><?php echo $string_values['tab_titulo_matricula'] ?></th>
                <th><?php echo $string_values['tab_titulo_nombre'] ?></th>
                <th><?php echo $string_values['tab_categoria_validador'] ?></th>
                <th><?php echo $string_values['tab_titulo_seleccionar_validador'] ?></th>
                <!--<th>Opciones</th>-->
            </tr>
        </thead>
        <tbody>
            <?php
//            pr($lista_unidades);
            foreach ($lista_unidades as $key_ai => $val) {
                $id_validador = $this->seguridad->encrypt_base64($val['validador_cve']); //Encripta id validador
                $delegacion_cve = $this->seguridad->encrypt_base64($val['delegacion_cve']); //Encripta id validador
                $departamento_cve = $this->seguridad->encrypt_base64($val['departamento_cve']); //Encripta id validador
                if (!empty($val['validador_cve']) AND intval($val['is_validador_actual']) === 1) {
                    $link_seleccionar_val = '';
                    $check_designar = $this->form_complete->create_element(
                            array('id' => 'check_designado_' . $key_ai . '"', 'type' => 'checkbox', 'class' => 'text-center',
                                'value' => $val['validador_cve'],
                                'attributes' => array(
                                    'checked' => ($id_validador === 0) ? '' : 'checked',
                                    'data-idvalidador' => $id_validador,
                                    'data-delcve' => $delegacion_cve,
                                    'data-depcve' => $departamento_cve,
                                    'data-idrow' => $key_ai,
//                                    'onchange' => 'funcion_designar_validador(this)',
                                    'onclick' => 'funcion_designar_validador(this)',
                                )
                            )
                    );
//                } else if (!empty($val['validador_cve']) AND intval($val['estado_validador']) === 0) {
//                    $id_validador = $this->seguridad->encrypt_base64($val['validador_cve']); //Encripta id validador
//                    $check_designar = '';
//                    $link_seleccionar_val = '<button '
//                            . 'type="button" '
//                            . 'class="btn btn-link btn-sm" '
//                            . 'id="btn_seleccionar_validador_' . $key_ai . '"'
//                            . 'data-toggle="modal"'
//                            . 'data-target="#modal_censo"'
//                            . 'data-idrow ="' . $key_ai . '"'
//                            . 'data-idvalidador="' . $id_validador . '"'
//                            . 'data-delcve="' . $delegacion_cve . '"'
//                            . 'data-idrow="' . $key_ai . '"'
//                            . 'data-depcve="' . $departamento_cve . '"'
//                            . 'data-tipoevento="cargarseleccion"'
//                            . 'onclick="funcion_carga_elemento(this)" >' .
//                            $string_values['tab_titulo_seleccionar_validador']
//                            . '</button>';
                } else {
                    $id_validador = 0;
                    $check_designar = '';
                    $link_seleccionar_val = '<button '
                            . 'type="button" '
                            . 'class="btn btn-link btn-sm" '
                            . 'id="btn_seleccionar_validador_' . $key_ai . '"'
                            . 'data-idrow ="' . $key_ai . '"'
                            . 'data-toggle="modal"'
                            . 'data-target="#modal_censo"'
                            . 'data-idvalidador="' . $id_validador . '"'
                            . 'data-delcve="' . $delegacion_cve . '"'
                            . 'data-idrow="' . $key_ai . '"'
                            . 'data-depcve="' . $departamento_cve . '"'
                            . 'data-tipoevento="cargarseleccion"'
                            . 'onclick="funcion_carga_elemento(this)" >' .
                            $string_values['tab_titulo_seleccionar_validador']
                            . '</button>';
                }
                echo "<tr id='id_row_" . $key_ai . "' data-keyrow=" . $key_ai . ">";
                echo "<td>" . $val['nom_departamento'] . "</td>";
                echo "<td class='text-center'>" . $check_designar . "</td>";
                echo "<td>" . $val['nom_delegacion'] . "</td>";
                echo "<td>" . $val['matricula_empleado'] . "</td>";
                echo "<td>" . $val['nom_empleado'] . "</td>";
                echo "<td>" . $val['nom_categoria'] . "</td>";
                echo "<td class='text-center'>" . $link_seleccionar_val
                . "</td>";
                echo "<tr>";
            }
            ?>
        </tbody>
    </table>
</div>

