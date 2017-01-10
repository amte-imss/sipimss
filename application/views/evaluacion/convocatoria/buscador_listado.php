<script type="text/javascript">
    var confirmar_eliminacion = "<?php echo $string_values['confirmar_eliminacion']; ?>"; //Texto de confirmación
    var error_eliminacion = "<?php echo $string_values['error']; ?>"; //Texto de confirmación
</script>
<?php echo js('evaluacion/evaluacion.js'); ?>
<div class="list-group">
    <div class="list-group-item">
        <div class="panel-body tab-content">
            <h4><?php echo $string_values['titulo']; ?></h4><br>
            
            <div id="mensaje"></div>
            
            <div class="row">
                <div class="col-lg-6"><?php echo $string_values['proxima_evaluacion'].': '.((!empty($proxima_convocatoria_evaluacion[0]['anio'])) ? nice_date($proxima_convocatoria_evaluacion[0]['anio'], 'd-m-Y') : $string_values['proxima_evaluacion_no_existe']); ?></div>
                <div class="col-lg-6 text-right">
                    <button type="button" class="btn btn-success btn-sm" id="btn_agregar_ce" data-toggle="modal" data-target="#modal_censo" data-value="">
                        <?php echo $string_values['agregar_convocatoria']; ?>
                    </button></div>
            </div><br>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo $string_values['tab_head_fecha_fin_registro'] ?></th>
                                <th class="text-center"><?php echo $string_values['tab_head_fecha_fin_validacion1'] ?></th>
                                <th class="text-center"><?php echo $string_values['tab_head_fecha_fin_validacion2'] ?></th>
                                <th class="text-center"><?php echo $string_values['tab_head_fecha_dictamen'] ?></th>
                                <th class="text-center"><?php echo $string_values['tab_head_fecha_inconformidad'] ?></th>
                                <th class="text-center"><?php echo $string_values['acciones'] ?></th>
                                <!--<th>Opciones</th>-->
                            </tr>
                        </thead>
                        <tbody>
                                <?php //Generará la tabla que muestrá las actividades del docente
                                $html = "";
                                foreach ($convocatoria_evaluacion as $ce) {
                                    $html_dic = $html_inc = "";
                                    foreach ($ce['dictamen'] as $dic) {
                                        $html_dic .= nice_date($dic['FCH_INICIO_EVALUACION'], 'd-m-Y').' - '.nice_date($dic['FCH_FIN_EVALUACION'], 'd-m-Y').'<br>';
                                        $html_inc .= nice_date($dic['FCH_FIN_INCONFORMIDAD'], 'd-m-Y').'<br>';
                                    }
                                    $html .= '<tr id="tr_'.$this->seguridad->encrypt_base64($ce['ADMIN_VALIDADOR_CVE']).'">
                                            <td>'.nice_date($ce['FCH_FIN_REG_DOCENTE'], 'd-m-Y').'</td>
                                            <td>'.nice_date($ce['FCH_FIN_VALIDACION_1'], 'd-m-Y').'</td>
                                            <td>'.nice_date($ce['FCH_FIN_VALIDACION_2'], 'd-m-Y').'</td>
                                            <td>'.$html_dic.'</td>
                                            <td>'.$html_inc.'</td>
                                            <td><button type="button" class="btn btn-link btn-sm btn_editar_ce" data-toggle="modal" data-target="#modal_censo" data-value="'.$this->seguridad->encrypt_base64($ce['ADMIN_VALIDADOR_CVE']).'">'.
                                                   $string_values['editar'].
                                                '</button>
                                                <button type="button" class="btn btn-link btn-sm btn_eliminar_ce" data-value="'.$this->seguridad->encrypt_base64($ce['ADMIN_VALIDADOR_CVE']).'">'.
                                                       $string_values['eliminar'].
                                                    '</button>
                                            </td>
                                        </tr>';
                                }
                                echo $html;
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>