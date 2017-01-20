<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$fecha_ultima_actualizacion = 'Fecha de última actualizacón: 11 de julio de 2016 ';
//    pr($tipo_msg);
//$colapso_div_ejercicio_profesional = 'collapse in';
//        $colapso_div_ejercicio_profesional = 'collapse';
//        pr($datos_tabla_actividades_docente);
//        pr($actividades_docente_objet);
echo js('validacion_censo_profesores/material_educativo.js');
$this->seguridad->set_tiempo_convocatoria_null(); //Reinicia validacion de convocatoria
$this->seguridad->set_tiempo_convocatoria(null, null, $is_interseccion); //Valida paso de convocatoria y, si la validación actual es una intersección
?>
<!-- <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/validacion_censo_profesores/material_educativo.js"></script> -->
<!-- Inicio informacion personal -->
<div class="list-group">
    <div class="list-group-item">
        <div class='row'>
            <div class="col-xs-12 col-md-12 col-lg-12 text-left">
                <br>
                <?php echo $string_values['title_material_eduacativo']; ?>
                <br>
            </div>
        </div>
        <div class='row'> 
            <div class="form-group col-xs-12 col-md-12">
                <?php // pr($lista_material_educativo); ?>
                <table class="table table-striped table-hover table-bordered" id="tabla_becas">
                    <thead>
                        <tr class="btn-default">
                            <th><?php echo $string_values['validado']; ?></th>
                            <th><?php echo $string_values['title_tab_mat_edu_nombre_mat']; ?></th>
                            <th><?php echo $string_values['title_tab_mat_edu_tipo_mat']; ?></th>
                            <th><?php echo $string_values['title_tab_mat_edu_anio']; ?></th>
                            <th><?php echo $string_values['title_tab_mat_edu_comprobante']; ?></th>
                            <th><?php echo $string_values['opciones']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($lista_material_educativo as $key_ai => $val) {
//                            pr($lista_material_educativo);
                            $key = $val['emp_material_educativo_cve'];
                            $key = $this->seguridad->encrypt_base64($key);
                            $key_tp_mat_edu = $val['tipo_material_cve'];
                            $key_tp_mat_edu = $this->seguridad->encrypt_base64($key_tp_mat_edu);
                            $idcomprobante = $val['comprobante'];
                            $desc_tipo_material = $val['nom_tipo_material']. '<br>' .$val['opt_tipo_material'];//Nombre del tipo de material, y opción como núm de años, cantidad de hojas  
                            if (!is_null($idcomprobante)) {
                                //Btn comprobante
                                $idcomprobante = $this->seguridad->encrypt_base64($idcomprobante); //Encripta
                                $btn_comprobante =  '<a href="'.site_url('administracion/ver_archivo/'.$idcomprobante).'" target="_blank">'.$string_values['lbl_ver_comprobante'].'</a>';
                                
                            }else{
                                $comprobante = 0;
                                $btn_comprobante  = '';
                            }
                            //$btn_validar = ($this->seguridad->verificar_liga_validar($val['IS_VALIDO_PROFESIONALIZACION'])) ?                                                '<button type="button" class="btn btn-link btn-sm btn_validar_me" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="'.$key.'" onclick="validar_me(this);" data-valid="'.$this->seguridad->encrypt_base64($this->config->item('ACCION_GENERAL')['VALIDAR']['valor']).'">'.$string_values['validar'].'</button>' : '';
                            ///////////Inicio ver liga de validación
//                            $validation_estado = (isset($val['validation_estado']) && !empty($val['validation_estado'])) ? $val['validation_estado'] : '';
//                            $validation_estado_anterior = (isset($val['validation_estado_anterior']) && !empty($val['validation_estado_anterior'])) ? $val['validation_estado_anterior'] : null;
                            $valido_eliminar_editar = $this->seguridad->verificar_liga_validar($val['IS_VALIDO_PROFESIONALIZACION'], $val['IS_CARGA_SISTEMA']);
                            $btn_validar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm btn_validar_me" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="'.$key.'" onclick="validar_me(this);" data-valid="'.$this->seguridad->encrypt_base64($this->config->item('ACCION_GENERAL')['VALIDAR']['valor']).'">'.$string_values['validar'].'</button>' : '';
                            ///////////Fin ver liga de validación
                            //Crea los row de la tabla
                            echo "<tr id='id_row_" . $key_ai . "' data-keyrow=" . $key_ai . ">";
                            echo '<td class="text-center">'.$this->seguridad->html_verificar_evaluado_issistema_valido($val['IS_VALIDO_PROFESIONALIZACION'], $val['IS_CARGA_SISTEMA'], $val['validation_estado']).'</td>';
                            echo "<td>" . $val['nombre_material'] . "</td>";
                            echo "<td>" . $desc_tipo_material . "</td>";
                            echo "<td>" . $val['material_educativo_anio'] . "</td>";
                            echo "<td>" . $btn_comprobante . "</td>";
                            echo "<td>" 
                                . '<button type="button" class="btn btn-link btn-sm btn_ver_me" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="'.$key.'" onclick="ver_me(this);">'.
                                       $string_values['ver'].
                                    '</button>'
                                . "";
                            echo ''.$btn_validar.'</td>'; ///Botón validar
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/template" id="template_row_nueva_comision">

</script>


