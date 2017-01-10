<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo css("style-sipimss.css"); ?>

<!--<script type='text/javascript' src="<?php // echo base_url();       ?>assets/js/evaluacion_curricular/index_eva_curricular.js"></script>-->
<script>
    $('.botonF1').hover(function () {
        $('.btn').addClass('animacionVer');
    })
    $('.contenedor').mouseleave(function () {
        $('.btn').removeClass('animacionVer');
    })
</script>

<div class="panel-group" id="accordion">
    <div class="row">
        <div class="col-sm-6">
            <strong><?php echo $string_value_seccion["lbl_info_nombre"] ?></strong>
            <?php
            echo $empleado["nombre"] . " "
            . $empleado["apellidoPaterno"] . " "
            . $empleado["apellidoMaterno"]
            ?><br />
            <strong><?php echo $string_value_seccion["lbl_info_matricula"] ?></strong>
            <?php echo $empleado["matricula"] ?><br />
            <strong><?php //echo $string_value["lbl_info_categoria"]     ?></strong>
            <?php //echo $empleado["categoria_PD"] ?>
        </div>
        <!-- /.col -->
        <div class="col-sm-6 ">
            <strong><?php echo $string_value_seccion["lbl_info_del"] ?></strong>
            <?php echo $empleado["delegacion"] ?><br />
            <strong><?php echo $string_value_seccion["lbl_info_adscripcion"] ?></strong>
            <?php echo $empleado["nombreUnidadAdscripcion"] ?><br />
            <strong><?php //echo $string_value["lbl_info_vigencia"]     ?></strong>
            <?php // $empleado["vigencia"] ?>
        </div>
        <!-- /.col -->
    </div>
    <br>
    <?php
    foreach ($array_menu as $key_bloque => $value_secc) {
//        echo $key_bloque;
//        pr($value_secc);
//        if (!empty($value_secc)) {//Verifica que el bloque sea iferente de vacio
        ?>
        <script >
                    /*Guarda los datos de configuración para el uso de ajax en javascript*/
                            //            hrutes['<?php // echo $key_bloque;       ?>'] = '<?php // echo $value_tab['ruta_padre'];       ?>';
        </script>
        <div class="panel box box-success">
            <div class="box-header with-border">
                <h4 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo 'seccion_' . $key_bloque ?>" class="collapsed" aria-expanded="false">
                        <?php echo $string_values[$labels_bloque[$key_bloque]]; ?>
                    </a>
                </h4>
            </div>
            <div id="<?php echo 'seccion_' . $key_bloque ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div id="cuerpo_<?php echo $key_bloque ?>" class="box-body">
                    <?php
                    $mostrar_boton_val = false;
                    foreach ($value_secc as $key_seccion => $value_mod) {
//                            pr($value_mod);
                        if (!empty($value_mod)) {//Valida que la sección sea diferente de evacio
                            $data['datos_modulo'] = $value_mod;
                            $data['metadatos'] = $info_actividad;
                            $data['pk'] = $info_actividad[$key_bloque][$key_seccion]['pk'];
                            $data['curso'] = $info_actividad[$key_bloque][$key_seccion]['fields']["lbl_" . $key_seccion . "_nombre"];
                            $data['tipo_curso'] = $info_actividad[$key_bloque][$key_seccion]['fields']["lbl_" . $key_seccion . "_tipo"];
                            $data['tp_cve'] = $info_actividad[$key_bloque][$key_seccion]['fields']["tp_cve"];
                            $data['seccion'] = $key_seccion;
                            $data['titulo'] = $info_actividad[$key_bloque][$key_seccion]['title'];
                            $data['bloque'] = $key_bloque;
                            $data['view'] = $info_actividad[$key_bloque][$key_seccion]["functions"]["view"];
                            $data['is_post'] = $info_actividad[$key_bloque][$key_seccion]["functions"]["is_post"];
                            $data['string_values'] = $string_values;

                            echo $this->load->view('evaluacion_currucular_doc/tablas_seccion_docente/tab_gen_cursos', $data, true);
                            $mostrar_boton_val = true;
                        }
                    }

                    $data_bloque['estado_validacion_bloque'] = (isset($estado_validacion_bloque[$key_bloque])) ? $estado_validacion_bloque[$key_bloque] : array();
                    $data_bloque['string_values'] = $string_values;
//                    $data_bloque['solicitud'] = $solicitud;
                    $data_bloque['bloque'] = $key_bloque;
                    if ($mostrar_boton_val) {
                        echo $this->load->view('evaluacion_currucular_doc/tablas_seccion_docente/btn_pie_bloque', $data_bloque, true);
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
//    }
    ?>
    <br>    
    <div class="row">
        <div class="col-sm-12 text-center">
            <button id="btn_comentarios" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_censo" 
                    data-solicitudcve="<?php echo $this->seguridad->encrypt_base64($solicitud_cve) ?>"
                    onclick="ver_comentario_estado_doc(this)" >
                        <?php echo $string_values['text_btn_comentarios']; ?>
            </button>
            <?php
            //Crea los botones de validación
            if (!empty($botones_validador)) {
                foreach ($botones_validador as $value) {
                    echo $value . ' &nbsp';
                }
            }
            ?>
        </div>    
    </div>    
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 contenedor" >
        <span id="pie"  onclick="funcion_cerrar_validacion_empleado(this)">
            <a class="botonF1" data-toggle='tab' href='#select_buscador_validar_evaluacion'>><?php // echo $string_values['lbl_validar_empleado'];                      ?></a>
        </span>
    </div>
</div>