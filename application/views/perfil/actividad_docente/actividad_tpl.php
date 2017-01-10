<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//    pr($tipo_msg);
$this->seguridad->set_tiempo_convocatoria_null();//Reinicia validacion de convocatoria
$this->seguridad->set_tiempo_convocatoria();//Valida paso de convocatoria
$colapso_div_ejercicio_profesional = 'collapse in';
//        $colapso_div_ejercicio_profesional = 'collapse';
//        pr($datos_tabla_actividades_docente);
//        pr($actividades_docente_objet);
?>

<style type="text/css">
    .button-padding {padding-top: 30px}
    .rojo {color: #a94442}.panel-body table{color: #000} .pinfo{padding-left:20px; padding-bottom: 20px;}
</style>

<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/perfil/actividad_docente.js"></script>

<!-- Inicio informacion personal -->
<?php echo form_open('', array('id' => 'form_actividad_docente')); 
if($this->seguridad->verificar_liga_validar()){
    $readonly = '';    
    $function = 'funcion_asignar_curso_principal(this)';
    $disabled = '';
} else {
    $readonly = 'readonly';
    $disabled = 'disabled';
    $function = '';
}?>

<?php echo $guardado_correcto; ?>
<div class="list-group">
    <div class="list-group-item">
            <div class="panel-body">
                <div>
                    <br>
                    <h4>Actividad docente</h4>
                    <br>
                </div>
                <!--Ejercicio profecional en salud-->
                <div class='row'>
                    <div class="form-group col-xs-5 col-md-5">
                        <label for='perfil_anios_dedicados_docencia' class="control-label">
                            <b class="rojo">*</b>
                            <?php echo $string_values['lbl_anios_dad']; ?>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"> </span>
                            </span>
                            <?php
                            echo $this->form_complete->create_element(
                                    array('id' => 'actividad_anios_dedicados_docencia', 'type' => 'number',
                                        'value' => empty($actividad_docente) ? '' : $actividad_docente[0]['ANIOS_DEDICADOS'],
                                        'attributes' => array(
                                            'class' => 'form-control',
                                            'placeholder' => $string_values['lbl_anios_dad'],
                                            'min' => '0',
                                            'max' => '50',
                                            $readonly => $readonly,
                                            $disabled => $disabled,
                                            'data-toggle' => 'tooltip',
                                            'data-placement' => 'bottom',
                                            'title' => $string_values['lbl_anios_dad'],
                                        )
                                    )
                            );
                            ?>
                        </div>
                        <?php echo form_error_format('actividad_anios_dedicados_docencia'); ?>
                    </div>

                    <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                        <label for='lbl_ejercicio_pd' class="control-label">
                            <b class="rojo">*</b>
                        <?php echo $string_values['lbl_ejercicio_pd']; ?>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-user"> </span>
                            </span>
                            <?php
                            echo $this->form_complete->create_element(array('id' => 'ejercicio_predominante', 'type' => 'dropdown',
                                'options' => $cejercicio_predominante,
                                'first' => array('' => 'Selecciona ejercicio'),
                                'value' => empty($actividad_docente) ? '' : $actividad_docente[0]['EJER_PREDOMI_CVE'],
                                'attributes' => array('name' => 'categoria', 'class' => 'form-control',
                                    $readonly => $readonly,
                                    $disabled => $disabled,
                                    'placeholder' => 'Categoría', 'data-toggle' => 'tooltip', 'data-placement' => 'top',
                                    'title' => $string_values['lbl_ejercicio_pd'])));
                            ?>
                        </div>
                            <?php echo form_error_format('ejercicio_predominante'); ?>
                    </div>

                </div>
                <?php if($this->seguridad->verificar_liga_validar()){ ?>
                    <div class="row">
                        <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1 ">
                            <!--<a class="btn btn-success " data-toggle="tab" href="#get_data_ajax_actividad" >-->
                                <?php // echo $string_values['btn_guardar_cp'];  ?>
                            <!--</a>-->

                            <button type="button" class="btn btn-success" id="btn_guardar_actividad" value="ajax">
                                <?php echo $string_values['btn_guardar_cp']; ?>
                                <?php // echo $string_values['perfil']['btn_informacion_general_editar_nombre'];  ?> 
                            </button>
                        </div>    
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">


                    </div>
                        <?php if (isset($datos_tabla_actividades_docente)) { ?>
                            <?php if($this->seguridad->verificar_liga_validar()){ ?>
                                <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                                    <button type="button" class="btn btn-success btn-lg" id="btn_agregar_actividad_modal_nueva" 
                                            data-actgralcve =" <?php echo $actividad_general_cve;?>"
                                            data-toggle="modal" data-target="#modal_censo">
                                    <?php echo $string_values['btn_add_new_actividad']; ?>
                                    </button>
                                </div>
                            <?php } ?>
                        <?php } ?>
                </div>
                            <?php if (isset($datos_tabla_actividades_docente)) { ?>
                    <div class="row" >

                        <div id="tabla_actividades_docente" class="table-responsive">
                            <!--Mostrará la tabla de actividad docente --> 
                            <table class="table table-striped table-hover table-bordered" id="tabla_actividades">
                                <thead>
                                    <tr class='btn-default'>
                                        <th><?php echo $string_values['validado']; ?></th>
                                        <th><?php echo $string_values['tab_titulo_pro_salud_cur_principal'] ?></th>
                                        <th><?php echo $string_values['tab_titulo_pro_salud_actividad'] ?></th>
                                        <th><?php echo $string_values['tab_titulo_pro_salud_anio'] ?></th>
                                        <th><?php echo $string_values['tab_titulo_pro_salud_duracion'] ?></th>
                                        <th><?php echo $string_values['tab_titulo_pro_salud_fecha_inicio'] ?></th>
                                        <th><?php echo $string_values['tab_titulo_pro_salud_fecha_fin'] ?></th>
                                        <th><?php echo $string_values['tab_titulo_comprobante'] ?></th>
                                        <th><?php echo $string_values['tab_titulo_editar'] ?></th>
                                        <th><?php echo $string_values['tab_titulo_eliminar'] ?></th>
                                        <!--<th>Opciones</th>-->
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //Generará la tabla que muestrá las actividades del docente
                                    foreach ($datos_tabla_actividades_docente as $key => $value) {
                                        //Valida curso principal
                                        $is_cur_principal_igual = ($curso_principal === $value['cve_actividad_docente']) ? 1 : 0;
                                        $is_tp_actividad_igual = ($curso_principal_entidad_contiene === $value['ta_cve']) ? 1 : 0;
                                        $is_cur_principal = ($is_cur_principal_igual === 1 AND $is_tp_actividad_igual === 1) ? 1 : 0;
                                        //                                                        pr($is_cur_principal .  ' : ' . $value['cve_actividad_docente'] . ' -> ' . $curso_principal .' ,  ' . $value['ta_cve'] . ' -> ' . $curso_principal_entidad_contiene  );
                                        if ($is_cur_principal === 1) {
                                            $checked = 'checked';
                                            $reg_principal = 'success';
                                            $cp = '1';
                                        } else {
                                            $checked = 'none';
                                            $reg_principal = '';
                                            $cp = '0';
                                        }
                                        $idcomprobante = $value['comprobante'];
                                        if (!is_null($idcomprobante)) {//Valida existencia del comprobante
                                            //Botón comprobante
                                            $idcomprobante = $this->seguridad->encrypt_base64($idcomprobante); //Encripta
                                            $btn_comprobante = '<a href="' . site_url('administracion/ver_archivo/' . $idcomprobante) . '" target="_blank">' . $string_values['lbl_ver_comprobante'] . '</a>';
                                        } else {
                                            $comprobante = 0;
                                            $btn_comprobante = '';
                                        }
                                        echo "<tr class='" . $reg_principal . "' id='id_row_" . $key . "' data-cp='" . $cp . "' data-keyrow=" . $key . " >
                                            <td class='text-center'>".$this->seguridad->html_verificar_valido_profesionalizacion($value['IS_VALIDO_PROFESIONALIZACION'], $value['IS_CARGA_SISTEMA'], $value['validation_estado'])."</td>";
                                        echo "<td >" . $this->form_complete->create_element(
                                                array('id' => 'radio_curso_principal', 'type' => 'radio',
                                                    'value' => $value['cve_actividad_docente'],
                                                    'attributes' => array(
                                                        'class' => 'radio-inline m-r-sm',
                                                        $readonly => $readonly,
                                                        $disabled => $disabled,
                                                        $checked => $checked,
                                                        'onchange' => $function,
                                                        'data-entidadtpacve' => "'" . $value['ta_cve'] . "'", //cve del catálogo tipo de actividad (ctipo_actividad)
                                                        'data-actividadgeneralcve' => "'" . $value['actividad_general_cve'] . "'", //actividad general cve
                                                        'data-actividaddocentecve' => "'" . $value['cve_actividad_docente'] . "'", //actividad de docente cve, según la entidad (emp_actividad_docente, emp_esp_med o emp_educacion_distancia)
                                                        'data-cp' => "'" . $cp . "'", //indica si es un curso principal, 0-no; 1-si;
                                                        'data-keyrowselect' => $key, //indica si es un curso principal, 0-no; 1-si;
                                                    )
                                        )) .
                                        "</td>";
                                        $valido_eliminar_editar = $this->seguridad->verificar_liga_validar($value['IS_VALIDO_PROFESIONALIZACION'], $value['IS_CARGA_SISTEMA'], $value['validation_estado']);
                                        $id = $this->seguridad->encrypt_base64($value['cve_actividad_docente']);
                                        $btn_eliminar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm" id="btn_eliminar_actividad_modal" data-idrow ="' . $key . '" data-tacve ="' . $value['ta_cve'] . '" data-cvead ="' . $value['cve_actividad_docente'] . '" data-cp ="' . $is_cur_principal . '" onclick="funcion_eliminar_actividad_docente(this)" >'.$string_values['tab_titulo_eliminar'].'</button>' : '';
                                        $btn_editar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm" data-idrow ="' . $key . '" data-becacve ="' . $value['cve_actividad_docente'] . '" data-comprobantecve ="' . $idcomprobante . '" data-tacve ="' . $value['ta_cve'] . '" data-cvead ="' . $value['cve_actividad_docente'] . '" data-toggle="modal" data-target="#modal_censo" onclick="funcion_editar_reg_actividad(this)" >'.$string_values['tab_titulo_editar'].'</button>' : '';
                                        echo "<td class='class_titulo'>" . $value['nombre_tp_actividad'] . "</td>";
                                        echo "<td >" . $value['anio'] . "</td>";
                                        echo "<td >" . $value['duracion'] . "</td>";
                                        echo "<td >" . $value['fecha_inicio'] . "</td>";
                                        echo "<td >" . $value['fecha_fin'] . "</td>";
                                        echo "<td>" . $btn_comprobante . "</td>";
                                        echo '<td><button type="button" class="btn btn-link btn-sm btn_ver_ad" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="'.$id.'" onclick="ver_ad(this, '.$value['ta_cve'].');">'.
                                               $string_values['ver'].
                                            '</button>
                                            '.$btn_editar.'</td>';
                                        echo '<td>'.$btn_eliminar.'</td>';
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="row">
                        <div id='mensaje_error_div' class='alert'>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <span id='mensaje_error' class="alert-info"><?php echo $string_values['alert_no_existe_actividad_principal']; ?></span>
                        </div>
                    </div>
                    <?php } ?>
            </div>
    </div>
</div>

<script type="text/template" id="template_row_nueva_act">
    <tr id="id_row_$$idrow$$" data-cp="$$cp$$" data-keyrow="$$key$$">
    <td>
    <input type="radio" name="radio_curso_principal" value="$$actividadgeneralcve$$" id="radio_curso_principal" class="radio-inline m-r-sm" 
    onchange="funcion_asignar_curso_principal(this)" data-entidadtpacve=$$tacve$$ data-actividadgeneralcve=$$actividadgeneralcve$$ 
    data-actividaddocentecve=$$cvead$$ data-cp=$$cp$$ data-keyrowselect=$$key$$>
    </td>
    <td class='class_titulo'>$$titulo_tipo_actividad$$</td>
    <td>$$anio$$</td>
    <td>$$duracion$$</td>
    <td>$$fecha_inicio$$</td>
    <td>$$fecha_fin$$</td>
    <td>
    <button type="button" class="btn btn-link btn-sm" id="btn_editar_actividad_modal">Editar</button>
    </td>
    <td>
    <button type="button" class="btn btn-link btn-sm" id="btn_eliminar_actividad_modal" data-idrow="$$idrow$$" data-tacve="$$tacve$$" data-cvead="$$cvead$$" data-cp="$$cp$$" onclick="funcion_eliminar_actividad_docente(this)">
    Eliminar
    </button>
    </td>
    </tr>
</script>


<?php echo form_close(); ?>
  