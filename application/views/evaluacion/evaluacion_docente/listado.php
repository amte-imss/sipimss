<h1><?php echo $string_values['docente']['titulo']; ?></h1><br>

<div id="mensaje"></div>

<br>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><?php echo $string_values['docente']['tab_head_fch_dictamen'] ?></th>
                    <th class="text-center"><?php echo $string_values['docente']['tab_head_estado_dictamen'] ?></th>
                    <th class="text-center"><?php echo $string_values['docente']['tab_head_fch_ultimo_estado'] ?></th>
                    <th class="text-center"><?php echo $string_values['docente']['tab_head_dictamen'] ?></th>
                    <th class="text-center"><?php echo $string_values['docente']['tab_head_constancia'] ?></th>
                    <th class="text-center"><?php echo $string_values['docente']['tab_head_categoria'] ?></th>
                    <th class="text-center"><?php echo $string_values['docente']['tab_head_vigencia'] ?></th>
                    <th class="text-center"><?php echo $string_values['docente']['tab_head_periodo_inconformidad'] ?></th>
                    <th class="text-center"><?php echo $string_values['docente']['tab_head_inconformidad'] ?></th>
                </tr>
            </thead>
            <tbody>
                    <?php //Generará la tabla que muestrá las actividades del docente
                    $html = "";
                    foreach ($dictamen as $ce) {
                        $fch_inc = (!empty($ce['FCH_INCONFOR_FIN'])) ? nice_date($ce['FCH_VIGENCIA_INICIO'], 'd-m-Y').' / '.nice_date($ce['FCH_INCONFOR_FIN'], 'd-m-Y') : '';
                        $fch_vig = (!empty($ce['FCH_VIGENCIA_INICIO']) && !empty($ce['FCH_VIGENCIA_FIN'])) ? nice_date($ce['FCH_VIGENCIA_INICIO'], 'd-m-Y').' / '.nice_date($ce['FCH_VIGENCIA_FIN'], 'd-m-Y') : '';
                        $html .= '<tr>
                                <td>'.nice_date($ce['FCH_DICTAMEN'], 'd-m-Y').'</td>
                                <td>falta</td>
                                <td>falta</td>
                                <td>falta</td>
                                <td>falta</td>
                                <td>'.$ce['CAT_NOMBRE'].'</td>
                                <td>'.$fch_vig.'</td>
                                <td>'.$fch_inc.'</td>
                                <td><button type="button" class="btn btn-link btn-sm btn_editar_ce" data-toggle="modal" data-target="#modal_censo" data-value="'.$this->seguridad->encrypt_base64($ce['DICTAMEN_CVE']).'">'.
                                       $string_values['detalle_fechas'].
                                    '</button>
                                    <button type="button" class="btn btn-link btn-sm btn_eliminar_ce" data-value="'.$this->seguridad->encrypt_base64($ce['DICTAMEN_CVE']).'">'.
                                           $string_values['docente']['enviar_inconformidad'].
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
