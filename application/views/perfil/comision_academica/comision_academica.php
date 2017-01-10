<?php
$this->seguridad->set_tiempo_convocatoria_null(); //Reinicia validacion de convocatoria
$this->seguridad->set_tiempo_convocatoria(); //Valida paso de convocatoria
?>
<script type="text/javascript">
    var confirmar_eliminacion = "<?php echo $string_values['confirmar_eliminacion']; ?>";
</script>
<?php echo js('perfil/comision_academica.js'); ?>
<div class="list-group">
    <div id='tab_content_comision_academica' class='tab-content col-md-12'>
        <div id='comision_academica_tab' class='tab-pane fade in active'>
            <div class="panel-body">
                <div>
                    <h4><?php echo $string_values['title']; ?></h4><br>
                </div>
                <div id="mensaje"></div>
                <?php $inc = 0;
                foreach ($catalogos['ctipo_comision'] as $key_tc => $tipo_comision) {
                    ?>
                    <div class="panel-group" id="accordion_<?php echo $key_tc; ?>" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="head_<?php echo $key_tc; ?>">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion_<?php echo $key_tc; ?>" href="#collapseOne_<?php echo $key_tc; ?>" aria-controls="collapseOne_<?php echo $key_tc; ?>">
    <?php echo $tipo_comision; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne_<?php echo $key_tc; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="head_<?php echo $key_tc; ?>">
                                <div class="panel-body">
    <?php if ($this->seguridad->verificar_liga_validar()) { ?>
                                        <div class="row">
                                            <div class='col-sm-12 col-md-12 col-lg-12 text-right'>
                                                <div>
                                                    <button type="button" aria-expanded="false" class="btn btn-success btn_agregar_comision_academica_modal" data-toggle="modal" data-target="#modal_censo" data-value="" data-com="<?php echo $this->seguridad->encrypt_base64($key_tc); ?>">
        <?php echo $string_values['btn_add_new_comision_academica']; ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div><br>
    <?php } ?>
                                    <div class="row" >
                                        <div id="div_comision_academica" class="table-responsive">
                                            <table class="table table-striped table-hover table-bordered" id="tabla_comision_academica">
                                                <thead>
                                                    <tr class='btn-default'>
                                                        <th><?php echo $string_values['validado']; ?></th>
                                                        <?php
                                                        foreach ($columns[$key_tc] as $title) {
                                                            echo '<th>' . $title . '</th>';
                                                        }
                                                        echo '<th>' . $string_values['t_h_comprobante'] . '</th><th>' . $string_values['t_h_opciones'] . '</th>';
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    //Generará la tabla que muestrá las actividades del docente
                                                    foreach ($comisiones[$key_tc] as $key_ca => $comision_academica) {
                                                        $id = $this->seguridad->encrypt_base64($comision_academica['EMP_COMISION_CVE']);
                                                        $valido_eliminar_editar = $this->seguridad->verificar_liga_validar($comision_academica['IS_VALIDO_PROFESIONALIZACION'], $comision_academica['IS_VALIDO_PROFESIONALIZACION'], $comision_academica['validation_estado']);
                                                        $btn_comprobante = (!is_null($comision_academica['COMPROBANTE_CVE'])) ? '<a href="' . site_url('administracion/ver_archivo/' . $this->seguridad->encrypt_base64($comision_academica['COMPROBANTE_CVE'])) . '" target="_blank">' . $string_values['lbl_ver_comprobante'] . '</a>' : '';
                                                        echo '<tr id="tr_' . $id . '">
                                                              <td class="text-center">' . $this->seguridad->html_verificar_valido_profesionalizacion($comision_academica['IS_VALIDO_PROFESIONALIZACION'], $comision_academica['IS_CARGA_SISTEMA'], $comision_academica['validation_estado']) . '</td>';
                                                        foreach ($columns[$key_tc] as $key_dato => $dato) {
                                                            echo '<td>' . $comision_academica[$key_dato] . '</td>';
                                                        }
                                                        $btn_eliminar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm btn_eliminar_dt" data-value="' . $id . '">' . $string_values['eliminar'] . '</button>' : '';
                                                        $btn_editar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm btn_editar_ca" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="' . $id . '" data-com="' . $this->seguridad->encrypt_base64($key_tc) . '">' . $string_values['editar'] . '</button>' : '';
                                                        echo '<td>' . $btn_comprobante . '</td>
															<td><button type="button" class="btn btn-link btn-sm btn_ver_ca" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="' . $id . '" data-com="' . $this->seguridad->encrypt_base64($key_tc) . '" onclick="ver_ca(this);">' .
                                                        $string_values['ver'] .
                                                        '</button>
                                                                ' . $btn_editar . '
                                                                ' . $btn_eliminar . '							                                    
							                                </td>
														</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    <?php $inc++;
}
?>
            </div>
        </div><!--Termina primer tab-->                
    </div>
</div>
