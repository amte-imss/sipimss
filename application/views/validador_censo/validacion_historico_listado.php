<?php
$html = '';
foreach ($registro_validado as $key_rv => $historico) {
    $cvalidacion_curso_estado = $this->config->item('cvalidacion_curso_estado');
    switch ($historico['VAL_CUR_EST_CVE']) {
        case $cvalidacion_curso_estado['VALIDO']['id']:
            $class = $cvalidacion_curso_estado['VALIDO']['color'];
            break;
        case $cvalidacion_curso_estado['NO_VALIDO']['id']:
            $class = $cvalidacion_curso_estado['NO_VALIDO']['color'];
            break;
        case $cvalidacion_curso_estado['CORRECCION']['id']:
            $class = $cvalidacion_curso_estado['CORRECCION']['color'];
            break;
        default:
            $class = 'info';
            break;
    }
    $html .= '<tr class="'.$class.'">
        <td>'.nice_date($historico['VAL_CUR_FCH'], 'd-m-Y').'</td>
        <td>'.$historico['ROL_NOMBRE'].'</td>
        <td>'.$historico['VAl_CUR_EST_NOMBRE'].'</td>
        <td>'.nl2br($historico['VAL_CUR_COMENTARIO']).'</td>
    </tr>';
}
if(count($registro_validado)>0){ ?>
    <div class="row">
        <div class='col-sm-12 col-md-12 col-lg-12 text-left'>
            <br><h4><?php echo $string_values['lbl_historico_validaciones']; ?></h4><hr>
        </div>
        <div class='col-sm-12 col-md-12 col-lg-12'>
            <table class="table table-striped table-hover table-bordered" id="tabla_historico">
                <thead>
                    <tr class='btn-default'>
                        <th><?php echo $string_values['t_h_fecha']; ?></th>
                        <th><?php echo $string_values['t_h_rol']; ?></th>
                        <th><?php echo $string_values['lbl_estado_validacion']; ?></th>
                        <th><?php echo $string_values['lbl_comentario']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php //Generará la tabla que muestrá las actividades del docente
                    echo $html;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
