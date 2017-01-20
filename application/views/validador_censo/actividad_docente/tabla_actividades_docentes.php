
<table class="table table-striped table-hover table-bordered">
    <thead>
        <tr class='success'>
            <th><?php echo $string_values['tab_titulo_pro_salud_cur_principal'] ?></th>
            <th><?php echo $string_values['tab_titulo_pro_salud_actividad'] ?></th>
            <th><?php echo $string_values['tab_titulo_pro_salud_anio'] ?></th>
            <th><?php echo $string_values['tab_titulo_pro_salud_duracion'] ?></th>
            <th><?php echo $string_values['tab_titulo_pro_salud_fecha_inicio'] ?></th>
            <th><?php echo $string_values['tab_titulo_pro_salud_fecha_fin'] ?></th>
            <th><?php echo $string_values['tab_titulo_editar'] ?></th>
            <th><?php echo $string_values['tab_titulo_eliminar'] ?></th>
            <!--<th>Opciones</th>-->
        </tr>
    </thead>
    <tbody>

            <?php //Generará la tabla que muestrá las actividades del docente
                    foreach ($datos_tabla_actividades_docente as $value) {
                        //Valida curso principal
                        $is_cur_principal_igual = ($curso_principal === $value['cve_actividad_docente'])?1:0;
                        $is_tp_actividad_igual = ($curso_principal_entidad_contiene  === $value['ta_cve'])?1:0;
                        $is_cur_principal = ($is_cur_principal_igual ===1 AND $is_tp_actividad_igual===1)?1:0; 
//                                                        pr($is_cur_principal .  ' : ' . $value['cve_actividad_docente'] . ' -> ' . $curso_principal .' ,  ' . $value['ta_cve'] . ' -> ' . $curso_principal_entidad_contiene  );
                        $checked = ($is_cur_principal===1)?"checked":"";
                        $reg_principal = ($is_cur_principal===1)?'success':''; 
                        echo "<tr class='". $reg_principal ."'>";
                        echo "<td >".$this->form_complete->create_element(
                                    array('id'=>'radio_curso_principal', 'type'=>'radio',
                                        'value' => $value['cve_actividad_docente'],
                                        'attributes'=>array(
                                        'class'=>'radio-inline m-r-sm',
                                        'title'=> $string_values['radio_duracion_horas'],
//                                                    'disabled'=> '',
                                        $checked=>$checked,
                                        )
                                    )).
                             "</td>";
                        echo "<td >".$value['nombre_tp_actividad']."</td>";
                        echo "<td >".$value['anio']."</td>";
                        echo "<td >".$value['duracion']."</td>";
                        echo "<td >".$value['fecha_inicio']."</td>";
                        echo "<td >".$value['fecha_fin']."</td>";
                        echo '<td><button type="button" class="btn btn-link btn-sm" id="btn_editar_actividad_modal" data-toggle="modal" data-target="#modal_censo">'.
                               $string_values['tab_titulo_editar'].
                             '</button></td>';
                        echo '<td><button type="button" class="btn btn-link btn-sm" id="btn_eliminar_actividad_modal" data-toggle="modal" data-target="#modal_censo" ' .
                         'onclick="funcion_eliminar_actividad_docente('.$value['ta_cve'].','.$value['cve_actividad_docente'].','.$is_cur_principal.',0)"  >'.
                               $string_values['tab_titulo_eliminar'].
                             '</button></td>';
                        echo "</tr>";
                    }
            ?>
    </tbody>
</table>
    